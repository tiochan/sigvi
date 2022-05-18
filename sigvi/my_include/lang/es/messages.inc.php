<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage lang
 *
 * Spanish version of application messages
 *
 */

  ////////////////////////////////////////////////////////////////////////////
 // APPLICATION MESSAGES                                                   //
////////////////////////////////////////////////////////////////////////////

$MESSAGES["APP_ALIAS"]="SIGVI";
$MESSAGES["APP_NAME"]="Sistema de gesti&oacute;n de vulnerabilidades";
$MESSAGES["REGISTER_SUCCESS"]=
	"<p><b>Bienvenido %s</b></p>." .
	"<p>El registro se ha completado correctamente.</p>" .
	"<p>Para acceder al SIGVI puede ir a la <a href='" . SERVER_URL . HOME . "/index.php'>p&aacute;gina de entrada</a></p>" .
	"<p> - Primero, revise sus datos, cuidando que la direcci&oacute;n de correo es correcta para poder recibir las notificaciones de alertas.</p>" .
	"<p> - El perfil de su usuario es de gestor de grupo. Podr&aacute; agregar nuevos usuarios a su grupo.</p>" .
	"<p> - A&ntilde;ada servidores, e indique qu&eacute; productos tienen instalados (por ejemplo los servicios principales como apache, mysql, ...).</p>" .
	"<p> - Diariamente, el SIGVI actualizar&aacute; las vulnerabilidades desde las fuentes. Si encuentra alguna vulnerabilidad que afecta a alguno de los productos instalados en sus servidores le enviar&aacute; una notificaci&oacute;n a su direcci&oacute;n de correo.</p>";
	"<br>" .
	"<p><a href='" . SERVER_URL . HOME . "/index.php'>p&agrave;gina de login</a>.</p>";

$MESSAGES["ABOUT_APP"]=
	"<p>SIGVI es un producto de UPCnet S.L.</p>";

// MAIN PAGE
$MESSAGES["SERVER_VULN_STATUS"]="Estado de las vulnerabilidades de los servidores";
$MESSAGES["TO-DO"]="TO-DO";
$MESSAGES["INDEX"]="&Iacute;ndice";
$MESSAGES["SERVERS"]="Servidores";
$MESSAGES["SERVER"]="Servidor";
$MESSAGES["SERVICES"]="Servicios";
$MESSAGES["SERVERS_AND_SERVICES"]="Servidores y servicios";
$MESSAGES["PRODUCTS"]="Productos";
$MESSAGES["VULNERABILITIES"]="Vulnerabilidades";
$MESSAGES["SERVER_PRODUCTS"]="Productos instalados en los servidores";
$MESSAGES["SOURCES_ADMIN"]="Administraci&oacute;n de las fuentes";
$MESSAGES["SOURCES"]="Fuentes";
$MESSAGES["VULN_SOURCES_ADMIN"]="Administraci&oacute;n de las fuentes de vulnerabilidades";
$MESSAGES["VULN_SOURCES"]="Fuentes de vulnerabilidades";
$MESSAGES["VULN_SOURCES_TESTING"]="Probar las fuentes";
$MESSAGES["VULN_SOURCES_LOADING"]="Carga de vulnerabilidades";
$MESSAGES["VULN_SOURCES_LOAD"]="Cargar manual desde las fuentes";
$MESSAGES["ALERTS"]="Alertas";
$MESSAGES["ALERT_VALIDATION_SHORT"]="Validaci&oacute;n de alertas";
$MESSAGES["ALERT_VALIDATION"]="Validaci&oacute;n de alertas con dudas";
$MESSAGES["ALERT_ASSIGNED_TO"]="Asignado a";
$MESSAGES["ALERT_ASSIGNED_TO_UNSET"]="Desasociadas las alertas del usuario";
$MESSAGES["ALERTS_TO_VALIDATE"]="Hay %d alertas por validar";
$MESSAGES["ALERTS_PENDING"]="Hay %d alertas activas";
$MESSAGES["CHECK_SERVER_VULNERABILITIES"]="Comprobar manualmente el estado de las vulnerabilidades de los servidores";
$MESSAGES["SEE_SERVER_VULNERABILITIES"]="Alertas por servidor";
$MESSAGES["SERVER_STATUS"]="Estado de los servidores";
$MESSAGES["NOTIFICATION_METHODS"]="M&eacute;todos de notificaci&oacute;n";
$MESSAGES["SHOW_VULNERABILITY_EVOLUTION"]="Evoluci&oacute;n de las vulnerabilidades";
$MESSAGES["STATISTICS"]="Estad&iacute;sticas";

