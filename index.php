<?php include("include/header.php"); ?>
<?php include("include/nav-bar.php"); ?>

<!--start slider-->
<div class="slide">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="50000">
        <div class="carousel-inner">
            <?php
                $result = $con->query("SELECT * FROM `slider` order by id desc  ") or die(mysqli_error());
                if (mysqli_num_rows($result) > 0) {
                    $x = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $slider_id = $row["id"];
                        $slide_image = $row["image"];
                        ?>
                        <div class="carousel-item <?php
                        if ($x == 1) {
                            echo "active";
                        }
                        ?>" >
                            <img src="<?= $slide_image; ?>" class="d-block w-100" alt="<?= $slider_id ?>">
                        </div>

                        <?php
                        $x++;
                    }
                }
            ?>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>
</div>

<!--start description-->
<div class="inform">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-12 stats">
                <div class="for-img">
                    <img src="<?= $image ?>" class="w-100" alt="decs"/>
                </div>
            </div>
            <div class="col-md-8 col-12 doce">
                <div class="desc">
                    <p class="lead"><?= $content ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


<!--start LATEST-->
<div class="latest">
    <h2><?= lang('LATEST') ?></h2>
</div>


<!-- start card-->
<div class="card-a">
    <div class="container">
        <div class="row py-3 my-3 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
            <?php
                $result = $con->query("SELECT sub_categories.* FROM `sub_categories` right join latest on latest.product_id=sub_categories.sub_category_id where sub_categories.`display`=1   ") or die(mysqli_error());
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

                    <div class = "col-md-3 col-6 px-3">
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
<!---end-->

<!--start most selling-->
<div class="most">
    <h2><?= lang('MOST_SELLING') ?></h2>
</div>

<!-- start card-->
<div class="card-a">
    <div class="container">
        <div class="row wow my-3 py-3 fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
            <!--one-->
            <?php
                $result = $con->query("SELECT sub_categories.* FROM `sub_categories` right join most_request_sub on most_request_sub.sub_category_id=sub_categories.sub_category_id where sub_categories.`display`=1   ") or die(mysqli_error());
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
                        <div class="card text-center">
                            <a class="product_img" href="product-details.php?product_id=<?php echo $sub_category_id; ?>">
                                <img src = "<?= GetDefaultImage($sub_category_image, $payment_url . "assets/img/coffee-arab.jpg"); ?>" class = "card-img-top" alt = "arab">
                            </a>
                            <div class="card-body">
                                <h6 class="card-title"> <?= $sub_category_name ?></h6>
                                <span><?= lang('bhd') ?> <?php echo $size_price; ?> <a   href="javascript:;" data-product="<?php echo $sub_category_id; ?>" data-id="<?php echo $sub_category_id; ?>"   class="add_to_cart"><i class="fas fa-shopping-cart"></i></a></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
</div>
<!---end-->

<!--start subscribe-->
<div class="subscribe">
    <div class="new">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12 bower wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                    <div class="our">
                        <h2><?= lang('news_letter_info') ?></h2>
                    </div>
                </div>
                <div class="col-md-6 col-12 engan wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                    <form  id="subscribe-form">
                        <div class="scen w-100">
                            <input id="email_subscribe" type="email" class="form-control d-block" placeholder="<?= lang('email') ?>"/>
                            <button type="button" id="subscribe" class="btn-lg d-block"><?= lang('submit') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--start details map-->
<div class="mt-5 mb-4 text-center">
    <h2><?= lang('OUR_LOCATION') ?></h2>
</div>

<!--start map-->
<div class="first-map">
    <div id="pattern" class="pattern text-center">
    </div>
</div>
<div id="map" class="map" style="height: 500px; width: 100%;">
</div>

<script>
        var map;

        function initMap() {
            map = new google.maps.Map(
                    document.getElementById('map'),
                    {center: new google.maps.LatLng(26.2342353, 50.5284394), zoom: 12.5});

            var features = [
                {
                    position: new google.maps.LatLng(26.2462638, 50.5669433),
                    label: 'فرع عراد',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2487346, 50.5752816),
                    label: 'فرع المحرق',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2086306, 50.5192847),
                    label: 'فرع مدينة عيسى',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2342353, 50.5284394),
                    label: 'فرع مُجمع البحرين',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.1887022, 50.4998247),
                    label: 'فرع الرفاع',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2462638, 50.5669433),
                    label: 'فرع قلالي',
                    type: 'info'
                }
            ];

            // Create markers.
            for (var i = 0; i < features.length; i++) {
                var marker = new google.maps.Marker({
                    position: features[i].position,
                    title: features[i].label,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    icon: 'https://aljazeeraroastery.com/assets/img/marker.png',
                    map: map
                });
            }
        }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjmF9nneXiMC3LujPbx-sA12RujVhESAw&callback=initMap"></script>

<?php include ('include/footer.php'); ?>

<script>
        $("#subscribe").on('click', function () {
            var ths_form = $('#subscribe-form');
            var action = site_url + 'functions/ajax.php';
            var email = $("#email_subscribe").val();
            var dataString = 'email_subscribe=' + email;
            if (ths_form.valid()) {
                $.ajax({
                    type: "POST",
                    url: action,
                    data: dataString,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        if (data.success == 1)
                        {
                            $.toast({
                                heading: data.message,
                                text: data.message,
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                            $("#email_subscribe").val("");
                        } else if (data.success == 0)
                        {
                            $.toast({
                                heading: data.message,
                                text: data.message,
                                showHideTransition: 'slide',
                                icon: 'error'
                            });
                        }

                    }

                });
            }

        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $(".carousel").carousel({
                interval: 8000,
                pause: false
            });
        });
</script>


