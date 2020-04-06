<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 4/27/2019
 * Time: 11:25 AM
 */
require '../lib/lights.inc.php';
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
if ($_POST['start'] == "start"){
    $_SESSION[LightSESSION] = new \SuperLights\SuperLights();
    $lights = $_SESSION[LightSESSION];
}
//If they go back to start page, we don't want them to be able to go reload their game.
$controller = new \SuperLights\SuperLightsController($lights, $_POST);
header("location: " . $controller->getRedirect());