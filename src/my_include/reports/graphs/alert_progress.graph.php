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


	class alert_progress extends report_graph {

		public function render($filename="") {

			global $MESSAGES, $global_db;


			$title=$MESSAGES["ALERT_COUNTER"];

			$width= 800;
			$height= 450;

			/**
			 * Graphs can be launched via CLI (command line) to generate automatically
			 * the reports.
			 *
			 * In those cases the user is passed as argument on the URL
			 *
			 */

			///////////////////////////////////////////////////////////////////////////
			// Get data

			if($this->user->level != 0) {
				$query= "select date_format(alerts.creation_date,'%Y/%m') as cd, count(*) from alerts, servers where alerts.id_server=servers.id_server and servers.id_group=" . $this->user->id_group . " and alerts.status!=5 group by cd order by cd asc limit 12";
				$title.= " (group " . $this->user->group_name . ")";
			} else {
				$query= "select date_format(creation_date,'%Y/%m') as cd, count(*) from alerts where alerts.status!=5 group by cd order by cd asc limit 12";
			}

			$res= $global_db->dbms_query($query);

			$values= Array();
			$labels= Array();
			$i=0;
			while($row= $global_db->dbms_fetch_row($res)) {
				$labels[$i]= $row[0];
				$values[$i]= $row[1];
				$i++;
			}

			$global_db->dbms_free_result($res);

			if(count($values) == 0) {
				$this->showMessage("No data",$filename);
				return;
			}


			///////////////////////////////////////////////////////////////////////////
			// Create graph

			$graph= new Graph($width, $height, "auto");
			$graph->SetMarginColor("#ffffff");
			$graph->SetScale("textlin");
			$graph->img->SetMargin(60,50,50,10);
			$graph->SetFrameBevel(0,false);
			// $graph->SetShadow();
			$graph->title->Set($title);
			$graph->title->SetFont(FF_FONT2,FS_BOLD);

			// Labels
			$graph->xaxis->title->Set("Month");
			$graph->xaxis->SetTickLabels($labels);
			$graph->xaxis->SetLabelAngle(90);
			$graph->xaxis->SetTextTickInterval(1);

			$graph->yaxis->title->Set("Alerts");

			$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
			$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

			// Line plot, alerts
			$l1plot=new BarPlot($values);
			$l1plot->SetColor("blue");
			$l1plot->SetFillColor("blue@0.9");
			$l1plot->SetWeight(1);
			$l1plot->SetLegend("Alert evolution");

			$l1plot->value->Show();
			$l1plot->value->SetFont(FF_FONT1,FS_NORMAL,10);
			$l1plot->value->SetColor("blue");
			//$l1plot->value->SetAngle(45);
			$l1plot->value->SetFormat('%d');


			$graph->Add($l1plot);

			$graph->Stroke($filename);

			unset($graph);
		}
	}
?>
