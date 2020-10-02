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

<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <style>.red.btn {
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
            if (isset($_POST['updateAddition'])) {
                $temp = $_POST;
                $parent_category_id=$_POST['parent_category_id'];
                $sql = "UPDATE `sub_categories_addition_prices` SET `parent_category_id`='$parent_category_id' ,  ";
                foreach ($temp as $k => $v) {
                    $sql .= ($k == 'updateAddition') ? "" : "`{$k}`=\"{$v}\",";
                }
                $sql = substr($sql, 0, -1);
                $sql .= "WHERE sub_category_addition_price_id='{$temp['sub_category_addition_price_id']}'";
                $update = $con->query($sql);
                if ($update) {
                    echo get_success("Successfully updated");
                } else {
                    echo get_error("Here's a error!");
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
                                <h4 class="page-title"> Additions   </h4>
                                <ol class="breadcrumb">
                                    <li><a href="sub_category_customize_view.php">Additions </a></li>
                                    <li class="active">edit Addition  </li>
                                </ol>
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-box"> 	
                                        <?php
                                        if ($_GET['addition_id']) {

                                            $addition_id = $_GET['addition_id'];
                                            $query_select = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id` = '{$addition_id}' LIMIT 1");
                                            $row_select = mysqli_fetch_array($query_select);

                                            $sub_category_addition_price_id = $row_select['sub_category_addition_price_id'];
                                            $sub_category_addition_name = $row_select['sub_category_addition_name'];
                                            $sub_category_addition_name_ar = $row_select['sub_category_addition_name_ar'];
                                            $sub_category_addition_price = $row_select['sub_category_addition_price'];
                                            $parent_cat_id_data= $row_select['parent_category_id'];

                                            if ($query_select) {
                                                ?>

                                                <div class="form-group optionBox" style="position: relative;">
                                                    <label class="control-label">Additions</label>
                                                     <div class="form-group">
                                                        <label class="control-label">Parent Category</label>
                                                        <select class="form-control" name="parent_category_id" id="parent_category_id" required>
                                                            <?php
                                                            $query = $con->query("SELECT * FROM `parent_categories` ORDER BY `parent_category_id` ASC");
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                                $parent_category_id = $row['parent_category_id'];
                                                                if($parent_category_id==$parent_cat_id_data){
                                                                    $selected="selected";
                                                                }else{
                                                                    $selected="";
                                                                }
                                                                $parent_category_name = $row['parent_category_name'];
                                                                echo "<option {$selected}  value='{$parent_category_id}'>{$parent_category_name}</option>";
                                                            }
                                                            ?>
                                                        </select>											
                                                    </div>
                                        
                                                
                                                <br>
                                                    
                                                    <div class="block">
                                                        <input name="sub_category_addition_name" value='<?php echo $sub_category_addition_name; ?>' type="text" parsley-trigger="change" required placeholder="name en  " class="form-control thisField">
                                                        <input name="sub_category_addition_name_ar" value='<?php echo $sub_category_addition_name_ar; ?>' type="text" parsley-trigger="change" required placeholder="name ar  " class="form-control thisField">
                                                        <input name="sub_category_addition_price" value='<?php echo $sub_category_addition_price; ?>' type="text" parsley-trigger="change" required placeholder="price" class="form-control thisField">
                                                        <!--<button class="btn add-remove remove-me remove" type="button">-</button>-->
                                                    </div>										
                                                </div>


                                                <input type="hidden" name='sub_category_addition_price_id' value='<?php echo $sub_category_addition_price_id; ?>'>

                                                <br />
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light " type="submit" name="updateAddition"> Update </button>
                                                    <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancell </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>			
                                </form>

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

                    <?php
                }
            }
            ?>

            <script>
                $(document).ready(function () {
                    $("#cssmenu ul>li").removeClass("active");
                    $("#item4").addClass("active");
                });
            </script>

    </body>
</html>