<?php
include("public/site-url.php");

if (empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url . "login.php");
}

include("include/header.php");
include("include/nav-bar.php");
// print_r($_POST);
//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $client_id = $_COOKIE['client_id'];
    $client_name = trim($_POST['client_name']);
    $client_email = trim($_POST['client_email']);
    $client_phone = trim($_POST['client_phone']);
    $client_password = trim($_POST['client_password']);


    if (check_register_phone($client_phone) && $client_phone != get_client_phone_from_id($client_id)) {
        echo get_error("Sorry, this number is already registered!");
    } else {

        $result = $con->query("UPDATE clients SET `client_password`='$client_password', `client_name`='$client_name',`client_email`='$client_email',
	`client_phone`='$client_phone' WHERE `client_id`='$client_id'");
        if ($result) {
            echo get_success("Successfully updated!");
        }
    }
}

$query_select = $con->query("SELECT * FROM `clients` WHERE `client_id`='" . $_COOKIE['client_id'] . "'");
$row_select = mysqli_fetch_array($query_select);
// Check Password
$client_id = $row_select['client_id'];
$client_name = $row_select['client_name'];
$client_phone = $row_select['client_phone'];
$client_password = $row_select['client_password'];
$client_email = $row_select['client_email'];
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
        <h3>My Profile</h3>
    </div>
</div>

<div class="container">
    <hr>
</div>

<!--Start Info-->
<div class="info">
    <div class="container">
        <!--start aside-->
        <aside class="wow fadeInLeft" data-wow-duration=".5s" data-wow-delay=".5s" data-wow-offest="200">
            <div class="container ">
                <ul class="list-unstyled">
                    <li class="active"><a href="my-profile.php"><?= lang('account_info') ?></a></li>
                    <hr>
                    <li><a href="my-address.php"><?= lang('my_addresses') ?></a></li>
                    <hr>
                    <li ><a href="my-current-orders.php"><?= lang('my_orders') ?></a></li>
                    <hr>
                    <li><a href="my-favorite.php"><?= lang('my_favorite') ?></a></li>
                    <hr>
                </ul>
            </div>
        </aside>
        <!--start form-->
        <div class="my-form-a">
            <div class="container">
                <form class="row"  method="POST" enctype="multipart/form-data">
                    <div class="form-group wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                        <label for="formGroupExampleInput"><?= lang('email') ?></label>
                        <input  id="formGroupExampleInput" name="client_email" type="email" class="form-control" value="<?php echo $client_email; ?>" placeholder="<?= lang('email') ?>" required="">
                    </div>
                    <div class="form-group wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1s" data-wow-offest="300">
                        <label for="client_name"><?= lang('name') ?></label>
                        <input  type="text" value="<?php echo $client_name; ?>"  name="client_name" id="client_name" class="form-control" placeholder="<?= lang('name') ?>">
                    </div>
                    <div class="form-group wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1.5s" data-wow-offest="300">
                        <label for="client_phone"><?= lang('phone_number') ?></label>
                        <input  type="text" value="<?php echo $client_phone; ?>"  name="client_phone" id="client_phone" class="form-control" placeholder="<?= lang('phone_number') ?>">
                    </div>
                    <div class="form-group wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="2s" data-wow-offest="300">
                        <label for="client_password"><?= lang('password') ?></label>
                        <input type="password" value="<?php echo $client_password; ?>" name="client_password" id="client_password" class="form-control" placeholder="<?= lang('password') ?>">
                    </div>
                    <button type="submit" name="submit" class="btn-lg d-block wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="2s" data-wow-offest="300"> <?= lang('update') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>


<?php include("include/footer.php"); ?>
