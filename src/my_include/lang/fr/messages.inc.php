<?php
/**
 * @author Gregory Depaix
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage lang
 *
 * French version of application messages
 *
 */

global $MESSAGES;

  /////////////////////////////////////////////////////////////////////////////
 // APPLICATION MESSAGES                                                    //
/////////////////////////////////////////////////////////////////////////////

$MESSAGES["APP_ALIAS"]="SIGVI";
$MESSAGES["APP_NAME"]="Syst&egrave;me de gestion des vuln&eacute;rabilit&eacute;s";
$MESSAGES["REGISTER_SUCCESS"]=
	"<p><b>Bienvenue %s.</b></p>" .
	"<p>Vous avez &eacute;t&eacute; enregistr&eacute; avec succ&egrave;s.</p>" .
	"<p>Pour utiliser SIGVI, rendez-vous maintenant sur la page de connexion et suivez les &eacute;tapes suivantes :</p>" .
	"<p> - Tout d'abord, v&eacute;rifiez vos informations personnelles. Assurez-vous que votre adresse de courriel est correcte. Sinon, vous ne serez pas notifi&eacute;s des alertes de vuln&eacute;rabilit&eacute;s.</p>" .
	"<p> - Vous &ecirc;tes gestionnaire de groupe. Ainsi vous pouvez, si vous d&eacute;sirez, ajouter de nouveaux utilisateurs dans votre groupe administrateurs.</p>" .
	"<p> - Ajoutez vos serveurs, et renseignez les produits qui sont install&eacute;s (par exemple les services les plus importants)</p>" .
	"<p> - Toutes les nuits, SIGVI t&eacute;l&eacute;chargera la liste des nouvelles vuln&eacute;rabilit&eacute;s depuis ses sources et les recherchera sur les produits que vous avez renseign&eacute;s. Chaque occurence positive de cette recherche g&eacute;n&eacute;rera une notification qui vous sera envoy&eacute;e.</p>" .
	"<br>" .
	"<p> - Et maintenant, &agrave; vous de jouer... <a href='" . SERVER_URL . HOME . "/index.php'>login page</a>.</p>";

$MESSAGES["ABOUT_APP"]=
	"<p>SIGVI is developed by UPCnet S.L.</p>";						// TO TRANSLATE

// MAIN PAGE
$MESSAGES["SERVER_VULN_STATUS"]="Etat de vuln&eacute;rabilit&eacute; des serveurs";
$MESSAGES["TO-DO"]="A faire";
$MESSAGES["INDEX"]="Index";
$MESSAGES["SERVERS"]="Serveurs";
$MESSAGES["SERVER"]="Serveur";
$MESSAGES["SERVICES"]="Produits";
$MESSAGES["SERVERS_AND_SERVICES"]="Serveurs et Produits";
$MESSAGES["PRODUCTS"]="Produits";
$MESSAGES["VULNERABILITIES"]="Vuln&eacute;rabilit&eacute;s";
$MESSAGES["SERVER_PRODUCTS"]="Produits install&eacute;s sur les serveurs";
$MESSAGES["SOURCES_ADMIN"]="Gestion des sources";
$MESSAGES["SOURCES"]="Sources";
$MESSAGES["VULN_SOURCES_ADMIN"]="Gestion des sources des vuln&eacute;rabilit&eacute;s";
$MESSAGES["VULN_SOURCES"]="Sources des vuln&eacute;rabilit&eacute;s";
$MESSAGES["VULN_SOURCES_TESTING"]="Test des sources";
$MESSAGES["VULN_SOURCES_LOADING"]="Chargement des vuln&eacute;rabilit&eacute;s";
$MESSAGES["VULN_SOURCES_LOAD"]="Chargement manuel des sources";
$MESSAGES["ALERTS"]="Alertes";
$MESSAGES["ALERT_VALIDATION_SHORT"]="Valider les alertes";
$MESSAGES["ALERT_VALIDATION"]="Valider les alertes avec doutes ?!";
$MESSAGES["ALERT_ASSIGNED_TO"]="attribu&eacute; &agrave;";
$MESSAGES["ALERT_ASSIGNED_TO_UNSET"]="les alertes associ&eacute;es &agrave; cet utilisateur ont &eacute;t&eacute; lib&eacute;r&eacute;s";
$MESSAGES["ALERT_ASSIGNED_TO_UNSET"]="Las alertas asociadas al usuario han sido liberadas";
$MESSAGES["ALERTS_TO_VALIDATE"]="Il y a  %d alertes &agrave; valider";
$MESSAGES["ALERTS_PENDING"]="Il y a %d alertes actives";
$MESSAGES["CHECK_SERVER_VULNERABILITIES"]="VÔøΩifier manuellement l'&eacute;tat de vuln&eacute;rabilit&eacute; des serveurs";
$MESSAGES["SEE_SERVER_VULNERABILITIES"]="Alertes des serveurs";
$MESSAGES["SERVER_STATUS"]="Etat des serveurs";
$MESSAGES["NOTIFICATION_METHODS"]="M&eacute;thodes de notification";
$MESSAGES["SHOW_VULNERABILITY_EVOLUTION"]="Evolution des vuln&eacute;rabilit&eacute;s";
$MESSAGES["STATISTICS"]="Statistiques";

