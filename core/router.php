<?php
/**
 * @author Gerome Guilfoyle
 * @date 26 August 2015
 * @description Handles all core routing
 */

$session = new session();
$id = $session->get_var('id');

$sRoute = "/";
if(!empty($id) || $id > 0){
	if(isset($_GET)) {
		$cRoute = trim(array_keys($_GET)[0]);
		if(!empty($cRoute) || $cRoute > ''){
			$sRoute = $cRoute;
		}
	}
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
