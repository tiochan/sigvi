<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage alerts
 *
 * Alert datawindow definition class
 *
 */

/*
	Table definition

	+----------------------+--------------+------+-----+---------------------+----------------+
	| Field                | Type         | Null | Key | Default             | Extra          |
	+----------------------+--------------+------+-----+---------------------+----------------+
	| id_alert             | mediumint(9) | NO   | PRI | NULL                | auto_increment |
	| id_server            | mediumint(9) | NO   | MUL | 0                   |                |
	| id_product           | mediumint(9) | NO   |     | 0                   |                |
	| vuln_id              | varchar(50)  | NO   |     | 0                   |                |
	| creation_date        | timestamp    | NO   |     | CURRENT_TIMESTAMP   |                |
	| closing_date         | timestamp    | NO   |     | 0000-00-00 00:00:00 |                |
	| status               | tinyint(4)   | YES  |     | NULL                |                |
	| final_alert_severity | tinyint(4)   | YES  |     | NULL                |                |
	| observations         | text         | YES  |     | NULL                |                |
	| vuln_modified        | tinyint(4)   | YES  |     | NULL                |                |
	| deleted              | tinyint(1)   | YES  |     | 0                   |                |
	| time_of_resolution   | decimal(4,2) | YES  |     | NULL                |                |
	+----------------------+--------------+------+-----+---------------------+----------------+
*/

	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/field.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once INC_DIR . "/forms/form_elements/field_box.inc.php";
	include_once INC_DIR . "/forms/form_elements/label.inc.php";

	include_once INC_DIR . "/forms/form_elements/datawindow_ext.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box_ext.inc.php";

	include_once MY_INC_DIR . "/classes/vulnerability.class.php";


	/**
	 * List box of available alert status
	 *
	 */
	class alert_status extends listbox {

		public function alert_status() {

			global $MESSAGES;

			parent::listbox();

			$this->lb["0"]= $MESSAGES["ALERT_STATUS_VALIDATED"] . ", " . $MESSAGES["ALERT_STATUS_NOT_SENT"];
			$this->lb["1"]=$MESSAGES["ALERT_STATUS_OPEN"];
			$this->lb["2"]=$MESSAGES["ALERT_STATUS_CLOSE"];
			$this->lb["3"]=$MESSAGES["ALERT_STATUS_PENDING"];
			$this->lb["4"]=$MESSAGES["ALERT_STATUS_DISCARDED"];
//			$this->lb["5"]=$MESSAGES["ALERT_STATUS_DUDE"];
		}

		function show($field_name, $readonly, $for_search=false) {

			if(!$readonly and !$for_search) unset($this->lb[0]);

			return parent::show($field_name, $readonly, $for_search);
		}
	}

	/**
	 * List box of available alert status on validation
	 *
	 */
	class alert_status_validate extends listbox {

		public function alert_status_validate() {

			global $MESSAGES;

			parent::listbox();

			$this->lb["0"]=$MESSAGES["ALERT_STATUS_VALIDATED"];
			$this->lb["4"]=$MESSAGES["ALERT_STATUS_DISCARDED"];
			$this->lb["5"]=$MESSAGES["ALERT_STATUS_DUDE"];
		}
	}

	/**
	 * List box that shows which alerts to display [all | opened]
	 *
	 */
	class alert_selection_view extends listbox {

		public function alert_selection_view() {

			global $MESSAGES;

			parent::listbox();

			$this->lb[0]= $MESSAGES["ALERT_SELECT_VIEW_OPENED"];
			$this->lb[1]= $MESSAGES["ALERT_SELECT_VIEW_ALL"];
		}

		function show($field_name, $readonly, $for_search=false) {

			parent::show($field_name, $readonly, false);
		}
	}

	class alerts_search_box extends search_box_ext {

		public function get_restriction() {

			global $global_db;

			parent::get_restriction();

			$dummy_value= isset($this->values["show_all"]) ? $this->values["show_all"] : 0;

			if($dummy_value==0) {
				$this->restriction= $global_db->dbms_query_append($this->restriction,"(alerts.status=0 or alerts.status=1 or alerts.status=3)");
			}

			return $this->restriction;
		}
	}

	/**
	 * Datawindow for alert management
	 *
	 */
	class dw_alert extends datawindow_ext {

		public $to_validate;


		public function dw_alert($to_validate=false, &$optional_db=null) {

			global $USER_GROUP, $USER_LEVEL, $USER_ID, $MESSAGES, $global_db;

			$this->to_validate= $to_validate;

			if($to_validate) {
				$status= new alert_status_validate();
			} else {
				$status= new alert_status();
			}

			// Datawindow Query
			$qry= new datawindow_query($optional_db);


			// ALERTS

			$fields= Array();

			$restriction= $USER_LEVEL!=0 ? "servers.id_group=$USER_GROUP and servers.deleted='0'" : "servers.deleted='0'";
			$server_reference= new foreign_key($global_db,"servers","id_server","name", $restriction);

			if($USER_LEVEL > 0) {
				if($USER_LEVEL == 3) {
					$restriction= "users.id_group='$USER_GROUP'";
				} else {
					$restriction= "users.id_user='$USER_ID'";
				}
			} else {
				$restriction="";
			}


			$users_reference= new foreign_key($global_db,"users","id_user","username", $restriction);

			$product_reference= new foreign_key($global_db,"products", "id_product","full_name","", HOME . "/my_include/lookups/lookup_products.php");
			$vuln_reference= new foreign_key($global_db,"vulnerabilities","vuln_id","vuln_id","","vulnerabilities.php");

			$null_ref=null;

			$fields[0]= new field_ext("alerts.id_alert","","auto",false,true,0,false);
			$fields[1]= new field_ext("alerts.id_server",$MESSAGES["ALERT_SERVER_FIELD_NAME"],"foreign_key",true,false,0,false,$null_ref,$server_reference);
			$fields[2]= new master_field_ext("products.php","products.id_product",$null_ref,"alerts.id_product",$MESSAGES["ALERT_PRODUCT_FIELD_NAME"],"foreign_key",true,false,2,false,null,$product_reference);
			$fields[3]= new master_field_ext("vuln_detail.php","vuln_id",$null_ref,"alerts.vuln_id",$MESSAGES["ALERT_VULN_FIELD_VULN_ID"],"foreign_key",true,false,3,false,null,$vuln_reference);
			// $fields[4]= new field_ext("alerts.creation_date",$MESSAGES["ALERT_FIELD_DATE"],"date",true,false,4,false);
			$fields[4]= new field_ext("alerts.creation_date",$MESSAGES["ALERT_FIELD_DATE"],"date",true,false,4,true);
			$fields[5]= new field_ext("alerts.status",$MESSAGES["ALERT_FIELD_STATUS"],"listbox", true,false,5,true,null,$status);
			$fields[6]= new field_ext("alerts.final_alert_severity",$MESSAGES["ALERT_FIELD_SEVERITY"],"integer", true,false,6,false);
			$fields[7]= new field_ext("alerts.observations",$MESSAGES["ALERT_FIELD_OBSERVATIONS"],"text", false,false,7,true);
//			$fields[8]= new field_ext("alerts.vuln_modified",$MESSAGES["ALERT_FIELD_VULN_MODIFIED"],"bool", false,false,true,false);
			$fields[8]= new field_ext("alerts.time_of_resolution",$MESSAGES["ALERT_FIELD_TIME_RESOLUTION"],"time",false,false,8,true);
			$fields[9]= new field_ext("alerts.id_user",$MESSAGES["ALERT_ASSIGNED_TO"],"foreign_key",false,false,9,true,$null_ref,$users_reference);
			$fields[10]=new field_ext("alerts.closing_date","","date",false,false,0,true);

			$fields[2]->new_window=true;
			$fields[3]->new_window=true;

			$fields[4]->hide_on_update=true;
			$fields[6]->hide_on_update=true;
			$fields[10]->hide_on_update=true;

			$fields[4]->default_order_by="d";
			$fields[6]->default_order_by="d";

			if($to_validate) {
				$can_create= false;
				$can_modify= ($USER_LEVEL <= 3);
				$can_delete= false;
			} else {
				$can_create= false;
				$can_modify= ($USER_LEVEL <= 5);
				$can_delete= ($USER_LEVEL <= 3);
			}


			// Creation of table and add it to query
			$table_alerts= new datawindow_table("alerts", $fields, 0, $can_create, $can_modify, $can_delete);
			$table_alerts->logical_delete=true;

			if($to_validate) {
				$table_alerts->add_restriction(5,"=5");
			} else {
				$table_alerts->add_restriction(5,"!=5");
				if($USER_LEVEL == 5) {
					$table_alerts->add_custom_restriction("((alerts.id_user is null) or (alerts.id_user='$USER_ID'))");
				}
			}

			$qry->add_table($table_alerts);


			// SERVERS

			$fields2= array();
			$fields2[0]= new field_ext("servers.id_server","","auto",false,false,0,false);
			$fields2[1]= new field_ext("servers.name",$MESSAGES["ALERT_SERVER_FIELD_NAME"],"string",false,false,1,false);
			$fields2[1]->default_order_by="a";

			$table_servers= new datawindow_table("servers", $fields2, 0, false, false, false);
			$table_servers->logical_delete=true;

			$qry->add_table($table_servers);
			if($USER_LEVEL != 0) {
				$table_servers->add_custom_restriction("servers.id_group=$USER_GROUP and servers.deleted='0'");
			} else {
				$table_servers->add_custom_restriction("servers.deleted='0'");
			}

			if($to_validate) {
				$sb_fields= array(&$fields[1], &$fields[2], &$fields[3]);
				$sb= new search_box_ext($sb_fields, "sb_search_validation1", $MESSAGES["SEARCH"],1, false);
			} else {
				$selection_view= new alert_selection_view();
				$field_dummy= new field_ext("show_all", $MESSAGES["ALERT_SELECT_VIEW_TITLE"], "dummy", false, false, 9, true, 0, $selection_view);
				$sb_fields= array(&$field_dummy, &$fields[1], &$fields[2], &$fields[3]);
				$sb= new alerts_search_box($sb_fields, "sb_search_alerts", $MESSAGES["SEARCH"],1, false);
			}

			// QUERY
			$qry->add_join($table_alerts, 1, $table_servers, 0);
			$qry->add_order_by_field($table_servers, 1);
			$qry->add_order_by_field($table_alerts, 6);
			$qry->add_order_by_field($table_alerts, 4);


			parent::datawindow_ext($qry);

			$this->row_selection_enabled= true;
			if($to_validate) {
				$this->add_group_action($MESSAGES["ALERT_STATUS_VALIDATED"],"group_change_not_sent");
				$this->add_group_action($MESSAGES["ALERT_STATUS_DISCARDED"],"group_change_discarded");
				$this->add_group_action($MESSAGES["ALERT_STATUS_DUDE"],"group_change_doubt");
			} else {
			//	$this->add_group_action($MESSAGES["ALERT_STATUS_NOT_SENT"],"group_change_not_sent");
				$this->add_group_action($MESSAGES["ALERT_STATUS_OPEN"],"group_change_open");
				$this->add_group_action($MESSAGES["ALERT_STATUS_CLOSE"],"group_change_close");
				$this->add_group_action($MESSAGES["ALERT_STATUS_PENDING"],"group_change_pending");
				$this->add_group_action($MESSAGES["ALERT_STATUS_DISCARDED"],"group_change_discarded");
			//	$this->add_group_action($MESSAGES["ALERT_STATUS_DUDE"],"group_change_doubt");
			}

			$this->max_lines_per_page=50;
			$this->add_search_box($sb);
			$this->export_allowed= true;
		}

/*		protected function post_delete($row_id, $values) {

			global $global_db;

			$query="update alerts set closing_date=" . $global_db->dbms_get_current_timestamp_query() . " where id_alert='$row_id'";
			$global_db->dbms_query($query);

			return 1;
		}
*/
		protected function pre_update($row_id, $old_values, &$new_values) {

			global $global_db;

			// If the alert is changed to closed or discarded status, update closing date field.
			if(($new_values["alerts.status"] == 2) or ($new_values["alerts.status"] == 4)) {
				$new_values["alerts.closing_date"]= $global_db->dbms_get_current_timestamp_query();
			} else {
				unset($new_values["alerts.closing_date"]);
			}

			return 1;
		}

		protected function action_group_change_not_sent($rows) {
			foreach($rows as $row_id) {
				$this->change_status($row_id, 0);
			}
		}

		protected function action_group_change_open($rows) {
			foreach($rows as $row_id) {
				$this->change_status($row_id, 1);
			}
		}

		protected function action_group_change_close($rows) {
			foreach($rows as $row_id) {
				$this->change_status($row_id, 2);
			}
		}

		protected function action_group_change_pending($rows) {
			foreach($rows as $row_id) {
				$this->change_status($row_id, 3);
			}
		}

		protected function action_group_change_discarded($rows) {
			foreach($rows as $row_id) {
				$this->change_status($row_id, 4);
			}
		}

		protected function action_group_change_doubt($rows) {
			foreach($rows as $row_id) {
				$this->change_status($row_id, 5);
			}
		}

		private function change_status($row_id, $status) {

			global $global_db;

			if(($status == 2) or ($status == 4)) {
				$add= ", closing_date=" . $global_db->dbms_get_current_timestamp_query();
			} else {
				$add="";
			}

			$query="update alerts set status='$status' $add where id_alert='$row_id'";

			$global_db->dbms_query($query);
		}

		protected function get_cell_color($field, $value) {
			if($field->name == "alerts.final_alert_severity") {
				return fas_get_color($value);
			}
			return "";
		}
	}
?>
