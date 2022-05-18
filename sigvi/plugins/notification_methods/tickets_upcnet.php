<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 * @subpackage notification_methods
 *
 */

	require_once MY_INC_DIR . "/classes/notification.class.php";


	class notification_ext extends notification {

		protected $ticket;


		function notification_ext($alert_id) {
			parent::notification($alert_id);
		}

		function send_new_notifications() {

			require_once SYSHOME . "/include/mail.inc.php";

			global $MESSAGES;

			//$body= build_body($this->vuln_info, false, false);
			$assumpte=sprintf($MESSAGES["NOTIFICATION_SUBJECT"],$this->fas, $this->server_name, $this->product_name);
			$descripcio=sprintf($MESSAGES["NOTIFICATION_ALERT_TITLE"],$this->fas,$this->product_name,$this->server_name);
    	    //echo "<br>" . $body . "<br><br>";

    	    $this->ticket = new soap_ticket();
    	    $request= $this->ticket->create_ticket($assumpte, $descripcio);
    	    $response= $this->ticket->consult_ticket();

    	    return 1;
		}
	}


	class soap_ticket {

		protected $function;
		protected $parameters;

		public function soap_ticket() {

			$this->function=$function;
			$this->parameters=$parameters;

		}

		public function create_ticket(&$assumpte, &$descripcio) {
			global $MESSAGES;

echo "begin create: <br>";
			$wsdl_url_request="https://palpatine.upc.es:8444/webtools/control/SOAPService/altaTiquet?wsdl";

			//$clientRQ = new SoapClient($wsdl_url_request);

			$paramCreate= array('login.username'	=> "username",
          			  		'login.password'	=> "password",
    	     		  		'domini'			=> "",
    	     		  		'solicitant'		=> "",
    	     		  		'client'			=> "UPCnet",
    	     		  		'assumpte'			=> "$assumpte",
    	     		  		'descripcio'		=> "$descripcio",
    	     		  		'equipResolutor'	=> "",
    	     		  		'assignatA'			=> "",
    	     		  		'producte'			=> "",
    	     		  		'urgencia'			=> "",
    	     		  		'impacte'			=> "",
    	     		  		'proces'			=> "",
    	     		  		'estat'				=> "",
    	     		  		'ip'				=> "", );

echo "Creo el ticket ->SOAP con esta url: " . $wsdl_url_request . ", con los siguientes param: ";
print_object($paramCreate);

/*
			var_dump($clientRQ->__getFunctions());

			try {

				$result= $clientRQ->call($function, $paramCreate);
			    echo "Valid Credentials!";
			}
			catch (Exception $e) {
				echo "RESPONSE: " . $clientRQ->__getLastResponse() . "<br>";
			    echo "Error!<br />";
			    echo $e->getMessage();
			}
*/
		}

		public function consult_ticket() {
echo "begin consult: <br>";
			$wsdl_url_response="https://palpatine.upc.es:8444/webtools/control/SOAPService/consultaTiquets?wsdl";

			//$clientRP = new SoapClient($wsdl_url_response);

			$paramConsult= array('login.username'	=> "username",
          			  		'login.password'	=> "password",
    	     		  		'domini'			=> "",
    	     		  		'codiTiquet'		=> "",
    	     		  		'estat'				=> "",
    	     		  		'client'			=> "UPCnet",
    	     		  		'solicitant'		=> "",
    	     		  		'ip'				=> "", );

echo "Consulto el ticket ->SOAP con esta url: " . $wsdl_url_response . ", con los siguientes param: ";
print_object($paramConsult);

/*
			var_dump($clientRP->__getFunctions());

			try {

				$result= $clientRP->call($function, $paramConsult);
			    echo "Valid Credentials!";
			}
			catch (Exception $e) {
				echo "RESPONSE: " . $clientRP->__getLastResponse() . "<br>";
			    echo "Error!<br />";
			    echo $e->getMessage();
			}
*/
		}

	}
?>