<?php

	include "../../include/init.inc.php";

	$tpl= new template("full_report");
	$tpl->set_vars(array(
			"VULN_LAST_MONTH" => 1000,
			"ALERT_LAST_MONTH" => 100,
			"ALERT_TOTAL" => 500,
			"ALERT_TOTAL_DISCARDED" => 25,
			"ALERT_OPENED" => 35,
			"VULN_INCR_DECR_STR"=> "incremento",
			"INCR_DECR_DEC"=> 15,
			"VULN_TOTAL" => 54390
		)
	);


	$html = $tpl->show();
	echo $html;

?>