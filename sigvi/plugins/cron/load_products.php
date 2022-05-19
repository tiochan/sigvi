<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage product_dictionaries
 *
 * Load the products from defined sources.
 *
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=0;			// SIGVI ADMINS ONLY
	// $LOCATION_REQUIRED="192.168.0.23";

	/**
	 * This script can be called from command line or via Web.
	 *
	 * - Comman line (cli), from cron tasks or directly (from shell)
	 * - Web, forcing the load process.
	 *
	 */

	if(php_sapi_name() == "cli") {
		if(strpos($_SERVER["PHP_SELF"], "plugins/cron/load_products.php") !== false) {
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


	include_once INC_DIR . "/output.inc.php";
	include_once MY_INC_DIR . "classes/cpe_sources.class.php";


	function f_show_form($db) {

		global $MESSAGES;

		$query="select id_source, name from product_sources";
		$res=$db->dbms_query($query);

		$id_source= get_http_param("id_source","");

		if($res and ($db->dbms_num_rows($res) > 0)) {
?>
			<table border=0><tr>
			<td><?php echo $MESSAGES["SOURCES_FIELD_ALIAS"]; ?>:&nbsp;</td>
			<td><form name='sources' action='<?php echo  $_SERVER["PHP_SELF"]; ?>' method='post'>
			<input type='hidden' name='action' value=''>
			<select name='id_source'>
<?php
			while($row=$db->dbms_fetch_array($res)) {

				if($id_source != "" and $id_source == $row[0]) {
					echo"	<option value='" . $row[0] . "' selected>" . $row[1] . "</option>\n";
				} else {
					echo"	<option value='" . $row[0] . "'>" . $row[1] . "</option>\n";
				}
			}
?>
			</select>
			<input type='submit' value='ok' onclick='document.forms.sources.action.value="0"'><br>
			</form></td>
			</tr></table>
<?php
		} else {
			echo "No rows";
		}
	}

	function show_form() {

		global $MESSAGES;

		$id_source= get_http_param("id_source","");

		?>

			<form name="met" action='<?php echo $_SERVER["PHP_SELF"]; ?>' method="post">
				<input type="hidden" name="action" value="0">
				<input type="hidden" name="id_source" value="<?php echo $id_source; ?>">
				<h3><?php echo $MESSAGES["LOAD_VULNERABILITIES_CONFIRM"]; ?></h3>
				<input type="button" value='<?php echo $MESSAGES["ACCEPT"]; ?>' onclick="document.forms.met.action.value='1'; document.forms.met.submit()">
       			<input type='button' value='<?php echo $MESSAGES["CANCEL"]; ?>' onclick="window.location.href='<?php echo HOME . "/admin/sources.php"; ?>'">
			</form>
		<?php
	}

	/////////////////////////////////////////////////////////////////////////////////

	if(!CLI_MODE) {		// Called over Web
		html_header($MESSAGES["SOURCE_MGM_TITLE"]);

		f_show_form($global_db);

		$id_source= get_http_param("id_source","");
		$action= get_http_param("action","");

		if($id_source == "") {
			html_footer();
			exit;
		} else {
			if($action != "1") {
				show_form();
				html_footer();
				exit;
			}
		}

		load_products($report, $id_source);
		html_footer();

	} else {

		if(!load_products($report)) {

			include_once SYSHOME . "/include/mail.inc.php";

			$subject="The process of load reports finished with errors";
			send_admins_mail($subject, $subject, $report, "html");
		}
		my_echo($report);
	}
?>