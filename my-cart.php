<?php
    include("public/site-url.php");
    if (empty($_COOKIE['client_id'])) {
        header("Location:" . $site_url . "login.php");
    }
    include("include/header.php");
    include("include/nav-bar.php");
?>
<!-- start bread -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php"><?= lang('home') ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= lang('my_cart') ?></li>
        </ol>
    </nav>
</div>


<!--Start Info-->
<div class="cart">
    <div class="container">

        <!--start cart Orders-->
        <?php
            $result = $con->query("SELECT * FROM `cart` WHERE `client_id`='" . $_COOKIE['client_id'] . "' AND `status`=0") or die(mysqli_error());

            // check for empty result
            if (mysqli_num_rows($result) > 0) {
                ?>

                <div class="ordd">
                    <h3><?= lang('order_details'); ?></h3>
                </div>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $cart_id = $row["cart_id"];
                    $sub_category_id = $row["sub_category_id"];
                    $notes = $row["note"];
                    $size_id = $row["size_id"];
                    $quantity = $row["quantity"];
                    $cart_price = number_format((float) ($row["price"]), 3, '.', '');
                    $sub_category_name_ar = SubcategoryNameAr($sub_category_id);
                    $sub_category_name_en = SubcategoryNameEn($sub_category_id);
                    $size_price = sizePrice($size_id);
                    $sub_category_name = (lang('lang_key') == 'en' ? $sub_category_name_en : $sub_category_name_ar);

                    $size_name_en = sizeNameEn($size_id);
                    $size_name_ar = sizeNameAr($size_id);
                    $size_name = (lang('lang_key') == 'en' ? $size_name_en : $size_name_ar);


                    $evaluate = resume_sub_category_evaluate($sub_category_id);
                    $image = get_product_image_from_id($sub_category_id);


                    $addition_id = $row["addition_id"];

                    $remove_id = $row["remove_id"];
                    $addition_arr_values = array();
                    $remove_arr_values = array();
                    $addprice = 0.000;
                    if ($addition_id != '') {
                        $addition_id_all = explode(',', $addition_id);
                        foreach ($addition_id_all as $one) {
                            $addition["addition_name"] = (lang('lang_key') == 'en' ? get_addition_by_id($one)['sub_category_addition_name'] : get_addition_by_id($one)['sub_category_addition_name_ar']);

                            $addition_price = get_addition_price_from_id($one);
                            $addprice += number_format((float) ($addition_price), 3, '.', '');
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
                    <div class="my-card one wow swing" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                        <div class="container">
                            <div class="solve">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="cardt">
                                            <div class="row">
                                                <div class="col-12 col-sm-3 col-lg-2">
                                                    <img src="<?= GetDefaultImage($image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class="card-img w-100 ml-3" alt="maag">
                                                </div>
                                                <div class="col-12 col-sm-9 col-lg-10">
                                                    <div class="card-body ml-2">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="pack">
                                                                    <h4><?= $sub_category_name; ?></h4>
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
                                                                    <h4><?= lang('size'); ?></h4>
                                                                    <span><?= $size_name; ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
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
                                                                    <h4><?= lang('price'); ?></h4>
                                                                    <span><?= $size_price; ?></span>
                                                                </div>

                                                                <div class="pack">
                                                                    <h4><?= lang('sub_total'); ?></h4>
                                                                    <span><?= $cart_price; ?></span>
                                                                </div>

                                                                <div class="pack">
                                                                    <div class="count">
                                                                        <div class="row counter border border-warning rounded">
                                                                            <div data-cart="<?php echo $cart_id; ?>" class="col-2 px-0 py-2 text-center quantity-plus border-right border-warning less"><i class="fas fa-plus d-block m-auto"></i></div>
                                                                            <div class="col-8 px-0"><input data-cart="<?php echo $cart_id; ?>"  id="qquantity_<?php echo $cart_id; ?>" name="quantity"  readonly="" value="<?php echo $quantity; ?>"  class="updatecart form-control border-0 input-number"></div>
                                                                            <div data-cart="<?php echo $cart_id; ?>" class="col-2 px-0 py-2 text-center quantity-minus border-left border-warning more"><i class="fas fa-minus d-block m-auto"></i></div>
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
                                    <div class="col-3 find">
                                        <span data-cart="<?php echo $cart_id; ?>" class="remvoe"><i   class="fas fa-trash-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                $total_price = number_format((float) (get_client_cart_total_amount($_COOKIE['client_id'])), 3, '.', '');
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
                <div class="ordd mt-5">
                    <h3><?= lang('cart_total') ?></h3>
                </div>
                <div class="spanish pl-5">
                    <div class="row justify-content-between">
                        <div class="col-4 fast">
                            <h4><?= lang('price'); ?> :</h4>
                        </div>
                        <div class="col-4">
                            <span><?= $total_price; ?> <?= lang('bhd'); ?> </span>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-4 fast">
                            <h4><?= lang('discount'); ?>  (<?php echo $discount_percentage; ?> %):</h4>
                        </div>
                        <div class="col-4">
                            <span><?= number_format((float) ($discount_percentage_amount), 3, '.', ''); ?> <?= lang('bhd'); ?> </span>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-4 fast">
                            <h4><?= lang('vat'); ?> (<?= $vat; ?>%) :</h4>
                        </div>
                        <div class="col-4">
                            <span><?= number_format((float) ($vat_added), 3, '.', '') ?> <?= lang('bhd'); ?></span>
                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-4 fast">
                            <h4><?= lang('total'); ?> :</h4>
                        </div>
                        <div class="col-4">
                            <span><?= $net_price_after_vat; ?> <?= lang('bhd'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-0 align-self-end text-center">

                    <a href="sections.php" class="py-2 px-5 btn btn-info bg-OceanGreen text-capitalize rounded-sm">
                        <?= lang('continue_shopping'); ?>
                    </a>
                    <a href="javascript:;" id='click_to_continue' class="py-2 px-5 btn btn-info bg-OceanGreen text-capitalize rounded-sm">
                        <?= lang('proceed_to_checkout'); ?>
                    </a>
                </div>
                <?php
            } else {
                echo lang('cart_is_empty');
            }
        ?>


    </div>
</div>


<?php include ('include/footer.php'); ?>