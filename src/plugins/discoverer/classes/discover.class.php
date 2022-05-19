<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage classes
 *
 * Discover plugin API classes
 *
 * 	Usage:
 * 	To get the complete list of the software discovered for one server:
 * 	- First, the discover_repository must have been created, which implements the DDBB connection.
 * 	- Second: create an object using the discover_server class.
 * 	Now, this object has all the services into the associative array $obj[<port_number>].
 */

	class os {
		public $name;
		public $type;
		public $vendor;
		public $osfamily;
		public $fingerprint;
	}

	/**
	 * servers
	 *
	 * Table definition:
	 *
	 * +-----------+--------------+------+-----+---------+----------------+
	 * | Field     | Type         | Null | Key | Default | Extra          |
	 * +-----------+--------------+------+-----+---------+----------------+
	 * | id_server | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	 * | hostname  | varchar(60)  | NO   | UNI |         |                |
	 * | ip        | varchar(20)  | YES  |     | NULL    |                |
	 * +-----------+--------------+------+-----+---------+----------------+
	 */
	class server {
		public $id_server;
		public $hostname;
		public $ip;

		public function server() {
		}
	}

	/**
	 * current_sevices
	 *
	 * Each of the services of each server
	 *
	 * This table host the last discover results
	 *
	 * +-------------+--------------+------+-----+-------------------+----------------+
	 * | Field       | Type         | Null | Key | Default           | Extra          |
	 * +-------------+--------------+------+-----+-------------------+----------------+
	 * | id_service  | mediumint(9) | NO   | PRI | NULL              | auto_increment |
	 * | id_server   | mediumint(9) | NO   |     |                   |                |
	 * | d_date      | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
	 * | port        | int(11)      | NO   |     |                   |                |
	 * | protocol    | char(10)     | NO   |     |                   |                |
	 * | state       | varchar(10)  | YES  |     | NULL              |                |
	 * | name        | varchar(255) | YES  |     | NULL              |                |
	 * | product     | varchar(255) | YES  |     | NULL              |                |
	 * | version     | varchar(255) | YES  |     | NULL              |                |
	 * | extrainfo   | varchar(255) | YES  |     | NULL              |                |
	 * | ostype      | varchar(255) | YES  |     | NULL              |                |
	 * | fingerprint | text         | YES  |     | NULL              |                |
	 * | deleted     | int(11)      | NO   |     | 0                 |                |
	 * | revision    | int(11)      | NO   |     | 0                 |                |
	 * +-------------+--------------+------+-----+-------------------+----------------+
	 */

	class server_service {

		public $id_service;
		public $id_server;
		public $d_date;
		public $port;
		public $protocol;
		public $state;
		public $name;
		public $product;
		public $version;
		public $extrainfo;
		public $ostype;
		public $fingerprint;
		public $deleted;
		public $revision;

		public function server_service($id_server) {
			$this->id_server= $id_server;
			$this->deleted=0;
			$this->revision=0;
		}

		public function show() {
			$format="%-5s %-5s %-6s %-12s %-18 %-18 %-10s %-6s\n";

			printf($format, $this->port, $this->protocol, $this->state, $this->name, $this->product, $this->version, $this->extrainfo, $this->ostype);
		}
	}


	/**
	 *
	 * Discover service implements each discover database server. It needs a host, database, username and password.
	 */
	class discover_repository {

		/**
		 * Database server for discover repository
		 *
		 * @var dbms
		 */
		public $discover_db;

		public $report;

		private	$host;
		private $type;
		private	$database;
		private	$username;
		private	$password;

		public function discover_repository($host, $type, $database, $username, $password) {
			$this->host= $host;
			$this->type= $type;
			$this->database= $database;
			$this->username= $username;
			$this->password= $password;

			require_once SYSHOME . "/include/dbms/" . $type . ".class.php";
			$dbtype= $type . "_class";
			$this->discover_db= new $dbtype() or die("ERROR: couldn't create DBMS Object");
			$this->discover_db->dbms_connect($host, $username, $password, false, true) or die("Cant connect to discover database server on $host");
			$this->discover_db->dbms_select_db($database) or die("Cant connect to discover database $database.");
		}

		public function __destruct() {
			$this->discover_db->dbms_close();
		}

		public function & get_server($id_server) {

			$query="select * from servers where id_server='$id_server'";

			$res= $this->discover_db->dbms_query($query);
			if(!$res or ($this->discover_db->dbms_num_rows($res)==0)) {
				$null_ref= null;
				return $null_ref;
			}

			$ret= new server();
			list($ret->id_server, $ret->hostname, $ret->ip)= $this->discover_db->dbms_fetch_row($res);
			$this->discover_db->dbms_free_result($res);

			return $ret;
		}

		public function & get_service($id_service) {

			$null_ref=null;
			$query="select * from current_services where id_service='$id_service'";

			$res= $this->discover_db->dbms_query($query);
			if(!$res or ($this->discover_db->dbms_num_rows($res)==0)) return $null_ref;

			$ret= new server_service(0);
			list($ret->id_service,
				 $ret->id_server,
				 $ret->d_date,
				 $ret->port,
				 $ret->protocol,
				 $ret->state,
				 $ret->name,
				 $ret->product,
				 $ret->version,
				 $ret->extrainfo,
				 $ret->ostype,
				 $ret->fingerprint,
				 $ret->deleted,
				 $ret->revision)= $this->discover_db->dbms_fetch_row($res);
			$this->discover_db->dbms_free_result($res);

			return $ret;
		}

	}

	/**
	 * The class for each server discovered.
	 *
	 */
	class discover_server {

		public $id_server;
		public $server_name;
		public $found;

		// All those properties will be filled from discover tools
		public $server_hostname;
		public $server_ip;
		public $server_services;
		public $new_services;

		public $os;
		public $has_os;

		// For reporting tasks
		public $time_spent;
		public $report;

		protected $discover_repository;

		private $attribs;

		public function discover_server($server_name, &$discover_repository=null) {

			$this->discover_repository= $discover_repository;
			$this->server_name= $server_name;
			$this->found=true;

			$this->os= new os();
			$this->has_os=false;
			$this->time_spent=0;

			$this->report="";

			$this->server_services= array();

			if($this->server_name!="" and !is_null($this->discover_repository)) {
				if(($this->id_server= $this->get_id_server()) != -1) {
					$this->load_software_list();
				}
			}

			// Which ojbect fields will be looked to decide if there are diferences?
			$this->attribs= array("protocol","state","name","product","version","extrainfo","ostype","fingerprint","deleted");
		}

		/**
		 * Set the property "server_name" of the object, also get the software list for it.
		 *
		 * @param string $server_name
		 */
		public function set_server_name($server_name) {

			$this->server_name= $server_name;
			$this->id_server= $this->get_id_server();

			if($this->id_server != -1) $this->load_software_list();
		}

		/**
		 * Try to get the server id, if doesn't exists, then create a new server.
		 * If all goes right the return value is the new id for this server, else return value is -1
		 *
		 * @return integer
		 */
		protected function get_id_server() {

			if($this->server_name=="" or is_null($this->discover_repository)) return -1;

			$query= "select id_server from servers where hostname='" . $this->server_name . "'";
			$res= $this->discover_repository->discover_db->dbms_query($query);

			if($this->discover_repository->discover_db->dbms_num_rows($res)==0) {
				return -1;
			} else {
				list($id_server)= $this->discover_repository->discover_db->dbms_fetch_row($res);
				$this->discover_repository->discover_db->dbms_free_result($res);
				return $id_server;
			}
		}

		/**
		 * Add this server on the "servers" table.
		 * If all goes right the return value is the new id for this server, else return value is -1
		 *
		 * @return integer
		 */
		public function add_server() {

			if($this->server_name=="" or is_null($this->discover_repository)) return -1;

			$query="insert into servers (hostname,ip) values ('" . $this->server_name . "','" . $this->server_ip . "')";
			if(!$this->discover_repository->discover_db->dbms_query($query)) return -1;

			$this->id_server= $this->get_id_server();
			return $this->id_server;
		}

		/**
		 * Delete the server from the "servers" table.
		 * If all goes right the return value is 1, else return value is -1
		 *
		 * @return integer
		 */
		public function delete_server() {

			if($this->server_name=="" or is_null($this->discover_repository)) return -1;

			$query="delte from servers where hostname='" . $this->server_name . "'";
			if(!$this->discover_repository->discover_db->dbms_query($query)) return -1;

			return 1;
		}

		/**
		 * For current server (must have set the server_name and the discover reposity). For current server
		 * get the software list from the "current_services" table.
		 * If all goes right the return value is 1, else return value is -1
		 *
		 * @return integer
		 */
		public function load_software_list() {

			if($this->server_name=="" or $this->id_server=="" or is_null($this->discover_repository)) return -1;

			$query= "select * from current_services where id_server='" . $this->id_server . "'";
			$res= $this->discover_repository->discover_db->dbms_query($query);

			while($row= $this->discover_repository->discover_db->dbms_fetch_array($res)) {

				$port= $row["port"];
				if($port == "") continue;

				$this->server_services[$port]= new server_service($this->id_server);

				$class_vars = get_class_vars("server_service");
				foreach ($class_vars as $key => $value) {
					$this->server_services[$port]->$key= $row[$key];
				}
			}

			$this->discover_repository->discover_db->dbms_free_result($res);
			return 1;
		}

		/**
		 * Saves the current software list of the server on the "current_services" table.
		 * For each new discovered service, if is a new service, then insert it,
		 * If is an existent service but have differences, then update the service data.
		 *
		 * If all goes right the return value is 1, else return value is -1
		 *
		 * @return integer
		 */
		public function save_software_list() {

			$this->report.="<PARAGRAPH>Services report for host <BOLD>$this->server_name</BOLD><LINE_BREAK><LINE_BREAK>";

			if($this->server_name=="" or is_null($this->discover_repository)) return -1;
			if(!$this->found) return -1;

			if($this->id_server == -1)
				if(!$this->add_server()) die("Couldn't add server.");

			// First, check for saved services vs discovered services, to delete not available services.
			foreach($this->server_services as $port => $service) {
				if(!isset($this->new_services[$port])) {
					$this->report.=" * [DELETE] Service name " . $service->name . " (port $port) not found.<LINE_BREAK>";
					$this->delete_service($port);
				}
			}

			// Second, check for discovered services vs saved services, for insert new or update existent.
			if(isset($this->new_services)) {
				foreach($this->new_services as $port => $service) {
					// Is a new service
					if(!isset($this->server_services[$port])) {
						$this->report.=" * [NEW]  A new service found: " . $service->name . " at port $port<LINE_BREAK>";
						$this->insert_new_service($service);
					} else {
						// Is not new, but have been detected updates from current service
						if($this->diff_services($service, $this->server_services[$port])) {
							$this->report.=" * [UPD]  The service " . $service->name . " at port $port has changed.<LINE_BREAK>";
							$this->update_service($service);
						} else {
							$this->report.=" * [NOP]  The service " . $service->name . " at port $port has not changed.<LINE_BREAK>";
						}
					}
				}
			}

			$this->report.="</PARAGRAPH>";
			return 1;
		}

		protected function insert_new_service($service) {

			$query_i="insert into current_services (id_server, d_date, port, protocol, " .
					"state, name, product, version, extrainfo, ostype, fingerprint, deleted, revision) " .
					"values (" .
					$this->id_server . "," .
					"now()," .
					"'" . $service->port . "'," .
					"'" . $service->protocol . "'," .
					"'" . $service->state . "'," .
					"'" . $service->name . "'," .
					"'" . $service->product . "'," .
					"'" . $service->version . "'," .
					"'" . $service->extrainfo . "'," .
					"'" . $service->ostype . "'," .
					"'" . $service->fingerprint . "'," .
					"0," .
					"0)";

			if(!$this->discover_repository->discover_db->dbms_query($query_i)) {
				$this->report.=" ** ERROR inserting.<LINE_BREAK>";
				echo $this->discover_repository->discover_db->dbms_error();
				return 0;
			}
			return 1;
		}

		/**
		 * Given a service, will update the existent service for port and host.
		 *
		 * @param unknown_type $service
		 * @return unknown
		 */
		protected function update_service($service) {

			$query_u= "update current_services set deleted='0'";
			$query_u.= ", revision = (revision + 1) ";	// Upgrade row version

			foreach($this->attribs as $attr) {
				$query_u.= ", $attr = '" . $service->$attr . "'";
			}

			$query_u.= " where id_server='" . $this->id_server . "' and port='" . $service->port . "'";

			if(!$this->discover_repository->discover_db->dbms_query($query_u)) {
				$this->report.=" ** ERROR updating.<LINE_BREAK>";
				return 0;
			}
			return 1;
		}

		protected function delete_service($port) {

			// Option 1: delete the row
			// $query_d="delete from current_services where id_server='" . $this->id_server . "' and port='$port'";
			// Option 2: mark as deleted
			$query_d= "update current_services set deleted = '1', revision = (revision + 1) where id_server='" . $this->id_server . "' and port='$port'";

			if(!$this->discover_repository->discover_db->dbms_query($query_d)) {
				$this->report.=" ** ERROR deleting.<LINE_BREAK>";
				return 0;
			}

			return 1;
		}

		/**
		 * Check for differences between service1 and service2
		 * Returns 0 if they are equal and 1 if they are different.
		 *
		 * @param server_service $service1
		 * @param server_service $service2
		 * @return boolean
		 */
		protected function diff_services($service1, $service2) {

			$diff=false;
			foreach($this->attribs as $attr) {
				if($service1->$attr != $service2->$attr) {
					$diff= true;
					$this->report.=
						" ** [DIF] On service " . $service1->name . " has changed, at least, the field <BOLD>$attr</BOLD>:<LINE_BREAK>" .
						" ** [DIF] Old value: " . $service1->$attr . "<LINE_BREAK>" .
						" ** [DIF] New value: " . $service2->$attr . "<LINE_BREAK>";
					break;
				}
			}

			return $diff;
		}
	}

?>