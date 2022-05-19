<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage fas
 *
 */


/*
	Table definition

	+----------+--------------+------+-----+---------+----------------+
	| Field    | Type         | Null | Key | Default | Extra          |
	+----------+--------------+------+-----+---------+----------------+
	| id_fas   | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| name     | char(15)     | YES  |     | NULL    |                |
	| id_group | mediumint(9) | YES  |     | NULL    |                |
	| fas      | char(255)    | YES  |     | NULL    |                |
	| enabled  | decimal(1,0) | YES  |     | 0       |                |
	+----------+--------------+------+-----+---------+----------------+
*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;			// ADMINS ONLY

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";
	include_once INC_DIR . "/forms/form_elements/label.inc.php";

	include_once MY_INC_DIR . "/classes/fas.class.php";


	$form_name= "form_fas";


	class dw_fas extends datawindow {

		/**
		 * After showing a row, we must decide who can edit/delete this row.
		 *
		 * Level 5: can see all the FAS functions for its group and general (without group), cant edit/delete any
		 * Level 3: can see all the FAS functions for its group and general (without group), can edit and delete only those created for his group
		 * Level 0: can see/edit/delete all
		 *
		 * @param array $values
		 * @param boolean $can_update
		 * @param boolean $can_delete
		 * @return boolean
		 */

		protected function pre_show_row(&$values, &$can_update, &$can_delete) {
			global $USER_LEVEL;
			global $USER_GROUP;

			$can_update= ($USER_LEVEL == 0) || ( ($USER_LEVEL == 3) and ($USER_GROUP == $values["id_group"]) );
			$can_delete= $can_update;

			return 1;
		}

		/**
		 * Only can be one FAS enabled for each group. Check it...
		 *
		 * @param array $values
		 * @return boolean
		 */
		public function pre_insert(&$values) {
			global $USER_GROUP;
			global $USER_LEVEL;
			global $MESSAGES;

			if ($USER_LEVEL>=3) {
					$values["id_group"]= $USER_GROUP;
			}

			if(! $this->check_fas($values["fas"])) {
				html_showError($MESSAGES["FAS_INCORRECT_FAS"]);
				return 0;
			}

			if($values["enabled"]==1) {
				if($this->check_enabled($values["id_group"])) {
					html_showError($MESSAGES["FAS_THERE_IS_ACTIVE_FAS"]);
					return 0;
				}
			}

			return 1;
		}

		/**
		 * Only can be one FAS enabled for each group. Check it...
		 *
		 * @param string $row_id
		 * @param array $old_values
		 * @param array $new_values
		 * @return boolean
		 */
		public function pre_update ($row_id, $old_values, &$new_values) {

			global $MESSAGES;

			// Only sigvi admin can change group
			$new_values["id_group"]= $old_values["id_group"];

			if(! $this->check_fas($new_values["fas"])) {
				html_showError($MESSAGES["FAS_INCORRECT_FAS"]);
				return 0;
			}

			if(($new_values["enabled"]==1) and ($old_values["enabled"]==0)) {
				if($this->check_enabled($new_values["id_group"])) {
					html_showError($MESSAGES["FAS_THERE_IS_ACTIVE_FAS"]);
					return 0;
				} else {
					return 1;
				}
			}

			return 1;
		}

		/**
		 * If there is not any FAS enabled for the group, advert to user
		 *
		 * @param unknown_type $row_id
		 * @param unknown_type $old_values
		 * @param unknown_type $new_values
		 * @return unknown
		 */
		public function post_update ($row_id, $old_values, $new_values) {

			global $MESSAGES;

			if(!$this->check_enabled($new_values["id_group"])) {
				html_showInfo($MESSAGES["FAS_USE_DEFAULT_FAS"]);
			}

			return 1;
		}

		/**
		 * If there is not any FAS enabled for the group, advert to user
		 *
		 * @param unknown_type $row_id
		 * @param unknown_type $old_values
		 * @return unknown
		 */
		public function post_delete ($row_id, $old_values) {

			global $MESSAGES;

			if(!$this->check_enabled($old_values["id_group"])) {
				html_showInfo($MESSAGES["FAS_USE_DEFAULT_FAS"]);
			}

			return 1;
		}

		/**
		 * This function returns true if there is one FAS enabled for this group, else returns false
		 *
		 * @param integer $id_group
		 * @return boolean
		 */
		private function check_enabled($id_group) {

			global $global_db;

			if($id_group=="") {

				$query= "SELECT * FROM fas WHERE fas.enabled=1 AND id_group is null";

			} else {

				$query= "SELECT *
						FROM fas
						WHERE fas.enabled=1 AND id_group='" . $id_group ."'";
			}

			$res= $global_db->dbms_query($query);
			if($global_db->dbms_check_result($res) ) {
				$global_db->dbms_free_result($res);
				return 1;
			}
			return 0;
		}

		/**
		 * This function return true if the FAS expression is correct, else return false
		 *
		 * @param string $fas_string
		 * @return boolean
		 */
		public function check_fas($fas_string) {

			global $global_db;

			$fas= new fas($fas_string);

			if(!$fas->is_valid) {

				return 0;
			}

			return 1;
		}
	}


	html_header($MESSAGES["FAS_MGM_TITLE"],"fas_form.html");

	$fields= Array();

	$group_restriction="";
	if($USER_LEVEL > 0) $group_restriction= "id_group= $USER_GROUP";
	$group_reference= new foreign_key($global_db,"groups","id_group","name", $group_restriction);

	$value_restriction= $USER_LEVEL == 0 ? null : $USER_GROUP;

	$fields[]= new field("id_fas","","auto",false,true,false,false);
	$fields[]= new field("name",$MESSAGES["FAS_FIELD_NAME"],"fstring",true,true,true,true);
	$fields[]= new field("id_group",$MESSAGES["FAS_FIELD_GROUP"],"foreign_key",false,false,true,($USER_LEVEL == 0), $value_restriction, $group_reference);
	$fields[]= new field("fas","FAS","text",false,false,true,($USER_LEVEL <= 3));
	$fields[]= new field("enabled",$MESSAGES["FAS_FIELD_ENABLE"],"bool",true,false,true,true,0);

	$sb= new search_box(array($fields[1],$fields[2]),"search_alert",$MESSAGES["SEARCH"]);

	$restriction= $USER_LEVEL >=3 ? "((id_group = $USER_GROUP) or (id_group is null))" : "";

	$can_insert= ($USER_LEVEL <= 3);
	$can_update= ($USER_LEVEL <= 3);
	$can_delete= ($USER_LEVEL <= 3);
	$query_adds="";

	$dw= new dw_fas("fas",$fields,0, $restriction, $query_adds, $can_insert, $can_update, $can_delete);
	$dw->add_search_box($sb);

	$frm= new form($form_name);
	$frm->add_element($dw);
	$frm->form_control();

	html_footer();
?>