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


    $client_id = $Req["client_id"];
    $device_token = $Req['device_token'];
    $type = $Req['type'];

    $check_token = check_token($device_token, $client_id);
    if ($check_token > 0) {
        $devicesArray = "SELECT device_token.id as device_token_id  from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE device_token.device_token='$device_token' and devices.client_id='{$client_id}'";
        $query_devicesArray = mysql_query($devicesArray);
        $device_token_id = $query_devicesArray['device_token_id'];

        $result_zero = mysql_query("UPDATE devices SET `login`='1',`date_added`='" . date("Y-m-d H:i:s") . "' WHERE `device_token_id`='$device_token_id' and `client_id`='$client_id'");
    } else {
        $result_one = mysql_query("INSERT INTO device_token(device_token,type,date_added) 
	VALUES('$device_token','$type','" . date("Y-m-d H:i:s") . "')");
        $device_token_id = mysql_insert_id();
        $result_two = mysql_query("INSERT INTO devices(device_token_id,client_id,login,date_added) 
	VALUES('$device_token_id','$client_id','1','" . date("Y-m-d H:i:s") . "')");
    }
    // success

    $response["device_token_id"] = $device_token_id;
    $response["success"] = 1;


    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echo no clients JSON
    echo json_encode($response);
}
?>