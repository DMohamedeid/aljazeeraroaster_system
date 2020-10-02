<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Al-Jazeerah Roastery Bill</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

<style>
#invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 44mm;
  background: #fff;
  font-family:tahoma;
}
  ::selection {
    background: #f31544;
    color: #fff;
  }
  ::moz-selection {
    background: #f31544;
    color: #fff;
  }
  h1 {
    font-size: 1.5em;
    color: #222;
	font-family:tahoma;
  }
  h2 {
    font-size: 0.9em;
	font-family:tahoma;
  }
  h3 {
    font-size: 1.2em;
    font-weight: 300;
    line-height: 2em;
	font-family:tahoma;
  }
  p {
    font-size: 0.7em;
    color: #666;
    line-height: 1.2em;
	font-weight: bold;
	font-family:tahoma;
  }

  #top,
  #mid,
  #bot {
    /* Targets all id with 'col-' */
    border-bottom: 1px solid #eee;
  }

  #top {
    min-height: 100px;
  }
  #mid {
    min-height: 80px;
  }
  #bot {
    min-height: 50px;
  }

  #top .logo {
    //float: left;
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
    background-size: 60px 60px;
  }
  .clientlogo {
    float: left;
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
    background-size: 60px 60px;
    border-radius: 50px;
  }
  .info {
    display: block;
    //float:left;
    margin-left: 0;
  }
  .title {
    float: right;
  }
  .title p {
    text-align: right;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  td {
    //padding: 5px 0 5px 15px;
    //border: 1px solid #EEE
  }
  .tabletitle {
    //padding: 5px;
    font-size: 0.5em;
    background: #eee;
  }
  .service {
    border-bottom: 1px solid #eee;
  }
  .item {
    width: 24mm;
  }
  .itemtext {
    font-size: 0.5em;
	font-weight: bold;
  }

  #legalcopy {
    margin-top: 5mm;
  }

