<?ob_start(); ?>
<?php
include("config.php");
if (loggedin()) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>
    <body>

        <?php
        // error_reporting(0);
        if (isset($_POST['submit'])) {

            $email = mysqli_real_escape_string($con, $_POST['email']);

            // check that username & password entered !!
            if ($email) {
                $login = $con->query("SELECT * FROM `users` WHERE `user_email`='$email' limit 1");
                if (mysqli_num_rows($login) == 0) {
                    echo get_error("This Email Not Registered Before");
                } else {
                    while ($row = mysqli_fetch_assoc($login)) {
                        // Check Password
                        $user_password = $row['user_password'];
                        $user_email = $row['user_email'];


                        $contact = $con->query("SELECT * FROM `contact`");
                        $contact_row = mysqli_fetch_array($contact);
                        $email = $contact_row["email"];

                        $to = $user_email;
                        $subject = 'Password: ';
                        $message = 'Password: ' . $user_password;
                        $headers = 'From: Karami Restaurant ' . "\r\n" .
                                'Reply-To:' . $email . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();

                        mail($to, $subject, $message, $headers);
                        echo get_success("We Sent The Password To Email");
                    }
                }
            }
        }
        ?>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">

                <div class="panel-body">
                    <form class="form-horizontal m-t-20" action="" method="POST">

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="email" required="" placeholder=" Email ">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit" name="submit">We Will Send The Password To Email</button>
                            </div>
                        </div>

                    </form>					
                </div>   
            </div> 
        </div>
        <?php include("include/footer.php"); ?>
    </body>
</html>
<?ob_flush(); ?>