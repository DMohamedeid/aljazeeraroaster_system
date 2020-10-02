<?php
include_once("regions_functions.php");

 function remoteFileExists($url) {
    $curl = curl_init($url);
    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);
    //do request
    $result = curl_exec($curl);
    $ret = false;
    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
        if ($statusCode == 200) {
             $ret = true;   
        }
    }
                                                        
    curl_close($curl);
    return $ret;
     
 }

if (isset($_POST['check_approved_order_id'])) {
    include("../connection.php");
    $order_id = $_POST['check_approved_order_id'];
    $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` limit 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $order_status = $row_select['order_status'];
    echo $order_status;
}

function check_client_exists_in_orders($client_id, $order_id) {

    global $con;

    $query = $con->query("SELECT * FROM `orders` WHERE `client_id`='$client_id' AND `order_id`<'$order_id'");

    return mysqli_num_rows($query);
}

if (isset($_POST['send_client_id'])) {

    include("../connection.php");

    $client_id = $_POST['send_client_id'];
    $content = $_POST['send_content'];
    $message_type_id = $_POST['send_message_type_id'];
    $complaint_id = $_POST['send_complaint_id'];
    $query = $con->query("INSERT INTO `messages` VALUES (null,'$message_type_id','$content','$client_id','$complaint_id','0','0','" . date("Y-m-d H:i:s") . "')");
    if ($query) {
        $message_id = mysqli_insert_id($con);

        //ارسال اشعار للعميل
        $devicesArray = " SELECT device_token.*,devices.* from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE devices.client_id='{$client_id}' and devices.login =1";
        $query_devicesArray = $con->query($devicesArray);
        $devicesArray_count = mysqli_num_rows($query_devicesArray);
        if ($devicesArray_count > 0) {
            while ($v = mysqli_fetch_assoc($query_devicesArray)) {
                if ($v['device_token_id']) {
                    $data = array();
                    $data['title'] = 'تم الرد علي الشكوى أو الإقتراح';
                    $data['client_id'] = $client_id;
                    $data['type'] = 'message';

                    $addNotSend['client_id'] = $client_id;
                    $addNotSend['text'] = 'تم الرد علي الشكوى أو الإقتراح';
                    $addNotSend['type'] = 'reply';
                    $addNotSend['text_id'] = $message_id;

                    $params = array("pushtype" => $v['type'], "registration_id" => $v['device_token'], "data" => $data);
                    $rtn = sendMessage($params, $addNotSend);
                }
            }
        } else {
            $params = array("client_id" => $client_id, "type" => 'reply', "text_id" => $message_id, 'text' => 'تم الرد علي الشكوي أو الإقتراح');
            $sendnotify = insertIntoNotSend($params);
        }
        echo get_success("sent succesfully");
    }
}
if (isset($_POST['last'])) {
    include("../connection.php");
    $last = $_POST['last'];
    $user_type = $_POST['user_type'];
    $query_select = $con->query("SELECT * FROM `orders` where `order_id`>'$last'  ORDER BY `order_id` desc ");

    $order_count = mysqli_num_rows($query_select);
    echo $order_count;
    exit();
}

function lastOrder($user_type) {
    global $con;
    $query_select = $con->query("SELECT * FROM `orders`  ORDER BY `order_id` desc LIMIT 1 ");

    $row_select = mysqli_fetch_array($query_select);
    $order_id = $row_select['order_id'];
    return $order_id;
}

function get_deliver_name($deliver_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `delivered_way` where `id`='$deliver_id' ORDER BY `id` desc LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $name_en = $row_select['name_en'];
    return $name_en;
}

function order_count() {

    global $con;

    $query = $con->query("SELECT * FROM `orders`  ORDER BY `order_id` ASC");

    $order_count = mysqli_num_rows($query);

    return $order_count;
}

function new_order_count() {

    global $con;

    $query = $con->query("SELECT * FROM `orders` where `order_status`=0  ORDER BY `order_id` ASC");

    $order_count = mysqli_num_rows($query);

    return $order_count;
}

function getPrice($size_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='" . $size_id . "' ORDER BY `sub_category_size_price_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $sub_category_size_price = $row_select['sub_category_size_price'];
    return $sub_category_size_price;
}

