<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage notification_methods
 *
 */


/*
	Table definition

	+------------------------+--------------+------+-----+---------+----------------+
	| Field                  | Type         | Null | Key | Default | Extra          |
	+------------------------+--------------+------+-----+---------+----------------+
	| id_notification_method | mediumint(9) |      | PRI | NULL    | auto_increment |
	| name                   | varchar(60)  |      | UNI |         |                |
	| description            | text         | YES  |     | NULL    |                |
	| module                 | varchar(255) | YES  |     | NULL    |                |
	| use_it                 | tinyint(4)   |      |     | 0       |                |
	+------------------------+--------------+------+-----+---------+----------------+
*/

	$AUTH_REQUIRED=true;
	$AUTH_LVL=3;			// ADMINS ONLY

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";


	$form_name= "form_notification_methods";

	class my_form extends form {
	}

	html_header($MESSAGES["NOTIF_METHOD_MGM_TITLE"]);

	// Create the listbox to select the filename
	$list= new listbox();

	$dir=SYSHOME . "/plugins/notification_methods/";
	if(is_dir($dir)) {
		if($dh = opendir($dir)) {
			while(( $file = readdir($dh)) != false) {
				if(($file==".") or ($file==".."))
					continue;
				$list->lb["$file"]="$file";
			}
		}
	}

	$i=0;
	$fields[$i++]= new field("id_notification_method","","auto",false,true,false,false);
	$fields[$i++]= new field("name",$MESSAGES["NOTIF_METHOD_FIELD_NAME"],"fstring",true,false,true,true);
	$fields[$i++]= new field("description",$MESSAGES["NOTIF_METHOD_FIELD_DESCRIPTION"],"text", false, false, true,true);
	$fields[$i++]= new field("module",$MESSAGES["NOTIF_METHOD_FIELD_METHOD_LOCATION"],"listbox", true, false, true,true, null, $list);
	$fields[$i++]= new field("use_it",$MESSAGES["NOTIF_METHOD_FIELD_USE_IT"],"bool", true, false, true,true);

	$can_manage= ($USER_LEVEL == 0);				// Each admin can do it
	$query_adds=" order by name";
	$dw= new datawindow("notification_methods",$fields,0, "", $query_adds, $can_manage, $can_manage, $can_manage);
	$frm= new my_form($form_name);
	$frm->add_element($dw);
	$frm->form_control();

	html_footer();
?>
