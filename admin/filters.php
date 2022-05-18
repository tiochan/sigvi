<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage filters
 *
 */


/*
	Table definition

	+--------------------------------+--------------+------+-----+---------+-------+
	| Field                          | Type         | Null | Key | Default | Extra |
	+--------------------------------+--------------+------+-----+---------+-------+
	| id_user                        | mediumint(9) | NO   | PRI |         |       |
	| severity                       | tinyint(1)   | YES  |     | NULL    |       |
	| ar_launch_remotely             | tinyint(1)   | YES  |     | NULL    |       |
	| ar_launch_locally              | tinyint(1)   | YES  |     | NULL    |       |
	| lt_security_protection         | tinyint(1)   | YES  |     | NULL    |       |
	| lt_obtain_all_priv             | tinyint(1)   | YES  |     | NULL    |       |
	| lt_obtain_some_priv            | tinyint(1)   | YES  |     | NULL    |       |
	| lt_confidentiality             | tinyint(1)   | YES  |     | NULL    |       |
	| lt_integrity                   | tinyint(1)   | YES  |     | NULL    |       |
	| lt_availability                | tinyint(1)   | YES  |     | NULL    |       |
	| vt_input_validation_error      | tinyint(1)   | YES  |     | NULL    |       |
	| vt_boundary_condition_error    | tinyint(1)   | YES  |     | NULL    |       |
	| vt_buffer_overflow             | tinyint(1)   | YES  |     | NULL    |       |
	| vt_access_validation_error     | tinyint(1)   | YES  |     | NULL    |       |
	| vt_exceptional_condition_error | tinyint(1)   | YES  |     | NULL    |       |
	| vt_environment_error           | tinyint(1)   | YES  |     | NULL    |       |
	| vt_configuration_error         | tinyint(1)   | YES  |     | NULL    |       |
	| vt_race_condition              | tinyint(1)   | YES  |     | NULL    |       |
	| vt_other_vulnerability_type    | tinyint(1)   | YES  |     | NULL    |       |
	+--------------------------------+--------------+------+-----+---------+-------+
*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";
	include_once INC_DIR . "/forms/form_elements/label.inc.php";

	$form_name= "form_users";

	class dw_filters extends datawindow {

		public function pre_insert(&$values) {

			global $USER_LEVEL, $USER_GROUP;

			if($USER_LEVEL != 0) $values["id_group"]= $USER_GROUP;
			return 1;
		}

		public function pre_update($row_id, $old_values, &$new_values) {

			global $USER_LEVEL, $USER_GROUP;

			if($USER_LEVEL != 0) $new_values["id_group"]= $USER_GROUP;
			return 1;
		}

		protected function pre_show_row(&$values, &$can_update, &$can_delete) {
			global $USER_LEVEL;
			global $USER_GROUP;

			$can_update= ($USER_LEVEL == 0) || ( ($USER_LEVEL == 3) and ($USER_GROUP == $values["id_group"]) );
			$can_delete= $can_update;

			return 1;
		}
	}

	class list_severity_opts extends listbox {

		function list_severity_opts() {

			parent::listbox();

			$this->lb[0]="";
			$this->lb[1]="Low";
			$this->lb[2]="Med";
			$this->lb[3]="High";

		}
	}

	class list_bool extends listbox {

		function list_bool() {
			global $MESSAGES;

			parent::listbox();

			$this->lb[0]="";
			$this->lb[1]=$MESSAGES["TRUE"];
			$this->lb[2]=$MESSAGES["FALSE"];
		}
	}

	$type= new listbox();
	$type->lb[0]=$MESSAGES["FILTER_TYPE_FIELD_PASS_AND"];
	$type->lb[1]=$MESSAGES["FILTER_TYPE_FIELD_PASS_OR"];
	$type->lb[2]=$MESSAGES["FILTER_TYPE_FIELD_FILTER_AND"];
	$type->lb[3]=$MESSAGES["FILTER_TYPE_FIELD_FILTER_OR"];



	html_header($MESSAGES["FILTER_TITLE"],"notification_filter.html");

	$info= new label("sf_info",$MESSAGES["FILTER_MORE_INFO"]);

	$fields= Array();

	$list= new listbox();

	$group_restriction="";
	if($USER_LEVEL > 0) $group_restriction= "id_group= $USER_GROUP";

	$default_group= ($USER_LEVEL > 0) ? $USER_GROUP : null;


	$group_reference= new foreign_key($global_db,"groups","id_group","name", $group_restriction);
	$list_severity= new list_severity_opts();
	$list_bool= new list_bool();

	$fields[]= new field("id_filter","","auto",false,true,false,false);
	$fields[]= new field("name","Name","fstring",false,false,true,true);
	$fields[]= new field("id_group","Grup","foreign_key",false,false,true,($USER_LEVEL == 0),$default_group,$group_reference);
	$fields[]= new field("f_type","TYPE","listbox",false,false,true,($USER_LEVEL <= 3),null,$type);
	$fields[]= new field("severity","SEV","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_severity);
	$fields[]= new field("ar_launch_remotely","REM","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("ar_launch_locally","LOC","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("lt_security_protection","SPT","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("lt_obtain_all_priv","APV","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("lt_obtain_some_priv","SPV","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("lt_confidentiality","CNF","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("lt_integrity","INT","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("lt_availability","AVA","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_input_validation_error","VAL","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_boundary_condition_error","CON","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_buffer_overflow","OVF","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_access_validation_error","AVE","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_exceptional_condition_error","ECE","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_environment_error","ENV","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_configuration_error","CNF","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_race_condition","RCN","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("vt_other_vulnerability_type","OTH","listbox",false,false,true,($USER_LEVEL <= 3),null,$list_bool);
	$fields[]= new field("description",$MESSAGES["FILTER_FIELD_DESCRIPTION"],"text",false,false,true,($USER_LEVEL <= 3));

	$restriction= ($USER_LEVEL > 0) ? "((id_group= $USER_GROUP) or (id_group is null))" : "";

	$sb= new search_box(array($fields[1]),"search_alert",$MESSAGES["SEARCH"]);

	$can_insert= ($USER_LEVEL <= 3);
	$can_update= ($USER_LEVEL <= 5);
	$can_delete= ($USER_LEVEL <= 3);
	$query_adds="";

	$dw= new dw_filters("filters",$fields,0, $restriction, $query_adds, $can_insert, $can_update, $can_delete);
	$dw->add_search_box($sb);

	$frm= new form($form_name);
	$frm->add_element($info);
	$frm->add_element($dw);
	$frm->form_control();

	html_footer();
?>