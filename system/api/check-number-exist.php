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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


// get all products from products table
// Start Functionality  
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $Req = json_decode($postdata, TRUE);

    $client_phone = $Req['client_phone'];
    $lang = $Req['lang'];

    $check_register_phone = check_register_phone($client_phone);
    if ($check_register_phone == $client_phone) {

// failed to insert row
        $response["success"] = 1;
        $response["exist"] = 1;
        $response["client_id"] = get_client_id_from_phone($client_phone);
        
        if ($lang == "ar") {
            $response["message"] = "هذ الرقم مسجل من قبل!";
        } else {
            $response["message"] = "This number is already registered!";
        }
// echoing JSON response
        echo json_encode($response);
    } else {

        // failed to insert row
        $response["success"] = 1;
        $response["exist"] = 0;
        $response["client_id"] = get_client_id_from_phone($client_phone);
        if ($lang == "ar") {
            $response["message"] = "هذ الرقم غير مسجل من قبل!";
        } else {
            $response["message"] = "This number is not registered!";
        }
// echoing JSON response
        echo json_encode($response);
    }
} else {
// required field is missing
    $response["success"] = 0;
    if ($lang == "ar") {
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    } else {
        $response["message"] = "Missing data Please review your data";
    }
// echoing JSON response
    echo json_encode($response);
}
?>