$MESSAGES["HIGH_RISK"]="Risque &eacute;lev&eacute;";
$MESSAGES["MED_RISK"]="Risque important";
$MESSAGES["LOW_RISK"]="Risque bas";

$MESSAGES["SERVER_PRODUCT_MGM"]="G&acute;rer les produits install&eacute;s sur les serveurs";

$MESSAGES["VULN"]="Vuln&eacute;rabilit&eacute;s";
$MESSAGES["LOAD_VULN"]="Charger la liste des vuln&eacute;rabilit&eacute;s dans la BDD";
$MESSAGES["LOAD_VULNERABILITIES_CONFIRM"]="Voulez-vous continuer  ?";
$MESSAGES["LOAD_PROD"]="Charger la liste des produits dans la BDD";
$MESSAGES["CHECK_STATUS"]="V&eacute;rifier l'&eacute;tat";
$MESSAGES["CHECK_SERVER_STATUS"]="V&eacute;rifier l'&eacute;tat de vuln&eacute;rabilit&eacute; des serveurs";
$MESSAGES["SEARCH_VULNERABILITIES_CONFIRM"]="Voulez-vous continuer  ?";

// SKILL LEVELS
$MESSAGES["SKILL_0"]="Adm. SIGVI";
$MESSAGES["SKILL_3"]="Adm. Groupes";
$MESSAGES["SKILL_5"]="Adm. Hote";

// SERVER management messages
$MESSAGES["SERVER_MGM_TITLE"]="Gestion des serveurs";
$MESSAGES["SERVER_MGM_STILL_HAS_PRODUCTS"]="Il y a des produits associ&eacute;s &agrave; ce serveur.Supression impossible";
$MESSAGES["SERVER_MGM_CANT_DELETE"]="D&eacute;sol&eacute;, l'administrateur de serveurs ne peut pas supprimer des serveurs";
$MESSAGES["SERVER_MGM_CANT_UPDATE"]="D&eacute;sol&eacute;, l'administrateur de serveurs ne peut pas modifier des serveurs.";

$MESSAGES["SERVER_FIELD_NAME"]="Nom";
$MESSAGES["SERVER_FIELD_VENDOR"]="Manufacturier";
$MESSAGES["SERVER_FIELD_MODEL"]="Mod&egrave;le";
$MESSAGES["SERVER_FIELD_CPU"]="CPU";
$MESSAGES["SERVER_FIELD_RAM"]="RAM";
$MESSAGES["SERVER_FIELD_DISC"]="Disques";
$MESSAGES["SERVER_FIELD_SERIAL_NUMBER"]="Num&eacute;ro de s&eacute;rie";
$MESSAGES["SERVER_FIELD_OS"]="Syst&egrave;me d'exploitation";
$MESSAGES["SERVER_FIELD_GROUP"]="Groupe";
$MESSAGES["SERVER_FIELD_LOCATION"]="Lieu";
$MESSAGES["SERVER_FIELD_IP"]="IP";
$MESSAGES["SERVER_FIELD_ZONE"]="Zone";
$MESSAGES["SERVER_FIELD_OBSERVATIONS"]="Remarques";

