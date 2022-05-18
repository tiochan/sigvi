<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 *
 * Main menu.
 */

	include_once INC_DIR . "/menus/main_menu.class.php";

	class my_main_menu extends main_menu {


		public function my_main_menu() {

			global $MESSAGES, $USER_LEVEL;

			$this->menus= array();


			parent::main_menu();


// TODO MENU

			$this->menus["01_todo_menu"]= new html_menu($MESSAGES["TO-DO"],ICONS . "/responses.png");
			$todo_items= Array();

			// Menu items for SIGVI Admin only
			if($USER_LEVEL <= 3) {
				$todo_items[]= new  html_menu_item($MESSAGES["ALERT_VALIDATION_SHORT"], ICONS . "/responses.png", HOME . "/admin/server_alerts.php?tab_1_tab_selected=tab_validation");
			}

			// Alerts in the user group servers
			$todo_items[]= new  html_menu_item($MESSAGES["ALERTS"], ICONS . "/responses.png", HOME . "/admin/server_alerts.php?tab_1_tab_selected=tab_alerts");
//			$todo_items[]= new  html_menu_item($MESSAGES["SEE_SERVER_VULNERABILITIES"], ICONS . "/bug_server.png", HOME . "/admin/server_alerts.php");


			foreach ( $todo_items as $item ) {
				$this->menus["01_todo_menu"]->add_menu_item($item);
			}


// APPLICATION CONFIGURATION

			$admins= Array();
			$admins[]= new html_menu_item($MESSAGES["FILTER_TITLE"], ICONS . "/filter.png",  HOME . "/admin/filters.php");
			$admins[]= new html_menu_item("FAS", ICONS . "/func.png",  HOME . "/admin/fas.php");

			foreach ( $admins as $item ) {
				$this->menus["10_admin_menu"]->add_menu_item($item);
			}

			if($USER_LEVEL <= 3) {
				$configs= Array();
				$configs[]= new html_menu_item($MESSAGES["SOURCES"], ICONS . "/news.png",  HOME . "/admin/sources.php");
				$configs[]= new html_menu_item($MESSAGES["NOTIFICATION_METHODS"], ICONS . "/kontact_mail.png",  HOME . "/admin/notification_methods.php");

				if(!isset($this->menus["40_config_menu"])) $this->menus["40_config_menu"]= new html_menu($MESSAGES["APP_CONF"], ICONS . "/configure.png");
				foreach ( $configs as $item ) {
					$this->menus["40_config_menu"]->add_menu_item($item);
				}
			}


// INVENTORY MENU

			$this->menus["05_inventory_menu"]= new html_menu($MESSAGES["INVENTORY"],  ICONS . "/kcmdf.png");
			$inventory_menu_item= array();

			$inventory_menu_item[]= new html_menu_item($MESSAGES["ALERTS"], ICONS . "/messagebox_warning.png", HOME . "/admin/server_alerts.php");
			$inventory_menu_item[]= new html_menu_item($MESSAGES["SERVERS_AND_SERVICES"], ICONS . "/systemtray.png",  HOME . "/admin/servers_and_services.php");
			$inventory_menu_item[]= new html_menu_item($MESSAGES["PRODUCTS"], ICONS . "/kcmdf.png",  HOME . "/admin/products.php");
			$inventory_menu_item[]= new html_menu_item($MESSAGES["VULNERABILITIES"], ICONS . "/bug.png",  HOME . "/admin/vulnerabilities.php");

//			if($USER_LEVEL <= 3) {
				if(file_exists(SYSHOME . "/conf/discover.conf.php")) {
					include_once SYSHOME . "/conf/discover.conf.php";

					if(defined("DISCOVERER_ENABLED") and DISCOVERER_ENABLED) {
						$inventory_menu_item[]= new html_menu_item($MESSAGES["REPOSITORY_MAIN_TITLE"], ICONS . "/vcs_add.png", DISCOVERER_WEB_DIR . "/admin/repositories.php");
					}
				}
//			}

			foreach ( $inventory_menu_item as $item ) {
				$this->menus["05_inventory_menu"]->add_menu_item($item);
			}


// REPORTS MENU

			$report_items= Array();
			$report_items[]= new html_menu_item($MESSAGES["STATISTICS"], ICONS . "/graph.png", HOME . "/my_include/reports/show_evolution.php");

			foreach ( $report_items as $item ) {
				$this->menus["80_tools"]->add_menu_item($item);
			}

// RSS MENU
			$this->menus["90_rss_menu"]= new html_menu($MESSAGES["RSS_LAST_NEWS"], ICONS . "/rss.png", HOME . "/admin/show_rss.php");


			ksort($this->menus);
		}
	}
?>