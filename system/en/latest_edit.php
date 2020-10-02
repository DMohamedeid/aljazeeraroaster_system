<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
// if (($_SESSION['cat_and_sub'] != '1')) {
//     header("Location: error.php");
//     exit();
// }
?>

<?php
// error_reporting(0);

if (isset($_POST['parent_cat_update'])) {

    $latest_id_update = $_POST['latest_id_update'];
    $product_id = $_POST['product_id'];
    $parent_cat_id=$_POST['parent_cat'];

    $errors = array();

    // if (empty($title_en)) {
    //     $errors[] = "من فضلك ادخل جميع الحقول !";
    // } else {
        
    // }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {


        $update = $con->query("UPDATE `latest` SET  `product_id`='$product_id',`parent_category_id`='$parent_cat_id' WHERE `id`='$latest_id_update'");
    }
    echo get_success("Updated Successfully ");
    echo "<meta http-equiv='refresh' content='0'>";
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
                                <h4 class="page-title"> Latest Items </h4>
                                <ol class="breadcrumb">
                                    <li><a href="latest_view.php"> Latest Items </a></li>
                                    <li class="active"> Update Latest Items </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData">

                            <?php
                            if (isset($_GET['latestId'])) {
                                $get_latest_id = $_GET['latestId'];
                                $query_select = $con->query("SELECT * FROM `latest` WHERE `id` = '{$get_latest_id}' LIMIT 1");
                                $row_select = mysqli_fetch_array($query_select);

                                $latest_id = $row_select['id'];
                                $get_product_id = $row_select['product_id'];
                                $parent_category_id_data=$row_select['parent_category_id'];


                                if ($query_select) {
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card-box"> 									
                                                <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                    <input type="hidden" name="latest_id_update" id="latest_id_update" parsley-trigger="change" required value="<?php echo $latest_id; ?>" class="form-control">
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label class="control-label">  Parent Categories </label>
                                                        <select class="form-control select2m" name="parent_cat" id="parent_cat" required>
                                                            <option value="0"> Choose </option>
                                                            <?php
                                                            $query = $con->query("SELECT * FROM `parent_categories`  ORDER BY `parent_category_id` ASC");
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                                $parent_category_id = $row['parent_category_id'];
                                                                $name_ar = $row['parent_category_name'];
                                                                if($parent_category_id_data==$parent_category_id){$selected="selected";}else{$selected="";}
                                                                echo "<option {$selected} value='{$parent_category_id}'>{$name_ar}</option>";
                                                            }
                                                            ?>
                                                        </select>											
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="product_id"> Item</label>
                                                        <select class="form-control select2m" name="product_id" id="product_id_update" required parsley-trigger="change">
                                                            <?php
                                                            $query = $con->query("SELECT * FROM `sub_categories` where `parent_category_id`='$parent_category_id_data' AND `display` =1 ORDER BY `sub_category_id` ASC");
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
                                                    
                                                    <div class="clearfix"></div>
                                                    <div class="form-group text-right m-b-0">
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="parent_cat_update" id="parent_cat_update">Update</button>
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
                $("#item202").addClass("active");
            });
            
            
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