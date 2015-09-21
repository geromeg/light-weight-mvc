<?php
/**
 * @author Gerome Guilfoyle
 * @date 26 August 2015
 * @description Configuration for framework
 */

ini_set("display_errors",1);
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

####################
# Defines          #
####################
define(FULL_FAILURE,0);
define(LOG_STATE,1);
define(OVERRIDE,2);
define(LOG_VERBOSE,0); //More heavier logging data
define(LOG_SIMPLE,1); //Basic logging

define(LOG_ERROR,2); //A log file for errors
define(LOG_WARNING,3); //For logging possible warnings
define(LOG_CRITICAL,4); //For critical errors
define(LOG_GENERAL,5); //For general errors
####################
# Default Settings #
####################

$aConfig['routing'] = true; //By default manual routing is enabled, this means you will need to define routes as such for example : $aRoutes['/home/test/'] = "home/test/index";
                            //Otherwise this will default to routing to controllers/home/test

$aConfig['encryption_key'] = "3uU2xNP73xjb9CR51j2ZxLFhKo5Pc95T"; //Used to generate passwords and other encrypted data

$aConfig['default_timezone'] = "Africa/Johannesburg"; //Default timezone

$aConfig['logging_mode'] = LOG_VERBOSE; //By default log everything possible

$aConfig['default_datetime'] = "Y-m-d H:i:s";


#####################################
# Log files                         #
#######################################
# DO NOT CHANGE VARIABLES, JUST VALUES#
# #####################################

$aConfig['logs'][LOG_ERROR] = "logs/error.log";
$aConfig['logs'][LOG_WARNING] = "logs/warning.log";
$aConfig['logs'][LOG_CRITICAL] = "logs/critical.log";
$aConfig['logs'][LOG_GENERAL] = "logs/general.log";
$aConfig['logs']['main_log'] = "logs/consolidated.log"; //All logs will arrive in this log file
$aConfig['logs']['post_pre_condition_log'] = "logs/post_pre_condition.log";

#####################################
# Default Views                     #
#####################################
$aConfig['default_header_view'] = "views/default/header.php";
$aConfig['default_body_view']   = "views/default/body.php";
$aConfig['default_footer_view'] = "views/default/footer.php";

####################################
# URL Switching Mechanism          #
####################################

$sUrl = $_SERVER['SERVER_URI'];

switch($sUrl) {
    case 'development':
        $aConfig['prepost_condition_mode'] = FULL_FAILURE;
        break;
    case 'qa':
        $aConfig['prepost_condition_mode'] = LOG_STATE;
        break;
    case 'production':
        $aConfig['prepost_condition_mode'] = LOG_STATE;
        break;

}


?>