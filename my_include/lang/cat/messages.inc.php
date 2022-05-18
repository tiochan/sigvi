<?php

/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage lang
 *
 * Catalan version of application messages
 * Reviewed from Iolanda Garcia
 */

global $MESSAGES;

  ////////////////////////////////////////////////////////////////////////////
 // APPLICATION MESSAGES                                                   //
////////////////////////////////////////////////////////////////////////////

$MESSAGES["APP_ALIAS"]="SIGVI";
$MESSAGES["APP_NAME"]="Sistema de gesti&oacute; de vulnerabilitats";
$MESSAGES["REGISTER_SUCCESS"]=
	"<p><b>Benvingut %s</b></p>." .
	"<p>T'has registrat correctament.</p>" .
	"<p>Per gaudir del SIGVI ara pots anar a la p&agrave;gina de login</p>" .
	"<p> - Primer, revisa les teves dades, vigila que la direcci&oacute; de correu &eacute;s correcta per poder rebre les notificacions d'alertes.</p>" .
	"<p> - El perfil del teu usuari &eacute;s gestor de grup, podr&agrave;s afegir nous usuaris al teu grup.</p>" .
	"<p> - Afegeix els servidors, i indica quins productes tenen instal&middot;lats (per exemple els serveis principals com apache, mysql, ...).</p>" .
	"<p> - Cada nit SIGVI s'actualitzar&agrave; les vulnerabilitats des de les fonts. Si troba alguna vulnerabilitat als teus servidors t'enviar&agrave; una notificaci&oacute; a la teva direcci&oacute; de correu.</p>" .
	"<br>" .
	"<p> - I ara gaudeix... <a href='" . SERVER_URL . HOME . "/index.php'>p&agrave;gina de login</a>.</p>";

$MESSAGES["ABOUT_APP"]=
	"<p>SIGVI &eacute;s un producte de UPCnet S.L.</p>";

// MAIN PAGE
$MESSAGES["SERVER_VULN_STATUS"]="Estat de les vulnerabilitats dels servidors";
$MESSAGES["TO-DO"]="TO-DO";
$MESSAGES["INDEX"]="&Iacute;ndex";
$MESSAGES["SERVERS"]="Servidors";
$MESSAGES["SERVER"]="Servidor";
$MESSAGES["SERVICES"]="Serveis";
$MESSAGES["SERVERS_AND_SERVICES"]="Servidors i serveis";
$MESSAGES["PRODUCTS"]="Productes";
$MESSAGES["VULNERABILITIES"]="Vulnerabilitats";
$MESSAGES["SERVER_PRODUCTS"]="Productes intal&middot;lats als servidors";
$MESSAGES["SOURCES_ADMIN"]="Administraci&oacute; de les fonts";
$MESSAGES["SOURCES"]="Fonts";
$MESSAGES["VULN_SOURCES_ADMIN"]="Administraci&oacute; de les fonts de vulnerabilitats";
$MESSAGES["VULN_SOURCES"]="Fonts de vulnerabilitats";
$MESSAGES["VULN_SOURCES_TESTING"]="Provar les fonts de dades";
$MESSAGES["VULN_SOURCES_LOADING"]="C&agrave;rrega de vulnerabilitats";
$MESSAGES["VULN_SOURCES_LOAD"]="C&agrave;rrega manual des de les fonts";
$MESSAGES["ALERTS"]="Alertes";
$MESSAGES["ALERT_VALIDATION_SHORT"]="Validaci&oacute; d'alertes";
$MESSAGES["ALERT_VALIDATION"]="Validaci&oacute; de alertes amb dubtes";
$MESSAGES["ALERT_ASSIGNED_TO"]="Assignat a";
$MESSAGES["ALERT_ASSIGNED_TO_UNSET"]="Les alertes associades a l'usuari han estat alliberades";
$MESSAGES["ALERTS_TO_VALIDATE"]="Hi ha %d alertes per validar";
$MESSAGES["ALERTS_PENDING"]="Hi ha %d alertes actives";
$MESSAGES["CHECK_SERVER_VULNERABILITIES"]="Comprovar manualment l'estat de les vulnerabilitats dels servidors";
$MESSAGES["SEE_SERVER_VULNERABILITIES"]="Alertes per servidor";
$MESSAGES["SERVER_STATUS"]="Estat dels servidors";
$MESSAGES["NOTIFICATION_METHODS"]="M&egrave;todes de notificaci&oacute;";
$MESSAGES["SHOW_VULNERABILITY_EVOLUTION"]="Evoluci&oacute; de les vulnerabilitats";
$MESSAGES["STATISTICS"]="Estad&iacute;stiques";

