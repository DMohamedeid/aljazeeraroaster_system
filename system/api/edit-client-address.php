<?php

/*
 * Following code will list all the products
 */
// array for JSON response
$response = array();

// include db connect class
include("db_connect.php");

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

    $lat = trim($Req['lat']);
    $lang = trim($Req['lang']);
    $block = mysql_real_escape_string(trim($Req['block']));
    $road = mysql_real_escape_string(trim($Req['road']));
    $building = mysql_real_escape_string(trim($Req['building']));
    $flat_number = mysql_real_escape_string(trim($Req['flat_number']));
    $note = mysql_real_escape_string(trim($Req['note']));

    $region = $Req['region_id'];
    $client_phone = mysql_real_escape_string($Req['client_phone']);
    $client_id = $Req['client_id'];
    $client_address_id = $Req['client_address_id'];

    $result = mysql_query("UPDATE `client_addresses` SET `lat`='$lat',`lang`='$lang',`region`='$region',`block`='$block',`road`='$road',
	`building`='$building',`flat_number`='$flat_number',`client_phone`='$client_phone',`note`='$note' WHERE `client_id`='$client_id' 
	AND `client_address_id`='$client_address_id'");


    $response["product"] = array();

    // temp user array
    $product = array();


    // push single product into final response array
    array_push($response["product"], $product);


    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "تم تحديث العنوان بنجاح.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "عفوا لقد حدث خطأ.";

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