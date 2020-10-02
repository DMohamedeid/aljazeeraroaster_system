<?php
include("public/site-url.php");

if (!empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url . "my-profile.php");
}
include("include/header.php");
include("include/nav-bar.php");

?>


<!--start log in-->
<div class="log">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <div class="log-in">
                    <img src="assets/img/Log%20In.png" class="w-100" alt="log-in"/>
                </div>
            </div>
            <div class="col-md-6 col-12 again wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <div class="container">
                    <div class="form-log">
                        <div class="logo text-center">
                            <img src="assets/img/Footer%20Logo.png" alt="logoo"/>
                            <h4><?= lang('login_to_your_account') ?></h4>
                        </div>
                        <form action="" method="POST" id="client-login">
                            <div class="row">
                                <div class="col-12">
                                    <label><i class="fas fa-mobile mr-2"></i> <?= lang('phone_number') ?></label>
                                    <input  class="form-control" type="text" data-type="login" value="<?php echo $_COOKIE['remember_phone']; ?>"  placeholder=" Phone" required="" name="client_phone" id="client_phone" >
                                </div>
                                <div class="col-12">
                                    <label><i class="fas fa-lock mr-2"></i> <?= lang('password') ?></label>
                                    <input type="password"  value="<?php echo $_COOKIE['remember_pass']; ?>" data-type="login"  placeholder="<?= lang('password') ?>" required name="client_password" id="client_password" class="form-control" >
                                    <p class="lead"><a href="forgot-password.php"><?= lang('forget_password') ?></a></p>
                                </div>
                                <div class="col-12">
                                    <label><i class="fas fa-lock mr-2"></i>  <?= lang('remember_me') ?></label>
                                    <input id="checkbox-signup" checked name="remember_me" class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="button-log text-center">
                                <button id="login-submit" name="login-submit" data-type="login" type="button"class="btn btn-lg"><?= lang('login') ?></button>
                            </div>
                        </form>
                        <p class="lead"><?= lang('dont_have_an_account_yet') ?><a href="signup.php"> <?= lang('sign_up') ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php"); ?>
<script src="js/login.js" type="text/javascript"></script>
