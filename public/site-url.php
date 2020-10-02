<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$_COOKIE['lang'] ? : setcookie("lang", "en", time() + 60 * 60 * 24 * 2, '/');

// print_r($_COOKIE);

$site_url = "https://localhost/Projects/Work/aljazeeraroaster_system/";

$payment_url = "https://localhost/Projects/Work/aljazeeraroaster_system/";
////
//$site_url = "http://localhost/aljazira/Arabic-coffee/";
//$payment_url = "http://localhost/aljazira/Arabic-coffee/";
?>