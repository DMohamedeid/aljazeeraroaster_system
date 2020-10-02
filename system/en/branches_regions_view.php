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

            <div class="deleteData"></div>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Regions of branches  <?php
                                    if (isset($_GET['branch_id']) && $_GET['branch_id'] != '') {
                                        echo '(' . branchesName($_GET['branch_id']) . ')';
                                    }
                                    ?> </h4>
                                <ol class="breadcrumb">
                                    <li><a href="branches_region_view.php">Regions of branches </a></li>
                                    <li class="active">Regions of branches</li>
                                </ol>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-striped" id="datatable-editable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Region</th>
                                                <th> Branch Name </th>
                                                <th>Date Added </th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php
                                            if (isset($_GET) && $_GET['branch_id'] != '') {
                                                echo view_branch_regions($_GET);
                                            } else {
                                                echo view_branches_regions();
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>			
                </div>
                <?php include("include/footer_text.php"); ?>

            </div>			

            <!-- MODAL -->
            <div id="dialog" class="modal-block mfp-hide">
                <section class="panel panel-info panel-color">
                    <header class="panel-heading">
                        <h2 class="panel-title">are you sure?</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <p>Delete this item?</p>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-md-12 text-right">
                                <button id="dialogConfirm" class="btn btn-primary waves-effect waves-light">Submit</button>
                                <button id="dialogCancel" class="btn btn-default waves-effect">Cancell</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- end Modal -->

            <!-- End Right content here -->

            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <?php include("include/rightbar.php"); ?>
            </div>
            <!-- /Right-bar -->
        </div>
        <!-- END wrapper -->
        <?php include("include/footer.php"); ?>	

        <script type="text/javascript">
            $(document).ready(function () {
                $('body').on('click', '.on-default', function () {
                    var delete_branche_region_id = $(this).attr('href');
                    // alert(category);
                    $("#dialogConfirm").click(function () {
                        var dataString = 'delete_branche_region_id=' + delete_branche_region_id;
                        $.ajax({
                            type: "POST",
                            url: "functions/branches_regions_function.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                                //alert(category);
                            }
                        });
                    });
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