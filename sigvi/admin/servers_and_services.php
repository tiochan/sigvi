<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage servers
 * @uses form, tab, dw_servers, dw_services
 *
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;

	include "../include/init.inc.php";

	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/tab.inc.php";
	include_once MY_INC_DIR . "/classes/dw_servers.class.php";
	include_once MY_INC_DIR . "/classes/dw_services.class.php";

	$tab= new tab_box("tab_1");

	$tb_servers= new tab("tab_servers",$MESSAGES["SERVERS"]);
	$srv= new dw_server();
	$tb_servers->add_element($srv);
	$tab->add_tab($tb_servers);

	$tb_services= new tab("tab_services",$MESSAGES["SERVICES"]);
	$svc= new dw_service();
	$tb_services->add_element($svc);
	$tab->add_tab($tb_services);


	$form= new form("form_servers");
	$form->add_element($tab);

	html_header($MESSAGES["SERVER_MGM_TITLE"]);
	$form->form_control();
	html_footer();
?>