<?php

include("../public/functions.php");
include("../public/connection.php");


if (isset($_POST)) {
    $Req = $_POST;
    $payment = $Req['payment'];
    $deliver_id = $Req['deliver_id'];
    $client_id = $Req['client_id'];
    $client_address_id = $Req['client_address_id'];
    $cart_id = $Req['cart_id'];
    $get_order_price = orderPrice($cart_id);
    $exist;
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
        // failed to insert row
        $response["exist"] = 0;
        $response["success"] = 0;

        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "This Order is currently unavailable";
        } else {
            $response["message"] = "نأسف، هذا المنتج غير متوفر حالياً";
        }
        // echoing JSON response
        echo json_encode($response);
    } else {

        if (isset($client_address_id) && $client_address_id != '') {
            $get_region_id = get_region_id($client_id, $client_address_id);
            $get_charge = get_charge($get_region_id);
            $total_amount = orderPrice($cart_id);

            $Check_discount = Check_discount();
            if ($Check_discount > 0) {
                $discount_percentage = discount_percentage();
            } else {
                $discount_percentage = 0;
            }
            $discount_percentage_amount = (($discount_percentage / 100) * $total_amount);

            $net_price = number_format((float) ($total_amount - $discount_percentage_amount), 3, '.', '');

            $total = $net_price + $get_charge;
            $min_order = get_min_order($get_region_id);
            if ($total >= $min_order) {
                $cart_id_all = explode(',', $cart_id);

                $vat = get_vat();
                $vat_added = (($vat / 100) * $net_price);
                $net_price_after_vat = number_format((float) ($net_price + $vat_added), 3, '.', '');

                $result = $con->query("INSERT INTO orders(cart_id,client_id,client_address_id,total_price,charge_cost,discount_percentage,discount_value,vat,vat_percentage,net_price,order_status,order_follow,payment,deliver_id,mobile_type,date) 
	VALUES('$cart_id','$client_id','$client_address_id','$total_amount','$get_charge','$discount_percentage','$discount_percentage_amount','$vat_added','$vat','$net_price_after_vat','0','0','$payment','$deliver_id','Web','" . date("Y-m-d H:i:s") . "')");

                $order_id = mysqli_insert_id($con);
//                $con->query("UPDATE `payment` SET `order_id`='$order_id' where `session_id`='$ssID' ");
                foreach ($cart_id_all as $one) {
                    $cart = $con->query("SELECT * FROM `cart` WHERE `cart_id`='$one'") or die(mysqli_error());
                    $row_select = mysqli_fetch_array($cart);
                    $quantity = $row_select['quantity'];

                    $result_two = $con->query("UPDATE cart SET `status`='1'   WHERE `cart_id`='$one' ");
                }

                if ($result) {

                    $response["success"] = 1;
                    $response["message"] = "Order confirmed successfully";
                    $response["order_id"] = $order_id;

                    echo json_encode($response);
                }
                /*
                 */ else {
                    $response["success"] = 0;

                    $response["message"] = "Sorry, there was an error";

                    echo json_encode($response);
                }
            } else {
                $response["success"] = 0;

                if ($_COOKIE['lang'] == "en") {
                    $response["message"] = "Sorry the Order Can't Be Confirmed Minimum Order Is
  " . $min_order . " BD.";
                } else {
                    $response["message"] = "نأسف، لا يمكنك إعتماد الطلب لأن الحد الأدنى هو " . $min_order . " BD.";
                }

                echo json_encode($response);
            }
        } else {
            $get_charge = 0;
            $min_order = 0;

            $total_amount = orderPrice($cart_id);
            $total = $total_amount + $get_charge;
            $cart_id_all = explode(',', $cart_id);
            $Check_discount = Check_discount();
            if ($Check_discount > 0) {
                $discount_percentage = discount_percentage();
            } else {
                $discount_percentage = 0;
            }
            $discount_percentage_amount = (($discount_percentage / 100) * $total);

            $net_price = number_format((float) ($total - $discount_percentage_amount), 3, '.', '');


            $vat = get_vat();
            $vat_added = (($vat / 100) * $net_price);
            $net_price_after_vat = number_format((float) ($net_price + $vat_added), 3, '.', '');

            $result = $con->query("INSERT INTO orders(cart_id,client_id,client_address_id,total_price,charge_cost,discount_percentage,discount_value,vat,vat_percentage,net_price,order_status,order_follow,payment,deliver_id,mobile_type,date) 
	VALUES('$cart_id','$client_id','','$total_amount','$get_charge','$discount_percentage','$discount_percentage_amount','$vat_added','$vat','$net_price_after_vat','0','0','$payment','$deliver_id','Web','" . date("Y-m-d H:i:s") . "')");

            $order_id = mysqli_insert_id($con);

            foreach ($cart_id_all as $one) {
                $cart = $con->query("SELECT * FROM `cart` WHERE `cart_id`='$one'") or die(mysqli_error());
                $row_select = mysqli_fetch_array($cart);
                $quantity = $row_select['quantity'];

                $result_two = $con->query("UPDATE cart SET `status`='1'  WHERE `cart_id`='$one'");
            }


            if ($result) {

                $response["success"] = 1;
                $response["message"] = "Order confirmed successfully";
                $response["order_id"] = $order_id;

                echo json_encode($response);
            }
            /*
             */ else {
                $response["success"] = 0;
                if ($_COOKIE['lang'] == "en") {
                    $response["message"] = "Sorry,there is an error!";
                } else {
                    $response["message"] = "عفوا،لقد حدث خطأ  ";
                }
                echo json_encode($response);
            }
        }
    }
}
?>
