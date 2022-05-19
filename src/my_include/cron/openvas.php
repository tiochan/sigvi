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
		
	#Auditar servidores no eliminados
	#$query="select * from servers where deleted='0'";
	
	#Auditar aquellos no previalmente auditados
	$query="select * from servers left outer join audit on audit.id_server=servers.id_server where audit.id_server is null and servers.deleted='0'";

	$res=$global_db->dbms_query($query);

	if($global_db->dbms_check_result($res)) {

		while($row=$global_db->dbms_fetch_array($res)) {
			
			$id_server=trim($row["id_server"]);
			$server_ip=trim($row["IP"]);
			$plugin="openvas";
			$class_name="discover_openvas";
			
			if(!file_exists(SYSHOME . "/plugins/discoverer/plugins/$plugin/$class_name.php")) {
				echo "**************\n";
				echo "Error, plugin $class_name not found.";
				echo "**************\n";
				return 0;
			}
			
			$number=rand(1000,9999);
			$cmd="nohup ssh root@$serveropenvas /root/executeOpenvasTask.sh $number $server_ip $number > /dev/null &";
			exec($cmd, $output, $ret);
			$output= system($cmd, $ret);
			if($ret!=0) die("Error executing $cmd");
			
		}
	}	

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
