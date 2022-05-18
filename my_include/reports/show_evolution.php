<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage reports
 *
 * vulnerability evolution report: main page.
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=100;

	include_once "../../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements.inc.php";
	include_once INC_DIR . "/forms/form_elements/image.inc.php";
	include_once INC_DIR . "/forms/form_elements/graph.inc.php";
	include_once INC_DIR . "/forms/form_elements/tab.inc.php";



	include_once MY_INC_DIR . "/reports/graphs/vulnerability_progress.graph.php";

	$tab= new tab_box("tab_graphs");

	$tab_1= new tab("tab_graph_vulns","Vuln. evolution");
	$g_vuln= new form_image("image_vulns","vulnerability_progress.php");
	//$g_vuln= new form_graph("image_vulns","vulnerability_progress");
	$tab_1->add_element($g_vuln);
	$tab->add_tab($tab_1);

	$tab_2= new tab("tab_graph_alerts","Alert evolution");
	$g_alrt= new form_image("image_alerts","alert_progress.php");
	$tab_2->add_element($g_alrt);
	$tab->add_tab($tab_2);

	$tab_3= new tab("tab_graph_comp","Vuln vs Alert");
	$g_comp= new form_image("image_comp","vulnerability_vs_alert.php");
	$tab_3->add_element($g_comp);
	$tab->add_tab($tab_3);

	$tab_4= new tab("tab_graph_type","Alerts by software");
	$g_type= new form_image("image_type","alert_type.php");
	$tab_4->add_element($g_type);
	$tab->add_tab($tab_4);

	$tab_5= new tab("tab_graph_stat","Alerts by status");
	$g_stat= new form_image("image_stat","alert_status.php");
	$tab_5->add_element($g_stat);
	$tab->add_tab($tab_5);

	html_header($MESSAGES["SHOW_VULNERABILITY_EVOLUTION"]);

	$frm= new form("form_graphs");
	$frm->add_element($tab);

	$frm->form_control();

	html_footer();
?>