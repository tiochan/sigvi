<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage admin
 *
 * Repository query page.
 */


/*
	Servers table:
	+-----------+--------------+------+-----+---------+----------------+
	| Field     | Type         | Null | Key | Default | Extra          |
	+-----------+--------------+------+-----+---------+----------------+
	| id_server | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| hostname  | varchar(60)  | NO   | UNI |         |                |
	| ip        | varchar(20)  | YES  |     | NULL    |                |
	+-----------+--------------+------+-----+---------+----------------+

	Current services table:
	+-------------+--------------+------+-----+-------------------+-------+
	| Field       | Type         | Null | Key | Default           | Extra |
	+-------------+--------------+------+-----+-------------------+-------+
	| id_server   | mediumint(9) | NO   |     |                   |       |
	| d_date      | timestamp    | NO   |     | CURRENT_TIMESTAMP |       |
	| port        | int(11)      | NO   |     |                   |       |
	| protocol    | char(10)     | NO   |     |                   |       |
	| state       | varchar(10)  | YES  |     | NULL              |       |
	| name        | varchar(255) | YES  |     | NULL              |       |
	| product     | varchar(255) | YES  |     | NULL              |       |
	| version     | varchar(255) | YES  |     | NULL              |       |
	| extrainfo   | varchar(255) | YES  |     | NULL              |       |
	| ostype      | varchar(255) | YES  |     | NULL              |       |
	| fingerprint | text         | YES  |     | NULL              |       |
	| deleted     | int(11)      | NO   |     | 0                 |       |
	| revision    | int(11)      | NO   |     | 0                 |       |
	+-------------+--------------+------+-----+-------------------+-------+
*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;

	include_once "../../../include/init.inc.php";
	include_once SYSHOME . "/conf/discover.conf.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once DISCOVERER_DIR . "/classes/discover.class.php";
	include_once DISCOVERER_DIR . "/include/forms/form_elements/repositories_forms.inc.php";


	html_header("NSDi repository");

	if(!defined("DISCOVERER_ENABLED") or !DISCOVERER_ENABLED) {
		html_showError("Discoverer not enabled.");
		html_footer();
		exit;
	}

	$form_name= "form_discover";
	$null_ref=null;

	$frm= new repository_form($form_name);
	$repository_name= $frm->repository_name;

	if($repository_name != "") echo "<b>Repository:</b> $repository_name, <a href='" . HOME . "/plugins/discoverer/admin/repositories.php'>back</a><hr><br>";

	$frm->form_control();


	html_footer();
?>