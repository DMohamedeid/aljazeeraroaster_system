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
    $query = mysql_query("SELECT * FROM `orders` WHERE `client_id`='$client_id' AND `order_id`='$order_id' limit 1") or die(mysql_error());
    $row_select = mysql_fetch_array($query);
    $payment = $row_select['payment'];
    $cart_id = $row_select['cart_id'];
    if ($payment == "online") {

        $response["success"] = 0;
        $response["message"] = " عفوا لا يمكنك إلغاء طلب مدفوع";

        echo json_encode($response);
    } else {
        $cart_id_all = explode(',', $cart_id);

        foreach ($cart_id_all as $one) {
            $delete_cart = mysql_query("DELETE FROM `cart` WHERE `cart_id`='$one'");
        }
        $delete_order = mysql_query("DELETE FROM `orders` WHERE `order_id`='$order_id' and `client_id`='$client_id' ");

        if ($delete_order) {
            $response["success"] = 1;
            $response["message"] = "تم إالغاء الطلب بنجاح.";

            echo json_encode($response);
        }
        /*
         */ else {
            $response["success"] = 0;
            $response["message"] = "عفوا لقد حدث خطأ.";

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