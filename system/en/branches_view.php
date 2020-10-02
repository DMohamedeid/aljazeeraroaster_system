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

            <div class="deleteData"></div>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">View branches </h4>
                                <ol class="breadcrumb">
                                    <li><a href="branches_view.php">branches </a></li>
                                    <li class="active">  View branches</li>
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
                                                <th>English Name </th>
                                                <th> Arabic Name</th>
                                                <th>Delivery?</th>
                                                 <th>Show/Hide ?</th>
                                                <th>Date Added </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php echo view_branches(); ?> </tbody>
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
            $('body').on('change', '.change_cat_status_off', function () {
                var change_cat_status_off = $(this).attr('data-id');
                var dataString = 'change_cat_status_off=' + change_cat_status_off;
                swal({
                    title: "Confirm hide?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "yes",
                    cancelButtonText: "cancell",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("changed ", "", "success");
                        var dataString = 'change_cat_status_off=' + change_cat_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/branches_function.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal("changed ", "changed  :)", "error");
                    }
                });
            });
            $('body').on('change', '.change_cat_status_on', function () {
                var change_cat_status_on = $(this).attr('data-id');
                var dataString = 'change_cat_status_on=' + change_cat_status_on;
                swal({
                    title: "Change status?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "yes",
                    cancelButtonText: "cancell",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("changed ", "", "success");
                        var dataString = 'change_cat_status_on=' + change_cat_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/branches_function.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal("changed ", "changed  :)", "error");
                    }
                });
            });
            
            
            
            
            
                ///////////////branch show //////////////////
            
            
            
            $('body').on('change', '.change_cat_status_off_show', function () {
                var change_cat_status_off = $(this).attr('data-id');
                var dataString = 'change_cat_status_off_show=' + change_cat_status_off;
                swal({
                    title: "  Confirm Hide ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancell ",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal(" Changed ", "", "success");
                        var dataString = 'change_cat_status_off_show=' + change_cat_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/branches_function.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal(" changed ", "Changed  :)", "error");
                    }
                });
            });
            
            $('body').on('change', '.change_cat_status_on_show', function () {
                var change_cat_status_on = $(this).attr('data-id');
                var dataString = 'change_cat_status_on_show=' + change_cat_status_on;
                swal({
                    title: "Confirm Change ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancell ",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("Changed  ", "", "success");
                        var dataString = 'change_cat_status_on_show=' + change_cat_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/branches_function.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal(" changed ", "Changed  :)", "success");
                    }
                });
            });
            
    
            /////////////branch Show////////////////////
            
            
            
            
            
            
            
            
            
            

            $(document).ready(function () {
                $('body').on('click', '.on-default', function () {
                    var delete_branches_id = $(this).attr('href');
//                     alert(delete_branches_id);
                    $("#dialogConfirm").click(function () {
                        var dataString = 'delete_branches_id=' + delete_branches_id;
                        $.ajax({
                            type: "POST",
                            url: "functions/branches_function.php",
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