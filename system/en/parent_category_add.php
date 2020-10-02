<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['cat_and_sub'] != '1')) {
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

                $parent_cat_name = mysqli_real_escape_string($con, trim($_POST['parent_cat_name']));
                $parent_cat_desc = mysqli_real_escape_string($con, trim($_POST['parent_cat_desc']));
                $parent_cat_name_ar = mysqli_real_escape_string($con, trim($_POST['parent_cat_name_ar']));
                $parent_cat_desc_ar = mysqli_real_escape_string($con, trim($_POST['parent_cat_desc_ar']));

                $display = $_POST['display'];
                $arrangement = $_POST['arrangement'];
                $parent_cat_photo_name = $_FILES['parent_cat_photo']['name'];
                $parent_cat_photo_tmp = $_FILES['parent_cat_photo']['tmp_name'];

                $errors = array();
                if (parent_category_arrange_exists($arrangement) === true) {
                    $errors[] = "This arrangement already exists!";
                }

                if (empty($parent_cat_name)) {
                    $errors[] = "Please enter all fields !";
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {


                    $add_parent_cat = add_parent_cat($arrangement, $parent_cat_name_ar, $parent_cat_desc_ar, $parent_cat_name, $parent_cat_desc, $parent_cat_photo_name, $display);

                    if (!file_exists("../api/uploads/parent_category/" . mysqli_insert_id($con))) {
                        mkdir("../api/uploads/parent_category/" . mysqli_insert_id($con), 0777, true);
                    }
                    $image_path = "../api/uploads/parent_category/" . mysqli_insert_id($con) . "/";
                    $target_path = $image_path . round(microtime(true)) . '.' . "jpg";

                    $image_database = "{$sit_url}/api/uploads/parent_category/" . mysqli_insert_id($con) . "/" . round(microtime(true)) . '.' . "jpg";
                    $update = $con->query("UPDATE `parent_categories` SET `parent_category_image`='$image_database' WHERE `parent_category_id`='" . mysqli_insert_id($con) . "'");


                    if (move_uploaded_file($parent_cat_photo_tmp, $target_path)) {
                        
                    }
                    echo get_success("Successfully Added");
                }
            }
            ?>	

            <?php // if(isset($_POST['submit'])) { echo add_user(); }     ?>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Parent Categories </h4>
                                <ol class="breadcrumb">
                                    <li><a href="parent_category_view.php">Parent Categories </a></li>
                                    <li class="active">Add Parent Category  </li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>


                                        <div class="form-group col-md-3">
                                            <label for="parent_cat_name"> Parent Category English </label>
                                            <input type="text" name="parent_cat_name" parsley-trigger="change"  placeholder="Name EN" class="form-control" id="parent_cat_name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="parent_cat_name_ar"> Parent Category Arabic  </label>
                                            <input type="text" name="parent_cat_name_ar" parsley-trigger="change"  placeholder="Name AR" class="form-control" id="parent_cat_name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="parent_cat_desc"> Describtion English </label>
                                            <input type="text" name="parent_cat_desc" parsley-trigger="change"  placeholder="Describtion EN" class="form-control" id="parent_cat_desc">
                                        </div>	
                                        <div class="form-group col-md-3">
                                            <label for="parent_cat_desc_ar"> Describtion Arabic </label>
                                            <input type="text" name="parent_cat_desc_ar" parsley-trigger="change"  placeholder="Describtion AR" class="form-control" id="parent_cat_desc">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label col-md-3"> Status </label>
                                            <select class="form-control" name="display" required parsley-trigger="change">
                                                <option value="1" >Show</option>
                                                <option value="0">Hidden</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">  Arrangement </label>
                                            <select class="form-control" name="arrangement"  parsley-trigger="change">
                                                <?php for ($i = 1; $i <= 100; $i++) { ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group m-b-0">
                                            <label class="control-label">image </label>
                                            <input type="file" name="parent_cat_photo" id="parent_cat_photo" class="filestyle" data-buttonname="btn-primary">
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

                    <?php include("include/footer_text.php"); ?>

                </div>

                <!-- End Right content here -->

                <!-- Right Sidebar -->
                <div class="side-bar right-bar nicescroll">
                    <?php include("include/rightbar.php"); ?>
                </div>
                <!-- /Right-bar -->
            </div>
        </div>
    </div>
    <!-- END wrapper -->
    <?php include("include/footer.php"); ?>
    <script type="text/javascript">
        $('.select2me').select2({
            placeholder: "Select",
            width: 'auto',
            allowClear: true
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#cssmenu ul>li").removeClass("active");
            $("#item2").addClass("active");
        });
    </script>

</body>
</html>