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
    $order_id = $_GET['order_id'];
    $value = $_GET['value'];
    $result = $_GET['result'];
    $payment_id = $_GET['payment_id'];
    $net_price=get_net_price($order_id);

    $result = mysql_query("INSERT INTO payment(client_id,order_id,payment_id,value,result,payment_type,date) VALUES('$client_id','$order_id','$payment_id','$net_price','$result','debit','" . date("Y-m-d H:i:s") . "')");

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "تم الإضافة بنجاح.";

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