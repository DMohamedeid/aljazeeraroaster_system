<?php

include("../public/functions.php");
include("../public/connection.php");

if (isset($_POST['data_cart'])) {
    $cart_id = $_POST['data_cart'];
    $client_id = $_POST['getClient_id'];

    $result = $con->query("DELETE FROM `cart` WHERE `cart_id`='$cart_id'");

    if ($result) {
        $mes['success'] = 1;
        $total_price = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '');
        $Check_discount = Check_discount();
        if ($Check_discount > 0) {
            $discount_percentage = discount_percentage();
        } else {
            $discount_percentage = 0;
        }
        $discount_percentage_amount = (($discount_percentage / 100) * $total_price);

        $net_price = number_format((float) ($total_price - $discount_percentage_amount), 3, '.', '');

        $vat = get_vat();
        $vat_added = (($vat / 100) * $net_price);
        $net_price_after_vat = number_format((float) ($total_price + $vat_added), 3, '.', '');
        if ($_COOKIE['lang'] == "en") {
            $mes['total_price'] = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '') . "BD";
            $mes['net_price'] = ($net_price_after_vat) . "BD";
        } else {
            $mes['total_price'] = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '') . "بحريني دينار";
            $mes['net_price'] = ($net_price_after_vat) . "بحريني دينار";
        }

        $mes['success'] = 1;
        $mes['count_all'] = count_client_cart($client_id);
        echo json_encode($mes);
        exit();
    } else {
        $mes['success'] = 0;
        if ($_COOKIE['lang'] == "en") {
            $mes['massge'] = "Sorry,there is an error!";
        } else {
            $mes["massge"] = "عفوا،لقد حدث خطأ  ";
        }
        echo json_encode($mes);
        exit();
    }
}

if (isset($_POST['data_remove'])) {
    $client_address_id = $_POST['data_remove'];

    $result = $con->query("DELETE FROM `client_addresses` WHERE `client_address_id`='$client_address_id'");

    if ($result) {
        $mes['success'] = 1;
        if ($_COOKIE['lang'] == "en") {
            $mes['massge'] = "Added Successfully!";
        } else {
            $mes["massge"] = "تم الإضافة بنجاح";
        }
        echo json_encode($mes);
        exit();
    } else {
        $mes['success'] = 0;
        if ($_COOKIE['lang'] == "en") {
            $mes['massge'] = "Sorry,there is an error!";
        } else {
            $mes["massge"] = "عفوا،لقد حدث خطأ  ";
        }
        echo json_encode($mes);
        exit();
    }
}
if (isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];

    $result = $con->query("SELECT * FROM `cart` WHERE `client_id`='$client_id' AND `status`=0") or die(mysqli_error());
    $cart_id_all = '';
    while ($row = mysqli_fetch_array($result)) {
        $cart_id = $row["cart_id"];
        $cart_id_all.=$cart_id . ',';
    }
    if ($result) {
        $cart_id_all = substr($cart_id_all, 0, -1);
        $mes['cart_id'] = $cart_id_all;
        $mes['success'] = 1;
        echo json_encode($mes);
        exit();
    } else {
        $mes['success'] = 0;
        echo json_encode($mes);
        exit();
    }
}
if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['new_value'];
    $client_id = $_POST['get_client_id'];
    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $cart_id . "' ORDER BY `cart_id` LIMIT 1");
    $row_select = mysqli_fetch_array($query_select);
    $sub_category_id = $row_select['sub_category_id'];
    $addition_id = $row_select['addition_id'];

    $size_id = $row_select['size_id'];

    $addition_price = 0;

    if ($addition_id != '') {
        $addition_id_all = explode(',', $addition_id);
        foreach ($addition_id_all as $one) {
            $get_addition_price = get_addition_price_from_id($one);
            $addition_price += $get_addition_price;
        }
    }

    $get_size_price = sizePrice($size_id);
    $total = $get_size_price + $addition_price;


    $total_price = $quantity * $total;
    $price = $total_price;

    $result = $con->query("UPDATE `cart` SET `price`='$price',`quantity`='$quantity' WHERE `cart_id`='$cart_id'");

    if ($_COOKIE['lang'] == "en") {
        $product["total_price"] = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '') . 'BD';
    } else {
        $product["total_price"] = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '') . "بحريني دينار";
    }
    // push single product into final response array
    $total_price = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '');
    $Check_discount = Check_discount();
    if ($Check_discount > 0) {
        $discount_percentage = discount_percentage();
    } else {
        $discount_percentage = 0;
    }
    $discount_percentage_amount = (($discount_percentage / 100) * $total_price);

    $net_price = number_format((float) ($total_price - $discount_percentage_amount), 3, '.', '');
    $vat = get_vat();
    $vat_added = (($vat / 100) * $net_price);

    $net_price_after_vat = number_format((float) ($total_price + $vat_added), 3, '.', '');



    if ($_COOKIE['lang'] == "en") {
        $product["net_price"] = number_format((float) ($net_price_after_vat), 3, '.', '') . "BD";
        $product["cart_price"] = number_format((float) ($total_price), 3, '.', '') . "BD";
        $product["disc"] = number_format((float) ($discount_percentage_amount), 3, '.', '') . "BD";
    } else {
        $product["net_price"] = number_format((float) ($net_price_after_vat), 3, '.', '') . "بحريني دينار";
        $product["cart_price"] = number_format((float) ($total_price), 3, '.', '') . "بحريني دينار";
        $product["disc"] = number_format((float) ($discount_percentage_amount), 3, '.', '') . "بحريني دينار";
    }
    $product["vat"] = $vat . '%';

    if ($result) {
        $product['success'] = 1;
        echo json_encode($product);
        exit();
    } else {
        $product['success'] = 0;
        echo json_encode($product);
        exit();
    }
}
?>
