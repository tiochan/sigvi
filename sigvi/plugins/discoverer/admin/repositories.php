<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage admin
 *
 * Repository management page.
 */


/*
	Table definition

	+---------------+--------------+------+-----+---------+----------------+
	| Field         | Type         | Null | Key | Default | Extra          |
	+---------------+--------------+------+-----+---------+----------------+
	| id_repository | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| name          | varchar(60)  | NO   | UNI |         |                |
	| id_group      | mediumint(9) | YES  |     | NULL    |                |
	| description   | varchar(255) | YES  |     | NULL    |                |
	| dbserver      | varchar(100) | NO   |     |         |                |
	| dbtype        | varchar(15)  | NO   |     |         |                |
	| dbuser        | varchar(60)  | YES  |     | NULL    |                |
	| dbname        | varchar(60)  | NO   |     |         |                |
	| dbpass        | varchar(255) | YES  |     | NULL    |                |
	| enabled       | int(1)       | YES  |     | NULL    |                |
	+---------------+--------------+------+-----+---------+----------------+
*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;

	include_once "../../../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/form_elements/select.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";

	$form_name= "form_repository";

	include_once SYSHOME . "/conf/discover.conf.php";

	html_header($MESSAGES["REPOSITORY_MGM_TITLE"]);

	if(!defined("DISCOVERER_ENABLED") or !DISCOVERER_ENABLED) {
		html_showError("Discoverer not enabled.");
		html_footer();
		exit;
	}

	$restriction= $USER_LEVEL!=0 ? "(id_group=$USER_GROUP or id_group is null)" : "";
	$group_reference= new foreign_key($global_db,"groups","id_group","name", $restriction);
    $null_ref= null;

	$fields= array();
	$fields[]= new field("id_repository","","auto",false,false,false,false);
	$fields[]= new master_field("repository_detail.php",$null_ref,"name",$MESSAGES["REPOSITORY_FIELD_NAME"],"string",true,true,true,true);
	$fields[]= new field("id_group",$MESSAGES["REPOSITORY_FIELD_GROUP"],"foreign_key", false, false, true, ($USER_LEVEL <= 3),$USER_GROUP,$group_reference);
	$fields[]= new field("dbserver",$MESSAGES["REPOSITORY_FIELD_HOST"],"string", true, false, true, true);
	$fields[]= new field("dbtype",$MESSAGES["REPOSITORY_FIELD_TYPE"],"list_dbms", true, false, true, true);
	$fields[]= new field("dbname",$MESSAGES["REPOSITORY_FIELD_DBNAME"],"string", true, false, true, true);
	$fields[]= new field("dbuser",$MESSAGES["REPOSITORY_FIELD_RO_USER"],"string", false, false, true, true);
	$fields[]= new field("dbpass",$MESSAGES["REPOSITORY_FIELD_RO_PASS"],"string", false, false, true, true);
	$fields[]= new field("description",$MESSAGES["REPOSITORY_FIELD_DESCRIPTION"],"text", false, false, true, true);
	$fields[]= new field("enabled",$MESSAGES["REPOSITORY_FIELD_USE_IT"],"bool", false, false, true, true);

	$fields[8]->show_max_len=20;

	$sb= new search_box(array($fields[1], $fields[2], $fields[3]),"search_repository",$MESSAGES["SEARCH"]);

	$can_manage= ($USER_LEVEL <= 3);				// Each group admin can do it
	$query_adds=" order by name";
	$dw= new datawindow("repositories",$fields,0, $restriction, $query_adds, $can_manage, $can_manage, $can_manage);
	$dw->add_search_box($sb);

	$frm= new form($form_name);
	$frm->add_element($dw);
	$frm->form_control();

	html_footer();
?>