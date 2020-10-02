<?php
    include("languages/lang_function.php");
    ChangeLanguage();
?><!DOCTYPE html>
<?php
    include('public/config.php');
    $active_parent_category_id = 0;
    if (\preg_match('/products\.php|gallery\.php/iUs', $_SERVER['PHP_SELF'])) {
        $active_parent_category_id = (\intval($_GET['parent_category_id']) > 0 ? $_GET['parent_category_id'] : 0);
    }
    if (\preg_match('/product\-details\.php/iUs', $_SERVER['PHP_SELF'])) {
        $sub_category_id = \intval($_GET['product_id']);
        $_result = $con->query("SELECT * FROM `sub_categories` where `sub_category_id`='$sub_category_id'");
        $_row = mysqli_fetch_array($_result);
        $active_parent_category_id = ($_row['parent_category_id']);
    }
    if (\preg_match('/about\-us\.php/iUs', $_SERVER['PHP_SELF'])) {
        $active_parent_category_id = 'about-us';
    }
    if (\preg_match('/contact\-us\.php/iUs', $_SERVER['PHP_SELF'])) {
        $active_parent_category_id = 'contact-us';
    }
    if (\preg_match('/login\.php/iUs', $_SERVER['PHP_SELF'])) {
        $active_parent_category_id = 'login';
    }
    if (\preg_match('/my\-cart\.php/iUs', $_SERVER['PHP_SELF'])) {
        $active_parent_category_id = 'my-cart';
    }
    $query_contact = $con->query("SELECT * FROM `contact` order by id desc");
    $row_contact = mysqli_fetch_array($query_contact);
    $email = $row_contact['email'];
    $phone = $row_contact['phone'];
    $address = (lang('lang_key') == 'en' ? $row_contact['address_en'] : $row_contact['address']);
    $fb = $row_contact['facebook'];
    $tw = $row_contact['twitter'];
    $insta = $row_contact['instagram'];
    $mob = $row_contact['mobile'];
    $website = $row_contact['website'];
    $snapchat = $row_contact['snapchat'];


    $result = $con->query("SELECT * FROM `setting` where id=1 limit 1 ") or die(mysqli_error());
    $row_select = mysqli_fetch_array($result);
    $footer_caption = (lang('lang_key') == 'en' ? $row_select['footer_caption_en'] : $row_select['footer_caption']);
    $vat = $row_select['vat'];
    $discount_percentage = $row_select['discount_percentage'];
    $email_for_send_actions = $row_select['email_for_send_actions'];
    $header_title = (lang('lang_key') == 'en' ? $row_select['header_title_en'] : $row_select['header_title']);
    $slider_image = $row_select['slider_image'];
    $logo = $row_select['logo'];
    $long_loca = $row_select['long_loca'];
    $lat_loca = $row_select['lat_loca'];

    $query_select = $con->query("SELECT * FROM `about` WHERE `id` = '1' LIMIT 1");
    $row_select = mysqli_fetch_array($query_select);

    $title = (lang('lang_key') == 'en' ? $row_select['title_en'] : $row_select['title']);
    $content = (lang('lang_key') == 'en' ? $row_select['content_en'] : $row_select['content']);
    $image = $row_select['image'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <meta name="description" content="Al-Jazeera Roastery" />

        <meta name="keywords" content="Al-Jazeera Roastery, COFFEE, SEEDS, PICKLES, NUTS, LIQUID PICKLE, SPCIES, DIRED FRUITS, RICE CRACKERS, MIX NUTS, FRESH NUTS, MINI PICKLES" />

        <meta name="author" content="Al-Jazeera Roastery" />

        <link rel="shortcut icon" type="image/png" href="https://aljazeeraroastery.com/system/uploads/Home-logo.png"/>

        <link href="https://fonts.googleapis.com/css2?family=Khand:wght@400;500;600&family=Source+Code+Pro&display=swap" rel="stylesheet">
        <title>Al-Jazeera Roastery</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
        <!-- reference your copy Font Awesome here (from our CDN or by hosting yourself) -->
        <link rel="stylesheet" href="assets/css/all.min.css"/>
        <link rel="stylesheet" href="assets/css/style.css"/>
        <link rel="stylesheet" href="assets/css/nav-footer.css"/>
        <link rel="stylesheet" href="assets/css/media.css"/>
        <link rel="stylesheet" href="assets/css/animated.css"/>
        <!-- If It IE 9 -->
        <script src="assets/js/jquery%203.5.1%20.js"></script>
        <script src="assets/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <link href="assets/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>

        <link href="js/toast/jquery.toast.min.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            body{
                direction: <?= lang('direction') ?> !important;
                text-align: <?= lang('align') ?> !important;
                text-transform: capitalize;
            }
            .top-header .min-cart {
                margin-<?= lang('align_reverse') ?>: 10px !important;
            }
            .dropdown-menu{
                <?= lang('align') ?>: 0  !important;
                <?= lang('align_reverse') ?>:auto !important;
            }
            .custom-control-label:before,
            .custom-control-label:after{
                <?= lang('align_reverse') ?>: auto !important;
                <?= lang('align') ?>: -1.5rem !important;
            }
        </style>
    </head>
    <body>
        <!-- start upper par-->
        <div class="upper-bar text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md">
                        <a href="tel:<?= $phone ?>" class="p-3 d-inline-block social-icons"><i class="fas fa-phone"></i> <?= $phone ?> </a>
                        <a href="mailto:<?= $email ?>" class="p-3 d-inline-block social-icons"><i class="fas fa-envelope"></i> <?= $email ?> </a>
                    </div>
                    <div class="col-md text-<?= lang('align_reverse') ?>">
                        <a class="p-3 d-inline-block social-icons" href="<?= $snapchat ?>" target="_blank"><i class="fab fa-snapchat"></i></a>
                        <a class="p-3 d-inline-block social-icons" href="<?= $tw ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a class="p-3 d-inline-block social-icons" href="<?= $fb ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a class="p-3 d-inline-block social-icons" href="<?= $insta ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- start heading -->
        <div class="heading">
            <header>
                <a href="index.php"><img src="assets/img/Home%20logo.png" class="wow flash" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300" alt="logo"/></a>
            </header>
        </div>


        <input type="hidden" id="site_url" name="site_url" value="<?php echo $site_url; ?>">
        <input type="hidden" id="lang" name="lang" value="<?php echo $_COOKIE['lang']; ?>">
        <input type="hidden" name="client_id" id="client_id" value="<?php echo $_COOKIE['client_id']; ?>">
        <input type="hidden" name="payment_url" id="payment_url" value="<?php echo $payment_url; ?>">

        <?php
            if (isset($_COOKIE['client_id']) && $_COOKIE['client_id'] != '') {
                $client_info = getClientById($_COOKIE['client_id']);
                $pwd = $client_info[0]['client_password'];
                if ($pwd != $_COOKIE['client_password']) {
                    setcookie('client_id', '', time() - 3600, '/');
                    setcookie('client_password', '', time() - 3600, '/');
                    header("Location:" . $site_url);
                }
            }
        ?>

