<?php

include("../public/site-url.php");
include("../public/functions.php");
include("../public/connection.php");

if (isset($_POST['add_q_to_cart']) && isset($_POST['sub_category_id'])) {


    $sub_category_id = $_POST['sub_category_id'];
    $size_id = $_POST['size_id'];
    $client_id = $_POST['add_q_to_cart'];
    $quantity = $_POST['quantity'];
    $notes = $_POST['notes'];
    $addition_id = $_POST['addition_id'];
    $remove_id = $_POST['remove_id'];
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
    $result = $con->query("INSERT INTO cart(sub_category_id,size_id,addition_id,quantity,price,client_id,remove_id,note,status,date,cart_type) VALUES('$sub_category_id','$size_id','$addition_id','$quantity','$price','$client_id','$remove_id','$notes','0','" . date("Y-m-d H:i:s") . "','2')");
    if ($result) {
// failed to insert row
        $mes['success'] = 1;
        $mes['count_all'] = count_client_cart($client_id);
        echo json_encode($mes);
        exit();
    } else {
// failed to insert row
        $mes['success'] = 0;
        echo json_encode($mes);
        exit();
    }
    die();
}
?>
