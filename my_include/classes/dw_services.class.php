<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage services
 *
 * Services datawindow class
 *
 */

/*
	Table definition

	+-------------------+--------------+------+-----+---------+----------------+
	| Field             | Type         | Null | Key | Default | Extra          |
	+-------------------+--------------+------+-----+---------+----------------+
	| id_server_product | mediumint(9) |      | PRI | NULL    | auto_increment |
	| id_server         | mediumint(9) |      | MUL | 0       |                |
	| id_product        | mediumint(9) |      |     | 0       |                |
	| ports             | varchar(255) | YES  |     | NULL    |                |
	| filtered          | tinyint(4)   | YES  |     | NULL    |                |
	| critic            | tinyint(4)   | YES  |     | NULL    |                |
	| protocol          | varchar(20)  | YES  |     | NULL    |                |
	+-------------------+--------------+------+-----+---------+----------------+
*/

	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow_ext.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box_ext.inc.php";

	include_once SYSHOME . "/include/lookups/lookup.inc.php";


	class dw_service extends datawindow_ext {

		public function dw_service(&$optional_db=null) {

			global $USER_GROUP, $USER_LEVEL, $global_db, $MESSAGES;

			// Datawindow Query
			$qry= new datawindow_query();


			/**
			 * Services table
			 */
			$restriction= $USER_LEVEL > 0 ? "servers.id_group='$USER_GROUP'":""; // See below...
			$server_reference= new foreign_key($global_db,"servers","id_server","name", $global_db->dbms_query_append($restriction, "deleted='0'"));
			$product_reference=new foreign_key($global_db,"products","id_product","full_name","",HOME . "/my_include/lookups/lookup_products.php");

			// Fields
			$fields= array();
			$fields[0]= new field_ext("server_products.id_server_product","","auto",false,true,0,false);
			$fields[1]= new field_ext("server_products.id_server",$MESSAGES["SERVER_PRODUCT_FIELD_SERVER_NAME"],"foreign_key", true, false, 1, true, null, $server_reference);
			$fields[2]= new field_ext("server_products.id_product",$MESSAGES["PRODUCT_ID_FIELD_NAME"],"field_lookup", true, false, 2, true, null, $product_reference);
			$fields[3]= new field_ext("server_products.filtered",$MESSAGES["SERVER_PRODUCTS_FIELD_FILTERED"],"bool", true, false, 3, true);
			$fields[4]= new field_ext("server_products.critic",$MESSAGES["SERVER_PRODUCTS_FIELD_CRITIC"],"bool", true, false, 4, true);
			$fields[5]= new field_ext("server_products.ports",$MESSAGES["SERVER_PRODUCTS_FIELD_PORTS"],"string", false, false, 5, true);
			$fields[6]= new field_ext("server_products.protocol",$MESSAGES["SERVER_PRODUCTS_FIELD_PROTOCOL"],"string", false, false, 6, true);

			$table_server_products= new datawindow_table("server_products", $fields, 0, true, true, true);
			$table_server_products->logical_delete= true;

			$qry->add_table($table_server_products);


			/**
			 * Servers table
			 */
			$fields2= array();
			$fields2[0]= new field_ext("servers.id_server","","auto",false,false,0,false);
			$fields2[1]= new field_ext("servers.name",$MESSAGES["SERVER_PRODUCT_FIELD_SERVER_NAME"],"string",false,false,0,false);
			$fields2[2]= new field_ext("servers.id_group","","string",false,false,0,false);

			$fields2[1]->default_order_by="a";
			$fields2[1]->hide_on_update= true;

			$table_servers= new datawindow_table("servers", $fields2, 0, false, false, false);

			if($USER_LEVEL > 0) {
				$table_servers->add_restriction(2,"='$USER_GROUP'");
			}

			$qry->add_table($table_servers);


			/**
			 * Products table
			 */
			$fields3= array();
			$fields3[0]= new field_ext("products.id_product","","auto",false,false,0,false);
			$fields3[1]= new field_ext("products.full_name",$MESSAGES["PRODUCT_ID_FIELD_NAME"],"string",false,false,0,false);

			$fields3[1]->default_order_by= "a";
			$fields3[1]->hide_on_update= true;

			$table_products= new datawindow_table("products", $fields3, 0, false, false, false);
			$qry->add_table($table_products);


			/**
			 * Configure query object
			 */
			$qry->add_join($table_server_products,1,$table_servers,0);
			$qry->add_join($table_server_products,2,$table_products,0);

			$qry->add_order_by_field($table_servers, 1);
			$qry->add_order_by_field($table_products, 1);


			$sb= new search_box_ext(array($fields[1], $fields[2], $fields[3], $fields[4], $fields[5], $fields[6]),"search_server_services",$MESSAGES["SEARCH"],2,false);


  			$master_value= get_http_param("detail_id_server");
			// Patch due to master connect from servers tab
			if($master_value != null) {
				$sb->set_extensible(false);
				$sb->set_field_default_value("server_products.id_server", $master_value);
			}


			parent::datawindow_ext($qry);

			$this->add_search_box($sb);
		}

		protected function post_update($row_id, $old_values, $new_values) {

			global $global_db;
			global $MESSAGES;

			// If new product is not the old product, the alerts referencing this product on this server
			// must be closed.

			// If the new product is the same than the older, then exit without action...
			if($new_values["server_products.id_product"] == $old_values["server_products.id_product"]) {
				return 1;
			}

			// Product has been changed. Get all alerts associated with this server and close them.
			$query="select id_alert, observations from alerts where id_server='" . $old_values["servers.id_server"] . "' and id_product='" . $old_values["products.id_product"] . "'";

			if(!$res= $global_db->dbms_query($query)) {
				return 1;
			}

			while (list($id_alert, $observations) = $global_db->dbms_fetch_row($res)) {
				$observations .= "\n" . $MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"];
				$observations= $global_db->dbms_escape_string($observations);

				$query= "update alerts set status=2, observations='$observations' where id_alert='$id_alert'";
				if($global_db->dbms_query($query)) {
					html_showInfo("Alert id: $id_alert," . $MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"] . "<br>");
				} else {
					echo $global_db->dbms_error() . "<br>";
					return 0;
				}
			}

			$global_db->dbms_free_result($res);

			return 1;
		}

		function post_delete($row_id, $old_values) {
			global $global_db;
			global $MESSAGES;


			// Close all alerts referencing this product and this server
			$query="select id_alert, observations from alerts where id_server='" . $old_values["servers.id_server"] . "' and id_product='" . $old_values["products.id_product"] . "'";
			$res= $global_db->dbms_query($query);

			if(!$global_db->dbms_check_result($res)) {		// There are not alerts for this product on this server.
				html_showInfo("No alerts associated.<br>");
			} else {
				html_showInfo("Deleting alerts associated... <br>");

				while (list($id_alert, $observations) = $global_db->dbms_fetch_row($res)) {

					$observations .= "\n" . $MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"];
					$observations= $global_db->dbms_escape_string($observations);

					$query= "update alerts set status=2, observations='$observations' where id_alert='$id_alert'";
					// echo $query . "<br>";
					if($global_db->dbms_query($query)) {
						html_showInfo("Alert id: $id_alert," . $MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"] . "<br>");
					} else {
						echo $global_db->dbms_error() . "<br>";
						return 0;
					}
				}
				html_showInfo("Deleted.<br>");
			}

			$global_db->dbms_free_result($res);

			html_showInfo("Deleting relationships with imported services... ");
			$query="delete from imported_services where local_id_service = '$row_id'";
			$res= $global_db->dbms_query($query);

			if($res === false) {
				html_showInfo("Error! Product will not be deleted.<br>");
				return false;
			} else {
				html_showInfo("Deleted.<br>");
			}

			return 1;
		}
	}
?>