<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage alerts
 *
 * Alert definition class
 *
 */

/*
	rss_sources table definition

	+-------------+--------------+------+-----+---------+----------------+
	| Field       | Type         | Null | Key | Default | Extra          |
	+-------------+--------------+------+-----+---------+----------------+
	| id_source   | mediumint(9) | NO   | PRI | NULL    | auto_increment |
	| name        | varchar(60)  | NO   | UNI |         |                |
	| description | text         | YES  |     | NULL    |                |
	| parser      | varchar(255) | YES  |     | NULL    |                |
	| parameters  | varchar(255) | YES  |     | NULL    |                |
	| use_it      | tinyint(4)   | YES  |     | NULL    |                |
	+-------------+--------------+------+-----+---------+----------------+

 */


	include_once INC_DIR . "/menu.inc.php";
	include_once INC_DIR . "/forms/form_elements.inc.php";
	include_once INC_DIR . "/forms/containers/sub_form.inc.php";
	include_once SYSHOME . "/plugins/sources/news/rss_reader.php";


	/**
	 * Class to display RSS as a subform
	 *
	 */
	class rss_subform extends sub_form {

		protected $rss_sources;

		public function rss_subform($name, $text, $max_items=0) {

			parent::sub_form($name, $text);

			$this->rss_sources= new rss_sources($name . "_rss_sources", $max_items);
			$this->add_element($this->rss_sources);
		}
	}

	/**
	 * Class to display RSS as a menu item
	 *
	 */
	class rss_menu_item extends menu_item {

		/**
		 * RSS object
		 *
		 * @var rss_sources
		 */
		protected $rss_sources;


		public function rss_menu_item($label, $max_items=0) {

			parent::menu_item($label, "", "");

			$this->rss_sources= new rss_sources($label . "_rss_sources", $max_items);
		}

		public function show() {

			$this->rss_sources->show();
		}
	}

	/**
	 * Form element to display the RSS sources
	 *
	 */
	class rss_sources extends form_element {

		protected $max_items;

		public function rss_sources($doc_name, $max_items=0) {

			$this->max_items= $max_items;

			parent::form_element($doc_name);
		}

		public function show() {

			global $global_db;
			global $MESSAGES;

			parent::show();

			$query= "select id_source, name, parameters from rss_sources where use_it='1'";
			$res= $global_db->dbms_query($query);

			if(!$global_db->dbms_check_result($res)) {
				html_showInfo($MESSAGES["RSS_CANT_FIND_ENABLED"]);
				return 1;
			}

			while(list($id_rss, $name, $source)= $global_db->dbms_fetch_row($res)) {

				{
					$rss_reader= new RSSParser($source,$this->max_items);
					$rss_reader->read_xml();

					html_showDetail("<p class='rss_source'>Source: <a href='" . $source. "' target='_blank'> $name</a></p>");

					foreach($rss_reader->xmlItems as $item) {
						printf("<p class='rss_title'><b><a href='%s' target='_blank'>%s</a></b>&nbsp;&nbsp;<font class='rss_date'>(%s)</font></p>",	$item->link,$item->title, $item->date);
					//	printf("<p class='rss_description'>%s</p>", htmlspecialchars_decode($item->description));
						printf("<p class='rss_description'>%s</p>", $item->description);
					}
				}
			}
		}
	}
?>