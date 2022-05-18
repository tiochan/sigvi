<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage vulnerability_sources
 *
 * Test the vulnerabilities from defined sources.
 *
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=0;			// SIGVI ADMINS ONLY

	include_once "../../include/init.inc.php";
	include_once INC_DIR . "/output.inc.php";
	include_once MY_INC_DIR . "/classes/alert.class.php";
	include_once MY_INC_DIR . "/classes/vulnerability_sources.class.php";

	/////////////////////////////////////////////////////////////////////////////////

	function f_show_form($db) {

		global $MESSAGES;

		$query="select id_source, name from vulnerability_sources";
		$res=$db->dbms_query($query);

		if($res and ($db->dbms_num_rows($res) > 0)) {
			echo "<table border=0><tr>";
			echo "<td>" . $MESSAGES["SOURCES_TEST_FIELD_ALIAS"] . ":&nbsp;</td>";
			echo "<td><form name='sources' action='" . $_SERVER["PHP_SELF"] . "' method='post'>\n";
			echo "  <input type='hidden' name='action' value=''>";
			echo "	<select name='id_source'>\n";

			while($row=$db->dbms_fetch_array($res)) {
				if(isset($_POST["id_source"]) and $_POST["id_source"]==$row[0]) {
					echo"	<option value='" . $row[0] . "' selected>" . $row[1] . "</option>\n";
				} else {
					echo"	<option value='" . $row[0] . "'>" . $row[1] . "</option>\n";
				}
			}
			echo "	</select>\n";
			echo "	<input type='submit' value='test' onclick='document.forms.sources.action.value=\"test\"'><br>\n";
			echo "</form></td>\n";
			echo "</tr></table>";
		} else {
			echo "No rows";
		}
	}

	html_header($MESSAGES["APP_NAME"]);

	f_show_form($global_db);

	if(isset($_POST["action"]) and ($_POST["action"] == 'test')) {

		go($global_vuln_array, $report, $all_output, $_POST["id_source"], true);

		my_echo($all_output);
		my_echo("<LINE_BREAK>");
		my_echo($report);
	}

	if(!CLI_MODE) html_footer();
?>