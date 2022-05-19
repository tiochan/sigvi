<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 *
 * Show info page
 */

$CRONO_ENABLED=false;
$AUTH_REQUIRED=false;

define("SHOW_MENU",false);

include_once "./include/init.inc.php";
//html_header("Info");

$page_to_show= get_http_param("info_page",false);
if(!$page_to_show) {
	html_showError("Info page not defined.");
	html_showMainFrameFooter();
	exit;
}

$file_page= SYSHOME . "/doc/info/" . basename($page_to_show);
if(!file_exists($file_page)) {
	html_showError("Couldn't find info page.");
	html_showMainFrameFooter();
	exit;
}

include_once $file_page;

html_showSimpleFooter();
