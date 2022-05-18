<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage reports
 *
 * Alerts evolution on the last year (12 months).
 * Echo a png string, creating a graph that indicates how many alerts
 * have appeared on each month.
 */

	define("QUIET",true);		// Avoid init echos and html includes
	include "../../include/init.inc.php";
	include MY_INC_DIR . "/reports/graphs/alert_type.graph.php";

	$gr= new alert_type();
	$gr->render();
?>