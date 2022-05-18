<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage fas
 *
 * FAS definition class
 *
 */

	include_once MY_INC_DIR . "/classes/cvss.class.php";
	
	
	define("FAS_HIGH_SEVERITY",7);	// If FAS is greater or equal to this value is considered high severity
	define("FAS_MED_SEVERITY",4);	// If FAS is greater or equal to this value, and lower than HIGH is considered med severity
	
	define("FAS_HIGH_SEVERITY_COLOR","#ff9999");
	define("FAS_MED_SEVERITY_COLOR","#ffff99");
	define("FAS_LOW_SEVERITY_COLOR","#99ff99");
	

	class fas {

		public $fas_string;
		public $fas_vars= array (
				"AV" => "",
				"AC" => "",
				"AU" => "",
				"Exp" => "",
				"FIMP" => "",
				"IMP" => "",
				"BS" => "",
				"I" => "",
				"A" => "",
				"CS" => "",
				"FS" => "",
				"C" => ""
				);

		public 	$is_valid;

		public function fas($fas_string) {

			$this->fas_string= $fas_string;
			$this->is_valid= true;

			$search= array("(","*","/","+","-", ")");
			$tmp_fas1=str_replace($search, " ", $this->fas_string);
			$tmp_fas1=str_replace("  ", " ", $tmp_fas1);
			$tmp_fas1= trim($tmp_fas1);

			$tmp_fas2=explode(" ", $tmp_fas1);


			foreach ($tmp_fas2 as $var) {

				$var= strtoupper($var);

				if( ($var != "") and ( ! is_numeric($var) )) {

					if(!array_key_exists($var, $this->fas_vars)) {

						$this->is_valid= false;
					} else {

						$this->fas_vars[$var]= $var;
					}
				}
			}
		}

		/**
		 * When the FAS expression is correct, this function replace all the FAS's vars for the numeric
		 * value and compute the expression
		 *
		 * @param cvss $cvss
		 * @return boolean
		 */
		public function parse_fas($cvss, $fs, $cs) {

			global $MESSAGES;

			if(!$this->is_valid) return false;

			// Now, we replace all the vars defined in the FAS function for its values
			$final_fas= $this->fas_string;

			foreach($this->fas_vars as $var) {

				if($var == "") continue;

				$var= strtoupper($var);

				switch($var) {

					case "FS":
						$final_fas= str_ireplace($var, $fs, $final_fas);
						break;
					case "CS":
						$final_fas= str_ireplace($var, $cs, $final_fas);
						break;
					default:
						if(array_key_exists($var, $cvss->cvss_array)) {
							if($cvss->cvss_array[$var]=="") {
								echo "<font color='red'>CVSS Vector is not set for var $var</font><br>";
								$value="0";
							} else {
								$value= $cvss->cvss_array[$var];
							}

							$final_fas= str_ireplace($var, $value, $final_fas);

						} else {
							html_showError($MESSAGES["FAS_VAR_NOT_VALID"] . $var );
							return false;
						}
				}
			}

			$final_fas= ' return (' . $final_fas . ');';
			$fas_value= eval($final_fas);

			return $fas_value;
		}
	}

	function get_fas($id_server) {

		global $global_db;

		$fas= "";

		// First, get the group of the server
		$query="select id_group from servers where id_server='" . $id_server . "'";
		$res= $global_db->dbms_query($query);
		if(! $global_db->dbms_check_result($res)) return false;

		list($id_group)= $global_db->dbms_fetch_row($res);
		$global_db->dbms_free_result($res);

		// Second, get the group FAS, if exists...
		$query="select fas from fas where id_group='" . $id_group . "' and enabled='1'";
		$res= $global_db->dbms_query($query);
		if($global_db->dbms_check_result($res)) {

			list($fas)= $global_db->dbms_fetch_row($res);
			$global_db->dbms_free_result($res);

			return $fas;

		} else {

			// If there is not any FAS enabled for this group, check for a global FAS
			$query="select fas from fas where id_group is null and enabled='1'";
			$res= $global_db->dbms_query($query);

			if($global_db->dbms_check_result($res)) {

				list($fas)= $global_db->dbms_fetch_row($res);
				$global_db->dbms_free_result($res);

				return $fas;
			} else {

				// Else, return the default FAS, defined on the app.conf.php
				return DEFAULT_FAS;
			}
		}
	}
?>