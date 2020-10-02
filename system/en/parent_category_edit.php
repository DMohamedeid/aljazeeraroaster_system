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

<?php
// error_reporting(0);

if (isset($_POST['parent_cat_update'])) {

    $parent_category_id_update = $_POST['parent_cat_id_update'];

    $parent_category_name = $_POST['parent_cat_name'];

    $parent_category_desc = $_POST['parent_cat_desc'];
    $parent_category_name_ar = $_POST['parent_cat_name_ar'];

    $parent_category_desc_ar = $_POST['parent_cat_desc_ar'];
    $display = $_POST['display'];
    $arrangement = $_POST['arrangement'];



    $errors = array();
    if (parent_category_arrange_exists($arrangement) && $arrangement != getArrangeById($parent_category_id_update)) {
        $errors[] = "This arrangement already exists!";
    }

    if (empty($parent_category_name)) {
        $errors[] = "Please enter all fields !";
    } else {
        
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {

        if (isset($_FILES['parent_cat_photo_update']['name']) && !empty($_FILES['parent_cat_photo_update']['name'])) {
            $image_ext_old = $_POST['image_ext_old'];
            $mostafa = explode('/', $image_ext_old);
            $image_name = $mostafa[8];
            $full_img_path = dirname(__FILE__) . "/../api/uploads/parent_category/{$parent_category_id_update}/{$image_name}";
            if (file_exists($full_img_path)) {
                @unlink($full_img_path);
            }
                if (!file_exists("../api/uploads/parent_category/" . $parent_category_id_update)) {
                        mkdir("../api/uploads/parent_category/" . $parent_category_id_update, 0777, true);
                    }


            $parent_cat_photo_name_update = $_FILES['parent_cat_photo_update']['name'];
            $parent_cat_photo_tmp_update = $_FILES['parent_cat_photo_update']['tmp_name'];


            $image_path = "../api/uploads/parent_category/" . $parent_category_id_update . "/";
            $image_database = "{$sit_url}/api/uploads/parent_category/" . $parent_category_id_update . "/" . round(microtime(true)) . '.' . "jpg";

            $target_path = $image_path . round(microtime(true)) . '.' . "jpg";


            $update = $con->query("UPDATE `parent_categories` SET  `arrangement`='$arrangement',`display`='$display', `parent_category_name_ar`='$parent_category_name_ar',`parent_category_desc_ar`='$parent_category_desc_ar', `parent_category_name`='$parent_category_name',`parent_category_desc`='$parent_category_desc',`parent_category_image`='$image_database' WHERE `parent_category_id`='$parent_category_id_update'");


            if (move_uploaded_file($parent_cat_photo_tmp_update, $target_path)) {
                
            }
        } else {

            $update = $con->query("UPDATE `parent_categories` SET  `arrangement`='$arrangement',`display`='$display', `parent_category_name_ar`='$parent_category_name_ar',`parent_category_desc_ar`='$parent_category_desc_ar', `parent_category_name`='$parent_category_name',`parent_category_desc`='$parent_category_desc' WHERE `parent_category_id`='$parent_category_id_update'");
        }
        echo get_success("Successfully updated");
        echo "<meta http-equiv='refresh' content='0'>";
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
                                <h4 class="page-title">Parent Categories</h4>
                                <ol class="breadcrumb">
                                    <li><a href="parent_category_view.php"> Parent Categories</a></li>
                                    <li class="active">Edit Parent Category </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData">

                            <?php
                            if (isset($_GET['catId'])) {
                                $get_parent_cat_id = $_GET['catId'];
                                $query_select = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id` = '{$get_parent_cat_id}' LIMIT 1");
                                $row_select = mysqli_fetch_array($query_select);

                                $parent_category_id = $row_select['parent_category_id'];
                                $display = $row_select['display'];
                                $parent_category_name = $row_select['parent_category_name'];
                                $parent_category_name_ar = $row_select['parent_category_name_ar'];
                                $parent_category_desc = $row_select['parent_category_desc'];
                                $parent_category_desc_ar = $row_select['parent_category_desc_ar'];
                                $parent_category_image = $row_select['parent_category_image'];
                                $arrangement = $row_select['arrangement'];

                                if ($query_select) {
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card-box"> 									
                                                <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                    <input type="hidden" name="parent_cat_id_update" id="parent_cat_id_update" parsley-trigger="change" required value="<?php echo $parent_category_id; ?>" class="form-control">

                                                    <div class="form-group col-md-3">
                                                        <label for="parent_cat_name"> Parent Category English </label>
                                                        <input type="text" name="parent_cat_name" id="parent_cat_name_update" parsley-trigger="change"  value="<?php echo $parent_category_name; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="parent_cat_name_ar"> Parent Category Arabic </label>
                                                        <input type="text" name="parent_cat_name_ar" id="parent_cat_name_update" parsley-trigger="change"  value="<?php echo $parent_category_name_ar; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="parent_cat_desc"> Describtion English </label>
                                                        <input type="text" name="parent_cat_desc" id="parent_cat_desc_update" parsley-trigger="change"  value="<?php echo $parent_category_desc; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="parent_cat_desc_ar"> Describtion Arabic </label>
                                                        <input type="text" name="parent_cat_desc_ar" id="parent_cat_desc_update" parsley-trigger="change"  value="<?php echo $parent_category_desc_ar; ?>" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="control-label"> Status</label>
                                                        <select class="form-control" name="display"  parsley-trigger="change">
                                                            <option value="1" <?php
                                                            if ($display == '1') {
                                                                echo 'selected';
                                                            }
                                                            ?>>show</option>
                                                            <option value="0"  <?php
                                                            if ($display == '0') {
                                                                echo 'selected';
                                                            }
                                                            ?>>hidden</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label class="control-label">  Arrangement </label>
                                                        <select class="form-control" name="arrangement"  parsley-trigger="change">
                                                            <?php for ($i = 1; $i <= 100; $i++) { ?>
                                                                <?php if ($arrangement == $i) { ?>
                                                                    <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <input type="hidden" name="image_ext_old" value="<?php echo $parent_category_image; ?>" />
                                                    <div class="form-group m-b-0">
                                                        <label for="userName">image  <a class="showImg">Edit?</a> </label>								

                                                        <div class="gal-detail thumb getImage">
                                                            <a href="<?php echo $parent_category_image; ?>" class="image-popup" title="<?php echo $parent_category_name; ?>">
                                                                <img src="<?php echo $parent_category_image; ?>" class="thumb-img" alt="<?php echo $parent_category_name; ?>">
                                                            </a>
                                                        </div>					

                                                        <div class="form-group m-b-0">
                                                            <label class="control-label">Image </label>
                                                            <input type="file" name="parent_cat_photo_update" id="parent_cat_photo_update" class="filestyle" data-buttonname="btn-primary">
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="form-group text-right m-b-0">
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="parent_cat_update" id="parent_cat_update">Update</button>
                                                    </div>
                                                </form>								
                                            </div>
                                        </div>
                                    </div>          
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('.image-popup').magnificPopup({
                                                type: 'image',
                                                closeOnContentClick: true,
                                                mainClass: 'mfp-fade',
                                                gallery: {
                                                    enabled: true,
                                                    navigateByImgClick: true,
                                                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                                                }
                                            });
                                        });
                                    </script>
                                    <?php
                                }
                            }
                            ?>

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