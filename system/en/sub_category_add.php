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
    <style>.red {
            /* color: #FFFFFF; */
            background-color: #cb5a5e;
        }</style>
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

                $parent_category_id = $_POST['parent_category_id'];
                $sub_cat_name = mysqli_real_escape_string($con, trim($_POST['sub_cat_name']));
                $sub_cat_desc = mysqli_real_escape_string($con, trim($_POST['sub_cat_desc']));
                $sub_cat_name_ar = mysqli_real_escape_string($con, trim($_POST['sub_cat_name_ar']));
                $sub_cat_desc_ar = mysqli_real_escape_string($con, trim($_POST['sub_cat_desc_ar']));

                $display = $_POST['display'];
                $points_num=$_POST['points_num'];



                $sub_cat_image = $_FILES['sub_cat_photo']['name'];
                $sub_cat_tmp = $_FILES['sub_cat_photo']['tmp_name'];


                $sub_cat_size_name = $_POST['size'];
                $sub_cat_size_name_ar = $_POST['size_ar'];
                $sub_cat_size_price = $_POST['size_price'];

                $errors = array();

                if (empty($sub_cat_name)) {
                    $errors[] = "Please enter all fields !";
                } else {
                    
                }
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {

                    $add_sub_cat = add_sub_cat($points_num,$sub_cat_name, $sub_cat_name_ar, $sub_cat_desc, $sub_cat_desc_ar, $parent_category_id, $sub_cat_image, $display);
                    $id = mysqli_insert_id($con);
                    if (!file_exists("../api/uploads/sub_category/" . $id)) {
                        mkdir("../api/uploads/sub_category/" . $id, 0777, true);
                    }
                    $image_path = "../api/uploads/sub_category/" . mysqli_insert_id($con) . "/";
                    $image_database = "{$sit_url}/api/uploads/sub_category/" . mysqli_insert_id($con) . "/" . round(microtime(true)) . '.' . "jpg";
                    $target_path = $image_path . round(microtime(true)) . '.' . "jpg";

                    $update = $con->query("UPDATE `sub_categories` SET `sub_category_image`='$image_database' WHERE `sub_category_id`='$id'");



                    if (move_uploaded_file($sub_cat_tmp, $target_path)) {
                        
                    }
                    $add_sub_cat_size_prices = add_sub_cat_size_prices($sub_cat_size_name, $sub_cat_size_name_ar, $sub_cat_size_price);

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
                                <h4 class="page-title"> Sub Categories  </h4>
                                <ol class="breadcrumb">
                                    <li><a href="sub_category_view.php">Sub Categories </a></li>
                                    <li class="active">Add New Sub Category    </li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b> Add New Sub Category    </b></h4>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>


                                        <div class="form-group col-md-3">
                                            <label class="control-label">Parent Category </label>
                                            <select class="form-control select2me" name="parent_category_id" id="parent_category_id" required>
                                                <?php
                                                $query = $con->query("SELECT * FROM `parent_categories` ORDER BY `parent_category_id` ASC");
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    $parent_category_id = $row['parent_category_id'];
                                                    $parent_category_name = $row['parent_category_name'];
                                                    echo "<option value='{$parent_category_id}'>{$parent_category_name}</option>";
                                                }
                                                ?>
                                            </select>											
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="sub_cat_name"> Sub Category Name English  </label>
                                            <input type="text" name="sub_cat_name" parsley-trigger="change" required placeholder="Name EN" class="form-control" id="sub_cat_name">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="sub_cat_name_ar"> Sub Category Name Arabic  </label>
                                            <input type="text" name="sub_cat_name_ar" parsley-trigger="change"  placeholder="Name AR" class="form-control" id="sub_cat_name">
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="form-group col-md-3">
                                            <label for="sub_cat_desc"> English Description</label>
                                            <textarea class="form-control" rows="3" name="sub_cat_desc"  minlength="3" maxlength="1000" ></textarea>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="sub_cat_desc_ar"> Arabic Description</label>
                                            <textarea class="form-control" rows="3" name="sub_cat_desc_ar"  minlength="3" maxlength="1000" ></textarea>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="points_num">  Number Of Points</label>
                                            <input type="number"  step='0.01' min='0' name="points_num" id="points_num" parsley-trigger="change"  class="form-control">
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">  Status</label>
                                            <select class="form-control" name="display" required parsley-trigger="change">
                                                <option value="1" >Show</option>
                                                <option value="0">Hidden</option>
                                            </select>
                                        </div>	

                                        <div class="form-group m-b-0">
                                            <label class="control-label"> Image</label>
                                            <input type="file" name="sub_cat_photo" id="sub_cat_photo" class="filestyle" multiple data-buttonname="btn-primary">
                                        </div>
                                        <br />										
                                        <div class="form-group optionBox_two" style="position: relative;">
                                            <label class="control-label">sizes</label>
                                            <div class="block_two">
                                                <input name="size[]" type="text" parsley-trigger="change" required placeholder="Size EN " class="form-control thisField">
                                                <input name="size_ar[]" type="text" parsley-trigger="change" required placeholder="Size AR " class="form-control thisField">
                                                <input name="size_price[]" type="number" min="0" step="0.01" parsley-trigger="change" required placeholder="Price" class="form-control thisField">
                                                <!--<button class="btn add-remove remove-me remove_two" type="button">-</button>-->
                                            </div>
                                            <br>
                                            <div class="block_two">
                                                <span class="btn add-more add_two">+</span>
                                            </div>											
                                        </div>
                                        <br />

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
            <!-- END wrapper -->
            <?php include("include/footer.php"); ?>

            <script>
                $("#branch_id").change(function () {
                    var branch_id = $(this).val();
                    var dataString = 'parent_categories_by_branch_id=' + branch_id;
                    $.ajax({
                        type: "POST",
                        url: "functions/sub_cat_functions.php",
                        data: dataString,
                        dataType: 'text',
                        cache: false,
                        success: function (html) {
                            $("#parent_category_id").html(html);
                        }
                    });

                });
            </script>
            <script>

                $("#spicy_show").change(function () {
                    var spicy_show = $(this).val();
                    if (spicy_show == 1) {
                        $("#spicy_type").show();
                    } else {
                        $('#spicy_type').css('display', 'none');
                    }
                });
            </script>
            <script>
                $('.add').click(function () {
                    $('.block:last').before('<div class="block"><input name="addition[]" type="text" parsley-trigger="change" required placeholder="Add" class="form-control thisField"><input name="addition_price[]" type="text" parsley-trigger="change" required placeholder="Price" class="form-control thisField"><button class="btn add-remove remove-me remove" type="button">-</button></div>');
                });
                $('.optionBox').on('click', '.remove', function () {
                    $(this).parent().remove();
                });
                $('.add_two').click(function () {
                    $('.block_two:last').before('<div class="block_two"><input name="size[]" type="text" parsley-trigger="change" required placeholder="Size EN " class="form-control thisField"><input name="size_ar[]" type="text" parsley-trigger="change" required placeholder="Size AR " class="form-control thisField"><input name="size_price[]" type="number" min="0" step="0.01" parsley-trigger="change" required placeholder="price" class="form-control thisField"><button class="btn add-remove remove-me remove_two" type="button">-</button></div>');
                });
                $('.optionBox_two').on('click', '.remove_two', function () {
                    $(this).parent().remove();
                });
            </script>

            <script>
                $(document).ready(function () {
                    $("#cssmenu ul>li").removeClass("active");
                    $("#item3").addClass("active");
                });
            </script>
            <script type="text/javascript">
                $('.select2me').select2({
                    placeholder: "Select",
                    width: 'auto',
                    allowClear: true
                });
            </script>
    </body>
</html>