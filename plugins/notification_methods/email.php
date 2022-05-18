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

		function notification_ext($alert_id) {
			parent::notification($alert_id);
		}

		function send_new_notifications() {

			require_once SYSHOME . "/include/mail.inc.php";

			global $MESSAGES;

			$sent=false;
			for($i=0; $i < count($this->users_email); $i++) {

				$to=$this->users_email[$i];
				$title=  sprintf($MESSAGES["NOTIFICATION_ALERT_TITLE"],$this->fas,$this->product_name,$this->server_name);
				$subject=sprintf($MESSAGES["NOTIFICATION_SUBJECT"],$this->fas, $this->server_name, $this->product_name);
				$body= build_body($this->vuln_info, false, false);

				if(send_mail($to, $title, $subject, $body, "html")) {
					log_write("NOTIFICATION","Notification sent to $to ($subject)",3);
					$sent=true;
				}
			}
			return $sent;
		}

		function send_updated_notifications() {
			global $MESSAGES;

			require_once SYSHOME . "/include/mail.inc.php";

			$sent=false;
			for($i=0; $i < count($this->users_email); $i++) {

				$to=$this->users_email[$i];
				$title=  sprintf($MESSAGES["NOTIFICATION_ALERT_TITLE"],$this->fas,$this->product_name,$this->server_name);
				$subject=sprintf($MESSAGES["NOTIFICATION_UPDATE_SUBJECT"],$this->fas, $this->server_name, $this->product_name);
				$body= build_body($this->vuln_info, false, false);

				if(send_mail($to, $title, $subject, $body, "html")) {
					log_write("NOTIFICATION","Notification sent to $to ($subject)",0);
					$sent=true;
				}
			}
			return $sent;
		}
	}

?>
