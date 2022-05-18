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

create table audit ( id_audit mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY, server varchar(60) DEFAULT NULL, port varchar(60) DEFAULT NULL, name text DEFAULT NULL, nvt_id varchar(60) DEFAULT NULL, vuln_id varchar(60) DEFAULT NULL,bid varchar(60) DEFAULT NULL, audit_date timestamp,risk_factor varchar(25) DEFAULT NULL,threat varchar(25) DEFAULT NULL, description text, solution text, unique (nvt_id));

insert into audit values (1,'172.16.13.143','http (80/tcp)',"Apache 'mod_proxy_ftp' Module Command Injection Vulnerability (Linux)",'1.3.6.1.4.1.25623.1.0.900842','CVE-2009-3095','36254','2011-08-10 00:00:00','high','high','The host is running Apache and is prone to Command Injection vulnerability.','Upgrade to Apache HTTP Server version 2.2.15 or later');
insert into audit values (2,'172.16.13.143','mysql (3306/tcp)',"MySQL Empty Bit-String Literal Denial of Service Vulnerability",'1.3.6.1.4.1.25623.1.0.900221','CVE-2008-3963','31081','2011-08-10 00:00:00','medium','high','This host is running MySQL, which is prone to Denial of Service\n Vulnerability.\nVulnerability Insight : <BR>Issue is due to error while processing an empty bit string literal via <BR>a specially crafted SQL statement.<BR>Impact : Successful exploitation by remote attackers could cause denying<BR>access to legitimate users.<BR> Impact Level : Application<BR>Affected Software/OS : <BR> MySQL versions prior to 5.0.x - 5.0.66,<BR> 5.1.x - 5.1.26, and <BR>6.0.x - 6.0.5 on all running platform.','Update to version 5.0.66 or 5.1.26 or 6.0.6 or later.');


*/

include_once INC_DIR . "/forms/forms.inc.php";
include_once INC_DIR . "/forms/form_elements/datawindow_ext.inc.php";
include_once INC_DIR . "/forms/form_elements/search_box_ext.inc.php";

class cve_url extends string {

	function get_value($field_value) {
		$field_value = str_replace(" ","",$field_value);

		if ($field_value=="NOCVE") {
			return "-";
		}
		else{
			$list="";
			$field_value=explode(",",$field_value);
			foreach ($field_value as $field_cve){
				$link_cve="<a href='" . SERVER_URL . HOME . "/admin/vuln_detail.php?detail_vuln_id=" . $field_cve . "'target='_blank'>".$field_cve."</a>";
				$list=$list.$link_cve;
			}
		}
		$list=str_replace("</a><a","</a>,<a",$list);
		return $list;
	}

}

class type_threat extends string {

	function get_value($field_value) {
		switch($field_value) {
			case 3:
				return "High";
			case 2:
				return "Medium";
			case 1:
				return "Low";
		}
	}
}


class dw_audit extends datawindow_ext {