$MESSAGES["HIGH_RISK"]="Riesgo alto";
$MESSAGES["MED_RISK"]="Riesgo medio";
$MESSAGES["LOW_RISK"]="Riesgo bajo";

$MESSAGES["SERVER_PRODUCT_MGM"]="Gesti&oacute;n de los productos en los servidores";

$MESSAGES["VULN"]="Vulnerabilidades";
$MESSAGES["LOAD_VULN"]="Cargar la lista de vulnerabilidades en la BBDD";
$MESSAGES["LOAD_VULNERABILITIES_CONFIRM"]="Este proceso puede tardar bastante.<br>Quiere continuar?";
$MESSAGES["LOAD_PROD"]="Cargar la lista de productos en la BBDD";
$MESSAGES["CHECK_STATUS"]="Comprobar el estado";
$MESSAGES["CHECK_SERVER_STATUS"]="Revisar las vulnerabilidades de los servidores";
$MESSAGES["SEARCH_VULNERABILITIES_CONFIRM"]="Quiere continuar?";

// SKILL LEVELS
$MESSAGES["SKILL_0"]="Adm. SIGVI";
$MESSAGES["SKILL_3"]="Adm. de un grup";
$MESSAGES["SKILL_5"]="Adm. de equipos";

// SERVER managemente messages
$MESSAGES["SERVER_MGM_TITLE"]="Gesti&oacute;n de servidores";
$MESSAGES["SERVER_MGM_STILL_HAS_PRODUCTS"]="Este servidor a&uacute;n tiene productos asociados. No se puede borrar.";
$MESSAGES["SERVER_MGM_CANT_DELETE"]="Lo siento, pero un administrador de servidores no puede borrar un servidor.";
$MESSAGES["SERVER_MGM_CANT_UPDATE"]="Lo siento, pero un administrador de servidores no puede modificar un servidor.";

$MESSAGES["SERVER_FIELD_NAME"]="Nombre";
$MESSAGES["SERVER_FIELD_VENDOR"]="Marca";
$MESSAGES["SERVER_FIELD_MODEL"]="Modelo";
$MESSAGES["SERVER_FIELD_CPU"]="CPU";
$MESSAGES["SERVER_FIELD_RAM"]="RAM";
$MESSAGES["SERVER_FIELD_DISC"]="Discos";
$MESSAGES["SERVER_FIELD_SERIAL_NUMBER"]="N&uacute;mero de serie";
$MESSAGES["SERVER_FIELD_OS"]="Sistema Operativo";
$MESSAGES["SERVER_FIELD_GROUP"]="Grupo";
$MESSAGES["SERVER_FIELD_LOCATION"]="Localizaci&oacute;n";
$MESSAGES["SERVER_FIELD_IP"]="IP";
$MESSAGES["SERVER_FIELD_ZONE"]="Zona";
$MESSAGES["SERVER_FIELD_OBSERVATIONS"]="Observaciones";

$MESSAGES["SERVER_FIELD_NAME"]="Nombre";

// PRODUCTS managemente messages
$MESSAGES["PRODUCT_MGM_TITLE"]="Gesti&oacute;n de productos";
$MESSAGES["PRODUCT_MGM_STILL_HAS_SERVERS"]="El producto est&aacute; asociado a alg&uacute;n servidor y no se puede dar de baja.";

