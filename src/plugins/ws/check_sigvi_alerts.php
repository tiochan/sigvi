<?php

	define("WS_LOCATION","http://sigvides.upc.edu:83/plugins/ws/sigvi_ws.php");
	define("WS_URI","check_alerts");
	define("ALERT_FAS_LEVEL",8);

	function show_usage() {
		global $argv;

		echo "Usage: " . $argv[0] . " <ip> [<warn_val> <crit_val>]\n";
		echo " - if set, crit_val must be greater than warn_val\n";
		exit(3);
	}

	if($argc < 2) show_usage();

	$ip= $argv[1];

	if($argc > 2) {
		if($argc < 4) show_usage();

		$warn= intval($argv[2]);
		$crit= intval($argv[3]);

		if($warn >= $crit) show_usage();
	} else {
		$warn= $crit= -1;
	}

	try {
		$cliente = new SoapClient(null, array(
				'location' => WS_LOCATION,
                'uri'      => WS_URI)
            );

		$result= $cliente->getServerAlerts($ip, ALERT_FAS_LEVEL);
	} catch (SoapFault $e) {
		echo "Excepcion: $e";
		exit(3);
	}

	if(is_numeric($result)) {
		$num_alerts= intval($result);

		if($warn >= 0 and $crit >= 0) {
			if($num_alerts >= $crit) { echo "CRITICAL: "; $ret=2; }
			elseif($num_alerts >= $warn) { echo "WARNING: "; $ret=1; }
			else { echo "OK: "; $ret=0; }
		} else {
			$ret=0;
		}

		echo "Num alerts: $num_alerts (with alert level greater than " . ALERT_FAS_LEVEL . ") | $num_alerts\n";
		exit($ret);
	} else {
		echo "$result\n";
		exit(3);
	}
?>
