<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage lang
 *
 * English version of application messages
 * Reviewed from Antoni Matamales
 */

  ///////////////////////////////////////////////////////////////////////////
 // APPLICATION MESSAGES                                                  //
///////////////////////////////////////////////////////////////////////////

$MESSAGES["APP_ALIAS"]="SIGVI";
$MESSAGES["APP_NAME"]="Vulnerabilities management system";
$MESSAGES["REGISTER_SUCCESS"]=
	"<p><b>Welcome %s.</b></p>" .
	"<p>You have been successfully registered.</p>" .
	"<p>To enjoy SIGVI please now go to login page and follow these steps:</p>" .
	"<p> - First, review your own data, be sure that email address is correct, else you will not be notified with vulnerability alerts.</p>" .
	"<p> - You are Group manager, so you can, if you want, add more users to your group as server administrators</p>" .
	"<p> - Add your servers, and define which products are installed (example: most important services)</p>" .
	"<p> - Each night, SIGVI will get vulnerability updates from the sources and will search them on the products that you indicated. Each maching will generate an alert and will send you a notification.</p>" .
	"<br>" .
	"<p> - And now, enjoy ... <a href='" . SERVER_URL . HOME . "/index.php'>login page</a>.</p>";

$MESSAGES["ABOUT_APP"]=
	"<p>SIGVI is developed by UPCnet S.L.</p>";

// MAIN PAGE
$MESSAGES["SERVER_VULN_STATUS"]="Server vulnerability status";
$MESSAGES["TO-DO"]="TO-DO";
$MESSAGES["INDEX"]="Index";
$MESSAGES["SERVERS"]="Servers";
$MESSAGES["SERVER"]="Server";
$MESSAGES["SERVICES"]="Services";
$MESSAGES["SERVERS_AND_SERVICES"]="Servers and services";
$MESSAGES["PRODUCTS"]="Products";
$MESSAGES["VULNERABILITIES"]="Vulnerabilities";
$MESSAGES["SERVER_PRODUCTS"]="Products installed on servers";
$MESSAGES["SOURCES_ADMIN"]="Sources management";
$MESSAGES["SOURCES"]="Sources";
$MESSAGES["VULN_SOURCES_ADMIN"]="Vulnerability sources management";
$MESSAGES["VULN_SOURCES"]="Vulnerabilities sources";
$MESSAGES["VULN_SOURCES_TESTING"]="Test sources";
$MESSAGES["VULN_SOURCES_LOADING"]="Vulnerabilities loading";
$MESSAGES["VULN_SOURCES_LOAD"]="Manual load from sources";
$MESSAGES["ALERTS"]="Alerts";
$MESSAGES["ALERT_VALIDATION_SHORT"]="Alert validation";
$MESSAGES["ALERT_VALIDATION"]="Validate alerts with doubts";
$MESSAGES["ALERT_ASSIGNED_TO"]="Assigned to";
$MESSAGES["ALERT_ASSIGNED_TO_UNSET"]="The alerts associated to this user have been released";
$MESSAGES["ALERTS_TO_VALIDATE"]="There are %d alerts to validate";
$MESSAGES["ALERTS_PENDING"]="There are %d active alerts";
$MESSAGES["CHECK_SERVER_VULNERABILITIES"]="Check manually server status";
$MESSAGES["SEE_SERVER_VULNERABILITIES"]="Alerts per server";
$MESSAGES["SERVER_STATUS"]="Server status";
$MESSAGES["NOTIFICATION_METHODS"]="Notification methods";
$MESSAGES["SHOW_VULNERABILITY_EVOLUTION"]="Vulnerability evolution";
$MESSAGES["STATISTICS"]="Statistics";

$MESSAGES["HIGH_RISK"]="High risk";
$MESSAGES["MED_RISK"]="Med risk";
$MESSAGES["LOW_RISK"]="Low risk";

$MESSAGES["SERVER_PRODUCT_MGM"]="Manage the products installed on servers";

