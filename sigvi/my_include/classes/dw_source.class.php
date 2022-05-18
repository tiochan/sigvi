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

	+-------------+--------------+------+-----+---------+----------------+
	| Field       | Type         | Null | Key | Default | Extra          |
	+-------------+--------------+------+-----+---------+----------------+
	| id_source   | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| name        | varchar(60)  | NO   | UNI |         |                |
	| description | text         | YES  |     | NULL    |                |
	| parser      | varchar(255) | YES  |     | NULL    |                |
	| parameters  | varchar(255) | YES  |     | NULL    |                |
	| use_it      | tinyint(4)   | YES  |     | NULL    |                |
	+-------------+--------------+------+-----+---------+----------------+
*/

	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";


	class dw_source extends datawindow {

		public function dw_source($table_name, $parsers_dir, &$optional_db=null) {

			global $USER_GROUP, $USER_LEVEL, $global_db, $MESSAGES;

			// Create the listbox to select the filename
			$list= new list_dir($parsers_dir);

			$fields= array();

			$fields[]= new field("id_source","","auto",false,true,false,false);
			$fields[]= new field("name",$MESSAGES["SOURCE_FIELD_NAME"],"string",true,false,true,true);
			$fields[]= new field("description",$MESSAGES["SOURCE_FIELD_DESCRIPTION"],"text", false, false, true,true);
			$fields[]= new field("parser",$MESSAGES["SOURCE_FIELD_PARSER_LOCATION"],"listbox", true, false, true,true, null, $list);
			$fields[]= new field("parameters",$MESSAGES["SOURCE_FIELD_PARAMETERS"],"string", false, false, true,true);
			$fields[]= new field("use_it",$MESSAGES["SOURCE_FIELD_USE_IT"],"bool", true, false, true,true);

			$can_manage= ($USER_LEVEL == 0);				// Each admin can do it
			$query_adds=" order by name";
			parent::datawindow($table_name, $fields,0, "", $query_adds, $can_manage, $can_manage, $can_manage, $optional_db);
		}
	}
?>