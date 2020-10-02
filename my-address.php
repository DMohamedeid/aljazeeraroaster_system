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
        <aside>
            <div class="container">
                <ul class="list-unstyled">
                    <ul class="list-unstyled">
                        <li><a href="my-profile.php"><?= lang('account_info') ?></a></li>
                        <hr>
                        <li  class="active"><a href="my-address.php"><?= lang('my_addresses') ?></a></li>
                        <hr>
                        <li><a href="my-current-orders.php"><?= lang('my_orders') ?></a></li>
                        <hr>
                        <li><a href="my-favorite.php"><?= lang('my_favorite') ?></a></li>
                        <hr>
                    </ul>
                </ul>
            </div>
        </aside>

        <div class="add">
            <div class="address">
                <?php
                    $result = $con->query("SELECT * FROM `client_addresses` WHERE `client_id`='" . $_COOKIE['client_id'] . "'") or die(mysqli_error());
                    // check for empty result
                    if (mysqli_num_rows($result) == 0) {
                        ?>
                        <img src="assets/img/map.png" alt="map">
                        <p class="lead"><?= lang('there_are_no_saved_adddresses') ?></p>

                    <?php } ?>

            </div>
        </div>


        <div class="add-address">
            <div class="container">
                <!--start address-->



                <!-- if has saved adddresses-->
                <div class="frist">
                    <div class="second">
                        <div class="row">
                            <div class="col-md-6 col-12 ">
                                <?php
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
                                            $client_phone = $row["client_phone"];
                                            ?>

                                            <div class="addres-spa pb-3 delete_<?php echo $client_address_id; ?>">
                                                <a href="javascript:;"  data-remove='<?php echo $client_address_id; ?>' class="remove-add float-right">Delete</a>
                                                <div class="icon-one">
                                                    <i class="fas fa-home"></i><span><?php echo $region_name . ' - ' . $road . '-' . $block . ' - ' . $building . ' - ' . $flat_number; ?>
                                                    </span>
                                                </div>
                                                <br>
                                                <div class="icon-two">
                                                    <i class="fas fa-phone"></i><span><?= $client_phone ?></span>
                                                </div>
                                                <hr>

                                            </div>

                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="add-new">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn exe" data-toggle="modal" data-target="#address_modal">
                        <?= \lang('add_new_address') ?>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>



    <?php include("include/footer.php"); ?>
    <script src="js/delivery_address.js" type="text/javascript"></script>