function add_order($temp) {
    global $con;
    $address_id = $temp['client_address_id'];
    $region_id = get_region_by_client_address($temp['client_id'], $address_id);
    $getChargeRegionId = getChargeRegionId($region_id);

    $getorderprice = getPrice($temp['size_id']);
    $addition_itr = $temp['addition_itr'];
    $remove_itr = $temp['remove_itr'];

    $getadditionprice_all = 0;
    $all_additions;
    $all_removes;
    for ($x = 0; $x <= $addition_itr; $x++) {
        if ($temp['addition_id_' . $x] != '') {
            $getadditionprice = getAdditionPrice($temp['addition_id_' . $x]);
            $getadditionprice_all+=$getadditionprice;
            $all_additions .= $temp['addition_id_' . $x] . ',';
        }
    }

    $all_additions = substr($all_additions, 0, -1);
    for ($y = 0; $y <= $remove_itr; $y++) {
        if ($temp['remove_id_' . $y] != '') {
            $all_removes .= $temp['remove_id_' . $y] . ',';
        }
    }
    $all_removes = substr($all_removes, 0, -1);

    $total = $getorderprice + $getadditionprice_all;
    $sum = $total * $temp['quantity'];
    $con->query("INSERT INTO `cart` VALUES (null,'" . $temp['sub_category_id'] . "','" . $temp['size_id'] . "','$all_additions','" . $temp['quantity'] . "','$sum','" . $temp['client_id'] . "','$all_removes','1')");

    $cart_id = mysqli_insert_id($con);
    if ($cart_id) {
        $con->query("INSERT INTO `orders` VALUES (null,'$cart_id','" . $temp['client_id'] . "','" . $temp['client_address_id'] . "','$getChargeRegionId','1','1','" . $temp['payment'] . "','" . date("Y-m-d H:i:s") . "')");
    }
    return mysqli_insert_id($con);
}

function last_orders($aStart = 0, $aLimit = 0, $get) {

    global $con;
    $last_orders = array();
    $sql = " SELECT `clients`.`client_phone`, `orders`.* FROM `orders` left join clients on clients.client_id=orders.client_id  where (((`orders`.`order_status`=1 and  `orders`.`order_follow`=3) or `orders`.`order_status`=2))  and orders.del=0  ";

    if (!empty($get['order_id'])) {
        $sql .= " and `orders`.order_id='" . $get['order_id'] . "'";
    }
    if (!empty($get['client_phone'])) {
        $sql .= " and `clients`.client_phone='" . $get['client_phone'] . "'";
    }
    $sql.= " ORDER BY `order_id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    $query_select = $con->query($sql);
    $x = 1;

    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($last_orders, $row);

        $x++;
    }
    return $last_orders;
}

function client_orders($aStart = 0, $aLimit = 0) {

    global $con;
    $last_orders = array();
    $sql = " SELECT * FROM `orders` where client_id='" . $_GET['client_id'] . "'  ";

    $sql.= "  and del=0 ORDER BY `order_id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    $query_select = $con->query($sql);
    $x = 1;

    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($last_orders, $row);

        $x++;
    }
    return $last_orders;
}

function client_orders_count() {

    global $con;

    $query = $con->query("SELECT * FROM `orders` where  client_id='" . $_GET['client_id'] . "' and del=0  ORDER BY `order_id` ASC");

    $order_count = mysqli_num_rows($query);

    return $order_count;
}

function last_orders_count($get) {

    global $con;
    $sql = " SELECT `clients`.`client_phone`, `orders`.* FROM `orders` left join clients on clients.client_id=orders.client_id where (((`orders`.`order_status`=1 and  `orders`.`order_follow`=3) or `orders`.`order_status`=2))  and orders.del=0  ";

    if (!empty($get['order_id'])) {
        $sql .= " and `orders`.order_id='" . $get['order_id'] . "'";
    }
    if (!empty($get['client_phone'])) {
        $sql .= " and `clients`.client_phone='" . $get['client_phone'] . "'";
    }
    $query = $con->query($sql);
    $order_count = mysqli_num_rows($query);

    return $order_count;
}

