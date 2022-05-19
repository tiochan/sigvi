<?php
/*
	Author: Sebastian Gomez, (tiochan@gmail.com)
	For: Politechnical University of Catalonia (UPC), Spain.

	Discover plugin configuration

	Requires to be loaded:

	- init.inc.php
*/

/*******************************************
 *	Discover configuration
 *******************************************/

/**
 * if true then the nmap discover plugin will attempt to get the
 * OS of the remote host. It will increase a lot the time of scan.
 * It might be
 */

define("DISCOVER_OPENVAS_RESULT_TMP_DIR", SYSHOME . "/plugins/discoverer/plugins/openvas");
