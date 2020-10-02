<?php

/*
 * Following code will list all the products
 */
// array for JSON response
$response = array();

// include db connect class
include("db_connect.php");

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


// get all products from products table
// Start Functionality  
$postdata = file_get_contents("php://input");
//$postdata = '{"payment_id":"1","deliver_id":"1","vehicle_id":"1","client_id":"94","client_address_id":"2","cart_id":"344"}';

if (isset($postdata) && !empty($postdata)) {
    $Req = json_decode($postdata, TRUE);

    $payment = $Req['payment'];
    $deliver_id = $Req['deliver_id'];
    $client_id = $Req['client_id'];
    $client_address_id = $Req['client_address_id'];
    $cart_id = $Req['cart_id'];
    $lang = $Req['lang'];
    $session_id = $Req['session_id'];
    $mobile_type = $Req['mobile_type'];
    $vat = check_vat();
    $get_order_price = orderPrice($cart_id);
    $not_exist;
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
        $cart_id_all = explode(',', $cart_id);
        if ($client_address_id != '') {
            $get_region_id = get_region_id($client_id, $client_address_id);
            $branch_id = get_branch_from_region_id($get_region_id);
            if ($branch_id == '') {
                $branch_id = get_branch();
            }
            $check_branch_avaliable_delivery = check_branch_avaliable_delivery($branch_id);
            if ($check_branch_avaliable_delivery == 1) {
                $get_charge = get_charge($get_region_id);

                $total_amount = orderPrice($cart_id);
                $check_discount = check_discount();
                if ($check_discount == 1) {
                    $discount_percentage = get_discount_percentage();
                    $discount_value= (($discount_percentage / 100) * $total_amount);
                    $total_amount_after_disc = $total_amount - $discount_value;
                } else {
                    $discount_percentage = 0;
                    $discount_value= 0;
                    $total_amount_after_disc = $total_amount;
                }

                $total = $total_amount_after_disc + $get_charge;
                $vat_added = number_format((float) ( (($vat / 100) * $total_amount_after_disc)), 3, '.', '');
                $net_price_after_vat = number_format((float) ($total + (($vat / 100) * $total_amount_after_disc)), 3, '.', '');

                $min_order = get_min_order($get_region_id);
                if ($get_order_price >= $min_order) {

                    foreach ($cart_id_all as $one) {
                        $cart = mysql_query("SELECT * FROM `cart` WHERE `cart_id`='$one'") or die(mysql_error());
                        $row_select = mysql_fetch_array($cart);
                        $result_two = mysql_query("UPDATE cart SET `status`='1' WHERE `cart_id`='$one' ");
                    }
                    $result = mysql_query("INSERT INTO orders(cart_id,client_id,client_address_id,branch_id,total_price,charge_cost,discount_percentage,discount_value,vat,vat_percentage,net_price,order_status,order_follow,payment,deliver_id,mobile_type,date) 
	VALUES('$cart_id','$client_id','$client_address_id','$branch_id','$total_amount','$get_charge','$discount_percentage','$discount_value','$vat_added','$vat','$net_price_after_vat','0','0','$payment','$deliver_id','$mobile_type','" . date("Y-m-d H:i:s") . "')");

                    $response["product"] = array();

                    $product = array();
                    $product["order_id"] = mysql_insert_id();
                    $order_id = mysql_insert_id();
                    mysql_query("UPDATE `payment` SET `order_id`='$order_id' where `payment_id`='$session_id' ");

                    array_push($response["product"], $product);

                    if ($result) {

                        $response["success"] = 1;
                        if ($lang == "ar") {
                            $response["message"] = "تم تأكيد الطلب بنجاح.";
                        } else {
                            $response["message"] = "Order Confirmed Successfully";
                        }

                        $to = "apps@emcan-group.com";
                        $subject = "Aljazeera Roastery - New Order";
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .="From:  Aljazeera Roastery" . " Info@emcan-group.com\r\n" . "Reply-To:Info@emcan-group.com\r\n";
                        $message = send_email($order_id, $client_id, $client_address_id, $branch_id);
                        mail($to, $subject, $message, $headers);


                        $to = "jazeera.bahrain@gmail.com";
                        $subject = "Aljazeera Roastery - New Order";
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .="From:  Aljazeera Roastery" . " Info@emcan-group.com\r\n" . "Reply-To:Info@emcan-group.com\r\n";
                        $message = send_email($order_id, $client_id, $client_address_id, $branch_id);
                        mail($to, $subject, $message, $headers);


                        //echo json for mobile//
                        echo json_encode($response);
                    } else {
                        $response["success"] = 0;
                        if ($lang == "ar") {
                            $response["message"] = "عفوا لقد حدث خطأ.";
                        } else {
                            $response["message"] = "Sorry, there was an error.";
                        }
                        echo json_encode($response);
                    }
                } else {
                    $response["success"] = 0;
                    if ($lang == "ar") {
                        $response["message"] = "عفوا لا يمكن تأكيد الطلب الحد الأدني هو  " . $min_order . "دينار بحريني .";
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
                    $response["message"] = "Sorry, delivery to home is not available now";
                }
                echo json_encode($response);
            }
        } else {
            $get_charge = 0;
            $min_order = 0;
            $branch_id = $Req['branch_id'];

            $total_amount = orderPrice($cart_id);
            $check_discount = check_discount();
            if ($check_discount == 1) {
                $discount_percentage = get_discount_percentage();
                $discount_value= (($discount_percentage / 100) * $total_amount);
                $total_amount_after_disc = $total_amount - $discount_value;
            } else {
                $discount_percentage = 0;
                $discount_value=0;
                $total_amount_after_disc = $total_amount;
            }

            $total = $total_amount_after_disc + $get_charge;
            $vat_added = number_format((float) ( (($vat / 100) * $total_amount_after_disc)), 3, '.', '');
            $net_price_after_vat = number_format((float) ($total + (($vat / 100) * $total_amount_after_disc)), 3, '.', '');

            foreach ($cart_id_all as $one) {
                $cart = mysql_query("SELECT * FROM `cart` WHERE `cart_id`='$one'") or die(mysql_error());
                $row_select = mysql_fetch_array($cart);
                $result_two = mysql_query("UPDATE cart SET `status`='1' WHERE `cart_id`='$one' ");
            }
            $result = mysql_query("INSERT INTO orders(cart_id,client_id,client_address_id,branch_id,total_price,charge_cost,discount_percentage,discount_value,vat,vat_percentage,net_price,order_status,order_follow,payment,deliver_id,mobile_type,date) 
	VALUES('$cart_id','$client_id','','$branch_id','$total_amount','$get_charge','$discount_percentage','$discount_value','$vat_added','$vat','$net_price_after_vat','0','0','$payment','$deliver_id','$mobile_type','" . date("Y-m-d H:i:s") . "')");

            $response["product"] = array();

            $product = array();
            $product["order_id"] = mysql_insert_id();
            $order_id = mysql_insert_id();
            mysql_query("UPDATE `payment` SET `order_id`='$order_id' where `payment_id`='$session_id' ");
            array_push($response["product"], $product);

            if ($result) {

                $response["success"] = 1;
                if ($lang == "ar") {
                    $response["message"] = "تم تأكيد الطلب بنجاح.";
                } else {
                    $response["message"] = "Order confirmed successfully";
                }


                        $to = "apps@emcan-group.com";
                        $subject = "Aljazeera Roastery - New Order";
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .="From:  Aljazeera Roastery" . " Info@emcan-group.com\r\n" . "Reply-To:Info@emcan-group.com\r\n";
                        $message = send_email($order_id, $client_id, $client_address_id, $branch_id);
                        mail($to, $subject, $message, $headers);


                        $to = "jazeera.bahrain@gmail.com";
                        $subject = "Aljazeera Roastery - New Order";
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .="From:  Aljazeera Roastery" . " Info@emcan-group.com\r\n" . "Reply-To:Info@emcan-group.com\r\n";
                        $message = send_email($order_id, $client_id, $client_address_id, $branch_id);
                        mail($to, $subject, $message, $headers);


                //echo json for mobile//
                echo json_encode($response);
            }
            /*
             */ else {
                $response["success"] = 0;
                if ($lang == "ar") {
                    $response["message"] = "عفوا لقد حدث خطأ.";
                } else {
                    $response["message"] = "Sorry, there was an error.";
                }
                echo json_encode($response);
            }
        }
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