$MESSAGES["PRODUCT_FIELD_ID"]="Identificador del producto";
$MESSAGES["PRODUCT_FIELD_VENDOR"]="Fabricante";
$MESSAGES["PRODUCT_FIELD_NAME"]="Nombre del producto";
$MESSAGES["PRODUCT_ID_FIELD_NAME"]="Identificador del producto";
$MESSAGES["PRODUCT_FIELD_FULL"]="Todo";
$MESSAGES["PRODUCT_FIELD_VERSION"]="Versi&oacute;n";

// PRODUCTS updated --> alerts closed
$MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"]="El software ha sido actualizado y las alertas asociadas al producto anterior han sido cerradas.";
$MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"]="Se ha eliminado el software y se han cerrado las alertas asociadas.";

// SEARCH PRODUCTS messages
$MESSAGES["SEARCH_PRODUCT_TITLE"]="B&uacute;squeda de productos";

// SERVER_PRODUCTS managemente messages

$MESSAGES["SERVER_PRODUCT_MGM_TITLE"]="Gesti&oacute;n de productos instalados en los servidores";

$MESSAGES["SERVER_PRODUCT_FIELD_SERVER_NAME"]="Nombre del servidor";
$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"]="Producto";
$MESSAGES["SERVER_PRODUCTS_FIELD_PORTS"]="Puertos";
$MESSAGES["SERVER_PRODUCTS_FIELD_FILTERED"]="&iquest;Est&aacute; filtrado?";
$MESSAGES["SERVER_PRODUCTS_FIELD_CRITIC"]="&iquest;Da un servicio cr&iacute;tico?";
$MESSAGES["SERVER_PRODUCTS_FIELD_PROTOCOL"]="Protocolo de transmisi&oacute;n (TCP,UDP,...)";


// SOURCE managemente messages
$MESSAGES["SOURCE_MGM_TITLE"]="Gesti&oacute;n de fuentes de vulnerabilidades";

$MESSAGES["SOURCE_FIELD_NAME"]="Alias";
$MESSAGES["SOURCE_FIELD_DESCRIPTION"]="Descripci&oacute;n";
$MESSAGES["SOURCE_FIELD_HOME_URL"]="URL del site";
$MESSAGES["SOURCE_FIELD_FILE_URL"]="URL del fichero";
$MESSAGES["SOURCE_FIELD_USE_IT"]="&iquest;Utilizar?";
$MESSAGES["SOURCE_FIELD_PARSER_LOCATION"]="Parser";
$MESSAGES["SOURCE_FIELD_PARAMETERS"]="Par&aacute;metros";

$MESSAGES["SOURCES_FIELD_ALIAS"]="Selecciona la fuente a cargar";
$MESSAGES["SOURCES_TEST_FIELD_ALIAS"]="Selecciona la fuente a probar";

// NOTIFICATION METHODS managemente messages
$MESSAGES["NOTIF_METHOD_MGM_TITLE"]="M&eacute;todos de notificaci&oacute;n de alertas";

$MESSAGES["NOTIF_METHOD_FIELD_NAME"]="Alias";
$MESSAGES["NOTIF_METHOD_FIELD_DESCRIPTION"]="Descripci&oacute;n";
$MESSAGES["NOTIF_METHOD_FIELD_USE_IT"]="&iquest;Utilizar?";
$MESSAGES["NOTIF_METHOD_FIELD_METHOD_LOCATION"]="M&oacute;dulo";

// VULNERABILITIES managemente messages
$MESSAGES["VULN_MGM_TITLE"]="Gesti&oacute;n de vulnerabilidades";
$MESSAGES["VULN_COUNTER"]="Contador de vulnerabilidades";

