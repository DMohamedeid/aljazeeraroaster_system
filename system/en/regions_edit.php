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

<?php
// error_reporting(0);

if (isset($_POST['region_update'])) {
    $temp = $_POST;

    $region_id_update = $temp['region_id_update'];
    $region_name_ar = $temp['region_name_ar'];
    $region_name_en = $temp['region_name_en'];
    $charge = $temp['charge'];
    $min_order = $temp['min_order'];
    $display = $temp['display'];
    $order_period = $temp['order_period'];
    $errors = array();

    if (region_exists($region_name_ar, "region_name_ar") && $region_name_ar != getRegionId($region_id_update)[0]) {
        $errors[] = "This name already exists";
    }


    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {
        $update = $con->query("UPDATE `regions` SET `order_period`='$order_period',`display`='$display',`charge`='$charge' ,`region_name_ar`='$region_name_ar',`region_name_en`='$region_name_en',`min_order`='$min_order' WHERE `region_id`='$region_id_update'");
        if ($update) {
            echo get_success("Successfully Updated");
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo get_error("Here's a error!");
        }
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
                                <h4 class="page-title">Regions</h4>
                                <ol class="breadcrumb">
                                    <li><a href="regions_add.php">Regions</a></li>
                                    <li class="active">Edit Region  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>
                        <?php
                        if ($_GET['regionId']) {

                            $regionId = $_GET['regionId'];

                            $query_select = $con->query("SELECT * FROM `regions` WHERE `region_id` = '{$regionId}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $region_id = $row_select['region_id'];
                            $order_period = $row_select['order_period'];
                            $region_name_en = $row_select['region_name_en'];
                            $region_name_ar = $row_select['region_name_ar'];
                            $charge = $row_select['charge'];
                            $min_order = $row_select['min_order'];
                            $order_period = $row_select['order_period'];
                            $display = $row_select['display'];

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="region_id_update" id="region_id_update" parsley-trigger="change" required value="<?php echo $region_id; ?>" class="form-control">
                                                <div class="form-group col-md-3">
                                                    <label for="region_name_ar">Arabic Region Name    </label>
                                                    <input type="text" name="region_name_ar" id="region_name_ar" parsley-trigger="change" required value="<?php echo $region_name_ar; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="region_name_en">English Region Name    </label>
                                                    <input type="text" name="region_name_en" id="region_name_en" parsley-trigger="change" required value="<?php echo $region_name_en; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="order_period"> Order Period </label>
                                                    <input value="<?php echo $order_period; ?>" type="text" name="order_period" parsley-trigger="change" required placeholder="Period" class="form-control" id="region_name_ar">
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="charge">   Charge Cost</label>
                                                    <input type="number" value="<?php echo $charge; ?>" step="0.100" min="0" name="charge" parsley-trigger="change" required placeholder="Price" class="form-control" id="charge">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="min_order">    Minimum Order</label>
                                                    <input type="number" value="<?php echo $min_order; ?>"  step="0.100" min="0" name="min_order" parsley-trigger="change" required placeholder=" Minimum Order" class="form-control" id="min_order">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">  Status</label>
                                                    <select class="form-control" name="display" required parsley-trigger="change">
                                                        <option value="1" <?php
                                                        if ($display == '1') {
                                                            echo 'selected';
                                                        }
                                                        ?>>appear</option>
                                                        <option value="0"  <?php
                                                        if ($display == '0') {
                                                            echo 'selected';
                                                        }
                                                        ?>>hidden</option>
                                                    </select>
                                                </div>
                                                <br>
                                                <div class="clearfix"></div>
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="region_update" id="region_update">Update</button>
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