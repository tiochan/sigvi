<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage product_dictionaries
 *
 * Load the products from defined sources.
 * 
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=0;			// SIGVI ADMINS ONLY
	// $LOCATION_REQUIRED="192.168.0.23";

	/**
	 * This script can be called from command line or via Web.
	 * 
	 * - Comman line (cli), from cron tasks or directly (from shell)
	 * - Web, forcing the check process.
	 * 
	 */
	
	if(php_sapi_name() == "cli") {
		if(strpos($_SERVER["PHP_SELF"], "plugins/sources/products_test.php") !== false) {
			// direct call
			define("SYSHOME",dirname($_SERVER["PHP_SELF"]) . "/../../");

		} else {
			// Call from cron?
			define("SYSHOME",dirname($_SERVER["PHP_SELF"]) . "/../");
		}
		include_once SYSHOME . "/include/init.inc.php";
	} else {
		include_once "../../include/init.inc.php";
	}

	include_once INC_DIR . "/output.inc.php";
	include_once MY_INC_DIR . "classes/cpe_sources.class.php";


	if(CLI_MODE) define("QUIET",true);
	else html_header($MESSAGES["PRODUCT_DICTIONARIES_MGM_TITLE"]);

	load_products($errors, "", 15);

	if(!CLI_MODE) html_footer();
?>