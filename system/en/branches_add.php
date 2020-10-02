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

<?php
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name_ar = $_POST['name_ar'];
    $show=$_POST['show'];
    $errors = array();

    if (empty($name)) {
        $errors[] = "Please enter all fields !";
    } else {
        
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {

        $add_branches = add_branches($name, $name_ar,$show);

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
                                <h4 class="page-title">  Branches </h4>
                                <ol class="breadcrumb">
                                    <li><a href="branches_view.php">Branches </a></li>
                                    <li class="active">Branches </li>
                                </ol>
                            </div>
                        </div>

                        <div class="deleteData"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Branches </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>

                                    <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>

                                        <div class="form-group optionBox" style="position: relative;">
                                            <label class="control-label">Branch name in English</label>
                                            <div class="block">
                                                <input name="name" type="text" parsley-trigger="change" required placeholder="Name" class="form-control thisField">
                                            </div>

                                            <div class="form-group optionBox" style="position: relative;">
                                                <label class="control-label">Branch name in Arabic
                                                </label>
                                                <div class="block">
                                                    <input name="name_ar" type="text" parsley-trigger="change" required placeholder="Name" class="form-control thisField">
                                                </div>
                                            </div>
                                            
                                             <div class="form-group optionBox" style="position: relative;">
                                            <label class="control-label"> Branch Display  </label>
                                            <div class="block">
                                                <select class="form-control select2me" name="show" id="show" required>
                                                      <option value="" >Choose </option>
                                                      <option value="1" > Show </option>
                                                      <option value="0" > Hide </option>
                                                </select>								
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


        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item8").addClass("active");
            });
        </script>
    </body>
</html>