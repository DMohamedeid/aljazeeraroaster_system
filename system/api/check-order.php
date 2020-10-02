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


if (isset($_GET['client_id']) && isset($_GET['cart_id'])) {

    $lang = $_GET['lang'];
    $client_id = $_GET['client_id'];
    $client_address_id = $_GET['client_address_id'];
    $cart_id = $_GET['cart_id'];
    $cart_id_all = explode(',', $cart_id);
    $get_order_price = orderPrice($cart_id);
    $response["product"] = array();

    $get_region_id = get_region_id($client_id, $client_address_id);
    $min_order = get_min_order($get_region_id);

    $branch_id = get_branch_from_region_id($get_region_id);
    if ($branch_id == '') {
        $branch_id = get_branch();
    }
    $check_branch_avaliable_delivery = check_branch_avaliable_delivery($branch_id);
    if ($check_branch_avaliable_delivery == 1) {
        if ($get_order_price >= $min_order) {
            $response["success"] = 1;
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            if ($lang == "ar") {
                $response["message"] = "عفوا لا يمكن تأكيد الطلب الحد الأدني هو  " . $min_order . "  دينار بحريني .";
            } else {
                $response["message"] = "Sorry Order can't be confirmed The minimum is 
" . $min_order . " BD";
            }
            echo json_encode($response);
        }
    } else {
        $response["success"] = 0;
        if ($lang == "ar") {
            $response["message"] = "عفوا , التوصيل الي المنزل غير متاح الأن";
        } else {
            $response["message"] = "Sorry, delivery to home is not available now"
            ;
        }
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