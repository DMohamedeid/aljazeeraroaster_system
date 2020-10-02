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

if ($_GET['cart_id']) {
    $not_exist;
    $cart_id = $_GET['cart_id'];
    $lang = $_GET['lang'];

    $carts_array = explode(",", $cart_id);
    foreach ($carts_array as $one_cart) {
        $query_select = mysql_query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' ORDER BY `cart_id` LIMIT 1");
        $row_select = mysql_fetch_array($query_select);
        $sub_category_id = $row_select['sub_category_id'];
        $check_category_exist = check_category_exist($sub_category_id);
        if ($check_category_exist == 0) {
            $not_exist = 1;
        } else {
            $check_sub_category_exist = check_sub_category_exist($sub_category_id);
            if ($check_sub_category_exist == 0) {
                $not_exist = 1;
            }
        }
    }
    if ($not_exist == 1) {
        // failed to insert row
        $response["not_exist"] = $not_exist;
        $response["success"] = 0;
        if ($lang == "ar") {
            $response["message"] = "هذا الطلب غير متوفر حاليا";
        } else {
            $response["message"] = "This order is currently not available";
        }
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["not_exist"] = 0;

        $response["success"] = 1;
        if ($lang == "ar") {
            $response["message"] = "هذا الطلب  متوفر حاليا";
        } else {
            $response["message"] = "This order is currently available";
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