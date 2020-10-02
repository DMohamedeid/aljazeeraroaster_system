<?php

function check_product_comment($client_id, $sub_category_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `sub_category_comments` WHERE `client_id`='$client_id' and `sub_category_id`='$sub_category_id'  ORDER BY `comment_id` DESC") or die(mysql_error());

    if (mysqli_fetch_array($result) >= 1) {

        return 1;
    }
}

function get_remove_by_id($remove_id) {
    global $con;

    $result = $con->query("SELECT * FROM `removes` WHERE `id`='$remove_id' ") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    return $row;
}

function get_addition_by_id($addition_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_size_price_id`='$addition_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    return $row;
}

function get_addition_price_id($addition_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_size_price_id`='$addition_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysqli_error());
    $row = mysqli_fetch_array($result);

    $addition_price = $row['sub_category_size_price'];

    return $addition_price;
}

function get_region_name($region_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $region_name = $row['region_name_ar'];

    return $region_name;
}

function check_product_buy_before($client_id, $sub_category_id) {
    global $con;
    include("connection.php");

    $exist = '';
    $result = $con->query("SELECT * FROM `orders` WHERE `client_id`='$client_id'   ORDER BY `order_id` DESC") or die(mysql_error());
    while ($row_select = mysqli_fetch_array($result)) {
        $cart_id = $row_select['cart_id'];
        $carts_array = explode(",", $cart_id);
        foreach ($carts_array as $one_cart) {
            $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' and `sub_category_id`='$sub_category_id' ORDER BY `cart_id` LIMIT 1");
            if (mysqli_fetch_array($query_select) >= 1) {
                $exist = 1;
            }
        }
    }
    if ($exist >= 1) {
        return 1;
    }
}

function Check_Credit($order_id, $client_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `payment` WHERE `order_id`='$order_id' and `client_id`='$client_id'");

    return mysqli_num_rows($result);
}

function count_sizes($sub_category_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_id`='$sub_category_id'  ");

    return mysqli_num_rows($result);
}

function get_size_id($sub_category_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_id`='$sub_category_id' order by sub_category_size_price asc limit 1");
    $row = mysqli_fetch_array($result);
    $size_price_id = $row['sub_category_size_price_id'];
    return $size_price_id;
}

function get_facebook() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `contact` WHERE `id`='1' ");
    $row = mysqli_fetch_array($result);

    $facebook = $row['facebook'];

    return $facebook;
}

function get_phone() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `contact` WHERE `id`='1' ");
    $row = mysqli_fetch_array($result);

    $phone = $row['phone'];

    return $phone;
}

function get_insta() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `contact` WHERE `id`='1' ");
    $row = mysqli_fetch_array($result);

    $instagram = $row['instagram'];

    return $instagram;
}

function get_twitter() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `contact` WHERE `id`='1' ");
    $row = mysqli_fetch_array($result);

    $twitter = $row['twitter'];

    return $twitter;
}

function get_email_for_send_actions() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `setting` WHERE `id`='1' ");
    $row = mysqli_fetch_array($result);

    $email_for_send_actions = $row['email_for_send_actions'];

    return $email_for_send_actions;
}

function Check_discount() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `setting` WHERE `id`='1' ");


    $row = mysqli_fetch_array($result);

    $discount = $row['discount'];

    return $discount;
}

function discount_percentage() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `setting` WHERE `id`='1' ");

    $row = mysqli_fetch_array($result);

    $discount_percentage = $row['discount_percentage'];

    return $discount_percentage;
}

function get_vat() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `setting` WHERE `id`='1' ");

    $row = mysqli_fetch_array($result);

    $vat = $row['vat'];

    return $vat;
}

function get_region_id($client_id, $client_address_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id' and `client_id`='$client_id' ORDER BY `client_address_id` DESC") or die(mysql_error());

    $row = mysqli_fetch_array($result);

    $region = $row['region'];

    return $region;
}

function get_region_by_address_id($client_address_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id'  ORDER BY `client_address_id` DESC") or die(mysql_error());

    $row = mysqli_fetch_array($result);

    $region = $row['region'];

    return $region;
}