function get_charge($region_id) {
    global $con;

    $result = $con->query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC limit 1");

    $row = mysqli_fetch_array($result);

    $charge = $row['charge'];

    return $charge;
}

function get_region($region_id) {
    global $con;

    $result = $con->query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC limit 1");

    $row = mysqli_fetch_array($result);

    $region_name_en = $row['region_name_en'];

    return $region_name_en;
}

function get_region_by_client_address($client_id, $client_address_id) {
    global $con;

    $result = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id' and `client_id`='$client_id' ORDER BY `client_address_id` DESC limit 1");

    $row = mysqli_fetch_array($result);

    $region = $row['region'];

    return $region;
}

function get_sub_category_name($sub_category_id) {
    global $con;

    $query_select_two = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` DESC");
    $row_select_two = mysqli_fetch_assoc($query_select_two);
    $sub_category_name = $row_select_two['sub_category_name'];

    return $sub_category_name;
}

function current_order_count($get) {

    global $con;
    $sql = " SELECT `clients`.`client_phone`, `orders`.* FROM `orders` left join clients on clients.client_id=orders.client_id  where ((`orders`.`order_follow`!=3 and `orders`.`order_follow`!=0 ) or `orders`.`order_status`=0)  and orders.del=0 ";

    if (!empty($get['order_id'])) {
        $sql .= "and `orders`.order_id='" . $get['order_id'] . "'";
    }
    if (!empty($get['client_phone'])) {
        $sql .= " and `clients`.client_phone='" . $get['client_phone'] . "'";
    }
    $query = $con->query($sql);

    $order_count = mysqli_num_rows($query);

    return $order_count;
}

function view_order($aStart = 0, $aLimit = 0, $get) {

    global $con;
    $orders = array();
    $sql = " SELECT `clients`.`client_phone`, `orders`.* FROM `orders` left join clients on clients.client_id=orders.client_id  where ((`orders`.`order_follow`!=3 and `orders`.`order_follow`!=0 ) or `orders`.`order_status`=0 ) and orders.del=0 ";

    if (!empty($get['order_id'])) {
        $sql .= "and `orders`.order_id='" . $get['order_id'] . "'";
    }
    if (!empty($get['client_phone'])) {
        $sql .= " and `clients`.client_phone='" . $get['client_phone'] . "'";
    }

    $sql.= " ORDER BY `order_id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($orders, $row);

        $x++;
    }
    return $orders;
}

function get_client_name_by_id($client_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `clients` WHERE `client_id`='" . $client_id . "' ORDER BY `client_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $client_name = $row_select['client_name'];
    return $client_name;
}

function get_client_id($cart_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $cart_id . "' ORDER BY `cart_id` LIMIT 1 ");

    $row_select = mysqli_fetch_array($query_select);
    $client_id = $row_select['client_id'];
    return $client_id;
}

function get_client_phone_by_id($client_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `clients` WHERE `client_id`='" . $client_id . "' ORDER BY `client_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $client_phone = $row_select['client_phone'];
    return $client_phone;
}

function get_order_reason_deleted($order_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `order_delete_reason` WHERE `order_id`='$order_id' ");
    $row_select = mysqli_fetch_array($query_select);
    $delete_reason = $row_select['delete_reason'];
    return $delete_reason;
}

function get_order_reason_edited($order_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `order_edit_reason` WHERE `order_id`='$order_id' ");
    $row_select = mysqli_fetch_array($query_select);
    $edit_reason = $row_select['edit_reason'];
    return $edit_reason;
}

