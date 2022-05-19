<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package admin
 *
 * Log-in page.
 */


if(file_exists("my_include/my_login.php")) {
    require_once "my_include/my_login.php";
    exit;
}

global $GLOBAL_RECONFIGURE_PAGE;
$GLOBAL_RECONFIGURE_PAGE= array();
$GLOBAL_RECONFIGURE_PAGE[]= 'setFocus("account_username");';

global $GLOBAL_STYLES;
$GLOBAL_STYLES["login.css"]="/include/styles/login.css";

global $OVERRIDE_TPL;
$OVERRIDE_TPL= "login.tpl.php";

include_once "include/init.inc.php";

global $MESSAGES;

$login_result=false;

$next_page= strip_tags(get_http_param("next_page",HOME . "/index.php"));
if($next_page == "" or !file_exists(SYSHOME . $next_page)) $next_page= HOME . "/index.php";


function showFormLogin($username, $error) {
    global $MESSAGES;
    global $next_page;

?>
    <div class="outerlogin">
        <div class="loginbox">

            <div class="loginlogo">
                <img src="<?php echo HOME . APP_MINILOGO; ?>">
            </div>

            <div class="alert alert-info" id="kssPortalMessage" >
                <strong><?php echo $MESSAGES["APP_NAME"]; ?></strong>
            </div>
            <?php
            if($error != "") {
                ?>
                <div class="alert alert-error" id="kssPortalMessage" role="error">
                    <strong><?php echo $error; ?></strong>
                </div>
            <?php
            }
            ?>
            <div class="alert alert-error" id="enable_cookies_message" style="display: none;">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <strong>Info</strong>
                Cookies are not enabled. You must enable cookies before you can log in.
            </div>

            <form class="form-horizontal margin0 enableAutoFocus" id="loginForm" name="loginForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="login">
                <input type="hidden" name="next_page" value="<?php echo $next_page; ?>">
                <input type="hidden" name="first_time" value="0">

                <div class="control-group">
                    <label class="control-label" for="account_username"><?php echo $MESSAGES["APP_LOGIN_USERNAME"] ?>:&nbsp;</label>
                    <div class="controls">
                        <input type="text" id="account_username" placeholder="<?php echo $MESSAGES["APP_LOGIN_USERNAME"] ?>" name="username" value="<?php echo $username; ?>">

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="account_password"><?php echo $MESSAGES["APP_LOGIN_PASSWORD"] ?>:&nbsp;</label>
                    <div class="controls">
                        <input type="password" id="account_password" placeholder="<?php echo $MESSAGES["APP_LOGIN_PASSWORD"] ?>" name="password">

                    </div>
                </div>
                <div class="control-group margin0">
                    <div class="controls">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
<?php
}

// Is already logged?
if(is_user_logged()) {
    // echo "user already logged. Redirecting to... $next_page\n";
    echo "<script>self.location.href='$next_page'</script>";
    exit;
}

////////////////////////
// NOT LOGGED.

// If first time, just show the login form
if(!isset($_POST["first_time"])) {
    html_header("");
    showFormLogin("", "");
    html_showSimpleFooter();
    exit;
}

// Not first time, Are vars defined?
$username= get_http_param("username");
$password= get_http_param("password");
if( ($username != "") and ($password != "") ) $login_result=authenticate($username, $password);

// Ok, authentication succesful, redirect to previous page if defined, else Home.
if($login_result) {
    html_showInfo("User logged, redirecting...\n");
    echo "<script>self.location.href='$next_page'</script>";
    exit;
}

// Something wrong...try again
html_header("");
showFormLogin($username, $MESSAGES["AUTH_INVALID_AUTH"]);

html_showSimpleFooter();
?>