function get_session_id($order_id, $client_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `payment` WHERE `order_id`='$order_id' and `client_id`='$client_id'");

    $row = mysqli_fetch_array($result);
    $session_id = $row['session_id'];

    return $session_id;
}

function orderPrice($cart_id) {
    global $con;
    include("connection.php");

    $carts_array = explode(",", $cart_id);
    $price = 0;
    foreach ($carts_array as $one_cart) {
        $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $one_cart . "' ORDER BY `cart_id` LIMIT 1");
        $row_select = mysqli_fetch_array($query_select);
        $price += $row_select['price'];
    }
    return $price;
}

function get_user_cart($user_id) {
    global $con;
    $query = $con->query("SELECT * FROM `cart` WHERE `client_id`='$user_id' AND `status`='0' AND `cart_type`='2' ");

    $data = array();
    $all_cart_ids = '';
    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['cart_id'];
        $all_cart_ids.=$id . ',';
    }
    $all_cart_ids = substr($all_cart_ids, 0, -1);
    return $all_cart_ids;
}

function get_added_vat() {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `setting` WHERE `id`='1'  ORDER BY `id` DESC limit 1") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $vat = $row['vat'];

    return $vat;
}

function send_email($order_id, $cart_id, $client_id, $client_address_id, $deliver_id) {
    global $con;
    include("connection.php");

    $cart_id_all = explode(',', $cart_id);
    $get_order_price = orderPrice($cart_id);
    $vat = get_added_vat();
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

<table align="center" cellpadding="0" cellspacing="0" width="95%" style="padding:15px;">
    <tr>
        <td align="center">
            <table align="center" border="1" cellpadding="0" cellspacing="0" width="600px" style="margin:15px;padding:15px;border-collapse: separate; border-spacing: 5px 5px; #000" bgcolor="#FFFFFF">
                <tr>
                    <td align="center" style="padding:5px;">
                        <a href="' . get_facebook() . '" target="_blank">
                            <img src="' . $site_url . 'image/logo.png" alt="Logo" style="width:186px;border:0;"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding:30px 0;">
                        <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:15px;text-align:right;direction:rtl;">
                            <tr>
                                <td style="padding:0; font-family: Avenir, sans-serif; font-size: 16px;">
                                    <!-- Initial text goes here-->
                                  <h2 style="text-align:center;color:#31A4F1;font-family:tahoma;">ملخص طلبك من غريب أرت </h2>
                                  <br/>
                                  <table style="border:1px solid #eee;padding: 5px;width: 100%;text-align: center;margin-bottom: 30px;" class="table table-striped">
	                                  <thead>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;"> المنتج</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">الكمية</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">السعر</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">المجموع</th>
	                                  </thead>
	                                  <tbody>';
    $client_addresses_query = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id'") or die(mysqli_error());
    $client_addresses_row_select = mysqli_fetch_array($client_addresses_query);

    $total_price = 0;
    foreach ($cart_id_all as $one) {
        $cart = $con->query("SELECT * FROM `cart` WHERE `cart_id`='$one'") or die(mysqli_error());
        $row_select = mysqli_fetch_array($cart);
        $sub_category_id = $row_select['sub_category_id'];
        $size_id = $row_select['size_id'];
        $quantity = $row_select['quantity'];
        $item_price = sizePrice($size_id);
        $sub_name = SubcategoryNameAr($sub_category_id);
        $price = $row_select['price'];
        $total_price += $price;


        $message .= '<tr style="border: 1px solid black;">';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $sub_name . '</td>';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $quantity . '</td>';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ($item_price), 3, '.', '') . '  BHD</td>';
        $message .= '<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . number_format((float) ($price), 3, '.', '') . '  BHD</td></tr>';
    }
    $message .= '</tbody></table>
