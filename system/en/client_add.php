<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['clients'] != '1')) {
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <body class="fixed-left">
        <div id="wrapper">
            <!-- Top Bar Start -->
            <?php include("include/topbar.php"); ?>
            <!-- Top Bar End -->

            <!-- Left Sidebar Start -->
            <?php include("include/leftsidebar.php"); ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->		

            <?php
            if (isset($_POST['submit'])) {

                $client_name = mysqli_real_escape_string($con, trim($_POST['client_name']));

                $client_password = md5(trim($_POST['client_password']));

                $client_email = mysqli_real_escape_string($con, trim($_POST['client_email']));

                $client_phone = mysqli_real_escape_string($con, trim($_POST['client_phone']));


                $errors = array();

                if (empty($client_name)) {
                    $errors[] = "Please enter all fields !";
                } else {
                    if (in_array($image_ext, $allowed_ext) === false) {
                        echo get_error("This file is not allowed");
                    }
                }
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {
                    $add_client = add_client($client_name, $client_password, $client_email, $client_phone);

                    echo get_success("Successfully Added");
                }
            }
            ?>	

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Clients</h4>
                                <ol class="breadcrumb">
                                    <li><a href="client_view.php">Clients</a></li>
                                    <li class="active">Add New Client  </li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Add New Client </b></h4>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>
                                        <div class="form-group">
                                            <label for="userName">Client Name</label>
                                            <input type="text" name="client_name" parsley-trigger="change" required placeholder="name" class="form-control" id="client_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="userName">Password</label>
                                            <input type="text" name="client_password" parsley-trigger="change" required placeholder="password " class="form-control" id="client_password">
                                        </div>										
                                        <div class="form-group">
                                            <label for="email"> Client Email</label>
                                            <input type="text" name="client_email" parsley-trigger="change" required placeholder="email " class="form-control" id="client_email">
                                        </div>
                                        <div class="form-group">
                                            <label for="userName">Phone</label>
                                            <input type="text" name="client_phone" parsley-trigger="change" required placeholder="phone" class="form-control" id="client_phone">
                                        </div>
                                        <br />																			
                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit"> Add </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancel </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>			
                    </div>			
                </div>
                <?php include("include/footer_text.php"); ?>

            </div>			

            <!-- End Right content here -->

            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <?php include("include/rightbar.php"); ?>
            </div>
            <!-- /Right-bar -->
        </div>
        <!-- END wrapper -->
        <?php include("include/footer.php"); ?>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item7").addClass("active");
            });
        </script>

    </body>
</html>