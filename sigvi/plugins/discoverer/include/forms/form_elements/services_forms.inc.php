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

	include_once INC_DIR . "/forms/field.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once INC_DIR . "/forms/form_elements/label.inc.php";

	include_once DISCOVERER_DIR . "/classes/dw_repository_services.inc.php";


	class cancel_button extends button {

		public function clicked () {
		}
	}


	class import_button extends button {

		public function clicked () {

			global $USER_GROUP;
			global $discover_repository;
			global $repository_id;
			global $global_db;

			$remote_service_id= get_http_param("remote_service_id");
			$local_product_id= get_http_param("id_product");

			if(!$local_product_id) {
				html_showError("You must indicate the product.");
				return 0;
			}

			if(($service= $discover_repository->get_service($remote_service_id)) == null) {
				html_showError("[1] Service not found on repository<br>");
				return 0;
			}

			if(!$repository_id) {
				html_showError("Repository id is not set.<br>");
				return 0;
			}

			$service_status= get_http_param("service_status");

			switch($service_status) {
				case "import":

//					html_showInfo("Importing remote service id: $remote_service_id using local product id: $local_product_id<br>");

					if(is_service_imported($repository_id, $service->id_service, $USER_GROUP)) {
						html_showError("This service has been imported before.");
						return 0;
					}

					if(import_service($repository_id, $service, $local_product_id, $USER_GROUP)) {
						// Add to usual imported table
						$query="select name,product,version,extrainfo,port from current_services where id_service='$remote_service_id'";
						$res= $discover_repository->discover_db->dbms_query($query);

						list($name, $product, $version, $info, $port)=$discover_repository->discover_db->dbms_fetch_row($res);
						$discover_repository->discover_db->dbms_free_result($res);

						// Check if this enter is registered
						$query= "select * from usual_product_associations where id_group='$USER_GROUP' and ".
						        "name='$name' and " .
						        "product='$product' and " .
						        "version='$version' and " .
						        "port='$port' and " .
						        "info='$info' and " .
						        "local_id_product='$local_product_id'";
						$res= $global_db->dbms_query($query);
						if($global_db->dbms_check_result($res)) {

							$query= "update usual_product_associations set counter=counter + 1 where ".
								"id_group='$USER_GROUP' and ".
						        "name='$name' and " .
						        "product='$product' and " .
						        "version='$version' and " .
						        "info='$info' and " .
								"port='$port' and " .
						        "local_id_product='$local_product_id'";
							$global_db->dbms_free_result($res);
						} else {

							$query="insert into usual_product_associations (id_group, name, product, version, info, port, local_id_product) " .
						    	   "values('$USER_GROUP','$name', '$product', '$version', '$info', '$port', '$local_product_id')";
						}

						$global_db->dbms_query($query);

						html_showSuccess("Service imported successfully");
					} else {
						html_showError("The service has not been imported.");
					}

					break;

				case "update":

					html_showInfo("Updating remote service id: $remote_service_id using local product id: $local_product_id<br>");

					if(!is_service_imported($repository_id, $service->id_service, $USER_GROUP)) {
						html_showError("This service has not been imported before.");
						return 0;
					}

					if(update_service($repository_id, $service, $local_product_id, $USER_GROUP)) {
						html_showSuccess("Service updated successfully");
					} else {
						html_showError("The service has not been updated.");
					}

					break;

				default:
					html_showError("Unknown service status: $service_status<br>");
			}

			return 0;
		}
	}

	class import_multiple_button extends button {

		public function clicked () {

			global $USER_GROUP;
			global $discover_repository;
			global $repository_id;
			global $global_db;

			$remote_service_ids= get_http_param("remote_service_ids");
			$remote_services= explode(",",$remote_service_ids);

			$local_product_id= get_http_param("id_product");

			if(!$local_product_id) {
				html_showError("You must indicate the product.");
				return 0;
			}

			foreach($remote_services as $remote_service_id) {

				if(($service= $discover_repository->get_service($remote_service_id)) == null) {
					html_showError("[1] Service not found on repository<br>");
					return 0;
				}

				if(!$repository_id) {
					html_showError("Repository id is not set.<br>");
					return 0;
				}

				$service_status= get_http_param("service_status");

	//			html_showInfo("Importing remote service id: $remote_service_id using local product id: $local_product_id<br>");

				if(is_service_imported($repository_id, $service->id_service, $USER_GROUP)) {
					html_showError("This service has been imported before.");
					return 0;
				}

				if(import_service($repository_id, $service, $local_product_id, $USER_GROUP)) {
					// Add to usual imported table
					$query="select name,product,version,extrainfo,port from current_services where id_service='$remote_service_id'";
					$res= $discover_repository->discover_db->dbms_query($query);

					list($name, $product, $version, $info, $port)=$discover_repository->discover_db->dbms_fetch_row($res);
					$discover_repository->discover_db->dbms_free_result($res);

					// Check if this enter is registered
					$query= "select * from usual_product_associations where id_group='$USER_GROUP' and ".
					        "name='$name' and " .
					        "product='$product' and " .
					        "version='$version' and " .
					        "port='$port' and " .
					        "info='$info' and " .
					        "local_id_product='$local_product_id'";
					$res= $global_db->dbms_query($query);
					if($global_db->dbms_check_result($res)) {

						$query= "update usual_product_associations set counter=counter + 1 where ".
							"id_group='$USER_GROUP' and ".
					        "name='$name' and " .
					        "product='$product' and " .
					        "version='$version' and " .
					        "info='$info' and " .
							"port='$port' and " .
					        "local_id_product='$local_product_id'";
						$global_db->dbms_free_result($res);
					} else {

						$query="insert into usual_product_associations (id_group, name, product, version, info, port, local_id_product) " .
					    	   "values('$USER_GROUP','$name', '$product', '$version', '$info', '$port', '$local_product_id')";
					}

					$global_db->dbms_query($query);

					html_showSuccess("Service imported successfully");
				} else {
					html_showError("The service has not been imported.");
				}
			}

			return 0;
		}
	}

	/**
	 * Subform to host services datawindow
	 *
	 */
	class import_services_subform extends sub_form {

		public $multiple_service_ids;
		public $service_id;
		protected $dw_usual;
		protected $dw_ports;

		public function import_services_subform($name, $title) {

			global $global_db;
			global $USER_LEVEL, $USER_GROUP;
			global $MESSAGES;

			parent::sub_form($name, $title);

			$fields=array();
			$pl= new field_lookup(HOME . "/my_include/lookups/lookup_products.php");

			$fields[]= new field("id_product","Local product identifier","field_lookup", true, false, true,true,0,$pl);
			$fields[]= new field("remote_service_id","","hidden",false,false,true,false);
			$fields[]= new field("service_status","","hidden",false,false,true,false);

			$field_box= new field_box("field_box_import", "Select the appropiate product", $fields);
			$this->add_element($field_box);

			$btn= new import_button("import_button", "Import");
			$this->add_element($btn);

			$stp= new cancel_button("cancel_button", "Cancel");
			$this->add_element($stp);


			$this->dw_usual= new dw_usual_product_associations("Usual associations to this product");
			$this->add_element($this->dw_usual);

			$this->dw_ports= new dw_usual_product_associations("Usual associations to this port");
			$this->add_element($this->dw_ports);
		}

		public function show() {

			global $discover_repository;
			global $repository_id;
			global $MESSAGES;
			global $global_db;

			if(!$this->visible) return;

			$this->service_id= $this->parent->get_service_id();

			if(($service= $discover_repository->get_service($this->service_id)) == null) {
				html_showError("[2] Service not found on repository<br>");
				return 0;
			}

			if(!is_server_imported($repository_id, $service->id_server)) {
				html_showError("First you must import the server.<br>");
				return 0;
			}

			$server_name= get_remote_server_name($discover_repository, $service->id_server);


			$attribs= array("port","protocol","state","name","product","version","extrainfo","port","revision");



			echo "<table class='data_box_external'>";
			echo "<tr class='data_box_title'><td align='left' class='data_box_title'>Importing remote services</td></tr>";
			echo "<tr><td>\n";
			echo "<table class='data_box_rows' cellspacing='0'>";
			echo "<tr class='data_box_rows'><th class='data_box_rows'>Server</th><th class='data_box_rows'>$server_name</th></tr>\n";

			foreach($attribs as $attrib) {
				echo "<tr class='data_box_rows_tabular_odd'><td class='data_box_cell'><b>$attrib</b></td><td class='data_box_cell'>" . $service->$attrib . "</td></tr>\n";
			}

			echo "</table></td></tr></table>";

			$full_name= "";
			$full_name= $service->name != "" ? $service->name : $service->product;
			if($full_name != "") $full_name= "%" . $full_name . "%";

			if($service->version != "") $full_name.= " and %" . $service->version . "%";

			$this->descents["field_box_import"]->fields[0]->reference->add_parameter("search_full_name",$full_name);

			$restriction= "(usual_product_associations.name like '%" . $service->name . "%' and ".
						  " usual_product_associations.product like '%" . $service->product . "%' and ".
						  " usual_product_associations.version like '%" . $service->version . "%')";
			$this->dw_usual->add_restriction($restriction);

			$restriction= "(usual_product_associations.port='" . $service->port . "')";
			$this->dw_ports->add_restriction($restriction);

			parent::show();
			$this->descents["field_box_import"]->fields[1]->set_form_value($this->form_name, $this->service_id);

			$service_status= $this->parent->get_service_status();
			$this->descents["field_box_import"]->fields[2]->set_form_value($this->form_name, $service_status);
		}
	}

	/**
	 * Subform to host services datawindow
	 *
	 */
	class import_multiple_services_subform extends sub_form {

		public $multiple_service_ids;
		public $service_id;
		protected $dw_usual;
		protected $dw_ports;

		public function import_multiple_services_subform($name, $title) {

			global $global_db;
			global $USER_LEVEL, $USER_GROUP;
			global $MESSAGES;

			parent::sub_form($name, $title);

			$fields=array();
			$pl= new field_lookup(HOME . "/my_include/lookups/lookup_products.php");

			$fields[]= new field("id_product","Local product identifier","field_lookup", true, false, true,true,0,$pl);
			$fields[]= new field("remote_service_ids","","hidden",false,false,true,false);
//			$fields[]= new field("service_status","","hidden",false,false,true,false);

			$field_box= new field_box("field_box_import_multiple", "Select the appropiate product", $fields);
			$this->add_element($field_box);

			$btn= new import_multiple_button("import_multiple_button", "Import");
			$this->add_element($btn);

			$stp= new cancel_button("cancel_button2", "Cancel");
			$this->add_element($stp);


			$this->dw_usual= new dw_usual_product_associations("Usual associations to this product");
			$this->add_element($this->dw_usual);

			$this->dw_ports= new dw_usual_product_associations("Usual associations to this port");
			$this->add_element($this->dw_ports);
		}

		public function show() {

			global $discover_repository;
			global $repository_id;
			global $MESSAGES;
			global $global_db;

			if(!$this->visible) return;

			$this->multiple_service_ids= $this->parent->get_multiple_services_id();

			// Multiple selection import
			if(!$this->multiple_service_ids or !count($this->multiple_service_ids)) {
				html_showError("No rows selected");
				return 0;
			}

			$attribs= array("port","protocol","state","name","product","version","extrainfo","port","revision");

			echo "<table class='data_box_external'>";
			echo "<tr class='data_box_title'><td align='left' class='data_box_title'>Importing multiple remote services</td></tr>";
			echo "<tr><td>\n";
			echo "<table class='data_box_rows' cellspacing='0'>";
			echo "<tr class='data_box_rows'>";

			echo "<th class='data_box_rows'>Server</th>";
			foreach($attribs as $attrib) {
				echo "<th class='data_box_rows'>$attrib</th>\n";
			}
			echo "</tr>";

			$first_service=null;
			$service_ids="";
			$add="";

			for($i=0; $i < count($this->multiple_service_ids); $i++) {

				$service_id= $this->multiple_service_ids[$i];

				echo "<tr class='data_box_rows_tabular_odd'>";

				if(($service= $discover_repository->get_service($service_id)) == null) {
					echo "<td class='data_box_rows' colspan='" . count($attribs) + 2 . "'>";
					echo "[2] Service not found on repository";
					echo "</td></tr>\n";
					$this->multiple_service_ids[$i]=-1;
					continue;
				}

				if(!isset($first_service)) $first_service= $service;

				$server_name= get_remote_server_name($discover_repository, $service->id_server);
				echo "<td class='data_box_cell'>$server_name</td>";

				if(!is_server_imported($repository_id, $service->id_server)) {
					echo "<td class='data_box_rows' colspan='" . count($attribs) + 1 . "'>";
					echo "This server is not imported";
					echo "</td></tr>";
					$this->multiple_service_ids[$i]=-1;
					continue;
				}

				foreach($attribs as $attrib) {
					echo "<td class='data_box_cell'>" . $service->$attrib . "</td>";
				}

				echo "</tr>";

				$service_ids.=$add . $service_id;
				$add=",";
			}

			echo "</table></td></tr></table>";

			$full_name= "";
			$full_name= $first_service->name != "" ? $first_service->name : $first_service->product;
			if($full_name != "") $full_name= "%" . $full_name . "%";

			if($first_service->version != "") $full_name.= " and %" . $first_service->version . "%";

			$this->descents["field_box_import_multiple"]->fields[0]->reference->add_parameter("search_full_name",$full_name);

			$restriction= "(usual_product_associations.name like '%" . $first_service->name . "%' and ".
						  " usual_product_associations.product like '%" . $first_service->product . "%' and ".
						  " usual_product_associations.version like '%" . $first_service->version . "%')";
			$this->dw_usual->add_restriction($restriction);

			$restriction= "(usual_product_associations.port='" . $first_service->port . "')";
			$this->dw_ports->add_restriction($restriction);

			parent::show();
			$this->descents["field_box_import_multiple"]->fields[1]->set_form_value($this->form_name, $service_ids);

//			$service_status= $this->parent->get_service_status();
//			$this->descents["field_box_import_multiple"]->fields[2]->set_form_value($this->form_name, $service_status);
		}
	}


	class dw_usual_product_associations extends datawindow_ext {

		public function dw_usual_product_associations($title) {

			global $global_db;
			global $MESSAGES, $USER_GROUP, $USER_LEVEL;

			// Datawindow Query
			$qry= new datawindow_query();

			$restriction= $USER_LEVEL > 0 ? "(usual_product_associations.id_group='$USER_GROUP' or usual_product_associations.id_group is null)" : "";
			$fields= array();
			$fields[]= new field_ext("usual_product_associations.local_id_product","","auto",false,false,0,false);
			$fields[]= new field_ext("usual_product_associations.name","Name","string",false,false,3,false);
			$fields[]= new field_ext("usual_product_associations.product","Product","string",false,false,4,false);
			$fields[]= new field_ext("usual_product_associations.version","Version","string",false,false,5,false);
			$fields[]= new field_ext("usual_product_associations.info","Info","string",false,false,6,false);
			$fields[]= new field_ext("usual_product_associations.port","Port","string",false,false,7,false);
			$fields[]= new field_ext("usual_product_associations.counter","Instances","string",false,false,1,false);

			// Creation of table and add it to query
			$table_usual= new datawindow_table("usual_product_associations", $fields, 0, false, false, false);
			$table_usual->add_custom_restriction($restriction);
			$qry->add_table($table_usual);

			$fields2= array();
			$fields2[]= new field_ext("products.id_product","","auto",false,false,0,false);
			$fields2[]= new field_ext("products.full_name","Local product","string",false,false,2,false);
			$table_products= new datawindow_table("products", $fields2, 0, false, false, false);
			$qry->add_table($table_products);

			$qry->add_join($table_usual, 0, $table_products, 0, $operator="=");

			parent::datawindow_ext($qry,0,$title);

			$this->nav_enabled=false;
			$this->show_no_rows=false;
			$this->show_toolbar=false;
		}

		public function post_show_row($values) {

			global $MESSAGES;
			global $global_db;

			$prod_id= $values["row_id"];
			$description= $values["products.full_name"];

			$onclick="set_value(\"description_id_product\", \"$description\");set_value(\"id_product\", \"$prod_id\")";
			echo "<img class='action' src='/include/images/icons/next.png' alt='Ok' title='Ok' align='absmiddle' onclick='$onclick'>\n";
		}

		public function add_restriction($restriction) {
			$this->datawindow_query->add_custom_restriction($restriction);
		}
	}

	/**
	 * Subform to host services datawindow
	 *
	 */
	class services_subform extends sub_form {

		public $fields;
		public $datawindow_services;
		public $selector;
		public $group_reference;
		public $search_box;

		public function services_subform($name, $title) {

			global $discover_repository;

			$this->datawindow_services= new services_datawindow($discover_repository->discover_db);
			$this->add_element($this->datawindow_services);
			$this->datawindow_services->export_allowed= true;
		}

		public function show() {

			$this->visible=true;
			parent::show();
		}
	}
?>