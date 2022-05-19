<?php
	if(isset($USER_NAME)) { 
		echo "Hello, $USER_NAME.<br>";
	} else {
		header("Location: ../../index.html");
		exit;
	}
?>
You are at main page.<br>
<br>
<br>
<b><a href="#what_to_do_first">What to do for first time?</a></b><br>
<b><a href="#what_to_do_next">I have done it, and now?</a></b><br>
<b><a href="#what_is_each_menu">All right, and now... what the hell can I do with it?</a></b><br>
<br>
<br>
<br>
<br>
<a name="what_to_do_first"></a>
<h2>What to do for first time?</h2>
<hr>
<br>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Global settings</b>: Have you checked the global environment settings? (can send mail from this server, the crontab is set, ...) Read the installation notes.</li>
<?php } ?>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Global parameters</b>: Check the global parameters.</li>
<?php } ?>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Vulnerability load</b>: The SIGVI administrator must load the vulnerabilities. <br>
This is a slow task, so if you do it via Web, you will be limited on the process timeout of your web server, so is better doing it at commmand line.<br>
<b>Via web</b><br>For it go to "Configuration -> Sources -> Vulnerability Sources" and check the sources. First, disable all enabled sources.<br>
Now, for each source, activate one, launch the "Vulnerabilities loading" process and deactivate it. After the process, left activated only those which you need (those called "recents" and "updates" are recommended). This action will spent a lot of time, so take care of your PHP expire configuration or execute it manually.<br>
<b>Via command line interpreter</b><br>
Is recomended to launch the load process manually. </li>
<?php } ?>
<li><b>Add your servers</b>: From the "Servers" menu you can create your servers.</li>
<li><b>Associate your servers with the software installed.</b>: From the "Products installed on servers" menu you can define the associations of your server with the installed products. Firts, is a good idea to set the services that the server is giving (like apache, mail. ftp, ssh, telnet, ...)</li>
<br>
<br>
<a name="what_to_do_next"></a>
<h2>I have done it, and now?</h2>
<hr>
<br>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Validate alerts</b>: The SIGVI administrator must validate the alerts that the check process couldn't determine.</li>
<?php } ?>
<li><b>check server alerts</b>: Now, wait for SIGVI notifications and from "TO-DO" menu or "Alerts" menu you can go to your server alerts.</li>
<a name="what_is_each_menu"></a>
<br>
<br>
<h2>And now... What can I do with it?</h2>
<p>This is a briew description on each menu, take a look at the documentation at the <a href="http://sigvi.upcnet.es/doc/manuales/doc.php" target="_blank">sigvi portal</a> if you need more help.<br>
And if you need still more help, you can ask me at my email address: tiochan@gmail.com<br>
</p>
<br>
<b>TO-DO menu</b><br>
<hr>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Validate alerts</b>: For some vulnerabilities, SIGVI can't decide if are true vulnerabilities or not. Admin must decide it.</li>
<?php } ?>
<li><b>Review server alerts</b>: Here you can review and manage the alerts of the servers of your group.</li>
<br><br>
<b>Application configuration</b><br>
<hr>
<li><b>My user</b>: Change your own data like username, password, if you want or not receive alerts, etc.</li>
<li><b>Filters</b>: That defines the criteria to be used to filter the vulnerabilities notifications and the server alert generation.</li>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Groups</b>: Manage the groups.</li>
<?php } ?>
<?php if(isset($USER_LEVEL) and $USER_LEVEL < 5) {?>
<li><b>Users</b>: Manage the users.</li>
<?php } ?>
<br><br>
<b>Inventory</b><br>
<hr>
<li><b>Servers</b>: Define your servers.</li>
<li><b>Products installed on servers</b>: For each server you must define which products has installed. The vulnerability mach will be done using this association. You must define, at least, one for each service that the server is giving (apache, ssh, IIS, telnet, ftp, ...)</li>
<li><b>Products</b>: This is the products repository</li>
<li><b>Vulnerabilities</b>: This is the vulnerabilities repository</li>
<br><br>
<b>General administration</b><br>
<hr>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Vulnerabilities sources</b>: Manage the vulnerabilities sources from which every day the vulnerabilities are imported.</li>
<?php } ?>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Notification methods</b>: Define the notification methos (email, ...).</li>
<?php } ?>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Global parameters</b>: Manage global parameters of the application</li>
<?php } ?>
<br><br>
<b>Tools</b><br>
<hr>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>See the status of server vulnerabilities</b>: Like alerts menu, but grouped by servers.</li>
<li><b>Check manually server status</b>: Launch manually the check process <u>now</u>.</li>
<li><b>Test vulnerabilities source</b>: Here you can test the vulnerabilities sources.</li>
<li><b>Manual load of vulnerabilities from sources</b>: Launch manually the vulnerabilities from sources <u>now</u>.</li>
<?php } ?>
<li><b>Vulnerability evolution</b>: some reports for vulnerabilities evolution.</li>
<li><b>Application bugs</b>: Bugs reported.</li>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<li><b>Logs</b>: Review the application logs</li>
<?php } ?>
<?php if(isset($USER_LEVEL) and $USER_LEVEL == 0) {?>
<br>
<br>
<b>Database access</b><br>
<hr>
<li><b>DDBB (current config)</b>: Database iteration using application parameters (username, database, ...).</li>
<li><b>DDBB (gen.)</b>: Generic database iteration.</li>
<?php } ?>
<br>
<br>
<b>Server status</b><br>
<hr>
This is a report of your servers vulnerability status.