$MESSAGES["VULN"]="Vulnerabilities";
$MESSAGES["LOAD_VULN"]="Load the vulnerabilities list into the database";
$MESSAGES["LOAD_VULNERABILITIES_CONFIRM"]="This process will take some time.<br>Do you want to continue?";
$MESSAGES["LOAD_PROD"]="Load the product list into the database";
$MESSAGES["CHECK_STATUS"]="Check status";
$MESSAGES["CHECK_SERVER_STATUS"]="Check the vulnerability status of servers";
$MESSAGES["SEARCH_VULNERABILITIES_CONFIRM"]="Do you want to continue?";

// SKILL LEVELS
$MESSAGES["SKILL_0"]="SIGVI Adm";
$MESSAGES["SKILL_3"]="Groups Adm";
$MESSAGES["SKILL_5"]="Host Adm";

// SERVER management messages
$MESSAGES["SERVER_MGM_TITLE"]="Server management";
$MESSAGES["SERVER_MGM_STILL_HAS_PRODUCTS"]="There are products associated to this server. Can't be deleted.";
$MESSAGES["SERVER_MGM_CANT_DELETE"]="Sorry, but server admin can't delete servers.";
$MESSAGES["SERVER_MGM_CANT_UPDATE"]="Sorry, but server admin can't update servers.";

$MESSAGES["SERVER_FIELD_NAME"]="Name";
$MESSAGES["SERVER_FIELD_VENDOR"]="Vendor";
$MESSAGES["SERVER_FIELD_MODEL"]="Model";
$MESSAGES["SERVER_FIELD_CPU"]="CPU";
$MESSAGES["SERVER_FIELD_RAM"]="RAM";
$MESSAGES["SERVER_FIELD_DISC"]="Discs";
$MESSAGES["SERVER_FIELD_SERIAL_NUMBER"]="Serial number";
$MESSAGES["SERVER_FIELD_OS"]="Operative System";
$MESSAGES["SERVER_FIELD_GROUP"]="Group";
$MESSAGES["SERVER_FIELD_LOCATION"]="Location";
$MESSAGES["SERVER_FIELD_IP"]="IP";
$MESSAGES["SERVER_FIELD_ZONE"]="Zone";
$MESSAGES["SERVER_FIELD_OBSERVATIONS"]="Observations";

$MESSAGES["SERVER_FIELD_NAME"]="Name";

// PRODUCTS management messages
$MESSAGES["PRODUCT_MGM_TITLE"]="Product management";
$MESSAGES["PRODUCT_MGM_STILL_HAS_SERVERS"]="This product is associated with any server so it can't be deleted.";

$MESSAGES["PRODUCT_FIELD_ID"]="Product identifier";
$MESSAGES["PRODUCT_FIELD_VENDOR"]="Vendor";
$MESSAGES["PRODUCT_FIELD_NAME"]="Product name";
$MESSAGES["PRODUCT_ID_FIELD_NAME"]="Product Identifier<br>(review products list)";
$MESSAGES["PRODUCT_FIELD_FULL"]="Full";
$MESSAGES["PRODUCT_FIELD_VERSION"]="Version";

// PRODUCTS updated --> alerts closed
$MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"]="The software was updated, so the alerts attached to the old software were changed to close status.";
$MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"]="The software was deleted, so the alerts attached to it were changed to close status.";

// SEARCH PRODUCTS messages
$MESSAGES["SEARCH_PRODUCT_TITLE"]="Product search";

// SERVER_PRODUCTS management messages

$MESSAGES["SERVER_PRODUCT_MGM_TITLE"]="Server products management";

$MESSAGES["SERVER_PRODUCT_FIELD_SERVER_NAME"]="Server name";
$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"]="Product";
$MESSAGES["SERVER_PRODUCTS_FIELD_PORTS"]="Ports";
$MESSAGES["SERVER_PRODUCTS_FIELD_FILTERED"]="Is service filtered? (is not public)";
$MESSAGES["SERVER_PRODUCTS_FIELD_CRITIC"]="Is a critical service?";
$MESSAGES["SERVER_PRODUCTS_FIELD_PROTOCOL"]="Transmission Protocol (TCP,UDP,...)";