<h2>إجمالي سعر المنتج : ' . number_format((float) ( ( $total_price)), 3, '.', '') . '  BHD </h2><h2>الضريبة   : ' . number_format((float) ( (($vat / 100) * $total_price)), 3, '.', '') . '  BHD </h2><h2>المجموع   : ' . number_format((float) ($total_price + (($vat / 100) * $total_price)), 3, '.', '') . '  BHD </h2>';
    if ($deliver_id == 1) {
        $message .= '<table style="border:1px solid #eee;padding: 5px;width: 100%%; text-align: center;margin-bottom: 30px;" class="table table-striped">
	                                  <thead>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">رقم الطلب</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">إسم العميل</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">رقم الجوال</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">المنطقة</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">المُجمع</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">الطريق</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">البناية</th>
	                                	  <th style="width: 10%;font-size: 14px;font-weight: bold;font-family: tahoma;">الشقة</th>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">ملاحظات</th>
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
                                  </table>';
    } else {
        $message .= '<table style="border:1px solid #eee;padding: 5px;width: 100%%; text-align: center;margin-bottom: 30px;" class="table table-striped">
	                                  <thead>
	                                	  <th style="width: 15%;font-size: 14px;font-weight: bold;font-family: tahoma;">رقم الطلب</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">إسم العميل</th>
	                                	  <th style="width: 20%;font-size: 14px;font-weight: bold;font-family: tahoma;">رقم الجوال</th>
	                                  </thead>
	                                  <tbody>
	                                  	<tr style="border: 1px solid black;">
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . $order_id . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;"> ' . get_client_name_from_id($client_id) . '</td>
	                                  		<td style="font-size: 12px;padding-top: 10px;border-top: 1px solid #000;">' . get_client_phone_from_id($client_id) . '</td>
	                                  		</tr>
	                                  </tbody>
                                  </table>';
    }
    $message .= '</td>
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
                                                <a href="tel:' . get_phone() . '" target="_blank">
                                                    <img src="' . $site_url . 'image/phone-icon.jpeg" alt="اتصل بنا"
                                                         style="display: block;"/>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-family: tahoma; font-weight:bold; color:#707070;font-size: 13px;padding: 10px 0 0 0;">
                                                اتصل بنا
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
                                                <a href="' . get_email_for_send_actions() . '">
                                                    <img src="' . $site_url . 'image/email-icon.jpeg" alt="Email us"
                                                         style="display: block;"/>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-family: tahoma; font-weight:bold; color:#707070;font-size: 13px;padding: 10px 0 0 0;">
                                                راسنا على البريد الإلكتروني
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
                                                <a href="' . get_facebook() . '" target="_blank">
                                                    <img src="' . $site_url . 'image/facebook-icon.jpeg" alt="Facebook" width="50" height="50" style="display: block;"/>
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td>
                                                <a href="' . get_insta() . '" target="_blank">
                                                    <img src="' . $site_url . 'image/instagram-icon.jpeg" alt="Instagram" width="50" height="50"style="display: block;"/>
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td>
                                                <a href="' . get_twitter() . '" target="_blank">
                                                    <img src="' . $site_url . 'image/twitter-icon.jpeg" alt="Twitter" width="50" height="50"style="display: block;"/>
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

function get_client_email($client_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $client_email = $row['client_email'];

    return $client_email;
}

function sizeNameEn($size_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $size_name = $row['sub_category_size_name'];

    return $size_name;
}

function sizeNameAr($size_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' ORDER BY `sub_category_size_price_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $size_name = $row['sub_category_size_name_ar'];

    return $size_name;
}

function get_client_name($client_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $client_name = $row['client_name'];

    return $client_name;
}

