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


    if ($client_address_id != '') {
        $get_charge = get_charge($get_region_id);
    } else {
        $get_charge = 0;
    }

    $Check_discount = Check_discount();
    if ($Check_discount > 0) {
        $discount_percentage = discount_percentage();
    } else {
        $discount_percentage = 0;
    }
    $discount_percentage_amount = (($discount_percentage / 100) * $get_order_price);

    $net_price = number_format((float) ($get_order_price - $discount_percentage_amount), 3, '.', '');

    $total = $net_price + $get_charge;
    $min_order = get_min_order($get_region_id);



    if ($net_price >= $min_order) {
        $response["order_price"] = $net_price;

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
