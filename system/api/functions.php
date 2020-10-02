<?php

function send_email($order_id, $client_id, $client_address_id, $branch_id) {
    $query_select = mysql_query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");

    $row_select = mysql_fetch_array($query_select);

    $cart_id = $row_select['cart_id'];
    $order_id = $row_select['order_id'];
    $payment = $row_select['payment'];
    $client_id = $row_select['client_id'];
    $client_address_id = $row_select['client_address_id'];
    $charge_cost = number_format($row_select['charge_cost'], 3, '.', '');
    $total_price = number_format($row_select['total_price'], 3, '.', '');
    $net_price = number_format($row_select['net_price'], 3, '.', '');

    $discount_percentage_number = $row_select['discount_percentage'];

    $discount_percentage = number_format($row_select['discount_percentage'], 3, '.', '');

    $discount_value = strval(($discount_percentage_number / 100) * $total_price);

    $total_after_discount = $row_select['total_price'] - $discount_value;

    $vat = number_format($row_select['vat'], 3, '.', '');
    $message = '
                
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Automatic Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin:0; padding:10px 0 0 0;" bgcolor="#FFFFFF">

<table align="center" cellpadding="0" cellspacing="0" width="95%%" style="padding:15px;">
    <tr>
        <td align="center">
            <table align="center" border="1" cellpadding="0" cellspacing="0" width="600px" style="margin:15px;padding:15px;border-collapse: separate; border-spacing: 5px 5px; #000;" bgcolor="#FFFFFF">
                <tr>
                    <td align="center" style="padding:5px;">
                        <a href="http://aljazeeraroastery.com/" target="_blank">
                            <img src="http://aljazeeraroastery.com/system/api/logo.jpg" alt="Logo" style="width:186px;border:0;"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding:30px 0;">
                        <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:15px;text-align:left;direction:ltr;">
                            <tr>
                                <td style="padding:0; font-family: Avenir, sans-serif; font-size: 16px;">
                                    <!-- Initial text goes here-->
                                    <h2 style="text-align:center;color:#31A4F1;font-family:tahoma;">Your Order Summary From Al Jazeera Roastery App Branch -  ' . get_branch_name_en($branch_id) . '</h2>

                                  <br/>
                                  <table style="border:1px solid #eee;padding: 5px;width: 100%;text-align: center;margin-bottom: 30px;" class="table table-striped">
	                                  <thead>
                                            <th style="width: 40%;font-size: 14px;font-weight: bold;font-family: tahoma;">Item</th>
                                            <th style="width: 40%;font-size: 14px;font-weight: bold;font-family: tahoma;">Quantity</th>
                                            <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">Total</th>
	                                 </thead>
	                                  <tbody>';
    $client_addresses_query = mysql_query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id'") or die(mysql_error());
    $client_addresses_row_select = mysql_fetch_array($client_addresses_query);

    //  $total_price = 0;
    $cart_id_all = explode(',', $cart_id);

    foreach ($cart_id_all as $one) {
        $cart = mysql_query("SELECT * FROM `cart` WHERE `cart_id`='$one'") or die(mysql_error());
        $row_select = mysql_fetch_array($cart);
        $sub_category_id = $row_select['sub_category_id'];
        $quantity = $row_select['quantity'];
        $price = $row_select['price'];
        $query_select_two = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` DESC");
        $row_select_two = mysql_fetch_assoc($query_select_two);
        $sub_category_name = $row_select_two['sub_category_name'];

        $message .= '<tr style="border: 1px solid black;">';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $sub_category_name . '</td>';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $quantity . '</td>';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $price . ' BD</td>';
        $message .= '</tr>';
    }

    $message .= '</tbody></table>

                        
                                
                                  <table style="border:1px solid #eee;padding: 5px;width: 100%%; text-align: center;margin-bottom: 30px;" class="table table-striped">
	                                  <thead>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">#</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">Name</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">Phone</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">Region</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">Block</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">Road</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">Building</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">Flat</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">Notes</th>
	                                  </thead>
	                                  <tbody>
	                                  	<tr style="border: 1px solid black;">
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $order_id . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;"> ' . get_client_name_from_id($client_id) . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . get_client_phone_from_id($client_id) . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . get_region_name_en($client_addresses_row_select['region']) . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $client_addresses_row_select['block'] . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $client_addresses_row_select['road'] . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;"> ' . $client_addresses_row_select['building'] . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;"> ' . $client_addresses_row_select['flat_number'] . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $client_addresses_row_select['note'] . '</td>
	                                  	</tr>     
	                                  </tbody>
                                  </table>                                  

                                  <table style="border:1px solid #eee;padding: 5px;width: 100%%; text-align: center;margin-bottom: 30px;" class="table table-striped">
	                                  <thead>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">Total</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">Discount</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">After Dis</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">VAT</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">Delivery Fees</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">Net Total</th>
	                                  </thead>
	                                  <tbody>
	                                  	<tr style="border: 1px solid black;">
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ( ( $total_price )), 3, '.', '') . ' BD </td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $discount_percentage_number . '  %</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ( ( $total_after_discount )), 3, '.', '') . '  BD </td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ( (($vat ))), 3, '.', '') . ' BD </td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ( ( $charge_cost)), 3, '.', '') . ' BD </td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ( ( $net_price )), 3, '.', '') . ' BD </td>
	                                  	</tr>     
	                                  </tbody>
                                  </table>
                                
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
          
                <tr>
                    <td bgcolor="#FFFFFF">
                        <table cellpadding="0" cellspacing="0" width="100%%" style="padding:10px;">
                            <tr>
                                <td width="260" valign="top" style="padding: 0 0 15px 0;">
                                    <table cellpadding="0" cellspacing="0" width="100%%">
                                        <tr>
                                            <td align="center">
                                                <a href="#" target="_blank">
                                                    <img src="http://aljazeeraroastery.com/system/api/phone-icon.jpeg" alt="Contact Us"
                                                         style="display: block;"/>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-family: tahoma; font-weight:bold; color:#707070;font-size: 13px;padding: 10px 0 0 0;">
                                                Contact Us
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="font-size: 0; line-height: 0;" width="20">
                                    &nbsp;
                                </td>
                                <td width="260" valign="top">
                                    <table cellpadding="0" cellspacing="0" width="100%%" >
                                        <tr>
                                            <td align="center">
                                                <a href="#">
                                                    <img src="http://aljazeeraroastery.com/system/api/email-icon.jpeg" alt="Email us"
                                                         style="display: block;"/>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-family: tahoma; font-weight:bold; color:#707070;font-size: 13px;padding: 10px 0 0 0;">
                                                Email Us
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="font-size: 0; line-height: 0;" width="20">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#FFFFFF" style="padding: 15px 15px 15px 15px;">
                        <table cellpadding="0" cellspacing="0" width="100%%">
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <a href="#" target="_blank">
                                                    <img src="http://aljazeeraroastery.com/system/api/facebook-icon.jpeg" alt="Facebook" width="50" height="50" style="display: block;"/>
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td>
                                                <a href="#" target="_blank">
                                                    <img src="http://aljazeeraroastery.com/system/api/instagram-icon.jpeg" alt="Instagram" width="50" height="50"style="display: block;"/>
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td>
                                                <a href="#" target="_blank">
                                                    <img src="http://aljazeeraroastery.com/system/api/twitter-icon.jpeg" alt="Twitter" width="50" height="50"style="display: block;"/>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>';


    return $message;
}

function most_request_sub($client_id, $lang) {
    $result = mysql_query("SELECT * FROM `most_request_sub`  ORDER BY `id` DESC") or die(mysql_error());
    $data = array();
    while ($row = mysql_fetch_assoc($result)) {
        // temp user array
        $product = array();
        $sizes_response = array();
        $sub_category_id = $row['sub_category_id'];
        $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' and `display`=1 order by sub_category_id ASC LIMIT 1") or die(mysql_error());

        while ($row = mysql_fetch_array($result)) {
            $product["sub_category_id"] = $row["sub_category_id"];
            if ($lang == "ar") {
                $product["sub_category_name"] = $row["sub_category_name_ar"];
                $product["sub_category_desc"] = $row["sub_category_desc_ar"];
            } else {
                $product["sub_category_name"] = $row["sub_category_name"];
                $product["sub_category_desc"] = $row["sub_category_desc"];
            }
            $product["sub_category_image"] = $row["sub_category_image"];

            $product["parent_category_id"] = $row["parent_category_id"];
            $sub_category_id = $row["sub_category_id"];
            $product["evaluate"] = resume_evaluate($sub_category_id);

            $result_zero = mysql_query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='$client_id'") or die(mysql_error());
            if (mysql_fetch_array($result_zero) >= 1) {
                $product["sub_category_fav"] = 1;
            } else {
                $product["sub_category_fav"] = 0;
            }

            $product["sizes"] = get_sizes($lang, $sub_category_id);
            $data[] = $product;
        }
    }

    return $data;
}

function get_sub_category_by_id($sub_category_id, $client_id, $lang) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' and `display`=1 order by sub_category_id desc") or die(mysql_error());
    $data = array();

    while ($row = mysql_fetch_array($result)) {

        // temp user array
        $product = array();
        $product["sub_category_id"] = $row["sub_category_id"];
        if ($lang == "ar") {
            $product["sub_category_name"] = $row["sub_category_name_ar"];
            $product["sub_category_desc"] = $row["sub_category_desc_ar"];
        } else {
            $product["sub_category_name"] = $row["sub_category_name"];
            $product["sub_category_desc"] = $row["sub_category_desc"];
        }
        $product["sub_category_image"] = $row["sub_category_image"];
        $product["parent_category_id"] = $row["parent_category_id"];
        $sub_category_id = $row["sub_category_id"];
        $product["evaluate"] = resume_evaluate($sub_category_id);

        $result_zero = mysql_query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='$client_id'") or die(mysql_error());
        if (mysql_fetch_array($result_zero) >= 1) {
            $product["sub_category_fav"] = 1;
        } else {
            $product["sub_category_fav"] = 0;
        }

        $data[] = $product;
    }


    return $data;
}

function sub_monthes($client_id, $lang) {
    $result = mysql_query("SELECT * FROM `sub_monthes`  ORDER BY `id` DESC") or die(mysql_error());
    $data = array();
    while ($row = mysql_fetch_assoc($result)) {
        $sub_category_id = $row['sub_category_id'];
        $row['sub_category_data'] = get_sub_category_by_id($sub_category_id, $client_id, $lang);
        $data[] = $row;
    }

    return $data;
}

function get_parent_categories($lang) {
    $result = mysql_query("SELECT * FROM `parent_categories` where `display`=1 order by `arrangement` asc") or die(mysql_error());
    $data = array();
    while ($row = mysql_fetch_assoc($result)) {

        if ($lang == "ar") {
            $row["parent_category_name"] = $row["parent_category_name_ar"];
            $row["parent_category_desc"] = $row["parent_category_desc_ar"];
        } else {
            $row["parent_category_name"] = $row["parent_category_name"];
            $row["parent_category_desc"] = $row["parent_category_desc"];
        }
        unset($row["parent_category_name_ar"]);
        unset($row["parent_category_desc_ar"]);

        $data[] = $row;
    }

    return $data;
}

function getParentData($id) {
    $result = mysql_query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$id' ") or die(mysql_error());
    return mysql_fetch_assoc($result);
}

function get_slider() {
    $result_slider = mysql_query("SELECT * FROM `slider`  ORDER BY `id` DESC");
    $data = array();
    while ($row_slider = mysql_fetch_array($result_slider)) {

        $sub_category_id = $row_slider['product_id'];
        $slider_image = $row_slider['image'];

        $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' and `display`=1 order by sub_category_id ASC LIMIT 1") or die(mysql_error());

        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $product = array();
            $sizes_response = array();

            $product["sub_category_id"] = $row["sub_category_id"];
            if ($lang == "ar") {
                $product["sub_category_name"] = $row["sub_category_name_ar"];
                $product["sub_category_desc"] = $row["sub_category_desc_ar"];
            } else {
                $product["sub_category_name"] = $row["sub_category_name"];
                $product["sub_category_desc"] = $row["sub_category_desc"];
            }
            $product["sub_category_image"] = $slider_image;
            $product["parent_category_id"] = $row["parent_category_id"];
            $sub_category_id = $row["sub_category_id"];
            $product["evaluate"] = resume_evaluate($sub_category_id);

            $result_zero = mysql_query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='$client_id'") or die(mysql_error());
            if (mysql_fetch_array($result_zero) >= 1) {
                $product["sub_category_fav"] = 1;
            } else {
                $product["sub_category_fav"] = 0;
            }
            $product["sizes"] = get_sizes($lang, $sub_category_id);
            $product["slider_image"] = $slider_image;


            $data[] = $product;
        }
    }
    return $data;
}

function get_latest_products($lang) {

    $result_latest = mysql_query("SELECT * FROM `latest`  ORDER BY `id` DESC") or die(mysql_error());
    $data = array();
    while ($row_latest = mysql_fetch_assoc($result_latest)) {
        $sub_category_id = $row_latest['product_id'];

        $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' and `display`=1 order by sub_category_id ASC LIMIT 1") or die(mysql_error());

        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $product = array();
            $sizes_response = array();

            $product["sub_category_id"] = $row["sub_category_id"];
            if ($lang == "ar") {
                $product["sub_category_name"] = $row["sub_category_name_ar"];
                $product["sub_category_desc"] = $row["sub_category_desc_ar"];
            } else {
                $product["sub_category_name"] = $row["sub_category_name"];
                $product["sub_category_desc"] = $row["sub_category_desc"];
            }
            $product["sub_category_image"] = $row["sub_category_image"];

            $product["parent_category_id"] = $row["parent_category_id"];
            $sub_category_id = $row["sub_category_id"];
            $product["evaluate"] = resume_evaluate($sub_category_id);

            $result_zero = mysql_query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='$client_id'") or die(mysql_error());
            if (mysql_fetch_array($result_zero) >= 1) {
                $product["sub_category_fav"] = 1;
            } else {
                $product["sub_category_fav"] = 0;
            }


            $product["sizes"] = get_sizes($lang, $sub_category_id);


            $data[] = $product;
        }
    }



    return $data;
}

function get_sizes($lang, $sub_category_id) {

    $query_orders = mysql_query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_id`='$sub_category_id'");
    $data = array();
    while ($row = mysql_fetch_assoc($query_orders)) {

        $sizes["sub_category_size_price_id"] = $row["sub_category_size_price_id"];

        if ($lang == "ar") {
            $sizes["sub_category_size_name"] = $row["sub_category_size_name_ar"];
        } else {
            $sizes["sub_category_size_name"] = $row["sub_category_size_name"];
        }

        $sub_category_size_price = $row["sub_category_size_price"];
        $sizes["sub_category_size_price"] = number_format((float) ( $sub_category_size_price), 3, '.', '');

        $sizes["sub_category_id"] = $row["sub_category_id"];

        $data[] = $sizes;
    }


    return $data;
}

function check_vat() {

    $result = mysql_query("SELECT * FROM `setting` WHERE `id`=1  ORDER BY `id` DESC limit 1") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $vat = $row['vat'];

    return $vat;
}

function get_cart_id($order_id) {

    $result = mysql_query("SELECT * FROM `orders` WHERE `order_id`='$order_id' ORDER BY `order_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $cart_id = $row['cart_id'];

    return $cart_id;
}

function get_branch_name($branche_id) {

    $result = mysql_query("SELECT * FROM `branches` WHERE `id`='$branche_id' ORDER BY `id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $name = $row['name_ar'];

    return $name;
}


function get_branch_name_en($branche_id) {

    $result = mysql_query("SELECT * FROM `branches` WHERE `id`='$branche_id' ORDER BY `id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $name = $row['name'];

    return $name;
}

function resume_evaluate($sub_category_id) {

    $sql = "SELECT * from `sub_category_comments` WHERE `sub_category_id`='$sub_category_id'";
    $result = mysql_query($sql);
    $count_evaluate = mysql_num_rows($result);
    $sum = 0;
    $evaluate = 0;
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            // temp client array
            $rate = $row['rate'];
            $sum+=$rate;
        }
        $evaluate = $sum / $count_evaluate;
    }
    return $evaluate;
}

function get_client_id_phone($client_phone) {

    $result = mysql_query("SELECT * FROM `clients` WHERE `client_phone`='$client_phone' ORDER BY `client_id` DESC LIMIT 1 ") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $data = $row['client_id'];

    return $data;
}

function get_net_price($order_id) {

    $result = mysql_query("SELECT * FROM `orders` WHERE `order_id`='$order_id' ORDER BY `order_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $net_price = $row['net_price'];

    return $net_price;
}

function check_sub_category_comment($client_id, $sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_category_comments` WHERE `client_id`='$client_id' and `sub_category_id`='$sub_category_id'  ORDER BY `comment_id` DESC") or die(mysql_error());

    if (mysql_fetch_array($result) >= 1) {

        return 1;
    }
}

function check_discount() {

    $result = mysql_query("SELECT * FROM `setting` WHERE `id`=1  ORDER BY `id` DESC limit 1") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $discount = $row['discount'];

    return $discount;
}

function check_branch_avaliable_delivery($branche_id) {

    $result = mysql_query("SELECT * FROM `branches` WHERE `id`='$branche_id'  ORDER BY `id` DESC limit 1") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $display = $row['display'];

    return $display;
}

function get_discount_percentage() {

    $result = mysql_query("SELECT * FROM `setting` WHERE `id`=1  ORDER BY `id` DESC limit 1") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $discount_percentage = $row['discount_percentage'];

    return $discount_percentage;
}

function get_branch() {

    $result = mysql_query("SELECT * FROM `setting` WHERE `id`=1  ORDER BY `id` DESC limit 1") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $branch_id = $row['branch_id'];

    return $branch_id;
}

function check_register_phone($client_phone) {
    global $con ;

    $result = mysqli_query($con ,"SELECT * FROM `clients` WHERE `client_phone`='$client_phone' ORDER BY `client_id` DESC") or die(mysqli_error($con));

    $row = mysql_fetch_array($result);

    $client_phone = $row['client_phone'];

    return $client_phone;
}

function get_branch_from_region_id($region_id) {

    $result = mysql_query("SELECT * FROM `branches_regions` WHERE `region_id`='$region_id' ORDER BY `id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $branche_id = $row['branche_id'];

    return $branche_id;
}

function check_register($client_email) {

    $result = mysql_query("SELECT * FROM `clients` WHERE `client_email`='$client_email' ORDER BY `client_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $client_email = $row['client_email'];

    return $client_email;
}

function get_remove_name($remove_id) {

    $result = mysql_query("SELECT * FROM `removes` WHERE `id`='$remove_id' ") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $title = $row['title'];

    return $title;
}

function get_remove_name_ar_from_id($remove_id) {

    $result = mysql_query("SELECT * FROM `removes` WHERE `id`='$remove_id' ") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $title = $row['title_ar'];

    return $title;
}

function get_remove_name_from_id($remove_id) {

    $result = mysql_query("SELECT * FROM `removes` WHERE `id`='$remove_id' ") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $title = $row['title'];

    return $title;
}

function get_category_name_from_id($category_id) {

    $result = mysql_query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$category_id' ") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $parent_category_name = $row['parent_category_name'];

    return $parent_category_name;
}

function get_category_type_from_id($category_id) {

    $result = mysql_query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$category_id' ") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $type = $row['type'];

    return $type;
}

function check_token($device_token, $client_id) {

    $devicesArray = " SELECT device_token.*,devices.* from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE device_token.device_token='$device_token' and devices.client_id='{$client_id}'";
    $query_devicesArray = mysql_query($devicesArray);


    return mysql_num_rows($query_devicesArray);
}

function check_item_fav($client_id, $sub_category_id) {

    $result = mysql_query("SELECT * FROM `client_fav` WHERE `client_id`='$client_id' AND `sub_category_id`='$sub_category_id' ORDER BY `fav_id` DESC") or die(mysql_error());

    if (mysql_fetch_array($result) >= 1) {

        return 1;
    }
}

function check_category_exist($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());
    $row = mysql_fetch_array($result);
    $parent_category_id = $row['parent_category_id'];
    $result_1 = mysql_query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' ORDER BY `parent_category_id` DESC") or die(mysql_error());
    $row_1 = mysql_fetch_array($result_1);
    $display = $row_1['display'];
    return $display;
}

function get_parent_category_by_sub_category_id($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $parent_category_id = $row['parent_category_id'];

    return $parent_category_id;
}

function check_sub_category_exist($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $display = $row['display'];

    return $display;
}

function totalPrice($order_id) {
    $query_select = mysql_query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");

    while ($row_select = mysql_fetch_array($query_select)) {

        $cart_id = $row_select['cart_id'];


        $carts_array = explode(",", $cart_id);
        $result = count($carts_array);
        $price = 0;
        foreach ($carts_array as $one_cart) {
            $query_select = mysql_query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' ORDER BY `cart_id` LIMIT 1");

            $row_select = mysql_fetch_array($query_select);

            $price += $row_select['price'];
        }
        return $price;
    }
}

function orderPrice($cart_id) {
    $carts_array = explode(",", $cart_id);
    $price = 0;
    foreach ($carts_array as $one_cart) {
        $query_select = mysql_query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' ORDER BY `cart_id` LIMIT 1");
        $row_select = mysql_fetch_array($query_select);
        $price += $row_select['price'];
    }
    return $price;
}

function get_region_id($client_id, $client_address_id) {

    $result = mysql_query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id' and `client_id`='$client_id' ORDER BY `client_address_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $region = $row['region'];

    return $region;
}

function get_charge($region_id) {

    $result = mysql_query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $charge = $row['charge'];

    return $charge;
}

function get_min_order($region_id) {

    $result = mysql_query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $min_order = $row['min_order'];

    return $min_order;
}

function get_region_name($region_id) {

    $result = mysql_query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $region_name_ar = $row['region_name_ar'];

    return $region_name_ar;
}

function get_region_name_en($region_id) {

    $result = mysql_query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $region_name_en = $row['region_name_en'];

    return $region_name_en;
}

function get_sub_category_name_from_id($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_name = $row['sub_category_name'];

    return $sub_category_name;
}

function get_sub_category_desc_from_id($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_desc = $row['sub_category_desc'];

    return $sub_category_desc;
}

function get_sub_category_name_ar_from_id($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_name = $row['sub_category_name_ar'];

    return $sub_category_name;
}

function get_sub_category_desc_ar_from_id($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_desc = $row['sub_category_desc_ar'];

    return $sub_category_desc;
}

function get_sub_category_image_from_id($sub_category_id) {

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_image = $row['sub_category_image'];

    return $sub_category_image;
}

function get_client_name_from_id($client_id) {

    $result = mysql_query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $client_name = $row['client_name'];

    return $client_name;
}

function get_client_phone_from_id($client_id) {

    $result = mysql_query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $client_phone = $row['client_phone'];

    return $client_phone;
}

function get_client_id_from_phone($client_phone) {

    $result = mysql_query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $client_id = $row['client_id'];

    return $client_id;
}

function get_size_name_from_id($size_id) {

    $result = mysql_query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_size_name = $row['sub_category_size_name'];

    return $sub_category_size_name;
}

function get_size_name_ar_from_id($size_id) {

    $result = mysql_query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_size_name = $row['sub_category_size_name_ar'];

    return $sub_category_size_name;
}

function get_size_price_from_id($size_id) {

    $result = mysql_query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_size_price = $row['sub_category_size_price'];

    return $sub_category_size_price;
}

function get_addition_name_from_id($addition_id) {

    $result = mysql_query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`='$addition_id' ORDER BY `sub_category_addition_price_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_addition_name = $row['sub_category_addition_name'];

    return $sub_category_addition_name;
}

function get_addition_name_ar_from_id($addition_id) {

    $result = mysql_query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`='$addition_id' ORDER BY `sub_category_addition_price_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_addition_name = $row['sub_category_addition_name_ar'];

    return $sub_category_addition_name;
}

function get_addition_price_from_id($addition_id) {

    $result = mysql_query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`='$addition_id' ORDER BY `sub_category_addition_price_id` DESC") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $sub_category_addition_price = $row['sub_category_addition_price'];

    return $sub_category_addition_price;
}

function get_client_cart_total_amount($client_id) {

    $total = array();

    $result = mysql_query("SELECT * FROM `cart` WHERE `client_id`='$client_id' AND `status`=0 ORDER BY `cart_id` DESC") or die(mysql_error());

    while ($row = mysql_fetch_array($result)) {

        $price = $row['price'];

        $quantity = $row['quantity'];

        $total[] = $price;
    }

    $total_amount = array_sum($total);

    return $total_amount;
}

function check_if_sub_special_offer($sub_id) {

    $total = array();

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `parent_category_id`='16' AND `sub_category_id`='$sub_id' ") or die(mysql_error());

    $total = mysql_num_rows($result);

    return $total;
}

function get_client_cart_id($client_id) {

    $get_cart_id = array();

    $result = mysql_query("SELECT * FROM `cart` WHERE `client_id`='$client_id' AND `status`=0 ORDER BY `cart_id` DESC") or die(mysql_error());

    while ($row = mysql_fetch_array($result)) {

        $cart_id = $row['cart_id'];

        $get_cart_id[] = $cart_id;
    }

    $cart_id_final = implode($get_cart_id, ',');

    return $cart_id_final;
}
?>