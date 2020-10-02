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
            if (isset($_POST['updateRemoves'])) {
                $temp = $_POST;
                $sql = "UPDATE `removes` SET `title`='{$temp['title']}',`title_ar`='{$temp['title_ar']}' ";

                $sql .= "WHERE `id`='{$temp['id']}'";
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
                                <h4 class="page-title"> Removes </h4>
                                <ol class="breadcrumb">
                                    <li><a href="remove_view.php">Removes </a></li>
                                    <li class="active">Edit Remove </li>
                                </ol>
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-box"> 	
                                        <?php
                                        if ($_GET['removeID']) {

                                            $removeID = $_GET['removeID'];
                                            $query_select = $con->query("SELECT * FROM `removes` WHERE `id` = '{$removeID}' LIMIT 1");
                                            $row_select = mysqli_fetch_array($query_select);

                                            $remove_id = $row_select['id'];
                                            $title = $row_select['title'];
                                            $title_ar = $row_select['title_ar'];
                                            if ($query_select) {
                                                ?>

                                                <div class="form-group">
                                                    <label class="control-label">Remove name english  </label>
                                                    <div class="block">
                                                        <input name="title" value='<?php echo $title; ?>' type="text" parsley-trigger="change" required placeholder="name en  " class="form-control thisField">
                                                    </div>										
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Remove name arabic  </label>
                                                    <div class="block">
                                                        <input name="title_ar" value='<?php echo $title_ar; ?>' type="text" parsley-trigger="change" required placeholder="name ar  " class="form-control thisField">
                                                    </div>										
                                                </div>
                                                <input type="hidden" name='id' value='<?php echo $removeID; ?>'>
                                                <br />
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light " type="submit" name="updateRemoves"> Update </button>
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
                    $("#item41").addClass("active");
                });
            </script>

    </body>
</html>