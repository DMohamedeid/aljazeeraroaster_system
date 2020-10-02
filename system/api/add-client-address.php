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
    $region = trim($Req['region_id']);
    $block = mysql_real_escape_string(trim($Req['block']));
    $road = mysql_real_escape_string(trim($Req['road']));
    $building = mysql_real_escape_string(trim($Req['building']));
    $flat_number = mysql_real_escape_string(trim($Req['flat_number']));
    $client_phone = mysql_real_escape_string(trim($Req['client_phone']));
    $note = mysql_real_escape_string(trim($Req['note']));
    $client_id = trim($Req['client_id']);

    $result = mysql_query("INSERT INTO client_addresses(lat,lang,region,block,road,building,flat_number,client_phone,note,client_id,date) 
	VALUES('$lat','$lang','$region','$block','$road','$building','$flat_number','$client_phone','$note','$client_id','" . date("Y-m-d H:i:s") . "')");

    $response["product"] = array();

    // temp user array
    $product = array();
    $product["client_address_id"] = mysql_insert_id();
    $product["lat"] = $Req["lat"];
    $product["lang"] = $Req["lang"];
    $product["region_id"] = $Req["region_id"];

    $region_id = $Req["region_id"];
    $product["region_name"] = get_region_name($region_id);
    $product["charge"] = get_charge($region_id);
    $product["min_order"] = get_min_order($region_id);


    $product["block"] = $Req["block"];
    $product["road"] = $Req["road"];
    $product["building"] = $Req["building"];
    $product["flat_number"] = $Req["flat_number"];
    $product["client_phone"] = $Req["client_phone"];
    $product["note"] = $Req["note"];
    $product["client_id"] = $Req["client_id"];

    // push single product into final response array
    array_push($response["product"], $product);


    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "تم إضافة العنوان بنجاح.";

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