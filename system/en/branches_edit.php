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
            if (isset($_POST['updatebranches'])) {
                  $show=$_POST['show'];
                $temp = $_POST;
                $sql = "UPDATE `branches` SET `name`='{$temp['name']}' ,  `name_ar`='{$temp['name_ar']}',`branch_show`='$show' ";

                $sql .= "WHERE id='{$temp['id']}'";
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
                                <h4 class="page-title"> Edit Branches </h4>
                                <ol class="breadcrumb">
                                    <li><a href="branches_view.php">Branches </a></li>
                                    <li class="active">Edit Branches </li>
                                </ol>
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-box"> 	
                                        <?php
                                        if ($_GET['brancheID']) {

                                            $branchesID = $_GET['brancheID'];
                                            $query_select = $con->query("SELECT * FROM `branches` WHERE `id` = '{$branchesID}' LIMIT 1");
                                            $row_select = mysqli_fetch_array($query_select);

                                            $remove_id = $row_select['id'];
                                            $name = $row_select['name'];
                                            $name_ar = $row_select['name_ar'];
                                            $branch_show = $row_select['branch_show'];
                                            

                                            if ($query_select) {
                                                ?>

                                                <div class="form-group optionBox" style="position: relative;">
                                                    <label class="control-label">Branch name in English</label>
                                                    <div class="block">
                                                        <input name="name" value='<?php echo $name; ?>' type="text" parsley-trigger="change" required placeholder="name en" class="form-control thisField">
                                                    </div>										
                                                </div>


                                                <div class="form-group optionBox" style="position: relative;">
                                                    <label class="control-label">Arabic branch name</label>
                                                    <div class="block">
                                                        <input name="name_ar" value='<?php echo $name_ar; ?>' type="text" parsley-trigger="change" required placeholder="name ar" class="form-control thisField">
                                                    </div>										
                                                </div>
                                                  
                                        <div class="form-group optionBox" style="position: relative;">
                                            <label class="control-label"> Branch Display  </label>
                                            <div class="block">
                                                <select class="form-control select2me" name="show" id="show" required>
                                                      <option value="" >Choose </option>
                                                      <option value="1" <?php if($branch_show) echo "selected"; ?> > Show </option>
                                                      <option value="0" <?php if(!$branch_show) echo "selected"; ?>  > Hide </option>
                                                </select>								
                                            </div>
                                        </div>
                                                
                                                <input type="hidden" name='id' value='<?php echo $branchesID; ?>'>
                                                <br />
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light " type="submit" name="updatebranches"> Update </button>
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
                    $("#item8").addClass("active");
                });
            </script>

    </body>
</html>