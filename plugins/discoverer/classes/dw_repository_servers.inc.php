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

	include_once SYSHOME . "/include/forms/field.inc.php";
	include_once INC_DIR . "/forms/form_elements/datawindow.inc.php";
	include_once INC_DIR . "/forms/form_elements/search_box.inc.php";


	/**
	 * Servers datawindow
	 *
	 */
	class servers_datawindow extends datawindow {


		public function post_show_row($values) {

			global $repository_id;

			if(!isset($repository_id)) die("Repository id not set");
	
			if(!is_server_imported($repository_id,$values["id_server"])) {
				echo $this->create_row_action("Import","import_server",$values["row_id"], DISCOVERER_WEB_DIR . "/icons/import.png");
			} else {
				echo $this->create_row_action("Unlink","unlink_server", $values["row_id"], DISCOVERER_WEB_DIR . "/icons/delete.png");
			}
		}

		
		public function action_import_server($row_id) {

			global $discover_repository;
			global $repository_id;
			global $global_db;
			global $USER_GROUP;
			global $USER_GROUP_NAME;
			
			if(!isset($discover_repository)) die("Discover repository not set");
			if(!isset($repository_id)) die("Repository id not set");

			if(($server= $discover_repository->get_server($row_id)) == null) {
				html_showError("Server not found on repository<br>");
				return 0;
			}

			if(is_server_imported($repository_id,$server->id_server)) {
				html_showError("This server is already imported.");
				return 0;
			}

			// $repository_id= $this->parent->parent->descents["repository_selector"]->repository_id;
			if(!$repository_id) {
				html_showError("Repository id is not set.<br>");
				return 0;
			}

			if(import_server($repository_id, $server, $USER_GROUP)) {
				html_showSuccess("Server " . $server->hostname . " imported successfully to group $USER_GROUP_NAME");
			} else {
				html_showError("The server has not been imported.");
			}

			return 0;
		}

		public function action_unlink_server($row_id) {

			global $USER_GROUP;
			global $discover_repository;
			global $repository_id;

			if(!isset($discover_repository)) die("Discover repository not set");
			if(!isset($repository_id)) die("Repository id not set");
			
			if(($server= $discover_repository->get_server($row_id)) == null) {
				html_showError("Server not found on repository<br>");
				return 0;
			}

			if(unlink_imported_server($repository_id, $server, $USER_GROUP)) {
				html_showSuccess("Server relationship from " . $server->hostname . " has been deleted successfully.");
			} else {
				html_showError("The relationship has not been deleted.");
			}
		}
	}
?>