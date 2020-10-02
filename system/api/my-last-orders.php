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


// get all products from products table

if (isset($_GET['client_id']) && $_GET['lang'] != '') {

    $client_id = $_GET['client_id'];
    $lang = $_GET['lang'];

    $result = mysql_query("SELECT * FROM `orders` WHERE `client_id`='$client_id' AND ( (`order_status`=1 and  `order_follow`=3) or `order_status`=2 ) and del=0 ORDER BY `order_id` DESC") or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node

        $response["product"] = array();

        while ($row = mysql_fetch_array($result)) {

            // temp user array
            $searchComma = ',';
            $cart_id_all_yala = $row["cart_id"];
            $order_id = $row["order_id"];
            $order_status = $row["order_status"];
            $order_follow = $row["order_follow"];
            $order_date = $row["date"];
            $client_address_id = $row["client_address_id"];
            $charge_cost = $row["charge_cost"];
            $discount_percentage = $row["discount_percentage"];
            $net_price = $row["net_price"];
            $get_region_id = get_region_id($client_id, $client_address_id);
            $deliver_id = $row["deliver_id"];

            $cart_id_all = explode(',', $cart_id_all_yala);
            $res_arr_values = array();
            $res_arr_response = array();

            foreach ($cart_id_all as $one) {
                $result_2 = mysql_query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");

                $row_select = mysql_fetch_array($result_2);
                $addition_arr_values = array();
                $remove_arr_values = array();

                $results["cart_id"] = $row_select['cart_id'];
                $results["remove_id"] = $row_select["remove_id"];
                $remove_id = $row_select["remove_id"];
                $results["spicy_type"] = $row_select["spicy_type"];
                $sub_category_id = $row_select["sub_category_id"];
                $results["sub_category_id"] = $row_select["sub_category_id"];

                if ($lang == "ar") {
                    $results["sub_category_desc"] = get_sub_category_desc_ar_from_id($sub_category_id);
                    $results["sub_category_name"] = get_sub_category_name_ar_from_id($sub_category_id);
                } else {
                    $results["sub_category_name"] = get_sub_category_name_from_id($sub_category_id);
                    $results["sub_category_desc"] = get_sub_category_desc_from_id($sub_category_id);
                }
                $results["sub_category_image"] = get_sub_category_image_from_id($sub_category_id);


                $size_id = $row_select['size_id'];
                if ($lang == "ar") {
                    $results["size_name"] = get_size_name_ar_from_id($size_id);
                } else {
                    $results["size_name"] = get_size_name_from_id($size_id);
                }
                $results["size_price"] = get_size_price_from_id($size_id);

                $addition_id = $row_select['addition_id'];
                if ($addition_id != '') {
                    $addition_id_all = explode(',', $addition_id);
                    foreach ($addition_id_all as $one) {
                        if ($lang == "ar") {
                            $addition["addition_name"] = get_addition_name_ar_from_id($one);
                        } else {
                            $addition["addition_name"] = get_addition_name_from_id($one);
                        }
                        $addition["addition_price"] = get_addition_price_from_id($one);

                        array_push($addition_arr_values, $addition);
                    }
                }
                $results["addition"] = $addition_arr_values;

                if ($remove_id != '') {
                    $remove_id_all = explode(',', $remove_id);
                    foreach ($remove_id_all as $one) {
                        if ($lang == "ar") {
                            $remove["remove_name"] = get_remove_name_ar_from_id($one);
                        } else {
                            $remove["remove_name"] = get_remove_name_from_id($one);
                        }
                        array_push($remove_arr_values, $remove);
                    }
                }

                $results["remove"] = $remove_arr_values;

                $quantity = $row_select['quantity'];
                $results["quantity"] = $quantity;

                $results["price"] = $row_select['price'];

                $total_amount = totalPrice($order_id);


                $total_price_without_charge = $net_price - $charge_cost;



                array_push($res_arr_values, $results);
            }
            $response_2 = array("deliver_id" => $deliver_id, "client_id" => $_GET["client_id"], "order_date" => $order_date, "order_status" => $order_status, "order_follow" => $order_follow, "order_id" => $order_id, "discount_percentage" => $discount_percentage, "total_price" => number_format((float) ($total_amount), 3, '.', ''), "charge_cost" => number_format((float) ($charge_cost), 3, '.', ''), "total_price_without_charge" => number_format((float) ($total_price_without_charge), 3, '.', ''), "net_price" => $net_price, "items" => $res_arr_values);
            array_push($response["product"], $response_2);
        }
        $response["success"] = 1;
        echo json_encode($response);
    } else {

        $response["product"] = array();

        // temp user array
        $product = array();

        // success
        $response["success"] = 1;

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // no products found
    $response["success"] = 0;
    if ($lang == "ar") {
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    } else {
        $response["message"] = "Missing data Please review your data";
    }
    // echo no users JSON
    echo json_encode($response);
}
?>