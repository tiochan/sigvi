<?php
/*
	Author: Sebastian Gomez, (tiochan@gmail.com)
	For: Politechnical University of Catalonia (UPC), Spain.

	Network services discover tool.

	This script will write on the standard output --different-- DESTINATION_IP:DESTINATION_PORT from the network indicated
	as parameters.

	Using it you can discover the usual services on your network.

*/

	include_once SYSHOME . "/plugins/discoverer/plugins/discover_plugin.class.php";
	include_once SYSHOME . "/plugins/discoverer/plugins/openvas/openvas.conf.php";
	include_once SYSHOME . "/plugins/discoverer/plugins/openvas/openvas_output_parser.php";


	class discover_openvas extends discover_plugin  {

		private $file;
		

		public function discover_openvas ($filename) {

			parent::discover_plugin($filename);
			$this->file= DISCOVER_OPENVAS_RESULT_TMP_DIR . "/XML/".$filename;
			
			//DESCOMENTAR ESTA LINEAAAA
			//file_exists($this->file) and unlink($this->file);	
			file_exists($this->file);
		}

		public function go() {

			$parser= new openvas_xml_parser($this);
			$parser->parse_file($this->file);
			//unlink($this->file);
		}
	}
