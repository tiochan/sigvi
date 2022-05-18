<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package discoverer
 * @subpackage forms
 *
 * API Form PHP Forms.
 */

include_once SYSHOME . "/conf/discover.conf.php";

include_once SYSHOME . "/include/forms/field.inc.php";
include_once INC_DIR . "/forms/form_elements.inc.php";
include_once INC_DIR . "/forms/containers/sub_form.inc.php";
include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
include_once INC_DIR . "/forms/form_elements/datawindow_ext.inc.php";
include_once INC_DIR . "/forms/form_elements/search_box.inc.php";
include_once INC_DIR . "/forms/form_elements/search_box_ext.inc.php";
include_once INC_DIR . "/forms/form_elements/field_box.inc.php";
include_once INC_DIR . "/forms/form_elements/tab.inc.php";
include_once INC_DIR . "/forms/form_elements/label.inc.php";

include_once DISCOVERER_DIR . "/include/repositories.api.php";
include_once DISCOVERER_DIR . "/include/forms/form_elements/servers_forms.inc.php";
include_once DISCOVERER_DIR . "/include/forms/form_elements/services_forms.inc.php";

$discover_repository=0;
$repository_id=0;
$repository_form=null;



/**
 * Main repository form
 *
 * Will create subforms for servers and services.
 *
 */
class repository_form extends form {

	public $repository_name;

	public $repository_selector;
	public $servers_form;
	public $services_form;
	public $import_services_form;


	public function repository_form($name) {

		global $discover_repository;
		global $repository_id;
		global $repository_form;
		global $MESSAGES;

		parent::form($name);

		/**
		 * The repository name or id must be passed. It can be defined from a link (repositories.php).
		 * Or directly from the current page select.
		 */

		$this->repository_selector= new repository_selector("repository_selector");
		$this->add_element($this->repository_selector);

		$this->repository_name= $this->repository_selector->repository_name;
		$repository_id= $this->repository_selector->repository_id;

		if($this->repository_name != "") {
			$this->repository_selector->visible= false;

			if(!get_repository_access($this->repository_name, $dbserver, $dbtype, $dbname, $ro_user, $ro_pass)) {
				html_showError("Repository not found!.");
				html_footer();
				exit;
			}

			$discover_repository= new discover_repository($dbserver, $dbtype, "repository_" . $dbname, $ro_user, $ro_pass);

			$tab= new tab_box("tab_1");

			$tb_servers= new tab("tab_servers",$MESSAGES["SERVERS"]);

			$this->servers_form= new servers_subform("subform_1","Servers");
			$tb_servers->add_element($this->servers_form);
			$tab->add_tab($tb_servers);

			$tb_services= new tab("tab_services",$MESSAGES["SERVICES"]);
			$this->services_form= new services_subform("subform_2","Services");
			$tb_services->add_element($this->services_form);
			$tab->add_tab($tb_services);

			$this->import_services_form= new import_services_subform("subform_3","Import service");
			$this->add_element($this->import_services_form);
			$this->import_services_form->visible= false;

			$this->import_multiple_services_form= new import_multiple_services_subform("subform_4","Import multiple services");
			$this->add_element($this->import_multiple_services_form);
			$this->import_multiple_services_form->visible= false;

			$this->add_element($tab);
		}

		$repository_form= $this;
	}

	public function get_multiple_services_id() {
		return $this->services_form->datawindow_services->multiple_services_rows;
	}

	public function get_service_id() {
		return $this->services_form->datawindow_services->services_row_id;
	}

	public function get_service_status() {
		return $this->services_form->datawindow_services->services_status;
	}
}


/**
 * Implements a form element to select a repository from a list.
 *
 */
class repository_selector extends form_element {

	public $repository_name;
	public $repository_id;
	public $show;

	private $repository_reference;
	private $cl_field;
	private $cl;


	public function repository_selector($name) {

		global $USER_LEVEL, $USER_GROUP;
		global $global_db;
		global $MESSAGES;

		parent::form_element($name);

		// Show only clusters that have, at least, one node suporting VPN
		$restriction= $USER_LEVEL > 0 ? "id_group ='$USER_GROUP'" : "";

		$this->repository_reference= new foreign_key($global_db,"repositories","id_repository","name", $restriction);
		$this->cl_field= new field("id_repository",$MESSAGES["REPOSITORY_FIELD_NAME"],"foreign_key",true,false,true,true,null,$this->repository_reference);
		$this->cl= new search_box(array($this->cl_field), "repository_search", " ", 1, false);
		$this->cl->help_text="";

		$this->add_element($this->cl);

		$this->repository_name= get_http_param("detail_name","");
		if($this->repository_name == "") {
			html_redirect(HOME . "/plugins/discoverer/admin/repositories.php");
			$this->repository_id= $this->get_repository_from_cl();
			$this->repository_name= get_repository_name($this->repository_id);
		} else {
			$this->repository_id= get_repository_id($this->repository_name);
		}
	}

	public function get_repository_from_cl() {
		return isset($this->cl->values["id_repository"]) ? $this->cl->values["id_repository"] : -1;
	}

	public function show_hidden() {

		echo "<input type='hidden' name='detail_name' value='" . $this->repository_name . "'>";
		parent::show_hidden();
	}
}
