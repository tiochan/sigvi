<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage servers
 *
 * Server datawindow class
 *
 */

/*
	Table definition

	+---------------+--------------+------+-----+---------+----------------+
	| Field         | Type         | Null | Key | Default | Extra          |
	+---------------+--------------+------+-----+---------+----------------+
	| id_server     | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| name          | varchar(30)  | NO   | UNI |         |                |
	| repository    | mediumint(9) | YES  |     | NULL    |                |
	| vendor        | varchar(60)  | YES  |     | NULL    |                |
	| model         | varchar(60)  | YES  |     | NULL    |                |
	| cpu           | varchar(60)  | YES  |     | NULL    |                |
	| ram           | varchar(30)  | YES  |     | NULL    |                |
	| disc          | varchar(60)  | YES  |     | NULL    |                |
	| serial_number | varchar(60)  | YES  |     | NULL    |                |
	| os            | varchar(60)  | YES  |     | NULL    |                |
	| id_group      | int(11)      | YES  |     | NULL    |                |
	| location      | varchar(60)  | YES  |     | NULL    |                |
	| IP            | varchar(60)  | YES  |     | NULL    |                |
	| zone          | varchar(60)  | YES  |     | NULL    |                |
	| observations  | text         | YES  |     | NULL    |                |
	| id_filter     | mediumint(9) | YES  |     | NULL    |                |
	+---------------+--------------+------+-----+---------+----------------+

*/

	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow_ext.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box_ext.inc.php";


	class dw_server extends datawindow_ext {

		public function dw_server(&$optional_db=null) {

			global $USER_GROUP, $USER_LEVEL, $global_db, $MESSAGES;


			$qry= new datawindow_query();


			$restriction= $USER_LEVEL == 0 ? "" : "(id_group=$USER_GROUP or id_group is null)";
			$filter_reference= new foreign_key($global_db,"filters","id_filter","name", $restriction,"");

			$restriction= $USER_LEVEL!=0 ? "id_group=$USER_GROUP" : "";
			$group_reference= new foreign_key($global_db,"groups","id_group","name", $restriction);

			$restriction= $USER_LEVEL == 0 ? "" : "(id_group=$USER_GROUP or id_group is null)";
			$repository_reference= new foreign_key($global_db,"repository","id_repository","name", $restriction);

			$null_ref=null;

			$fields= array();
			// field($field_name, $field_alias, $field_type, $required, $is_unique, $visible, $updatable, $default_value=null, $reference=NULL)

			$fields[0]=  new field_ext("servers.id_server","","auto",false,true,0,false);
			$fields[0]->is_detail=false;
			$fields[1]=  new master_field_ext("servers_and_services.php","server_products.id_server",$fields[0],"servers.name",$MESSAGES["SERVER_FIELD_NAME"],"string",true,true,1,true);
			$fields[1]->add_parameter("tab_1_tab_selected=tab_services");
			$fields[1]->default_order_by= "a";
			$fields[2]=  new field_ext("servers.vendor",$MESSAGES["SERVER_FIELD_VENDOR"],"string", false, false, 2, true);
			$fields[3]=  new field_ext("servers.model",$MESSAGES["SERVER_FIELD_MODEL"],"string", false, false, 3,true);
			$fields[4]=  new field_ext("servers.cpu",$MESSAGES["SERVER_FIELD_CPU"],"string", false, false, 4,true);
			$fields[5]=  new field_ext("servers.ram",$MESSAGES["SERVER_FIELD_RAM"],"string", false, false, 5,true);
			$fields[6]=  new field_ext("servers.disc",$MESSAGES["SERVER_FIELD_DISC"],"string", false, false, 6,true);
			$fields[7]=  new field_ext("servers.serial_number",$MESSAGES["SERVER_FIELD_SERIAL_NUMBER"],"string", false, false, 7,true);
			$fields[8]=  new field_ext("servers.os",$MESSAGES["SERVER_FIELD_OS"],"string", false, false, 8,true);
			$fields[9]=  new field_ext("servers.id_group",$MESSAGES["SERVER_FIELD_GROUP"],"foreign_key", true, false, 9,($USER_LEVEL == 0), $USER_GROUP, $group_reference);
			$fields[9]->default_order_by= "a";
			$fields[10]= new field_ext("servers.location",$MESSAGES["SERVER_FIELD_LOCATION"],"string", false, false, 10,true);
			$fields[11]= new field_ext("servers.IP",$MESSAGES["SERVER_FIELD_IP"],"string", false, false, 11,true);
			$fields[11]->default_order_by= "a";
			$fields[12]= new field_ext("servers.zone",$MESSAGES["SERVER_FIELD_ZONE"],"string", false, false, 12,true);
			$fields[13]= new field_ext("servers.observations",$MESSAGES["SERVER_FIELD_OBSERVATIONS"],"string", false, false, 13,true);
			$fields[14]= new field_ext("servers.id_filter",$MESSAGES["FILTER_CHECK"],"foreign_key",false,false,14,true,null,$filter_reference);

			$sb= new search_box_ext(array($fields[1], $fields[8], $fields[9], $fields[11]),"search_servers",$MESSAGES["SEARCH"]);

			$can_insert= true;
			$can_update= true;
			$can_delete= true;  //$can_delete= ($USER_LEVEL <= 3);
			$table_servers= new datawindow_table("servers", $fields, 0, $can_insert, $can_update, $can_delete);

			if($USER_LEVEL != 0) {
				$table_servers->add_restriction(9, " ='$USER_GROUP'");
			}

			if(strtoupper(SERVER_DELETE_RESTRICTION) == "LOGICAL") $table_servers->logical_delete=true;

			$qry->add_table($table_servers);
			$qry->add_order_by_field($table_servers, 1);
			$qry->add_order_by_field($table_servers, 9);
			$qry->add_order_by_field($table_servers, 11);

			parent::datawindow_ext($qry);
			$this->add_search_box($sb);
		}

		public function pre_insert(&$values) {

			global $USER_LEVEL;
			global $USER_GROUP;

			if($USER_LEVEL != 0) $values["servers.id_group"]= $USER_GROUP;
			return 1;
		}

		public function pre_update($row_id, $old_values, &$new_values) {
			global $USER_NAME;
			global $USER_GROUP;
			global $USER_LEVEL;
			global $USER_ID;
			global $MESSAGES;
			global $global_db;

			if($USER_LEVEL == 0)
				return 1;

			// Only sigvi admin can change group
			$new_values["servers.id_group"]= $old_values["servers.id_group"];
			return 1;
		}

		protected function pre_delete($server_id, $values) {

			global $MESSAGES;
			global $global_db;
			global $USER_LEVEL;

/*			if($USER_LEVEL > 3) {
				html_showError($MESSAGES["SERVER_MGM_CANT_DELETE"]);
				return 0;
			}*/

			// Has this server any product associated?
			//
			switch(strtoupper(SERVER_DELETE_RESTRICTION)) {
				case "CASCADE":

					// Will be done on post-delete
					break;
				case "RESTRICT":
					// Option 2: restrict delete

					$query="select * from server_products where id_server=$server_id";
					$res=$global_db->dbms_query($query);

					if($global_db->dbms_check_result($res)) {
						$global_db->dbms_free_result($res);
						html_showError($MESSAGES["SERVER_MGM_STILL_HAS_PRODUCTS"]);
						return 0;
					}
			}

			return 1;
		}

		protected function post_delete($server_id, $values) {

			global $global_db;
			global $MESSAGES;

			switch(strtoupper(SERVER_DELETE_RESTRICTION)) {

				case "CASCADE":
					// Option 1: delete on cascade
					$query="delete from server_products where id_server=$server_id";
					if(! $global_db->dbms_query($query)) {
						html_showError("Error: couldn't delete associated products");
						return 0;
					} else {
						html_showInfo("Deleted products associations.");
					}

					$observations = addslashes("\n" . $MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"]);
					$query= "update alerts set status=2, observations='$observations' where id_server='$server_id'";
					if(! $global_db->dbms_query($query)) {
						html_showError("Error: couldn't close associated alerts.");
						return 0;
					} else {
						html_showInfo("Closed open alerts for this server.");
					}
					break;

				case "RESTRICT":
					break;

				case "LOGICAL":

					// Option 1: delete on cascade
					$query="update server_products set deleted='1' where id_server=$server_id";
					if(! $global_db->dbms_query($query)) {
						html_showError("Error: couldn't delete associated products.");
						return 0;
					} else {
						html_showInfo("Marked associated products as deleted.");
					}

					$observations = addslashes("\n" . $MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"]);
					$query= "update alerts set status=2, observations='$observations' where id_server='$server_id'";
					if(! $global_db->dbms_query($query)) {
						html_showError("Error: couldn't close associated alerts.");
						return 0;
					} else {
						html_showInfo("Closed open alerts for this server.");
					}

					break;
			}

			$query="delete from imported_servers where local_id_server='$server_id'";
			$res=$global_db->dbms_query($query);

			if($res === false) {
				html_showInfo("Error! Can't be deleted.");
				return false;
			} else {
				html_showInfo("Deleted relationships with imported servers.");
			}

			return true;
		}
	}
?>
