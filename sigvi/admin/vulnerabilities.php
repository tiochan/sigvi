<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage vulnerabilities
 *
 */


/*
	Table definition

	+--------------------------------+--------------+------+-----+------------+----------------+
	| Field                          | Type         | Null | Key | Default    | Extra          |
	+--------------------------------+--------------+------+-----+------------+----------------+
	| id_vulnerability               | int(11)      | NO   | PRI | NULL       | auto_increment |
	| id_source                      | mediumint(9) | NO   |     | 0          |                |
	| vuln_id                        | varchar(50)  | NO   | UNI |            |                |
	| publish_date                   | date         | NO   |     | 0000-00-00 |                |
	| modify_date                    | date         | NO   |     | 0000-00-00 |                |
	| description                    | text         | YES  |     | NULL       |                |
	| severity                       | varchar(25)  | YES  |     | NULL       |                |
	| CVSS_score                     | decimal(4,2) | YES  |     | NULL       |                |
	| CVSS_vector                    | varchar(100) | YES  |     | NULL       |                |
	| CVSS_version                   | decimal(4,2) | YES  |     | NULL       |                |
	| CVSS_base_score                | decimal(4,2) | YES  |     | NULL       |                |
	| CVSS_impact_subscore           | decimal(4,2) | YES  |     | NULL       |                |
	| CVSS_exploit_subscore          | decimal(4,2) | YES  |     | NULL       |                |
	| ar_launch_remotely             | tinyint(4)   | YES  |     | NULL       |                |
	| ar_launch_locally              | tinyint(4)   | YES  |     | NULL       |                |
	| lt_security_protection         | tinyint(4)   | YES  |     | NULL       |                |
	| lt_obtain_all_priv             | tinyint(4)   | YES  |     | NULL       |                |
	| lt_obtain_some_priv            | tinyint(4)   | YES  |     | NULL       |                |
	| lt_confidentiality             | tinyint(4)   | YES  |     | NULL       |                |
	| lt_integrity                   | tinyint(4)   | YES  |     | NULL       |                |
	| lt_availability                | tinyint(4)   | YES  |     | NULL       |                |
	| vt_input_validation_error      | tinyint(4)   | YES  |     | NULL       |                |
	| vt_boundary_condition_error    | tinyint(4)   | YES  |     | NULL       |                |
	| vt_buffer_overflow             | tinyint(4)   | YES  |     | NULL       |                |
	| vt_access_validation_error     | tinyint(4)   | YES  |     | NULL       |                |
	| vt_exceptional_condition_error | tinyint(4)   | YES  |     | NULL       |                |
	| vt_environment_error           | tinyint(4)   | YES  |     | NULL       |                |
	| vt_configuration_error         | tinyint(4)   | YES  |     | NULL       |                |
	| vt_race_condition              | tinyint(4)   | YES  |     | NULL       |                |
	| vt_other_vulnerability_type    | tinyint(4)   | YES  |     | NULL       |                |
	| vuln_software                  | text         | YES  |     | NULL       |                |
	| links                          | text         | YES  |     | NULL       |                |
	| other_references               | text         | YES  |     | NULL       |                |
	| other                          | text         | YES  |     | NULL       |                |
	+--------------------------------+--------------+------+-----+------------+----------------+

*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;			// ADMINS ONLY

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/button.inc.php";
	include_once INC_DIR . "/forms/form_elements/checkbox.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once INC_DIR . "/forms/form_elements/select.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";
	include_once SYSHOME . "/my_include/filters.inc.php";
	include_once MY_INC_DIR . "/classes/vulnerability.class.php";

	function get_last_vuln() {

		global $global_db;

		$query="select max(publish_date) from vulnerabilities";
		$res= $global_db->dbms_query($query);

		if(!$global_db->dbms_check_result($res)) return "";

		list($max)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $max;
	}


	class my_bool extends bool {

		function get_value($field_value, $for_show=true) {

			$value= ($field_value == "1") ? "X" : "";
			return $value;
		}
	}

	class cve_url extends string {

		function get_value($field_value, $for_show=true) {
			return "<a href='http://nvd.nist.gov/nvd.cfm?cvename=$field_value' target='_blank'>$field_value</a>";
		}

	}


	class my_vuln extends datawindow {

		protected function get_row_color($filaPar, $values) {

			$ret= isset($values["severity"]) ? vuln_get_color($values["severity"]) : parent::get_row_color($filaPar, null);
			return $ret;
		}

		protected function post_show_row($values) {
			global $MESSAGES;

			$link= "<a href='" . SERVER_URL . HOME . "/admin/vuln_detail.php?detail_vuln_id=" . $values["vuln_id"] . "'>[+]</a>";
			echo $link;
		}

		protected function pre_show_row(&$values, &$can_update, &$can_delete) {

			$vuln_id= $values["vuln_id"];
			$cvss_version= round($values["CVSS_version"],0);
			$cvss_vector= $values["CVSS_vector"];
			$cvss_score= $values["CVSS_score"] ? $values["CVSS_score"] : "&nbsp;";

			if($cvss_vector!="" and $cvss_version) {

				$url_cvss= "http://nvd.nist.gov/cvss.cfm?version=$cvss_version&name=" . $vuln_id . "&vector=$cvss_vector";
				$link_cvss= "<a href='$url_cvss' target='_blank'>" . $cvss_score . "</a>";

				$values["CVSS_score"]= $link_cvss;
			} else {
				$values["CVSS_score"]= " ";
			}

			return parent::pre_show_row($values, $can_update, $can_delete);
		}
	}

	$SHOW_ALL= false;
	$form_name= "form_vulnerabilities";

	html_header($MESSAGES["VULN_MGM_TITLE"]);

	$source_reference= new foreign_key($global_db,"vulnerability_sources","id_source","name");

	$fields[0]=  new field("id_vulnerability","","auto",false,true,false,false);
	$fields[1]=  new field("id_source",$MESSAGES["VULN_FIELD_SOURCE"],"foreign_key", true, false, true, false, null, $source_reference);
	$fields[2]=  new field("vuln_id",$MESSAGES["VULN_FIELD_VULN_ID"],"cve_url", true, false, true, false);
	$fields[3]=  new field("publish_date",$MESSAGES["VULN_FIELD_PUBLISH_DATE"],"date_time", true, false, true, false);
	$fields[4]=  new field("modify_date",$MESSAGES["VULN_FIELD_MODIFY_DATE"],"date", true, false, true, false);
	$fields[5]=  new field("severity","SEV","string", true, false, true,false);

	$fields[6]=  new field("CVSS_score","CVSS score","integer",false,false,true,true);

	$fields[7]=  new field("ar_launch_remotely","REM","my_bool", true, false, true,false);
	$fields[8]=  new field("ar_launch_locally","LOC","my_bool", false, false, true,false);
	$fields[9]=  new field("lt_security_protection","SPT","my_bool", false, false, true,false);
	$fields[10]= new field("lt_obtain_all_priv","APV","my_bool", false, false, true,false);
	$fields[11]= new field("lt_obtain_some_priv","SPV","my_bool", false, false, true,false);
	$fields[12]= new field("lt_confidentiality","CNF","my_bool", false, false, true,false);
	$fields[13]= new field("lt_integrity","INT","my_bool", false, false, true,false);
	$fields[14]= new field("lt_availability","AVA","my_bool", false, false, true,false);
	$fields[15]= new field("description",$MESSAGES["VULN_FIELD_DESCRIPTION"],"short_string", false, false, true, false);
	$fields[16]= new field("vuln_software",$MESSAGES["VULN_FIELD_VULN_SOFTWARE"],"short_string", false, false, true, false);
	// No visibles: (but software list)
	$fields[17]= new field("vt_input_validation_error",$MESSAGES["VULN_FIELD_INPUT_VALIDATION_ERROR"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[18]= new field("vt_boundary_condition_error",$MESSAGES["VULN_FIELD_BOUNDARY_CONDITION_ERROR"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[19]= new field("vt_buffer_overflow",$MESSAGES["VULN_FIELD_BUFFER_OVERFLOW"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[20]= new field("vt_access_validation_error",$MESSAGES["VULN_FIELD_ACCESS_VALIDATION_ERROR"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[21]= new field("vt_exceptional_condition_error",$MESSAGES["VULN_FIELD_EXCEPTIONAL_CONDITION_ERROR"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[22]= new field("vt_environment_error",$MESSAGES["VULN_FIELD_ENVIRONMENT_ERROR"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[23]= new field("vt_configuration_error",$MESSAGES["VULN_FIELD_CONFIGURATION_ERROR"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[24]= new field("vt_race_condition",$MESSAGES["VULN_FIELD_RACE_CONDITION"],"my_bool", false, false, $SHOW_ALL, false);
	$fields[25]= new field("vt_other_vulnerability_type",$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"],"string", false, false, $SHOW_ALL, false);
	$fields[26]= new field("links",$MESSAGES["VULN_FIELD_LINKS"],"string", false, false, $SHOW_ALL,true);
	$fields[27]= new field("other_references",$MESSAGES["VULN_FIELD_OTHER_REFERENCES"],"text", false, false, $SHOW_ALL,true);
	$fields[28]= new field("other",$MESSAGES["VULN_FIELD_OTHER"],"string", false, false, $SHOW_ALL, true);
	$fields[29]= new field("solution",$MESSAGES["VULN_FIELD_SOLUTION"],"string", false, false, $SHOW_ALL, true);

	$fields[]=  new field("CVSS_vector","CVSS vector","string",false,false,false,false);
	$fields[]=  new field("CVSS_version","CVSS version","integer",false,false,false,false);
	$fields[]=  new field("CVSS_base_score","CVSS base score","integer",false,false,false,false);
	$fields[]=  new field("CVSS_impact_subscore","CVSS impact subscore","integer",false,false,false,false);
	$fields[]=  new field("CVSS_exploit_subscore","CVSS exploit subscore","integer",false,false,false,false);


	$sb_fields1= array($fields[2], $fields[3], $fields[5], $fields[15], $fields[16], $fields[26]);
	$sb1= new search_box($sb_fields1, "sb_search1", $MESSAGES["SEARCH"], 2, false);
	if($sb1->first_time and ($sb1->get_field_value("publish_date")=="") and (get_http_get_param("detail_vuln_id","")=="") and (get_http_param("find_software","")=="")) $sb1->set_field_value("publish_date", get_last_vuln());

	$sb_fields2= array($fields[5], $fields[7], $fields[8], $fields[9], $fields[10], $fields[11], $fields[12], $fields[13], $fields[14]);
	$sb2= new search_box($sb_fields2, "sb_search2", $MESSAGES["ADVANCED_SEARCH"], 2);

	$dw= new my_vuln("vulnerabilities",$fields, 0, "", "order by publish_date", false, false, false,$null);
	$dw->add_search_box($sb1);
	$dw->add_search_box($sb2);

	$frm= new form($form_name);
	$frm->add_element($dw);
	$frm->form_control();

	echo "<TABLE>" .
	"<TH>Key</TH><TH>Type<TH>Desc</TH>" .
	"<TR><TD><BOLD>SEV&nbsp;&nbsp;</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_SEVERITY"]) . "</TD></TR>" .
	"<TR><TD><BOLD>REM</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_AR_LAUNCH_REMOTELY"]) . "</TD></TR>" .
	"<TR><TD><BOLD>LOC</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_AR_LAUNCH_LOCALLY"]) . "</TD></TR>" .
	"<TR><TD><BOLD>SPT</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_SECURITY_PROTECTION"]) . "</TD></TR>" .
	"<TR><TD><BOLD>APV</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_OBTAIN_ALL_PRIV"]) . "</TD></TR>" .
	"<TR><TD><BOLD>SPV</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_OBTAIN_SOME_PRIV"]) . "</TD></TR>" .
	"<TR><TD><BOLD>CNF</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_CONFIDENTIALITY"]) . "</TD></TR>" .
	"<TR><TD><BOLD>INT</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_INTEGRITY"]) . "</TD></TR>" .
	"<TR><TD><BOLD>AVA</BOLD></TD><TD>" . str_replace("<br>","&nbsp;&nbsp;</TD><TD>", $MESSAGES["VULN_FIELD_AVAILABILITY"]) . "</TD></TR>" .
	"</TABLE>";

	html_footer();
?>