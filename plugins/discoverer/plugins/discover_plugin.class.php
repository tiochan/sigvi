<?php
/*
	Author: Sebastian Gomez, (tiochan@gmail.com)
	For: Politechnical University of Catalonia (UPC), Spain.

	Network services discover tool.

	This script will write on the standard output --different-- DESTINATION_IP:DESTINATION_PORT from the network indicated
	as parameters.

	Using it you can discover the usual services on your network.

*/

// include_once SYSHOME . "/conf/discoverer.conf.php";
include_once SYSHOME . "/include/init.inc.php";
include_once SYSHOME . "/conf/discover.conf.php";
include_once DISCOVERER_DIR . "/classes/discover.class.php";
class discover_plugin {

	/**
	 * Host array of discover_server objects
	 *
	 * @var discover_server
	 */

	public $id_server;
	public $report;


	/**
	 * Constructor for basic discoverer plugin
	 *
	 * @param string $host, The server/network name
	 * @param discover_repository $discover_repository
	 * @param string $override_parameters, if this instance will override general plugin parameters
	 * @return discover_plugin
	 */
	public function discover_plugin($id_server) {

		$this->id_server=0;
		$this->report="";
	}

	// To implement at inherited classes (plugins)
	public function go() {	}

	public function save() {  }
}
