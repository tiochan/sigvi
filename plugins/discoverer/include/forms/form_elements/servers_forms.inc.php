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

	include_once SYSHOME . "/conf/discover.conf.php";

	include_once SYSHOME . "/include/forms/field.inc.php";
	include_once INC_DIR . "/forms/form_elements.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once INC_DIR . "/forms/form_elements/label.inc.php";

	include_once DISCOVERER_DIR . "/classes/dw_repository_servers.inc.php";



	class import_all_servers_button extends button {

		public function clicked () {

			global $discover_repository;
			global $repository_id;
			global $global_db;
			global $USER_GROUP;
			global $USER_GROUP_NAME;

			if(!isset($discover_repository)) die("Discover repository not set");
			if(!isset($repository_id)) die("Repository id not set");

			/**
			 * TODO: change this 1000 for the total number of servers.
			 */
			$row_id=0;

			for($j=0; $row_id<1000; $row_id++) {

				if(($server= $discover_repository->get_server($row_id)) == null) {
					//html_showError("Server not found on repository<br>");
					continue;
				}

				if(import_server($repository_id, $server, $USER_GROUP)) {
					html_showSuccess("Server " . $server->hostname . " imported successfully to group $USER_GROUP_NAME");
				} else {
					html_showError("The server has not been imported.");
				}
			}
			return 0;
		}
	}


	/**
	 * Subform to host servers datawindow
	 *
	 */
	class servers_subform extends sub_form {

		public $fields_s;
		public $datawindow_servers;
		public $search_box;

		public function servers_subform($name, $title) {

			global $discover_repository;
			global $MESSAGES;


			if(!isset($discover_repository)) die("Discover repository not set");


			parent::sub_form($name, $title);

			$btn= new import_all_servers_button("import_all_servers_button", "Import all servers");
			$this->add_element($btn);


			$this->fields_s= Array();

			/* DATAWINDOW FOR SERVERS */
			$this->fields_s[]= new field("id_server","","auto",false,true,false,false);
			$this->fields_s[]= new field("hostname",$MESSAGES["SERVER_FIELD_NAME"],"string",true,true,true,true);
			$this->fields_s[]= new field("ip",$MESSAGES["SERVER_FIELD_IP"],"string", false, false, true,true);
			$this->fields_s[1]->is_detail=false;

			$this->search_box= new search_box(array($this->fields_s[1], $this->fields_s[2]), "search_servers", $MESSAGES["SEARCH"]);

			$this->datawindow_servers= new servers_datawindow("servers", $this->fields_s, 0, "", "order by hostname", false, false, false, $discover_repository->discover_db);
			$this->datawindow_servers->add_search_box($this->search_box);
			$this->datawindow_servers->export_allowed= true;

			$this->add_element($this->datawindow_servers);
		}
	}
?>