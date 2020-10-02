<?php

include("../public/functions.php");
include("../public/connection.php");


if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $exist = '';
    $not_exist = '';

    $carts_array = explode(',', $cart_id);
    foreach ($carts_array as $one_cart) {
        $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' ORDER BY `cart_id` LIMIT 1");
        $row_select = mysqli_fetch_array($query_select);
        $sub_category_id = $row_select['sub_category_id'];
        $quantity = $row_select['quantity'];

        $check_product_avaliable = check_product_avaliable($sub_category_id);
        if ($check_product_avaliable > 0) {
            $exist = 1;
        } else {
            $not_exist = 1;
        }
    }
    if ($not_exist == 1) {
        $response["success"] = 0;
        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "This Order is currently unavailable";
        } else {
            $response["message"] = "عفوا،هذا المنتج غير متوفر حاليا";
        }
        echo json_encode($response);
    } else {
        $response["success"] = 1;
        echo json_encode($response);
    }
}
?>
