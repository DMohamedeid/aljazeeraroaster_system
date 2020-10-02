<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
if (($_SESSION['messages'] != '1')) {
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
                                <h4 class="page-title">Messages View  </h4>
                                <ol class="breadcrumb">
                                    <li><a href="messages_view.php">Messages </a></li>
                                    <li class="active">Messages View  </li>
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
                                                <th>Message Type </th>
                                                <th>Content </th>
                                                <th> Sent/Received</th>
                                                <th> Read/ Not Read </th>

                                                <th>Date Added </th>
                                                <th>Client Name  </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php echo view_messages(); ?> </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>			
                </div>
                <?php include("include/footer_text.php"); ?>

            </div>			


            <!-- MODAL -->
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
                $('body').on('click', '.deletemsg', function () {
                    var message_delete = $(this).attr('data-id');
                    var dataString = 'message_delete=' + message_delete;
                    bootbox.dialog({
                        message: "Delete This Item?",
                        title: "Message Confirm Deletion", buttons: {
                            danger: {
                                label: "Cancel",
                                className: "btn-danger"
                            },
                            main: {
                                label: "Delete", className: "btn-primary",
                                callback: function () {
                                    //do something else
                                    $.ajax({
                                        type: "POST",
                                        url: "functions/complaints_functions.php",
                                        data: dataString,
                                        dataType: 'text', cache: false,
                                        success: function (data) {
                                            $(".deleteData").html(data);
                                            $("." + message_delete).remove();

                                            //alert(category);
                                        }
                                    });
                                }
                            }
                        }
                    });
                });

            });
        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item103").addClass("active");
            });
        </script>		

    </body>
</html>