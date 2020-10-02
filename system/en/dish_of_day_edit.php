<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['dishs'] != '1')) {
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
            if (isset($_POST['update_dish'])) {
                $dish_id = $_POST['dish_id'];
                $parent_category_id = $_POST['parent_category_id'];
                $sub_category_id = $_POST['sub_category_id'];
                $show_date = $_POST['show_date'];
                $check = getDishById($dish_id);
                $errors = array();
                if (empty($parent_category_id)) {
                    $errors[] = "Please enter all fields!";
                }
                if (dish_exists($show_date) && ($show_date != $check)) {
                    $errors[] = "The dish has already  added";
                }
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {
                    if (isset($_FILES['dish_image_update']['name']) && !empty($_FILES['dish_image_update']['name'])) {
                        $image_ext_old = $_POST['image_ext_old'];
                        $mostafa = explode('/', $image_ext_old);
                        $image_name = $mostafa[8];
                        $full_img_path = dirname(__FILE__) . "/../api/uploads/dish/{$dish_id}/{$image_name}";
                        if (file_exists($full_img_path)) {
                            @unlink($full_img_path);
                        }


                        $image_name_update = $_FILES['dish_image_update']['name'];
                        $image_tmp_update = $_FILES['dish_image_update']['tmp_name'];
                        $allowed_ext = array('jpg', 'jpeg', 'gif', 'png');
                        $get_image_ext = explode('.', $image_name_update);
                        $image_ext = strtolower(end($get_image_ext));


                        $image_path = "../api/uploads/dish/" . $dish_id . "/";
                        $image_database = "{$sit_url}/api/uploads/dish/" . $dish_id . "/" . round(microtime(true)) . '.' . "jpg";
                        $target_path = $image_path . round(microtime(true)) . '.' . "jpg";


                        $update = $con->query("UPDATE `dish_of_day` SET `show_date`='$show_date',`image`='$image_database',`sub_category_id`='$sub_category_id',`parent_category_id`='$parent_category_id' WHERE `id`='$dish_id'");


                        if (move_uploaded_file($image_tmp_update, $target_path)) {

                        }
                    } else {
                        $update = $con->query("UPDATE `dish_of_day` SET  `show_date`='$show_date',`sub_category_id`='$sub_category_id',`parent_category_id`='$parent_category_id' WHERE `id`='$dish_id'");
                        echo "UPDATE `dish_of_day` SET `type`='$type',`show_date`='$show_date',`sub_category_id`='$sub_category_id',`parent_category_id`='$parent_category_id' WHERE `id`='$dish_id'";
                    }

                    if ($update) {
                        echo get_success("Successfully Updated");
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        echo get_error("Here's a error!");
                    }
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
                                <h4 class="page-title">  New items </h4>
                                <ol class="breadcrumb">
                                    <li><a href="dish_of_day_view.php"> New items </a></li>
                                    <li class="active"> Edit Item   </li>
                                </ol>
                            </div>
                        </div>

                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                    if ($_GET['dish_of_day_id']) {

                                        $dish_of_day_id = $_GET['dish_of_day_id'];
                                        $query_select = $con->query("SELECT * FROM `dish_of_day` WHERE `id` = '{$dish_of_day_id}' LIMIT 1");
                                        $row_select = mysqli_fetch_array($query_select);

                                        $id = $row_select['id'];
                                        $sub_category_id = $row_select['sub_category_id'];
                                        $parent_category_id = $row_select['parent_category_id'];
                                        $show_date = $row_select['show_date'];
                                        $image = $row_select['image'];

                                        if ($query_select) {
                                            ?>


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card-box">
                                                        <p class="text-muted font-13 m-b-30"></p>
                                                        <input type='hidden' name='dish_id' value='<?php echo $id; ?>'>
                                                        <div class="form-group">
                                                            <label for="userName"> Parent Categories</label>
                                                            <select class="form-control select2me" name="parent_category_id" id="parent_category_id" required parsley-trigger="change">
                                                                <?php
                                                                $query = $con->query("SELECT * FROM `parent_categories` ORDER BY `parent_category_id` ASC");
                                                                while ($row = mysqli_fetch_assoc($query)) {
                                                                    $parent_cat_id = $row['parent_category_id'];
                                                                    $parent_category_name = $row['parent_category_name'];
                                                                    if ($parent_category_id == $parent_cat_id) {
                                                                        echo "<option value='{$parent_cat_id}' selected='selected'>{$parent_category_name}</option>";
                                                                    } else {
                                                                        echo "<option value='{$parent_cat_id}'>{$parent_category_name}</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>					
                                                        </div>	
                                                        <br>
                                                        <div class="form-group">
                                                            <label class="control-label">Sub Categories  </label>
                                                            <select class="form-control" name="sub_category_id" id="sub_category_id" required>
                                                                <option value="">Choose  </option>
                                                                <?php
                                                                $query = $con->query("SELECT * FROM `sub_categories` where `parent_category_id`='{$parent_category_id}'  ");
                                                                while ($row = mysqli_fetch_assoc($query)) {
                                                                    $sub_cat_id = $row['sub_category_id'];
                                                                    $sub_category_name = $row['sub_category_name'];
                                                                    ?>
                                                                    <option value='<?php echo $sub_cat_id; ?>'  <?php
                                                                    if ($sub_category_id == $sub_cat_id) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>><?php echo $sub_category_name; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>

                                                            </select>											
                                                        </div>
                                                       
                                                        <div class="form-group col-md-6">
                                                            <label class = "col-md-2 control-label">Show Date   </label>
                                                            <div class = "col-md-10  date-picker input-daterange" data-date ="10/11/2012" data-date-format ="yyyy-mm-dd">
                                                                <input  type = "text" value='<?php echo $show_date; ?>' required="" name = "show_date" readonly = "" class = "form-control date-picker input-sm"  placeholder = "mm/dd/yyyy" > </div>
                                                        </div>
                                                        <div class='clearfix'></div>

                                                        <br>

                                                        <input type="hidden" name="image_ext_old" value="<?php echo $image; ?>" />
                                                        <div class="form-group m-b-0">
                                                            <label for="image"> Image <a class="showImg">Edit?</a> </label>								

                                                            <div class="gal-detail thumb getImage">
                                                                <a href="<?php echo $image; ?>" class="image-popup" title="<?php echo $image; ?>">
                                                                    <img src="<?php echo $image; ?>" class="thumb-img" alt="<?php echo $image; ?>">
                                                                </a>
                                                            </div>					

                                                            <div class="form-group m-b-0">
                                                                <label class="control-label">Image </label>
                                                                <input type="file" name="dish_image_update" id="dish_image_update" class="filestyle" data-buttonname="btn-primary">
                                                            </div>
                                                            <div class="form-group text-right m-b-0">
                                                                <button class="btn btn-primary waves-effect waves-light " type="submit" name="update_dish"> Update </button>
                                                                <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancel </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>			
                                            </div>			
                                            </form>

                                        </div>
                                        <?php include("include/footer_text.php"); ?>

                                    </div>			
                                    <?php
                                }
                            }
                            ?>
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

                        $('.optionBox').on('click', '.remove', function () {
                            $(this).parent().remove();
                        });

                        $(document).ready(function () {
                            $("#parent_category_id").change(function () {
                                var get_sub_category_by_parent_category_id = $(this).val();

                                var dataString = 'get_sub_category_by_parent_category_id=' + get_sub_category_by_parent_category_id;
                                $.ajax({
                                    type: "POST",
                                    url: "functions/sub_cat_functions.php",
                                    data: dataString,
                                    dataType: 'text',
                                    cache: false,
                                    success: function (html) {
                                        $("#sub_category_id").html(html);
                                    }
                                });

                            });
                        });
                    </script>
                    <script>
                        $(document).ready(function () {
                            $("#cssmenu ul>li").removeClass("active");
                            $("#item59").addClass("active");
                        });
                    </script>
                    <script type="text/javascript">
                        $('.date-picker').datepicker();
                        $('.select2me').select2({
                            placeholder: "Select",
                            width: 'auto',
                            allowClear: true
                        });
                    </script>
                    </body>
                    </html>