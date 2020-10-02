<?php
include ('include/header.php');
include("include/nav-bar.php");


if (isset($_GET['check']) && $_GET['check'] == "credit") {
    $operation_order_id = $_GET['operation_order_id'];
    $payment = $_GET['check'];
    $deliver_id = $_GET['deliver_id'];
    $client_address_id = $_GET['client_address_id'];
    $client_id = $_GET['client_id'];
    $cart_id = get_user_cart($client_id);

    $get_order_price = orderPrice($cart_id);


    if ($client_address_id != '') {
        $get_region_id = get_region_id($client_id, $client_address_id);
        $get_charge = get_charge($get_region_id);
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
        $net_price_after_vat = number_format((float) ($total_price + $vat_added), 3, '.', '');

        $result = $con->query("INSERT INTO orders(cart_id,client_id,client_address_id,total_price,charge_cost,discount_percentage,vat,net_price,order_status,order_follow,payment,deliver_id,date)
	VALUES('$cart_id','$client_id','$client_address_id','$total_amount','$get_charge','$discount_percentage_amount','$vat_added','$net_price_after_vat','0','0','$payment','$deliver_id','" . date("Y-m-d H:i:s") . "')");


        $product = array();
        $order_id = mysqli_insert_id($con);
        $con->query("UPDATE `payment` SET `order_id`='$order_id' where `operation_order_id`='$operation_order_id' ");
        foreach ($cart_id_all as $one) {
            $result_two = $con->query("UPDATE cart SET `status`='1'   WHERE `cart_id`='$one' ");
        }
        ?>
        <script>
            var payment_url = $("#payment_url").val();

            var link = payment_url + "finish-order.php?order_id=" + <?php echo $order_id;
        ?>;
            document.location.href = link;

        </script>
        <?php
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

        $result = $con->query("INSERT INTO orders(cart_id,client_id,client_address_id,total_price,charge_cost,discount_percentage,vat,net_price,order_status,order_follow,payment,deliver_id,date)
	VALUES('$cart_id','$client_id','','$total_amount','$get_charge','$discount_percentage_amount','$vat_added','$net_price_after_vat','0','0','$payment','$deliver_id','" . date("Y-m-d H:i:s") . "')");


        $order_id = mysqli_insert_id($con);
        $con->query("UPDATE `payment` SET `order_id`='$order_id' where `operation_order_id`='$operation_order_id' ");

        foreach ($cart_id_all as $one) {
            $result_two = $con->query("UPDATE cart SET `status`='1'  WHERE `cart_id`='$one'");
        }
        ?>
        <script>
            var payment_url = $("#payment_url").val();

            var link = payment_url + "finish-order.php?order_id=" + <?php echo $order_id; ?>;
            document.location.href = link;

        </script>

        <?php
    }
}

if (isset($_GET['paymentid']) && $_GET['paymentid'] != '' && $_COOKIE['payment'] == "debit") {
    $payment = $_COOKIE['payment'];
    $payment_id = $_GET['paymentid'];

    $deliver_id = $_GET['deliver_id'];
    $client_address_id = $_GET['client_address_id'];
    $client_id = $_GET['client_id'];
    $cart_id = get_user_cart($client_id);


    $get_order_price = orderPrice($cart_id);


    if ($client_address_id != '') {
        $get_region_id = get_region_id($client_id, $client_address_id);
        $get_charge = get_charge($get_region_id);
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

        $result = $con->query("INSERT INTO orders(cart_id,client_id,client_address_id,total_price,charge_cost,discount_percentage,vat,net_price,order_status,order_follow,payment,deliver_id,date)
	VALUES('$cart_id','$client_id','$client_address_id','$total_amount','$get_charge','$discount_percentage_amount','$vat_added','$net_price_after_vat','0','0','$payment','$deliver_id','" . date("Y-m-d H:i:s") . "')");


        $product = array();
        $order_id = mysqli_insert_id($con);

        $con->query("INSERT INTO payment(client_id,order_id,operation_order_id,result_indicator,payment_id,value,result,type,date) VALUES('$client_id','$order_id','','','$payment_id','$net_price_after_vat','success','debit','" . date("Y-m-d H:i:s") . "')");

        foreach ($cart_id_all as $one) {
            $result_two = $con->query("UPDATE cart SET `status`='1'  WHERE `cart_id`='$one' ");
        }
        ?>
        <script>
            var payment_url = $("#payment_url").val();

            var link = payment_url + "finish-order.php?order_id=" + <?php echo $order_id; ?>;
            document.location.href = link;
        </script>

        <?php
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

        $result = $con->query("INSERT INTO orders(cart_id,client_id,client_address_id,total_price,charge_cost,discount_percentage,vat,net_price,order_status,order_follow,payment,deliver_id,date)
	VALUES('$cart_id','$client_id','','$total_amount','$get_charge','$discount_percentage_amount','$vat_added','$net_price_after_vat','0','0','$payment','$deliver_id','" . date("Y-m-d H:i:s") . "')");



        $product = array();
        $order_id = mysqli_insert_id($con);
        $con->query("INSERT INTO payment(client_id,order_id,operation_order_id,result_indicator,payment_id,value,result,type,date) VALUES('$client_id','$order_id','','','$payment_id','$net_price_after_vat','success','debit','" . date("Y-m-d H:i:s") . "')");
        foreach ($cart_id_all as $one) {
            $result_two = $con->query("UPDATE cart SET `status`='1' WHERE `cart_id`='$one'");
        }
        ?>
        <script>
            var payment_url = $("#payment_url").val();

            var link = payment_url + "finish-order.php?order_id=" + <?php echo $order_id; ?>;
            document.location.href = link;

        </script>
        <?php
    }
}
?>
<style>
    .w3-green, .w3-hover-green:hover {
        color: #fff!important;
        background-color: #4c86af!important;
    }
    .w3-red {
        color: #fff!important;
        background-color: #dc356387!important;
    }
    .w3-panel {
        margin-top: 16px;
        margin-bottom: 16px;
    }

    h3{
        text-align: center;
    }
    p{
        text-align: center;
    }
    .w3-panel {
        padding: 4.01em 16px;
        margin-top: 194px;
    }
</style>
<?php if (isset($_GET['order_id']) && $_GET['order_id'] != '') { ?>

    <div class="container py-3">
        <div class="row my-5 border border-OceanGreen p-5 home-block rounded-sm">
            <div class="news-letter-left d-none d-md-block"></div>


            <div class="d-block w-100 text-center">
                <h3><?= lang('order_added_successfully'); ?></h3>
                <p><?= lang('order_id') ?>  <u class="bold text-OceanGreen"><?php echo $_GET['order_id']; ?></u></p>
            </div>


            <div class="news-letter-right d-none d-md-block"></div>
        </div>
    </div>



    <script type='text/javascript'>
        var link = 'http://aljazeeraroastery.com/my-current-orders.php';
        setInterval(function () {
            location.href = link
        }, 6000);

    </script>
<?php } else { ?>

    <div class="w3-panel w3-red">
        <h3><?= lang('sorry_there_was_an_error') ?>  </h3>
    </div>
<?php } ?>
