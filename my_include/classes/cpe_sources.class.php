<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage sources
 *
 * CPE Source definition class
 *
 */

	function load_products(&$errors, $id_source="", $test_mode=false) {

		global $global_db;
		global $MESSAGES;


		$max_items= $test_mode ? 15:0;
		$errors="";
		$all_ok= true;

		if($id_source!="") {
			$query="select * from product_sources where id_source='$id_source'";
		} else {
			$query="select * from product_sources where use_it = '1'";
		}

		$res=$global_db->dbms_query($query);
		if($global_db->dbms_check_result($res)) {

			while($row=$global_db->dbms_fetch_array($res)) {

				$error="";

				$id_source= $row["id_source"];
				$name= $row["name"];
				$description= $row["description"];
				$parser= $row["parser"];
				$parameters= $row["parameters"];
				$use_it= $row["use_it"];

				$current_output="<HLINE><FONT color='gray'>Downloading vulnerabilities from source:<LINE_BREAK>" .
					 " - id_source: $id_source<LINE_BREAK>" .
					 " - <BOLD>name: $name</BOLD><LINE_BREAK>" .
					 " - description: $description<LINE_BREAK>" .
					 " - parser: $parser<LINE_BREAK>" .
					 " - parameters: $parameters<LINE_BREAK>" .
					 " - use_it: $use_it</FONT><LINE_BREAK><LINE_BREAK>\n";

				if(!CLI_MODE) my_echo($current_output);

				if($test_mode or $use_it=='1' or $id_source!="") {

					unset($cpe_parser_class_name);

					{
						require_once SYSHOME . "/plugins/sources/product_dictionaries/" . $parser;

						if(!isset($cpe_parser_class_name)) {
							$error="Error, variable cpe_parser_class_name not initialized on parser $parser";
						} else {

							$inst_cpe= new $cpe_parser_class_name($parameters,$global_db,$max_items);

							if(!$inst_cpe->read_xml()) {
								$error="Error reading dictionary $name.<LINE_BREAK>";
								$all_ok= false;
							} else {

								if($test_mode) {
									foreach($inst_cpe->xmlItems as $item) {
										$vars= get_object_vars($item);
										foreach($vars as $key => $value) {
											if(!CLI_MODE) my_echo("<BOLD>$key:</BOLD> $value<LINE_BREAK>");
										}
										if(!CLI_MODE) my_echo("<HLINE>");
									}
								} else {
									$inst_cpe->store_data();
								}
							}
						}
					}

					if($error!="") {
						log_write("LOAD PROD",$error,0);
						$errors.= "<PARAGRAPH>" . $error . "</PARAGRAPH>";
						if(!CLI_MODE) my_echo($error . "<LINE_BREAK>");
					}
				} else {
					$error= "<FONT color='#AA6666'><BOLD><ITALIC>This source is not enabled</ITALIC></BOLD></FONT>";
					if(!CLI_MODE) my_echo($error);
				}
			}

			$errors.= $error;

		} else {
			$errors= "No active sources found.";
			return 0;
		}

		return $all_ok;
	}
?>