$MESSAGES["SERVER_FIELD_NAME"]="Nom";

// PRODUCTS management messages
$MESSAGES["PRODUCT_MGM_TITLE"]="Gestion des produits";
$MESSAGES["PRODUCT_MGM_STILL_HAS_SERVERS"]="Ce produit est associ&eacute; &agrave; au moins un serveur et ne peut pas &ecirc;tre suuprim&eacute;";

$MESSAGES["PRODUCT_FIELD_ID"]="Identifiant du produit";
$MESSAGES["PRODUCT_FIELD_VENDOR"]="Editeur";
$MESSAGES["PRODUCT_FIELD_NAME"]="Nom du produit";
$MESSAGES["PRODUCT_ID_FIELD_NAME"]="Identifiant";
$MESSAGES["PRODUCT_FIELD_FULL"]="Complet";
$MESSAGES["PRODUCT_FIELD_VERSION"]="Version";

// PRODUCTS updated --> alerts closed
$MESSAGES["PRODUCT_UPDATED_ALERT_CLOSED"]="Le logiciel a &eacute;t&eacute; mis &agrave; jour. Ainsi les alertes associ&eacute;es &agrave; l'ancienne version du logiciel ont &eacute;t&eacute; ferm&eacute;es.";
$MESSAGES["PRODUCT_DELETED_ALERT_CLOSED"]="Le logiciel a &eacute;t&eacute; supprim&eacute;. Ainsi les alertes associ&eacute;es &agrave; ce logiciel ont &eacute;t&eacute; ferm&eacute;es.";

// SEARCH PRODUCTS messages
$MESSAGES["SEARCH_PRODUCT_TITLE"]="Recherche de produit";

// SERVER_PRODUCTS management messages

$MESSAGES["SERVER_PRODUCT_MGM_TITLE"]="Gestion des produits install&eacute;s sur les serveurs";

$MESSAGES["SERVER_PRODUCT_FIELD_SERVER_NAME"]="Nom du serveur";
$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"]="Produit";
$MESSAGES["SERVER_PRODUCTS_FIELD_PORTS"]="Ports";
$MESSAGES["SERVER_PRODUCTS_FIELD_FILTERED"]="Est-ce que le service est filtr&eacute; ? (n'est pas publique)";
$MESSAGES["SERVER_PRODUCTS_FIELD_CRITIC"]="Est-ce que le service est critique ?";
$MESSAGES["SERVER_PRODUCTS_FIELD_PROTOCOL"]="Transmission Protocol (TCP,UDP,...)";


// SOURCE management messages
$MESSAGES["SOURCE_MGM_TITLE"]="Gestion des sources de vuln&eacute;rabilit&eacute;s";

$MESSAGES["SOURCE_FIELD_NAME"]="Alias";
$MESSAGES["SOURCE_FIELD_DESCRIPTION"]="Description";
$MESSAGES["SOURCE_FIELD_HOME_URL"]="SURL du site";
$MESSAGES["SOURCE_FIELD_FILE_URL"]="URL du fichier";
$MESSAGES["SOURCE_FIELD_USE_IT"]="Utiliser ?";
$MESSAGES["SOURCE_FIELD_PARSER_LOCATION"]="Parser";
$MESSAGES["SOURCE_FIELD_PARAMETERS"]="Param&egrave;tres";

$MESSAGES["SOURCES_FIELD_ALIAS"]="Source &agrave; charger";
$MESSAGES["SOURCES_TEST_FIELD_ALIAS"]="Source &agrave; tester";

