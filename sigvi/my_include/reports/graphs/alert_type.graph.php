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


	class alert_type extends report_graph {

		public function render($filename="") {

			global $MESSAGES, $global_db;


			$title= $MESSAGES["ALERT_COUNTER"] . " (" . $MESSAGES["VULN_FIELD_VULN_SOFTWARE"] . ")";

			$width= 800;
			$height= 450;

			$show_max= 10;


			///////////////////////////////////////////////////////////////////////////
			// Get data for pie 1: group alerts by product name

			if($this->user->level != 0) {
				$query= "select products.name, count(*) as total " .
						"from alerts, servers, products " .
						"where alerts.id_product = products.id_product " .
						"      and alerts.id_server = servers.id_server " .
						"      and servers.id_group='" . $this->user->id_group . "' " .
						"      and alerts.status in (0,1,3) " .
						"group by products.name " .
						"order by total desc";
				$title.= " (group " . $this->user->group_name . ")";
			} else {
				$query= "select name, count(*) as total " .
						"from alerts, products " .
						"where alerts.id_product = products.id_product " .
						"      and alerts.status in (0,1,3) " .
						"group by name order by total desc";
			}


			$res= $global_db->dbms_query($query);

			$values= Array();
			$labels= Array();
			$i=1;
			while($row= $global_db->dbms_fetch_row($res)) {

				$val= intval($row[1]);

				if($i < $show_max) {
					$values[$i]= $val;
					$labels[$i]= $row[0] . " (" . $row[1] . " alerts)";
					$i++;
				} else {

					$values[$i]= isset($values[$i]) ? $values[$i] + $val : $val;
					$labels[$i]= "Others" . " (" . $values[$i] . ")";
				}
			}
			$global_db->dbms_free_result($res);

			if(count($values) == 0) {
				$this->showMessage("No data",$filename);
				return;
			}


			///////////////////////////////////////////////////////////////////////////
			// Create graphs

			$graph= new PieGraph($width, $height, "auto");
			$graph->SetFrameBevel(0);

			$graph->title->Set($title);
			$graph->title->SetFont(FF_FONT2,FS_BOLD);


			// Pie 1
			$l1pie=new PiePlot($values);
			$l1pie->ExplodeSlice(0);
			$l1pie->SetLegends($labels);
			$l1pie->SetCenter(0.25, 0.5);
		//	$l1pie->title->SetMargin(10,20,30,40);
			$l1pie->SetTheme("water");

			$graph->Add($l1pie);

			$graph->Stroke($filename);

			unset($graph);
		}
	}
?>