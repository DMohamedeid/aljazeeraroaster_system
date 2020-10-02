<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
if (($_SESSION['regions'] != '1')) {
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
            if (isset($_POST['submit'])) {

                $branche_id = mysqli_real_escape_string($con, trim($_POST['branche_id']));
                $region_id = mysqli_real_escape_string($con, trim($_POST['region_id']));

                $errors = array();

                if (empty($branche_id)) {
                    $errors[] = "Please enter all fields !";
                }

                if (branches_region_exists($region_id) === true) {
                    $errors[] = " This region is already registered with  branch!" . " " . '<br>' . branchesName($branche_id);
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {

                    $add_branches_region = add_branches_region($region_id, $branche_id);

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
                                <h4 class="page-title"> Regions of branches</h4>
                                <ol class="breadcrumb">
                                    <li><a href="branches_regions_view.php">Regions of branches  </a></li>
                                    <li class="active">Add Regions of branches</li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Add Regions of branches</b></h4>

                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>

                                        <div class="row">
                                            <div class="block_two">
                                                <label class="control-label">  Branches</label>
                                                <select class="form-control branche_id select2me" name="branche_id" id="branche_id" required>
                                                    <option value=''>choose </option>
                                                    <?php
                                                    $query = $con->query("SELECT * FROM `branches` ORDER BY `id` ASC");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $branche_id = $row['id'];
                                                        $name = $row['name'];
                                                        echo " <option value = '{$branche_id}'>{$name}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="block_two">
                                                <label class="control-label"> Regions </label>
                                                <select class="form-control region_id select2me" name="region_id" id="region_id" required>
                                                    <option value=''>choose </option>
                                                    <?php
                                                    $query_1 = $con->query("SELECT * FROM `regions` ORDER BY `region_id` ASC");
                                                    while ($row_1 = mysqli_fetch_assoc($query_1)) {
                                                        $region_id = $row_1['region_id'];
                                                        $region_name = $row_1['region_name_en'];
                                                        $query_b = $con->query("SELECT * FROM `branches_regions` WHERE `region_id`='$region_id' LIMIT 1");
                                                        if (mysqli_num_rows($query_b) >= 1) {
                                                            
                                                        } else {
                                                            echo'   <option value="' . $region_id . '"> ' . $region_name . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="clearfix"></div>
                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit">
                                                Add
                                            </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                                Cancell
                                            </button>
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
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item8").addClass("active");
            });
            $('.select2me').select2({
                placeholder: "Select",
                width: 'auto',
                allowClear: true
            });
        </script>

    </body>
</html>