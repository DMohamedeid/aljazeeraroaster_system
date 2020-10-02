<?php
include("public/site-url.php");

if (!empty($_COOKIE['client_id'])) {
    header("Location:" . $site_url . "my-favorite.php");
}
include("include/header.php");
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
                            <h4><?= lang('recover_password') ?></h4>
                        </div>
                        <form action="" method="POST" id="recover-pass" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <label><i class="fas fa-mobile mr-2"></i> <?= lang('email') ?></label>
                                    <input type="text" placeholder="<?= lang('email') ?>" required="" name="client_email" id="client_email" class="form-control border-0" aria-label="Phone" aria-describedby="basic-addon1">
                                </div>


                            </div>
                            <div class="button-log text-center">
                                <button  id="recover_pass" type="button" class="btn btn-lg"><?= lang('send_password') ?></button>
                            </div>
                        </form>
                        <p class="lead"><?= lang('i_have_an_account') ?><a href="login.php"><?= lang('login') ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('include/footer.php'); ?>
<script>
    $("#recover_pass").on('click', function () {
        var ths_form = $('#recover-pass');
        var action = site_url + 'functions/ajax.php';
        var email = $("#client_email").val();
        var dataString = 'email=' + email;
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
                        $("#client_email").val("");
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