// NOTIFICATION METHODS management messages
$MESSAGES["NOTIF_METHOD_MGM_TITLE"]="M&eacute;thodes de notification des alertes";

$MESSAGES["NOTIF_METHOD_FIELD_NAME"]="Alias";
$MESSAGES["NOTIF_METHOD_FIELD_DESCRIPTION"]="Description";
$MESSAGES["NOTIF_METHOD_FIELD_USE_IT"]="Utiliser ?";
$MESSAGES["NOTIF_METHOD_FIELD_METHOD_LOCATION"]="Module";

// VULNERABILITIES management messages
$MESSAGES["VULN_MGM_TITLE"]="Gestion des vuln&eacute;rabilit&eacute;s";
$MESSAGES["VULN_COUNTER"]="Compteur de vuln&eacute;rabilit&eacute;s";

$MESSAGES["VULN_FIELD_VULN_ID"]="CVE/CAN";
$MESSAGES["VULN_FIELD_PUBLISH_DATE"]="Date de publication";
$MESSAGES["VULN_FIELD_MODIFY_DATE"]="Date de r&eacute;vision";
$MESSAGES["VULN_FIELD_DESCRIPTION"]="Description";
$MESSAGES["VULN_FIELD_SEVERITY"]="S&eacute;v&eacute;rit&eacute;";
$MESSAGES["VULN_FIELD_AR_LAUNCH_REMOTELY"]="Conditions d'acc&egrave;s<br>Exploitation &agrave; distance possible ?";
$MESSAGES["VULN_FIELD_AR_LAUNCH_LOCALLY"]="Conditions d'acc&egrave;s<br>Acc&egrave;s local requis ?";
$MESSAGES["VULN_FIELD_SECURITY_PROTECTION"]="Cons&eacute;quences<brObtention de protection";
$MESSAGES["VULN_FIELD_OBTAIN_ALL_PRIV"]="Cons&eacute;quences<br>Obtention de certains privil&egrave;ges";
$MESSAGES["VULN_FIELD_OBTAIN_SOME_PRIV"]="Cons&eacute;quences<br>Obtention de tous les privil&egrave;ges";
$MESSAGES["VULN_FIELD_CONFIDENTIALITY"]="Cons&eacute;quences<br>Perte de confidentialit&eacute;";
$MESSAGES["VULN_FIELD_INTEGRITY"]="Cons&eacute;quences<br>Perte d'int&eacute;grit&eacute;";
$MESSAGES["VULN_FIELD_AVAILABILITY"]="Cons&eacute;quences<br>Perte de disponibilit&eacute;";
$MESSAGES["VULN_FIELD_INPUT_VALIDATION_ERROR"]="Type<br>Erreur de validation de donn&eacute;es";
$MESSAGES["VULN_FIELD_BOUNDARY_CONDITION_ERROR"]="Type<br>Erreur de condition";
$MESSAGES["VULN_FIELD_BUFFER_OVERFLOW"]="Type<br>D&eacute;bordement de m&eacute;moire";
$MESSAGES["VULN_FIELD_ACCESS_VALIDATION_ERROR"]="Type<br>Erreur de validation d'acc&egrave;s";
$MESSAGES["VULN_FIELD_EXCEPTIONAL_CONDITION_ERROR"]="Type<br>Erreur de condition";
$MESSAGES["VULN_FIELD_ENVIRONMENT_ERROR"]="Type<br>Erreur d'environement";
$MESSAGES["VULN_FIELD_CONFIGURATION_ERROR"]="Type<br>Erreur de configuration";
$MESSAGES["VULN_FIELD_RACE_CONDITION"]="Type<br>'Race condition'";
$MESSAGES["VULN_FIELD_OTHER_VULNERABILITY_TYPE"]="Type<br>Autre";
$MESSAGES["VULN_FIELD_VULN_SOFTWARE"]="Logiciel vuln&eacute;rable";
$MESSAGES["VULN_FIELD_LINKS"]="Liens";
$MESSAGES["VULN_FIELD_OTHER_REFERENCES"]="Autres r&eacute;f&eacute;rences";
$MESSAGES["VULN_FIELD_OTHER"]="...";
$MESSAGES["VULN_FIELD_SOLUTION"]="Solutions";
$MESSAGES["VULN_FIELD_SOURCE"]="Source";