$MESSAGES["HIGH_RISK"]="Risc alt";
$MESSAGES["MED_RISK"]="Risc mig";
$MESSAGES["LOW_RISK"]="Risc baix";

$MESSAGES["SERVER_PRODUCT_MGM"]="Gesti&oacute; dels productes als servidors";

$MESSAGES["VULN"]="Vulnerabilitats";
$MESSAGES["LOAD_VULN"]="Carregar la llista de vulnerabilidats a la BBDD";
$MESSAGES["LOAD_VULNERABILITIES_CONFIRM"]="Aquest proc&eacute;s pot trigar una bona estona.<br>Vol continuar?";
$MESSAGES["LOAD_PROD"]="Carregar la llista de productes a la BBDD";
$MESSAGES["CHECK_STATUS"]="Comprovaci&oacute; de l'estat";
$MESSAGES["CHECK_SERVER_STATUS"]="Revisar les vulnerabilitats dels servidors";
$MESSAGES["SEARCH_VULNERABILITIES_CONFIRM"]="Vol continuar?";

// SKILL LEVELS
$MESSAGES["SKILL_0"]="Adm. SIGVI";
$MESSAGES["SKILL_3"]="Adm. d'un grup";
$MESSAGES["SKILL_5"]="Adm. d'equips";

// SERVER management messages
$MESSAGES["SERVER_MGM_TITLE"]="Gesti&oacute; de servidors";
$MESSAGES["SERVER_MGM_STILL_HAS_PRODUCTS"]="Aquest servidor encara te productes associats. No es pot esborrar.";
$MESSAGES["SERVER_MGM_CANT_DELETE"]="Ho sento, per&ograve; un administrador de servidors no pot esborrar un servidor.";
$MESSAGES["SERVER_MGM_CANT_UPDATE"]="Ho sento, per&ograve; un administrador de servidors no pot modificar un servidor.";

$MESSAGES["SERVER_FIELD_NAME"]="Nom";
$MESSAGES["SERVER_FIELD_VENDOR"]="Marca";
$MESSAGES["SERVER_FIELD_MODEL"]="Model";
$MESSAGES["SERVER_FIELD_CPU"]="CPU";
$MESSAGES["SERVER_FIELD_RAM"]="RAM";
$MESSAGES["SERVER_FIELD_DISC"]="Discos";
$MESSAGES["SERVER_FIELD_SERIAL_NUMBER"]="N&uacute;mero serie";
$MESSAGES["SERVER_FIELD_OS"]="Sistema Operatiu";
$MESSAGES["SERVER_FIELD_GROUP"]="Grup";
$MESSAGES["SERVER_FIELD_LOCATION"]="Localitzaci&oacute;";
$MESSAGES["SERVER_FIELD_IP"]="IP";
$MESSAGES["SERVER_FIELD_ZONE"]="Zona";
$MESSAGES["SERVER_FIELD_OBSERVATIONS"]="Observacions";

$MESSAGES["SERVER_FIELD_NAME"]="Nom";

// PRODUCTS management messages
$MESSAGES["PRODUCT_MGM_TITLE"]="Gesti&oacute; de productes";
$MESSAGES["PRODUCT_MGM_STILL_HAS_SERVERS"]="El producte est&agrave; associat a algun servidor i no es pot donar de baixa.";

$MESSAGES["PRODUCT_FIELD_ID"]="Identificador del producte";
$MESSAGES["PRODUCT_FIELD_VENDOR"]="Fabricant";
$MESSAGES["PRODUCT_FIELD_NAME"]="Nom del producte";
$MESSAGES["PRODUCT_ID_FIELD_NAME"]="Identificador del producte";
$MESSAGES["PRODUCT_FIELD_FULL"]="Tot";
$MESSAGES["PRODUCT_FIELD_VERSION"]="Versi&oacute;";

