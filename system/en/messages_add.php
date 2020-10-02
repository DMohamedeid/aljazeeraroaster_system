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

            <?php
            if (isset($_POST['submit'])) {
                $temp = $_POST;

                $add_message = add_message($temp);
                

                  if ($add_message) {
                    $message_id = mysqli_insert_id($con);
                    //ارسال اشعار للعميل
                    $devicesArray = " SELECT * from `device_token` ";
                    $query_devicesArray = $con->query($devicesArray);
                    $devicesArray_count = mysqli_num_rows($query_devicesArray);
                    if ($devicesArray_count > 0) {
                        while ($v = mysqli_fetch_assoc($query_devicesArray)) {
                            if ($v['device_token']) {
                                $data = array();
                                $data['client_id'] = '';
                                $data['title'] = $temp['content'];
                                $data['msgcnt'] = '1';
                                $data['type'] = 'message';

                                $params = array("pushtype" => $v['type'], "registration_id" => $v['device_token'], "data" => $data);
                                $rtn = sendMessage($params,$params);
                                $params = array("client_id" => '', "type" => 'message', "text_id" => $message_id, 'text' => 'يوجد رسالة جديدة');

                            }
                        }
                    }
                    // $sendnotify = insertIntoNotSend($params);
                    echo get_success("تم إرسال الرسالة   بنجاح");
                    // echo "<meta http-equiv='refresh' content='0'>";
                
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
                                <h4 class="page-title"> Messages  </h4>
                                <ol class="breadcrumb">
                                    <li><a href="messages_view.php">Messages </a></li>
                                    <li class="active">Add New Message    </li>
                                </ol>
                            </div>
                        </div>
                        <form id="client_address_add" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate >

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 header-title"><b> Add New message    </b></h4>
                                        <div class="form-group">
                                            <label class="control-label">Message Type  </label>
                                            <select class="form-control" name="message_type_id" id="message_type_id" required>
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
                                        <br />

                                        <div class="form-group">
                                            <label for="content">  Content</label>
                                            <textarea class="form-control" rows="3" name="content"  minlength="3" maxlength="1000" required=""></textarea>
                                        </div>
                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" id="submit" name="submit"> Add </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancel </button>
                                        </div>
                                    </div>
                                </div>
                            </div>	
                        </form>

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