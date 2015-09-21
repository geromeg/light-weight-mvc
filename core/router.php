<?php
/**
 * @author Gerome Guilfoyle
 * @date 26 August 2015
 * @description Handles all core routing
 */
if(!isset($_GET['route'])) {
    $sRoute = "/";
} else {
    $sRoute = $_GET['route'];
}

if(!isset($_GET['ajax'])) {
    require_once($aConfig['default_header_view']);
}
if(array_key_exists($sRoute,$aRoutes)) { //We got a path lets go there
    $sRoute = $aRoutes[$sRoute]; //Get the route
}

$aRoutes = explode("/",$sRoute);
$sFunction = array_pop($aRoutes);
$sFile = array_pop($aRoutes);
if(is_array($aRoutes)) {
    $sFolder = "/".implode("/",$aRoutes);
}

require_once("controllers".$sFolder."/".$sFile.".php");
$coController = new Controller();
$coController->{$sFunction}();

if(!isset($_GET['ajax'])) {
    require_once($aConfig['default_footer_view']);
}
?>