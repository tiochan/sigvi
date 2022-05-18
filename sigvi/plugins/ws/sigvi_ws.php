<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage Web Services
 *
 * Web service to get the number of alerts for a server
 *
 */

	define("LOG_REQUEST", true);
	define("MODULE","WS_TIQUETS");

	$allowed_hosts= array(
			"127.0.0.1",
			"147.83.198.148",
			"147.83.198.165",
			"147.83.198.17",
			"147.83.197.40"
		);

	define("QUIET",true);
	include_once "../../include/init.inc.php";

	/**
	 * Return the number of alerts for a server whose FAS is equal or greater
	 * than the "alert_level" parameter.
	 *
	 * @param string $host_name
	 * @param numeric $alert_level
	 * @return integer
	 */
	function getServerAlerts($host_name, $alert_level=8) {

		global $global_db, $allowed_hosts;

		if(! in_array($_SERVER['REMOTE_ADDR'], $allowed_hosts))
			return "Access denied";

		$num_alerts= -1;
		$server= trim($host_name);

		if($server=="") return "Must set host name\n";

		// LOG?
		if(LOG_REQUEST) {
			$log= "New request from " . $_SERVER['REMOTE_ADDR'] . " for Server: $server, Alert level: $alert_level\n";
			log_write(MODULE, $log, 3);
		}

		$server= addslashes($server);
		$query="select id_server, name from servers where IP='$server' or name='$server'";

		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) return "Error: server not found";

		list($id_server, $name) = $global_db->dbms_fetch_row($res);

		$query="select count(*) from alerts where alerts.id_server = '$id_server' and alerts.final_alert_severity >= $alert_level and (alerts.status=0 or alerts.status=1 or alerts.status=3)";
		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) return "Error executing query";

		list($num_alerts) = $global_db->dbms_fetch_row($res);

		return $num_alerts;
	}

	$server= new SoapServer(null, array('uri' => "http://check_alerts/"));
	$server->addFunction("getServerAlerts");
	$server->addFunction(SOAP_FUNCTIONS_ALL);

	$server->handle();
?>