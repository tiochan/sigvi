<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 *
 * Main menu.
 */

	include_once INC_DIR . "/menu.inc.php";

	class main_menu extends html_menu_bar {

		public function main_menu() {

			global $MESSAGES, $USER_LEVEL;

			parent::html_menu_bar();


			$init_menu= new html_menu($MESSAGES["APP_HOME"], ICONS . "/home.png", HOME . "/");


			/****************************************************
			 *  TODO MENU
			 ****************************************************/

			$todo_menu= new html_menu($MESSAGES["TO-DO"],ICONS . "/responses.png");
			$todo_items= Array();

			// Menu items for SIGVI Admin only
			if($USER_LEVEL <= 3) {
				$todo_items[]= new  html_menu_item($MESSAGES["ALERT_VALIDATION_SHORT"], ICONS . "/responses.png", HOME . "/admin/server_alerts.php?tab_1_tab_selected=tab_validation");
			}

			// Alerts in the user group servers
			$todo_items[]= new  html_menu_item($MESSAGES["ALERTS"], ICONS . "/responses.png", HOME . "/admin/server_alerts.php?tab_1_tab_selected=tab_alerts");

			$todo_items[]= new  html_menu_item($MESSAGES["SEE_SERVER_VULNERABILITIES"], ICONS . "/bug_server.png", HOME . "/admin/server_alerts.php");


			foreach ( $todo_items as $item ) {
				$todo_menu->add_menu_item($item);
			}


			/****************************************************
			 *  APPLICATION CONFIGURATION
			 ****************************************************/

			$config_menu= new html_menu($MESSAGES["APP_ADMIN"], ICONS . "/configure.png");
			$configs= Array();

			$configs[]= new html_menu_item($MESSAGES["CHANGE_MY_DATA"], ICONS . "/identity.png",  HOME . "/tools/user.php");

			if($USER_LEVEL <= 3) $configs[]= new html_menu_item($MESSAGES["GROUPS_AND_USERS_MGM_TITLE"], ICONS . "/kuser.png",  HOME . "/tools/groups_and_users.php");

			$configs[]= new html_menu_item($MESSAGES["FILTER_TITLE"], ICONS . "/filter.png",  HOME . "/admin/filters.php");
			$configs[]= new html_menu_item("FAS", ICONS . "/func.png",  HOME . "/admin/fas.php");
			$configs[]= new html_menu_item("** Task Manager **", ICONS . "/systemtray.png",  HOME . "/tools/task_manager.php");

			for($i=0; $i < count($configs); $i++) {
				$config_menu->add_menu_item($configs[$i]);
			}


			/****************************************************
			 *  GENERAL MENU
			 ****************************************************/

			if($USER_LEVEL <= 3) {
				$general_admin= new html_menu($MESSAGES["SIGVI_ADMIN"]);
				$general_admin_item= Array();

				// Menu items for SIGVI Admin only

				$general_admin_item[]= new html_menu_item($MESSAGES["SOURCES"], ICONS . "/news.png",  HOME . "/admin/sources.php");
				$general_admin_item[]= new html_menu_item($MESSAGES["NOTIFICATION_METHODS"], ICONS . "/kontact_mail.png",  HOME . "/admin/notification_methods.php");

				if($USER_LEVEL == 0) {
					$general_admin_item[]= new html_menu_item($MESSAGES["CONFIG_MGM_TITLE"], ICONS . "/configure.png",  HOME . "/tools/config.php");
				}

				foreach ( $general_admin_item as $item ) {
					$general_admin->add_menu_item($item);
				}
			}

			/****************************************************
			 *  INVENTORY MENU
			 ****************************************************/

			$inventory_menu= new html_menu($MESSAGES["INVENTORY"]);
			$inventory_menu_item= array();

			$inventory_menu_item[]= new html_menu_item($MESSAGES["SERVERS_AND_SERVICES"], ICONS . "/systemtray.png",  HOME . "/admin/servers_and_services.php");
			$inventory_menu_item[]= new html_menu_item($MESSAGES["PRODUCTS"], ICONS . "/kcmdf.png",  HOME . "/admin/products.php");
			$inventory_menu_item[]= new html_menu_item($MESSAGES["VULNERABILITIES"], ICONS . "/bug.png",  HOME . "/admin/vulnerabilities.php");

			if($USER_LEVEL <= 3) {
				if(file_exists(SYSHOME . "/conf/discover.conf.php")) {
					include_once SYSHOME . "/conf/discover.conf.php";

					if(defined("DISCOVERER_ENABLED") and DISCOVERER_ENABLED) {
						$inventory_menu_item[]= new html_menu_item($MESSAGES["REPOSITORY_MAIN_TITLE"], ICONS . "/vcs_add.png", DISCOVERER_WEB_DIR .  HOME . "/admin/repositories.php");
					}
				}
			}

			foreach ( $inventory_menu_item as $item ) {
				$inventory_menu->add_menu_item($item);
			}

			/****************************************************
			 *  REPORTS MENU
			 ****************************************************/
			$reports= new html_menu("** REPORTS **");
			$report_items= Array();

			$report_items[]= new html_menu_item($MESSAGES["REPORT_MGM_TITLE"], ICONS . "/graph.png",  HOME . "/admin/reports.php");
			$report_items[]= new html_menu_item($MESSAGES["STATISTICS"], ICONS . "/graph.png", HOME . "/my_include/reports/show_evolution.php");


			foreach ( $report_items as $item ) {
				$reports->add_menu_item($item);
			}

			/****************************************************
			 *  TOOLS MENU
			 ****************************************************/
			$tools= new html_menu($MESSAGES["TOOLS"]);
			$tools_item= Array();

			if($USER_LEVEL == 0) {
				$tools_item[]= new html_menu_item($MESSAGES["DDBB_CURRENT"], ICONS . "/database.png",  HOME . "/tools/db_configured.php");
				$tools_item[]= new html_menu_item($MESSAGES["DDBB_GENERIC"], ICONS . "/database.png",  HOME . "/tools/dbms.php");
				$tools_item[]= new html_menu_item($MESSAGES["LOGS"], ICONS . "/logviewer.png",  HOME . "/tools/logs.php");
			}

			if($USER_LEVEL <= 3) {
				$tools_item[]= new html_menu_item("Mailing", ICONS . "/mail.png",  HOME . "/tools/mailing.php");
			}

			$tools_item[]= new html_menu_item($MESSAGES["BUG_MGM_TITLE"], ICONS . "/bug.png",  HOME . "/tools/bugs.php");

			foreach ( $tools_item as $item ) {
				$tools->add_menu_item($item);
			}


			/****************************************************
			 *  ABOUT MENU
			 ****************************************************/
			$about_url= "#' onclick=\"javascript:openMyWindow('" . HOME . "/show_info.php?info_page=about.html',600,500)\"";
			$about_menu= new html_menu("** About **","",$about_url);

			/****************************************************
			 *  SHOW MENUS
			 ****************************************************/

			html_header($MESSAGES["APP_NAME"],"index.html");

			$this->add_menu($init_menu);
			$this->add_menu($todo_menu);
			$this->add_menu($config_menu);
			$this->add_menu($inventory_menu);
			if($USER_LEVEL <= 3) $this->add_menu($general_admin);
			$this->add_menu($reports);
			$this->add_menu($tools);
			$this->add_menu($about_menu);
		}
	}
?>