$MESSAGES["VULN_EXPLOID_REMOTELLY"]="Exploitation &agrave; distance possible ?";
$MESSAGES["VULN_EXPLOID_ONLY_LOCALLY"]="Acc&egrave;s local requis ?";

// SEARCH VULNERABILITY messages
$MESSAGES["SEARCH_VULNERABILITY_TITLE"]="Recherche de vuln&eacute;rabilit&eacute;";

// SEARCH ALERT messages
$MESSAGES["SEARCH_ALERT_TITLE"]="Recherche d'alertes";

// ALERTS management messages
$MESSAGES["ALERT_MGM_TITLE"]="Gestion des alertes";
$MESSAGES["ALERT_MGM_NOTIFICATION_METHOD"]="M&eacute;thode d'authentification";

$MESSAGES["ALERT_COUNTER"]="Compteur d'alertes";

$MESSAGES["ALERT_SERVER_FIELD_NAME"]="Serveur";
$MESSAGES["ALERT_PRODUCT_FIELD_NAME"]="Produit incrimin&eacute;";
$MESSAGES["ALERT_VULN_FIELD_VULN_ID"]="Vuln&eacute;rabilit&eacute;";
$MESSAGES["ALERT_FIELD_DATE"]="Date de cr&eacute;ation";
$MESSAGES["ALERT_FIELD_STATUS"]="Etat"; // [1=open|2=pending|3=solved|4=closed]
$MESSAGES["ALERT_FIELD_SEVERITY"]="FAS (Final Alert Severity)"; // [0=not critical, ..., 9=very critical]
$MESSAGES["ALERT_FIELD_OBSERVATIONS"]="Remarques";
$MESSAGES["ALERT_FIELD_VULN_MODIFIED"]="Vuln&eacute;rabilit&eacute;s mises &agrave; jour";
$MESSAGES["ALERT_FIELD_TIME_RESOLUTION"]="Temps de la r&eacute;solution";

$MESSAGES["ALERT_SELECT_VIEW_TITLE"]="Montrer";
$MESSAGES["ALERT_SELECT_VIEW_OPENED"]="Les alertes qui sont ouverts et en attente";
$MESSAGES["ALERT_SELECT_VIEW_ALL"]="Toutes les alertes";

$MESSAGES["ALERT_NUM_ALERTS_FOUND"]="%d vuln&eacute;rabilit&eacute;s concordent avec des produits vuln&eacute;rables install&eacute;s sur les serveurs";
$MESSAGES["ALERT_NUM_ALERTS_PROCESSED"]="%d alertes  trait&eacutes";
$MESSAGES["ALERT_NUM_ALERTS_SENT"]="%d notifications ont &eacute;t&eacute; envoy&eacute;es aux administrateurs des serveurs incrimin&Eacute;s";

$MESSAGES["ALERT_STATUS_NOT_SENT"]="Non envoy&eacute;";
$MESSAGES["ALERT_STATUS_VALIDATED"]="Valid&eacute;";
$MESSAGES["ALERT_STATUS_OPEN"]="Ouvert";
$MESSAGES["ALERT_STATUS_CLOSE"]="Ferm&eacute;";
$MESSAGES["ALERT_STATUS_PENDING"]="En attente";
$MESSAGES["ALERT_STATUS_DISCARDED"]="Annul&eacute;";
$MESSAGES["ALERT_STATUS_DUDE"]="Doute";

