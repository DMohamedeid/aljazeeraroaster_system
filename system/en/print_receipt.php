<?php
$curr_decimal = 3;

include("config.php");
error_reporting(0);
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['orders'] != '1')) {
    header("Location: error.php");
    exit();
}
?>
<?php
include_once("regions_functions.php");
?>


<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="-1" />

        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href="assets/css/receipt_design.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <section id="bill">
            <image src="../uploads/aljazeera-logo.jpg" alt="" style="   display: block;  margin-left: auto;  margin-right: auto; height:100px ; width: 50%;" ></image>
            <p class="companyname">ALJAZIRA ROASTERY</p>
            <!--<p class="companyinfo">E-Mail : </p>-->
            <!--<p class="companyinfo">Mobile:.. </p>-->

            <br>
            <br>

            <table id="bill_header_info">

<?php
if (isset($_GET['get_order']) && $_GET['get_order'] != '') {
    $order_id = $_GET['get_order'];

    $query_1 = $con->query("SELECT * FROM `orders` WHERE `order_id`='" . $order_id . "' ORDER BY `order_id` DESC");
    $row_1 = mysqli_fetch_assoc($query_1);
    $branch_id = $row_1['branch_id'];
    $client_id = $row_1['branch_id'];
    $order_type = $row_1['mobile_type'];
    $orderdatetime = $row_1['date'];
    $branch_name = get_branche_Name($branch_id);
    $cart_id = $row_1['cart_id'];
    $cart_id = explode(",", $cart_id);
    $client_address_id = $row_1['client_address_id'];
    $get_client_address = get_client_address($client_address_id);
    $region_id = $get_client_address[0];
    $region_name=get_region($region_id);
    $discount_percentage = $row_1['discount_percentage'];
    $payment = $row_1['payment'];
    $vat = $row_1['vat'];
    $charge_cost = $row_1['charge_cost'];
    $net_price = $row_1['net_price'];
    $customer_name = get_client_name_by_id($client_id);
    $customer_mobile = get_client_phone_by_id($client_id);
    
}
?>


                <tr><td class="bill_header_info-c1">Bill No.        </td><td class="bill_header_info-c2">  <?php echo $order_id ?> </td></tr>
                <tr><td class="bill_header_info-c1">Branch Name.        </td><td class="bill_header_info-c2"> <?php echo $branch_name ?></td></tr>
                <tr><td class="bill_header_info-c1">Order Datetime.        </td><td class="bill_header_info-c2"> <?php echo $orderdatetime ?></td></tr>
                <tr><td class="bill_header_info-c1">Customer Name.        </td><td class="bill_header_info-c2"> <?php echo $customer_name ?></td></tr>

<?php

if (!empty($customer_mobile)) {
  echo '<tr><td class="bill_header_info-c1">Mobile.    </td><td class="bill_header_info-c2">'.$customer_mobile.'</td></tr>';
}

       if (!empty($client_address_id)) {


if (!empty($region_name)) {
  echo '<tr><td class="bill_header_info-c1">Region.    </td><td class="bill_header_info-c2">'.$region_name.'</td></tr>';
}

if (!empty($get_client_address[1])) {
  echo '<tr><td class="bill_header_info-c1">Block.    </td><td class="bill_header_info-c2">'.$get_client_address[1].'</td></tr>';
}

if (!empty($get_client_address[2])) {
  echo '<tr><td class="bill_header_info-c1">Road.    </td><td class="bill_header_info-c2">'.$get_client_address[2].'</td></tr>';
}

if (!empty($get_client_address[3])) {
  echo '<tr><td class="bill_header_info-c1">Building.    </td><td class="bill_header_info-c2">'.$get_client_address[3].'</td></tr>';
}


if (!empty($get_client_address[4])) {
  echo '<tr><td class="bill_header_info-c1">Flat.    </td><td class="bill_header_info-c2">'.$get_client_address[4].'</td></tr>';
}

if (!empty($get_client_address[5])) {
  echo '<tr><td class="bill_header_info-c1">Notes.    </td><td class="bill_header_info-c2">'.$get_client_address[5].'</td></tr>';
}

}





?>     

                




            </table>

            <br>

            <table id="bill_details">
                <tr>
                    <th class="bill_details_item_name_header">Description</th><th class="bill_details_qty_header">QTY</th><th class="bill_details_net_price_header">Net Price</th>
                </tr>


