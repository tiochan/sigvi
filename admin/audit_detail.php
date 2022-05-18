<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage vulnerabilities
 * @uses form, datawindow
 *
 */


/*
	Table definition

+-------------+--------------+------+-----+-------------------+-----------------------------+
| Field       | Type         | Null | Key | Default           | Extra                       |
+-------------+--------------+------+-----+-------------------+-----------------------------+
| id_audit    | mediumint(9) | NO   | PRI | NULL              | auto_increment              | 
| server      | varchar(60)  | YES  |     | NULL              |                             | 
| port        | varchar(60)  | YES  |     | NULL              |                             | 
| name        | text         | YES  |     | NULL              |                             | 
| nvt_id      | varchar(60)  | YES  | UNI | NULL              |                             | 
| vuln_id     | varchar(60)  | YES  |     | NULL              |                             | 
| bid         | varchar(60)  | YES  |     | NULL              |                             | 
| audit_date  | timestamp    | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP | 
| risk_factor | varchar(25)  | YES  |     | NULL              |                             | 
| threat      | varchar(25)  | YES  |     | NULL              |                             | 
| description | text         | YES  |     | NULL              |                             | 
| solution    | text         | YES  |     | NULL              |                             | 
+-------------+--------------+------+-----+-------------------+-----------------------------+


*/

$AUTH_REQUIRED=true;
$AUTH_LVL=5;			// ADMINS ONLY

include_once "../include/init.inc.php";
include_once INC_DIR . "/forms/forms.inc.php";
include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";


class my_form extends form {

	function show_hidden() {
		global $audit_id;
		?>

		<input type='hidden' name='detail_audit_id' value='<?php echo $audit_id; ?>'>
		<?php
		parent::show_hidden();
	}
}

class my_vuln extends datawindow {

	protected function pre_show_row(&$values, &$can_update, &$can_delete) {
		return parent::pre_show_row($values, $can_update, $can_delete);
	}
}

$form_name= "form_audit";

html_header($MESSAGES["AUDIT_MGM_TITLE"]);

//echo "<a href='" . SERVER_URL . HOME . "/admin/server_alerts.php'>All</a>";


//	$source_reference= new foreign_key($global_db,"vulnerability_sources","id_source","name");