	public function dw_audit(&$optional_db=null) {

		global $USER_GROUP, $USER_LEVEL, $global_db, $MESSAGES;


		$qry= new datawindow_query();


		$restriction= $USER_LEVEL == 0 ? "" : "(id_group=$USER_GROUP or id_group is null)";
		$filter_reference= new foreign_key($global_db,"filters","id_filter","name", $restriction,"");

		$restriction= $USER_LEVEL!=0 ? "id_group=$USER_GROUP" : "";
		$group_reference= new foreign_key($global_db,"groups","id_group","name", $restriction);

		$restriction= $USER_LEVEL!=0 ? "servers.id_group=$USER_GROUP and servers.deleted='0'" : "servers.deleted='0'";
		$server_reference= new foreign_key($global_db,"servers","id_server","name", $restriction);

		$port_reference= new foreign_key($global_db,"audit_result","port","port", "distinct");


		$null_ref=null;

		$fields= array();
		// field($field_name, $field_alias, $field_type, $required, $is_unique, $visible, $updatable, $default_value=null, $reference=NULL)
		/*
					$fields[0]=  new field_ext("servers.id_server","","auto",false,true,0,false);
					$fields[0]->is_detail=false;
					$fields[1]=  new master_field_ext("servers_and_services.php","server_products.id_server",$fields[0],"servers.name",$MESSAGES["SERVER_FIELD_NAME"],"string",true,true,1,true);
					$fields[1]->add_parameter("tab_1_tab_selected=tab_services");
					$fields[1]->default_order_by= "a";
					$fields[2]=  new field_ext("servers.vendor","Port","string", false, false, 2, true);
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
		*/

		$form_name= "form_audit_result";
		//visible
		$fields[0]=  new field_ext("audit_result.id_audit_result","","auto",false,true,0,false);
		$fields[0]->is_detail=false;
		$fields[1]=  new field_ext("audit_result.id_audit",$MESSAGES["AUDIT_FIELD_SERVER"],"string", false, false, 0, true);

		$fields[2]=  new field_ext("audit_result.port",$MESSAGES["AUDIT_FIELD_PORT"],"string", false, false, 3,true);
		$fields[3]=  new field_ext("audit_result.name",$MESSAGES["AUDIT_FIELD_NAME"],"short_string", false, false, 4,true);
		$fields[4]=  new field_ext("audit_result.vuln_id",$MESSAGES["AUDIT_FIELD_VULN_ID"],"cve_url", false, false, 5,true);
		$fields[5]=  new field_ext("audit_result.threat",$MESSAGES["AUDIT_FIELD_THREAT"],"type_threat", false, false, 6,true);
		$fields[5]->default_order_by= "d";
		$fields[6]=  new field_ext("audit_result.description",$MESSAGES["AUDIT_FIELD_DESCRIPTION"],"short_string", false, false, 8,true);

		//no visible
		$fields[7]=  new field_ext("audit_result.bid",$MESSAGES["AUDIT_FIELD_VULN_ID"],"string", false, false, 0,true);
		$fields[8]=  new field_ext("audit_result.risk_factor",$MESSAGES["AUDIT_FIELD_RISK_FACTOR"],"string", false, false, 0,true);
		$fields[9]=  new field_ext("audit_result.nvt_id",$MESSAGES["AUDIT_FIELD_NVT_ID"],"string", false, true, 0,true);
		$fields[10]=  new field_ext("audit_result.solution",$MESSAGES["AUDIT_FIELD_SOLUTION"],"short_string", false, false, 0,false);
		$fields[11]=  new field_ext("audit_result.reference",$MESSAGES["AUDIT_FIELD_REFERENCES"],"short_string", false, false, 0,false);
		$fields[12]= new field_ext("audit_result.port",$MESSAGES["AUDIT_FIELD_PORT"],"foreign_key",false,false,0,false,null,$port_reference);



		$can_insert= false;
		$can_update= false;
		$can_delete= false;  //$can_delete= ($USER_LEVEL <= 3);
		$table_audit= new datawindow_table("audit_result", $fields, 0, $can_insert, $can_update, $can_delete);


		//if(strtoupper(SERVER_DELETE_RESTRICTION) == "LOGICAL") $table_audit->logical_delete=true;

		$qry->add_table($table_audit);


		$fields2= array();
		$fields2[0]= new field_ext("audit.id_audit","","auto",false,false,0,false);
		$fields2[1]= new field_ext("audit.id_server",$MESSAGES["ALERT_SERVER_FIELD_NAME"],"foreign_key",false,false,0,false,null,$server_reference);
		$fields2[2]= new field_ext("audit.audit_date",$MESSAGES["VULN_FIELD_PUBLISH_DATE"],"date",false,false,7,false);
		//$fields2[1]->default_order_by="a";

		$table_id_audit= new datawindow_table("audit", $fields2, 0, false, false, false);
		$table_id_audit->logical_delete=true;
		$qry->add_table($table_id_audit);

		$fields3= array();
		$fields3[0]= new field_ext("servers.id_server","","auto",false,false,0,false);
		$fields3[1]= new field_ext("servers.name",$MESSAGES["ALERT_SERVER_FIELD_NAME"],"string",false,false,1,false);
		//function field_ext($field_name, $field_alias, $field_type, $required, $is_unique, $show_order, $updatable, $default_value=null, $reference=NULL)

		$fields3[2]= new field_ext("servers.IP","IP","string",false,false,2,false);
		$fields3[3]= new field_ext("servers.id_group",$MESSAGES["SERVER_FIELD_GROUP"],"foreign_key", true, false, 0,($USER_LEVEL == 0), $USER_GROUP, $group_reference);
		//$fields3[4]= new field_ext("servers.name",$MESSAGES["ALERT_SERVER_FIELD_NAME"],"foreign_key",false,false,0,false,null,$server_reference);
		//$fields3[1]->default_order_by="a";

		$table_servers= new datawindow_table("servers", $fields3, 0, false, false, false);
		//$table_servers->logical_delete=true;
		if($USER_LEVEL != 0) {
			$table_servers->add_restriction(3, " ='$USER_GROUP'");
			$table_servers->add_custom_restriction("servers.deleted='0'");
		}
		else{
			$table_servers->add_custom_restriction("servers.deleted='0'");
		}
		$qry->add_table($table_servers);

		$qry->add_join($table_audit, 1, $table_id_audit, 0);
		$qry->add_join($table_id_audit, 1, $table_servers, 0);

		$sb= new search_box_ext(array($fields2[1],$fields[12],$fields3[2],$fields[4],$fields[5],$fields[9],$fields2[2]),"search_audit",$MESSAGES["SEARCH"],2);

		$qry->add_order_by_field($table_servers, 1);
		$qry->add_order_by_field($table_audit, 2);
		$qry->add_order_by_field($table_audit, 5);

		parent::datawindow_ext($qry);
		$this->add_search_box($sb);
	}

	protected function post_show_row($values) {
		global $MESSAGES;
		//var_dump($values);
		$audit_id= $values["audit_result.id_audit_result"];
		$link= HOME . '/admin/audit_detail.php?detail_audit_id='. $audit_id;
		echo $this->create_row_redirection("View audit",$link,ICONS . "/info.png");
	}


	protected function get_cell_color($field, $value) {
		if($field->name == "audit_result.threat") {
			switch($value) {
				case "High":
					return "#ff9999";
				case "Medium":
					return "#ffff99";
				case "Low":
					return "#99ff99";
				default:
					return "#99ff99";
			}
		}
		return "";
	}
}
