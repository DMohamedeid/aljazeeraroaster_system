<?php
    include("include/header.php");
    include("include/nav-bar.php");

    $items = (int) $_GET['items'];

    if ($_POST['price']) {
        $price = $_POST['price'];
    } elseif ($_GET['price']) {
        $price = $_GET['price'];
    }
    if ($_POST['price_to']) {
        $price_to = $_POST['price_to'];
    } elseif ($_GET['price_to']) {
        $price_to = $_GET['price_to'];
    }

    if ($_POST['product_name']) {
        $product_name = $_POST['product_name'];
    } elseif ($_GET['product_name']) {
        $product_name = $_GET['product_name'];
    }
    if ($_POST['parent_category_id']) {
        $parent_category_id = $_POST['parent_category_id'];
    } elseif ($_GET['parent_category_id']) {
        $parent_category_id = $_GET['parent_category_id'];
    }


    if ($_POST['sub_category_id']) {
        $sub_category_id = $_POST['sub_category_id'];
    } elseif ($_GET['sub_category_id']) {
        $sub_category_id = $_GET['sub_category_id'];
    }

    $items = $items ? $items : 15;
    define(ITEMS_PER_PAGE, $items);
    $page = (int) $_GET['page'];
    $page = ($page < 1) ? 1 : $page;
    $start = ($page - 1) * ITEMS_PER_PAGE;
    $c_data_num = getAllProductsNumber($_POST, $_GET);


    $allData = getAllProducts($start, ITEMS_PER_PAGE, $_POST, $_GET);
//
//print_r("<pre>");
//print_r($_POST);
//print_r("<pre>");

    $url = "products.php?items=" . ITEMS_PER_PAGE . (($sub_category_id) ? "&sub_category_id=" . $sub_category_id : "") . (($product_name) ? "&product_name=" . $product_name : "") . (($parent_category_id) ? "&parent_category_id=" . $parent_category_id : "") . (($price) ? "&price=" . $price : "") . (($price_to) ? "&price_to=" . $price_to : "");

    $navigation = navigationee($c_data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
?>
<!--start bread-->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php"><?= lang('home') ?></a></li>
            <li class="breadcrumb-item"><a href="sections.php"><?= lang('sections') ?></a></li>

            <?php
                if (isset($parent_category_id) && $parent_category_id != '') {
                    $parent_category_name = (lang('lang_key') == 'en' ? get_categoryname_en($parent_category_id) : get_categoryname_ar($parent_category_id));
                    ?>
                    <li class="breadcrumb-item " aria-current="page"><?= $parent_category_name ?></li>
                <?php } ?>
            <li class="breadcrumb-item active" aria-current="page"><?= lang('products_number') ?> : <?= $c_data_num ?></li>

        </ol>
    </nav>
</div>

<div class="container">
    <!--start card-->
    <div class="card-c">
        <div class="container">
            <div class="row">
                <!--one-->
                <?php
                    foreach ($allData as $key => $row) {
                        $sub_category_id = $row['sub_category_id'];
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
                        <div class="col-md-4 col-12 wow fadeIn"  data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                            <div class="card text-center" style="width: 14rem;">
                                <a class="product_img" href="product-details.php?product_id=<?php echo $sub_category_id; ?>"><img src="<?= GetDefaultImage($sub_category_image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class="card-img-top" alt="arab"></a>
                                <div class="card-body">
                                    <h6 class="card-title"> <?= $sub_category_name ?></h6>

                                    <Span><?= lang('bhd') ?> <?php echo $size_price; ?> <a   href="javascript:;" data-product="<?php echo $sub_category_id; ?>" data-id="<?php echo $sub_category_id; ?>"   class="add_to_cart"><i class="fas fa-shopping-cart"></i></a></Span>
                                </div>
                            </div>
                        </div>
                    <?php } if ($c_data_num == 0) { ?>
                        <h4 class=""><?= lang('There are no products') ?></h4>
                    <?php } ?>
                <div class="" style="margin-top: 30px;width:100%; float: left;">
                    <?php echo $navigation; ?>
                </div>
            </div>
        </div>
    </div>
    <!---end-->

    <?php include("include/side-bar.php"); ?>

</div>

<div class="clearfix"></div>

<?php include("include/footer.php"); ?>
