<?php
/*
	Author: Sebastian Gomez, (tiochan@gmail.com)
	For: Politechnical University of Catalonia (UPC), Spain.

	Cron script example
	You own scripts must be placed at my_include/cron
*/


	define("CLI_REQUIRED",true);
	define("QUIET",true);

	$dir= dirname($_SERVER["PHP_SELF"]);
	define("SYSHOME", $dir . "/../..");

	include_once SYSHOME . "/include/init.inc.php";

	$return_code=0;			// 0: ok, [1,2, ...] : error
	$serveropenvas=OpenVASServer;
	echo "\n\nProcess started at " . date("Y-m-d h:i:s") . "\n";
	echo "----------------------------------------------------\n\n";
	
	
	$cmd="ssh root@".$serveropenvas." '/root/getAllReportXML.sh'; scp root@".$serveropenvas.":/tmp/reports/* " . SYSHOME . "/plugins/discoverer/plugins/openvas/XML";
	exec($cmd, $output, $ret);
	$output= system($cmd, $ret);
	if($ret!=0) die("Error executing $cmd");
	
	$dir = new DirectoryIterator(SYSHOME . "/plugins/discoverer/plugins/openvas/XML");
	foreach ($dir as $fileinfo) {
		$filename=$fileinfo->getFilename();
		if ($filename!="." && $filename!=".."){	
	        $plugin="openvas";
	        $class_name="discover_openvas";		
	        include_once SYSHOME . "/plugins/discoverer/plugins/$plugin/$class_name.php";
			$discover_plugin= new $class_name($filename);
			$discover_plugin->go();
			$discover_plugin->save();   
		}
	}
	
	$cmd="ssh root@".$serveropenvas." 'rm -f /tmp/reports/*' ; rm -f " . SYSHOME . "/plugins/discoverer/plugins/openvas/XML/*";
	exec($cmd, $output, $ret);
	$output= system($cmd, $ret);
	if($ret!=0) die("Error executing $cmd");

	/*
	 * Perhaps you want to send a report about execution:
	 *
	 * 	include_once SYSHOME . "/include/mail.inc.php";
	 *
	 * 	$subject= "<any subject>";
	 *  $content= "The content to send"
	 * 	// Now send mail to admins.
	 * 	send_group_mail(0, $subject,$content, "html");
	 */

	echo "\n\n----------------------------------------------------\n";
	echo "Process finished at " . date("Y-m-d h:i:s") . "\n";
	exit($return_code);