// PRODUCTS updated --> alerts closed
$MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"]="El software ha estat upgradat i les alertes associades al producte anterior han estat tancades.";
$MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"]="S'ha eliminat el software i les alertes associades han estat tancades.";

// SEARCH PRODUCTS messages
$MESSAGES["SEARCH_PRODUCT_TITLE"]="Cerca de productes";

// SERVER_PRODUCTS management messages

$MESSAGES["SERVER_PRODUCT_MGM_TITLE"]="Gesti&oacute; de productes instal&middot;lats als servidors";

$MESSAGES["SERVER_PRODUCT_FIELD_SERVER_NAME"]="Nom del servidor";
$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"]="Producte";
$MESSAGES["SERVER_PRODUCTS_FIELD_PORTS"]="Ports";
$MESSAGES["SERVER_PRODUCTS_FIELD_FILTERED"]="Est&agrave; filtrat?";
$MESSAGES["SERVER_PRODUCTS_FIELD_CRITIC"]="D&oacute;na un servei cr&iacute;tic?";
$MESSAGES["SERVER_PRODUCTS_FIELD_PROTOCOL"]="Protocol de transmissi&oacute; (TCP,UDP,...)";


// SOURCE management messages
$MESSAGES["SOURCE_MGM_TITLE"]="Gesti&oacute; de fonts de vulnerabilitats";

