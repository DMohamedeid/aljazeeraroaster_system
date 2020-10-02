<?php
include("public/site-url.php");

if (empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url . "login.php");
} else {
    $client_id = $_COOKIE['client_id'];
}
if (isset($_POST) && !empty($_POST)) {
    
}
include("include/header.php");
include("include/nav-bar.php");
?>

<style>

    .w3-green, .w3-hover-green:hover {
        color: #b0752f!important;
        background-color: #748552ab!important;
        width: 504px;
        margin-left: 309px;
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
        padding: 1.01em 16px;
    }
</style>


<!-- start bread -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php"><?= lang('home'); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= lang('my_cart'); ?></li>
        </ol>
    </nav>
</div>


<!-- start costomer details-->
<div class="costomer">
    <div class="container">
        <div class="ordd">
            <h3><?= lang('deliver_way'); ?></h3>
        </div>
        <div class="datelis">
            <div class="container">
                <div class="row">
                    <?php
                    $result = $con->query("SELECT * FROM `delivered_way` where `display`=1 order by id asc") or die(mysqli_error());
                    while ($row = mysqli_fetch_array($result)) {
                        $deliver_id = $row["id"];
                        $name = (lang('lang_key') == 'en' ? $row['name_en'] : $row['name_ar']);
                        ?>
                        <div class="custom-control custom-radio px-0">
                            <input type = "radio" name="deliver_id" <?php
                            if ($deliver_id == 1) {
                                echo "checked";
                            }
                            ?> class="custom-control-input deliver_id" required="" value="<?php echo $deliver_id; ?>" id="customCheck<?php echo $deliver_id; ?>">
                            <label class="custom-control-label" for="customCheck<?php echo $deliver_id; ?>"> <?php echo $name; ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start costomer details-->
<div class="costomer"  id="hide_address">
    <div class="container">
        <div class="ordd">
            <h3><?= lang('customer_details'); ?></h3>
        </div>
        <div class="datelis">
            <div class="container">
                <?php
                $result = $con->query("SELECT * FROM `client_addresses` WHERE `client_id`='$client_id'") or die(mysqli_error());

                // check for empty result
                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_array($result)) {

                        $client_address_id = $row["client_address_id"];
                        $lat = $row["lat"];
                        $lang = $row["lang"];
                        $region_id = $row["region"];

                        $region_name_ar = get_region_name($region_id);
                        $region_name_en = get_region_name_en($region_id);
                        $region_name = (lang('lang_key') == 'en' ? $region_name_en : $region_name_ar);

                        $charge = number_format((float) (get_charge($region_id)), 3, '.', '');
                        $min_order = number_format((float) (get_min_order($region_id)), 3, '.', '');

                        $block = $row["block"];
                        $road = $row["road"];
                        $building = $row["building"];
                        $flat_number = $row["flat_number"];
                        ?>


                        <div class="custom-control custom-radio  client_address delete_<?php echo $client_address_id; ?>" id="delete_<?php echo $client_address_id; ?>">

                            <input name="client_address_id" id="client_address_id<?php echo $client_address_id; ?>" class="custom-control-input client_address_id" type="radio" data-id="<?php echo $client_address_id; ?>">
                            <label class="custom-control-label w-100 d-block" for="client_address_id<?php echo $client_address_id; ?>">
                                <p class="float-<?= lang('align') ?> m-0 size16 font-weight-bold text-left">
                                    <span data-icon="&#xf020" class="px-2 text-OceanGreen"></span>
                                    <?php echo $region_name . ' - ' . $road . ' - ' . $block . ' - ' . $building . ' - ' . $flat_number; ?>
                                </p>
                                <a href="javascript:;" data-remove='<?php echo $client_address_id; ?>' class="remove-add fas fa-trash-alt">
                                    <span data-icon="&#xf01f" class="px-2 text-OceanGreen"></span>
                                </a>
                            </label>

                        </div>
                        <?php
                    }
                }
                ?>


            </div>

            <a href="javascript:;" class="py-2 px-5 btn-block btn btn-info" id='add_address'><?= lang('add_new_address') ?> </a>
        </div>

    </div>
</div>


