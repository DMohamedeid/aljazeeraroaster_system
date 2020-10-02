<?php

/*
 * Following code will list all the products
 */
// array for JSON response
$response = array();

// include db connect class
include("db_connect.php");

// connecting to db

mysqli_query($con ,"SET NAMES 'utf8'");

mysqli_query($con ,"SET CHARACTER SET utf8");

mysqli_query($con ,"SET SESSION collation_connection = 'utf8_unicode_ci'");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


// get all products from products table
// Start Functionality  
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $Req = json_decode($postdata, TRUE);

    $client_name = trim($Req['client_name']);
    $client_password = trim($Req['client_password']);
    $client_phone = trim($Req['client_phone']);
    $device_token = trim($Req['device_token']);
    $type = $Req['type'];
    $lang = $Req['lang'];

    $check_register_phone = check_register_phone($client_phone);
    if ($check_register_phone == $client_phone) {

// failed to insert row
        $response["success"] = 0;
//        if ($lang == "ar") {
//            $response["message"] = "هذ الرقم مسجل من قبل!";
//        } else {
        $response["message"] = "This number is already registered";
//        }
// echoing JSON response
        echo json_encode($response);
    } else {

        $result = mysqli_query($con ,"INSERT INTO clients(client_name,client_password,client_email,client_phone,date) VALUES('$client_name','$client_password','$client_email','$client_phone','" . date("Y-m-d H:i:s") . "')");
        $client_id = mysqli_insert_id();
        if ($result) {
            $result_one = mysqli_query($con ,"INSERT INTO device_token(device_token,type,date_added) 
	VALUES('$device_token','$type','" . date("Y-m-d H:i:s") . "')");
            $device_token_id = mysqli_insert_id();
            $result_two = mysqli_query($con ,"INSERT INTO devices(device_token_id,client_id,login,date_added) 
	VALUES('$device_token_id','$client_id','1','" . date("Y-m-d H:i:s") . "')");
            $response["product"] = array();
        }
        // temp user array
        $product = array();
        $product["client_id"] = $client_id;
        $product["client_name"] = $Req["client_name"];
        $product["client_password"] = $client_password;
        $product["client_email"] = $Req["client_email"];
        $product["client_phone"] = $Req["client_phone"];

        // push single product into final response array
        array_push($response["product"], $product);


        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["success"] = 1;
            if ($lang == "ar") {
                $response["message"] = "تم إضافة العميل بنجاح.";
            } else {
                $response["message"] = "The client was added successfully";
            }
            // echoing JSON response
            echo json_encode($response);
        } else {
            // failed to insert row
            $response["success"] = 0;
            if ($lang == "ar") {
                $response["message"] = "عفوا لقد حدث خطأ.";
            } else {
                $response["message"] = "Sorry, there was an error.";
            }
            // echoing JSON response
            echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 0;
//    if ($lang == "ar") {
//        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
//    } else {
    $response["message"] = "Missing data Please review your data";
//    }
    // echoing JSON response
    echo json_encode($response);
}
?>

