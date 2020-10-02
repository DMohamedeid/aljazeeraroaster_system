<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['clients'] != '1')) {
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

                        <?php
                        $client_id = $_GET["client_id"];
                        $clientname = clientName($client_id);
                        ?>
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">View Addresses For <?php echo $clientname; ?></h4>
                                <ol class="breadcrumb">
                                    <li><a href="client_view.php"> Clients </a></li>
                                    <li class="active">View Addresses For <?php echo $clientname; ?></li>
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
                                                <th>Client Name </th>
                                                <th>Region</th>
                                                <th>Block </th>
                                                <th>Road</th>
                                                <th>Building</th>
                                                <th>Flat Number </th>
                                                <th>Phone </th>
                                                <th>Date Added </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php
                                            $client_id = $_GET['client_id'];
                                            echo view_client_address($client_id);
                                            ?> </tbody>
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
                        <h2 class="panel-title">Are You Sure?</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <p>Delete This Item?</p>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-md-12 text-right">
                                <button id="dialogConfirm" class="btn btn-primary waves-effect waves-light">Submit</button>
                                <button id="dialogCancel" class="btn btn-default waves-effect">Cancel</button>
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
                    var del_client_address_id = $(this).attr('href');
                    $("#dialogConfirm").click(function () {
                        var dataString = 'del_client_address_id=' + del_client_address_id;
                        $.ajax({
                            type: "POST",
                            url: "functions/client_functions.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    });
                });
            });
        </script>		

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item7").addClass("active");
            });
        </script>		

    </body>
</html>