$MESSAGES["VULN_FIELD_VULN_ID"]="CVE/CAN";
$MESSAGES["VULN_FIELD_PUBLISH_DATE"]="Fecha de publicaci&oacute;n";
$MESSAGES["VULN_FIELD_MODIFY_DATE"]="Fecha de revisi&oacute;n";
$MESSAGES["VULN_FIELD_DESCRIPTION"]="Descripci&oacute;n";
$MESSAGES["VULN_FIELD_SEVERITY"]="Criticidad";
$MESSAGES["VULN_FIELD_AR_LAUNCH_REMOTELY"]="REQUISITOS DE ACCESO<br>&iquest;Se puede explotar remotamente?";
$MESSAGES["VULN_FIELD_AR_LAUNCH_LOCALLY"]="REQUISITOS DE ACCESO<br>&iquest;Se puede explotar localmente?";
$MESSAGES["VULN_FIELD_SECURITY_PROTECTION"]="CONSECUENCIAS<br>Gana protecci&oacute;n de seguridad";
$MESSAGES["VULN_FIELD_OBTAIN_ALL_PRIV"]="CONSECUENCIAS<br>Gana algunos privilegios";
$MESSAGES["VULN_FIELD_OBTAIN_SOME_PRIV"]="CONSECUENCIAS<br>Gana todos los privilegios";
$MESSAGES["VULN_FIELD_CONFIDENTIALITY"]="CONSECUENCIAS<br>Compromiso de confidencialidad";
$MESSAGES["VULN_FIELD_INTEGRITY"]="CONSECUENCIAS<br>P&eacute;rdida de integridad";
$MESSAGES["VULN_FIELD_AVAILABILITY"]="CONSECUENCIAS<br>P&eacute;rdida de disponibilidat";
$MESSAGES["VULN_FIELD_INPUT_VALIDATION_ERROR"]="TIPO<br>Error de validaci&oacute;n de datos";
$MESSAGES["VULN_FIELD_BOUNDARY_CONDITION_ERROR"]="TIPO<br>Error de condici&oacute;n";
$MESSAGES["VULN_FIELD_BUFFER_OVERFLOW"]="TIPO<br>buffer overflow";
$MESSAGES["VULN_FIELD_ACCESS_VALIDATION_ERROR"]="TIPO<br>Error de validaci&oacute;n de acceso";
$MESSAGES["VULN_FIELD_EXCEPTIONAL_CONDITION_ERROR"]="TIPO<br>Error de condici&oacute;n excepcional";
$MESSAGES["VULN_FIELD_ENVIRONMENT_ERROR"]="TIPO<br>Error del entorno";
$MESSAGES["VULN_FIELD_CONFIGURATION_ERROR"]="TIPO<br>Error de configuraci&oacute;n";
$MESSAGES["VULN_FIELD_RACE_CONDITION"]="TIPO<br>'race condition'";
$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"]="TIPO<br>Otros";
$MESSAGES["VULN_FIELD_VULN_SOFTWARE"]="Software afectado";
$MESSAGES["VULN_FIELD_LINKS"]="Enlaces";
$MESSAGES["VULN_FIELD_OTHER_REFERENCES"]="Otras referencias";
$MESSAGES["VULN_FIELD_OTHER"]="...";
$MESSAGES["VULN_FIELD_SOLUTION"]="Soluciones";
$MESSAGES["VULN_FIELD_SOURCE"]="Fuente";

$MESSAGES["VULN_EXPLOID_REMOTELLY"]="Explotable remotamente";
$MESSAGES["VULN_EXPLOID_ONLY_LOCALLY"]="Requiere acceso f&iacute;sico";

// SEARCH VULNERABILITY messages
$MESSAGES["SEARCH_VULNERABILITY_TITLE"]="B&uacute;squeda de vulnerabilidades";

// SEARCH ALERT messages
$MESSAGES["SEARCH_ALERT_TITLE"]="B&uacute;squeda de alertas";

// ALERTS managemente messages
$MESSAGES["ALERT_MGM_TITLE"]="Gesti&oacute;n de alertas";
$MESSAGES["ALERT_MGM_NOTIFICATION_METHOD"]="M&eacute;todo de notificaci&oacute;n";

$MESSAGES["ALERT_COUNTER"]="Contador de alertas";

