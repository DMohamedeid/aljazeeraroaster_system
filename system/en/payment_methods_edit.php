<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
?>

<?php
// error_reporting(0);

if (isset($_POST['payment_method_update'])) {


    $payment_method_id_update = $_POST['payment_method_id_update'];
    
    $payment_method_name_ar = $_POST['payment_method_name_ar'];
    
    $payment_method_name_en = $_POST['payment_method_name_en'];

    $display = $_POST['display'];

    $errors = array();


    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {
        $update = $con->query("UPDATE `payment_methods` SET `name_ar`='$payment_method_name_ar', `name_en`='$payment_method_name_en', `display`='$display' WHERE `id`='$payment_method_id_update'");

        if ($update) {
            echo get_success("Updated Successfully");
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo get_error("Error !");
        }
    }
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

            <div class="content-page">
                <div class="content">
                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Payment Methods</h4>
                                <ol class="breadcrumb">
                                    <li><a href="payment_methods_edit.php">Payment Methods</a></li>
                                    <li class="active">Edit Payment Method</li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>
                        <?php
                        if ($_GET['payment_method_id']) {

                            $payment_method_id = $_GET['payment_method_id'];

                            $query_select = $con->query("SELECT * FROM `payment_methods` WHERE `id` = '{$payment_method_id}' LIMIT 1");
                            
                            $row_select = mysqli_fetch_array($query_select);

                            $payment_method_id = $row_select['id'];
                            
                            $payment_method_name_en = $row_select['name_en'];
                            
                            $payment_method_name_ar = $row_select['name_ar'];

                            $display = $row_select['display'];

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                            
                                                <input type="hidden" name="payment_method_id_update" id="payment_method_id_update" parsley-trigger="change" required value="<?php echo $payment_method_id; ?>" class="form-control">
                                                
                                                <div class="form-group col-md-3">
                                                    <label for="payment_method_name_ar">Payment Method Name AR</label>
                                                    <input type="text" name="payment_method_name_ar" id="payment_method_name_ar" parsley-trigger="change" required value="<?php echo $payment_method_name_ar; ?>" class="form-control">
                                                </div>
                                                
                                                <div class="form-group col-md-3">
                                                    <label for="payment_method_name_en">Payment Method Name EN</label>
                                                    <input type="text" name="payment_method_name_en" id="payment_method_name_en" parsley-trigger="change" required value="<?php echo $payment_method_name_en; ?>" class="form-control">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Status</label>
                                                    <select class="form-control" name="display" required parsley-trigger="change">
                                                        <option value="1" <?php
                                                        if ($display == '1') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Show</option>
                                                        <option value="0"  <?php
                                                        if ($display == '0') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Hide</option>
                                                    </select>
                                                </div>
                                                
                                                <br>
                                                <div class="clearfix"></div>
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="payment_method_update" id="payment_method_update">Update</button>
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
                $("#item666").addClass("active");
            });
        </script>

    </body>
</html>