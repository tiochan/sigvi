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
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";

	class cve_url extends string {

		function get_value($field_value) {
			return "<a href='http://nvd.nist.gov/nvd.cfm?cvename=$field_value' target='_blank'>$field_value</a>";
		}

	}
	
	class my_form extends form {
		
		function show_hidden() {
			global $vuln_id;
?>

<input type='hidden' name='detail_vuln_id' value='<?php echo $vuln_id; ?>'>
<?php
			parent::show_hidden();
		}
	}

	class my_vuln extends datawindow {

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
/*
		protected function own_show_rows(&$res) {
			
			$num_fields=count($this->fields);
			
			
			$cont=1;
			while($row= $this->db->dbms_fetch_array($res)) {

				$this->get_values_from_row($row, $values);
				
//print_object($values);


				$can_update=true;
				$can_delete=true;

				if(!$this->pre_show_row($values, $can_update, $can_delete)) continue;

				$toHead="#" . $cont++;
				$id=""; $value=0;
				$toPrint="";
				
				$toPrint.="<tr class='data_box_rows_list'><td class='data_box_cell_alias'>" . $this->fields[1]->alias . "[</td><td class='data_box_cell_value'>" . $value . "</td></tr>";

				for($i=0, $field_counter=0; $i < $num_fields; $i++) {
					if($this->fields[$i]->name=="") continue;

					$value= $this->fields[$i]->get_value($row[$field_counter++]);

					if($this->fields[$i]->visible) {
						$alias=$this->fields[$i]->alias;
						$toPrint.="<tr class='data_box_rows_list'><td class='data_box_cell_alias'>$alias</td><td class='data_box_cell_value'>$value</td></tr>";
					}
				}

				$toToolbar="";

				$id= key_exists($this->identifier, $row) ? $row[$this->identifier] : "";

				if($can_update and $this->update_allowed and ($id != "")) {
					$toToolbar.=$this->get_update_button($id);
				}
				if($can_delete and $this->delete_allowed and ($id != "")) {
					$toToolbar.= $this->get_delete_button($id);
				}
				if($toPrint!="") {
					echo "<tr class='data_box_rows_list_header'><td class='data_box_rows_list_header'>$toHead</td><td class='data_box_notab_header' align='right'>$toToolbar</td></tr>\n";
					echo $toPrint;
				}

				if(method_exists($this, "post_show_row")) {
					echo "<tr class='data_box_notab_header'><td class='data_box_notab_header' colspan='2'>";
					$this->post_show_row($values);
					echo "</td></tr>";
				}
			}
		}
		*/
	}

	$form_name= "form_vulnerabilities";

	html_header($MESSAGES["VULN_MGM_TITLE"]);

	echo "<a href='" . SERVER_URL . HOME . "/admin/vulnerabilities.php'>All</a>";

	$source_reference= new foreign_key($global_db,"vulnerability_sources","id_source","name");


	$fields[0]= new field("id_vulnerability","","auto",false,true,false,false);
	$fields[1]= new field("id_source",$MESSAGES["VULN_FIELD_SOURCE"],"foreign_key",true,false,true,false, null, $source_reference);
	$fields[2]= new field("vuln_id",$MESSAGES["VULN_FIELD_VULN_ID"],"cve_url", true, false, true,false);
	$fields[3]= new field("publish_date",$MESSAGES["VULN_FIELD_PUBLISH_DATE"],"date", true, false, true,false);
	$fields[4]= new field("modify_date",$MESSAGES["VULN_FIELD_MODIFY_DATE"],"date", true, false, true,false);
	$fields[5]= new field("description",$MESSAGES["VULN_FIELD_DESCRIPTION"],"string", false, false, true,false);
	$fields[6]= new field("severity",$MESSAGES["VULN_FIELD_SEVERITY"],"string", true, false, true,false);

	$fields[7]= new field("CVSS_score","CVSS score","integer", true, false, true,false);
	$fields[8]= new field("CVSS_vector","CVSS vector","string", true, false, true,false);
	$fields[9]= new field("CVSS_version","CVSS version","integer", true, false, true,false);
	$fields[10]= new field("CVSS_base_score","CVSS base score","integer", true, false, true,false);
	$fields[11]= new field("CVSS_impact_subscore","CVSS impact subscore","integer", true, false, true,false);
	$fields[12]= new field("CVSS_exploit_subscore","CVSS exploit subscore","integer", true, false, true,false);

	$fields[13]= new field("vuln_software",$MESSAGES["VULN_FIELD_VULN_SOFTWARE"],"string", false, false, true,false);
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
	$fields[30]= new field("vt_other_vulnerability_type",$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"],"string", false, false, true,false);
	$fields[31]= new field("links",$MESSAGES["VULN_FIELD_LINKS"],"string", false, false, true,true);
	$fields[32]= new field("other_references",$MESSAGES["VULN_FIELD_OTHER_REFERENCES"],"text", false, false, true,true);
	$fields[33]= new field("other",$MESSAGES["VULN_FIELD_OTHER"],"string", false, false, true,true);
	$fields[34]= new field("solution",$MESSAGES["VULN_FIELD_SOLUTION"],"html", false, false, true, true);


	$vuln_id= get_http_param("detail_vuln_id","");


	if($vuln_id != "") {

		$can_update= ($USER_LEVEL == 0);				// Each admin can do it
		$query_adds=" order by publish_date";
		$app="";

		$restriction="vuln_id='". $vuln_id . "'";

		$dw= new my_vuln("vulnerabilities",$fields,0, $restriction, $query_adds, false, $can_update, false);
		$dw->tabular=false;

		$frm= new my_form($form_name);
		$frm->add_element($dw);
		$frm->form_control();

	} else {
		echo "<h1>NULL VULN ID</h1>";
	}

	html_footer();
?>