// SOURCE management messages
$MESSAGES["SOURCE_MGM_TITLE"]="Vulnerability sources management";

$MESSAGES["SOURCE_FIELD_NAME"]="Alias";
$MESSAGES["SOURCE_FIELD_DESCRIPTION"]="Description";
$MESSAGES["SOURCE_FIELD_HOME_URL"]="Site URL";
$MESSAGES["SOURCE_FIELD_FILE_URL"]="File URL";
$MESSAGES["SOURCE_FIELD_USE_IT"]="Use it?";
$MESSAGES["SOURCE_FIELD_PARSER_LOCATION"]="Parser";
$MESSAGES["SOURCE_FIELD_PARAMETERS"]="Parameters";

$MESSAGES["SOURCES_FIELD_ALIAS"]="Select the source to load";
$MESSAGES["SOURCES_TEST_FIELD_ALIAS"]="Select the source to test";

// NOTIFICATION METHODS management messages
$MESSAGES["NOTIF_METHOD_MGM_TITLE"]="Alert notification methods";

$MESSAGES["NOTIF_METHOD_FIELD_NAME"]="Alias";
$MESSAGES["NOTIF_METHOD_FIELD_DESCRIPTION"]="Description";
$MESSAGES["NOTIF_METHOD_FIELD_USE_IT"]="Use it?";
$MESSAGES["NOTIF_METHOD_FIELD_METHOD_LOCATION"]="Module";

// VULNERABILITIES management messages
$MESSAGES["VULN_MGM_TITLE"]="Vulnerability management";
$MESSAGES["VULN_COUNTER"]="Vulnerability counter";

$MESSAGES["VULN_FIELD_VULN_ID"]="CVE/CAN";
$MESSAGES["VULN_FIELD_PUBLISH_DATE"]="Publish date";
$MESSAGES["VULN_FIELD_MODIFY_DATE"]="Revision date";
$MESSAGES["VULN_FIELD_DESCRIPTION"]="Description";
$MESSAGES["VULN_FIELD_SEVERITY"]="Severity";
$MESSAGES["VULN_FIELD_AR_LAUNCH_REMOTELY"]="Access requirements<br>Can be exploided remotely?";
$MESSAGES["VULN_FIELD_AR_LAUNCH_LOCALLY"]="Access requirements<br>Local access required?";
$MESSAGES["VULN_FIELD_SECURITY_PROTECTION"]="Consequences<br>Gain protection security";
$MESSAGES["VULN_FIELD_OBTAIN_ALL_PRIV"]="Consequences<br>Gain some privileges";
$MESSAGES["VULN_FIELD_OBTAIN_SOME_PRIV"]="Consequences<br>Gain all privileges";
$MESSAGES["VULN_FIELD_CONFIDENTIALITY"]="Consequences<br>Loss confidenciality";
$MESSAGES["VULN_FIELD_INTEGRITY"]="Consequences<br>Loss integrity";
$MESSAGES["VULN_FIELD_AVAILABILITY"]="Consequences<br>Loss disponibility";
$MESSAGES["VULN_FIELD_INPUT_VALIDATION_ERROR"]="Type<br>Error validating data";
$MESSAGES["VULN_FIELD_BOUNDARY_CONDITION_ERROR"]="Type<br>Condition error";
$MESSAGES["VULN_FIELD_BUFFER_OVERFLOW"]="Type<br>buffer overflow";
$MESSAGES["VULN_FIELD_ACCESS_VALIDATION_ERROR"]="Type<br>Access validation error";
$MESSAGES["VULN_FIELD_EXCEPTIONAL_CONDITION_ERROR"]="Type<br>Contition error";
$MESSAGES["VULN_FIELD_ENVIRONMENT_ERROR"]="Type<br>Environment error";
$MESSAGES["VULN_FIELD_CONFIGURATION_ERROR"]="Type<br>Configuration error";
$MESSAGES["VULN_FIELD_RACE_CONDITION"]="Type<br>Race condition";
$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"]="Type<br>Other";
$MESSAGES["VULN_FIELD_VULN_SOFTWARE"]="Vulnerable software";
$MESSAGES["VULN_FIELD_LINKS"]="Links";
$MESSAGES["VULN_FIELD_OTHER_REFERENCES"]="Other references";
$MESSAGES["VULN_FIELD_OTHER"]="...";
$MESSAGES["VULN_FIELD_SOLUTION"]="Solutions";
$MESSAGES["VULN_FIELD_SOURCE"]="Source";