$MESSAGES["ALERT_SERVER_FIELD_NAME"]="Servidor";
$MESSAGES["ALERT_PRODUCT_FIELD_NAME"]="Producto afectado";
$MESSAGES["ALERT_VULN_FIELD_VULN_ID"]="Vulnerabilidad";
$MESSAGES["ALERT_FIELD_DATE"]="Fecha de creaci&oacute;n";
$MESSAGES["ALERT_FIELD_STATUS"]="Estado"; // [1=abierto|2=pendiente|3=resuelto|4=cerrado]
$MESSAGES["ALERT_FIELD_SEVERITY"]="FAS (Final Alert Severity)"; // [0=not critical, ..., 9=very critical]
$MESSAGES["ALERT_FIELD_OBSERVATIONS"]="Observaciones";
$MESSAGES["ALERT_FIELD_VULN_MODIFIED"]="Vuln actualizada";
$MESSAGES["ALERT_FIELD_TIME_RESOLUTION"]="Tiempo de resoluci&oacute;n";

$MESSAGES["ALERT_SELECT_VIEW_TITLE"]="Mostrar";
$MESSAGES["ALERT_SELECT_VIEW_OPENED"]="Solo las alertas abiertas o pendientes";
$MESSAGES["ALERT_SELECT_VIEW_ALL"]="Todas las alertas";

$MESSAGES["ALERT_NUM_ALERTS_FOUND"]="Se han encontrado %d casos de productos instalados en alg&uacute;n equipo afectados por vulnerabilidades";
$MESSAGES["ALERT_NUM_ALERTS_PROCESSED"]="Se han procesado %d alertas";
$MESSAGES["ALERT_NUM_ALERTS_SENT"]="Se han enviado %d notificaciones a los administradores de los equipos afectados";

$MESSAGES["ALERT_STATUS_NOT_SENT"]="No enviada";
$MESSAGES["ALERT_STATUS_VALIDATED"]="Validada";
$MESSAGES["ALERT_STATUS_OPEN"]="Abierta";
$MESSAGES["ALERT_STATUS_CLOSE"]="Cerrada";
$MESSAGES["ALERT_STATUS_PENDING"]="Pendiente";
$MESSAGES["ALERT_STATUS_DISCARDED"]="Descartada";
$MESSAGES["ALERT_STATUS_DUDE"]="Dudosa";

$MESSAGES["ALERTS_DONT_SHOW_CLOSED"]="No mostrar las cerradas o descartadas.";
$MESSAGES["ALERTS_SHOW_ALL"]="Mostrar todas las alertas (cerradas y descartadas).";

$MESSAGES["ALERTS_CHANGE_STATUS"]="Cambiar el estado de las alertas seleccionadas";

// NOTIFICATIONS messages
// (mail body)
$MESSAGES["NOTIFICATION_TITLE"]="Notificaci&oacute;n de alertas";
$MESSAGES["NOTIFICATION_SUBJECT"]="SIGVI: Alerta de vulnerabilidad de nivel %d en el servidor %s, producto %s";
$MESSAGES["NOTIFICATION_ALERT_TITLE"]="Se ha encontrado una vulnerabilidad de nivel %d en el producto %s instalado en el servidor %s";
$MESSAGES["NOTIFICATION_UPDATE_SUBJECT"]="SIGVI: Actualizaci&oacute;n de la vulnerabilidad asociada a la alerta de nivel %d en el servidor %s, producto %s";
$MESSAGES["NOTIFICATION_VULN_ID"]="Identificador de vulnerabilidad";
$MESSAGES["NOTIFICATION_SEVERITY"]="Criticidad";
$MESSAGES["NOTIFICATION_DESCRIPTION"]="Descripci&oacute;n";
$MESSAGES["NOTIFICATION_SOFWARE"]="Software afectado";
$MESSAGES["NOTIFICATION_LINK"]="Enlaces de inter&eacute;s";
$MESSAGES["NOTIFICATION_OTHER_REFERENCES"]="Otras referencias";
$MESSAGES["NOTIFICATION_SOLUTION"]="Soluciones";
$MESSAGES["NOTIFICATION_CARACTERISTICS"]="Caracter&iacute;sticas de la vulnerabilidad";

