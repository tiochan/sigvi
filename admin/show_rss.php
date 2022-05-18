<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage rss_sources
 *
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;			// Logged

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/menu.inc.php";
	include_once MY_INC_DIR . "/classes/rss_sources.class.php";

	html_header($MESSAGES["RSS_VULN_NEWS"]);

	$rss= new rss_subform("RSS_Sources",$MESSAGES["RSS_SOURCES"]);

	$frm= new form("forms_rss");
	$frm->add_element($rss);
	$frm->form_control();

	html_footer();
