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
    $sub_category_id = $Req['sub_category_id'];
    $comment = $Req['comment'];
    $rate = $Req['rate'];
    $check_sub_category_comment = check_sub_category_comment($client_id, $sub_category_id);

    if ($check_sub_category_comment >= 1) {

        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "عفوا ، قمت بإضافة تعليق لهذا الصنف من قبل";

        // echoing JSON response
        echo json_encode($response);
    } else {
        $result = mysql_query("INSERT INTO sub_category_comments(client_id,sub_category_id,comment,rate,viewed,date) VALUES('$client_id','$sub_category_id','$comment','$rate','0','" . date("Y-m-d H:i:s") . "')");


        $response["product"] = array();

        // temp user array
        $product = array();
        $product["comment_id"] = mysql_insert_id();
        $product["client_id"] = $Req["client_id"];
        $product["sub_category_id"] = $Req["sub_category_id"];
        $product["comment"] = $Req["comment"];
        $product["rate"] = $Req["rate"];

        // push single product into final response array
        array_push($response["product"], $product);


        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["success"] = 1;
            $response["message"] = "تم إضافة تعليق بنجاح.";

            // echoing JSON response
            echo json_encode($response);
        } else {
            // failed to insert row
            $response["success"] = 0;
            $response["message"] = "عفوا لقد حدث خطأ.";

            // echoing JSON response
            echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echoing JSON response
    echo json_encode($response);
}
?>