$MESSAGES["ALERTS_DONT_SHOW_CLOSED"]="Ne pas montrer les &eacute;tats ferm&eacutee;s et annul&eacute;es.";
$MESSAGES["ALERTS_SHOW_ALL"]="Montrer toutes les alertes (ferm&eacute;es et annul&eacute;es).";

$MESSAGES["ALERTS_CHANGE_STATUS"]="Changer l'&eacute;tat pour les lignes s&eacute;l&eacute;ctionn&eacute;es";

// NOTIFICATIONS messages
// (mail body)
$MESSAGES["NOTIFICATION_TITLE"]="Notification des alertes";
$MESSAGES["NOTIFICATION_SUBJECT"]="SIGVI : Niveau %d d'alertes de vuln&eacute;rabilit&eacute;s  pour le serveur %s, produit %s";
$MESSAGES["NOTIFICATION_ALERT_TITLE"]="Un niveau %d d'alertes de vuln&eacute;rabilit&eacute;s des produits %s a &eacute;t&eacute; d&eacute;tect&eacute; sur le serveur %s";
$MESSAGES["NOTIFICATION_UPDATE_SUBJECT"]="SIGVI : La vuln&eacute;rabilit&eacute; associ&eacute;e avec le niveau d'alerte %d pour le serveur %s, le produit %s, a &eacute;t&eacute; mis &agrave; jour";
$MESSAGES["NOTIFICATION_VULN_ID"]="Vulnerability identifier";
$MESSAGES["NOTIFICATION_SEVERITY"]="S&eacute;v&eacute;rit&eacute;";
$MESSAGES["NOTIFICATION_DESCRIPTION"]="Description";
$MESSAGES["NOTIFICATION_SOFWARE"]="Logiciel vuln&eacute;rable";
$MESSAGES["NOTIFICATION_LINK"]="Liens";
$MESSAGES["NOTIFICATION_OTHER_REFERENCES"]="Autres r&eacute;f&eacute;rences";
$MESSAGES["NOTIFICATION_SOLUTION"]="Solution";
$MESSAGES["NOTIFICATION_CARACTERISTICS"]="Caract&eacute;ristiques des vulne&eacute;abilit&eacute;s";

$MESSAGES["UNIQ_NOTIFICATION_SUBJECT"]="SIGVI: Alertes de vuln&eacute;rabilit&eacute;s sur leurs serveurs";
$MESSAGES["UNIQ_NOTIFICATION_ALERT_TITLE"]="Trouvé %d vuln&eacute;rabilit&eacute;s sur les produits install&eacute;s sur vos serveurs.";
$MESSAGES["UNIQ_NOTIFICATION_INFO"]="Acc&egrave;s &agrave; la <a href='" . HOME . "'>consule du gestion du SIGVI</a> pour examiner l'&eacute;tat des alertes et d'obtenir plus d'informations sur les vuln&eacute;rabilit&eacute;s.";
$MESSAGES["UNIQ_NOTIFICATION_SERVER_NAME"]=$MESSAGES["SERVER"];
$MESSAGES["UNIQ_NOTIFICATION_PRODUCT_NAME"]=$MESSAGES["SERVER_PRODUCT_FIELD_PRODUCT_NAME"];
$MESSAGES["UNIQ_NOTIFICATION_VULN_ID"]=$MESSAGES["NOTIFICATION_VULN_ID"];
$MESSAGES["UNIQ_NOTIFICATION_FAS"]=$MESSAGES["ALERT_FIELD_SEVERITY"];
$MESSAGES["UNIQ_NOTIFICATION_NEW"]="Nouvelle vuln&eacute;rabilit&eacute;";
$MESSAGES["UNIQ_NOTIFICATION_UPDATED"]="mise &agrave; jour la vuln&eacute;rabilit&eacute;";