<!--Start Info-->
<div class="cart">
    <div class="container">
        <div class="ordd">
            <h3><?= lang('order_details') ?></h3>
        </div>
        <!--start cart Orders-->
        <?php
        $result = $con->query("SELECT * FROM `cart` WHERE `client_id`='$client_id' AND `status`=0") or die(mysqli_error());
        while ($row = mysqli_fetch_array($result)) {
            $cart_id = $row["cart_id"];
            $sub_category_id = $row["sub_category_id"];
            $size_id = $row["size_id"];
            $quantity = $row["quantity"];
            $notes = $row["notes"];

            $cart_price = number_format((float) ($row["price"]), 3, '.', '');
            $sub_category_name_ar = SubcategoryNameAr($sub_category_id);
            $sub_category_name_en = SubcategoryNameEn($sub_category_id);
            $sub_category_name = (lang('lang_key') == 'en' ? $sub_category_name_en : $sub_category_name_ar);

            $size_name_en = sizeNameEn($size_id);
            $size_name_ar = sizeNameAr($size_id);
            $size_name = (lang('lang_key') == 'en' ? $size_name_en : $size_name_ar);

            $price = sizePrice($size_id);
            $price = number_format((float) ($price), 3, '.', '');
            $image = get_product_image_from_id($sub_category_id);



            $addition_id = $row["addition_id"];
            $notes = $row["note"];

            $remove_id = $row["remove_id"];
            $addition_arr_values = array();
            $remove_arr_values = array();
            $addprice = 0.000;
            if ($addition_id != '') {
                $addition_id_all = explode(',', $addition_id);
                foreach ($addition_id_all as $one) {
                    $addition["addition_name"] = (lang('lang_key') == 'en' ? get_addition_by_id($one)['sub_category_addition_name'] : get_addition_by_id($one)['sub_category_addition_name_ar']);

                    $addition_price = get_addition_price_from_id($one);
                    $addprice+=number_format((float) ($addition_price), 3, '.', '');
                    array_push($addition_arr_values, $addition);
                }
            }
            if ($remove_id != '') {
                $remove_id_all = explode(',', $remove_id);
                foreach ($remove_id_all as $one) {
                    $remove["remove_name"] = (lang('lang_key') == 'en' ? get_remove_by_id($one)['title'] : get_remove_by_id($one)['title_ar']);
                    array_push($remove_arr_values, $remove);
                }
            }
            ?>
            <div class="my-card wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <div class="container">
                    <div class="solve">
                        <div class="row">
                            <div class="col-9">
                                <div class="cardt">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="<?= GetDefaultImage($image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class="card-img w-100 ml-5" alt="maag">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card-body ml-4">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="pack">
                                                            <h4><?=$sub_category_name ?></h4>
                                                        </div>
                                                        <?php if (count($addition_arr_values) > 0) { ?>
                                                            <div class="pack">
                                                                <h4><?= lang('additions'); ?></h4>
                                                                <?php foreach ($addition_arr_values as $add) { ?>
                                                                    <span><?= $add['addition_name'];
                                                                    ?></span>- 
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if (count($remove_arr_values) > 0) { ?>
                                                            <div class="pack">
                                                                <h4><?= lang('removes'); ?></h4>
                                                                <?php foreach ($remove_arr_values as $rem) { ?>
                                                                    <span><?= $rem['remove_name'];
                                                                    ?></span>- 
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="pack">
                                                            <h4><?= lang('quantity') ?></h4>
                                                            <span><?= $quantity; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="pack">
                                                            <h4><?= lang('size') ?></h4>
                                                            <span><?= $size_name; ?></span>
                                                        </div>
                                                        <?php
                                                        if ($notes == '') {
                                                            
                                                        } else {
                                                            ?>
                                                            <div class="pack">
                                                                <h4><?= lang('notes'); ?></h4>
                                                                <span><?= $notes; ?></span>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="pack">
                                                            <h4><?= lang('price') ?></h4>
                                                            <span><?= $price; ?></span>
                                                        </div>
                                                        <div class="pack">
                                                            <h4><?= lang('total') ?></h4>
                                                            <span><?= $cart_price; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>

        <div class="ordd mt-5">
            <h3><?= lang('payment') ?></h3>
        </div>
        <div class="method">
            <div class="row">
                <div class="col-6">

                    <div class="form pl-3">
                        <?php
                        $x = 1;
                        $result = $con->query("SELECT * FROM `payment_methods` where `display`=1  order by id asc") or die(mysqli_error());
                        while ($row = mysqli_fetch_array($result)) {
                            $payment_id = $row["id"];
                            $name = (lang('lang_key') == 'en' ? $row['name_en'] : $row['name_ar']);
                            ?>
                            <div class="form-check mt-4 mb-4">
                                <input class="form-check-input payment" type="radio" id="<?php
                                if ($payment_id == 1) {
                                    echo "cash";
                                } elseif ($payment_id == 2) {
                                    echo "debit";
                                } elseif ($payment_id == 3) {
                                    echo "credit";
                                }
                                ?>" name="payment" <?php
                                       if ($x == 1) {
                                           echo "checked";
                                       }
                                       ?> value="<?php
                                       if ($payment_id == 1) {
                                           echo "cash";
                                       } elseif ($payment_id == 2) {
                                           echo "debit";
                                       } elseif ($payment_id == 3) {
                                           echo "credit";
                                       }
                                       ?>" >
                                <label class="form-check-label ml-3" for="gridRadios1">
                                    <?= $name ?><img src="assets/img/-e-money.png" class="w-25 ml-5" alt="mony">
                                </label>
                            </div>
                            <?php
                            $x++;
                        }
                        ?>

                    </div>
                </div>


                <?php
                $total_price = number_format((float) (get_client_cart_total_amount($client_id)), 3, '.', '');
                $Check_discount = Check_discount();
                if ($Check_discount > 0) {
                    $discount_percentage = discount_percentage();
                } else {
                    $discount_percentage = 0;
                }
                $discount_percentage_amount = (($discount_percentage / 100) * $total_price);

                $net_price = number_format((float) ($total_price - $discount_percentage_amount), 3, '.', '');
                $vat = get_vat();
                $vat_added = (($vat / 100) * $net_price);
                $net_price_after_vat = number_format((float) ($total_price + $vat_added), 3, '.', '');
                ?>

                <div class="col-6">
                    <div class="spanish pl-5">
                        <div class="row justify-content-between">
                            <div class="col-4 fast">
                                <h4><?= lang('sub_total') ?> :</h4>
                            </div>
                            <div class="col-4 slow">
                                <span><?= number_format((float) ($total_price), 3, '.', ''); ?>  <?= lang('bhd') ?></span>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-4 fast">
                                <h4> <?= lang('discount_percentage') ?>(<?php echo $discount_percentage; ?>%) :</h4>
                            </div>
                            <div class="col-4 slow">
                                <span><?= number_format((float) ($discount_percentage_amount), 3, '.', ''); ?> <?= lang('bhd') ?></span>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-4 fast">
                                <h4><?= lang('price_after_discount') ?> :</h4>
                            </div>
                            <div class="col-4 slow">
                                <span><?= number_format((float) ($total_price), 3, '.', ''); ?> <?= lang('bhd') ?></span>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-4 fast">
                                <h4><?= lang('vat') ?>  (<?= get_vat(); ?>%) :</h4>
                            </div>
                            <div class="col-4 slow">
                                <span><?= number_format((float) ($vat_added), 3, '.', ''); ?> <?= lang('bhd') ?></span>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-4 fast">
                                <h4><?= lang('total') ?> :</h4>
                            </div>
                            <div class="col-4 slow">
                                <span><?= number_format((float) ($net_price_after_vat), 3, '.', ''); ?>  <?= lang('bhd') ?></span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="w3-panel w3-green note note-error" style="display: none">
                    <h3><?= lang('sorry') ?> !</h3>
                    <p><?= lang('choose_address_first') ?> !</p>
                </div>
                <input type="hidden" name="client_id" id="client_id" value="<?php echo $_COOKIE['client_id']; ?>">
                <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $_GET['cart_id']; ?>">
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?= lang('charge_cost') ?></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p id="charge_value"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-lg" id="accept"><?= lang('accept') ?></button>
                                <button type="button" class="btn-lg" data-dismiss="modal"><?= lang('cancel') ?></button>
                            </div>
                        </div>

                    </div>
                </div>


                <a href="javascript:;" id='confirm_pay'  class="py-2 px-5 btn-block btn btn-info">
                    <?= lang('checkout') ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include ('include/footer.php'); ?>
<script src="js/delivery_address.js" type="text/javascript"></script>

<script>

    $('body').on('change', '.deliver_id', function () {
        var deliver_id = $(this).val();
        if (deliver_id != 1) {
            $("#hide_address").css('display', 'none');
        } else {
            $("#hide_address").css('display', 'flex');
        }
    });
    var check = function (payment, client_address_id, client_id, deliver_id, dataString) {
        $.ajax({
            type: "POST",
            url: payment_url + "functions/check-exist.php",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function (data) {
                if (data.success == "0") {
                    $.toast({
                        heading: data.message,
                        text: data.message,
                        showHideTransition: 'slide',
                        icon: 'error'
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: payment_url + "functions/check_order_open.php",
                        data: dataString,
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            if (data == "1") {
                                // alert(data.order_price);

                                $.ajax({
                                    type: "POST",
                                    url: payment_url + "functions/check_order.php",
                                    data: dataString,
                                    dataType: 'json',
                                    cache: false,
                                    success: function (data) {
                                        if (data.success == "0") {
                                            $.toast({
                                                heading: data.message,
                                                text: data.message,
                                                showHideTransition: 'slide',
                                                icon: 'error'
                                            });
                                        } else {
                                            var send_data = dataString;
                                            $.ajax({
                                                type: "POST",
                                                url: payment_url + "functions/ajax_2.php",
                                                data: send_data,
                                                dataType: 'text',
                                                cache: false,
                                                success: function (send_data) {
                                                    if (send_data == "1") {
                                                        if (payment == "debit") {
                                                            var link = payment_url + "debit/init.php?amount=" + data.order_price + '&type=debit&&client_address_id=' + client_address_id + '&client_id=' + client_id + '&deliver_id=' + deliver_id;
                                                            document.location.href = link;
                                                        } else if (payment == "credit") {
                                                            var ran = Math.random(); // returns a random number
                                                            var client_id = $("#client_id").val(); // returns a random number

                                                            var link = payment_url + "credit/init.php?client_id=" + client_id + "&amount=" + data.order_price + "&orderID=" + ran + '&type=credit&client_address_id=' + client_address_id + '&client_id=' + client_id + '&deliver_id=' + deliver_id;
                                                            document.location.href = link;
                                                        } else if (payment == "cash") {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: payment_url + "functions/confirm_order.php",
                                                                data: dataString,
                                                                dataType: 'json',
                                                                cache: false,
                                                                success: function (data) {
                                                                    console.log(data.success)
                                                                    if (data.success == "0") {
                                                                        $.toast({
                                                                            heading: data.message,
                                                                            text: data.message,
                                                                            showHideTransition: 'slide',
                                                                            icon: 'error'
                                                                        });
                                                                    } else {
                                                                        $("#confirm_pay").prop('disabled', true);
                                                                        document.location.href = "finish-order.php?order_id=" + data.order_id;
                                                                    }

                                                                }
                                                            });

                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: "Sorry,Orders is currently unavailable",
                                    text: "Sorry,Orders is currently unavailable",
                                    showHideTransition: 'slide',
                                    icon: 'error'
                                });
                            }
                        }

                    });
                }
            }

        });
    }

    var Payment = function (payment, ran, client_id, cart_id, deliver_id, dataString_ch1, notify_url) {
        if (deliver_id == 1) {
            if ($('.client_address_id:radio').is(':checked')) {
                var client_address_id = $('.client_address_id:radio').attr("data-id");
            }
            var dataString = 'client_address_id=' + client_address_id + '&payment=' + payment + '&deliver_id=' + deliver_id + '&client_id=' + client_id + '&cart_id=' + cart_id;
//            alert(client_address_id)
            if (isNaN(client_address_id)) {
                $(".note-error").css('display', 'block');
            } else {
                $('.note-error').css('display', 'none');
                $.ajax({
                    type: "POST",
                    url: payment_url + "functions/region_charge.php",
                    data: "client_address_id=" + client_address_id,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        if (data.value == 0) {
                            $('.note-error').css('display', 'none');
                        check(payment, client_address_id, client_id, deliver_id, dataString)
                        } else {
                            $("#charge_value").html(data.text);
                            $('#myModal').modal('show');
                        }
                    }
                });
            }
        } else {
            var dataString = 'payment=' + payment + '&deliver_id=' + deliver_id + '&client_id=' + client_id + '&cart_id=' + cart_id ;
            $('.note-error').css('display', 'none');
            check(payment, client_address_id, client_id, deliver_id, dataString)
        }
    }
    $('body').on('click', '#accept', function () {

        $('#myModal').modal('hide');
        var client_id = $("#client_id").val();
        var cart_id = $("#cart_id").val();
        var ran = Math.random(); // returns a random number
        var deliver_id = $("input[name='deliver_id']:checked").val();
        if (deliver_id == 1) {
            if ($('.client_address_id:radio').is(':checked')) {
                var client_address_id = $('.client_address_id:radio').attr("data-id");
            }
        }
        var payment = $("input[name='payment']:checked").val();
        var dataString_ch1 = 'cart_id=' + cart_id;
        var notify_url = window.location.href;
        if (deliver_id == 1) {
            if ($('.client_address_id:radio').is(':checked')) {
                var client_address_id = $('.client_address_id:radio').attr("data-id");
            }
            var dataString = 'client_address_id=' + client_address_id + '&payment=' + payment + '&deliver_id=' + deliver_id + '&client_id=' + client_id + '&cart_id=' + cart_id;
            $('.note-error').css('display', 'none');
            check(payment, client_address_id, client_id, deliver_id, dataString)

        } else {
            var dataString = 'payment=' + payment + '&deliver_id=' + deliver_id + '&client_id=' + client_id + '&cart_id=' + cart_id;
            $('.note-error').css('display', 'none');
            check(payment, client_address_id, client_id, deliver_id, dataString)

        }
    });</script>
<script>
    $(document).ready(function () {
        $('body').on('click', '#confirm_pay', function () {
            var payment = $("input[name='payment']:checked").val();
            var ran = Math.random(); // returns a random number
            var client_id = $("#client_id").val();
            var cart_id = $("#cart_id").val();
            var deliver_id = $("input[name='deliver_id']:checked").val();
            var dataString_ch1 = 'cart_id=' + cart_id;
            var notify_url = window.location.href;
            Payment(payment, ran, client_id, cart_id, deliver_id, dataString_ch1, notify_url);
        });
    });
</script>