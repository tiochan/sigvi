<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage vulnerability_sources
 *
 *	Search for vulnerabilities into products installed on servers
 *
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL= 3;			// SIGVI ADMINS ONLY

	/**
	 * This script can be called from command line or via Web.
	 * 
	 * - Comman line (cli), from cron tasks or directly (from shell)
	 * - Web, forcing the check process.
	 * 
	 */

	if(php_sapi_name() == "cli") {
		if(strpos($_SERVER["PHP_SELF"], "my_include/cron/check_server_vulnerabilities.php") !== false) {
			// direct call
			define("SYSHOME",dirname($_SERVER["PHP_SELF"]) . "/../../");

		} else {
			// Call from cron?
			define("SYSHOME",dirname($_SERVER["PHP_SELF"]) . "/../../");
		}
		include_once SYSHOME . "/include/init.inc.php";
	} else {
		include_once "../../include/init.inc.php";
	}

	if(CLI_MODE) define("QUIET",true);

	
	include_once MY_INC_DIR . "/classes/alert.class.php";


	function go(&$report, &$all_output) {

		global $global_db;
		global $MESSAGES;

		global $USER_LEVEL, $USER_GROUP;


		$output="";
		$all_output="";

		// TODO: Optimize this query to detect at least ALL the positives
		$query=	"select servers.id_server as 'id_server'," .
					   "servers.name as 'name',".
					   "server_products.id_server_product as 'id_server_product',".
					   "products.full_name as 'full_name',".
					   "vulnerabilities.vuln_id as 'vuln_id' " .
				"from servers,".
					 "products,".
					 "vulnerabilities,".
					 "server_products " .
				"where servers.deleted='0' and " .
				"       server_products.deleted=0 and " .
				"       servers.id_server = server_products.id_server and " .
				"       products.id_product = server_products.id_product and " .
				"       vulnerabilities.vuln_software like " . $global_db->dbms_concat("", '\'%\'', "products.vendor", '\'%\',\'%\'', "products.name", '\'%\',\'%\'', "products.version", '\'%\'');

		if($USER_LEVEL != 0) $query.= " and servers.id_group='$USER_GROUP'";

		$res=$global_db->dbms_query($query);
		if(!$global_db->dbms_check_result($res)) {
			echo "Query error:\n";
			echo $global_db->dbms_error();
			return;
		}

		$alerts_sent=0;
		$num_alers= $global_db->dbms_num_rows($res);
		$processed_alerts=0;

		include_once MY_INC_DIR . "/classes/vulnerability.class.php";
		include_once MY_INC_DIR . "/filters.inc.php";

		while($row=$global_db->dbms_fetch_array($res)) {

			$id_server= $row["id_server"];
			$id_server_product= $row["id_server_product"];
			$vuln_id= $row["vuln_id"];

			$server_name= $row["name"];
			$product_name=$row["full_name"];

			$all_output.= " * Vulnerability found on server $server_name<LINE_BREAK>";
			$all_output.= "   - CVE: $vuln_id<LINE_BREAK>";
			$all_output.= "   - Product: $product_name<LINE_BREAK>";

			$vuln= new short_vuln_info($global_db, $vuln_id);
			if(vuln_pass_server_filter($id_server, $vuln)) {
				$alert= new alert($id_server_product, $vuln_id);
				if($alert->store_it()) {
					$processed_alerts++;
					$all_output.= "   - Alert created<LINE_BREAK>";
				} else {
					$all_output.= "   - The alert just exists<LINE_BREAK>";
				}
			} else {
				$all_output.= "   - Don't pass the server filter.<LINE_BREAK>";
			}
		}
		$global_db->dbms_free_result($res);

// 		$alerts_sent=send_notifications();
$alerts_sent= send_grouped_notifications();

		$report="<LINE_BREAK><PARAGRAPH>" . sprintf($MESSAGES["ALERT_NUM_ALERTS_FOUND"], $num_alers) . "<LINE_BREAK>";
		$report.=sprintf($MESSAGES["ALERT_NUM_ALERTS_PROCESSED"], $processed_alerts) . "<LINE_BREAK>";
		$report.=sprintf($MESSAGES["ALERT_NUM_ALERTS_SENT"], $alerts_sent) . "</PARAGRAPH>";

		$all_output= $report . "<HLINE>Report:<LINE_BREAK><LINE_BREAK>" . $all_output;
		$all_output.= "<HLINE><LINE_BREAK>Check server vulnerabilities: Process finished.<LINE_BREAK><LINE_BREAK>";
	}


	function show_form() {

		global $MESSAGES;
		?>

			<form name="met" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method="post">
				<input type="hidden" name="action" value="0">
				<h3><?php echo $MESSAGES["SEARCH_VULNERABILITIES_CONFIRM"]; ?></h3>
				<input type="button" value='<?php echo $MESSAGES["ACCEPT"]; ?>' onclick="document.forms.met.action.value='1'; document.forms.met.submit()">
       			<input type='button' value='<?php echo $MESSAGES["CANCEL"]; ?>' onclick="window.location.href='<?php echo HOME . "/index.php"; ?>'">
			</form>
		<?php
	}


	if(!CLI_MODE) {
		html_header($MESSAGES["APP_NAME"]);

		if(!isset($_POST["action"]) or ($_POST["action"]=="0")) {
			show_form();
			html_footer();
			exit;
		}
	}

	go($report, $all_output);


	include_once SYSHOME . "/include/mail.inc.php";
	include_once SYSHOME . "/include/output.inc.php";

	// Send report only on batch mode
	if(CLI_MODE) {
		$subject=$MESSAGES["CRON_VULN_CHECK_SUBJECT"];
		//send_admins_mail($subject, $subject, $report, "html");
		my_echo($report);
	} else {
		my_echo($all_output);
		html_footer();
	}
?>
