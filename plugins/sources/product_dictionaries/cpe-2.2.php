<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage news about vulnerabilities
 *
 * CPE schema version 2.2
 *
 */

/*
	This script is a modification of the original xml parser for NVD.NIST.GOV for the adaption to
	the SIGVI environment. At the end of the file is stored the original header message.
*/

	include_once INC_DIR . "/output.inc.php";
	include_once INC_DIR . "/classes/xml_reader.php";
	
	$cpe_parser_class_name="cpe22";

	/**
	 *     <cpe-item name="cpe:/a:3com:3c16115-us:2.01">
	 *         <title xml:lang="en-US">3Com WebCache 1000 2.01</title>
	 *         <meta:item-metadata modification-date="2008-04-01T12:09:27.607-04:00" status="DRAFT" nvd-id="12602" />
	 *     </cpe-item>
	 */
	class cpeItem22 extends xmlItem {

		public $name;
		public $title;
		public $modification_date;
		public $status;
		public $nvd_id;

		public $part;
		public $vendor;
		public $product;
		public $version;


		public function parse_name() {

			list($part1, $part2) = explode("/", $this->name);
			$list= explode(":",$part2);

			$this->part= isset($list[0]) ? $list[0] : "";
			$this->vendor= isset($list[1]) ? $list[1] : "";
			$this->product= isset($list[2]) ? $list[2] : "";
			$this->version= isset($list[3]) ? $list[3] : "";
		}

		public function store_it() {

			if(!defined("QUIET")) {
				my_echo($this->name . ", " . $this->modification_date);
			}

			if($this->version == "") {
				if(!defined("QUIET"))
					my_echo("<FONT color='maroon'> - Incomplete product name (without version), skipping</FONT><LINE_BREAK>");
				return 0;
			}

			$query="select *
					from cpe_products
					where nvd_id='$this->nvd_id' and
						  modification_date >= '$this->modification_date'";

			$res=$this->db->dbms_query($query);
			if($this->db->dbms_check_result($res)) {
				// Yes, then do nothing
				if(!defined("QUIET"))
					my_echo("<FONT color='maroon'> - Same or more recent version exists, skipping</FONT><LINE_BREAK>");
				$this->db->dbms_free_result($res);
				return 0;
			}

			$query="delete from cpe_products where nvd_id='$this->nvd_id'";
			$this->db->dbms_query($query);

			$query="insert into cpe_products (
						name,
						part,
						vendor,
						product,
						version,
						title,
						modification_date,
						status,
						nvd_id)
				   values (
				   		'$this->name',
				   		'$this->part',
				   		'$this->vendor',
				   		'$this->product',
				   		'$this->version',
				   		'$this->title',
				   		'$this->modification_date',
				   		'$this->status',
				   		'$this->nvd_id')";

			$this->db->dbms_query($query);

			if(!defined("QUIET")) {
				if($this->db->dbms_affected_rows()) {
					my_echo("<FONT color='blue'> - Added</FONT><LINE_BREAK>");
				} else {
					my_echo("<FONT color='red'> - Not added</FONT><LINE_BREAK>");
				}
			}

			return 1;
		}
	}

	class cpe22 extends xmlParser {

		public $URL;
		public $max;

		protected $insideitem = false;
		protected $tag = "";
		protected $attrs;

		protected $name = "";
		protected $title = "";
		protected $modifation_date = "";
		protected $status = "";
		protected $nvd_id = "";

		public function cpe22($url, &$db, $max_items = 0) {
			parent::xmlParser($url, $db, $max_items);
		}

		protected function startElement($parser, $tagName, $attrs) {

			if(!$this->continue) return;

			if ($this->insideitem) {
				$this->tag = $tagName;

				if($tagName == "META:ITEM-METADATA") {
					$this->modifation_date= $attrs["MODIFICATION-DATE"];
					$this->status= $attrs["STATUS"];
					$this->nvd_id= $attrs["NVD-ID"];
				}

			} elseif ($tagName == "CPE-ITEM") {
				$this->insideitem = true;
				$this->xmlItems[]= new cpeItem22();

				$this->name= $attrs["NAME"];
			} elseif ($tagName == "CPE-LIST") {

				if($this->max) {
					echo "<font color='blue'>PARSER " . basename(__FILE__) . "</font><br>";
					echo "<font color='gray'>Checking XML version, [2.1 expected]: </font>";
				}

				$this->continue= $this->check_version($attrs);

				if(!$this->continue) {

					$error= "CRITICAL: XML file has not the correct version, parser: " . basename(__FILE__) . "<LINE_BREAK>";
					$output="<FONT color='red'>" .
							$error .
							"Dictionary will not be used correctly<LINE_BREAK>" .
							"</FONT>";

					if($this->max) {		// If testing mode
						my_echo("ERROR<LINE_BREAK>");
						my_echo($output);
					} else {				// Batch mode, send mail to administrators
						include_once INC_DIR . "mail.inc.php";
						send_admins_mail($error, $error, $output, DEFAULT_EMAIL_METHOD);
					}
				}
			}
		}

		protected function endElement($parser, $tagName) {

			if(!$this->continue) return;

			switch($tagName) {

				case "CPE-ITEM":

					$this->xmlItems[count($this->xmlItems) - 1]->name= htmlspecialchars(trim($this->name));
					$this->xmlItems[count($this->xmlItems) - 1]->title= trim($this->title);
					$this->xmlItems[count($this->xmlItems) - 1]->status= trim($this->status);
					$this->xmlItems[count($this->xmlItems) - 1]->nvd_id= trim($this->nvd_id);

					$this->modifation_date= trim($this->modifation_date);

					if($this->modifation_date != "") {
						$parsed= date_parse($this->modifation_date);

						if(strlen($parsed["month"])==1) $parsed["month"] = "0" . $parsed["month"];
						if(strlen($parsed["day"])==1) $parsed["day"] = "0" . $parsed["day"];
						$this->xmlItems[count($this->xmlItems) - 1]->modification_date= $parsed["year"] . "-" . $parsed["month"] . "-" . $parsed["day"];
					} else {
						$this->xmlItems[count($this->xmlItems) - 1]->modification_date= "";
					}

					$this->xmlItems[count($this->xmlItems) - 1]->parse_name();

					$this->name = "";
					$this->title = "";
					$this->modifation_date = "";
					$this->status = "";
					$this->nvd_id = "";

					$this->insideitem = false;

					$this->counter++;
					if(($this->max != 0) and ($this->counter >= $this->max)) $this->continue= false;

					break;
			}
		}

		protected function characterData($parser, $data) {

		   	if(!$this->continue) return;

		   	if ($this->insideitem) {
		   		switch ($this->tag) {
		   			case "TITLE":
		   				$this->title .= $data;
		   				break;
		   		}
			}
		}

		protected function check_version($cpe_list_attrs) {

			if(!isset($cpe_list_attrs["XSI:SCHEMALOCATION"])) return false;
			return (strpos($cpe_list_attrs["XSI:SCHEMALOCATION"], "cpe-dictionary_2.2.xsd") !== false);
		}
	}
?>