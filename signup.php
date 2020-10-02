<?php
include("public/site-url.php");
if (!empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url);
}
include("include/header.php");
?>
<div class="titln">
    <div class="container">
        <h3>Sign Up</h3>
    </div>
</div>

<!--start log in-->
<div class="sign">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 move wow fadeInLeftBig" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <div class="sign-up">
                    <img src="assets/img/Log%20In.png" class="w-100" alt="log-in"/>
                </div>
            </div>
            <div id="Regis" class="col-md-6 col-12 again wow fadeInRightBig" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <div class="container">
                    <div class="form-sign">
                        <div class="logo text-center">
                            <img src="assets/img/Footer%20Logo.png" alt="logoo"/>
                            <h4><?= lang('sign_up_to_your_account') ?></h4>
                        </div>
                        <form id="client-reg" method="POST" >
                            <div class="row">

                                <div class="col-12">
                                    <label><i class="fas fa-user-edit"></i> <?= lang('name') ?></label>
                                    <input class="form-control" type="text" placeholder="<?= lang('name') ?>" required="" name="client_name" id="client_name" >
                                </div>
                                <div class="col-12">
                                    <label><i class="fas fa-mobile mr-2"></i> <?= lang('phone_number') ?></label>
                                    <input type="text" placeholder="<?= lang('phone_number') ?> " required="" name="client_phone" id="client_phone" class="form-control" >
                                </div>
                                <div class="col-12">
                                    <label><i class="fas fa-lock mr-2"></i>  <?= lang('password') ?></label>
                                    <input type="password" name="client_password" class="form-control" placeholder=" <?= lang('password') ?>">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 p-0" id="recaptcha-container"></div>

                            <div class="button-log text-center">
                                <button id="" name="signup-submit" onclick="phoneAuth();" data-type="reg" type="button" class="btn btn-lg"><?= lang('sign_up') ?></button>
                            </div>
                        </form>

                        <p class="lead"><?= lang('i_have_an_account') ?> <a href="login.php"><?= lang('login') ?></a></p>
                    </div>
                </div>
            </div>





            <div  id="Phone_Verification" style="display:none" class="col-md-6 col-12 again wow fadeInRightBig" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <div class="container">
                    <div class="form-sign">
                        <div class="logo text-center">
                            <img src="assets/img/Footer%20Logo.png" alt="logoo"/>
                            <h4><?= lang('verification_code') ?></h4>
                        </div>
                        <form method="POST" >
                            <div class="row">
                                <div class="col-12">
                                    <label><i class="fas fa-lock mr-2"></i> <?= lang('verification_code') ?></label>
                                    <input type="text" placeholder="<?= lang('verification_code') ?>" required="" name="verificationCode" id="verificationCode" class="form-control" >
                                </div>
                            </div>
                            <div class="button-log text-center">
                                <button onclick="codeverify();" data-type="reg" type="button" class="btn btn-lg"><?= lang('submit') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php"); ?>
<script src="js/login.js" type="text/javascript"></script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
  https://firebase.google.com/docs/web/setup#config-web-app -->

<script>
                                    // Your web app's Firebase configuration
                                    var firebaseConfig = {
                                        apiKey: "AIzaSyBjXrP3TajAQhlQTwNg6Mod11nQxWs_yhk",
                                        authDomain: "aljazeera-3190c.firebaseapp.com",
                                        databaseURL: "https://aljazeera-3190c.firebaseio.com",
                                        projectId: "aljazeera-3190c",
                                        storageBucket: "aljazeera-3190c.appspot.com",
                                        messagingSenderId: "943411405133",
                                        appId: "1:943411405133:web:69eb805a2045bbc5fa9704",
                                        measurementId: "G-3ZR28EXLH6"
                                    };
                                    // Initialize Firebase
                                    firebase.initializeApp(firebaseConfig);
                                    firebase.analytics();

</script>
<script src="js/NumberAuthentication.js" type="text/javascript"></script>