// Cron
$MESSAGES["CRON_VULN_LOAD_SUBJECT"]="SIGVI : process de chargement des vuln&eacute;rabilit&eacute;s";
$MESSAGES["CRON_VULN_LOAD_BODY"]="Vuln&eacute;rabilit&eacute;s charg&eacute; depuis la source %s : %s vuln&eacute;rabilit&eacute;s ont &eacute;t&eacute; trouv&eacute;es, %s d'entre elles ont &eacute;t&eacute; charg&eacute;es dans la base de donn&eacute;es.";
$MESSAGES["CRON_VULN_CHECK_SUBJECT"]= "SIGVI : Process de v&eacute;rification des vuln&eacute;rabilit&eacute;s";

// Discover
$MESSAGES["DISCOVER_TITLE"]="D&eacute;couverte automatique d'applications.";

// Filter
$MESSAGES["FILTER_TITLE"]="Filtre de notifications";
$MESSAGES["FILTER_MORE_INFO"]="Pour plus d'informations et pour une l&eacute;gende, cliquez sur l'ic&ocirc;ne d'information en haut de cette page.";
$MESSAGES["FILTER_FIELD_NAME"]="Filtre";
$MESSAGES["FILTER_FIELD_DESCRIPTION"]="Description";
$MESSAGES["FILTER_NOTIFICATION"]="Filtre de notifications";
$MESSAGES["FILTER_CHECK"]="V&eacute;rifiez les filtres";
$MESSAGES["FILTER_TYPE_FIELD_PASS_AND"]="Passer si tous sont &eacute;gaux";
$MESSAGES["FILTER_TYPE_FIELD_PASS_OR"]="Passer si au moins un est &eacute;gal";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_AND"]="Filtrer si tous sont &eacute;gaux";
$MESSAGES["FILTER_TYPE_FIELD_FILTER_OR"]="Filtrer si au moins un est &eacute;gal";

// REPOSITORY Administration
$MESSAGES["REPOSITORY_MAIN_TITLE"]="D&eacute;p&ocirc;ts";
$MESSAGES["REPOSITORY_MGM_TITLE"]="Administration des d&eacute;p&ocirc;ts";
$MESSAGES["REPOSITORY_FIELD_NAME"]="Nom";
$MESSAGES["REPOSITORY_FIELD_DBNAME"]="Nom de DB";
$MESSAGES["REPOSITORY_FIELD_GROUP"]="Groupe";
$MESSAGES["REPOSITORY_FIELD_PLUGIN"]="Plugin";
$MESSAGES["REPOSITORY_FIELD_PARAMETERS"]="Param&egrave;tres";
$MESSAGES["REPOSITORY_FIELD_DESCRIPTION"]="Description";
$MESSAGES["REPOSITORY_FIELD_USE_IT"]="L'utiliser ?";
$MESSAGES["REPOSITORY_FIELD_RO_USER"]="Utilisateur distant (lecture seule)";
$MESSAGES["REPOSITORY_FIELD_RO_PASS"]="Mot de passe";
$MESSAGES["REPOSITORY_FIELD_HOST"]="Serveur";
$MESSAGES["REPOSITORY_FIELD_TYPE"]="Type";

// Inventory menu
$MESSAGES["INVENTORY"]="Inventaire";

// MITYC																// TO TRANSLATE
$MESSAGES["MITYC"]= "The SIGVI project has been co-financed by the Spanish Ministry of" .
					"Industry, Tourism and Commerce within the National Plan for Scientific" .
					"Research, Development and Technological Innovation 2008-2011.<br>" .
					"[Project reference: TSI-020400-2008-5]";
// FAS
$MESSAGES["FAS_MGM_TITLE"]= "FAS functions management (Final Absolute Severity)";		// TO TRANSLATE
$MESSAGES["FAS_INCORRECT_FAS"]= "FAS incorrect";
$MESSAGES["FAS_THERE_IS_ACTIVE_FAS"]= "Ya existe una FAS activa";			//TO TRANSLATE
$MESSAGES["FAS_USE_DEFAULT_FAS"]= "No tienes ninguna FAS activa en tu grupo, se usar&acute la gen&ecuterica";	//TO TRANSLATE
$MESSAGES["FAS_FIELD_NAME"]= "Nom";
$MESSAGES["FAS_FIELD_GROUP"]= "Groupe";
$MESSAGES["FAS_FIELD_ENABLE"]= "Active";
$MESSAGES["FAS_VAR_NOT_VALID"]= "Hay una variable en la funci&oacute;n que no existe: ";	//TO TRANSLATE

