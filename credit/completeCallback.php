<?php

$response = array();
// include db connect class
require_once __DIR__ . '/../system/api/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");

$client_id=$_GET['client_id'];
$resultIndicator=$_GET['resultIndicator'];
$orderID=$_GET['orderID'];


mysql_query("UPDATE `payment` SET `result`='success' where  `value`='$resultIndicator' and `order_id`='$orderID'");

?>