function get_workshop_en($workshop_id) {
    global $con;

    $result = $con->query("SELECT * FROM `workshop` WHERE `id`='$workshop_id' ORDER BY `id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $title_en = $row['title_en'];

    return $title_en;
}

function get_workshop_ar($workshop_id) {
    global $con;

    $result = $con->query("SELECT * FROM `workshop` WHERE `id`='$workshop_id' ORDER BY `id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $title_ar = $row['title_ar'];

    return $title_ar;
}

function get_error($the_error) {
    $get_error = '<div class="w3-panel w3-error note note-error" >
            <h3>' . $the_error . ' !</h3>
            <p> ' . $the_error . ' !</p>
        </div>';
    return $get_error;
}

function get_success($the_success) {
    $get_success = '<div class="w3-panel w3-green note note-success" >
            <h3>' . $the_success . ' !</h3>
            <p> ' . $the_success . ' !</p>
        </div>';
    return $get_success;
}

function get_client_phone_from_id($client_id) {
    global $con;

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $client_phone = $row['client_phone'];

    return $client_phone;
}

function get_charge($region_id) {
    global $con;

    $result = $con->query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $charge = $row['charge'];

    return $charge;
}

function get_min_order($region_id) {
    global $con;

    $result = $con->query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $min_order = $row['min_order'];

    return $min_order;
}

function get_region_name_en($region_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `regions` WHERE `region_id`='$region_id'  ORDER BY `region_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $region_name_en = $row['region_name_en'];

    return $region_name_en;
}

function count_client_cart($client_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `cart` WHERE  `status`='0' and `client_id`='$client_id'  ORDER BY `cart_id` DESC") or die(mysqli_error());

    return mysqli_num_rows($result);
}

function check_product_in_cart($sub_category_id, $size_id, $client_id) {
    include("connection.php");
    global $con;

    $result = $con->query("SELECT * FROM `cart` WHERE  `sub_category_id`='$sub_category_id' and `size_id`='$size_id' and `status`='0' and `client_id`='$client_id'  ORDER BY `cart_id` DESC") or die(mysqli_error());

    if (mysqli_fetch_array($result) >= 1) {

        return 1;
    }
}

function count_sub_categories_by_category_id($category_id) {
    global $con;
    $result = $con->query("SELECT * FROM `sub_categories` WHERE `parent_category_id`='$category_id' and `display`=1");
    return mysqli_num_rows($result);
}

function sizePrice($size_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' ORDER BY `sub_category_size_price_id` DESC limit 1") or die(mysqli_error());
    $row = mysqli_fetch_array($result);

    $size_price = $row['sub_category_size_price'];

    return number_format((float) ($size_price), 3, '.', '');
}

function get_category_id($sub_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_id' ") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $parent_category_id = $row['parent_category_id'];

    return $parent_category_id;
}

function get_categoryname_en($sub_id) {
    global $con;

    $result = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$sub_id' ORDER BY `parent_category_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $name_en = $row['parent_category_name'];

    return $name_en;
}

function get_categoryname_ar($sub_id) {
    global $con;

    $result = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$sub_id' ORDER BY `parent_category_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $name_en = $row['parent_category_name_ar'];

    return $name_en;
}

function get_client_image_from_id($client_id) {
    global $con;

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $client_image = $row['client_image'];

    return $client_image;
}

function get_client_name_from_id($client_id) {
    global $con;

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $client_name = $row['client_name'];

    return $client_name;
}

function check_register_phone($client_phone) {
    global $con;

    $result = $con->query("SELECT * FROM `clients` WHERE `client_phone`='$client_phone' ORDER BY `client_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $client_phone = $row['client_phone'];

    return $client_phone;
}

function getClientById($client_id) {
    global $con;

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' ORDER BY `client_id` DESC") or die(mysqli_error());
    $data = array();

    while ($row = mysqli_fetch_array($result)) {
        $data[] = $row;
    }
    return $data;
}

function get_category_name_ar_from_id($parent_category_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' ORDER BY `parent_category_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $parent_category_name = $row['parent_category_name_ar'];

    return $parent_category_name;
}

function get_category_name_en_from_id($parent_category_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' ORDER BY `parent_category_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $parent_category_name = $row['parent_category_name'];

    return $parent_category_name;
}

function SubcategoryNameAr($sub_category_id) {
    global $con;
    include("connection.php");

    $query_select = $con->query("SELECT * FROM `sub_categories` WHERE  `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $sub_category_name = $row_select['sub_category_name_ar'];
    return $sub_category_name;
}

function get_delivered_way_en($deliver_id) {
    global $con;

    $result = $con->query("SELECT * FROM `delivered_way` WHERE `id`='$deliver_id' ORDER BY `id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);

    $name_en = $row['name_en'];

    return $name_en;
}

function SubcategoryNameEn($sub_category_id) {
    global $con;
    include("connection.php");

    $query_select = $con->query("SELECT * FROM `sub_categories` WHERE  `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $sub_category_name = $row_select['sub_category_name'];
    return $sub_category_name;
}

function SubcategoryPrice($sub_category_id) {
    global $con;
    include("connection.php");

    $query_select = $con->query("SELECT * FROM `sub_categories` WHERE  `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $price = $row_select['price'];
    return $price;
}

function get_parent_category_id($sub_category_id) {
    global $con;
    include("connection.php");

    $query_select = $con->query("SELECT * FROM `sub_categories` WHERE  `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $parent_category_id = $row_select['parent_category_id'];
    return $parent_category_id;
}

function check_product_avaliable($sub_category_id) {
    global $con;
    include("connection.php");

    $query_select = $con->query("SELECT * FROM `sub_categories` WHERE  `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $display = $row_select['display'];
    return $display;
}

function check_cart_key($sub_category_id, $client_id) {
    global $con;

    $result = $con->query("SELECT * FROM `cart` WHERE `sub_category_id`='$sub_category_id' and `status`=0 and `client_id`='$client_id' ORDER BY `cart_id` DESC") or die(mysqli_error());

    if (mysqli_fetch_array($result) >= 1) {

        return 1;
    }
}

function get_client_cart_total_amount($client_id) {
    global $con;
    include("connection.php");

    $total = array();

    $result = $con->query("SELECT * FROM `cart` WHERE `client_id`='$client_id' AND `status`=0 ORDER BY `cart_id` DESC") or die(mysqli_error());

    while ($row = mysqli_fetch_array($result)) {

        $price = $row['price'];

        $quantity = $row['quantity'];

        $total[] = $price;
    }

    $total_amount = array_sum($total);

    return $total_amount;
}

function productPrice($sub_category_id) {
    global $con;

    $result = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysqli_error());
    $row = mysqli_fetch_array($result);

    $price = $row['price'];

    return $price;
}

function get_product_image_from_id($sub_category_id) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC") or die(mysqli_error());

    $row = mysqli_fetch_array($result);
    $sub_category_image = $row['sub_category_image'];

    return $sub_category_image;
}

function resume_sub_category_evaluate($sub_category_id) {
    global $con;
    include("connection.php");

    $sql = "SELECT * from `sub_category_comments` WHERE `sub_category_id`='$sub_category_id'";
    $result = $con->query($sql);
    $count_evaluate = mysqli_num_rows($result);
    $sum = 0;
    $evaluate = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            // temp client array
            $rate = $row['rate'];
            $sum += $rate;
        }
        $evaluate = $sum / $count_evaluate;
    }
    return $evaluate;
}

function check_register($client_phone) {
    global $con;
    include("connection.php");

    $result = $con->query("SELECT * FROM `clients` WHERE `client_phone`='$client_phone' ORDER BY `client_id` DESC") or die(mysqli_error());

    return mysqli_num_rows($result);
}

function check_client_login($temp) {
    include("connection.php");
    if (isset($temp['remember_me'])) {
        $remember_me = $temp['remember_me'];
    } else {
        $remember_me = '';
    }
    $client_phone = $temp['client_phone'];
    $login = $con->query("SELECT * FROM `clients` WHERE `client_phone`='" . $temp['client_phone'] . "'");
    if (mysqli_num_rows($login) == 0) {
        return FALSE;
    } else {
        while ($row = mysqli_fetch_array($login)) {
            // Check Password
            if ($row['client_password'] == $temp['client_password']) {
                $client_id = $row['client_id'];
                $client_password = $row['client_password'];
                $client_name = get_client_name_from_id($client_id);
                setcookie("client_id", '', time() - 3600, '/');
                setcookie("client_password", '', time() - 3600, '/');
                setcookie("client_id", $client_id, time() + 60 * 60 * 24 * 2, '/');
                setcookie("client_name", $client_name, time() + 60 * 60 * 24 * 2, '/');
                setcookie("client_password", $client_password, time() + 60 * 60 * 24 * 2, '/');
                if (isset($remember_me) && $remember_me != '') {
                    setcookie("remember_phone", $client_phone, time() + 60 * 60 * 24 * 2, '/');
                    setcookie("remember_pass", $client_password, time() + 60 * 60 * 24 * 2, '/');
                } else {
                    setcookie('remember_phone', '', time() - 3600, '/');
                    setcookie('remember_pass', '', time() - 3600, '/');
                }
                return "1";
            } else {
                return "error_pass";
            }
        }
    }
}

function navigationee($aTotal, $aStart, $aNum, $aUrl, $aItemsPerPage = 3, $aLinksPerPage = 5) {
    global $Lang;
    if ($_COOKIE['lang'] == "en") {
        $Next = "Next";
        $previous = "previous";
    } else {
        $Next = "التالي";
        $previous = "السابق";
    }

    if ($aTotal && $aTotal > $aItemsPerPage) {

        $num_pages = ceil($aTotal / $aItemsPerPage);
        $current_page = (int) $_GET['page'];
        $current_page = ($current_page < 1) ? 1 : ($current_page > $num_pages ? $num_pages : $current_page);

        $left_offset = ceil($aLinksPerPage / 2) - 1;
        $first = $current_page - $left_offset;
        $first = ($first < 1) ? 1 : $first;

        $last = $first + $aLinksPerPage - 1;
        $last = ($last > $num_pages) ? $num_pages : $last;

        $first = $last - $aLinksPerPage + 1;
        $first = ($first < 1) ? 1 : $first;

        $pages = range($first, $last);

        $out = '<nav aria-label="Page navigation">    <ul class="pager pagination justify-content-end">';

        $delim = ('.php' == strtolower(substr($aUrl, -4))) ? '?' : '&amp;';

// Previous, First links
        if ($current_page > 1) {
            $prev = $current_page - 1;
            $out .= "<li class='page-item'><a href=\"{$aUrl}{$delim}page={$prev}\" class='page-link'>" . $Next . "</a></li>";
        } else {
            $out .= '<li class="disabled page-item "><a class="page-link">' . $previous . '</a></li>';
        }

        foreach ($pages as $page) {
            if ($current_page == $page) {
                $out .= " <li class='page-item active'><a class='page-link'>{$page}</a></li>";
            } else {
                $out .= "<li class='page-item '><a href=\"{$aUrl}{$delim}page={$page}\" class='page-link'> {$page}</a> </li>";
            }
        }

        if ($current_page < $num_pages) {

            $next = $current_page + 1;
            $out .= "<li class='page-item '><a href=\"{$aUrl}{$delim}page={$next}\" class='page-link'>" . $Next . "</a></li>";
        } else {
            $out .= '<li class="disabled page-item"><a class="page-link">' . $previous . '</a></li>';
        }

        $out .= '</nav>';
    }

    return $out;
}

function getAllNewsNumber($post, $get) {

    global $con;
    $sql = " SELECT * from `news`   ";
//    echo $sql;
    $query = $con->query($sql);
    $news_count = mysqli_num_rows($query);
    return $news_count;
}

// View Sub Category Table
function getAllNews($aStart = 0, $aLimit = 0, $post, $get) {
    global $con;
    $allnews = array();

    $sql = " SELECT * from `news`   ";
    $sql .= ' order by id asc ';
    $sql .= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
//    echo $sql;
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($allnews, $row);

        $x++;
    }
    return $allnews;
}

function getAllOffersNumber($post, $get) {

    global $con;
    $sql = " SELECT * from `offers`   ";
//    echo $sql;
    $query = $con->query($sql);
    $offers_count = mysqli_num_rows($query);
    return $offers_count;
}

// View Sub Category Table
function getAllOffers($aStart = 0, $aLimit = 0, $post, $get) {
    global $con;
    $allofferss = array();

    $sql = " SELECT * from `offers`   ";
    $sql .= ' order by id asc ';
    $sql .= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
//    echo $sql;
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($allofferss, $row);

        $x++;
    }
    return $allofferss;
}

function getAllProductsNumber($post, $get) {

    global $con;
    $sql = " SELECT sub_categories.* from `sub_categories` left join sub_categories_size_prices on sub_categories_size_prices.sub_category_id=sub_categories.sub_category_id  where 1=1   ";

    if (isset($post['price_from']) && $post['price_from'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price` = '" . $post['price_from'] . "' ";
    }
    if (isset($post['price_to']) && $post['price_to'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price`= '" . $post['price_to'] . "' ";
    }
    if (isset($get['price_from']) && $get['price_from'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price` = '" . $get['price_from'] . "' ";
    }
    if (isset($get['price_to']) && $get['price_to'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price` = '" . $get['price_to'] . "' ";
    }

    if (isset($get['parent_category_id']) && $get['parent_category_id'] != '') {
        $sql .= " and sub_categories.`parent_category_id` = '{$get['parent_category_id']}'  ";
    }
    if ($post['parent_category_id'] && $post['parent_category_id'] != '') {
        $sql .= " and sub_categories.`parent_category_id` = '{$post['parent_category_id']}'  ";
    }



    if (isset($get['product_name']) && $get['product_name'] != '') {
        $sql .= "AND (sub_categories.`sub_category_name_ar` LIKE   '%{$get['product_name']}%') or (sub_categories.`sub_category_name` LIKE   '%{$get['product_name']}%') ";
    }
    if (isset($post['product_name']) && $post['product_name'] != '') {
        $sql .= "AND (sub_categories.`sub_category_name_ar` LIKE   '%{$post['product_name']}%') or (sub_categories.`sub_category_name` LIKE   '%{$post['product_name']}%') ";
    }
//    echo $sql;

    $query = $con->query($sql);

    $allbooks_count = mysqli_num_rows($query);

    return $allbooks_count;
}

// View Sub Category Table
function getAllProducts($aStart = 0, $aLimit = 0, $post, $get) {
    global $con;
    $allproducts = array();

    $sql = " SELECT sub_categories.* from `sub_categories` left join sub_categories_size_prices on sub_categories_size_prices.sub_category_id=sub_categories.sub_category_id  where 1=1   ";

    if (isset($post['price_from']) && $post['price_from'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price` = '" . $post['price_from'] . "' ";
    }
    if (isset($post['price_to']) && $post['price_to'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price`= '" . $post['price_to'] . "' ";
    }
    if (isset($get['price_from']) && $get['price_from'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price` = '" . $get['price_from'] . "' ";
    }
    if (isset($get['price_to']) && $get['price_to'] != '') {
        $sql.= "AND sub_categories_size_prices.`sub_category_size_price` = '" . $get['price_to'] . "' ";
    }

    if (isset($get['parent_category_id']) && $get['parent_category_id'] != '') {
        $sql .= " and sub_categories.`parent_category_id` = '{$get['parent_category_id']}'  ";
    }
    if ($post['parent_category_id'] && $post['parent_category_id'] != '') {
        $sql .= " and sub_categories.`parent_category_id` = '{$post['parent_category_id']}'  ";
    }



    if (isset($get['product_name']) && $get['product_name'] != '') {
        $sql .= "AND (sub_categories.`sub_category_name_ar` LIKE   '%{$get['product_name']}%') or (sub_categories.`sub_category_name` LIKE   '%{$get['product_name']}%') ";
    }
    if (isset($post['product_name']) && $post['product_name'] != '') {
        $sql .= "AND (sub_categories.`sub_category_name_ar` LIKE   '%{$post['product_name']}%') or (sub_categories.`sub_category_name` LIKE   '%{$post['product_name']}%') ";
    }
    $sql .= ' order by sub_categories_size_prices.sub_category_size_price asc ';
    $sql .= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    // echo $sql;
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($allproducts, $row);

        $x++;
    }
    return $allproducts;
}

function GetDefaultImage($src = false, $DefaultImage = false) {
    $img_return = $DefaultImage;
    if (empty($src) && empty($DefaultImage)) {
        return $src;
    }

    $file_headers = @get_headers($src);
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return $DefaultImage;
    } else {
        return $src;
    }
}
?>