<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage cron
 *
 * Script to detect updates on remote services.
 */


/*
	Schema information:

	Local table repositories:
	+---------------+--------------+------+-----+---------+----------------+
	| Field         | Type         | Null | Key | Default | Extra          |
	+---------------+--------------+------+-----+---------+----------------+
	| id_repository | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| name          | varchar(60)  | NO   | UNI |         |                |
	| id_group      | mediumint(9) | YES  |     | NULL    |                |
	| description   | varchar(255) | YES  |     | NULL    |                |
	| dbserver      | varchar(100) | NO   |     |         |                |
	| dbtype        | varchar(15)  | NO   |     |         |                |
	| dbuser        | varchar(60)  | YES  |     | NULL    |                |
	| dbname        | varchar(60)  | NO   |     |         |                |
	| dbpass        | varchar(255) | YES  |     | NULL    |                |
	| enabled       | int(1)       | YES  |     | NULL    |                |
	+---------------+--------------+------+-----+---------+----------------+

	Local table imported_services:
	+----------------------+--------------+------+-----+---------+----------------+
	| Field                | Type         | Null | Key | Default | Extra          |
	+----------------------+--------------+------+-----+---------+----------------+
	| id_imported_services | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| id_repository        | mediumint(9) | NO   | MUL |         |                |
	| remote_id_service    | mediumint(9) | NO   |     |         |                |
	| local_id_service     | mediumint(9) | NO   |     |         |                |
	| revision             | mediumint(9) | NO   |     | 0       |                |
	+----------------------+--------------+------+-----+---------+----------------+

	Remote table current_services:
	+-------------+--------------+------+-----+-------------------+----------------+
	| Field       | Type         | Null | Key | Default           | Extra          |
	+-------------+--------------+------+-----+-------------------+----------------+
	| id_service  | mediumint(9) | NO   | PRI | NULL              | auto_increment |
	| id_server   | mediumint(9) | NO   |     |                   |                |
	| d_date      | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
	| port        | int(11)      | NO   |     |                   |                |
	| protocol    | char(10)     | NO   |     |                   |                |
	| state       | varchar(10)  | YES  |     | NULL              |                |
	| name        | varchar(255) | YES  |     | NULL              |                |
	| product     | varchar(255) | YES  |     | NULL              |                |
	| version     | varchar(255) | YES  |     | NULL              |                |
	| extrainfo   | varchar(255) | YES  |     | NULL              |                |
	| ostype      | varchar(255) | YES  |     | NULL              |                |
	| fingerprint | text         | YES  |     | NULL              |                |
	| deleted     | int(11)      | NO   |     | 0                 |                |
	| revision    | int(11)      | NO   |     | 0                 |                |
	+-------------+--------------+------+-----+-------------------+----------------+
*/

	define("CLI_REQUIRED",true);

	$dir= dirname(__FILE__);
	define("SYSHOME", $dir . "/../..");

	include_once SYSHOME . "/include/init.inc.php";
	include_once SYSHOME . "/include/mail.inc.php";

	include_once SYSHOME . "/conf/discover.conf.php";
	include_once DISCOVERER_DIR . "/classes/discover.class.php";
	include_once DISCOVERER_DIR . "/include/repositories.api.php";
