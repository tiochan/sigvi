<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage news about vulnerabilities
 *
 * NVD version prior to 1.2 source plugin
 *
 * Based on the article "http://www.sitepoint.com/article/php-xml-parsing-rss-1-0" of Kevin Yank
 *
 */

/*
	This script is a modification of the original xml parser for NVD.NIST.GOV for the adaption to
	the SIGVI environment. At the end of the file is stored the original header message.
*/

	include_once INC_DIR . "/output.inc.php";
	include_once INC_DIR . "/classes/xml_reader.php";


	class rssItem extends xmlItem {

		public $title;
		public $link;
		public $description;
		public $date;

		public function store_it() {
			// Do you need to store anything?
		}
	}

	class RSSParser extends xmlParser {

		protected $title = "";
		protected $description = "";
		protected $link = "";
		protected $date = "";
		protected $pubdate = "";

		public function RSSParser($url, $max_items = 0) {
			parent::xmlParser($url, $null, $max_items);
		}

		protected function startElement($parser, $tagName, $attrs) {

			if(!$this->continue) return;

			if ($this->insideitem) {
				$this->tag = $tagName;
			} elseif ($tagName == "ITEM") {
				$this->insideitem = true;
				$this->xmlItems[]= new rssItem();
			}
		}

		protected function endElement($parser, $tagName) {

			if(!$this->continue) return;

			if ($tagName == "ITEM") {
				$this->xmlItems[count($this->xmlItems) - 1]->title= htmlspecialchars(trim($this->title));
				$this->xmlItems[count($this->xmlItems) - 1]->link= trim($this->link);
				//$this->xmlItems[count($this->xmlItems) - 1]->description= htmlspecialchars(trim($this->description));
				$this->xmlItems[count($this->xmlItems) - 1]->description= trim($this->description);

				if($this->date != "") {
					$this->xmlItems[count($this->xmlItems) - 1]->date= trim($this->date);
				} else {
					$parsed= date_parse($this->pubdate);
					if(strlen($parsed["month"])==1) $parsed["month"] = "0" . $parsed["month"];
					if(strlen($parsed["day"])==1) $parsed["day"] = "0" . $parsed["day"];
					$this->xmlItems[count($this->xmlItems) - 1]->date= $parsed["year"] . "-" . $parsed["month"] . "-" . $parsed["day"];
				}

				$this->title = "";
				$this->description = "";
				$this->link = "";
				$this->date = "";

				$this->insideitem = false;

				$this->counter++;
				if(($this->max != 0) and ($this->counter >= $this->max)) $this->continue= false;
			}
		}

		protected function characterData($parser, $data) {

		   	if(!$this->continue) return;

		   	if ($this->insideitem) {
		   		switch ($this->tag) {
		   			case "TITLE":
		   				$this->title .= $data;
		   				break;
		   			case "DESCRIPTION":
		   				$this->description .= $data;
		   				break;
		   			case "LINK":
		   				$this->link .= $data;
		   				break;
		   			case "DC:DATE":
		   				$this->date .= $data;
		   				break;
		   			case "PUBDATE":
		   				$this->pubdate .= $data;
		   				break;
		   		}
			}
		}
	}
