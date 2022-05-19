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
define("MODULE","WS_SERVER_ALERTS");

$allowed_hosts= array(
	"127.0.0.1",
	$_SERVER['SERVER_ADDR']
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
function server_alerts($USER_ID) {

	global $global_db, $allowed_hosts, $USER_GROUP, $USER_LEVEL;

	if(! in_array($_SERVER['REMOTE_ADDR'], $allowed_hosts))
		return "Access denied" . $_SERVER['REMOTE_ADDR'];

	if(!is_numeric($USER_ID)) return "User id not set";

	include_once INC_DIR . "/forms/form_basic.inc.php";

	if(file_exists(MY_INC_DIR . "/classes/user.class.php")) {
		include_once MY_INC_DIR . "/classes/user.class.php";
	} else {
		include_once INC_DIR . "/classes/user.class.php";
	}

	include_once MY_INC_DIR . "/classes/alert.class.php";

	$usr= new user($USER_ID);
	$USER_GROUP= $usr->id_group;
	$USER_LEVEL= $usr->level;

	$result= alerts_show_servers_status(false, false);

	return "$result";
}

$server= new SoapServer(null, array('uri' => "server_alerts.php"));
$server->addFunction("server_alerts");
$server->addFunction(SOAP_FUNCTIONS_ALL);

$server->handle();
