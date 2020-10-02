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

<?php
if (isset($_POST['submit'])) {

    $price = $_POST['price'];

    $price_sar = $_POST['price_sar'];
    $title_en = $_POST['title_en'];
    $title_ar = $_POST['title_ar'];

    $errors = array();

    if (empty($title_en)) {
        $errors[] = "Please enter all fields !";
    } else {
        
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {

        $add_drinks = add_drinks($title_ar, $title_en, $price,$price_sar);

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
                                <h4 class="page-title">   drinks types </h4>
                                <ol class="breadcrumb">
                                    <li><a href="drinks_view.php"> drinks types</a></li>
                                    <li class="active"> drinks types</li>
                                </ol>
                            </div>
                        </div>

                        <div class="deleteData"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b> drinks types </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>

                                    <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>

                                        <div class="form-group col-md-3">
                                            <label class="control-label"> English Name</label>
                                            <div class="block">
                                                <input name="title_en" type="text" parsley-trigger="change" required placeholder="name en" class="form-control thisField">
                                            </div>										
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Arabic Name  </label>
                                            <div class="block">
                                                <input name="title_ar" type="text" parsley-trigger="change" required placeholder="name ar" class="form-control thisField">
                                            </div>										
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Price BD </label>
                                            <div class="block">
                                                <input name="price" type="number" min="0" step="0.100" parsley-trigger="change" required placeholder="price BD" class="form-control thisField">
                                            </div>										
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Price SAR </label>
                                            <div class="block">
                                                <input name="price_sar" type="number" min="0" step="0.100" parsley-trigger="change" required placeholder="price SAR" class="form-control thisField">
                                            </div>										
                                        </div>
                                        
                                        <div class="clearfix"></div>
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


        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item100").addClass("active");
            });
        </script>
    </body>
</html>