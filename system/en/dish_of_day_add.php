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

<?php
if (isset($_POST['submit'])) {


    $parent_category_id = $_POST['parent_category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $show_date = $_POST['show_date'];
    $dish_image = $_FILES['dish_photo']['name'];
    $dish_tmp = $_FILES['dish_photo']['tmp_name'];
    $errors = array();
    if (empty($parent_category_id)) {
        $errors[] = "Please enter all fields !";
    }
    if (dish_exists($show_date) === true) {
        $errors[] = "The dish has already been added";
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {

        $add_dish_of_day = add_dish_of_day($parent_category_id, $sub_category_id, $show_date, $dish_image);
        $id = mysqli_insert_id($con);
        if (!file_exists("../api/uploads/dish/" . $id)) {
            mkdir("../api/uploads/dish/" . $id, 0777, true);
        }
        $image_path = "../api/uploads/dish/" . mysqli_insert_id($con) . '/';
        $target_path = $image_path . round(microtime(true)) . '.' . "jpg";

        $image_database = "{$sit_url}/api/uploads/dish/" . mysqli_insert_id($con) . "/" . round(microtime(true)) .
                '.' . "jpg";

        $update = $con->query("UPDATE `dish_of_day` SET `image`='$image_database' WHERE `id`='$id'");



        if (move_uploaded_file($dish_tmp, $target_path)) {

        }
        echo get_success("Successfully added");
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
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">  New items</h4>
                                <ol class="breadcrumb">
                                    <li><a href="dish_of_day_view.php"> New items</a></li>
                                    <li class="active"> Add New item</li>
                                </ol>
                            </div>
                        </div>

                        <div class="deleteData"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b> New Items </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>

                                    <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                        <div class="form-group">
                                            <label class="control-label">Parent Categories </label>
                                            <select class="form-control select2me" name="parent_category_id" id="parent_category_id" required>
                                                <option value=''>Choose</option>

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
                                        <div class="form-group">
                                            <label class="control-label">Sub Categories  </label>
                                            <select class="form-control" name="sub_category_id" id="sub_category_id" required>


                                            </select>											
                                        </div>
                                        	
                                        <div class="form-group col-md-6">
                                            <label class = "col-md-2 control-label">Show Date   </label>
                                            <div class = "col-md-10  date-picker input-daterange" data-date ="10/11/2012" data-date-format ="yyyy-mm-dd">
                                                <input  type = "text" required="" name = "show_date" readonly = "" class = "form-control date-picker input-sm"  placeholder = "mm/dd/yyyy" > 
                                            </div>
                                        </div>
                                        <div class='clearfix'></div>

                                        <div class="form-group m-b-0">
                                            <label class="control-label"> Image</label>
                                            <input type="file" required name="dish_photo" id="dish_photo" class="filestyle" multiple data-buttonname="btn-primary">
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