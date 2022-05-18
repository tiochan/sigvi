<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage conf
 *
 * Main application configuration.
 */

/*******************************************
 *	Current application configuration
 *******************************************/

/**
 * SERVER_DELETE_RESTRICTION
 *
 * What to do when a server is going to be deleted.
 * Options:
 *
 * - CASCADE: delete the products and alerts associated with it
 * - RESTRICT: stop deleting if alerts or products are associated with it
 * - LOGICAL: dont delete, only mark server as deleted, so will not appear on
 *   the servers list
 */
define("SERVER_DELETE_RESTRICTION","LOGICAL");
define("DEFAULT_FAS","BS");
define("SEND_VOID_VULN_REPORT",false);
