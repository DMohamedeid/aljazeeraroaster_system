<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['regions'] != '1')) {
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

                $charge = $_POST['charge'];
                $min_order = $_POST['min_order'];
                $display = $_POST['display'];
                $region_name_ar = mysqli_real_escape_string($con, trim($_POST['region_name_ar']));

                $region_name_en = mysqli_real_escape_string($con, trim($_POST['region_name_en']));
                $order_period = mysqli_real_escape_string($con, trim($_POST['order_period']));
                $errors = array();


                if (region_exists($region_name_ar, "region_name_ar") === true) {
                    $errors[] = "This name already exists !";
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {
                    $add_region = add_region($charge, $min_order, $region_name_ar, $display, $region_name_en, $order_period);


                    echo get_success("Successfully added");
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
                                <h4 class="page-title"> Regions </h4>
                                <ol class="breadcrumb">
                                    <li><a href="regions_add.php">Regions</a></li>
                                    <li class="active">Add New Region  </li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box"> 									

                                    <h4 class="m-t-0 header-title"><b>Add New Region  </b></h4>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>


                                        <div class="form-group col-md-3">
                                            <label for="region_name_ar">Arabic Region Name    </label>
                                            <input type="text" name="region_name_ar" parsley-trigger="change" required placeholder="Name AR" class="form-control" id="region_name_ar">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="region_name_en">English Region Name    </label>
                                            <input type="text" name="region_name_en" parsley-trigger="change" required placeholder="Name EN" class="form-control" id="region_name_ar">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="order_period"> Order Period </label>
                                            <input type="text" name="order_period" parsley-trigger="change" required placeholder="Period" class="form-control" id="region_name_ar">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="charge">   Charge Cost </label>
                                            <input type="number" step="0.100" min="0" name="charge" parsley-trigger="change" required placeholder="Cost" class="form-control" id="charge">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="min_order">    Minimum Order</label>
                                            <input type="number" step="0.100" min="0" name="min_order" parsley-trigger="change" required placeholder="Min Order " class="form-control" id="min_order">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">  Status </label>
                                            <select class="form-control" name="display" required parsley-trigger="change">
                                                <option value="1" >Show</option>
                                                <option value="0">Hidden</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
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
            </div>
            <?php include("include/footer_text.php"); ?>

        </div>			

        <!-- End Right content here -->

        <!-- Right Sidebar -->
        <div class="side-bar right-bar nicescroll">
            <?php include("include/rightbar.php"); ?>
        </div>
        <!-- /Right-bar -->
        <!-- END wrapper -->
        <?php include("include/footer.php"); ?>
        <script>
            $("#country_id").change(function () {
                var get_cities_by_country_id = $(this).val();

                var dataString = 'get_cities_by_country_id=' + get_cities_by_country_id;
                $.ajax({
                    type: "POST",
                    url: "functions/cities_functions.php",
                    data: dataString,
                    dataType: 'text',
                    cache: false,
                    success: function (html) {
                        $("#city_id").html(html);
                    }
                });

            });

        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item8").addClass("active");
            });
        </script>

    </body>
</html>