$MESSAGES["VULN_EXPLOID_REMOTELLY"]="Remotely exploided?";
$MESSAGES["VULN_EXPLOID_ONLY_LOCALLY"]="Local access required?";

// SEARCH VULNERABILITY messages
$MESSAGES["SEARCH_VULNERABILITY_TITLE"]="vulnerability search";

// SEARCH ALERT messages
$MESSAGES["SEARCH_ALERT_TITLE"]="Alerts search";

// ALERTS management messages
$MESSAGES["ALERT_MGM_TITLE"]="Alert management";
$MESSAGES["ALERT_MGM_NOTIFICATION_METHOD"]="Notification method";

$MESSAGES["ALERT_COUNTER"]="Alert counter";

$MESSAGES["ALERT_SERVER_FIELD_NAME"]="Server";
$MESSAGES["ALERT_PRODUCT_FIELD_NAME"]="Affected product";
$MESSAGES["ALERT_VULN_FIELD_VULN_ID"]="Vulnerabily";
$MESSAGES["ALERT_FIELD_DATE"]="Creation date";
$MESSAGES["ALERT_FIELD_STATUS"]="Status"; // [1=open|2=pending|3=solved|4=closed...]
$MESSAGES["ALERT_FIELD_SEVERITY"]="FAS (Final Alert Severity)"; // [0=not critical, ..., 9=very critical]
$MESSAGES["ALERT_FIELD_OBSERVATIONS"]="Observations";
$MESSAGES["ALERT_FIELD_VULN_MODIFIED"]="Vulnerability updated";
$MESSAGES["ALERT_FIELD_TIME_RESOLUTION"]="Time of resolution";

$MESSAGES["ALERT_SELECT_VIEW_TITLE"]="Show";
$MESSAGES["ALERT_SELECT_VIEW_OPENED"]="Only opened or pending alerts";
$MESSAGES["ALERT_SELECT_VIEW_ALL"]="All alerts";

$MESSAGES["ALERT_NUM_ALERTS_FOUND"]="Have been found %d matches of vulnerable products installed on any server";
$MESSAGES["ALERT_NUM_ALERTS_PROCESSED"]="Have been processed %d alerts";
$MESSAGES["ALERT_NUM_ALERTS_SENT"]="Have been sent %d notifications to the administrators of affected servers";

$MESSAGES["ALERT_STATUS_NOT_SENT"]="Not sent";
$MESSAGES["ALERT_STATUS_VALIDATED"]="Validated";
$MESSAGES["ALERT_STATUS_OPEN"]="Open";
$MESSAGES["ALERT_STATUS_CLOSE"]="Closed";
$MESSAGES["ALERT_STATUS_PENDING"]="Pending";
$MESSAGES["ALERT_STATUS_DISCARDED"]="Discarded";
$MESSAGES["ALERT_STATUS_DUDE"]="Doubt";

$MESSAGES["ALERTS_DONT_SHOW_CLOSED"]="Don't show closed nor discarded.";
$MESSAGES["ALERTS_SHOW_ALL"]="Show all alerts (closed and discarded).";

$MESSAGES["ALERTS_CHANGE_STATUS"]="Change status for selected rows";

