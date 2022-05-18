<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 *
 * Main page.
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=100;

	include_once "include/init.inc.php";


	include_once "include/menu.inc.php";
	include_once MY_INC_DIR . "/classes/alert.class.php";


	/****************************************************
	 *  TODO MENU
	 ****************************************************/

	$todo_menu= new menu($MESSAGES["TO-DO"]);
	$todo_items= Array();

	// Menu items for SIGVI Admin only
	if($USER_LEVEL <= 3) {

		// Alerts to be validated
		$alerts_to_validate= alerts_get_alerts_to_validate();
		$msg= sprintf($MESSAGES["ALERTS_TO_VALIDATE"],$alerts_to_validate);
		if($alerts_to_validate > 0) $msg= "<b>$msg</b>";
		$todo_items[]= new menu_item($msg, ICONS . "/responses.png", "admin/server_alerts.php?tab_1_tab_selected=tab_validation");
	}

	// Alerts in the user group servers
	$alerts_pending= alerts_get_pending_alerts();
	$msg= sprintf($MESSAGES["ALERTS_PENDING"],$alerts_pending);
	if($alerts_pending > 0) $msg= "<b>$msg</b>";
	$todo_items[]= new menu_item($msg, ICONS . "/responses.png", "admin/server_alerts.php?tab_1_tab_selected=tab_alerts");

	if(file_exists(SYSHOME . "/conf/discover.conf.php")) {
		include_once SYSHOME . "/conf/discover.conf.php";

		if(defined("DISCOVERER_ENABLED") and DISCOVERER_ENABLED) {
			$todo_items[]= new menu_item($MESSAGES["REPOSITORY_MAIN_TITLE"], ICONS . "/vcs_add.png", DISCOVERER_WEB_DIR .  "/admin/repositories.php");
		}
	}

	foreach ( $todo_items as $item ) {
		$todo_menu->add_menu_item($item);
	}

	/****************************************************
	 *  RSS MENU
	 ****************************************************/
/*
	include_once MY_INC_DIR . "/classes/rss_sources.class.php";

	$rss_menu= new menu($MESSAGES["RSS_LAST_NEWS"]);
	$rss_menu_all= new menu_item($MESSAGES["RSS_SEE_ALL"], ICONS . "/rss.png", "admin/show_rss.php");
	$rss_menu->add_menu_item($rss_menu_all);
	$rss_menu_item= new rss_menu_item("",3);
	$rss_menu->add_menu_item($rss_menu_item);
*/
	/****************************************************
	 *  Server status
	 ****************************************************/

	$server_status_menu= new menu($MESSAGES["SERVER_STATUS"]);
	$server_status_item= new server_status_as_menu("","","");
	$server_status_menu->add_menu_item($server_status_item);


	/****************************************************
	 *  SHOW MENUS
	 ****************************************************/

	html_header($MESSAGES["APP_NAME"],"main.php");

?>	<br><br><center>
	<table border='0px' cellpadding="20">
		<tr valign="top">
			<td style="{ vertical-align: top; width: auto; }">
<?php
				$todo_menu->show(1);
				$server_status_menu->show(1);
?>			</td>
			<td>
				<a href='<?php echo HOME; ?>/my_include/reports/show_evolution.php'><img class='portal' height="400" src='<?php echo HOME . "/my_include/reports/vulnerability_vs_alert.php"; ?>'></a><br>
				<a href='<?php echo HOME; ?>/my_include/reports/show_evolution.php'><img class='portal' height="400" src='<?php echo HOME . "/my_include/reports/alert_type.php"; ?>'></a><br>
<?php
//				$rss_menu->show();
?>
			</td>
		</tr>
	</table>
	</center>
<?php

	html_footer();
?>
