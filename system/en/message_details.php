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
<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <style>.custom-label{
            margin-top: 11px!important;

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

            <div class="deleteData"></div>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">View Messages</h4>
                                <ol class="breadcrumb">
                                    <li><a href="messages_view.php">Messages</a></li>
                                    <li class="active">View Messages </li>
                                </ol>
                            </div>
                        </div>

                        <?php
                        if ($_GET['messages_id']) {

                            $messages_id = $_GET['messages_id'];

                            $query_select = $con->query("SELECT * FROM `messages` WHERE `id` = '{$messages_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $content = $row_select['content'];
                            $date = $row_select['date'];
                            $type = $row_select['type'];
                            $message_type_id = $row_select['message_type_id'];
                            $complaint_id = $row_select['complaint_id'];
                            if ($complaint_id != '') {

                                $con->query("UPDATE `messages` SET `is_read`=1  where `id`='$messages_id' ");
                            }
                            if ($query_select) {
                                ?>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="">
                                            <div class="table-responsive m-t-20">
                                                <table class="table">
                                                    <tbody>

                                                        <tr>
                                                            <td> Content</td>
                                                            <td>
                                                                <?php echo $content; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Type</td>
                                                            <td>
                                                                <?php
                                                                echo messages_type_name($message_type_id);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Sent/Received</td>
                                                            <td>
                                                                <?php
                                                                if ($type == 0) {
                                                                    echo "sent";
                                                                } else {
                                                                    echo "received";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Date Added </td>
                                                            <td>
                                                                <?php echo $date; ?>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>			
                </div>
                <?php
            }
        }
        ?>
        <?php include("include/footer_text.php"); ?>



        <!-- End Right content here -->

        <!-- Right Sidebar -->
        <div class="side-bar right-bar nicescroll">
            <?php include("include/rightbar.php"); ?>
        </div>
        <!-- /Right-bar -->
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