<?php
$result = count($cart_id);
$index = 1;

foreach ($cart_id as $one) {
    $query_select = $con->query("SELECT * FROM `cart` WHERE `cart_id`=$one  ORDER BY `cart_id` LIMIT 1");
    $row_select = mysqli_fetch_array($query_select);
    $sub_category_id = $row_select['sub_category_id'];
    $note = $row_select['note'];
    $size_id = $row_select['size_id'];
    $additions_id = $row_select['addition_id'];
    $quantity = number_format($row_select['quantity'], 2, '.', ' ');

    $price = number_format($row_select['price'], $curr_decimal, '.', ' ');
    $removes_id = $row_select['remove_id'];

    $query_select_two = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='" . $sub_category_id . "' ORDER BY `sub_category_id` DESC");
    $row_select_two = mysqli_fetch_assoc($query_select_two);
    $sub_category_name = $row_select_two['sub_category_name'];

    $query_select_three = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='" . $size_id . "' ORDER BY `sub_category_size_price_id` DESC");
    $row_select_three = mysqli_fetch_assoc($query_select_three);
    $sub_category_size_name = $row_select_three['sub_category_size_name'];
    $sub_category_size_price = number_format($row_select_three['sub_category_size_price'], $curr_decimal, '.', ' ');
    $additional_price = number_format(get_size_additions_price_by_id($additions_id), $curr_decimal, '.', ' ');
    $net_line_amt= ($sub_category_size_price*$quantity)+$additional_price ;
$net_line_amt=number_format($net_line_amt, $curr_decimal, '.', ' ');
    $item_size_comment_modifires = '';

    if (!empty($sub_category_size_name)) {
        $item_size_comment_modifires .= '<li> ' . $sub_category_size_name . ' </li>';
    }
    if (!empty($note)) {
        $item_size_comment_modifires .= '<li> ' . $note . ' </li>';
    }
    

    echo '<tr><td class="bill_details_item_name">' . $sub_category_name . $item_size_comment_modifires . '</td><td class="bill_details_qty">' . $quantity . '</td><td class="bill_details_net_price">' . $net_line_amt . '</td></tr>';
}
?>



            </table>
            <br>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">

            <table id="bill_footer">
                <tr><td class="bill_footer-c1">Total Bill :</td><td class="bill_footer-c2">  <?php echo number_format(totalPrice($order_id), $curr_decimal, '.', ' ') ; ?> </td></tr>
                <tr><td class="bill_footer-c1">Bill Discount</td><td class="bill_footer-c2"> <?php echo number_format($discount_percentage, $curr_decimal, '.', ' ') ; ?></td></tr>
                <tr><td class="bill_footer-c1">Total After Discount</td><td class="bill_footer-c2">  <?php echo number_format((($net_price - $charge_cost) - $vat), $curr_decimal, '.', ' ') ?>  </td></tr>
                <tr><td class="bill_footer-c1">Total VAT 5%</td><td class="bill_footer-c2">  <?php echo number_format($vat, $curr_decimal, '.', ' ')  ?>  </td></tr>
                <tr><td class="bill_footer-c1">Charge Cost</td><td class="bill_footer-c2">  <?php echo number_format($charge_cost, $curr_decimal, '.', ' ')  ?>  </td></tr>
                                <tr><td class="bill_footer-c1">Net Amount</td><td class="bill_footer-c2">  <?php echo number_format(($net_price - $charge_cost), $curr_decimal, '.', ' ')   ?>  </td></tr>

                <tr><td class="bill_footer-c1">Payment Method</td><td class="bill_footer-c2">  <?php
                switch ($payment) {
                    case "cash":
                        echo "CASH";
                        break;
                    case "credit":
                        echo "Online-Credit";
                        break;
                    case "debit":
                        echo "Online-Debit";
                        break;
                    default:
                        echo $payment;
                }
?>  </td></tr>



            </table>

        </section>

        <br>
        <div>

            <button class="btn_close" style="  height:50px ; width: 45%;" onclick="window.close();">Close</button>
            <button class="btn_print" onclick="printDiv();" style="  height:50px ; width: 45%;">Print Bill</button>


        </div>



        <script type="text/javascript">

            function printDiv() {
                var printContents = document.getElementById('bill').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }




        </script>
    </body>




</html>