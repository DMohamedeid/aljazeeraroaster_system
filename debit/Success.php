<?php

$response = array();
// include db connect class
require_once __DIR__ . '../../system/api/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");

if (isset($_GET['PaymentId'])) {

        $PaymentId = $_GET['PaymentId'];



        $response["success"] = 1;
        $response['PaymentId']=$PaymentId;

        // echoing JSON response
        echo json_encode($response);
   
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echoing JSON response
    echo json_encode($response);
}
?>