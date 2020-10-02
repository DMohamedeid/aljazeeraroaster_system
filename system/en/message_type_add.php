<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['messages'] != '1')) {
    header("Location: error.php");
    exit();
}
?>

<?php
if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $title_ar = $_POST['title_ar'];

    $errors = array();

    if (empty($title)) {
        $errors[] = "Please enter all fields !";
    } else {
        
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            //echo $error, '<br />';
            echo get_error($error);
        }
    } else {

        $add_messages_type = add_messages_type($title, $title_ar);

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
                                <h4 class="page-title">  Types Of Messages</h4>
                                <ol class="breadcrumb">
                                    <li><a href="message_type_view.php">  Types Of Messages  </a></li>
                                    <li class="active">  Types Of Messages  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="deleteData"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>  Types Of Messages </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>

                                    <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>

                                        <div class="form-group optionBox" style="position: relative;">
                                            <label class="control-label">English Name</label>
                                            <div class="block">
                                                <input name="title" type="text" parsley-trigger="change" required placeholder="Name EN" class="form-control thisField">
                                            </div>										
                                        </div>
                                        <div class="form-group optionBox" style="position: relative;">
                                            <label class="control-label">Arabic Name  </label>
                                            <div class="block">
                                                <input name="title_ar" type="text" parsley-trigger="change" required placeholder="Name AR" class="form-control thisField">
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
                $("#item103").addClass("active");
            });
        </script>
    </body>
</html>