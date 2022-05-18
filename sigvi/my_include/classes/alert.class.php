<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage alerts
 *
 * Alert definition class
 *
 */


/*
	Table definition

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
	+----------------------+--------------+------+-----+---------------------+----------------+
*/

	include_once INC_DIR . "/menu.inc.php";
	include_once MY_INC_DIR . "/classes/fas.class.php";


	class alert {

		public $id_server;
		public $id_product;
		public $vuln_id;
		public $creation_date;
		public $status;				// Status values: [0 - 5] (not sent, open, pending, solved, discarded, doubt)
		public $fas;				// Final Alert Severity [0-10] (less important - most important)
		public $observations;

		/**
		 * Alert constructor
		 *
		 * @PARAM integer $id_source, references the server
		 * @PARAM integer $id_server_product, references the association between the server and the product
		 * @PARAM integer $vuln_id, references the vulnerability
		 */
		function alert($id_server_product, $vuln_id) {

			global $global_db;

			$this->vuln_id=$vuln_id;

			// Get server and product identifiers
			$query="select id_server, id_product, critic, filtered from server_products where id_server_product = $id_server_product";
			$res= $global_db->dbms_query($query);

			if(!$global_db->dbms_check_result($res)) {
				html_showError("ERROR: alert, id_server_product doesn't exists");
				return;
			}

			$row=$global_db->dbms_fetch_array($res);
			$global_db->dbms_free_result($res);

			$this->id_server=$row["id_server"];
			$this->id_product=$row["id_product"];
			$service_criticity=$row["critic"];
			$service_filtered=$row["filtered"];

			// Get vulnerability information
			$vuln= new short_vuln_info($global_db, $vuln_id);

			// Own alert creation date
			$date= getdate();
			$this->creation_date=$date["year"] . "-" . $date["mon"] . "-" . $date["mday"];

			$this->fas= get_alert_level($this->id_server, $service_criticity, $service_filtered, $vuln);
		}


		/**
		 * Reset Alert fields
		 *
		 */
		function reset() {
			$this->id_server= -1;
			$this->id_product= -1;
			$this->vuln_id= -1;
		}


		/**
		 * echo the value of every field.
		 *
		 */
		function show_contents() {

			$class_vars = get_object_vars($this);

			foreach ($class_vars as $name => $value) {
				echo "<b>$name:</b> $value<br>\n";
			}

			echo "<hr>\n";
		}


		/**
		 * Start alert process...
		 *
		 */
		function store_it() {

			global $global_db;

			// If any of the parameters is not set, return error
			if(($this->id_server == -1) or ($this->id_product == -1) or ($this->vuln_id == -1)) {
				echo "$this->id_server, $this->id_product, $this->vuln_id<br>";
				return 0;
			}

			// Check if this alert just exists

			$query="select * from alerts
					where id_server='$this->id_server' and
						  id_product='$this->id_product' and
						  vuln_id='$this->vuln_id'";

			$res= $global_db->dbms_query($query);
			if($global_db->dbms_check_result($res)) {
				// Exists, don't insert again.
				return 0;
			}

			// Check if this alert is a real positive or if there is any doubt:
			// - In a first check, if there is more than one vendor in the product list of
			//   the vulnerability, the alert is stored as "DOUBT". Else, is stored as "NOT SENT"
			include_once MY_INC_DIR . "/classes/vulnerability.class.php";
			$svi= new short_vuln_info($global_db, $this->vuln_id);

			$vendors=Array();
			$svi->get_vendors_array($vendors);

			$initial_status= count($vendors) > 1 ? 5:0; // Status 0 == Not sent, status 5 == doubt

			// Then insert the alert into the alerts table
			$query="insert into alerts ( id_server, id_product, vuln_id, creation_date, status, final_alert_severity ) " .
				   "values ('" . $this->id_server . "','"  . $this->id_product . "','" . $this->vuln_id . "','" . $this->creation_date . "'," . $initial_status . ", " . $this->fas . ")";

			if(!$global_db->dbms_query($query)) {
				echo "Error inserting alert: $query<br>";
				echo $this->db->dbms_error() . "<br>";
				return 0;
			}

			return 1;

			// The notifications are sent once the process of determine alerts is finished.

		}
	}

	/**
	 *    GENERAL ALERT LEVEL  --> FINAL ABSOLUTE SEVERITY (FAS)
	 *
	 *    This is one of the more critical points all over the application: define the criticity of
	 *    a vulnerability on one server.
	 *
	 *    We have four variables to determine it:
	 *
	 *     - The criticity of the service
	 *     - Is the service filtered
	 *     - Severity of the vulnerability
	 *     - Access required to exploid the vulnerability
	 *
	 *    Of course is not the same a non critical and filtered service affected
	 *    by a low severity vulnerability than a critical and non filtered service affected
	 *    by a high severity vulnerability.
	 *
	 *    This function evaluates these variables and determine the absolute criticity to
	 *    help the administrators to detect the "run to solve" situations.
	 *
	 *    FORMULA
	 *
	 *    Possible values for:
	 *    - affected service criticity: 0 (service not critical), 1 (service is critical)
	 *    - filted service: 0 (service is not filtered), 1 (service is filtered)
	 *    - vulnerability severity: null (informational only), low, med, high
	 *    - vulnerability requirements:
	 *          · ar_launch_remotely: 1 (vulnerability can be exploided remotely)
	 *          · ar_launch_locally: 1 (vulnerability must be exploided locally)
	 *        This parameter will be resumed in one: access_factor.
	 *
	 *    Access factor
	 *    -----------------------------------------------------
	 *    Usually, vulnerabilities that requires local access are deprecated in an environment
	 *    that don't support local external users (like web servers, database servers, ...)
	 *    In our particular environment we give more importance to a vulnerability that don't
	 *    requires local access that other.
	 *
	 *    This aspect is represented on the variables ar_launch_remotely and ar_launch_locally. Its valid values are 0 and 1.
	 *
	 *     $access_factor = (ar_lauch_remotely == 1) ? 2:1; // initially is the same that $access_factor= ar_launch_remotely + 1
	 *
	 *    values are 2,1 (2 --> launch remotely, 1 --> launch is local)
	 *
	 *
	 *    Service criticity
	 *    -----------------------------------------------------
	 *    Is more vulnerable a filtered service than other one.
	 *    So, we must use this. See next table to understand the values:
	 *
	 *    First convert the server_fitered to its negative value, to set 1 when the service is not filtered
	 *
	 *    service_not_filtered   service_critical   value
	 *              0                  0              1
	 *              0                  1              2
	 *              1                  0              3
	 *              1                  1              4
	 *
	 *    The last values are more critical than firsts.
	 *    It results into a binary value with 2 bits. To create it:
	 *
	 *      $service_absolute_criticity = (($service_not_filtered << 1 ) | $service_critical) + 1  (final values are 1 - 4)
	 *
	 *    Vulnerability severity
	 *    -----------------------------------------------------
	 *    Valid values are: "high", "med", "low", "info" (other).
	 *
	 *    For each value we associate an integer to determine it priority:
	 *      $vuln_absolute_severity =
	 *     - "high" --> 4
	 *     - "med"  --> 3
	 *     - "low"  --> 2
	 *     - "info" --> 1
	 *
	 *     FINALLY
	 *     -----------------------------------------------------
	 *     All factors must be included in the formula to determine the absolute value:
	 *
	 *          $A = $service_absolute_criticity;
	 *          $B = $vuln_absolute_severity;
	 *          $C = $access_factor;
	 *
	 *          // sf_a, sf_b and sf_c are scaling factors.
	 *
	 *          // op_1, op2 and op3 are the operations for calculate the final value.
	 *
	 *          $ALERT_ABSOLUTE_LEVEL = (sf_a * $A) op_1 (sf_b * $B) op_2 (sf_c * $C)
	 *
	 *     IMPORTANCE OF EACH FACTOR
	 *     -----------------------------------------------------
	 *     This is the order to determine the final absolute severity (FAS):
	 *
	 *      - If local access is required --> the FAS will be low, ( <= 5 )
	 *      - Else --> the FAS will be high ( > 5 )
	 *
	 *     max(service_absolute_criticity)=4
	 *     max(vuln_absolute_severity)=4
	 *
	 *     4 + 4 = 8. Assuming that we want to return a value between 0 and 10, it will be scaled to 5.
	 *     So:
	 *       The scaling factor for service_absolute_criticity is " * (5/8) "
	 *       The scaling factor for  is vuln_absolute_severity " * (5/8) "
	 *
	 *
	 *     The scaling factor for access_factor is " * 5 ".
	 *
	 *     THEN:
	 *
	 *     Final Alert Severity
	 *     -----------------------------------------------------
	 *
	 *     +------------------------------------+
	 *     | FAS = 5/8 * $A + 5/8 * $B + 5 * $C |
	 *     +------------------------------------+
	 *
	 *     Getting the worst case, that we have a service is critical and is not filtered, affected by
	 *     a high severity vulnerability that don't requires local access we have:
	 *
	 *     5/8 * 4 + 5/8 * 4 + 5 * 1 = 20/8 + 20/8 + 5 = 5 + 5 = 10.
	 *
	 */

	/**
	 * Return the FAS (Final Absolute Severity)
	 *
	 * @param integer $id_server
	 * @param boolean $service_criticity
	 * @param boolean $service_filtered
	 * @param short_vuln_info $vuln
	 * @return integer
	 */
	function get_alert_level($id_server, $service_criticity, $service_filtered, $vuln) {

		// If the vulnerability doesn't has CVSS vector
		if($vuln->cvss == null) {
			$service_not_filtered= $service_filtered == 0? 1:0;

			$service_absolute_criticity= (($service_not_filtered << 1 ) | $service_criticity) + 1;

			switch(strtolower($vuln->severity)) {
				case "high":
					$vuln_absolute_severity=4;
					break;
				case "med":
				case "medium":
				case "mid":
					$vuln_absolute_severity=3;
					break;
				case  "low":
					$vuln_absolute_severity=2;
					break;
				default:
					$vuln_absolute_severity=1;
			}

			$access_factor = ($vuln->ar_launch_remotely == 1) ? 1:0;

			$FAS= ((5 * $service_absolute_criticity) / 8) + (( 5 * $vuln_absolute_severity) / 8) + (5 * $access_factor);

		} else {							// Else use group FAS function
			$fas_to_use= get_fas($id_server);

			$my_fas= new fas($fas_to_use);
			$FAS= $my_fas->parse_fas($vuln->cvss, $service_filtered, $service_criticity);
		}

		return $FAS;
	}

	/**
	 * For every alert not sent, and every alert which vulnerability has been updated, send the notification to the group.
	 *
	 * @return notifications_sent, the number of notifications that have been sent.
	 */
	function send_notifications() {

		global $global_db;

		$query="select * from notification_methods where use_it=1";
		$notif_methods= $global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($notif_methods)) {
			html_showError("WARNING: no notification methods active");
			return 0;
		}

		while($nm = $global_db->dbms_fetch_array($notif_methods)) {
			
			$module= $nm["module"];
			
			if(!file_exists(SYSHOME . "/plugins/notification_methods/" . $module)) {
				html_showError("ERROR: notification module '$module' not found at " . SYSHOME . "/plugins/notification_methods/");
			} else {

				require_once SYSHOME . "/plugins/notification_methods/" . $module;

				$query="select id_alert from alerts where status=0 or vuln_modified = 1";
				$res= $global_db->dbms_query($query);
				if(!$res) {
					html_showInfo("No un-notified alerts found.");
					return 0;
				}

				$cont=0;

				while($row= $global_db->dbms_fetch_row($res)) {

					$id_alert= $row[0];

					$notif= new notification_ext($id_alert);
					if($notif->notify()) {
						$cont++;
					}
				}
				$global_db->dbms_free_result($res);
			}
		}

		$global_db->dbms_free_result($notif_methods);

		return $cont;
	}
	
	function send_grouped_notifications() {
		
		global $global_db, $MESSAGES;
		
		
		$query_groups="select id_group, name from groups";
		$res_groups= $global_db->dbms_query($query_groups);

		while(list($id_group, $group_name)= $global_db->dbms_fetch_row($res_groups)) {

			$query_alerts="
				SELECT
					alerts.id_alert,
					alerts.id_server,
					servers.name,
					products.full_name,
					alerts.vuln_id,
					alerts.final_alert_severity,
					alerts.status,
					alerts.vuln_modified
				FROM
					alerts,
					servers,
					products
				WHERE
					servers.id_group = '" . $id_group . "' AND
					alerts.id_server = servers.id_server AND
					alerts.id_product = products.id_product AND
					(alerts.status=0 OR alerts.vuln_modified = 1)
				ORDER BY servers.name ASC, alerts.final_alert_severity DESC
			";
			
			$alerts_report="";
			
			$res_alerts= $global_db->dbms_query($query_alerts);
			
			$cont=0;
			$current_server="";
			$alerts_id=array();
			while($row= $global_db->dbms_fetch_row($res_alerts)) {

				$id_alert=    $row[0];
				$id_server=   $row[1];
				$server_name= $row[2];
				$product=     $row[3];
				$vuln_id=     $row[4];
				$fas=         $row[5];
				$status=      $row[6];
				$updated=     $row[7];

				$alerts_ids[]=$id_alert;
				
				$is_update= $updated ? $MESSAGES["UNIQ_NOTIFICATION_UPDATED"] : $MESSAGES["UNIQ_NOTIFICATION_NEW"];
				$color=fas_get_color($fas);
				
				if($server_name != $current_server) {
					$current_server=$server_name;
					$alerts_report.="<TR class='report'><TD class='report' colspan=5 id='success'><B>$server_name</B></TD></TR>";
				}
				
				// Now create the alert info:
				$alerts_report.="<TR class='report' BGCOLOR='$color'>
					<TD class='report'><a href='" . SERVER_URL . "/admin/server_alerts.php?tab_1_tab_selected=tab_alerts&sb_search_alerts_search_alerts_id_server=$id_server'>$server_name</TD>
					<TD class='report'>$product</TD>
					<TD class='report'><a href='http://nvd.nist.gov/nvd.cfm?cvename=$vuln_id'>$vuln_id</A></TD>
					<TD class='report'>$fas</TD>
					<TD class='report'>$is_update</TD>
					</TR>";

				$cont++;
			}
			
			$global_db->dbms_free_result($res_alerts);
			
			if($alerts_report=="") continue;
			
			$group_subject=$MESSAGES["UNIQ_NOTIFICATION_SUBJECT"];
			
			$group_title= sprintf($MESSAGES["UNIQ_NOTIFICATION_ALERT_TITLE"], $cont);
			
			$group_report="<P>$group_title</P>";
			$group_report.="<P>" . $MESSAGES["UNIQ_NOTIFICATION_INFO"] . "</P>";
			$group_report.="<hr><br>";

 			$group_report.="<P><TABLE class='report'>";
			$group_report.="<TH class='report'>" . $MESSAGES["UNIQ_NOTIFICATION_SERVER_NAME"] . "</TH>";
			$group_report.="<TH class='report'>" . $MESSAGES["UNIQ_NOTIFICATION_PRODUCT_NAME"] . "</TH>";
			$group_report.="<TH class='report'>" . $MESSAGES["UNIQ_NOTIFICATION_VULN_ID"] . "</TH>";
			$group_report.="<TH class='report'>" . $MESSAGES["UNIQ_NOTIFICATION_FAS"] . "</TH>";
			$group_report.="<TH class='report'>" . $MESSAGES["UNIQ_NOTIFICATION_NEW"] . "/" . $MESSAGES["UNIQ_NOTIFICATION_UPDATED"] . "</TH>";

			$group_report.=$alerts_report;
			$group_report.="</TABLE></P>";

			require_once SYSHOME . "/include/mail.inc.php";
			if(send_group_mail($id_group, $group_subject, $group_report, "html")) {

				// Finally, change alert status
				foreach($alerts_ids as $alert_id) {
					$query_update="update alerts set alerts.status=1, alerts.vuln_modified=0 where alerts.id_alert='$alert_id'";
					$global_db->dbms_query($query_update);
				}
			}
		}
		
		$global_db->dbms_free_result($res_groups);

		return 1;
	}

	function alerts_get_alerts_to_validate() {
		global $global_db;
		global $USER_GROUP;
		global $USER_LEVEL;

		$restriction= $USER_LEVEL!=0 ? "and servers.id_group=$USER_GROUP":"";

		$query="select count(*) from alerts, servers where servers.deleted='0' and servers.id_server = alerts.id_server and alerts.status=5 $restriction";
		$res=$global_db->dbms_query($query);

		if(!$res) {
			return 0;
		}

		list($ret)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $ret;
	}
	
	function alerts_autovalidate(&$output) {
		global $global_db;
		
		$period= get_app_param("auto_validate_after");
		if(!$period) {
			$output="No period defined for alert autovalidation.";
			return false;
		}
		
		$current_timestamp_query= $global_db->dbms_get_current_timestamp_query();
		$date_add_query= $global_db->dbms_date_add_query($current_timestamp_query, $period);
		$query="update alerts set status='0' where status='5' and creation_date < $date_add_query";

		$res= $global_db->dbms_query($query);
		

		$rows= $global_db->dbms_affected_rows();
		if(!$rows) {
			$output="No alerts validated.";
		} else {
			$output="Alerts validated: " . $rows;
		}
		
		return true;
	}

	function alerts_get_pending_alerts() {
		global $global_db;
		global $USER_GROUP;
		global $USER_LEVEL;

		$restriction= $USER_LEVEL!=0 ? "and servers.id_group=$USER_GROUP":"";

		$query="select count(*) from alerts, servers where servers.id_server = alerts.id_server and (alerts.status=0 or alerts.status=1 or alerts.status=3) $restriction";
		$res=$global_db->dbms_query($query);

		if(!$res) {
			return 0;
		}

		list($ret)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		return $ret;
	}

	// Show the current status of the servers vulnerabilities
	function alerts_show_servers_status($show_header= true, $show_content=true, $show_all_servers=false) {

		global $MESSAGES;
		global $global_db;
		global $USER_GROUP;
		global $USER_LEVEL;
		global $GLOBAL_HEADERS;
		
		$GLOBAL_HEADERS["form_elements"]="<link rel='stylesheet' type='text/css' href='" . HOME . "/include/styles/form_elements.css'>";
		
		$server_status_table="";

		$where= $USER_LEVEL > 0 ? "and servers.id_group=$USER_GROUP" : "";
		$query_servers="select servers.id_server, servers.name from servers where servers.deleted='0' $where order by servers.name";

		$query_high="select count(*) as 'total' from alerts where alerts.id_server = %d and alerts.final_alert_severity >= " . FAS_HIGH_SEVERITY . " and (alerts.status=0 or alerts.status=1 or alerts.status=3)";
		$query_medium="select count(*) as 'total' from alerts where alerts.id_server = %d and alerts.final_alert_severity < " . FAS_HIGH_SEVERITY . " and alerts.final_alert_severity>= " . FAS_MED_SEVERITY . " and (alerts.status=0 or alerts.status=1 or alerts.status=3)";
		$query_low="select count(*) as 'total' from alerts where alerts.id_server = %d and alerts.final_alert_severity < " . FAS_MED_SEVERITY . " and (alerts.status=0 or alerts.status=1 or alerts.status=3)";

		$res=$global_db->dbms_query($query_servers);

		if($show_header) $server_status_table= "<h3>" . $MESSAGES["SERVER_STATUS"] . "</h3>";

		$server_status_table.= "

			<table class='data_box_external' width='450'><tr><td colspan='3'>
			<table class='data_box_rows' width='100%' cellspacing='0'>
            	<th class='data_box_rows'><b>" . $MESSAGES['SERVER'] . "</b></th>
            	<th class='data_box_rows' bgcolor='" . FAS_HIGH_SEVERITY_COLOR . "'>" . $MESSAGES['HIGH_RISK'] . "</th>
            	<th class='data_box_rows' bgcolor='" . FAS_MED_SEVERITY_COLOR . "'>" . $MESSAGES['MED_RISK'] . "</th>
            	<th class='data_box_rows' bgcolor='" . FAS_LOW_SEVERITY_COLOR . "'>" . $MESSAGES['LOW_RISK'] . "</th>
            	<th class='data_box_rows'>" . $MESSAGES['TOTAL'] . "</th>
";

		while($row=$global_db->dbms_fetch_row($res)) {
			$server_id= $row[0];
			$server_name= $row[1];

			$query_tmp= sprintf($query_high, $server_id);
			$res2= $global_db->dbms_query($query_tmp);
			if($global_db->dbms_check_result($res2)) {
				$row2= $global_db->dbms_fetch_row($res2);
				$high= $row2[0];
				$global_db->dbms_free_result($res2);
			} else {
				$high=0;
			}

			$query_tmp= sprintf($query_medium, $server_id);
			$res2= $global_db->dbms_query($query_tmp);
			if($global_db->dbms_check_result($res2)) {
				$row2= $global_db->dbms_fetch_row($res2);
				$med= $row2[0];
				$global_db->dbms_free_result($res2);
			} else {
				$med=0;
			}

			$query_tmp= sprintf($query_low, $server_id);
			$res2= $global_db->dbms_query($query_tmp);
			if($global_db->dbms_check_result($res2)) {
				$row2= $global_db->dbms_fetch_row($res2);
				$low= $row2[0];
				$global_db->dbms_free_result($res2);
			} else {
				$low=0;
			}

			$total= $high + $med + $low;
			if($show_all_servers or ($total > 0)) {
				$server_status_table.= "
				<tr class='data_box_rows_tabular_odd'>
					<td class='data_box_cell'><a href='" . SERVER_URL . HOME . "/admin/server_alerts.php?tab_1_tab_selected=tab_alerts&sb_search_alerts_search_alerts_id_server=" . $server_id . "'>". $server_name . "</a></TD>
					<td class='data_box_cell' bgcolor='" . FAS_HIGH_SEVERITY_COLOR . "'>" . $high . "</TD>
					<td class='data_box_cell' bgcolor='" . FAS_MED_SEVERITY_COLOR . "'>" . $med . "</TD>
					<td class='data_box_cell' bgcolor='" . FAS_LOW_SEVERITY_COLOR . "'>" . $low . "</TD>
					<td class='data_box_cell'>" . $total . "</TD>
				</tr>\n";
			}
		}

		$global_db->dbms_free_result($res);

		$server_status_table.="</table></TD></tr></table>";

		if($show_content) echo $server_status_table;
		else return $server_status_table;
	}

	class server_status_as_menu extends menu_item {

		public function show() {
			alerts_show_servers_status(false, true, false);
		}
	}
?>