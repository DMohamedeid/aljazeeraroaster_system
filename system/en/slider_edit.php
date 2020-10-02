<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
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

            if (isset($_POST['slider_update'])) {

                $sliderID_update = $_POST['sliderID_update'];
                $product_id = $_POST['product_id'];
                $parent_cat_id = $_POST['parent_cat'];
                if (isset($_FILES['image_update']['name']) && !empty($_FILES['image_update']['name'])) {

                    $image_ext_old = $_POST['image_ext_old'];
                    $mostafa = explode('/', $image_ext_old);
                    $image_name = $mostafa[7];
                    $full_img_path = "../api/uploads/slider/$sliderID_update" . "/" . $image_name;
                    if (file_exists($full_img_path)) {
                        @unlink($full_img_path);
                    }

                    if (!file_exists("../api/uploads/slider/" . $sliderID_update)) {
                        mkdir("../api/uploads/slider/" . $sliderID_update, 0777, true);
                    }

                    $image_name_update = $_FILES['image_update']['name'];
                    $image_tmp_update = $_FILES['image_update']['tmp_name'];

                    $image_path = "../api/uploads/slider/$sliderID_update" . "/" . $image_name_update;
                    $image_database = "{$sit_url}/api/uploads/slider/$sliderID_update" . "/" . $image_name_update;

                    $update = $con->query("UPDATE  `slider` SET `product_id`='$product_id',`image`='$image_database' ,`parent_category_id`='$parent_cat_id' WHERE `id`='$sliderID_update'");

                    if (move_uploaded_file($image_tmp_update, $image_path)) {
                        
                    }

                    if ($update) {
                        echo get_success("Updated Successfully ");
                    } else {
                        echo get_error("there's an error ");
                    }
                } else {
                    $update = $con->query("UPDATE  `slider` SET `product_id`='$product_id' ,`parent_category_id`='$parent_cat_id' WHERE `id`='$sliderID_update'");
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
                                <h4 class="page-title">Slider </h4>
                                <ol class="breadcrumb">
                                    <li><a href="slider_view.php">Slider  </a></li>
                                    <li class="active"> Update Slider  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>

                        <?php
                        if ($_GET['sliderID']) {

                            $get_slider_id = $_GET['sliderID'];

                            $query_select = $con->query("SELECT * FROM `slider` WHERE `id` = '{$get_slider_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $id = $row_select['id'];
                            $image = $row_select['image'];
                            $parent_category_id_data = $row_select['parent_category_id'];
                            $get_product_id = $row_select['product_id'];

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="sliderID_update" id="sliderID_update" parsley-trigger="change" required value="<?php echo $id; ?>" class="form-control">


                                                <div class="form-group col-md-3">
                                                    <label class="control-label">  Parent Categories  </label>
                                                    <select class="form-control select2m" name="parent_cat" id="parent_cat" required>
                                                        <option value="0"> Choose </option>
                                                        <?php
                                                        $query = $con->query("SELECT * FROM `parent_categories`  ORDER BY `parent_category_id` ASC");
                                                        while ($row = mysqli_fetch_assoc($query)) {

                                                            $parent_category_id = $row['parent_category_id'];
                                                            if ($parent_category_id_data == $parent_category_id) {
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                            $name_ar = $row['parent_category_name'];
                                                            echo "<option {$selected} value='{$parent_category_id}'>{$name_ar}</option>";
                                                        }
                                                        ?>
                                                    </select>											
                                                </div>


                                                <div class="form-group col-md-3">
                                                    <label for="product_id"> Sub Category </label>
                                                    <select class="form-control select2m" name="product_id" id="product_id_update" required parsley-trigger="change">
                                                        <?php
                                                        $query = $con->query("SELECT * FROM `sub_categories` WHERE `parent_category_id`='$parent_category_id_data'  ORDER BY `sub_category_id` ASC");
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                            $product_id = $row['sub_category_id'];
                                                            $product_name_ar = $row['sub_category_name'];
                                                            if ($get_product_id == $product_id) {
                                                                echo "<option value='{$product_id}' selected='selected'>{$product_name_ar}</option>";
                                                            } else {
                                                                echo "<option value='{$product_id}'>{$product_name_ar}</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>					
                                                </div>
                                                <input type="hidden" name="image_ext_old" value="<?php echo $image; ?>" />
                                                <div class="form-group m-b-0">
                                                    <label for="image"> Image * <a class="showImg">update ?</a> </label>								

                                                    <div class="gal-detail thumb getImage">
                                                        <a href="<?php echo $image; ?>" class="image-popup" title="image">
                                                            <img src="<?php echo $image; ?>" class="thumb-img" alt="image">
                                                        </a>
                                                    </div>					

                                                    <div class="form-group m-b-0">
                                                        <label class="control-label"> Image slider </label>
                                                        <input type="file" name="image_update" id="image_update" class="filestyle" data-buttonname="btn-primary">
                                                    </div>

                                                </div>
                                                <br>
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="slider_update" id="updateMenu">تحديث</button>
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
                $("#cssslider ul>li").removeClass("active");
                $("#item5").addClass("active");

                $("#parent_cat").on('change', function () {
                    // alert("sss");
                    var parent_cat = $(this).val();
                    var dataString = 'parent_cat_id_products=' + parent_cat;
                    console.log(dataString);
                    $.ajax({
                        type: "POST",
                        url: "functions/slider_functions.php",
                        data: dataString,
                        dataType: 'text',
                        cache: false,
                        success: function (html) {
                            console.log(html);
                            $('#product_id_update option').remove();
                            $('#product_id_update').removeAttr('disabled');
                            $('#product_id_update').append(html);

                        }, error: function (html) {
                            alert(html);
                        }
                    });

                });


            });
        </script>	
        <script>
            $('.select2m').select2({
                placeholder: "Select",
                width: 'auto',
                allowClear: true
            });
        </script>

    </body>
</html>