// NOTIFICATIONS messages
// (mail body)
$MESSAGES["NOTIFICATION_TITLE"]="Alert notification";
$MESSAGES["NOTIFICATION_SUBJECT"]="SIGVI: Vulnerability alert of level %d at server %s, product %s";
$MESSAGES["NOTIFICATION_ALERT_TITLE"]="A vulnerability of level %d of product %s has been found installed at server %s";
$MESSAGES["NOTIFICATION_UPDATE_SUBJECT"]="SIGVI: The vulnerability associated with the alert of level %d at server %s, product %s, has been updated";
$MESSAGES["NOTIFICATION_VULN_ID"]="Vulnerability identifier";
$MESSAGES["NOTIFICATION_SEVERITY"]="Severity";
$MESSAGES["NOTIFICATION_DESCRIPTION"]="Description";
$MESSAGES["NOTIFICATION_SOFWARE"]="Vulnerable software";
$MESSAGES["NOTIFICATION_LINK"]="Links";
$MESSAGES["NOTIFICATION_OTHER_REFERENCES"]="Other references";
$MESSAGES["NOTIFICATION_SOLUTION"]="Solutions";
$MESSAGES["NOTIFICATION_CARACTERISTICS"]="Vulnerability caracteristics";

$MESSAGES["UNIQ_NOTIFICATION_SUBJECT"]="SIGVI: Vulnerability alerts for your servers";
$MESSAGES["UNIQ_NOTIFICATION_ALERT_TITLE"]="%d vulnerabilities have been found on products installed on your servers.";
$MESSAGES["UNIQ_NOTIFICATION_INFO"]="Access to the <a href='" . SERVER_URL . "'>SIGVI management console</a> to review the status of the alerts and get more information about those vulnerabilities.";
$MESSAGES["UNIQ_NOTIFICATION_SERVER_NAME"]=$MESSAGES["SERVER"];
$MESSAGES["UNIQ_NOTIFICATION_PRODUCT_NAME"]=$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"];
$MESSAGES["UNIQ_NOTIFICATION_VULN_ID"]=$MESSAGES["NOTIFICATION_VULN_ID"];
$MESSAGES["UNIQ_NOTIFICATION_FAS"]=$MESSAGES["ALERT_FIELD_SEVERITY"];
$MESSAGES["UNIQ_NOTIFICATION_NEW"]="New vulnerability";
$MESSAGES["UNIQ_NOTIFICATION_UPDATED"]="Vulnerability updated";

// Cron
$MESSAGES["CRON_VULN_LOAD_SUBJECT"]="SIGVI: Vulnerabilities load process";
$MESSAGES["CRON_VULN_LOAD_BODY"]="Vulnerabilities loaded from source %s: found %s vulnerabilities, %s of them were loaded into dabatase.";
$MESSAGES["CRON_VULN_CHECK_SUBJECT"]= "SIGVI: Vulnerabilities check process";

// Discover
$MESSAGES["DISCOVER_TITLE"]="Automatic software discoverer";

// Filter
$MESSAGES["FILTER_TITLE"]="Filters";
$MESSAGES["FILTER_MORE_INFO"]="For more info and legend, click at the info icon on the top of this page.";
$MESSAGES["FILTER_FIELD_NAME"]="Filter";
$MESSAGES["FILTER_FIELD_DESCRIPTION"]="Description";
$MESSAGES["FILTER_NOTIFICATION"]="Notification filter";
$MESSAGES["FILTER_CHECK"]="Check filter";
$MESSAGES["FILTER_TYPE_FIELD_PASS_AND"]="Pass if all are equal";
$MESSAGES["FILTER_TYPE_FIELD_PASS_OR"]="Pass if ANY is equal";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_AND"]="Filter if all are equal";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_OR"]="Filter if ANY is equal";

