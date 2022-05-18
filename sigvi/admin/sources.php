<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package lib
 * @subpackage admin
 *
 */


	$AUTH_REQUIRED=true;
	$AUTH_LVL=3;

	include "../include/init.inc.php";

	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/menu.inc.php";
	include_once INC_DIR . "/forms/form_elements/tab.inc.php";
	include_once MY_INC_DIR . "/classes/dw_source.class.php";

	class dw_source_vuln extends dw_source {
		public function post_show_row($values) {
			echo $this->create_row_action("Force load","force_load",$values["row_id"],ICONS . "/hidden.png");
		}

		public function action_force_load($row_id) {
?>
	<script language='javascript'>
	open("../plugins/cron/load_vulnerabilities.php?id_source=<?php echo $row_id; ?>");
	</script>
<?php
		}
	}

	class dw_source_prod extends dw_source {
		public function post_show_row($values) {
			echo $this->create_row_action("Force load","force_load",$values["row_id"],ICONS . "/hidden.png");
		}

		public function action_force_load($row_id) {
?>
	<script language='javascript'>
	open("../plugins/cron/load_products.php?id_source=<?php echo $row_id; ?>");
	</script>
<?php
		}
	}


	/**
	 *  TOOLS MENU
	 *
	 */
	class vuln_menu_form extends form_element {
		public $tools;

		public function vuln_menu_form($name) {
			global $MESSAGES, $USER_LEVEL;

			parent::form_element($name);

			$this->tools= new menu($MESSAGES["TOOLS"]);
			$tools_item= Array();

			if($USER_LEVEL == 0) {
				$tools_item[]= new menu_item($MESSAGES["VULN_SOURCES_TESTING"], ICONS . "/folder_html.png", HOME . "/plugins/sources/source_test.php");
				$tools_item[]= new menu_item($MESSAGES["VULN_SOURCES_LOAD"], ICONS . "/hidden.png", HOME . "/plugins/cron/load_vulnerabilities.php");
			}

			foreach ( $tools_item as $item ) {
				$this->tools->add_menu_item($item);
			}
		}

		public function show() {
			parent::show();

			$this->tools->show();
		}
	}

	class cpe_menu_form extends form_element {
		public $tools;

		public function cpe_menu_form($name) {
			global $MESSAGES, $USER_LEVEL;

			parent::form_element($name);

			$this->tools= new menu($MESSAGES["TOOLS"]);
			$tools_item= Array();

			if($USER_LEVEL == 0) {
				$tools_item[]= new menu_item($MESSAGES["VULN_SOURCES_TESTING"], ICONS . "/folder_html.png", HOME . "/plugins/sources/products_test.php");
				$tools_item[]= new menu_item($MESSAGES["VULN_SOURCES_LOAD"], ICONS . "/hidden.png", HOME . "/plugins/cron/load_products.php");
			}

			foreach ( $tools_item as $item ) {
				$this->tools->add_menu_item($item);
			}
		}

		public function show() {
			parent::show();

			$this->tools->show();
		}
	}


	$tab= new tab_box("tab_1");


	/**
	 * Vulnerability sources management
	 */
	$tb_vuln= new tab("tab_vuln",$MESSAGES["VULN_SOURCES"]);

	if(!isset($action) or ($action == "show_rows")) echo "<form name='source_tools'></form>";

	$vuln= new dw_source_vuln("vulnerability_sources","/plugins/sources/vulnerability_parsers");

	if($USER_LEVEL == 0) {
		$mf= new vuln_menu_form("menu_form1");
		$tb_vuln->add_element($mf);
	}
	$tb_vuln->add_element($vuln);
	$tab->add_tab($tb_vuln);

	/**
	 * RSS sources management
	 */
	$tb_rss= new tab("tab_rss",$MESSAGES["RSS_SOURCES"]);

	$rss= new dw_source("rss_sources","/plugins/sources/news");
	$tb_rss->add_element($rss);
	$tab->add_tab($tb_rss);

	if($USER_LEVEL == 0) {
		/**
		 * Product dictionaries sources management
		 */
		$tb_prod= new tab("tab_prod",$MESSAGES["PRODUCT_DICTIONARIES"]);

		$mg= new cpe_menu_form("menu_form2");
		$tb_prod->add_element($mg);

		$prod= new dw_source_prod("product_sources","/plugins/sources/product_dictionaries");
		$tb_prod->add_element($prod);
		$tab->add_tab($tb_prod);
	}

	html_header($MESSAGES["SOURCES_ADMIN"]);

	$form= new form("form_sources");
	$form->add_element($tab);
	$form->form_control();
	html_footer();
?>