$MESSAGES["UNIQ_NOTIFICATION_SUBJECT"]="SIGVI: Alertas de vulnerabilidades en sus servidores";
$MESSAGES["UNIQ_NOTIFICATION_ALERT_TITLE"]="Se han encontrado %d vulnerabilidades en productos instalados en sus servidores.";
$MESSAGES["UNIQ_NOTIFICATION_INFO"]="Puede acceder a la <a href='" . HOME . "'>consola de gesti&oacute;n</a> del SIGVI para revisar el estado de las alertas y obtener m&aacute;s informaci&oacute;n de las vulnerabilidades.";
$MESSAGES["UNIQ_NOTIFICATION_SERVER_NAME"]=$MESSAGES["SERVER"];
$MESSAGES["UNIQ_NOTIFICATION_PRODUCT_NAME"]=$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"];
$MESSAGES["UNIQ_NOTIFICATION_VULN_ID"]=$MESSAGES["NOTIFICATION_VULN_ID"];
$MESSAGES["UNIQ_NOTIFICATION_FAS"]=$MESSAGES["ALERT_FIELD_SEVERITY"];
$MESSAGES["UNIQ_NOTIFICATION_NEW"]="Nueva vulnerabilidad";
$MESSAGES["UNIQ_NOTIFICATION_UPDATED"]="Vulnerabilidad actualizada";

// Cron
$MESSAGES["CRON_VULN_LOAD_SUBJECT"]="SIGVI: Proceso de carga autom&aacute;tica de vulnerabilidades";
$MESSAGES["CRON_VULN_LOAD_BODY"]="Resultados de la carga de la fuente %s: %s vulnerabilidades encontradas, %s agregadas a la base de datos.";
$MESSAGES["CRON_VULN_CHECK_SUBJECT"]= "SIGVI: Proceso de comprobaci&oacute;n autom&aacute;tico del estado de las vulnerabilidades en los servidores";

// Discover
$MESSAGES["DISCOVER_TITLE"]="B&uacute;squeda autom&aacute;tica de servicios";

// Filter
$MESSAGES["FILTER_TITLE"]="Filtros de notificaciones";
$MESSAGES["FILTER_MORE_INFO"]="Para m&aacute;s informaci&oacute;n pinchar el icono de informaci&oacute;n de arriba ('i').";
$MESSAGES["FILTER_FIELD_NAME"]="Filtro";
$MESSAGES["FILTER_FIELD_DESCRIPTION"]="Descripci&oacute;n";
$MESSAGES["FILTER_NOTIFICATION"]="Filtro de notificaciones";
$MESSAGES["FILTER_CHECK"]="Filtro de vulnerabilidades";
$MESSAGES["FILTER_TYPE_FIELD_PASS_AND"]="Pasar si cumple todos";
$MESSAGES["FILTER_TYPE_FIELD_PASS_OR"]="Pasar si cumple alguno";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_AND"]="Filtrar si cumple todos";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_OR"]="Filtrar si cumple alguno";

// REPOSITORY Administration
$MESSAGES["REPOSITORY_MAIN_TITLE"]="Repositorios";
$MESSAGES["REPOSITORY_MGM_TITLE"]="Administraci&oacute;n de los repositorios";
$MESSAGES["REPOSITORY_FIELD_NAME"]="Nombre";
$MESSAGES["REPOSITORY_FIELD_DBNAME"]="Nombre BD";
$MESSAGES["REPOSITORY_FIELD_GROUP"]="Grupo";
$MESSAGES["REPOSITORY_FIELD_PLUGIN"]="Plugin";
$MESSAGES["REPOSITORY_FIELD_PARAMETERS"]="Par&aacute;metros";
$MESSAGES["REPOSITORY_FIELD_DESCRIPTION"]="Descripci&oacute;n";
$MESSAGES["REPOSITORY_FIELD_USE_IT"]="&iquest;Utilizar?";
$MESSAGES["REPOSITORY_FIELD_RO_USER"]="Usuario de acceso remoto (s&oacute;lo lectura)";
$MESSAGES["REPOSITORY_FIELD_RO_PASS"]="Clave de acceso";
$MESSAGES["REPOSITORY_FIELD_HOST"]="Servidor";
$MESSAGES["REPOSITORY_FIELD_TYPE"]="Tipo de servidor";