// REPOSITORY Administration
$MESSAGES["REPOSITORY_MAIN_TITLE"]="Repositories";
$MESSAGES["REPOSITORY_MGM_TITLE"]="Repositories Administration";
$MESSAGES["REPOSITORY_FIELD_NAME"]="Name";
$MESSAGES["REPOSITORY_FIELD_DBNAME"]="DB Name";
$MESSAGES["REPOSITORY_FIELD_GROUP"]="Group";
$MESSAGES["REPOSITORY_FIELD_PLUGIN"]="Plugin";
$MESSAGES["REPOSITORY_FIELD_PARAMETERS"]="Parameters";
$MESSAGES["REPOSITORY_FIELD_DESCRIPTION"]="Description";
$MESSAGES["REPOSITORY_FIELD_USE_IT"]="Use it?";
$MESSAGES["REPOSITORY_FIELD_RO_USER"]="Remote user (read only)";
$MESSAGES["REPOSITORY_FIELD_RO_PASS"]="Password";
$MESSAGES["REPOSITORY_FIELD_HOST"]="Server";
$MESSAGES["REPOSITORY_FIELD_TYPE"]="Server type";

// Inventory menu
$MESSAGES["INVENTORY"]="Inventory";

// MITYC
$MESSAGES["MITYC"]= "The SIGVI project has been co-financed by the Spanish Ministry of " .
					"Industry, Tourism and Commerce within the National Plan for Scientific " .
					"Research, Development and Technological Innovation 2008-2011.<br>" .
					"[Project reference: TSI-020400-2008-5]";
// FAS
$MESSAGES["FAS_MGM_TITLE"]= "FAS functions management (Final Absolute Severity)";
$MESSAGES["FAS_INCORRECT_FAS"]= "Incorrect FAS";
$MESSAGES["FAS_THERE_IS_ACTIVE_FAS"]= "There is an active FAS";
$MESSAGES["FAS_USE_DEFAULT_FAS"]= "There is not an active FAS in your group, will be used default FAS";
$MESSAGES["FAS_FIELD_NAME"]= "Name";
$MESSAGES["FAS_FIELD_GROUP"]="Group";
$MESSAGES["FAS_FIELD_ENABLE"]= "Active";
$MESSAGES["FAS_VAR_NOT_VALID"]= "Function variable doesn't exist: ";

// RSS
$MESSAGES["RSS_ADMIN"]= "Admin RSS Sources";
$MESSAGES["RSS_LAST_NEWS"]= "Last news";
$MESSAGES["RSS_SEE_ALL"]= "See all";
$MESSAGES["RSS_VULN_NEWS"]= "Last vulnerability news";
$MESSAGES["RSS_SOURCES"]= "RSS Sources";

$MESSAGES["RSS_SOURCES"]= "RSS Sources";
$MESSAGES["RSS_MGM_TITLE"]= "RSS Sources management";
$MESSAGES["RSS_FIELD_NAME"]= "Name";
$MESSAGES["RSS_FIELD_SOURCE"]="Source (URL)";
$MESSAGES["RSS_FIELD_ENABLED"]="Enabled?";

$MESSAGES["RSS_CANT_FIND_ENABLED"]="Can't find any RSS source enabled.";

// CPE
$MESSAGES["PRODUCT_DICTIONARIES_MGM_TITLE"]= "Product management [CPE]";
$MESSAGES["PRODUCT_DICTIONARIES"]="Products dictionaries";
$MESSAGES["CPE_FIELD_NAME"]="Name";
$MESSAGES["CPE_FIELD_PART"]="Part";
$MESSAGES["CPE_FIELD_VENDOR"]="Vendor";
$MESSAGES["CPE_FIELD_PRODUCT"]="Product";
$MESSAGES["CPE_FIELD_VERSION"]="Version";
$MESSAGES["CPE_FIELD_TITLE"]="Title";
$MESSAGES["CPE_FIELD_MODIFICATION_DATE"]="Modification date";
$MESSAGES["CPE_FIELD_STATUS"]="Status";
$MESSAGES["CPE_FIELD_NVD_ID"]="NVD Id";
$MESSAGES["CPE_FIELD_PART_APPLICATION"]="Application";
$MESSAGES["CPE_FIELD_PART_HARDWARE"]="Hardware";
$MESSAGES["CPE_FIELD_PART_OS"]="Operative System";
?>