// RSS
$MESSAGES["RSS_ADMIN"]= "Admin RSS Sources";								// TO TRANSLATE
$MESSAGES["RSS_LAST_NEWS"]= "Last news";									// TO TRANSLATE
$MESSAGES["RSS_SEE_ALL"]= "See all";										// TO TRANSLATE
$MESSAGES["RSS_VULN_NEWS"]= "Last vulnerability news";						// TO TRANSLATE
$MESSAGES["RSS_SOURCES"]= "RSS Sources";									// TO TRANSLATE

$MESSAGES["RSS_SOURCES"]= "RSS Sources management";							// TO TRANSLATE
$MESSAGES["RSS_MGM_TITLE"]= "RSS Sources management";						// TO TRANSLATE
$MESSAGES["RSS_FIELD_NAME"]= "Nom";
$MESSAGES["RSS_FIELD_SOURCE"]="Source (URL)";								// TO TRANSLATE
$MESSAGES["RSS_FIELD_ENABLED"]="Enabled?";									// TO TRANSLATE

$MESSAGES["RSS_CANT_FIND_ENABLED"]="Can't find any RSS source enabled.";	// TO TRANSLATE

// CPE
$MESSAGES["PRODUCT_DICTIONARIES_MGM_TITLE"]= "Product management [CPE]";	// TO TRANSLATE
$MESSAGES["PRODUCT_DICTIONARIES"]="Products dictionaries";					// TO TRANSLATE
$MESSAGES["CPE_FIELD_NAME"]="Nom";
$MESSAGES["CPE_FIELD_PART"]="Part";											// TO TRANSLATE
$MESSAGES["CPE_FIELD_VENDOR"]="Vendor";										// TO TRANSLATE
$MESSAGES["CPE_FIELD_PRODUCT"]="Product";									// TO TRANSLATE
$MESSAGES["CPE_FIELD_VERSION"]="Version";									// TO TRANSLATE
$MESSAGES["CPE_FIELD_TITLE"]="Title";										// TO TRANSLATE
$MESSAGES["CPE_FIELD_MODIFICATION_DATE"]="Modification date";				// TO TRANSLATE
$MESSAGES["CPE_FIELD_STATUS"]="Status";										// TO TRANSLATE
$MESSAGES["CPE_FIELD_NVD_ID"]="NVD Id";										// TO TRANSLATE
$MESSAGES["CPE_FIELD_PART_APPLICATION"]="Application";						// TO TRANSLATE
$MESSAGES["CPE_FIELD_PART_HARDWARE"]="Hardware";							// TO TRANSLATE
$MESSAGES["CPE_FIELD_PART_OS"]="Operative System";							// TO TRANSLATE

//Auditoria
$MESSAGES["AUDIT"]="AUDIT";                                                 // TO TRANSLATE
$MESSAGES["SECURITY_AUDIT"]="Security audit";                               // TO TRANSLATE
$MESSAGES["AUDIT_MGM_TITLE"]="Security audit";                              // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_SERVER"]="Server";                                   // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_PORT"]="Port";                                       // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_NAME"]="NVT";                                        // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_NVT_ID"]="ID NVT";                                   // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_VULN_ID"]="CVE/CAN";                                 // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_BID"]="BID";                                         // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_DESCRIPTION"]="Description";                         // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_SOLUTION"]="Solution";                               // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_DATE"]="Date";                                       // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_THREAT"]="Threat";                                   // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_RISK_FACTOR"]="Risc factor";                         // TO TRANSLATE
$MESSAGES["AUDIT_FIELD_REFERENCES"]="References";                           // TO TRANSLATE