// Inventory menu
$MESSAGES["INVENTORY"]="Inventario";

// MITYC
$MESSAGES["MITYC"]= "El proyecto SIGVI ha sido cofinanciado por el Ministerio de Industria," .
					"Turismo y Comercio, dentro del Plan Nacional de Investigaci&oacute;n" .
					"Cient&iacute;fica,Desarrollo e Innovaci&oacute;n Tecnol&oacute;gica 2008-2011.<br>" .
					"[Referencia del projecto: TSI-020400-2008-5]";
// FAS
$MESSAGES["FAS_MGM_TITLE"]= "Gesti&oacute;n de las funciones FAS (Final Absolute Severity)";
$MESSAGES["FAS_INCORRECT_FAS"]= "La FAS no es correcta";
$MESSAGES["FAS_THERE_IS_ACTIVE_FAS"]= "Ya existe una FAS activa";
$MESSAGES["FAS_USE_DEFAULT_FAS"]= "No tienes ninguna FAS activa en tu grupo, se usar&aacute la gen&eacute;rica";
$MESSAGES["FAS_FIELD_NAME"]= "Nombre";
$MESSAGES["FAS_FIELD_GROUP"]="Grupo";
$MESSAGES["FAS_FIELD_ENABLE"]= "Activo";
$MESSAGES["FAS_VAR_NOT_VALID"]= "Hay una variable en la funci&oacute;n que no existe: ";

// RSS
$MESSAGES["RSS_ADMIN"]= "Administrar fuentes RSS";
$MESSAGES["RSS_LAST_NEWS"]= "&Uacute;ltimas noticias";
$MESSAGES["RSS_SEE_ALL"]= "Ver todas";
$MESSAGES["RSS_VULN_NEWS"]= "&Uacute;ltimas vulnerabilidades publicadas";
$MESSAGES["RSS_SOURCES"]= "Fuentes RSS";

$MESSAGES["RSS_SOURCES"]= "Fuentes RSS";
$MESSAGES["RSS_MGM_TITLE"]= "Gesti&oacute;n de fuentes RSS";
$MESSAGES["RSS_FIELD_NAME"]= "Nombre";
$MESSAGES["RSS_FIELD_SOURCE"]="Fuente (URL)";
$MESSAGES["RSS_FIELD_ENABLED"]="Activada?";

$MESSAGES["RSS_CANT_FIND_ENABLED"]="No se encontr&oacute; ninguna fuente RSS activa.";

// CPE
$MESSAGES["PRODUCT_DICTIONARIES_MGM_TITLE"]= "Gesti&oacute;n de los productos [CPE]";
$MESSAGES["PRODUCT_DICTIONARIES"]="Diccionarios de productos";
$MESSAGES["CPE_FIELD_NAME"]="Nombre";
$MESSAGES["CPE_FIELD_PART"]="Parte";
$MESSAGES["CPE_FIELD_VENDOR"]="Fabricante";
$MESSAGES["CPE_FIELD_PRODUCT"]="Producto";
$MESSAGES["CPE_FIELD_VERSION"]="Versi&oacute;n";
$MESSAGES["CPE_FIELD_TITLE"]="T&iacute;tulo";
$MESSAGES["CPE_FIELD_MODIFICATION_DATE"]="Fecha de modificaci&oacute;n";
$MESSAGES["CPE_FIELD_STATUS"]="Estado";
$MESSAGES["CPE_FIELD_NVD_ID"]="NVD Id";
$MESSAGES["CPE_FIELD_PART_APPLICATION"]="Aplicaci&oacute;n";
$MESSAGES["CPE_FIELD_PART_HARDWARE"]="Hardware";
$MESSAGES["CPE_FIELD_PART_OS"]="Sistema Operativo";
?>
