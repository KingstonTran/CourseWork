<?php
/**
 * Created by PhpStorm.
 * User: Kingston Tran
 * Date: 4/27/2019
 * Time: 11:38 AM
 */
// Include the Locker class
require_once "SuperLights/SuperLights.php";
require_once "SuperLights/SuperLightsController.php";
require_once "SuperLights/SuperLightsView.php";

//
// Session support
//
define('LightSESSION', 'lights');
session_start();

if(!isset($_SESSION[LightSESSION])) {
    $_SESSION[LightSESSION] = new \SuperLights\SuperLights();
}

$lights = $_SESSION[LightSESSION];