$MESSAGES["SOURCE_FIELD_NAME"]="Alias";
$MESSAGES["SOURCE_FIELD_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["SOURCE_FIELD_HOME_URL"]="URL del site";
$MESSAGES["SOURCE_FIELD_FILE_URL"]="URL del fitxer";
$MESSAGES["SOURCE_FIELD_USE_IT"]="Utilitzar?";
$MESSAGES["SOURCE_FIELD_PARSER_LOCATION"]="Parser";
$MESSAGES["SOURCE_FIELD_PARAMETERS"]="Par&agrave;metres";

$MESSAGES["SOURCES_FIELD_ALIAS"]="Selecciona la font a carregar";
$MESSAGES["SOURCES_TEST_FIELD_ALIAS"]="Selecciona la font a provar";

// NOTIFICATION METHODS management messages
$MESSAGES["NOTIF_METHOD_MGM_TITLE"]="M&egrave;todes de notificaci&oacute; d'alertes";

$MESSAGES["NOTIF_METHOD_FIELD_NAME"]="Alias";
$MESSAGES["NOTIF_METHOD_FIELD_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["NOTIF_METHOD_FIELD_USE_IT"]="Utilitzar?";
$MESSAGES["NOTIF_METHOD_FIELD_METHOD_LOCATION"]="M&ograve;dul";

// VULNERABILITIES management messages
$MESSAGES["VULN_MGM_TITLE"]="Gesti&oacute; de vulnerabilitats";
$MESSAGES["VULN_COUNTER"]="Contador de vulnerabilitats";

$MESSAGES["VULN_FIELD_VULN_ID"]="CVE/CAN";
$MESSAGES["VULN_FIELD_PUBLISH_DATE"]="Data de publicaci&oacute;";
$MESSAGES["VULN_FIELD_MODIFY_DATE"]="Data de revisi&oacute;";
$MESSAGES["VULN_FIELD_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["VULN_FIELD_SEVERITY"]="Severitat";
$MESSAGES["VULN_FIELD_AR_LAUNCH_REMOTELY"]="REQUERIMENTS D'ACC&Eacute;S<br>Explotable remotament?";
$MESSAGES["VULN_FIELD_AR_LAUNCH_LOCALLY"]="REQUERIMENTS D'ACC&Eacute;S<br>Explotable localment?";
$MESSAGES["VULN_FIELD_SECURITY_PROTECTION"]="CONSEQ&Uuml;&Egrave;NCIES<br>Guanya protecci&oacute; de seguretat";
$MESSAGES["VULN_FIELD_OBTAIN_ALL_PRIV"]="CONSEQ&Uuml;&Egrave;NCIES<br>Guanya alguns privilegis";
$MESSAGES["VULN_FIELD_OBTAIN_SOME_PRIV"]="CONSEQ&Uuml;&Egrave;NCIES<br>Guanya tots els privilegis";
$MESSAGES["VULN_FIELD_CONFIDENTIALITY"]="CONSEQ&Uuml;&Egrave;NCIES<br>Comprom&iacute;s de confidencialitat";
$MESSAGES["VULN_FIELD_INTEGRITY"]="CONSEQ&Uuml;&Egrave;NCIES<br>P&egrave;rdua d'integritat";
$MESSAGES["VULN_FIELD_AVAILABILITY"]="CONSEQ&Uuml;&Egrave;NCIES<br>P&egrave;rdua de disponibilitat";
$MESSAGES["VULN_FIELD_INPUT_VALIDATION_ERROR"]="TIPUS<br>Error de validaci&oacute; de dades";
$MESSAGES["VULN_FIELD_BOUNDARY_CONDITION_ERROR"]="TIPUS<br>Error de condici&oacute;";
$MESSAGES["VULN_FIELD_BUFFER_OVERFLOW"]="TIPUS<br>buffer overflow";
$MESSAGES["VULN_FIELD_ACCESS_VALIDATION_ERROR"]="TIPUS<br>Error de validaci&oacute; d'acc&eacute;s";
$MESSAGES["VULN_FIELD_EXCEPTIONAL_CONDITION_ERROR"]="TIPUS<br>Error de condici&oacute; excepcional";
$MESSAGES["VULN_FIELD_ENVIRONMENT_ERROR"]="TIPUS<br>Error de l'entorn";
$MESSAGES["VULN_FIELD_CONFIGURATION_ERROR"]="TIPUS<br>Error de configuraci&oacute;";
$MESSAGES["VULN_FIELD_RACE_CONDITION"]="TIPUS<br>'race condition'";
$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"]="TIPUS<br>Altres";
$MESSAGES["VULN_FIELD_VULN_SOFTWARE"]="Software afectat";
$MESSAGES["VULN_FIELD_LINKS"]="Enlla&ccedil;os";
$MESSAGES["VULN_FIELD_OTHER_REFERENCES"]="Altres refer&egrave;ncies";
$MESSAGES["VULN_FIELD_OTHER"]="...";
$MESSAGES["VULN_FIELD_SOLUTION"]="Solucions";
$MESSAGES["VULN_FIELD_SOURCE"]="Font";

$MESSAGES["VULN_EXPLOID_REMOTELLY"]="Explotable remotament";
$MESSAGES["VULN_EXPLOID_ONLY_LOCALLY"]="Cal acc&eacute; f&iacute;sic";

// SEARCH VULNERABILITY messages
$MESSAGES["SEARCH_VULNERABILITY_TITLE"]="Cerca de vulnerabilitats";

// SEARCH ALERT messages
$MESSAGES["SEARCH_ALERT_TITLE"]="Cerca d'alertes";

// ALERTS management messages
$MESSAGES["ALERT_MGM_TITLE"]="Gesti&oacute; d'alertes";
$MESSAGES["ALERT_MGM_NOTIFICATION_METHOD"]="M&egrave;tode de notificaci&oacute;";

$MESSAGES["ALERT_COUNTER"]="Contador d'alertes";

$MESSAGES["ALERT_SERVER_FIELD_NAME"]="Servidor";
$MESSAGES["ALERT_PRODUCT_FIELD_NAME"]="Producte afectat";
$MESSAGES["ALERT_VULN_FIELD_VULN_ID"]="Vulnerabilitat";
$MESSAGES["ALERT_FIELD_DATE"]="Data de creaci&oacute;";
$MESSAGES["ALERT_FIELD_STATUS"]="Estat"; // [1=obert|2=pendent|3=resolt|4=tancat]
$MESSAGES["ALERT_FIELD_SEVERITY"]="FAS (Final Alert Severity)"; // [0=lleu, ..., 9=molt critic]
$MESSAGES["ALERT_FIELD_OBSERVATIONS"]="Observacions";
$MESSAGES["ALERT_FIELD_VULN_MODIFIED"]="Vuln actualitzada";
$MESSAGES["ALERT_FIELD_TIME_RESOLUTION"]="Temps de resoluci&oacute;";

$MESSAGES["ALERT_SELECT_VIEW_TITLE"]="Mostrar";
$MESSAGES["ALERT_SELECT_VIEW_OPENED"]="Nom&eacute;s les alertes obertes o pendents";
$MESSAGES["ALERT_SELECT_VIEW_ALL"]="Totes les alertes";

$MESSAGES["ALERT_NUM_ALERTS_FOUND"]="S'han trobat %d casos de productes instal&middot;lats a algun equip afectats per vulnerabilitats";
$MESSAGES["ALERT_NUM_ALERTS_PROCESSED"]="S'han processat %d alertes";
$MESSAGES["ALERT_NUM_ALERTS_SENT"]="S'han enviat %d notificacions als administradors dels equips afectats";

$MESSAGES["ALERT_STATUS_NOT_SENT"]="No enviada";
$MESSAGES["ALERT_STATUS_VALIDATED"]="Validada";
$MESSAGES["ALERT_STATUS_OPEN"]="Oberta";
$MESSAGES["ALERT_STATUS_CLOSE"]="Tancada";
$MESSAGES["ALERT_STATUS_PENDING"]="Pendent";
$MESSAGES["ALERT_STATUS_DISCARDED"]="Descartada";
$MESSAGES["ALERT_STATUS_DUDE"]="Dubte";

$MESSAGES["ALERTS_DONT_SHOW_CLOSED"]="No mostrar les tancades o descartades.";
$MESSAGES["ALERTS_SHOW_ALL"]="Mostrar totes les alertes (tancades i descartades).";

$MESSAGES["ALERTS_CHANGE_STATUS"]="Canviar l'estat de les alertes seleccionades";

// NOTIFICATIONS messages
// (mail body)
$MESSAGES["NOTIFICATION_TITLE"]="Notificaci&oacute; d'alertes";
$MESSAGES["NOTIFICATION_SUBJECT"]="SIGVI: Alerta de vulnerabilitat de nivell %d al servidor %s, producte %s";
$MESSAGES["NOTIFICATION_ALERT_TITLE"]="S'ha trobat una vulnerabilitat de nivell %d al producte %s instal&middot;lat al servidor %s";
$MESSAGES["NOTIFICATION_UPDATE_SUBJECT"]="SIGVI: Actualitzaci&oacute; de la vulnerabilitat associada a l'alerta nivell %d al servidor %s, producte %s";
$MESSAGES["NOTIFICATION_VULN_ID"]="Identificador de vulnerabilitat";
$MESSAGES["NOTIFICATION_SEVERITY"]="Severitat";
$MESSAGES["NOTIFICATION_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["NOTIFICATION_SOFWARE"]="Software afectat";
$MESSAGES["NOTIFICATION_LINK"]="Enllacos d'inter&egrave;s";
$MESSAGES["NOTIFICATION_OTHER_REFERENCES"]="Altres refer&egrave;ncies";
$MESSAGES["NOTIFICATION_SOLUTION"]="Solucions";
$MESSAGES["NOTIFICATION_CARACTERISTICS"]="Caracter&iacute;stiques de la vulnerabilitat";

$MESSAGES["UNIQ_NOTIFICATION_SUBJECT"]="SIGVI: Alerta de vulnerabilitats als vostres servidors";
$MESSAGES["UNIQ_NOTIFICATION_ALERT_TITLE"]="S'han trobat %d vulnerabilitats als servidors del vostre grup.";
$MESSAGES["UNIQ_NOTIFICATION_INFO"]="Podeu accedir a la <a href='" . HOME . "'>consola de gesti&oacute;</a> del SIGVI per a revisar el estat de les alerts i obtenir m&eacute;s informaci&oacute; de les vulnerabilitats.";
$MESSAGES["UNIQ_NOTIFICATION_SERVER_NAME"]=$MESSAGES["SERVER"];
$MESSAGES["UNIQ_NOTIFICATION_PRODUCT_NAME"]=$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"];
$MESSAGES["UNIQ_NOTIFICATION_VULN_ID"]=$MESSAGES["NOTIFICATION_VULN_ID"];
$MESSAGES["UNIQ_NOTIFICATION_FAS"]=$MESSAGES["ALERT_FIELD_SEVERITY"];
$MESSAGES["UNIQ_NOTIFICATION_NEW"]="Nova vulnerabilitat";
$MESSAGES["UNIQ_NOTIFICATION_UPDATED"]="Vulnerabilitat actualitzada";

// Cron
$MESSAGES["CRON_VULN_LOAD_SUBJECT"]="SIGVI: Proces de carrega automatica de vulnerabilitats";
$MESSAGES["CRON_VULN_LOAD_BODY"]="Resultats de la carrega de la font %s: %s vulnerabilitats trobades, %s afegides a la base de dades.";
$MESSAGES["CRON_VULN_CHECK_SUBJECT"]= "SIGVI: Proces de comprovacio automatica de l'estat de les vulnerabilitats als servidors";

// Discover
$MESSAGES["DISCOVER_TITLE"]="Cerca autom&agrave;tica de serveis";

// Filter
$MESSAGES["FILTER_TITLE"]="Filtres de notificaci&oacute;";
$MESSAGES["FILTER_MORE_INFO"]="Per a m&eacute;s informaci&oacute; cliqueu la icona de 'i' a dalt.";
$MESSAGES["FILTER_FIELD_NAME"]="Filtre";
$MESSAGES["FILTER_FIELD_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["FILTER_NOTIFICATION"]="Filtre de notificacions";
$MESSAGES["FILTER_CHECK"]="Filtre de vulnerabilitats";
$MESSAGES["FILTER_TYPE_FIELD_PASS_AND"]="Passar si compleix tots";
$MESSAGES["FILTER_TYPE_FIELD_PASS_OR"]="Passar si compleix algun";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_AND"]="Filtrar si compleix tots";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_OR"]="Filtrar si compleix algun";

// REPOSITORY Administration
$MESSAGES["REPOSITORY_MAIN_TITLE"]="Repositoris";
$MESSAGES["REPOSITORY_MGM_TITLE"]="Administraci&oacute; dels repositoris";
$MESSAGES["REPOSITORY_FIELD_NAME"]="Nom";
$MESSAGES["REPOSITORY_FIELD_DBNAME"]="Nom BD";
$MESSAGES["REPOSITORY_FIELD_GROUP"]="Grup";
$MESSAGES["REPOSITORY_FIELD_PLUGIN"]="Plugin";
$MESSAGES["REPOSITORY_FIELD_PARAMETERS"]="Par&agrave;metres";
$MESSAGES["REPOSITORY_FIELD_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["REPOSITORY_FIELD_USE_IT"]="Utilitzar?";
$MESSAGES["REPOSITORY_FIELD_RO_USER"]="Usuari d'acc&eacute;s remot (nom&eacute;s lectura)";
$MESSAGES["REPOSITORY_FIELD_RO_PASS"]="Clau d'acc&eacute;s";
$MESSAGES["REPOSITORY_FIELD_HOST"]="Servidor";
$MESSAGES["REPOSITORY_FIELD_TYPE"]="Tipus de servidor";

// Inventory menu
$MESSAGES["INVENTORY"]="Inventari";

// MITYC
$MESSAGES["MITYC"]= "El projecte SIGVI ha estat cofinan&ccedil;at pel Ministeri d'Industria, Turisme" .
					"i Comer&ccedil;, dins el Pla Nacional d'Investigaci&oacute; Cient&iacute;fica," .
					"Desenvolupament i Innovaci&oacute; Tecnol&egrave;gica 2008-2011.<br>" .
					"[Codi del projecte: TSI-020400-2008-5]";
// FAS
$MESSAGES["FAS_MGM_TITLE"]= "Gesti&oacute; de les funcions FAS (Final Absolute Severity)";
$MESSAGES["FAS_INCORRECT_FAS"]= "FAS incorrecta";
$MESSAGES["FAS_THERE_IS_ACTIVE_FAS"]= "Ja tens una FAS activa";
$MESSAGES["FAS_USE_DEFAULT_FAS"]= "No tens cap FAS activa en el teu grup, farem servir la gen&ecute;rica";
$MESSAGES["FAS_FIELD_NAME"]= "Nom";
$MESSAGES["FAS_FIELD_GROUP"]="Grup";
$MESSAGES["FAS_FIELD_ENABLE"]= "Actiu";
$MESSAGES["FAS_VAR_NOT_VALID"]= "Hi ha una variable que no existeix en la funci&oacute: ";

// RSS
$MESSAGES["RSS_ADMIN"]= "Administrar fonts RSS";
$MESSAGES["RSS_LAST_NEWS"]= "&Uacute;ltimes not&iacute;cies";
$MESSAGES["RSS_SEE_ALL"]= "Veure totes";
$MESSAGES["RSS_VULN_NEWS"]= "&Uacute;ltimes vulnerabilitats publicades";
$MESSAGES["RSS_SOURCES"]= "Fonts RSS";

$MESSAGES["RSS_SOURCES"]= "Fonts RSS";
$MESSAGES["RSS_MGM_TITLE"]= "Gesti&oacute; de fonts RSS";
$MESSAGES["RSS_FIELD_NAME"]= "Nom";
$MESSAGES["RSS_FIELD_SOURCE"]="Font (URL)";
$MESSAGES["RSS_FIELD_ENABLED"]="Activada?";

$MESSAGES["RSS_CANT_FIND_ENABLED"]="No s'ha trobat cap font RSS activa.";

// CPE
$MESSAGES["PRODUCT_DICTIONARIES_MGM_TITLE"]= "Gesti&oacute; dels productes [CPE]";
$MESSAGES["PRODUCT_DICTIONARIES"]="Diccionaris de productes";
$MESSAGES["CPE_FIELD_NAME"]="Nom";
$MESSAGES["CPE_FIELD_PART"]="Part";
$MESSAGES["CPE_FIELD_VENDOR"]="Fabricant";
$MESSAGES["CPE_FIELD_PRODUCT"]="Producte";
$MESSAGES["CPE_FIELD_VERSION"]="Versi&oacute;";
$MESSAGES["CPE_FIELD_TITLE"]="T&iacute;tol";
$MESSAGES["CPE_FIELD_MODIFICATION_DATE"]="Data de modificaci&oacute;";
$MESSAGES["CPE_FIELD_STATUS"]="Estat";
$MESSAGES["CPE_FIELD_NVD_ID"]="NVD Id";
$MESSAGES["CPE_FIELD_PART_APPLICATION"]="Aplicaci&oacute;";
$MESSAGES["CPE_FIELD_PART_HARDWARE"]="Hardware";
$MESSAGES["CPE_FIELD_PART_OS"]="Sistema Operatiu";

//Auditoria
$MESSAGES["AUDIT"]="AUDITORIA";
$MESSAGES["SECURITY_AUDIT"]="Auditoria de seguretat";
$MESSAGES["AUDIT_MGM_TITLE"]="Auditoria de seguretat";
$MESSAGES["AUDIT_FIELD_SERVER"]="Servidor";
$MESSAGES["AUDIT_FIELD_PORT"]="Port";
$MESSAGES["AUDIT_FIELD_NAME"]="NVT";
$MESSAGES["AUDIT_FIELD_NVT_ID"]="ID NVT";
$MESSAGES["AUDIT_FIELD_VULN_ID"]="CVE/CAN";
$MESSAGES["AUDIT_FIELD_BID"]="BID";
$MESSAGES["AUDIT_FIELD_DESCRIPTION"]="Descripci&oacute;";
$MESSAGES["AUDIT_FIELD_SOLUTION"]="Soluci&oacute;";
$MESSAGES["AUDIT_FIELD_DATE"]="Data";
$MESSAGES["AUDIT_FIELD_THREAT"]="Amena&ccedil;a";
$MESSAGES["AUDIT_FIELD_RISK_FACTOR"]="Factor de risc";
$MESSAGES["AUDIT_FIELD_REFERENCES"]="Refer&egrave;ncies";