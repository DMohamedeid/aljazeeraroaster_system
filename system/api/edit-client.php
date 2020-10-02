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

    $client_id = $Req['client_id'];
    $client_name = trim($Req['client_name']);
    $client_password = trim($Req['client_password']);
    $client_phone = trim($Req['client_phone']);
    $lang = $Req['lang'];

    if (check_register_phone($client_phone) && $client_phone != get_client_phone_from_id($client_id)) {
// failed to insert row
        $response["success"] = 0;
        if ($lang == "ar") {
            $response["message"] = "هذ الرقم مسجل من قبل!";
        } else {
            $response["message"] = "This number is already registered";
        }// echoing JSON response
        echo json_encode($response);
    } else {
        $result = mysql_query("UPDATE clients SET `client_name`='$client_name',`client_password`='$client_password',
	`client_phone`='$client_phone' WHERE `client_id`='$client_id'");

        $result_two = mysql_query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysql_error());

        // check for empty result
        if (mysql_num_rows($result_two) > 0) {
            // looping through all results
            // products node
            $response["product"] = array();

            while ($row = mysql_fetch_array($result_two)) {
                // temp client array
                $product = array();
                $product["client_id"] = $row["client_id"];
                $product["client_name"] = $row["client_name"];
                $product["client_password"] = $row["client_password"];
                $product["client_email"] = $row["client_email"];
                $product["client_phone"] = $row["client_phone"];
                $product["client_image"] = $row["client_image"];
                $product['date'] = $row['date'];

                // push single product into final response array
                array_push($response["product"], $product);
            }
            // success
            $response["success"] = 1;


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
    if ($lang == "ar") {
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    } else {
        $response["message"] = "Missing data Please review your data";
    }
    // echoing JSON response
    echo json_encode($response);
}
?>