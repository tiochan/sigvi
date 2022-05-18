<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage vulnerabilities
 *
 * vulnerability notification class
 *
 */


/*
	Table definition:

	+----------------------+--------------+------+-----+---------------------+----------------+
	| Field                | Type         | Null | Key | Default             | Extra          |
	+----------------------+--------------+------+-----+---------------------+----------------+
	| id_alert             | mediumint(9) |      | PRI | NULL                | auto_increment |
	| id_server            | mediumint(9) |      | MUL | 0                   |                |
	| id_product           | mediumint(9) |      |     | 0                   |                |
	| vuln_id              | varchar(50)  |      |     | 0                   |                |
	| creation_date        | datetime     |      |     | 0000-00-00 00:00:00 |                |
	| status               | tinyint(4)   | YES  |     | NULL                |                |
	| final_alert_severity | tinyint(4)   | YES  |     | NULL                |                |
	| observations         | text         | YES  |     | NULL                |                |
	| vuln_modified        | tinyint(4)   | YES  |     | NULL                |                |
	+----------------------+--------------+------+-----+---------------------+----------------+
*/

	require_once MY_INC_DIR . "/classes/vulnerability.class.php";

	class notification {

		public $alert_id;

		public $status;
		public $vuln_modified;

		public $server_name;
		public $id_group;
		public $product_name;
		public $fas;
		public $vuln_info;
		public $users_email;

		public $id_server;
		public $id_product;
		public $vuln_id;

		function notification($alert_id) {
			global $global_db;
			global $MESSAGES;

			$this->alert_id= $alert_id;

			$query="select id_server, id_product, vuln_id, status, vuln_modified, final_alert_severity from alerts where id_alert = $this->alert_id";
			$res= $global_db->dbms_query($query);

			if(!$res) {
				return 0;
			}
			list($this->id_server, $this->id_product, $this->vuln_id, $this->status, $this->vuln_modified, $this->fas) = $global_db->dbms_fetch_row($res);
			$global_db->dbms_free_result($res);
			$this->get_alert_info();

		}

		function notify() {
			global $global_db;

			$sent=false;

			if($this->status == 0) {
				// Send a new alert notification...
				$sent=$this->send_new_notifications();

				if($sent) {
					$query_update="update alerts set status=1 where id_alert=$this->alert_id";
					$global_db->dbms_query($query_update);
				}

			} elseif ($this->vuln_modified == 1) {
				// Notify that vuln has been upgraded...

				$sent=$this->send_updated_notifications();
				if($sent) {
					$query_update="update alerts set vuln_modified=0 where id_alert=$this->alert_id";
					$global_db->dbms_query($query_update);
				}
			}

			return $sent;
		}

		/**
		 * Abstract
		 * To define in inherited classes (/notification_methods/*)
		 */
		/*
		function send_new_notifications() {
		}
		*/

		/**
		 * Abstract
		 * To define in inherited classes (/notification_methods/*)
		 */
		/*
		function send_updated_notifications() {
		}
		*/

		function get_alert_info() {
			global $global_db;

			// Collect all information for notification:

			// 1. Server info:
			$query="select name, id_group from servers where id_server = $this->id_server";
			$res= $global_db->dbms_query($query);
			if(!$res) {
				html_showError("ERROR consulting server name");
				return 0;
			}
			list($this->server_name, $this->id_group)= $global_db->dbms_fetch_row($res);
			$global_db->dbms_free_result($res);

			// 2. Product info:
			$query="select full_name from products where id_product = $this->id_product";
			$res= $global_db->dbms_query($query);
			if(!$res) {
				html_showError("ERROR consulting product name");
				return 0;
			}
			list($this->product_name)= $global_db->dbms_fetch_row($res);
			$global_db->dbms_free_result($res);

			// 3. Vulnerability info
			$this->vuln_info= new short_vuln_info($global_db, $this->vuln_id);

			// 4. Users to send notifications:
			$this->users_email= array();
			$query="select email from users where id_group = $this->id_group and send_notifications=1";
			$res= $global_db->dbms_query($query);
			if(!$res) {
				html_showError("WARNING: No users found on group\n");
				return 0;
			}

			$i=0;
			while($row= $global_db->dbms_fetch_row($res)) {
				$this->users_email[$i++]=$row[0];
			}
			$global_db->dbms_free_result($res);
		}
	}
?>