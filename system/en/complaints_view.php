<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
if (($_SESSION['problems'] != '1')) {
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
                                <h4 class="page-title">View Complaints & Suggestions</h4>
                                <ol class="breadcrumb">
                                    <li><a href="complaints_view.php">Complaints & Suggestions </a></li>
                                    <li class="active">Complaints & Suggestions</li>
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
                                                <th> Title </th>
                                                <th>Status</th>
                                                <th>Date Added </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php echo view_complaints(); ?> </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>			
                </div>
                <?php include("include/footer_text.php"); ?>

            </div>			

            <!-- MODAL -->
            <div class="modal fade" id="send_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post">
                            <div class="form-group">
                                <label class="control-label">Message Type  </label>
                                <select class="form-control message_type_id" name="message_type_id" id="message_type_id" required>
                                    <?php
                                    $query = $con->query("SELECT * FROM `messages_type` ORDER BY `id` ASC");
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='{$id}'>{$title}</option>";
                                    }
                                    ?>
                                </select>											
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control content" rows="3" id="content" name="content"  minlength="3" maxlength="100" required=""></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="submit_send_message"  class="btn btn-success submit_send_message">Send</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- MODAL -->
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
                $(".on-default").click(function () {
                    var complaint_delete = $(this).attr('href');
                    // alert(category);
                    $("#dialogConfirm").click(function () {
                        var dataString = 'complaint_delete=' + complaint_delete;
                        $.ajax({
                            type: "POST",
                            url: "functions/complaints_functions.php",
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

                $('body').on('click', '.sendmsg', function () {
                    var client_id = $(this).attr('data-client');
                    var complaint_id = $(this).attr('data-id');
                    $('#send_message').modal('show');
                    $('body').on('click', '.submit_send_message', function () {
                        var content = $("textarea#content").val();
                        var message_type_id = $(".message_type_id").val();
                        var dataString = 'send_client_id=' + client_id + '&send_content=' + content + '&send_message_type_id=' + message_type_id + '&send_complaint_id=' + complaint_id;

                        if (content != '') {
                            $.ajax({
                                type: "POST",
                                url: "functions/order_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });
                            $('#send_message').modal('hide');

                        } else {
                            alert("Please enter the message  ")
                        }
                    });
                });

            });

            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item13").addClass("active");
            });
        </script>		

    </body>
</html>