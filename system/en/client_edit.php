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

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->  		

            <?php
// error_reporting(0);

            if (isset($_POST['client_update'])) {

                $clientID_update = $_POST['clientID_update'];
                $clientName_update = $_POST['clientName_update'];
                if (isset($_POST['clientPassword_update']) && ($_POST['clientPassword_update'] != '')) {
                    $clientPassword_update = trim($_POST['clientPassword_update']);
                } else {
                    $old_pass = $_POST['old_pass'];
                    $clientPassword_update = $old_pass;
                }
                $clientEmail_update = $_POST['clientEmail_update'];
                $clientPhone_update = $_POST['clientPhone_update'];

                $update = $con->query("UPDATE `clients` SET  `client_name`='$clientName_update',`client_password`='$clientPassword_update',`client_email`='$clientEmail_update',
`client_phone`='$clientPhone_update' WHERE `client_id`='$clientID_update'");

                if ($update) {
                    echo get_success("Successfully Updated");
                } else {
                    echo get_error("Error !");
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
                                    <li class="active">CLient Edit</li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>

                        <?php
                        if ($_GET['clientId']) {

                            $get_client_id = $_GET['clientId'];

                            $query_select = $con->query("SELECT * FROM `clients` WHERE `client_id` = '{$get_client_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $client_id = $row_select['client_id'];
                            $client_name = $row_select['client_name'];
                            $client_password = $row_select['client_password'];
                            $client_email = $row_select['client_email'];
                            $client_phone = $row_select['client_phone'];
                            $client_verify = $row_select['client_verify'];

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="clientID_update" id="clientID_update" parsley-trigger="change" required value="<?php echo $client_id; ?>" class="form-control">
                                                <input type="hidden" name="old_pass" id="old_pass" parsley-trigger="change" required value="<?php echo $client_password; ?>" class="form-control">

                                                <div class="form-group">
                                                    <label for="clientName">Name</label>
                                                    <input type="text" name="clientName_update" id="clientName_update" parsley-trigger="change" required value="<?php echo $client_name; ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="clientName">Email</label>
                                                    <input type="text" name="clientEmail_update" id="clientEmail_update" parsley-trigger="change" required value="<?php echo $client_email; ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="clientName">Password</label>
                                                    <input type="password" name="clientPassword_update" id="clientPassword_update" parsley-trigger="change"  value="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="clientName">Phone</label>
                                                    <input type="text" name="clientPhone_update" id="clientPhone_update" parsley-trigger="change" required value="<?php echo $client_phone; ?>" class="form-control">
                                                </div>

                                                <br>
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="client_update" id="updateUser">Update</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

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