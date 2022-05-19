<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage forms
 *
 * API Form PHP Forms.
 */

	include_once SYSHOME . "/include/forms/field.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";
	include_once INC_DIR . "/forms/field_types/listbox.inc.php";


	/**
	 * List box that shows which services to display [all | not imported or pending update]
	 *
	 */
	class services_selection_view extends listbox {

		public function services_selection_view() {

			global $MESSAGES;

			parent::listbox();

			$this->lb[0]= "Show not imported or pending update";
			$this->lb[1]= "Show all";
		}

		function show($field_name, $readonly, $for_search=false) {

			parent::show($field_name, $readonly, false);
		}
	}

	class services_search_box extends search_box_ext {

		public $show_all=true;

		public function services_search_box($fields, $name, $text, $cols=1, $extensible=true) {

			parent::search_box_ext($fields, $name, $text, $cols, $extensible);

			$this->get_values();

			$dummy_value= isset($this->values["show_all"]) ? $this->values["show_all"] : 0;

			$this->show_all= $dummy_value != 0;
		}
	}


	/**
	 * Services datawindow
	 *
	 */
	class services_datawindow extends datawindow_ext {

		public $services_status=null;
		public $multiple_services_rows=null;
		public $services_row_id=null;
		protected $search_box;

		public function services_datawindow(&$discoverer_db) {

			global $MESSAGES;

			$null_ref= null;


			// public function datawindow_query (& $optional_db=null)
			$qry= new datawindow_query($discoverer_db);


			/**
			 * current_services table
			 */
			$group_reference= new foreign_key($discoverer_db,"servers","id_server","hostname");

			$fields= array();

			//function field_ext($field_name, $field_alias, $field_type, $required, $is_unique, $show_order, $updatable, $default_value=null, $reference=NULL) {
			$fields[0]=  new field_ext("current_services.id_service","","auto",false,false,0,false);
			$fields[1]=  new field_ext("current_services.id_server","Host","foreign_key",true,false,0,false,$null_ref,$group_reference);
			$fields[2]=  new field_ext("current_services.port","Port","fstring",false,false,2,false);
			$fields[2]->default_order_by="a";
			$fields[3]=  new field_ext("current_services.protocol","Proto","fstring",false,false,3,false);
			$fields[4]=  new field_ext("current_services.state","State","fstring",false,false,4,false);
			$fields[5]=  new field_ext("current_services.name","Name","fstring",false,false,5,false);
			$fields[5]->is_detail=false;
			$fields[5]->default_order_by="a";
			$fields[6]=  new field_ext("current_services.product","Product","fstring",false,false,6,false);
			$fields[7]=  new field_ext("current_services.version","Version","fstring",false,false,7,false);
			$fields[8]=  new field_ext("current_services.extrainfo","Info","fstring",false,false,8,false);
			$fields[9]=  new field_ext("current_services.ostype","OS Type","fstring",false,false,9,false);
			$fields[10]= new field_ext("current_services.fingerprint","Fingerprint","text",false,false,0,false);
			$fields[11]= new field_ext("current_services.deleted","D","fbool",false,false,10,false);
			$fields[12]= new field_ext("current_services.revision","Revision","fstring",false,false,11,false);

			//public function datawindow_table($table_name, &$fields, $field_id, $insert_allowed, $update_allowed, $delete_allowed)
			$table_services= new datawindow_table("current_services", $fields, 0, false, false, false);
			$table_services->logical_delete=false;

			// Add it to query object
			$qry->add_table($table_services);

			$fields2= array();
			$fields2[0]= new field_ext("servers.id_server","","auto",false,false,0,false);
			$fields2[1]= new field_ext("servers.hostname",$MESSAGES["ALERT_SERVER_FIELD_NAME"],"fstring",false,false,1,false);
			$fields2[1]->default_order_by="a";

			$table_servers= new datawindow_table("servers", $fields2, 0, false, false, false);
			$table_servers->logical_delete=false;

			$qry->add_table($table_servers);


			$qry->add_join($table_services, 1, $table_servers, 0);

			// Add selection view
			$selection_view= new services_selection_view();
			$field_dummy= new field_ext("show_all", "Select view", "dummy", false, false, 12, true, 0, $selection_view);

			// Search box associated
			$this->sb= new services_search_box(array(&$field_dummy, $fields2[1], $fields[1], $fields[2], $fields[4], $fields[5], $fields[6], $fields[7], $fields[8], $fields[9]),"search_discovered",$MESSAGES["SEARCH"], 2, false);
			$this->sb->set_field_default_value("show_all",0);

			// Order by...
			$qry->add_order_by_field($table_servers, 1);
			$qry->add_order_by_field($table_services, 2);
			$qry->add_order_by_field($table_services, 5);

			// Create datawindow with current query object
			parent::datawindow_ext($qry,0,"Remote services from NSDi");
			//$this->nav_enabled=false;		// Not recomendable if your NSDi manage a lot of information.
			$this->row_selection_enabled= true;
			$this->add_group_action("Import","group_import");
			$this->add_group_action("Lock","group_lock");

			$this->max_lines_per_page=100;

			// Add search box
			$this->add_search_box($this->sb);
		}

		public function pre_show_row(&$values, $can_update, $can_delete) {

			global $repository_id;
			global $USER_GROUP;


			if(!isset($repository_id)) die("Repository id not set");

			$values["__server_imported"]= is_server_imported($repository_id, $values["current_services.id_server"]) ? 1 : 0;
			if($values["__server_imported"]) {
				$values["__service_locked"]= is_service_locked($repository_id, $values["row_id"], $USER_GROUP) ? 1 : 0;
				$values["__service_status"]= check_imported_service_updates($repository_id, $values["row_id"], $values["current_services.revision"], $USER_GROUP);

				// If service is not imported and
				if(($values["__service_status"]==2) and ($values["current_services.deleted"]==1) ) {
					return false;
				}
			} else {
				$values["__service_locked"]= "";
				$values["__service_status"]= "";
			}


			if($this->sb->show_all) return true; // If show all is set, then return true
			if($values["__service_locked"]) return false; // Else, if service is locked, return false
			if($values["__service_status"]==0) return false; // Else, if service is sync, return false

			return true;		// Else return true (show row)
		}

		protected function get_row_color($EvenRow, $values) {

			if($values["current_services.deleted"]==1) return "#ffdddd";
			return parent::get_row_color($EvenRow, $values);
		}

		public function post_show_row($values) {

			global $repository_id;
			global $USER_GROUP;

			if(!isset($repository_id)) die("Repository id not set");


			if(!is_server_imported($repository_id, $values["current_services.id_server"])) {
				echo "<font color='brown'>Server not imported</font>";
				return;
			}

			if($values["current_services.deleted"]==1) {
				echo "<font color='brown'>Remote service has been deleted</font>";
				echo "<hr>";
				echo $this->create_row_action("Unlink","unlink_service",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/delete.png");
				return;
			}

			if(is_service_locked($repository_id, $values["row_id"], $USER_GROUP)) {

				echo $this->create_row_action("Unlock service","unlock_service",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/unlock.png");

			} else {

				$status= check_imported_service_updates($repository_id, $values["row_id"], $values["current_services.revision"], $USER_GROUP);

				switch($status) {
					case 0:		// Version is sync.
						echo $this->create_row_action("Unlink","unlink_service",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/delete.png");
						break;
					case 1:		// Has a minor version
						echo $this->create_row_action("Update","update_service",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/reload.png");
						break;
					default:	// Is not imported.
						echo $this->create_row_action("Import","import_service",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/import.png");
				}

				echo "<hr>";
				echo $this->create_row_action("Lock service","lock_service",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/lock.png");
			}
		}

		public function action_group_import($rows) {

			global $repository_form;


			if(!isset($repository_form)) die("Repository form not set");

			$this->multiple_services_rows= $rows;
			$this->services_status="import";

			/*
				The second step must be enabled: link remote product with a local one.
			 */
			$this->parent->parent->parent->visible= false;	// Hide tab
			$repository_form->import_multiple_services_form->visible=true;

			return 0;
		}

		public function action_group_lock($rows) {

			global $repository_form;


			if(!isset($repository_form)) die("Repository form not set");

			foreach($rows as $row_id) {
				$this->action_lock_service($row_id);
			}

			return 0;
		}

		public function action_import_service($row_id) {

			global $repository_form;

			if(!isset($repository_form)) die("Repository form not set");

			$this->services_row_id= $row_id;
			$this->services_status="import";

			/*
				The second step must be enabled: link remote product with a local one.
			 */
			$this->parent->parent->parent->visible= false;	// Hide tab
			$repository_form->import_services_form->visible=true;

			return 0;
		}

		public function action_update_service($row_id) {

			global $repository_form;

			if(!isset($repository_form)) die("Repository form not set");

			$this->services_row_id= $row_id;
			$this->services_status="update";

			/*
				The second step must be enabled: link remote product with a local one.
			 */
			$this->parent->parent->parent->visible= false;	// Hide tab
			$repository_form->import_services_form->visible=true;

			return 0;
		}

		public function action_unlink_service($row_id) {

			global $USER_GROUP;
			global $repository_id;

			if(!isset($repository_id)) die("Repository id not set");

			if(unlink_imported_service($repository_id, $row_id, $USER_GROUP)) {
				html_showSuccess("Service relationship deleted successfully.");
			} else {
				html_showError("The relationship has not been deleted.");
			}
		}

		public function action_lock_service($row_id) {

			global $repository_id;
			global $USER_GROUP;

			if(!isset($repository_id)) die("Repository id not set");

			if(lock_service($repository_id, $row_id, $USER_GROUP)) {
				html_showSuccess("Service locked");
			} else {
				html_showError("Can't lock service");
			}
		}

		public function action_unlock_service($row_id) {

			global $repository_id;
			global $USER_GROUP;

			if(!isset($repository_id)) die("Repository id not set");

			if(unlock_service($repository_id, $row_id, $USER_GROUP)) {
				html_showSuccess("Service unlocked");
			} else {
				html_showError("Can't unlock service");
			}
		}
	}
?>