</style>

        <div id="invoice-POS">

            <center id="top">
                <div class="logo"></div>
                <div class="info"> 
                    <h2>Al-Jazeera Roastery</h2>
                </div><!--End Info-->
            </center><!--End InvoiceTop-->
            <?php
            $order_id = $_GET['order_id'];
            ?>


            <?php
            $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $_GET['order_id'] . "' ORDER BY `order_id` DESC");
            $orders_count = mysqli_num_rows($query_select);
            if ($orders_count > 0) {
                $row_select = mysqli_fetch_assoc($query_select);
                $cart_id = $row_select['cart_id'];
                $order_id = $row_select['order_id'];
                $payment = $row_select['payment'];
                $client_id = $row_select['client_id'];
                $client_address_id = $row_select['client_address_id'];
                $charge_cost = $row_select['charge_cost'];
                $net_price = $row_select['net_price'];
                $discount_percentage = $row_select['discount_percentage'];
                $get_client_address = get_client_address($client_address_id);
                $region_id = $get_client_address[0];
                $searchComma = ',';
                ?>

                <div id="mid">
                    <div class="info">
                        <h2>Contact Info</h2>
                        <p> 
                            Name   : <?php echo get_client_name_by_id($client_id); ?></br>
                            Phone   :
                            <?php
                            if ($client_address_id == '') {
                                echo get_client_phone_by_id($client_id);
                            } else {
                                echo $get_client_address[6];
                            }
                            ?> </br>    
                            Address : <?php echo get_region($region_id) . ' ,' . $get_client_address[1] . ' ,' . $get_client_address[2] . ' ,' . $get_client_address[3] . '.' . $get_client_address[4]; ?> </br>

                        </p>
                    </div>
                </div><!--End Invoice Mid-->

                <div id="bot">

                    <div id="table">
                        <table>
                            <tr class="tabletitle">
                                <td class="Hours"><h2>Qty</h2></td>
                                <td class="item"><h2>Item</h2></td>
                                <td class="Rate"><h2>Sub Total</h2></td>
                            </tr>
                            <?php
                            if (strpos($cart_id, $searchComma) != TRUE) {
                                $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $cart_id . "' ORDER BY `cart_id` LIMIT 1");
                                $row_select = mysqli_fetch_array($query_select);

                                $sub_category_id = $row_select['sub_category_id'];
                                $size_id = $row_select['size_id'];
                                $quantity = $row_select['quantity'];
                                $price = $row_select['price'];
                                $query_select_two = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` DESC");
                                $row_select_two = mysqli_fetch_assoc($query_select_two);
                                $sub_category_name = $row_select_two['sub_category_name'];

                                $query_select_three = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='" . $size_id . "' ORDER BY `sub_category_size_price_id` DESC");
                                $row_select_three = mysqli_fetch_assoc($query_select_three);
                                $sub_category_size_name = $row_select_three['sub_category_size_name'];
                                $sub_category_size_price = $row_select_three['sub_category_size_price'];
                                $additions_total_amount = get_size_additions_by_id_for_admin($additions_id);
                                ?>

                                <tr class="service">
                                    <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                    <td class="tableitem"><p class="itemtext"><?php echo $sub_category_name . ' -' . $sub_category_size_name; ?></p></td>
                                    <td class="tableitem"><p class="itemtext"><?php echo $sub_category_size_price * $quantity; ?> BD</p></td>
                                </tr>
                                <?php
                            } else {

                                $cart_id = explode(",", $cart_id);
                                $result = count($cart_id);
                                $index = 1;

                                foreach ($cart_id as $one) {
                                    //                echo $carts_array[$i];
                                    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");

                                    $row_select = mysqli_fetch_array($query_select);
                                    $sub_category_id = $row_select['sub_category_id'];
                                    $size_id = $row_select['size_id'];
                                    $quantity = $row_select['quantity'];
                                    $price = $row_select['price'];


                                    $query_select_two = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` DESC");
                                    $row_select_two = mysqli_fetch_assoc($query_select_two);
                                    $sub_category_name = $row_select_two['sub_category_name'];

                                    $query_select_three = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='" . $size_id . "' ORDER BY `sub_category_size_price_id` DESC");
                                    $row_select_three = mysqli_fetch_assoc($query_select_three);
                                    $sub_category_size_name = $row_select_three['sub_category_size_name'];
                                    $sub_category_size_price = $row_select_three['sub_category_size_price'];
                                    ?>
                                    <tr class="service">
                                        <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                        <td class="tableitem"><p class="itemtext"><?php echo $sub_category_name . ' -' . $sub_category_size_name; ?></p></td>
                                        <td class="tableitem"><p class="itemtext"><?php echo $sub_category_size_price * $quantity; ?> BD</p></td>
                                    </tr>
                                    <?php
                                    $index++;
                                }
                            }
                            ?>
                            <?php
                            $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");
                            $row_select = mysqli_fetch_assoc($query_select);
                            $cart_id = $row_select['cart_id'];
                            $searchComma = ',';

                            if (strpos($cart_id, $searchComma) != TRUE) {
                                $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $cart_id . "' ORDER BY `cart_id` LIMIT 1");
                                $row_select = mysqli_fetch_array($query_select);

                                $sub_category_id = $row_select['sub_category_id'];
                                $quantity = $row_select['quantity'];
                                $additions_id = $row_select['addition_id'];
                                if ($additions_id != '') {
                                    ?>
                                    <?php
                                    if (strpos($additions_id, $searchComma) != TRUE) {

                                        $query_add = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`=$additions_id  ORDER BY `sub_category_addition_price_id` LIMIT 1");

                                        $row_add = mysqli_fetch_array($query_add);
                                        $sub_category_addition_name = $row_add['sub_category_addition_name'];
                                        $sub_category_addition_price = $row_add['sub_category_addition_price'];
                                        ?>

                                        <tr class="service">
                                            <td class="tableitem"><p class="itemtext"> <?php echo $quantity; ?></p></td>
                                            <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_name; ?></p></td>
                                            <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_price * $quantity; ?> BD</p></td>
                                        </tr>
                                        <?php
                                    } else {

                                        $additions_id = explode(",", $additions_id);


                                        foreach ($additions_id as $add) {
                                            //                echo $carts_array[$i];
                                            $query_select = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`=$add  ORDER BY `sub_category_addition_price_id` LIMIT 1");

                                            $row_add = mysqli_fetch_array($query_select);
                                            $sub_category_addition_name = $row_add['sub_category_addition_name'];
                                            $sub_category_addition_price = $row_add['sub_category_addition_price'];
                                            ?>
                                            <tr class="service">
                                                <td class="tableitem"><p class="itemtext"> <?php echo $quantity; ?></p></td>
                                                <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_name; ?></p></td>
                                                <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_price * $quantity; ?> BD</p></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                } else {
                                    
                                }
                                ?>

                                <?php
                            } else {

                                $cart_id = explode(",", $cart_id);
                                $result = count($cart_id);
                                $index = 1;

                                foreach ($cart_id as $one) {
                                    //                echo $carts_array[$i];
                                    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");

                                    $row_select = mysqli_fetch_array($query_select);
                                    $quantity = $row_select['quantity'];
                                    $additions_id = $row_select['addition_id'];
                                    if ($additions_id != '') {
                                        ?>
                                        <?php
                                        if (strpos($additions_id, $searchComma) != TRUE) {
                                            $query_add = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`=$additions_id  ORDER BY `sub_category_addition_price_id` LIMIT 1");
                                            $row_add = mysqli_fetch_array($query_add);
                                            $sub_category_addition_name = $row_add['sub_category_addition_name'];
                                            $sub_category_addition_price = $row_add['sub_category_addition_price'];
                                            ?>
                                            <tr class="service">
                                                <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                                <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_name; ?></p></td>
                                                <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_price * $quantity; ?> BD</p></td>
                                            </tr>
                                            <?php
                                        } else {

                                            $additions_id = explode(",", $additions_id);


                                            foreach ($additions_id as $add) {
                                                //                echo $carts_array[$i];
                                                $query_add = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`=$add  ORDER BY `sub_category_addition_price_id` LIMIT 1");
                                                $row_add = mysqli_fetch_array($query_add);
                                                $sub_category_addition_name = $row_add['sub_category_addition_name'];
                                                $sub_category_addition_price = $row_add['sub_category_addition_price'];
                                                ?>
                                                <tr class="service">
                                                    <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                                    <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_name; ?></p></td>
                                                    <td class="tableitem"><p class="itemtext"><?php echo $sub_category_addition_price * $quantity; ?> BD</p></td>
                                                </tr>

                                                <?php
                                            }
                                        }
                                    } else {
                                        
                                    }
                                    ?>
                                    <?php
                                    $index++;
                                }
                            }
                            ?>
                            <?php
                            $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");
                            $row_select = mysqli_fetch_assoc($query_select);
                            $cart_id = $row_select['cart_id'];
                            $searchComma = ',';
                            if (strpos($cart_id, $searchComma) != TRUE) {
                                $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $cart_id . "' ORDER BY `cart_id` LIMIT 1");
                                $row_select = mysqli_fetch_array($query_select);
                                $quantity = $row_select['quantity'];
                                $potato_id = $row_select['potato_id'];
                                $drink_id = $row_select['drink_id'];
                                $type = $row_select['type'];
                                if ($type == 1 || $potato_id != '') {
                                    ?>
                                    <tr class="service">
                                        <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                        <td class="tableitem"><p class="itemtext"><?php echo potatos_name($potato_id); ?></p></td>
                                        <td class="tableitem"><p class="itemtext"><?php echo potatos_price($potato_id) * $quantity; ?> BD</p></td>
                                    </tr>

                                    <?php
                                } else {
                                    
                                }
                            } else {

                                $cart_id = explode(",", $cart_id);
                                $result = count($cart_id);
                                $index = 1;

                                foreach ($cart_id as $one) {
                                    //                echo $carts_array[$i];
                                    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");
                                    $row_select = mysqli_fetch_array($query_select);
                                    $quantity = $row_select['quantity'];
                                    $potato_id = $row_select['potato_id'];
                                    $drink_id = $row_select['drink_id'];
                                    $type = $row_select['type'];
                                    if ($type == 1 || $potato_id != '') {
                                        ?>
                                        <tr class="service">
                                            <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                            <td class="tableitem"><p class="itemtext"><?php echo potatos_name($potato_id); ?></p></td>
                                            <td class="tableitem"><p class="itemtext"><?php echo potatos_price($potato_id) * $quantity; ?> BD</p></td>
                                        </tr>
                                        <?php
                                        $index++;
                                    } else {
                                        
                                    }
                                }
                            }
                            ?>
                            <?php
                            $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");
                            $row_select = mysqli_fetch_assoc($query_select);
                            $cart_id = $row_select['cart_id'];
                            $searchComma = ',';
                            if (strpos($cart_id, $searchComma) != TRUE) {
                                $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`='" . $cart_id . "' ORDER BY `cart_id` LIMIT 1");
                                $row_select = mysqli_fetch_array($query_select);
                                $quantity = $row_select['quantity'];
                                $potato_id = $row_select['potato_id'];
                                $drink_id = $row_select['drink_id'];
                                $type = $row_select['type'];
                                if ($type == 1 || $drink_id != '') {
                                    ?>
                                    <tr class="service">
                                        <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                        <td class="tableitem"><p class="itemtext"><?php echo drinks_name($drink_id); ?></p></td>
                                        <td class="tableitem"><p class="itemtext"><?php echo drinks_price($drink_id) * $quantity; ?> BD</p></td>
                                    </tr>

                                    <?php
                                } else {
                                    
                                }
                            } else {

                                $cart_id = explode(",", $cart_id);
                                $result = count($cart_id);
                                $index = 1;

                                foreach ($cart_id as $one) {
                                    //                echo $carts_array[$i];
                                    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");
                                    $row_select = mysqli_fetch_array($query_select);
                                    $quantity = $row_select['quantity'];
                                    $potato_id = $row_select['potato_id'];
                                    $drink_id = $row_select['drink_id'];
                                    $type = $row_select['type'];
                                    if ($type == 1 || $drink_id != '') {
                                        ?>
                                        <tr class="service">
                                            <td class="tableitem"><p class="itemtext"><?php echo $quantity; ?></p></td>
                                            <td class="tableitem"><p class="itemtext"><?php echo drinks_name($drink_id); ?></p></td>
                                            <td class="tableitem"><p class="itemtext"><?php echo drinks_price($drink_id) * $quantity; ?> BD</p></td>
                                        </tr>

                                        <?php
                                        $index++;
                                    } else {
                                        
                                    }
                                }
                            }
                            ?>


                            <?php
                            $query_select = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id`  DESC limit 1");
                            $row_select_order = mysqli_fetch_assoc($query_select);
                            $cart_id = $row_select_order['cart_id'];
                            $order_id = $row_select_order['order_id'];
                            $payment = $row_select_order['payment'];
                            $client_id = $row_select_order['client_id'];
                            $client_address_id = $row_select_order['client_address_id'];
                            $charge_cost = $row_select_order['charge_cost'];
                            $net_price = $row_select_order['net_price'];
                            $discount_percentage = $row_select_order['discount_percentage'];
                            $get_client_address = get_client_address($client_address_id);
                            $region_id = $get_client_address[0];
                            $searchComma = ',';
                            ?>

                            <tr class="tabletitle">
                                <td></td>
                                <td class="Rate"><h2>Gross</h2></td>
                                <td class="payment"><h2><?php echo totalPrice($order_id); ?> BD</h2></td>
                            </tr>

                            <tr class="tabletitle">
                                <td></td>
                                <td class="Rate"><h2>Delivery Charge</h2></td>
                                <td class="payment"><h2><?php echo $charge_cost; ?> BD</h2></td>
                            </tr>

                            <tr class="tabletitle">
                                <td></td>
                                <td class="Rate"><h2>Discount</h2></td>
                                <td class="payment"><h2><?php echo $discount_percentage; ?> %</h2></td>
                            </tr>

                            <tr class="tabletitle">
                                <td></td>
                                <td class="Rate"><h2>Net</h2></td>
                                <td class="payment"><h2><?php echo $net_price; ?> BD</h2></td>
                            </tr>

                        </table>
                    </div><!--End Table-->

                    <div id="legalcopy">
                        <p class="legal"><strong>Deliver By</strong>  Emcan Solutions </p>
                    </div>
                <?php } else {
                    ?>

                    <h2> No Orders </h2>

                <?php }
                ?>

            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->


    </body>
</html>
