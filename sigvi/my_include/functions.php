<?php
/*
	Author: Sebastian Gomez, (tiochan@gmail.com)
	For: Politechnical University of Catalonia (UPC), Spain.

	Respoitory auxiliar functions

	require:
*/

	/**
	 * This function is used to normalize a hostname or ip, set on user_entered.
	 * If user_entered is an IP, will set on $ip itself, and on $hostname, the
	 * corresponding DNS resolution, or the same IP if there is not resolution.
	 *
	 * If user_entered is the hostname, will set on $ip the DNS resolved, and on
	 * $hostname the corresponding DNS resolution (which can be different from
	 * original).
	 *
	 * It can be used to normalize IPs and hostnames specially for nmap usage.
	 *
	 * @param string $user_entered
	 * @param string $hostname
	 * @param string $ip
	 * @return boolean
	 */
	function normalize_hostname_and_ip($user_entered, &$hostname, &$ip) {

		global $MESSAGES;

		// What have the user entered into the dummy field, an IP or the hostname?
		$t_ip= @gethostbyname($user_entered);
		// Check if is a valid IP
		$l_ip= ip2long($t_ip);
		if($l_ip === false) return false;

		$t_hn= @gethostbyaddr($t_ip);

		if($t_ip == $t_hn) html_showWarning("No DNS resolution found for $user_entered");

		$ip= $t_ip;
		$hostname= $t_hn;

		return true;
	}
?>