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
if (isset($_GET['last_order_id'])) {

    $order_id = $_GET['last_order_id'];

    $result = mysql_query("SELECT * FROM `orders` WHERE `order_id` > '$order_id'  ORDER BY `order_id` DESC") or die(mysql_error());

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
            $client_address_id = $row["client_address_id"];
            $charge_cost = $row["charge_cost"];
            $discount_percentage = $row["discount_percentage"];
            $net_price = $row["net_price"];
            $deliver_id = $row["deliver_id"];
            $client_id=$row['client_id'];
            $get_region_id = get_region_id($client_id, $client_address_id);

            $order_date = $row["date"];
            $cart_id_all = explode(',', $cart_id_all_yala);
            $res_arr_values = array();
            $res_arr_response = array();

            foreach ($cart_id_all as $one) {
                $result_2 = mysql_query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");

                $row_select = mysql_fetch_array($result_2);
                $addition_arr_values = array();
                $remove_arr_values = array();
                $summer_meal_values = array();
                $twinz_meal_values = array();
                $arena_slider_values = array();
                $double_meal_values = array();

                $results["cart_id"] = $row_select['cart_id'];
                $results["remove_id"] = $row_select["remove_id"];
                $remove_id = $row_select["remove_id"];
                $results["spicy_type"] = $row_select["spicy_type"];
                $results["type"] = $row_select["type"];
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

                $summer_meal = $row_select["summer_meal"];

                if ($summer_meal != '') {
                    if ($sub_category_id == 108) {
                        $summer_meal_id_all = explode(',', $summer_meal);
                        foreach ($summer_meal_id_all as $one_summer_meal) {
                            if ($lang == "ar") {
                                $summer["summer_meal_name"] = get_summer_meal_name_ar_from_id($one_summer_meal);
                            } else {
                                $summer["summer_meal_name"] = get_summer_meal_name_en_from_id($one_summer_meal);
                            }
                            array_push($summer_meal_values, $summer);
                        }
                    } elseif ($sub_category_id == 112) {
                        $twinz_meal_id_all = explode(',', $summer_meal);
                        foreach ($twinz_meal_id_all as $one_twinz_meal) {
                            if ($lang == "ar") {
                                $twinz["twinz_meal"] = get_twinz_meal_name_ar_from_id($one_twinz_meal);
                            } else {
                                $twinz["twinz_meal"] = get_twinz_meal_name_en_from_id($one_twinz_meal);
                            }
                            array_push($twinz_meal_values, $twinz);
                        }
                    } elseif ($sub_category_id == 111) {
                        $arena_slider_id_all = explode(',', $summer_meal);
                        foreach ($arena_slider_id_all as $one_arena_slider) {
                            if ($lang == "ar") {
                                $arena["arena_slider"] = get_arena_slider_name_ar_from_id($one_arena_slider);
                            } else {
                                $arena["arena_slider"] = get_arena_slider_name_en_from_id($one_arena_slider);
                            }
                            array_push($arena_slider_values, $arena);
                        }
                    } elseif ($sub_category_id == 113) {
                        $double_meal_id_all = explode(',', $summer_meal);
                        foreach ($double_meal_id_all as $one_double_meal) {
                            if ($lang == "ar") {
                                $double["double_meal"] = get_sub_category_name_ar_from_id($one_double_meal);
                            } else {
                                $double["double_meal"] = get_sub_category_name_from_id($one_double_meal);
                            }
                            array_push($double_meal_values, $double);
                        }
                    }
                }

                $results["double_meal"] = $double_meal_values;
                $results["arena_slider"] = $arena_slider_values;
                $results["twinz_meals"] = $twinz_meal_values;
                $results["summer_meal"] = $summer_meal_values;


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
                $total_amount = totalPrice($order_id);


                $total_price_without_charge = $net_price - $charge_cost;



                array_push($res_arr_values, $results);
            }

            $response_2 = array("deliver_id" => $deliver_id, "client_id" => $client_id, "order_date" => $order_date, "order_status" => $order_status, "order_follow" => $order_follow, "order_id" => $order_id, "discount_percentage" => $discount_percentage, "total_price" => number_format((float) ($total_amount), 3, '.', ''), "charge_cost" => number_format((float) ($charge_cost), 3, '.', ''), "total_price_without_charge" => number_format((float) ($total_price_without_charge), 3, '.', ''), "net_price" => number_format((float) ($net_price), 3, '.', ''), "items" => $res_arr_values);
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