/*	$fields[0]= new field("id_vulnerability","","auto",false,true,false,false);
	$fields[1]= new field("id_source",$MESSAGES["VULN_FIELD_SOURCE"],"foreign_key",true,false,true,false, null, $source_reference);
	$fields[2]= new field("audit_id",$MESSAGES["VULN_FIELD_audit_id"],"cve_url", true, false, true,false);
	$fields[3]= new field("publish_date",$MESSAGES["VULN_FIELD_PUBLISH_DATE"],"date", true, false, true,false);
	$fields[4]= new field("modify_date",$MESSAGES["VULN_FIELD_MODIFY_DATE"],"date", true, false, true,false);
	$fields[5]= new field("description",$MESSAGES["VULN_FIELD_DESCRIPTION"],"fstring", false, false, true,false);
	$fields[6]= new field("severity",$MESSAGES["VULN_FIELD_SEVERITY"],"fstring", true, false, true,false);

	$fields[7]= new field("CVSS_score","CVSS score","integer", true, false, true,false);
	$fields[8]= new field("CVSS_vector","CVSS vector","fstring", true, false, true,false);
	$fields[9]= new field("CVSS_version","CVSS version","integer", true, false, true,false);
	$fields[10]= new field("CVSS_base_score","CVSS base score","integer", true, false, true,false);
	$fields[11]= new field("CVSS_impact_subscore","CVSS impact subscore","integer", true, false, true,false);
	$fields[12]= new field("CVSS_exploit_subscore","CVSS exploit subscore","integer", true, false, true,false);

	$fields[13]= new field("vuln_software",$MESSAGES["VULN_FIELD_VULN_SOFTWARE"],"fstring", false, false, true,false);
	$fields[14]= new field("ar_launch_remotely",$MESSAGES["VULN_FIELD_AR_LAUNCH_REMOTELY"],"bool", true, false, true,false);
	$fields[15]= new field("ar_launch_locally",$MESSAGES["VULN_FIELD_AR_LAUNCH_LOCALLY"],"bool", false, false, true,false);
	$fields[16]= new field("lt_security_protection",$MESSAGES["VULN_FIELD_SECURITY_PROTECTION"],"bool", false, false, true,false);
	$fields[17]= new field("lt_obtain_all_priv",$MESSAGES["VULN_FIELD_OBTAIN_ALL_PRIV"],"bool", false, false, true,false);
	$fields[18]= new field("lt_obtain_some_priv",$MESSAGES["VULN_FIELD_OBTAIN_SOME_PRIV"],"bool", false, false, true,false);
	$fields[19]= new field("lt_confidentiality",$MESSAGES["VULN_FIELD_CONFIDENTIALITY"],"bool", false, false, true,false);
	$fields[20]= new field("lt_integrity",$MESSAGES["VULN_FIELD_INTEGRITY"],"bool", false, false, true,false);
	$fields[21]= new field("lt_availability",$MESSAGES["VULN_FIELD_AVAILABILITY"],"bool", false, false, true,false);
	$fields[22]= new field("vt_input_validation_error",$MESSAGES["VULN_FIELD_INPUT_VALIDATION_ERROR"],"bool", false, false, true,false);
	$fields[23]= new field("vt_boundary_condition_error",$MESSAGES["VULN_FIELD_BOUNDARY_CONDITION_ERROR"],"bool", false, false, true,false);
	$fields[24]= new field("vt_buffer_overflow",$MESSAGES["VULN_FIELD_BUFFER_OVERFLOW"],"bool", false, false, true,false);
	$fields[25]= new field("vt_access_validation_error",$MESSAGES["VULN_FIELD_ACCESS_VALIDATION_ERROR"],"bool", false, false, true,false);
	$fields[26]= new field("vt_exceptional_condition_error",$MESSAGES["VULN_FIELD_EXCEPTIONAL_CONDITION_ERROR"],"bool", false, false, true,false);
	$fields[27]= new field("vt_environment_error",$MESSAGES["VULN_FIELD_ENVIRONMENT_ERROR"],"bool", false, false, true,false);
	$fields[28]= new field("vt_configuration_error",$MESSAGES["VULN_FIELD_CONFIGURATION_ERROR"],"bool", false, false, true,false);
	$fields[29]= new field("vt_race_condition",$MESSAGES["VULN_FIELD_RACE_CONDITION"],"bool", false, false, true,false);
	$fields[30]= new field("vt_other_vulnerability_type",$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"],"fstring", false, false, true,false);
	$fields[31]= new field("links",$MESSAGES["VULN_FIELD_LINKS"],"fstring", false, false, true,true);
	$fields[32]= new field("other_references",$MESSAGES["VULN_FIELD_OTHER_REFERENCES"],"text", false, false, true,true);
	$fields[33]= new field("other",$MESSAGES["VULN_FIELD_OTHER"],"fstring", false, false, true,true);
	$fields[34]= new field("solution",$MESSAGES["VULN_FIELD_SOLUTION"],"html", false, false, true, true);
*/

$fields[0]= new field("id_audit","","auto",false,true,false,false);
$fields[1]= new field("nvt_id",$MESSAGES["AUDIT_FIELD_NVT_ID"],"fstring", true, false, true,false);
$fields[2]= new field("name",$MESSAGES["AUDIT_FIELD_NAME"],"text", true, false, true,false);
$fields[3]= new field("port",$MESSAGES["AUDIT_FIELD_PORT"],"fstring", true, false, true,false);
$fields[4]= new field("vuln_id",$MESSAGES["AUDIT_FIELD_VULN_ID"],"fstring", true, false, true,false);
$fields[5]= new field("bid",$MESSAGES["AUDIT_FIELD_BID"],"fstring", true, false, true,false);
$fields[6]= new field("threat",$MESSAGES["AUDIT_FIELD_THREAT"],"fstring", true, false, true,false);
$fields[7]= new field("risk_factor",$MESSAGES["AUDIT_FIELD_RISK_FACTOR"],"fstring", true, false, true,false);
$fields[8]= new field("description",$MESSAGES["AUDIT_FIELD_DESCRIPTION"],"text", true, false, true,false);
$fields[9]= new field("solution",$MESSAGES["AUDIT_FIELD_SOLUTION"],"text", true, false, true,false);
$fields[10]= new field("reference",$MESSAGES["AUDIT_FIELD_REFERENCES"],"text", true, false, true,false);




$audit_id= get_http_param("detail_audit_id","");


if($audit_id != "") {

	$can_update= false;				// Each admin can do it
	$query_adds="";
	//$query_adds=" order by audit_date";
	$app="";
	//$restriction="";
	$restriction="id_audit_result='". $audit_id . "'";

	$dw= new my_vuln("audit_result",$fields,0, $restriction, $query_adds, false, $can_update, false);
	$dw->tabular=false;

	$frm= new my_form($form_name);
	$frm->add_element($dw);
	$frm->form_control();

} else {
	echo "<h1>NULL AUDIT ID</h1>";
}

html_footer();