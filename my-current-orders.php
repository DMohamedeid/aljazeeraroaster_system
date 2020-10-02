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
            <li class="breadcrumb-item active" aria-current="page"><?= lang('my_profile') ?></li>
        </ol>
    </nav>
</div>

<div class="main-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-5">
                <h3>My Profile</h3>              
            </div>
            <div class="col-md-7 col-7">
                <div class="current">
                    <div class="links">
                        <div class="first-links active d-inline">
                            <a href="my-current-orders.php"><?= lang('my_orders') ?></a>
                        </div>
                        <div class="second-links  d-inline">
                            <a href="my-last-orders.php"><?= lang('last_orders') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <hr>
</div>

<!--Start Info-->
<div class="no-one">
    <div class="container">
        <!--start aside-->
        <aside>
            <div class="container">
                <ul class="list-unstyled">
                    <li><a href="my-profile.php"><?= lang('account_info') ?></a></li>
                    <hr>
                    <li><a href="my-address.php"><?= lang('my_addresses') ?></a></li>
                    <hr>
                    <li class="active"><a href="my-current-orders.php"><?= lang('my_orders') ?></a></li>
                    <hr>
                    <li><a href="my-favorite.php"><?= lang('my_favorite') ?></a></li>
                    <hr>
                </ul>
            </div>
        </aside>

        <!--start Current Orders-->
        <div class="currently text-center">

            <?php
            $X = 1;
            $result = $con->query("SELECT * FROM `orders` WHERE `client_id`='" . $_COOKIE['client_id'] . "' and  (`order_follow` !='3' and `order_status` !='2')  ORDER BY `order_id` DESC") or die(mysqli_error());
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $cart_id_all_yala = $row["cart_id"];
                    $order_id = $row["order_id"];
                    $order_status = $row["order_status"];
                    $order_follow = $row["order_follow"];
                    $charge_cost = number_format((float) ($row["charge_cost"]), 3, '.', '');
                    $payment = $row["payment"];
                    $date = $row["date"];
                    $deliver_id = $row["deliver_id"];
                    $deliver_name = get_delivered_way_en($deliver_id);
                    $net_price = number_format((float) ($row["net_price"]), 3, '.', '');
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-md-3 text-center d-flex">
                                <div class="once">
                                    <div class="strong d-block">
                                        <img src="assets/img/orders%20logo.png" class="w-50" alt="order">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 text-center d-flex">
                                <div class="once">
                                    <div class="strong d-block">
                                        <?= $date; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 text-center d-flex">
                                <div class="second">
                                    <div class="strong d-block">
                                        <?= lang('total') ?> : <?= $net_price; ?> <?= lang('bhd') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 col-md-3 text-center d-flex">
                                <div class="thired">
                                    <div class="strong d-block">
                                        <?= lang('order_no') ?>: <?php echo $order_id; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-1 text-center d-flex">
                                <div class="fourd">
                                    <div class="strong d-block">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cart_id_all = explode(',', $cart_id_all_yala);
                        foreach ($cart_id_all as $one) {
                            $result_2 = $con->query("SELECT * FROM `cart` WHERE `cart_id`='$one'  ORDER BY `cart_id`");
                            $row = mysqli_fetch_array($result_2);
                            $cart_id = $row["cart_id"];
                            $sub_category_id = $row["sub_category_id"];
                            $size_id = $row["size_id"];
                            $quantity = $row["quantity"];
                            $cart_price = number_format((float) ($row["price"]), 3, '.', '');

                            $image = get_product_image_from_id($sub_category_id);
                            $sizeprice = number_format((float) (sizePrice($size_id)), 3, '.', '');

                            $sub_category_name_ar = SubcategoryNameAr($sub_category_id);
                            $sub_category_name_en = SubcategoryNameEn($sub_category_id);
                            $sub_category_name = (lang('lang_key') == 'en' ? $sub_category_name_en : $sub_category_name_ar);

                            $size_name_en = sizeNameEn($size_id);
                            $size_name_ar = sizeNameAr($size_id);
                            $size_name = (lang('lang_key') == 'en' ? $size_name_en : $size_name_ar);
                            ?>

                            <div class="snop mb-3">
                                <div class="row text-center">
                                    <div class="col-md-2 col-5 text-center">
                                        <a href="#"><img src="<?= GetDefaultImage($image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class="d-block w-100 h-75" alt="coffee"/></a>
                                    </div>
                                    <div class="col-md-3 col-7">
                                        <strong class="pb-4 d-block"><?= lang('item_name') ?></strong>
                                        <a href="#"><?= $sub_category_name; ?></a>
                                    </div>
                                    <div class="col-md-3 col-12 text-center">
                                        <strong class="pb-4 d-block"><?= lang('quantity') ?></strong>
                                        <a href="#"><?= $quantity; ?></a>

                                    </div>
                                    <div class="col-md-2 col-6">
                                        <strong class="pb-4 d-block"><?= lang('price') ?></strong>
                                        <span><?= $sizeprice; ?> <?= lang('bhd') ?></span>
                                    </div>
                                    <div class="col-md-2 col-6">
                                        <strong class="pb-4 d-block"><?= lang('total') ?></strong>
                                        <span><?= $cart_price; ?> <?= lang('bhd') ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <hr>
                    </div>
                    <?php
                    $X++;
                }
            } else {
                ?>
                <h6><?= lang('no_orders') ?></h6>
            <?php }
            ?>

        </div>
    </div>
</div>


<div class="clearfix"></div>


<?php include ('include/footer.php'); ?>
