<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");


if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    $result = mysql_query("SELECT * FROM `clients` WHERE `client_id`='$client_id' limit 1") or die(mysql_error());
    $response["product"] = array();

    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node

        while ($row = mysql_fetch_array($result)) {
            // temp client array
            $product = array();
            $product["exist"] = 1;
            // push single product into final response array
            array_push($response["product"], $product);
        }
        // success
        $response["success"] = 1;


        // echoing JSON response
        echo json_encode($response);
    } else {
        $product = array();
        $product["exist"] = 0;
        // push single product into final response array
        array_push($response["product"], $product);
        // failed to insert row
        $response["success"] = 1;

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echoing JSON response
    echo json_encode($response);
}
?>