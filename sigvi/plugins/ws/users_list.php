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
define("MODULE","WS_LIST_USERS");

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
function users_list($USER_ID) {

	global $global_db, $allowed_hosts;

	if(! in_array($_SERVER['REMOTE_ADDR'], $allowed_hosts))
		return "Access denied" . $_SERVER['REMOTE_ADDR'];

	if(!is_numeric($USER_ID)) return "User id not set";

	include_once INC_DIR . "/forms/form_basic.inc.php";

	if(file_exists(MY_INC_DIR . "/classes/user.class.php")) {
		include_once MY_INC_DIR . "/classes/user.class.php";
	} else {
		include_once INC_DIR . "/classes/user.class.php";
	}


	$usr= new user($USER_ID);

	$query="select username, hiredate from users";
	if($usr->level != 0) $query.= " where id_group = '" . $usr->id_group . "'";

	$res= $global_db->dbms_query($query);

	if(!$global_db->dbms_check_result($res)) {
		return "Error executing query: " . $global_db->dbms_error();
	}


	$result= convertResultToString($global_db, $res);

	$global_db->dbms_free_result($res);

	//return htmlspecialchars("$result");
	return "<h3>Web Service Sample</h3>$result";
}

$server= new SoapServer(null, array('uri' => "http://users_list/"));
$server->addFunction("users_list");
$server->addFunction(SOAP_FUNCTIONS_ALL);

$server->handle();
