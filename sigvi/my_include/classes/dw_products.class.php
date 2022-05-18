<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage services
 *
 * Products datawindow class
 *
 */


	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow_ext.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box_ext.inc.php";

	/**
	 * Datawindow extension for products
	 *
	 */
	class dw_product extends datawindow_ext {

		public function dw_product(&$optional_db=null) {
			global $USER_LEVEL, $MESSAGES;

			$qry= new datawindow_query();



			$get_search= get_http_param("search_full_name","");

			$fields= array();
			$fields[0]= new field_ext("products.id_product","id","auto",false,true,1,false);
			$fields[1]= new field_ext("products.vendor",$MESSAGES["PRODUCT_FIELD_VENDOR"],"string",true,false,2,true);
			$fields[1]->default_order_by= "a";
			$fields[2]= new field_ext("products.name",$MESSAGES["PRODUCT_FIELD_NAME"],"string",true,false,3,true);
			$fields[2]->default_order_by= "a";
			$fields[3]= new field_ext("products.version",$MESSAGES["PRODUCT_FIELD_VERSION"],"string",true,false,4,true);
			$fields[3]->default_order_by= "a";
			$fields[4]= new field_ext("products.full_name",$MESSAGES["PRODUCT_FIELD_FULL"],"hidden",false,false,0,true);

			$can_create= ($USER_LEVEL <= 5);				// Each admin can do it
			$can_modify= ($USER_LEVEL==0);					// Only sigvi admin can do it
			$can_delete= ($USER_LEVEL==0);					// Only sigvi admin can do it

			$table_products= new datawindow_table("products",$fields,0,$can_create, $can_modify, $can_delete);

			$qry->add_table($table_products);
			$qry->add_order_by_field($table_products,1);
			$qry->add_order_by_field($table_products,2);
			$qry->add_order_by_field($table_products,3);

			$sb= new search_box_ext(array($fields[0], $fields[1], $fields[2], $fields[3], $fields[4]), "sb_search", $MESSAGES["SEARCH"],1,($get_search==""));

			if($get_search!="") $sb->set_field_value("products.full_name",$get_search);

			parent::datawindow_ext($qry,600);
			$this->add_search_box($sb);
		}

		public function post_show_row($values) {

			global $repository_id;

			$product_name= $values["products.full_name"];
			$product_name= str_replace(", ", ",%", $product_name);
			$link= HOME . "/admin/vulnerabilities.php?search_vuln_software=%$product_name%&find_software=yes";
			echo $this->create_row_redirection("View vulnerabilities for this software",$link,ICONS . "/bug.png");
		}

		function pre_insert(&$values) {
			$values["products.full_name"]= $values["products.vendor"] . ", " . $values["products.name"] . ", " . $values["products.version"];
			return 1;
		}

		function pre_update($row_id, $old_values, &$new_values) {
			$new_values["products.full_name"]= $new_values["products.vendor"] . ", " . $new_values["products.name"] . ", " . $new_values["products.version"];
			return 1;
		}

		function post_insert($values) {
			global $global_db;
			global $MESSAGES;

			$query="select id_product from products where vendor='" . $values["products.vendor"] . "' and name='" . $values["products.name"] . "' and version='" . $values["products.version"] . "'";
			$res= $global_db->dbms_query($query);
			if(!$res) {
				html_showError("ERROR::f_post_new, product not found!");
				return 0;
			}
			list($id)= $global_db->dbms_fetch_row($res);
			html_showInfo($MESSAGES["PRODUCT_FIELD_ID"] . ": $id<br>");
			return 1;
		}

		function pre_delete($product_id, $values) {

			global $MESSAGES;
			global $global_db;

			// Has this product any server associated?
			$query="select * from server_products where id_product=$product_id";
			$res=$global_db->dbms_query($query);

			if($global_db->dbms_check_result($res)) {
				$global_db->dbms_free_result($res);
				html_showError($MESSAGES["PRODUCT_MGM_STILL_HAS_SERVERS"]);
				return 0;
			}
			return 1;
		}
	}


	class dw_product_cpe_ext extends datawindow_ext {

		public function dw_product_cpe_ext(&$optional_db=null) {

			global $USER_LEVEL, $MESSAGES, $null_ref;

			// Datawindow Query
			$qry= new datawindow_query();


			$get_search= get_http_param("search_full_name","");

			$parts= new listbox();
			$parts->lb["a"]= $MESSAGES["CPE_FIELD_PART_APPLICATION"];
			$parts->lb["h"]= $MESSAGES["CPE_FIELD_PART_HARDWARE"];
			$parts->lb["o"]= $MESSAGES["CPE_FIELD_PART_OS"];


			$fields= array();
			$fields[]= new field_ext("cpe_products.id_product","id","auto",false,true,0,false);
			$fields[]= new field_ext("cpe_products.name",$MESSAGES["CPE_FIELD_NAME"],"string",true,false,0,false);
			$fields[]= new field_ext("cpe_products.part",$MESSAGES["CPE_FIELD_PART"],"listbox",true,false,1,true,$null_ref,$parts);
			$fields[]= new field_ext("cpe_products.vendor",$MESSAGES["CPE_FIELD_VENDOR"],"string",true,false,2,true);
			$fields[]= new field_ext("cpe_products.product",$MESSAGES["CPE_FIELD_PRODUCT"],"string",true,false,3,true);
			$fields[]= new field_ext("cpe_products.version",$MESSAGES["CPE_FIELD_VERSION"],"string",true,false,4,true);
			$fields[]= new field_ext("cpe_products.title",$MESSAGES["CPE_FIELD_TITLE"],"string",true,false,5,true);
			$fields[]= new field_ext("cpe_products.modification_date",$MESSAGES["CPE_FIELD_MODIFICATION_DATE"],"date",true,false,6,true);
			$fields[]= new field_ext("cpe_products.status",$MESSAGES["CPE_FIELD_STATUS"],"string",true,false,7,true);
			$fields[]= new field_ext("cpe_products.nvd_id",$MESSAGES["CPE_FIELD_NVD_ID"],"string",true,false,8,true);

			$can_create= $can_delete= $can_modify= false;


			$sb_fields=Array($fields[6], $fields[3], $fields[4], $fields[5], $fields[2]);
			$sb= new search_box_ext($sb_fields, "sb_search_cpe", $MESSAGES["SEARCH"],1,($get_search==""));

			// Creation of table and add it to query
			$table_products= new datawindow_table("cpe_products", $fields, 0, $can_create, $can_modify, $can_delete);

			$qry->add_table($table_products);


			// Set the order by
			$qry->add_order_by("cpe_products.vendor");
			$qry->add_order_by("cpe_products.version");
			//$qry->add_order_by("product");
			//$qry->add_order_by("version");

			parent::datawindow_ext($qry);

			$this->add_search_box($sb);
		}

		function pre_insert(&$values) {
			//$values["full_name"]= $values["vendor"] . ", " . $values["name"] . ", " . $values["version"];
			return 1;
		}

		function post_insert($values) {
			/*
			global $global_db;
			global $MESSAGES;

			$query="select id_product from products where vendor='" . $values["vendor"] . "' and name='" . $values["name"] . "' and version='" . $values["version"] . "'";
			$res= $global_db->dbms_query($query);
			if(!$res) {
				html_showError("ERROR::f_post_new, product not found!");
				return 0;
			}
			list($id)= $global_db->dbms_fetch_row($res);
			html_showInfo($MESSAGES["PRODUCT_FIELD_ID"] . ": $id<br>");
			*/
			return 1;
		}

		function pre_delete($product_id, $values) {
			/*
			global $MESSAGES;
			global $global_db;

			// Has this product any server associated?
			$query="select * from server_products where id_product=$product_id";
			$res=$global_db->dbms_query($query);

			if($global_db->dbms_check_result($res)) {
				$global_db->dbms_free_result($res);
				html_showError($MESSAGES["PRODUCT_MGM_STILL_HAS_SERVERS"]);
				return 0;
			}
			return 1;
			*/
			return 0;
		}
	}
?>