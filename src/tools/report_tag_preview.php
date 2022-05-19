<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package lib
 * @subpackage conf
 *
 * Datawindow class for parameters management.
 */

/*
	Table definition

	+-------------+--------------+------+-----+---------+----------------+
	| Field       | Type         | Null | Key | Default | Extra          |
	+-------------+--------------+------+-----+---------+----------------+
	| id_report   | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| report_name | varchar(60)  | YES  | MUL | NULL    |                |
	| id_group    | mediumint(9) | YES  |     | NULL    |                |
	| content     | text         | YES  |     | NULL    |                |
	| periodicity | tinyint(1)   | YES  |     | NULL    |                |
	+-------------+--------------+------+-----+---------+----------------+


*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;			// ADMINS ONLY

	define("SHOW_MENU",false);

	include_once "../include/init.inc.php";
	include INC_DIR . "/reports/reports.class.php";

	global $global_db, $USER_LEVEL;

	html_header("Tag preview");

	$tag_id= get_http_param("detail_tag_id",false);
	if($tag_id === false) {
		$tag_id= get_http_param("detail_tag_id", false);
		if($tag_id === false) {
			html_showError("** Tag id expected **", true);
			html_footer();
			exit;
		}
	}

	$query="select tag_name from report_tags where id_tag='$tag_id'";
	$res= $global_db->dbms_query($query);

	if(!$global_db->dbms_check_result($res)) {
		html_showError("** Tag id not found **", true);
		html_footer();
		exit;
	}

	list($tag_name)= $global_db->dbms_fetch_row($res);
	$global_db->dbms_free_result($res);


	$tag= new tag($tag_name);

	// Report access: only generic (id_group is null) and own group reports
	if($USER_LEVEL != 0 and $tag->is_public != 1) {
		html_showError("** Not allowed to see this tag **", true);
	} else {
		echo "<br><p><b>Showing preview for tag</b>: $tag_name</p>";
		echo "<p>(Shown between horizontal lines)</p><br><hr>";
		$content= $tag->get_value();
		echo $content;
		echo "<hr>";
	}

	html_footer();
?>