function get_client_address_by_id($client_address_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='" . $client_address_id . "'  LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $client_region = $row_select['region'];
    $client_block = $row_select['block'];
    $client_road = $row_select['road'];
    $client_building = $row_select['building'];
    $client_flat_number = $row_select['flat_number'];
    $client_phone = $row_select['client_phone'];

    $client_address_total = "<b>" . "City :" . $client_region . "</b>" . "Block : " . $client_block . " Road : " . $client_road . " Building : " . $client_building . " Flat Num : " . $client_flat_number . "Client Num : " . $client_phone;
    return $client_address_total;
}

function get_client_address($client_address_id) {
    global $con;
    $query_select = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='" . $client_address_id . "'  LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $client_region = $row_select['region'];
    $client_block = $row_select['block'];
    $client_road = $row_select['road'];
    $client_building = $row_select['building'];
    $client_flat_number = $row_select['flat_number'];
    $client_client_phone = $row_select['client_phone'];
    $note = $row_select['note'];

    return array($client_region, $client_block, $client_road, $client_building, $client_flat_number, $note, $client_client_phone);
}









      

function get_branche_Name($branche_id) {

    global $con;

    $query_select = $con->query("SELECT * FROM `branches` WHERE `id`='$branche_id' ORDER BY `id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $name = $row_select['name'];
    return $name;
}

function get_size_additions_price_by_id($additions_id) {

    global $con;

    $get_additions_id = explode(',', $additions_id);
    $sum_all = 0;
    foreach ($get_additions_id AS $add_id) {

        $query_addition = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`='$add_id' ORDER BY `sub_category_addition_price_id` DESC");

        $row_addition = mysqli_fetch_assoc($query_addition);
        $sub_category_addition_price = $row_addition['sub_category_addition_price'];
        $sum_all+=$sub_category_addition_price;
    }
    return $sum_all;
}

// Get Total Names Of Additions For Each Size
        function get_removes_names_by_id($removes_id) {

            global $con;

            $get_removes_id = explode(',', $removes_id);

            foreach ($get_removes_id AS $rem_id) {

                $query_removes = $con->query("SELECT * FROM `removes` WHERE `id`='$rem_id' ORDER BY `id` DESC");

                $row_remove = mysqli_fetch_assoc($query_removes);

                echo $remove_name = $row_remove['title'] . " + ";
            }
        }



// Get Total Names Of Additions For Each Size
function get_size_additions_names_by_id($additions_id) {

    global $con;

    $get_additions_id = explode(',', $additions_id);

    foreach ($get_additions_id AS $add_id) {

        $query_addition = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`='$add_id' ORDER BY `sub_category_addition_price_id` DESC");

        $row_addition = mysqli_fetch_assoc($query_addition);

        echo $additions_name = $row_addition['sub_category_addition_name'] . " + ";
    }
}

// Get Total Amount For Client Orders 
        function get_order_total_price_by_id($order_id) {

            global $con;

            $mos = array();

            $query_total = $con->query("SELECT * FROM `order_size_price` LEFT JOIN `sub_categories_size_prices` ON `order_size_price`.`sub_category_size_price_id` = `sub_categories_size_prices`.`sub_category_size_price_id` 
	WHERE `order_size_price`.`order_id`='" . $order_id . "' ORDER BY `order_size_price_id` DESC");

            while ($row_total = mysqli_fetch_assoc($query_total)) {

                $mos[] = $row_total['sub_category_size_price'];

                $additions_id = $row_total['additions_id'];

                $additions_total_amounts = get_size_additions_by_id_for_admin($additions_id);

                $additions_total_amount[] = $additions_total_amounts[0];
            }
            
            $total = array_sum($mos) + array_sum($additions_total_amount);
            echo $total;
        }

        function totalPrice($order_id) {
            global $con;

            $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");

            while ($row_select = mysqli_fetch_assoc($query_select)) {

                $cart_id = $row_select['cart_id'];


                $carts_array = explode(",", $cart_id);
                $result = count($carts_array);
                $price = 0;
                foreach ($carts_array as $one_cart) {
                    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' ORDER BY `cart_id` LIMIT 1");

                    $row_select = mysqli_fetch_array($query_select);

                    $price += $row_select['price'];
                }
                return $price;
            }
        }

        if (isset($_POST['verify'])) {

            include("../connection.php");

            $verify = $_POST['verify'];
            $client_id = $_POST['client_id'];

            $query = $con->query("UPDATE `orders` SET `order_status`=1 , `order_follow`=1 WHERE `order_id`='$verify'");

            //ارسال اشعار للعميل
            $devicesArray = " SELECT device_token.*,devices.* from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE devices.client_id='{$client_id}' and devices.login =1";
            $query_devicesArray = $con->query($devicesArray);
            $devicesArray_count = mysqli_num_rows($query_devicesArray);
            if ($devicesArray_count > 0) {
                while ($v = mysqli_fetch_assoc($query_devicesArray)) {
                    if ($v['device_token_id']) {
                        $data = array();
                        $data['title'] = 'Your order Approved';
                        $data['client_id'] = $client_id;
                        $data['type'] = 'order';

                        $addNotSend['client_id'] = $client_id;
                        $addNotSend['text'] = 'Your order Approved';
                        $addNotSend['type'] = 'order';
                        $addNotSend['text_id'] = $verify;

                        $params = array("pushtype" => $v['type'], "registration_id" => $v['device_token'], "data" => $data);
                        $rtn = sendMessage($params, $addNotSend);
                    }
                }
            } else {
                $params = array("client_id" => $client_id, "type" => 'order', "text_id" => $verify, 'text' => 'تم إعتماد طلبك ');
                $sendnotify = insertIntoNotSend($params);
            }
            if ($query) {
                // echo get_success("تم التفعيل بنجاح");
            }
        }

        if (isset($_POST['cancel_verify'])) {

            include("../connection.php");

            $cancel_verify = $_POST['cancel_verify'];
            $client_id = $_POST['client_id'];

            $query = $con->query("UPDATE `orders` SET `order_status`=2,`order_follow`='0' WHERE `order_id`='$cancel_verify'");

            //ارسال اشعار للعميل
            $devicesArray = " SELECT device_token.*,devices.* from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE devices.client_id='{$client_id}' and devices.login =1";
            $query_devicesArray = $con->query($devicesArray);
            $devicesArray_count = mysqli_num_rows($query_devicesArray);
            if ($devicesArray_count > 0) {
                while ($v = mysqli_fetch_assoc($query_devicesArray)) {


                    if ($v['device_token_id']) {
                        $data = array();
                        $data['title'] = 'Your order Cancelled';
                        $data['client_id'] = $client_id;
                        $data['type'] = 'order';

                        $addNotSend['client_id'] = $client_id;
                        $addNotSend['text'] = 'Your order Cancelled';
                        $addNotSend['type'] = 'order';
                        $addNotSend['text_id'] = $cancel_verify;

                        $params = array("pushtype" => $v['type'], "registration_id" => $v['device_token'], "data" => $data);
                        $rtn = sendMessage($params, $addNotSend);
                    }
                }
            } else {
                $params = array("client_id" => $client_id, "type" => 'order', "text_id" => $cancel_verify, 'text' => 'Your order Cancelled');
                $sendnotify = insertIntoNotSend($params);
            }
            if ($query) {
//        echo get_success("تم إلغاء الإعتماد بنجاح");
            }
        }
        if (isset($_POST['edit_follow']) && isset($_POST['order_id'])) {

            include("../connection.php");

            $edit_follow = $_POST['edit_follow'];
            $order_id = $_POST['order_id'];
            $client_id = $_POST['client_id'];
            $deliver_type = $_POST['deliver_type'];

            $query = $con->query("UPDATE `orders` SET `order_follow`='$edit_follow' WHERE `order_id`='$order_id'");

            //ارسال اشعار للعميل
            $devicesArray = " SELECT device_token.*,devices.* from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE devices.client_id='{$client_id}' and devices.login =1";
            $query_devicesArray = $con->query($devicesArray);
            $devicesArray_count = mysqli_num_rows($query_devicesArray);
            if ($devicesArray_count > 0) {
                while ($v = mysqli_fetch_assoc($query_devicesArray)) {


                    if ($v['device_token_id']) {
                        $data = array();
                        if ($edit_follow == '2') {
                            if ($deliver_type != 1) {
                                $data['title'] = 'Your order under processing';
                            } else {
                                $data['title'] = 'Your order with the delivery man';
                            }
                        } elseif ($edit_follow == '3') {
                            $data['title'] = 'Your order has been Delivered';
                        } elseif ($edit_follow == '1') {
                            $data['title'] = 'Your order under processing';
                        }

                        $data['msgcnt'] = '1';
                        $data['client_id'] = $client_id;
                        $data['type'] = 'order';

                        $addNotSend['client_id'] = $client_id;
                        if ($edit_follow == '2') {
                            if ($deliver_type != 1) {
                                $addNotSend['text'] = 'Your order under processing';
                            } else {
                                $addNotSend['text'] = 'Your order with the delivery man';
                            }
                        } elseif ($edit_follow == '3') {
                            $addNotSend['text'] = 'Your order has been Delivered';
                        } elseif ($edit_follow == '1') {
                            $addNotSend['text'] = 'Your order under processing';
                        }
                        $addNotSend['type'] = 'order';
                        $addNotSend['text_id'] = $order_id;


                        $params = array("pushtype" => $v['type'], "registration_id" => $v['device_token'], "data" => $data);
                        $rtn = sendMessage($params, $addNotSend);
                    }
                }
            } else {
                if ($edit_follow == '2') {
                    if ($deliver_type != 1) {
                        $text = 'Your order under processing';
                    } else {
                        $text = 'Your order with the delivery man';
                    }
                } elseif ($edit_follow == '3') {
                    $text = 'Your order has been Delivered';
                } elseif ($edit_follow == '1') {
                    $text = 'Your order has been Delivered';
                }
                $params = array("client_id" => $client_id, 'text' => $text, 'type' => 'order', 'text_id' => $order_id);
                $sendnotify = insertIntoNotSend($params);
            }
        }

        function sendMessageAndroid($registration_id, $params) {

            define('API_ACCESS_KEY', 'AAAA26ezoU0:APA91bEbGWwazNv4fGErTIknZfwSubhX8t28qSAQX6EWu_-TEvnrTDAwlSULemuOUMvDUPkHGxPSI0zMcZKNGRvJI_06beKNiyR9PPE5LIw5xlvnTwsjS4AP5ZDO5SF010w9iNjt8Hbe');
            $registrationIds = array($registration_id);
            $msg = array
                (
                'message' => $params['data']['title'],
                'type' => $params['data']['type'],
                'title' => 'Alert',
                'subtitle' => 'Alert message!',
                'vibrate' => 1,
                'sound' => 'default',
                'largeIcon' => 'large_icon',
                'smallIcon' => 'small_icon'
            );

            $fields = array
                (
                'registration_ids' => $registrationIds,
                'data' => $msg
            );

            $headers = array
                (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send'); //For firebase, use https://fcm.googleapis.com/fcm/send

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }

        function sendMessageIos($registration_id, $params) {

            $url = "https://fcm.googleapis.com/fcm/send";

            $serverKey = 'AAAA26ezoU0:APA91bEbGWwazNv4fGErTIknZfwSubhX8t28qSAQX6EWu_-TEvnrTDAwlSULemuOUMvDUPkHGxPSI0zMcZKNGRvJI_06beKNiyR9PPE5LIw5xlvnTwsjS4AP5ZDO5SF010w9iNjt8Hbe';
            $title = "";
            $body = $params['data']['title'];
            $type = $params['data']['type'];
            $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');
            $data = array('type' => $type);
            $arrayToSend = array('to' => $registration_id, 'notification' => $notification, 'priority' => 'high', "data" => $data);
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key=' . $serverKey;
            $ch = curl_init();



            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send'); //For firebase, use https://fcm.googleapis.com/fcm/send

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            //Send the request
            $response = curl_exec($ch);
            //Close request
            if ($response === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            // echo die(var_dump($response));
            return $response;
        }

        /**
         * Send message to SmartPhone
         * $params [pushtype, msg, registration_id]
         */
        function sendMessage($params, $addNotSend) {
            global $con;


            if ($params["registration_id"] && $params["data"]) {
                switch ($params["pushtype"]) {
                    case "ios":
                        $ress = sendMessageIos($params["registration_id"], $params);
                        if ($addNotSend['type'] != 'message') {
                            insertIntoNotSend($addNotSend);
                        }
                        break;
                    case "android":
                        $ress = sendMessageAndroid($params["registration_id"], $params);
                        $ress = json_decode($ress);
                        if ($ress) {
                            if ($ress->success == 0) {
                                updateDevices($params['data']['client_id'], $params["registration_id"]);
                            }
                            if ($addNotSend['type'] != 'message') {
                                insertIntoNotSend($addNotSend);
                            }
                        }
                        break;
                }
            }
        }

        function updateDevices($client_id, $device_token) {
            //    echo 'osama';
            global $con;

            if ($device_token) {
                $sql = " SELECT * ";
                $sql .= " FROM `device_token` where `device_token`='{$device_token}' limit 1 ";
                $query = $con->query($sql);
                $row_select = mysqli_fetch_array($query);
                $id = $row_select['id'];
            }
            if (mysqli_num_rows($query) > 0) {
                $sql = "UPDATE  `devices` SET ";
                $sql .= "`login`='0',";
                $sql .= "`date_added`='" . date('Y-m-d H:i:s') . "'";
                $sql .= " WHERE `device_token_id`='{$id}' ";
                $sql .=" and `client_id`='{$client_id}'";
//        echo '5555' . $sql . "<hr>";
                return $con->query($sql);
            }
        }

        function insertIntoNotSend($temp) {
            global $con;
            $sql = "SELECT * FROM `notifications` WHERE ";
            $sql.=" `client_id`='" . $temp['client_id'] . "' AND ";
            $sql.=" `text_id`='" . $temp['text_id'] . "' AND ";
            $sql.=" `text`='" . $temp['text'] . "' AND ";
            $sql.=" `type`='" . $temp['type'] . "'";
            $res = $con->query($sql);
            $notifications_count = mysqli_num_rows($res);
            if ($notifications_count == 0) {
                $sql = "INSERT INTO `notifications` SET  `client_id`='" . $temp['client_id'] . "' ,`text`='" . $temp['text'] . "',`type`='" . $temp['type'] . "',`text_id`='" . $temp['text_id'] . "',`date`='" . date('Y-m-d H:i:s') . "'";
                $res = $con->query($sql);
                return mysqli_insert_id($con);
            }
        }

        function get_device_type_by_client_id($client_id) {

            global $con;

            $queryB = $con->query("SELECT * FROM `devices` WHERE `client_id`='$client_id' ORDER BY `id` DESC limit 1");
            $row_select = mysqli_fetch_array($queryB);
            $device_token_id = $row_select['device_token_id'];

            $queryc = $con->query("SELECT * FROM `device_token` WHERE `id`='$device_token_id' ORDER BY `id` DESC limit 1");
            $row_select_2 = mysqli_fetch_array($queryc);
            $type = $row_select_2['type'];

            return $type;
        }

        if (isset($_POST['remove_order_id'])) {

            include("../connection.php");

            $order_id = $_POST['remove_order_id'];
            $delete_reason = $_POST['delete_reason'];

            $cart_id = $row_select['cart_id'];
            $con->query("INSERT INTO `order_delete_reason` VALUES (null,'$order_id','$delete_reason','" . date("Y-m-d H:i:s") . "')");

            $query = $con->query("UPDATE `orders` SET `del`='1',`date_del`='" . date("Y-m-d") . "' WHERE `order_id`='$order_id'");

            if ($query) {
                echo get_success("Deleted Successfully");
            }
        }
        ?>