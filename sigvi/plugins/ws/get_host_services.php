<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage Remote Services
 *
 * PHP service to get the software installed on a server
 *
 */

	$allowed_hosts= array(
			"127.0.0.1",
			$_SERVER['SERVER_ADDR'],
			"147.83.198.17",
			"147.83.194.23",
			"147.83.194.44",
			"147.83.194.105",
			"147.83.198.148"
		);

	define("QUIET",true);
	include_once "../../include/init.inc.php";
	include_once MY_INC_DIR . "/functions.php";


	function check_server(&$server_name) {

		global $global_db;

		// Check for server name
		$query="select id_server from servers where name='" . $server_name . "'";
		$res= $global_db->dbms_query($query);

		if(!$global_db->dbms_check_result($res)) {

			if(normalize_hostname_and_ip($server_name, $hostname, $ip)) {
				$server_name= $hostname;

				// Check for server name
				$query="select id_server from servers where name='" . $server_name . "'";
				$res= $global_db->dbms_query($query);

				if(!$global_db->dbms_check_result($res)) {
					return false;
				}
			} else {
				return false;
			}
		}

		list($id_server)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $id_server;
	}

	/**
	 * Return a string in XML format with the list of software for a given
	 * server on a given repository.
	 *
	 * @param string $server_name
	 * @return xml
	 *
	 */
	function get_server_services($server_name) {

		global $global_db;

		if(($id_server=check_server($server_name)) === false) {
			die("Server not found ($server_name)");
		}

		// Get server services
		$query="select distinct s.name, p.vendor, p.name, p.version from servers s, server_products sp, products p where s.name='$server_name' and s.id_server = sp.id_server and sp.id_product = p.id_product";

		$res= $global_db->dbms_query($query);
//		if(!$global_db->dbms_check_result($res)) die("No services found for this Server ($server_name)");

?>
		<table border='0' cellspacing='0' cellpadding='2' class='boxbottom'  width='98%'>
			<tr>
				<td><span class="tableheadtext">Producte</span></td>
				<td><span class="tableheadtext">Versi&oacute;</span></td>
				<td><span class="tableheadtext">Fabricant</span></td>
			</tr>
<?php

		$par=false;
		while($row= $global_db->dbms_fetch_array($res)) {

			if($par) echo "<tr class='TRbackground'>";
			else echo "<tr>";

			$par= !$par;

			echo "<td><span class='tabletext'>" . $row[1] . "</span></td>";
			echo "<td><span class='tabletext'>" . $row[2] . "</span></td>";
			echo "<td><span class='tabletext'>" . $row[3] . "</span></td>";

			echo "</tr>";
		}

		echo "</table>";

		$global_db->dbms_free_result($res);
	}

//	if(!in_array($_SERVER['REMOTE_ADDR'], $allowed_hosts)) die("Access denied" . $_SERVER['REMOTE_ADDR']);

	$host= get_http_param("hostname","");
	if($host == "") die("hostname parameter must be passed through GET or POST.");

	get_server_services($host);
?>
