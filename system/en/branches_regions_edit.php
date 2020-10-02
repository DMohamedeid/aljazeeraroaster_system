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

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->  		

            <?php
// error_reporting(0);

            if (isset($_POST['update_branches_region'])) {

                $branches_region_id = $_POST['branches_region_id'];
                $branche_id = $_POST['branche_id'];
                $region_id = $_POST['region_id'];

                if (branches_region_exists($region_id) && $region_id != getBrancheRegionId($branches_region_id)) {
                    $errors[] = " This region is already registered to  !" . " " . branchesName($branche_id);
                    ;
                }
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {
                    $update = $con->query("UPDATE `branches_regions` SET `branche_id`='$branche_id', `region_id`='$region_id' WHERE `id`='$branches_region_id'");
                    if ($update) {
                        echo get_success("Successfully updated");
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
                                <h4 class="page-title"> Regions of branches</h4>
                                <ol class="breadcrumb">
                                    <li><a href="branches_regions_view.php">   Regions of branches </a></li>
                                    <li class="active">Edit  Regions of branches    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>

                        <?php
                        if ($_GET['branche_region_id']) {

                            $branches_region_id = $_GET['branche_region_id'];

                            $query_select = $con->query("SELECT * FROM `branches_regions` WHERE `id` = '{$branches_region_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $id = $row_select['id'];
                            $get_region_id = $row_select['region_id'];
                            $get_branche_id = $row_select['branche_id'];

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="branches_region_id" id="branches_region_id" parsley-trigger="change" required value="<?php echo $id; ?>" class="form-control">

                                                <div class="block_two">
                                                    <label class="control-label">  Branch</label>
                                                    <select class="form-control branche_id select2me" name="branche_id" id="branche_id" required>
                                                        <option value=''>choose </option>
                                                        <?php
                                                        $query = $con->query("SELECT * FROM `branches` ORDER BY `id` ASC");
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                            $branche_id = $row['id'];
                                                            $name = $row['name'];
                                                            if ($get_branche_id == $branche_id) {
                                                                echo " <option value = '{$branche_id}' selected>{$name}</option>";
                                                            } else {
                                                                echo " <option value = '{$branche_id}'>{$name}</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="block_two">
                                                    <label class="control-label"> Regions </label>
                                                    <select class="form-control region_id select2me" name="region_id" id="region_id" required>
                                                        <option value=''>CHOOSE </option>
                                                        <?php
                                                        $query_1 = $con->query("SELECT * FROM `regions` ORDER BY `region_id` ASC");
                                                        while ($row_1 = mysqli_fetch_assoc($query_1)) {
                                                            $region_id = $row_1['region_id'];
                                                            $region_name = $row_1['region_name_en'];
                                                            if ($get_region_id == $region_id) {
                                                                echo'   <option value="' . $region_id . '" selected> ' . $region_name . '</option>';
                                                            } else {
                                                                echo'   <option value="' . $region_id . '"> ' . $region_name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="update_branches_region" id="update_branches_region">UPDATE</button>
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
            $('.select2me').select2({
                placeholder: "Select",
                width: 'auto',
                allowClear: true
            });
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item8").addClass("active");
            });
        </script>		

    </body>
</html>