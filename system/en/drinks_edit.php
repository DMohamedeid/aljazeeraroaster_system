<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
if (($_SESSION['adds_and_removes'] != '1')) {
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
            if (isset($_POST['updateTypes'])) {
                $temp = $_POST;
                $sql = "UPDATE `drinks` SET `title_en`='{$temp['title_en']}',`title_ar`='{$temp['title_ar']}' ,`price`='{$temp['price']}',`price_sar`='{$temp['price_sar']}' ";

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
                                <h4 class="page-title">  drinks types</h4>
                                <ol class="breadcrumb">
                                    <li><a href="drinks_view.php"> drinks types</a></li>
                                    <li class="active">Edit drinks types</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box"> 	
                                    <?php
                                    if ($_GET['drinks_id']) {

                                        $drinks_id = $_GET['drinks_id'];
                                        $query_select = $con->query("SELECT * FROM `drinks` WHERE `id` = '{$drinks_id}' LIMIT 1");
                                        $row_select = mysqli_fetch_array($query_select);

                                        $id = $row_select['id'];
                                        $price = $row_select['price'];
                                        $price_sar = $row_select['price_sar'];
                                        $title_en = $row_select['title_en'];
                                        $title_ar = $row_select['title_ar'];
                                        if ($query_select) {
                                            ?>
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>

                                                <div class="form-group col-md-3" >
                                                    <label class="control-label"> English Name</label>
                                                    <div class="block">
                                                        <input name="title_en" value='<?php echo $title_en; ?>' type="text" parsley-trigger="change" required placeholder="name en" class="form-control thisField">
                                                    </div>										
                                                </div>
                                                <div class="form-group col-md-3" >
                                                    <label class="control-label">Arabic Name  </label>
                                                    <div class="block">
                                                        <input name="title_ar" value='<?php echo $title_ar; ?>' type="text" parsley-trigger="change" required placeholder="name ar" class="form-control thisField">
                                                    </div>										
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Price BD  </label>
                                                    <div class="block">
                                                        <input name="price" value='<?php echo $price; ?>'  type="number" min="0" step="0.100" parsley-trigger="change" required placeholder="price BD" class="form-control thisField">
                                                    </div>										
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="control-label">Price SAR  </label>
                                                    <div class="block">
                                                        <input name="price_sar" value='<?php echo $price_sar; ?>'  type="number" min="0" step="0.100" parsley-trigger="change" required placeholder="price SAR" class="form-control thisField">
                                                    </div>										
                                                </div>                                                
                                                <input type="hidden" name='id' value='<?php echo $id; ?>'>
                                                <br />
                                                <div class="clearfix"></div>

                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light " type="submit" name="updateTypes"> Update </button>
                                                    <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancell </button>
                                                </div>
                                            </form>

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

                    <?php
                }
            }
            ?>

            <script>
                $(document).ready(function () {
                    $("#cssmenu ul>li").removeClass("active");
                    $("#item100").addClass("active");
                });
            </script>

    </body>
</html>