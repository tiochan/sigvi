<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage alerts
 * @uses form, tab, dw_server_alerts, dw_alerts, alert
 *
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;			// ADMINS ONLY

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/menu.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/tab.inc.php";

	include_once MY_INC_DIR . "/classes/dw_server_alerts.class.php";
	include_once MY_INC_DIR . "/classes/dw_alerts.class.php";
	include_once MY_INC_DIR . "/classes/alert.class.php";


	class alerts_report extends form_element {
		function show() {
			parent::show();
			alerts_show_servers_status(true, true, true);
		}
	}

	html_header($MESSAGES["ALERT_MGM_TITLE"]);
/*
	if($USER_LEVEL == 3) {
		$tools= new menu($MESSAGES["TOOLS"]);
		$tools_item= new menu_item($MESSAGES["CHECK_SERVER_VULNERABILITIES"], ICONS . "/button.png", HOME . "/plugins/sources/check_server_vulnerabilities.php");
		$tools->add_menu_item($tools_item);
		$tools->show();
	}
*/

	$tab= new tab_box("tab_1");

	$tb_servers= new tab("tab_servers",$MESSAGES["SERVERS"]);
	$alert_report= new alerts_report("alert_report");
	$tb_servers->add_element($alert_report);
	$tab->add_tab($tb_servers);

	$tb_alerts= new tab("tab_alerts",$MESSAGES["ALERTS"]);
	$dw_alerts= new dw_alert();
	$tb_alerts->add_element($dw_alerts);
	$tab->add_tab($tb_alerts);

	if($USER_LEVEL <= 3) {
		$tb_validation= new tab("tab_validation",$MESSAGES["ALERT_VALIDATION_SHORT"]);

		$dw1= new dw_alert(true);

		$tb_validation->add_element($dw1);

		$tab->add_tab($tb_validation);
	}

	$frm= new form("form_server_vulnerabilities");
	$frm->add_element($tab);
	$frm->form_control();

	html_footer();
?>