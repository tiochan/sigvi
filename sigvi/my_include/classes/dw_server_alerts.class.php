<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage servers
 *
 * Server alerts datawindow class
 *
 */

	include_once INC_DIR . "/forms/forms.inc.php";

	include_once INC_DIR . "/forms/field.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";

	class dw_server_alerts extends datawindow {

		public function dw_server_alerts() {

			global $global_db, $MESSAGES, $USER_GROUP, $USER_LEVEL;

			$server_reference= new foreign_key($global_db,"servers","id_server","name");

			$fields= Array();
			$fields[0]= new field("servers.id_server","id_server","integer",false,true,false,false);
			$fields[1]= new master_field("alerts.php",$fields[0],"id_server",$MESSAGES["SERVER_FIELD_NAME"],"foreign_key",false,false,true,false,null,$server_reference);
			$fields[2]= new field("count(*)",$MESSAGES["TOTAL"],"integer",false,false,true,false);

			$restriction= $USER_LEVEL!=0 ? "servers.id_group=$USER_GROUP and " : "";
			$restriction.="servers.id_server = alerts.id_server and (alerts.status=0 or alerts.status=1 or alerts.status=3)";
			$query_adds="group by servers.id_server order by servers.name";

			parent::datawindow("servers,alerts",$fields,"", "", $query_adds, false, false, false);

			$c= "select servers.id_server as id_server, count(*) from servers, alerts where servers.deleted='0' and " . $restriction;
			$this->set_custom_query($c);
			$this->nav_enabled=false;
		}
	}
?>