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

                $product_id = $_POST['product_id'];
                $parent_cat_id=$_POST['parent_cat'];


                $errors = array();

                if (empty($product_id)) {
                    $errors[] = "Please Insert All Fields ";
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {

                    $add_parent_cat = add_latest($product_id,$parent_cat_id);

                    echo get_success("Added Successfully");
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
                                <h4 class="page-title">  Latest items </h4>
                                <ol class="breadcrumb">
                                    <li><a href="offer_view.php"> Latest items  </a></li>
                                    <li class="active">  Add New item To Latest </li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>

                                        <div class="form-group col-md-3">
                                            <label class="control-label">  Parent Categories </label>
                                            <select class="form-control select2m" name="parent_cat" id="parent_cat" required>
                                                <option value="0"> Choose  </option>
                                                <?php
                                                $query = $con->query("SELECT * FROM `parent_categories`  ORDER BY `parent_category_id` ASC");
                                                while ($row = mysqli_fetch_assoc($query)) {
                                                    $parent_category_id = $row['parent_category_id'];
                                                    $name_ar = $row['parent_category_name'];
                                                    echo "<option value='{$parent_category_id}'>{$name_ar}</option>";
                                                }
                                                ?>
                                            </select>											
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label class="control-label"> Item </label>
                                            <select class="form-control select2m" name="product_id" id="product_id" required>
                                                <?php
                                                
                                                // $query = $con->query("SELECT * FROM `products` where `display` =1 ORDER BY `id` ASC");
                                                // while ($row = mysqli_fetch_assoc($query)) {
                                                //     $product_id = $row['id'];
                                                //     $product_name_ar = $row['product_name_ar'];
                                                //     echo "<option value='{$product_id}'>{$product_name_ar}</option>";
                                                // }
                                                
                                                ?>
                                            </select>											
                                        </div>

                                        <br />
                                        <div class="clearfix"></div>
                                           <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit"> Add </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancell </button>
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
            $('.select2m').select2({
                placeholder: "Select",
                width: 'auto',
                allowClear: true
            });
            
            $("#parent_cat").on('change', function (){
                // alert("sss");
                var parent_cat = $(this).val();
                var dataString = 'parent_cat_id_products=' + parent_cat;
               
                $.ajax({
                    type: "POST",
                    url: "functions/slider_functions.php",
                    data: dataString,
                    dataType: 'text',
                    cache: false,
                    success: function (html) {
                        console.log(html);
                        $('#product_id option').remove();
                        $('#product_id').removeAttr('disabled');
                        $('#product_id').append(html);
                        
                    }, error: function (html) {
                        alert(html);
                    }
                });

            });
            
            
        </script>
        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item202").addClass("active");
            });
        </script>

    </body>
</html>