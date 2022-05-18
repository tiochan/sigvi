<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 *
 * Logout page.
 */

if(!defined("LOGGINGOUT")) define("LOGGINGOUT",true);


if(file_exists("my_include/my_logout.php")) {
	require_once "my_include/my_logout.php";
	exit;
}


global $GLOBAL_STYLES;
global $OVERRIDE_TPL;
$OVERRIDE_TPL= "login.tpl.php";
$GLOBAL_STYLES["login.css"]="/include/styles/login.css";

include_once "include/init.inc.php";

global $GLOBAL_SCRIPTS;
$next_page= strip_tags(get_http_param("next_page",HOME . "/index.php"));

$goto= "login.php?next_page=$next_page";
$my_function="setTimeout(\"self.location.href='" . HOME . "/" . $goto . "'\", 2000)";
$GLOBAL_SCRIPTS[]= $my_function;

end_session();


function show_logout_message() {
    global $MESSAGES;
    ?>
    <div class="outerlogin">
        <div class="loginbox">

            <div class="loginlogo">
                <img src="<?php echo HOME . APP_MINILOGO; ?>">
            </div>

            <div class="alert alert-info" id="kssPortalMessage" >
                <strong><?php echo $MESSAGES["APP_NAME"]; ?></strong>
            </div>

            <div class="alert alert-success" id="kssPortalMessage" role="error">
                <strong><?php echo $MESSAGES["APP_LOGOUT_TITLE"]; ?></strong>
            </div>
        </div>
    </div>
    <br>
    <br>
<?php
}

html_header("");
show_logout_message();
html_showSimpleFooter();
?>