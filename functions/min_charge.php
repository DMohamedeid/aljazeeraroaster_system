<?php

include("../public/functions.php");
include("../public/connection.php");


if (isset($_POST['client_id']) && isset($_POST['cart_id'])) {
    $client_id = $_POST['client_id'];
    $client_address_id = $_POST['client_address_id'];
    $cart_id = $_POST['cart_id'];
    $carts_array = explode(',', $cart_id);
    $get_region_id = get_region_id($client_id, $client_address_id);
    $min_order = get_min_order($get_region_id);
    $get_order_price = orderPrice($cart_id);
    if ($get_order_price >= $min_order) {
        $response["success"] = 1;
        echo json_encode($response);
    } else {
        $response["success"] = 0;
        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "Sorry the Order Can't Be Confirmed Minimum Order Is
  " . $min_order . " BD.";
        } else {
            $response["message"] = "عفوا،لا يمكنك شراء هذا المنتج فالحد الدني هو" . $min_order . " BD.";
        }

        echo json_encode($response);
    }
}
?>