error_reporting(E_ALL);
	global $global_db;

	if(!defined("DISCOVERER_ENABLED") or !DISCOVERER_ENABLED) die ("Discoverer not enabled.");

	class updated_service {
		public $repository_name;
		public $group_id;
		public $remote_server_name;
		public $remote_service_description;
		public $status;
		public $revision;

		function updated_service($repository_name, $group_id, $remote_server_name, $remote_service_description, $status, $revision) {
			$this->repository_name= $repository_name;
			$this->group_id= $group_id;
			$this->remote_server_name= $remote_server_name;
			$this->remote_service_description= $remote_service_description;
			$this->status= $status;
			$this->revision= $revision;
		}
	}

	/**
	 * Checks for the updates of a remote repository against local services.
	 *
	 * @param integer $repository_id
	 * @param array of service_updated $services_array
	 */
	function check_repository_updates(&$discover_repository, $repository_id, $repository_name, $group, &$services_array) {

		global $global_db;


		// Get all services from remote repository
		$query="select srv.hostname, svc.* " .
			   "from current_services svc, servers srv " .
			   "where svc.id_server = srv.id_server";

		$remote_services= $discover_repository->discover_db->dbms_query($query);

		// Is there any service?
		if(!$discover_repository->discover_db->dbms_check_result($remote_services)) return;

		while($remote_service = $discover_repository->discover_db->dbms_fetch_array($remote_services)) {

			$remote_server_name= $remote_service["hostname"];
			$remote_service_id= $remote_service["id_service"];
			$remote_revision= $remote_service["revision"];
			$remote_service_name= $remote_service["name"];
			$remote_service_product= $remote_service["product"];
			$remote_service_version= $remote_service["version"];
			$remote_service_extrainfo= $remote_service["extrainfo"];
			$remote_service_deleted= $remote_service["deleted"];
			$remote_service_port= $remote_service["port"];


			$product_info = "Port $remote_service_port: ";
			$product_info.= trim($remote_service_name) != "" ? $remote_service_name . "," : "";
			$product_info.= trim($remote_service_product) != "" ? $remote_service_product . "," : "";
			$product_info.= trim($remote_service_version) != "" ? $remote_service_version . "," : "";
			$product_info.= $remote_service_extrainfo;

			/**
			 * First, select services imported and compare for those whose current version is greater than imported
			 * That means that the product has been upgraded.
			 *
			 */
			$query= "select imported_services.local_id_service, imported_services.revision, " .
				    "server_products.deleted, servers.name " .
					"from imported_services, server_products, servers " .
					"where imported_services.id_repository='$repository_id' and " .
					"      imported_services.remote_id_service='" . $remote_service_id . "' and " .
					"      imported_services.local_id_service=server_products.id_server_product and " .
					"      server_products.id_server=servers.id_server and " .
				    "      servers.id_group='$group'";

			$local_services= $global_db->dbms_query($query);

			/**
			 * If service is not imported
			 */
			if(!$global_db->dbms_check_result($local_services))	{

				// If is not imported, but is locked, ignore.
				if(is_service_locked($repository_id, $remote_service_id, $group) !== false) continue;

				// Not locked and not imported, then notify as new
				$services_array[$group][$repository_name][$remote_server_name][]= new updated_service($repository_name, $group, $remote_server_name, $product_info, "new", $remote_revision);
				continue;
			}

			while($local_service= $global_db->dbms_fetch_array($local_services)) {

				$local_revision= $local_service["revision"];
				$local_deleted= $local_service["deleted"];
				$local_name= $local_service["name"];

				// If a remote service is locked for a group, no checks are done.
				if(is_service_locked($repository_id, $remote_service_id, $group) !== false) continue;

				/**
				 * Check for deleted status, on remote and local
				 */

				// If remote service is deleted and local too, no checks needed
				if($remote_service_deleted and $local_deleted) continue;
				// If remote service is deleted but not local, notify as deleted
				if($remote_service_deleted and !$local_deleted) {
					$services_array[$group][$repository_name][$local_name][]= new updated_service($repository_name, $group, $remote_server_name, $product_info, "deleted", $remote_revision);
					continue;
				}
				// If remote service is not deleted, but is deleted local, the notify as new
				if(!$remote_service_deleted and $local_deleted) {
					$services_array[$group][$repository_name][$local_name][]= new updated_service($repository_name, $group, $remote_server_name, $product_info, "new", $remote_revision);
					continue;
				}

				/**
				 * If both are not deleted and present, check version status
				 */

				// If remote version is greater than imported, so the remote services has been upgraded.
				if($local_revision < $remote_revision) {
					$services_array[$group][$repository_name][$local_name][]= new updated_service($repository_name, $group, $remote_server_name, $product_info, "updated", $remote_revision);
				}
			}

			$global_db->dbms_free_result($local_services);
		}

		/**
		 * TODO
		 *
		 * Perhaps is a good idea to check the reverse order: which local services has been imported and has
		 * been deleted (not logically, simply deleted, on remote repository.
		 *
		 */

		$discover_repository->discover_db->dbms_free_result($remote_services);
	}


	$services_updated= array();

	$query="select * from repositories where enabled='1'";
	$repositories=$global_db->dbms_query($query);

	if(!$global_db->dbms_check_result($repositories)) {
		echo "There is not any active repository.\n";
		return 1;
	}


	while($repository = $global_db->dbms_fetch_array($repositories)) {

		// Construct repository object
		// $host, $type, $database, $username, $password
		$discover_repository= new discover_repository($repository["dbserver"], $repository["dbtype"], "repository_" . $repository["dbname"], $repository["dbuser"], $repository["dbpass"]);
		check_repository_updates($discover_repository, $repository["id_repository"], $repository["name"], $repository["id_group"], $services_updated);
		$discover_repository->discover_db->dbms_close();
	}

	$global_db->dbms_free_result($repositories);


	foreach($services_updated as $group_id => $updated_repositories) {

		$report="<BOLD>The following remote services has been updated:</BOLD><LINE_BREAK><LINE_BREAK>";

		foreach($updated_repositories as $repository => $updated_servers) {

			$report.="<TABLE class='report'><TR><TH colspan=2 class='report'>Repository $repository</TH></TR>\n";
			$report.="<TR class='report'><TD class='report'><BOLD>Server</BOLD></TD><TD class='report'><BOLD>Service</BOLD></TD></TR>\n";

			foreach($updated_servers as $server_name => $updated_services) {

				$tmp_server_name= $server_name;

				foreach($updated_services as $service) {

					$report.="<TR class='report'><TD class='report'>$tmp_server_name</TD>\n";
					$tmp_server_name="&nbsp;";

					switch($service->status) {
						case "new":
						case "add":
							$report.= "<TD class='report' bgcolor='#aaffaa'>[+] " . $service->remote_service_description . "</TD>\n";
							break;
						case "updated":
						case "modified":
						case "upd":
							$report.= "<TD class='report' bgcolor='#aaaaff'>[*] " . $service->remote_service_description . "</TD>\n";
							break;
						case "deleted":
						case "removed":
						case "del":
							$report.= "<TD class='report' bgcolor='#ffaaaa'>[-] " . $service->remote_service_description . "</TD>\n";
							break;
					}

					$report.= "</TR>";
				}
			}

			$report.="</TABLE>";
		}

		if($report!= "") {
			send_group_report($group_id, "Services updates from NSDi", $report, DEFAULT_EMAIL_METHOD);
		}

		my_echo("<LINE_BREAK>The execute of this task was made sucessfully.<br><LINE_BREAK>");
	}
?>