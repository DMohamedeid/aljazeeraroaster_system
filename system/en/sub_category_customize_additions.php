<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['adds_and_removes'] != '1')) {
    header("Location: error.php");
    exit();
}
?>

<?php
if (isset($_POST['submit'])) {

    $sub_cat_addition_name = $_POST['addition'];
    $sub_cat_addition_name_ar = $_POST['addition_ar'];
    $sub_cat_addition_price = $_POST['addition_price'];
    $parent_category_id=$_POST['parent_category_id'];
    $errors = array();

    if (empty($sub_cat_addition_name)) {
        $errors[] = "Please enter all fields !";
    } else {
        
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {

        $add_sub_cat_addition_prices = add_sub_cat_addition_prices($sub_cat_addition_name, $sub_cat_addition_name_ar, $sub_cat_addition_price,$parent_category_id);

        echo get_success("Successfully added");
    }
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

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">  Additions </h4>
                                <ol class="breadcrumb">
                                    <li><a href="sub_category_customize_view.php">Additions </a></li>
                                    <li class="active">Add New Addition </li>
                                </ol>
                            </div>
                        </div>

                        <div class="deleteData"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Add New Addition </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>

                                    <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                      <div class="form-group">
                                                    <label class="control-label">Parent Category</label>
                                                    <select class="form-control" name="parent_category_id" id="parent_category_id" required>
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
                                        
                                                
                                                <br>

                                        <div class="form-group optionBox" style="position: relative;">
                                               
                                            <div class="block">
                                               <br><br>

                                                <input name="addition[]" type="text" parsley-trigger="change" required placeholder="name en  " class="form-control thisField">
                                                <input name="addition_ar[]" type="text" parsley-trigger="change" required placeholder="name ar  " class="form-control thisField">
                                                <input name="addition_price[]" type="number" min="0" step="0.01"  parsley-trigger="change" required placeholder="price" class="form-control thisField">
                                            </div>
                                            <br>
                                            <div class="clearfix"></div>
                                            <div class="block">
                                                <span style="    margin-top: 3px;" class="btn add-more add">+</span>
                                            </div>											
                                        </div>

                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit" id="submit"> Add</button>
                                        </div>

                                        <br />

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


        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item4").addClass("active");
            });
        </script>
        <script type="text/javascript">
            $('.add').on('click', function () {
                $('.block:last').before('<div class="block"><input name="addition[]" type="text" parsley-trigger="change" required placeholder="name en  " class="form-control thisField"><input name="addition_ar[]" type="text" parsley-trigger="change" required placeholder="name ar  " class="form-control thisField"><input name="addition_price[]" type="number" min="0" step="0.01" parsley-trigger="change" required placeholder="price" class="form-control thisField"><button class="btn add-remove remove-me remove red" type="button">-</button></div>');
            });
            $('.optionBox').on('click', '.remove', function () {
                $(this).parent().remove();
            });
        </script>
    </body>
</html>