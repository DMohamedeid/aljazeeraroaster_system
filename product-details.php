<?php
    include("include/header.php");
    include("include/nav-bar.php");

    if (isset($_GET['product_id'])) {
        $sub_category_id = $_GET['product_id'];
    }
?>


<!-- start bread -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php"><?= lang('home') ?></a></li>
            <?php
                $sub_category_name_ar = SubcategoryNameAr($sub_category_id);
                $sub_category_name_en = SubcategoryNameEn($sub_category_id);
                $sub_category_name = (lang('lang_key') == 'en' ? $sub_category_name_en : $sub_category_name_ar);
                $parent_category_id = get_parent_category_id($sub_category_id);
                $get_categoryname_en = get_categoryname_en($parent_category_id);
                $get_categoryname_ar = get_categoryname_ar($parent_category_id);
                $get_categoryname = (lang('lang_key') == 'en' ? $get_categoryname_en : $get_categoryname_ar);
            ?>

            <li class="breadcrumb-item"><a href="sections.php"><?= $get_categoryname ?></a></li>

            <li class="breadcrumb-item active" aria-current="page"> <?= $sub_category_name ?></li>
        </ol>
    </nav>
</div>

<!--start section price-->
<div class="stor">
    <div class="container">
        <div class="row">
            <?php
                if (isset($_GET['product_id']) && $_GET['product_id'] != '') {
                    $sub_category_id = $_GET['product_id'];
                    $result = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id'  ");
                    $row = mysqli_fetch_array($result);
                    $sub_category_name = (lang('lang_key') == 'en' ? $row['sub_category_name'] : $row['sub_category_name_ar']);
                    $sub_category_desc = (lang('lang_key') == 'en' ? $row['sub_category_desc'] : $row['sub_category_desc_ar']);

                    $get_parent_category_id = $row['parent_category_id'];
                    $display = $row['display'];
                    $sub_category_image = $row['sub_category_image'];
                    $product_fav;
                    if (!empty($_COOKIE['client_id'])) {
                        $result_zero = $con->query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='" . $_COOKIE['client_id'] . "'") or die(mysqli_error());
                        if (mysqli_fetch_array($result_zero) >= 1) {
                            $product_fav = 1;
                        } else {
                            $product_fav = 0;
                        }
                    }
                    $evaluate = resume_sub_category_evaluate($sub_category_id);
                    $count_sizes = count_sizes($sub_category_id);
                    $size_id = get_size_id($sub_category_id);
                    $size_price = sizePrice($size_id);
                    $display = $row['display'];
                    ?>

                    <input id="item_id" type="hidden" value="<?php echo $sub_category_id; ?>">

                    <div class="col-md-7 px-0 col-12 wow slideInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                        <div class="gallery">
                            <div class="container">
                                <div class="master-img">
                                    <img src="<?= GetDefaultImage($sub_category_image, $payment_url . "assets/img/sections-img/coffeeOPP.jpeg"); ?>" alt="coffee">
                                </div>
                                <div class="thumbnails"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12 some wow slideInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                        <div class="detail">
                            <div class="row">
                                <div class="col-10 mt-5">
                                    <h4 class="pb-2 m-0"> <?= $sub_category_name ?></h4>
                                    <p class="pb-2 m-0"> <?php if ($count_sizes <= 1) { ?>
                                            <?= lang('bhd') ?> <?= $size_price ?>
                                        <?php } ?>
                                    </p>
                                    <p class="pb-2 m-0"> <?= $sub_category_desc ?></p>

                                    <?php
                                    $query = $con->query("SELECT * FROM `sub_categories_size_prices` where `sub_category_id`='$sub_category_id'  ORDER BY `sub_category_size_price_id` ASC");
                                    $index = 0;
                                    if (mysqli_num_rows($query) > 1) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            $size_price = $row['sub_category_size_price'];
                                            $size_price = number_format((float) ($size_price), 3, '.', '');
                                            $size_name = (lang('lang_key') == 'en' ? $row['sub_category_size_name'] : $row['sub_category_size_name_ar']);
//                                $currency = (lang('lang_key') == 'en' ? "BHD" : "دينار بحريني");

                                            $size_price_id = $row['sub_category_size_price_id'];
                                            ?>
                                            <div class = "custom-control custom-radio">
                                                <input type = "radio"  name="size_id"  required="" value="<?php echo $size_price_id; ?>" id="customCheck_<?php echo $size_price_id; ?>" class = "custom-control-input size_id">
                                                <label class = "custom-control-label w-100 text-<?= lang('align') ?>" for = "customCheck_<?php echo $size_price_id; ?>">
                                                    <?php echo $size_name; ?> <?php echo $size_price; ?>  <?= lang('bhd') ?>
                                                </label>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="count m-3">
                                        <div class="row counter border border-warning rounded">
                                            <div class="col-2 px-0 py-2 text-center quantity-plus border-right border-warning"><i class="fas fa-plus d-block m-auto"></i></div>
                                            <div class="col-8 px-0"><input type="text" id='quantity' value="1" class="form-control border-0 input-number"></div>
                                            <div class="col-2 px-0 py-2 text-center quantity-minus border-left border-warning"><i class="fas fa-minus d-block m-auto"></i></div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="" class="text-capitalize text-OceanGreen font-weight-bold"><?= lang('note') ?> </label>
                                        <textarea class="form-control" rows="4" name="notes" id="notes" class=""></textarea>
                                    </div>
                                    <div>
                                        <?php
                                        $query = $con->query("SELECT * FROM `sub_categories_addition_prices` where parent_category_id='$get_parent_category_id'  ORDER BY `sub_category_addition_price_id` ASC");
                                        $index = 0;
                                        if (mysqli_num_rows($query) > 0) {
                                            ?>
                                            <h4><?= lang('additions') ?> </h4>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $addition_price_id = $row['sub_category_addition_price_id'];
                                                $addition_price = $row['sub_category_addition_price'];
                                                $addition_name = (lang('lang_key') == 'en' ? $row['sub_category_addition_name'] : $row['sub_category_addition_name_ar']);
                                                ?>
                                                <div class = "custom-control custom-radio">
                                                    <input type = "radio"  name="addition_id_<?php echo $addition_price_id; ?>"  required="" value="<?php echo $addition_price_id; ?>" id="addcustomCheck_<?php echo $addition_price_id; ?>" class = "custom-control-input addition_id">
                                                    <label class = "custom-control-label w-100 text-<?= lang('align') ?>" for = "addcustomCheck_<?php echo $addition_price_id; ?>">
                                                        <?php echo $addition_name; ?>
                                                        <?php echo $addition_price; ?> <?= lang('bhd') ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <?php
                                        $query = $con->query("SELECT * FROM `removes` where parent_category_id='$get_parent_category_id'  ORDER BY `id` ASC");
                                        $index = 0;
                                        if (mysqli_num_rows($query) > 0) {
                                            ?>
                                            <h4><?= lang('removes') ?> </h4>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $remove_id = $row['id'];
                                                $remove_name = (lang('lang_key') == 'en' ? $row['title'] : $row['title_ar']);
                                                ?>
                                                <div class = "custom-control custom-radio">
                                                    <input type = "radio"  name="remove_id_<?php echo $remove_id; ?>"  required="" value="<?php echo $remove_id; ?>" id="removes_<?php echo $remove_id; ?>" class = "custom-control-input remove_id">
                                                    <label class = "custom-control-label w-100 text-<?= lang('align') ?>" for = "removes_<?php echo $remove_id; ?>">
                                                        <?php echo $remove_name; ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php if ($count_sizes > 1) { ?>
                                        <button href="javascript:;" data-product="<?php echo $sub_category_id; ?>" class="btn-lg d-block"  id="add_q_to_cart" ><i class=" fas fa-shopping-cart mr-4"></i>
                                            <?= lang('add_to_cart') ?>
                                        </button>
                                    <?php } else { ?>

                                        <button onclick="addToCart(<?php echo $size_id; ?>,<?php echo $sub_category_id; ?>)" class="btn border-0 mt-3 btn-lg d-block"><i class="fas fa-shopping-cart mx-1"></i>
                                            <?= lang('add_to_cart') ?>
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class = "col-2">
                                    <i href="javascript:;"  data-fav="<?php echo $product_fav; ?>" id="fav_<?php echo $sub_category_id; ?>"  data-id="<?php echo $sub_category_id; ?>" class="set-fav add-to-fav fas <?php
                                    if ($product_fav == 1) {
                                        echo "fa-heart";
                                    } else {
                                        echo "fa-heart-o";
                                    }
                                    ?> "></i>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


        </div>
    </div>
</div>


<!--start related items -->
<div class = "container">
    <div class = "related mt-5 mb-3">
        <h3 class="m-0 p-2"><?= lang('related_products') ?></h3>
    </div>
</div>

<div class = "card-a">
    <div class = "container">
        <div class = "row wow fadeInRight" data-wow-duration = "1.5s" data-wow-delay = ".5s" data-wow-offest = "300">
            <!--one-->
            <?php
                $result = $con->query("SELECT * FROM `sub_categories` where `display`=1 and `sub_category_id` !='$sub_category_id' and `parent_category_id`='$get_parent_category_id'   ") or die(mysqli_error());
                while ($row = mysqli_fetch_array($result)) {
                    $sub_category_id = $row['sub_category_id'];
                    $sub_category_name = (lang('lang_key') == 'en' ? $row['sub_category_name'] : $row['sub_category_name_ar']);
                    $sub_category_desc = (lang('lang_key') == 'en' ? $row['sub_category_desc'] : $row['sub_category_desc_ar']);

                    $get_parent_category_id = $row['parent_category_id'];
                    $sub_category_image = $row['sub_category_image'];
                    $product_fav;
                    if (!empty($_COOKIE['client_id'])) {
                        $result_zero = $con->query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='" . $_COOKIE['client_id'] . "'") or die(mysqli_error());
                        if (mysqli_fetch_array($result_zero) >= 1) {
                            $product_fav = 1;
                        } else {
                            $product_fav = 0;
                        }
                    }
                    $evaluate = resume_sub_category_evaluate($sub_category_id);
                    $count_sizes = count_sizes($sub_category_id);
                    $size_id = get_size_id($sub_category_id);
                    $size_price = sizePrice($size_id);
                    ?>

                    <div class = "col-md-3 col-6">
                        <div class = "card text-center">
                            <a class="product_img" href="product-details.php?product_id=<?php echo $sub_category_id; ?>">
                                <img src = "<?= GetDefaultImage($sub_category_image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class = "card-img-top" alt = "arab">
                            </a>
                            <div class = "card-body">
                                <h6 class="card-title"> <?= $sub_category_name ?></h6>
                                <Span><?= lang('bhd') ?> <?php echo $size_price; ?> <a   href="javascript:;" data-product="<?php echo $sub_category_id; ?>" data-id="<?php echo $sub_category_id; ?>"   class="add_to_cart"><i class="fas fa-shopping-cart"></i></a></Span>
                            </div>
                        </div>
                    </div>
                <?php } ?>

        </div>

    </div>
</div>



<?php include ('include/footer.php');
?>
