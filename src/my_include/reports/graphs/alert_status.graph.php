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

	if(!defined("QUIET")) define("QUIET",true);		// Avoid init echos and html includes

	include_once INC_DIR . "/reports/graphs/report_graph.class.php";


	class alert_status extends report_graph {

		public function render($filename="") {

			global $MESSAGES, $global_db;


			//$title=$MESSAGES["ALERT_COUNTER"] . " (" . $MESSAGES["ALERT_STAT"] . ")";
			$title=$MESSAGES["ALERT_COUNTER"];

			$width= 800;
			$height= 450;

			$show_max= 10;

			///////////////////////////////////////////////////////////////////////////
			// Get data for pie 2: alert created vs alerts discarded

			$values2= Array();
			$labels2= Array();

			if($this->user->level != 0) {
				$query= "select status, count(*) as total " .
						"from alerts, servers, products " .
						"where alerts.id_product = products.id_product " .
						"      and alerts.id_server = servers.id_server " .
						"      and servers.id_group='" . $this->user->id_group . "' " .
						"      group by status";
				$title.= " (group " . $this->user->group_name . ")";
			} else {
				$query= "select status, count(*) as total " .
						"from alerts " .
						"group by status";
			}

			$aux= array($MESSAGES["ALERT_STATUS_NOT_SENT"],
						$MESSAGES["ALERT_STATUS_OPEN"],
						$MESSAGES["ALERT_STATUS_CLOSE"],
						$MESSAGES["ALERT_STATUS_PENDING"],
						$MESSAGES["ALERT_STATUS_DISCARDED"],
						$MESSAGES["ALERT_STATUS_DUDE"]);

			$res= $global_db->dbms_query($query);

			while($row= $global_db->dbms_fetch_row($res)) {

				$val= intval($row[0]);

				$labels2[]= isset($aux[$val]) ? $aux[$val] . " (" . $row[1] . ")" : "Unknown ($val)";
				$values2[]= $row[1];
			}
			$global_db->dbms_free_result($res);

			if(count($values2) == 0) {
				$this->showMessage("No data",$filename);
				return;
			}


			///////////////////////////////////////////////////////////////////////////
			// Create graphs

			$graph= new PieGraph($width, $height, "auto");
			$graph->SetFrameBevel(0);

			$graph->title->Set($title);
			$graph->title->SetFont(FF_FONT2,FS_BOLD);

			// Pie 2
			$l2pie=new PiePlot($values2);
			$l2pie->ExplodeSlice(0);
			$l2pie->SetLegends($labels2);
			$l2pie->SetCenter(0.45, 0.5);
		//	$l2pie->title->SetMargin(10,20,30,40);
		//	$l2pie->SetLabelType(PIE_VALUE_ABS);
		//	$l2pie->value->SetFormat('%d');
			$l2pie->SetTheme("water");
		//	$l2pie->SetSize(0.13);

			$graph->Add($l2pie);


			$graph->Stroke($filename);

			unset($graph);
		}
	}
?>
