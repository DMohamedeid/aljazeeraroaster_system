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

            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = $_POST['password'];

            // check that username & password entered !!
            if ($username && $password) {
                $login = $con->query("SELECT * FROM `users` WHERE `user_name`='$username'");
                if (mysqli_num_rows($login) == 0) {
                    echo get_error("Invalid Username Or Password !");
                } else {
                    while ($row = mysqli_fetch_assoc($login)) {
                        // Check Password
                        if ($row['user_password'] == $password) {
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['user_type'] = $row['user_type'];
                            $_SESSION['user_name'] = $row['user_name'];
                            $_SESSION['messages'] = $row['messages'];
                            $_SESSION['dishs'] = $row['dishs'];
                            $_SESSION['adds_and_removes'] = $row['adds_and_removes'];
                            $_SESSION['cat_and_sub'] = $row['cat_and_sub'];
                            $_SESSION['orders'] = $row['orders'];
                            $_SESSION['clients'] = $row['clients'];
                            $_SESSION['setting'] = $row['setting'];
                            $_SESSION['problems'] = $row['problems'];
                            $_SESSION['regions'] = $row['regions'];
                            $_SESSION['about'] = $row['about'];
                            $_SESSION['reports'] = $row['reports'];
                            $_SESSION['comments'] = $row['comments'];
                            $_SESSION['statics'] = $row['statics'];
                            $_SESSION['users'] = $row['users'];

                            header("Location: index.php");
                        } else {
                            echo get_error("Incorrect password! Please try again");
                        }
                    }
                }
            }
        }
        ?>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading"> 
                    <h3 class="text-center"> Login <strong class="text-custom"> Aljazeera Roastery</strong> </h3>
                </div> 
                <div class="panel-body">
                    <form class="form-horizontal m-t-20" action="" method="POST">

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" required="" placeholder="User Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password ">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit" name="submit">login</button>
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