<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage admin
 *
 * Repositories common functions
 * API Form PHP Forms.
 *
 * You need to complete the code for the basic functions ahead.
 */

	/**
	 * Repository API Functions
	 * Get the repository name from the repository identifier.
	 * If found, then returns the name, else returns false.
	 *
	 * @param integer $repository_id
	 * @return string
	 */
	function get_repository_name($repository_id) {
		global $global_db;

		$query="select name from repositories where id_repository=$repository_id";
		$res=$global_db->dbms_query($query);
		if(!$res) return false;

		list($name)= $global_db->dbms_fetch_row($res);

		$global_db->dbms_free_result($res);
		return $name;
	}

	/**
	 * Repository API Functions
	 * Get the repository id from the repository name.
	 * If found, then returns the ID, else returns false.
	 *
	 * @param string $repository_name
	 * @return integer
	 */
	function get_repository_id($repository_name) {
		global $global_db;

		$query="select id_repository from repositories where name='" . $repository_name . "'";
		$res=$global_db->dbms_query($query);
		if(!$res) return false;

		list($id)= $global_db->dbms_fetch_row($res);

		$global_db->dbms_free_result($res);
		return $id;
	}

	/**
	 * Repository API Functions
	 * Get the repository access from the repository name.
	 * If found, then returns true, else returns false
	 *
	 * @param string $repository_name
	 * @param string $dbserver
	 * @param string $dbtype
	 * @param string $dbname
	 * @param string $dbuser
	 * @param string $dbpass
	 * @return bool
	 */
	function get_repository_access($repository_name, &$dbserver, &$dbtype, &$dbname, &$dbuser, &$dbpass) {
		global $global_db;

		$query="select dbserver, dbname, dbtype, dbuser, dbpass from repositories where name='" . $repository_name . "'";

		$res=$global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) return false;

		list($dbserver, $dbname, $dbtype, $dbuser, $dbpass) = $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return true;
	}

	/**
	 * Returns the hostname of the remote server identified by remote_id_server.
	 * If not found returns false.
	 *
	 * @param discover_repository $discover_repository
	 * @param integer $remote_id_server
	 * @return string
	 */
	function get_remote_server_name(&$discover_repository, $remote_id_server) {

		$query= "select hostname from servers where id_server='$remote_id_server'";

		$res=$discover_repository->discover_db->dbms_query($query);
		if(!$discover_repository->discover_db->dbms_check_result($res)) {
			return false;
		}

		list($server_name) = $discover_repository->discover_db->dbms_fetch_row($res);
		$discover_repository->discover_db->dbms_free_result($res);

		return $server_name;
	}

	/**
	 * YOUR CODE HERE!
	 *
	 * Put the code to get the local server name, from a
	 * Returns true if the server exists (or can't be imported) and fales if the server doesn't exists (or can be imported).
	 *
	 * @param string $server_name
	 * @return bool
	 */
	function get_local_server_name($local_id_server) {

		global $global_db;

		$query= "select name from servers where id_server='$local_id_server'";

		if(!$global_db->dbms_check_result($res)) return false;

		list($server_name) = $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $server_name;
	}

	/**
	 * YOUR CODE HERE!
	 *
	 * Put the code to determine if the server exists on your environment, local database, etc...
	 * Returns the server id if the server exists (or can't be imported), else returns false.
	 *
	 * @param string $server_name
	 * @return bool
	 */
	function exists_local_server($server_name, $group_id) {

		global $global_db;

		$query="select id_server from servers where name='" . $server_name . "' and id_group='" . $group_id . "'";
		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) return false;

		list($server_id)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);
		return $server_id;
	}

	/**
	 * Determines if a remote server has been imported.
	 * If found then returns the local server identifier. Else returns false.
	 *
	 * imported_servers
	 * +---------------------+--------------+------+-----+---------+----------------+
	 * | Field               | Type         | Null | Key | Default | Extra          |
	 * +---------------------+--------------+------+-----+---------+----------------+
	 * | id_imported_servers | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	 * | id_repository       | mediumint(9) | NO   | MUL |         |                |
	 * | remote_id_server    | mediumint(9) | NO   |     |         |                |
	 * | local_id_server     | mediumint(9) | NO   |     |         |                |
	 * +---------------------+--------------+------+-----+---------+----------------+
	 *
	 * @param integer $id_repository
	 * @param integer $remote_id_server
	 * @return integer
	 */
	function is_server_imported($id_repository, $remote_id_server) {

		global $global_db;

		$query= "select local_id_server from imported_servers where id_repository='$id_repository' and remote_id_server='$remote_id_server'";

		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) return false;

		list($local_id_server) = $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $local_id_server;
	}

	/**
	 *
	 * YOUR CODE HERE
	 *
	 * Determines if a remote service has been imported or not.
	 *
	 * imported_services
	 * +----------------------+--------------+------+-----+---------+----------------+
	 * | Field                | Type         | Null | Key | Default | Extra          |
	 * +----------------------+--------------+------+-----+---------+----------------+
	 * | id_imported_services | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	 * | id_repository        | mediumint(9) | NO   | MUL |         |                |
	 * | remote_id_service    | mediumint(9) | NO   |     |         |                |
	 * | local_id_service     | mediumint(9) | NO   |     |         |                |
	 * | revision             | mediumint(9) | NO   |     | 0       |                |
	 * +----------------------+--------------+------+-----+---------+----------------+
	 *
	 * server_products
	 * +-------------------+--------------+------+-----+---------+----------------+
	 * | Field             | Type         | Null | Key | Default | Extra          |
	 * +-------------------+--------------+------+-----+---------+----------------+
	 * | id_server_product | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	 * | id_server         | mediumint(9) | NO   | MUL | 0       |                |
	 * | id_product        | mediumint(9) | NO   |     | 0       |                |
	 * | ports             | varchar(255) | YES  |     | NULL    |                |
	 * | filtered          | tinyint(4)   | YES  |     | NULL    |                |
	 * | critic            | tinyint(4)   | YES  |     | NULL    |                |
	 * | protocol          | varchar(20)  | YES  |     | NULL    |                |
	 * +-------------------+--------------+------+-----+---------+----------------+
	 *
	 * servers (local)
	 * +---------------+--------------+------+-----+---------+----------------+
	 * | Field         | Type         | Null | Key | Default | Extra          |
	 * +---------------+--------------+------+-----+---------+----------------+
	 * | id_server     | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	 * | name          | varchar(30)  | NO   | MUL |         |                |
	 * | id_repository | mediumint(9) | YES  |     | NULL    |                |
	 * | vendor        | varchar(60)  | YES  |     | NULL    |                |
	 * | model         | varchar(60)  | YES  |     | NULL    |                |
	 * | cpu           | varchar(60)  | YES  |     | NULL    |                |
	 * | ram           | varchar(30)  | YES  |     | NULL    |                |
	 * | disc          | varchar(60)  | YES  |     | NULL    |                |
	 * | serial_number | varchar(60)  | YES  |     | NULL    |                |
	 * | os            | varchar(60)  | YES  |     | NULL    |                |
	 * | id_group      | int(11)      | YES  |     | NULL    |                |
	 * | location      | varchar(60)  | YES  |     | NULL    |                |
	 * | IP            | varchar(60)  | YES  |     | NULL    |                |
	 * | zone          | varchar(60)  | YES  |     | NULL    |                |
	 * | observations  | text         | YES  |     | NULL    |                |
	 * | id_filter     | mediumint(9) | YES  |     | NULL    |                |
	 * +---------------+--------------+------+-----+---------+----------------+

	 * @param integer $repository_id
	 * @param integer $remote_service_id
	 */

	function is_service_imported($repository_id, $remote_service_id, $group_id) {

		global $global_db;

		/**
		 * Review this query to link it to your local servers database.
		 *
		 * This code is sampled for SIGVI, where a server can be owned by one group,
		 * and one remote server can be imported to multiple local servers, but on
		 * distincts groups.
		 */

		$query= "select local_id_service from imported_services, server_products, servers
				where imported_services.id_repository='$repository_id' and
				      imported_services.remote_id_service='" . $remote_service_id . "' and
				      imported_services.local_id_service=server_products.id_server_product and
				      server_products.id_server=servers.id_server and
				      servers.id_group='$group_id'
				      ";

		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) {
			return false;
		}

		list($local_id_service)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);
		return $local_id_service;
	}

	/**
	 * Determines if a remote service has been locked for a group.
	 *
	 *
	 * +-------------------+--------------+------+-----+---------+----------------+
	 * | Field             | Type         | Null | Key | Default | Extra          |
	 * +-------------------+--------------+------+-----+---------+----------------+
	 * | id_locked_service | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	 * | id_repository     | mediumint(9) | NO   | MUL |         |                |
	 * | remote_id_service | mediumint(9) | NO   |     |         |                |
	 * | local_group_id    | mediumint(9) | YES  |     | NULL    |                |
	 * +-------------------+--------------+------+-----+---------+----------------+
	 *
	 * Determines if a remote service has been locked.
	 *
	 * @param integer $repository_id
	 * @param integer $remote_service_id
	 * @param integer $group_id
	 */

	function is_service_locked($repository_id, $remote_service_id, $group_id) {

		global $global_db;

		$query= "select * from imported_locked_services where id_repository='$repository_id' and " .
				"remote_id_service='$remote_service_id' and	local_group_id='$group_id'";

		$res= $global_db->dbms_query($query);

		if(!$global_db->dbms_check_result($res)) {   // Ok, doesn't exists
			return false;
		}

		list($id_locked_service)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $id_locked_service;
	}

	/**
	 * Lock a remote service for a given group
	 *
	 * Returns true if all goes ok, else returns false
	 *
	 * @param integer $repository_id
	 * @param integer $remote_service_id
	 * @param integer $group_id
	 * @return bool
	 */
	function lock_service($repository_id, $remote_service_id, $group_id) {

		global $global_db;

		$query= "insert into imported_locked_services (id_repository, remote_id_service, local_group_id) " .
				"values('$repository_id','$remote_service_id','$group_id')";

		if(($res= $global_db->dbms_query($query)) === false) {
			html_showError("Error locking service:" . $global_db->dbms_error());
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Unlock a remote service for a given group
	 *
	 * Returns true if all goes ok, else returns false
	 *
	 * @param integer $repository_id
	 * @param integer $remote_service_id
	 * @param integer $group_id
	 */
	function unlock_service($repository_id, $remote_service_id, $group_id) {

		global $global_db;

		$query= "delete from imported_locked_services " .
				"where id_repository= '$repository_id' and ".
				"remote_id_service='$remote_service_id' and ".
				"local_group_id='$group_id'";

		if(($res= $global_db->dbms_query($query)) === false) {
			html_showError("Error unlocking service:" . $global_db->dbms_error());
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Returns the state of revision from remote service against imported service.
	 * The retun values are:
	 *
	 *  - 0 if the services are sync.
	 *  - 1 if the imported service has a minor revision version (the remote is updated)
	 *  - 2 if the remote service has not been imported
	 *
	 * @param integer $repository_id
	 * @param integer $remote_service_id
	 * @param integer $remote_service_revision
	 * @return integer
	 */
	function check_imported_service_updates($repository_id, $remote_service_id, $remote_service_revision, $group_id) {

		global $global_db;

		if(!($local_service_id= is_service_imported($repository_id, $remote_service_id, $group_id))) return 2;
		$query= "select revision from imported_services " .
				"where id_repository='$repository_id' and " .
					  "remote_id_service='" . $remote_service_id . "' and " .
					  "local_id_service='$local_service_id'";

		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) return 2;

		list($revision)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		if($revision < $remote_service_revision) return 1;
		return 0;
	}

	/**
	 *
	 * Will import a remote server to the local import tables. If the local server
	 * doesn't exists will create it.
	 *
	 * $server has the data to import:
	 * - $server->id_server (the remote id_server on repository)
	 * - $server->hostname (the remote host name on repository)
	 * - $server->ip (the remote host ip on repository)
	 *
	 * The most important field is:
	 * - id_server (to identify the server on the remote repository)
	 *
	 * @param integer $id_repository
	 * @param server $server
	 */
	function import_server($id_repository, $server, $group_id) {

		global $global_db;


		$global_db->dbms_begin_transaction();

		// First insert the new server...
		if(!($local_server_id= exists_local_server($server->hostname, $group_id))) {
			if(!($local_server_id= create_local_server($server->hostname, $server->ip, $group_id))) return false;
		}

		$query="insert into imported_servers (id_repository, remote_id_server, local_id_server) values ('$id_repository','" . $server->id_server . "','$local_server_id')";
		$res= $global_db->dbms_query($query);

		if($res===false) {
			html_showError("Error importing server. Can't insert relationship between remote and local server find server id.");
			//echo $global_db->dbms_error();
			$global_db->dbms_rollback();
			return false;
		}

		$global_db->dbms_commit();

		return true;
	}

	/**
	 * Removes the association between a remote server and a local server, but don't delete
	 * any information more than the relationship.
	 *
	 * @param integer $id_repository
	 * @param server $server
	 * @return bool
	 */
	function unlink_imported_server($id_repository, $server, $group_id) {

		global $global_db;

		if(!($local_server_id= exists_local_server($server->hostname, $group_id))) {
			return false;
		}

		$query= "delete from imported_servers where id_repository='$id_repository' and remote_id_server='" . $server->id_server . "' and local_id_server='$local_server_id'";

		if(($res= $global_db->dbms_query($query)) === false) {
			html_showError("Error deleting relationship.");
			return false;
		}

		return true;
	}

	/**
	 *
	 * YOUR CODE HERE
	 *
	 * On this function you must put the code to import the service into your system.
	 *
	 * $service has the data to import:
	 *
	 * $service->id_service (the remote service id on repository)
	 * $service->id_server (the remote service server on repository)
	 * $service->d_date (the remote service adquisition date on repository)
	 * $service->port (the remote service port on repository)
	 * $service->protocol (the remote service protocol on repository)
	 * $service->state (the remote service state on repository)
	 * $service->name (the remote service name on repository)
	 * $service->product (the remote service product on repository)
	 * $service->version (the remote service version on repository)
	 * $service->extrainfo (the remote service extrainfo on repository)
	 * $service->ostype (the remote service operative system on repository)
	 * $service->fingerprint (the remote service fingerprint on repository)
	 * $service->deleted (the remote service deleted flag on repository)
	 * $service->revision (the remote service revision counter on repository)
	 *
	 *
	 * The most important fields are:
	 *
	 * id_service (to identify the service on the remote repository)
	 * revision (to control when a change happen)
	 *
	 * @param integer $id_repository
	 * @param server_service $service
	 * @param integer $local_service
	 */
	function import_service($id_repository, $service, $local_service, $group_id) {

		global $global_db;
		global $discover_repository;


		// First insert the new server...
		if(!($hostname=get_remote_server_name($discover_repository, $service->id_server))) {
			html_showError("Cant find remote server.");
		}

		if(!($local_server_id=exists_local_server($hostname, $group_id))) {
			html_showError("The server is not imported.");
			return false;
		}

		$global_db->dbms_begin_transaction();

		if(!($new_local_relation=create_local_service($local_server_id, $local_service, $service->port, $service->protocol))) {
			html_showError("Couldn't link the product with the server.");
			$global_db->dbms_rollback();
			return false;
		}

		$query="insert into imported_services (id_repository, remote_id_service, local_id_service, revision) ".
			   "values ('$id_repository','" . $service->id_service . "','$new_local_relation','" . $service->revision . "')";
		$res= $global_db->dbms_query($query);

		if($res===false) {
			html_showError("Error importing service. Can't insert relationship between remote and local services.");
			echo $global_db->dbms_error();
			$global_db->dbms_rollback();
			return false;
		}

		$global_db->dbms_commit();

		return true;
	}

	/**
	 *
	 * YOUR CODE HERE
	 *
	 * On this function you must put the code to update an existing service.
	 *
	 * $service has the data to update:
	 *
	 * $service->id_service (the remote service id on repository)
	 * $service->id_server (the remote service server on repository)
	 * $service->d_date (the remote service adquisition date on repository)
	 * $service->port (the remote service port on repository)
	 * $service->protocol (the remote service protocol on repository)
	 * $service->state (the remote service state on repository)
	 * $service->name (the remote service name on repository)
	 * $service->product (the remote service product on repository)
	 * $service->version (the remote service version on repository)
	 * $service->extrainfo (the remote service extrainfo on repository)
	 * $service->ostype (the remote service operative system on repository)
	 * $service->fingerprint (the remote service fingerprint on repository)
	 * $service->deleted (the remote service deleted flag on repository)
	 * $service->revision (the remote service revision counter on repository)
	 *
	 *
	 * The most important fields are:
	 *
	 * id_service (to identify the service on the remote repository)
	 * revision (to control when a change happen)
	 *
	 * @param integer $id_repository
	 * @param server_service $service
	 * @param integer $local_service
	 */
	function update_service($id_repository, $service, $local_service, $group_id) {

		global $global_db;
		global $discover_repository;


		// First insert the new server...
		if(!($hostname=get_remote_server_name($discover_repository, $service->id_server))) {
			html_showError("Cant find remote server.");
		}

		if(!($local_server_id=exists_local_server($hostname, $group_id))) {
			html_showError("The server is not imported.");
		}

		$global_db->dbms_begin_transaction();

		if(!($new_local_relation=create_local_service($local_server_id, $local_service, $service->port, $service->protocol))) {
			html_showError("Couldn't link the product with the server.");
			$global_db->dbms_rollback();
			return false;
		}

		$query= "update imported_services set " .
				"local_id_service = '$local_service'," .
				"revision = '" . $service->revision . "' " .
				"where id_repository = '$id_repository' and " .
				"remote_id_service='" . $service->id_service . "'";


		$res= $global_db->dbms_query($query);

		if($res===false) {
			html_showError("Error updating service. Can't update the relationship between remote and local services.");
			echo $global_db->dbms_error();
			$global_db->dbms_rollback();
			return false;
		}

		$global_db->dbms_commit();

		return true;
	}

	/**
	 * Removes the association between a remote server and a local server, but don't delete
	 * any information more than the relationship.
	 *
	 * @param integer $id_repository
	 * @param integer $remote_service_id
	 * @return bool
	 */
	function unlink_imported_service($repository_id, $remote_service_id, $group_id) {

		global $global_db;

		if(!($local_service_id=is_service_imported($repository_id, $remote_service_id, $group_id))) return false;

		$query= "delete from imported_services where id_repository='$repository_id' and remote_id_service='" . $remote_service_id. "' and local_id_service='$local_service_id'";
		if(($res= $global_db->dbms_query($query)) === false) {
			html_showError("Error deleting relationship.");
			return false;
		} else {
			html_showSuccess("");
		}
		return true;
	}

	/**
	 *
	 * YOUR CODE HERE
	 *
	 * This function will create a server on local repository.
	 * Returns the identifier of the new server if all went ok, else returns false.
	 *
	 * Steps:
	 * 1. Insert a new server
	 * 2. Get the id of this server.
	 *
	 * @param string $servername
	 * @param string $ip
	 * @param integer $group
	 * @return integer
	 */
	function create_local_server($servername, $ip, $group) {
		global $global_db;

		$query="insert into servers (name, ip, id_group) values ('" . $servername . "','" . $ip . "','" . $group . "')";
		$res= $global_db->dbms_query($query);

		// Now set the relationship between remote and local server
		$query="select id_server from servers where name='" . $servername . "' and id_group='" . $group . "'";
		$res= $global_db->dbms_query($query);

		if(!$global_db->dbms_check_result($res)) {   // Ok, doesn't exists
			html_showError("Error importing server. Can't find the new server id.");
			$global_db->dbms_rollback();
			return false;
		}

		list($local_server_id)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $local_server_id;
	}

	/**
	 *
	 * YOUR CODE HERE
	 *
	 * This function will create a service on local repository.
	 * Returns the identifier of the new service if all went ok, else returns false.
	 *
	 * Steps:
	 * 1. Insert a new service
	 * 2. Get the id of this service.
	 *
	 * @param string $servername
	 * @param string $ip
	 * @param integer $group
	 * @return integer
	 */
	function create_local_service($local_server_id, $local_service_id, $port, $protocol) {
		global $global_db;

		$query="insert into server_products (id_server, id_product, ports, filtered, critic, protocol) ".
			   "values ('$local_server_id','$local_service_id','" . $port . "', '0', '0', '" . $protocol . "')";
		$res= $global_db->dbms_query($query);

		if($res===false) {
			html_showError("Error importing service. Can't add new service.");
			$global_db->dbms_rollback();
			return false;
		}

		// Now set the relationship between remote and local server
		$query="select max(id_server_product) from server_products where id_server='$local_server_id' and id_product='$local_service_id'";
		$res= $global_db->dbms_query($query);

		if(!$global_db->dbms_check_result($res)) {   // Ok, doesn't exists
			html_showError("Error importing service. Can't find the new service id.");
			$global_db->dbms_rollback();
			return false;
		}

		list($local_relation)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $local_relation;
	}

	/**
	 * Return a report of pending tasks
	 *
	 * TODO: Add code to return a brief report of pending imports and synchros.
	 */
	function get_unsinchronized_elements() {

		global $USER_GROUP, $USER_LEVEL;
		global $global_db;

		$restriction= $USER_LEVEL!=0 ? "(id_group=$USER_GROUP or id_group is null)" : "";

		$query="select * from repositories where $restriction";
		$res= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) {
			return "";
		}

		$ret="";
		while($row= $global_db->dbms_fetch_array($res)) {
			$id= $row["id_repository"];
			$name=$row["name"];
			$ret.=$name . ",";
		}

		$global_db->dbms_free_result($res);
		return $ret;
	}
?>