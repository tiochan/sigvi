<?php
/**
 * @author Jorge Novoa (jorge.novoa@upcnet.es)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage cvss
 *
 * CVSS definition class
 *
 */

	class cvss {
		
		public $cvss_version;
		public $cvss_array = array(
				"AV" => "",
				"AC" => "",
				"AU" => "",
				"EXP" => "",
				"FIMP" => "",
				"IMP" => "",
				"BS" => "",
				"I" => "",
				"A" => "",
				"C" => ""
				);
	
		public $cvss_vector;
		public $cvss_impact_subscore;
		public $cvss_exploit_subscore;
	
		/**
		 * This function take from any vulnerability the atributes that needs
		 *
		 * @param unknown_type $cvss_score
		 * @param unknown_type $cvss_vector
		 * @param unknown_type $cvss_impact_subscore
		 * @param unknown_type $cvss_exploit_subscore
		 * @return cvss
		 */
		public function cvss($cvss_version, $cvss_score, $cvss_vector,	$cvss_impact_subscore, $cvss_exploit_subscore) {
	
			$this->cvss_version= $cvss_version;
			$this->cvss_vector= $cvss_vector;
	
			$this->cvss_array["BS"]= $cvss_score;
			$this->cvss_array["IMP"]= $cvss_impact_subscore;
			$this->cvss_array["EXP"]= $cvss_exploit_subscore;
			$this->cvss_array["FIMP"]= $cvss_impact_subscore == 0 ? 0 : 1.176;
	
			$this->take_off_vector();
		}
	
		/**
		 * This function take the cvss vector and let only the strings components
		 *
		 */
		private function take_off_vector() {
	
			switch($this->cvss_version) {
				case "2.0":
				default:
					$search= array("(", ")");
					$vector=str_replace($search, "", $this->cvss_vector);
	
					$sub_vector=explode("/", $vector);
	
					foreach($sub_vector as $var) {
						list ($comp, $value)=explode(":",$var);
						$upper_comp= strtoupper($comp);
						$this->cvss_array[$upper_comp]= $this->get_var_value($comp, $value);
					}
					break;
			}
		}
	
		/**
		 * This function return a numeric value of the CVSS atribute
		 *
		 * @param unknown_type $comp
		 * @param unknown_type $value
		 * @return numeric value from CVSS atribute
		 */
		private function get_var_value($comp, $value) {
	
			$nums_values=array (
				"AC"=>array("H"=> 0.35, "M"=> 0.61, "L"=> 0.71),
				"Au"=>array("N"=> 0.704, "S"=> 0.56, "M"=> 0.45),
				"AV"=>array("L"=> 0.395, "A"=> 0.646, "N"=> 1),
				"C"=>array("N"=> 0, "P"=> 0.275, "C"=> 0.66),
				"I"=>array("N"=> 0, "P"=> 0.275, "C"=> 0.66),
				"A"=>array("N"=> 0, "P"=> 0.275, "C"=> 0.66)
			);
	
			return (isset($num_values[$comp]) and isset($num_values[$comp][$value])) ? $nums_values[$comp][$value] : null;
		}
	}
?>
