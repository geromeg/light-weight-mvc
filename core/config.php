<?php
/**
 * @author Gerome Guilfoyle
 * @date 26 August 2015
 * @description Configuration for framework
 */

####################
# Defines          #
####################
define(FULL_FAILURE,0);
define(LOG_STATE,1);
define(OVERRIDE,2);

####################
# Default Settings #
####################

$aConfig['routing'] = true; //By default manual routing is enabled, this means you will need to define routes as such for example : $aRoutes['/home/test/'] = "home/test/index";
                            //Otherwise this will default to routing to controllers/home/test

$aConfig['encryption_key'] = "3uU2xNP73xjb9CR51j2ZxLFhKo5Pc95T"; //Used to generate passwords and other encrypted data

$aConfig['default_timezone'] = "Africa/Johannesburg"; //Default timezone

#####################################
# Default Views                     #
#####################################
$aConfig['default_header_view'] = "default/header.php";
$aConfig['default_body_view']   = "default/body.php";
$aConfig['default_footer_view'] = "default/footer.php";

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