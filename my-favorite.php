<?php
include("public/site-url.php");

if (empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url . "login.php");
} else {
    $client_id = $_COOKIE['client_id'];
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
        <h3><?= lang('my_profile') ?></h3>
    </div>
</div>

<div class="container">
    <hr>
</div>

<!--Start Info-->
<div class="info">
    <div class="container">
        <!--start aside-->
        <aside class="wow fadeInDownBig" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
            <div class="container">
                <ul class="list-unstyled">
                    <ul class="list-unstyled">
                        <li><a href="my-profile.php"><?= lang('account_info') ?></a></li>
                        <hr>
                        <li><a href="my-address.php"><?= lang('my_addresses') ?></a></li>
                        <hr>
                        <li ><a href="my-current-orders.php"><?= lang('my_orders') ?></a></li>
                        <hr>
                        <li class="active"><a href="my-favorite.php"><?= lang('my_favorite') ?></a></li>
                        <hr>
                    </ul>
                </ul>
            </div>
        </aside>
        <!--start address-->
        <div class="favour">
            <div class="container">
                <div class="fav-coffee">
                    <?php
                    $result = $con->query("SELECT * FROM `client_fav` WHERE `client_id`='" . $_COOKIE['client_id'] . "'") or die(mysqli_error());
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $fav_id = $row["fav_id"];
                            $client_id = $row["client_id"];
                            $sub_category_id = $row["sub_category_id"];
                            $evaluate = resume_sub_category_evaluate($sub_category_id);
                            $sub_category_image = get_product_image_from_id($sub_category_id);
                            $parent_category_id = get_category_id($sub_category_id);
                            $get_categoryname_en = get_categoryname_en($parent_category_id);
                            $get_categoryname_ar = get_categoryname_ar($parent_category_id);
                            $get_categoryname = (lang('lang_key') == 'en' ? $get_categoryname_en : $get_categoryname_ar);


                            $sub_category_name_ar = SubcategoryNameAr($sub_category_id);
                            $sub_category_name_en = SubcategoryNameEn($sub_category_id);
                            $sub_category_name = (lang('lang_key') == 'en' ? $sub_category_name_en : $sub_category_name_ar);


                            $product_fav;
                            if (!empty($_COOKIE['client_id'])) {
                                $client_id = $_COOKIE['client_id'];
                                $result_zero = $con->query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='$client_id'") or die(mysql_error());
                                if (mysqli_fetch_array($result_zero) >= 1) {
                                    $product_fav = 1;
                                } else {
                                    $product_fav = 0;
                                }
                            }
                            ?>


                            <div class="row wow heartBeat" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                                <div class="col-9">
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <a href="product-details.php?product_id=<?php echo $sub_category_id; ?>"> <img src="<?= GetDefaultImage($sub_category_image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class="card-img" alt="maag"></a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $get_categoryname; ?></h5>
                                                    <p class="card-text"><?= $sub_category_name; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <span><i  data-fav-id='<?php echo $fav_id; ?>' data-fav="<?php echo $product_fav; ?>" id="fav_<?php echo $sub_category_id; ?>"  data-id="<?php echo $sub_category_id; ?>"  class=" <?php
                                        if ($product_fav == 1) {
                                            echo "fa-heart";
                                        } else {
                                            echo "";
                                        }
                                        ?> fas remove-fav"></i></span>
                                </div>
                            </div>

                        <?php } ?>
                    <?php } else { ?>

                        <?= lang('empty_favourite') ?>
                    <?php } ?> 

                </div>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>



<?php include("include/footer.php"); ?>
<script>


    $('body').on('click', '.remove-fav', function () {
        var client_id = $("#client_id").val();
        var data_fav = $(this).attr('data-fav');
        var data_id = $(this).attr('data-id');
        var data_fav_id = $(this).attr('data-fav-id');
//        alert(data_id)
//        alert(data_fav)
//        alert(client_id)
        if (client_id == '') {
            $.toast({
                heading: 'Sorry,there is error',
                text: 'Login First',
                showHideTransition: 'slide',
                icon: 'error'
            });

        } else {
            var dataString = 'data_fav=' + data_fav + '&get_client_id=' + client_id + '&data_id=' + data_id;
            $.ajax({
                type: "POST",
                url: site_url + "functions/ajax.php",
                data: dataString,
                dataType: 'text',
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        if (data_fav == 1) {
                            $("#fav_" + data_id).attr("data-fav", "0");
                            $("." + data_fav_id).remove();
                            window.location.href = site_url + 'my-favorite.php';

                        }
                    }
                }
            });
        }
    });

</script>