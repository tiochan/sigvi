<?php
/*
	Author: Sebastian Gomez, (tiochan@gmail.com)
	For: Politechnical University of Catalonia (UPC), Spain.

	Parses the XML format of nmap output.

*/

include_once SYSHOME . "/include/init.inc.php";
include_once SYSHOME . "/conf/discover.conf.php";
include_once DISCOVERER_DIR . "/classes/discover.class.php";




class openvas_xml_parser {

	/**
	 * Discover plugin
	 *
	 * @var discover_plugin
	 */

	private $dp;
	private $depth;
	private $aux_audit;
	private $last_result;
	private $all_data;
	private $fp;
	private $xml_parser;

	private function parser_threat($result_threat) {
		$result_threat=trim($result_threat);
		switch($result_threat) {
			case "High":
				return 3;
			case "Medium":
				return 2;
			case "Low":
				return 1;
		}
		return 1;
	}

	public function openvas_xml_parser(&$discover_plugin) {

		$this->last_result=0;
		$this->all_data='';
		$this->dp=$discover_plugin;
	}


	public function parse_file($file) {
		global $global_db;
		require_once SYSHOME . "/include/dbms/mysqli.class.php";
		$dbtype= "mysqli_class";
		$this->repository_db= new $dbtype() or die("ERROR: couldn't create DBMS Object");

		// load xml
		if ($xml = simplexml_load_file($file)) {

			$report = $xml->report->report;

			$results=$report->results;


			$timestamp_end_scan = date("y-m-d 00:00:00");
			$total_high=$report->result_count->hole->full;
			$total_medium=$report->result_count->warning->full;
			$total_low=$report->result_count->info->full;
			$ip_host=$report->host_start->host;
			$query="select id_server from servers where IP='$ip_host'";
			$res= $global_db->dbms_query($query);
			$line = $global_db->dbms_fetch_array($res);
			$id_server=$line[0];

			$result_cpe = $xml->xpath('//port[.="general/CPE-T"]/ancestor::result');
			$cpe_list=$result_cpe[0]->description;


			/*$lista_cpe=explode("\n",trim($cpe_list));
			  foreach($lista_cpe as $cpe){
				  $cpe=explode("|",$cpe);
				$cpe=explode(":",$cpe[1]);
				$vendor=$cpe[2];
				$product=$cpe[3];
				$version=$cpe[4];
				$query= "select * from imported_servers where local_id_server=".$id_server;
				$res= $global_db->dbms_query($query);
				$row = $global_db->dbms_fetch_array($res);
				if($row){
					$id_repository=$row['id_repository'];
					   $remote_id_server=$row['remote_id_server'];
					$query= "select * from repositories where id_repository=".$id_repository;
					$res= $global_db->dbms_query($query);
					$row = $global_db->dbms_fetch_array($res);
					if($row){
					  $name_repository="repository_".$row['name'];
					  $dbserver_repository=$row['dbserver'];
					  $dbtype_repository=$row['dbtype'];
					  $dbuser_repository=$row['dbuser'];
					  $dbname_repository=$row['dbname'];
					  $dbpass_repository=$row['dbpass'];

					  $this->repository_db->dbms_connect($dbserver_repository, $dbuser_repository, $dbpass_repository, false, true) or die("Cant connect to discover database server on $dbserver_repository");
					  $this->repository_db->dbms_select_db($name_repository) or die("Cant connect to discover database $name_repository.");
					  $query1= "select count(*) from current_services where product='".$product."' and version='".$version."'";
					  $res1= $this->repository_db->dbms_query($query1) or die(mysql_error());
					  $line1 = $this->repository_db->dbms_fetch_array($res1);
					  if ($line1[0]==0){
						  $query2="insert into current_services (id_server,d_date,port,protocol,state,name,product,version) values ('$remote_id_server',now(),0,'null','open','$product','$product','$version');";
						  $res2= $this->repository_db->dbms_query($query2);
					  }
					  }
				}*/

			$query= "insert into audit (id_server,high,medium,low,list_cpe,audit_date,deleted,revision) values ('$id_server','$total_high','$total_medium','$total_low','$cpe_list','$timestamp_end_scan',0,0);";
			$res= $global_db->dbms_query($query);
			$query= "select MAX(id_audit) from audit";
			$res= $global_db->dbms_query($query);
			$line = $global_db->dbms_fetch_array($res);
			$id_au=$line[0];


			foreach ($results->result as $result) {

				if ($result->threat!="Log" && $result->port!="general/CPE-T" && $result->port!="general/HOST-T" && $result->nvt->name!="Services" && $result->nvt->name!="Traceroute" ) {
					$port=$result->port;
					$result_threat=$result->threat;
					$result_threat=trim($result_threat);
					switch($result_threat) {
						case "High":
							$threat=3;
							break;
						case "Medium":
							$threat=2;
							break;
						case "Low":
							$threat=1;
							break;
					}
					$nvt=$result->nvt;
					$nvt_oid=$nvt['oid'];
					$nvt_name=$nvt->name;
					$nvt_name=str_replace("'", "''", $nvt_name);
					$risk_factor=$nvt->risk_factor;
					$cve=$nvt->cve;
					$bid=$nvt->bid;
					$description=$result->description;
					$description=str_replace("'", "''", $description);

					if(ereg("References:",$description))
					{
						$cadena1=explode("References:", $description);
						if(ereg("CVE",$cadena1[1])) {
							$cadena2=explode("CVE",$cadena1[1]);
							$references=trim($cadena2[0]);
						}
						$description=trim($cadena1[0]);
					}
					if(ereg("Fix:",$description))
					{
						$cadena2=explode("Fix:", $description);
						$fix=$cadena2[1];
						$description=trim($cadena2[0]);
					}
					if(ereg("Solution:",$description))
					{
						$cadena2=explode("Solution:", $description);
						$fix=$cadena2[1];
						$description=trim($cadena2[0]);
					}

					$query= "insert into audit_result (id_audit,port,name,nvt_id,vuln_id,bid,risk_factor,threat,description,solution,reference,deleted,revision) values ('$id_au','$port','$nvt_name','$nvt_oid','$cve','$bid','$risk_factor','$threat','$description','$fix','$references',0,0);";
					$res= $global_db->dbms_query($query);
				}
			}
		} else {
			echo "Error Loading File: " . $file;
			return 0;
		}
		return 1;
	}
}