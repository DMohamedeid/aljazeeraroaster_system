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
if (isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];
    $lang = $_GET['lang'];
    $cart_id_all_yala = get_cart_id($order_id);
    $response["product"] = array();

    $cart_id_all = explode(',', $cart_id_all_yala);
    foreach ($cart_id_all as $one) {
        $comments_response = array();
        $result = mysql_query("SELECT *,(select  parent_category_id from sub_categories  where sub_categories.sub_category_id=cart.sub_category_id )  group_id FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");

        $row_select = mysql_fetch_array($result);
        $addition_arr_values = array();
        $remove_arr_values = array();

        $results["cart_id"] = $row_select['cart_id'];
        $results["remove_id"] = $row_select["remove_id"];
        $remove_id = $row_select["remove_id"];
        $results["spicy_type"] = $row_select["spicy_type"];
        $results["type"] = $row_select["type"];
        $results["potato_id"] = $row_select["potato_id"];
        $results["drink_id"] = $row_select["drink_id"];
        $results["note"] = $row_select["note"];
        $results["group_id"] = $row_select["group_id"];
        $potato_id = $row_select["potato_id"];
        $drink_id = $row_select["drink_id"];
        $type = $row_select["type"];
        $sub_category_id = $row_select["sub_category_id"];
        $results["sub_category_id"] = $row_select["sub_category_id"];
        
        if ($type == 1) {
            if ($lang == "ar") {
                if ($sub_category_id == 108) {
                    $results["drinks_name"] = get_drinks_name_ar_from_id($drink_id);
                    $results["potatos_name"] = get_potatos_name_ar_from_id($potato_id);
                } elseif ($sub_category_id == 112 || $sub_category_id == 113) {
                    $drinks_name = '';
                    $potatos_name = '';

                    $drink_id_all = explode(',', $drink_id);
                    foreach ($drink_id_all as $one_drink) {
                        $drinks_name .= get_drinks_name_ar_from_id($one_drink) . ' و ';
                    }
                    $potato_id_all = explode(',', $potato_id);
                    foreach ($potato_id_all as $one_potato) {
                        $potatos_name .= get_potatos_name_ar_from_id($one_potato) . ' و ';
                    }
                    $drinks_name = substr($drinks_name, 0, -3);
                    $potatos_name = substr($potatos_name, 0, -3);

                    $results["drinks_name"] = $drinks_name;
                    $results["potatos_name"] = $potatos_name;
                } else {
                    $results["drinks_name"] = get_drinks_name_ar_from_id($drink_id);
                    $results["potatos_name"] = get_potatos_name_ar_from_id($potato_id);
                }
            } else {
                if ($sub_category_id == 108) {
                    $results["drinks_name"] = get_drinks_name_en_from_id($drink_id);
                    $results["potatos_name"] = get_potatos_name_en_from_id($potato_id);
                } elseif ($sub_category_id == 112 || $sub_category_id == 113) {
                    $drinks_name = '';
                    $potatos_name = '';

                    $drink_id_all = explode(',', $drink_id);
                    foreach ($drink_id_all as $one_drink) {
                        $drinks_name .= get_drinks_name_en_from_id($one_drink) . ' and ';
                    }
                    $potato_id_all = explode(',', $potato_id);
                    foreach ($potato_id_all as $one_potato) {
                        $potatos_name .= get_potatos_name_en_from_id($one_potato) . ' and ';
                    }
                    $drinks_name = substr($drinks_name, 0, -4);
                    $potatos_name = substr($potatos_name, 0, -4);

                    $results["drinks_name"] = $drinks_name;
                    $results["potatos_name"] = $potatos_name;
                } else {
                    $results["drinks_name"] = get_drinks_name_en_from_id($drink_id);
                    $results["potatos_name"] = get_potatos_name_en_from_id($potato_id);
                }
            }
        }


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
        $results["size_price"] = number_format((float) (get_size_price_from_id($size_id)), 3, '.', '');

        $addition_id = $row_select['addition_id'];

        if ($addition_id != '') {
            $addition_id_all = explode(',', $addition_id);
            foreach ($addition_id_all as $one) {
                if ($lang == "ar") {
                    $addition["addition_name"] = get_addition_name_ar_from_id($one);
                } else {
                    $addition["addition_name"] = get_addition_name_from_id($one);
                }
                $addition["addition_price"] = number_format((float) (get_addition_price_from_id($one)), 3, '.', '');
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

        $price = $row_select['price'];
        $results["price"] = number_format((float) ($price), 3, '.', '');

        $result_2 = mysql_query("SELECT * FROM `sub_category_comments` WHERE `sub_category_id`='$sub_category_id' order by comment_id desc ") or die(mysql_error());
        while ($row_2 = mysql_fetch_array($result_2)) {
            $comments = array();
            $comments["comment_id"] = $row_2["comment_id"];
            $comments["comment"] = $row_2["comment"];
            $comments["rate"] = $row_2["rate"];

            array_push($comments_response, $comments);
        }

        $results["comments"] = $comments_response;



        array_push($response["product"], $results);
    }


    // success
    $response["success"] = 1;
    // echoing JSON response
    echo json_encode($response);
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