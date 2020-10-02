<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['problems'] != '1')) {
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <style>.custom-label{
            margin-top: 11px!important;

        }
    </style>
    <?php
    if (isset($_GET['complaintId']) && $_GET['complaintId'] != '') {
        $con->query("UPDATE `messages` SET `is_read`=1  where `complaint_id`='" . $_GET['complaintId'] . "' AND `type`=1");
    }
    ?>
    <?php
    if (isset($_POST['submit_send_message'])) {

        $client_id = $_POST['client_id'];
        $content = $_POST['content'];
        $message_type_id = $_POST['message_type_id'];
        $complaint_id = $_POST['complaint_id'];
        $query = $con->query("INSERT INTO `messages` VALUES (null,'$message_type_id','$content','$client_id','$complaint_id','0','0','" . date("Y-m-d H:i:s") . "')");
        if ($query) {
            $message_id = mysqli_insert_id($con);
            //ارسال اشعار للعميل
            $devicesArray = " SELECT device_token.*,devices.* from `device_token` left join devices on devices.device_token_id =device_token.id  WHERE devices.client_id='{$client_id}' and devices.login =1";
            $query_devicesArray = $con->query($devicesArray);
            $devicesArray_count = mysqli_num_rows($query_devicesArray);
            if ($devicesArray_count > 0) {
                while ($v = mysqli_fetch_assoc($query_devicesArray)) {
                    if ($v['device_token_id']) {
                        $data = array();
                        $data['title'] = 'تم الرد علي الشكوى أو الإقتراح';
                        $data['client_id'] = $client_id;
                        $data['type'] = 'reply';

                        $addNotSend['client_id'] = $client_id;
                        $addNotSend['text'] = 'تم الرد علي الشكوى أو الإقتراح';
                        $addNotSend['type'] = 'reply';
                        $addNotSend['text_id'] = $message_id;


                        $params = array("pushtype" => $v['type'], "registration_id" => $v['device_token'], "data" => $data);
                        $rtn = sendMessage($params, $addNotSend);
                    }
                }
            } else {
                $params = array("client_id" => $client_id, "type" => 'reply', "text_id" => $message_id, 'text' => 'Replied');
                $sendnotify = insertIntoNotSend($params);
            }
            echo get_success("Successfully Added");
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
    ?>
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
                                    <li><a href="complaints_view.php"> Complaints & Suggestions </a></li>
                                    <li class="active"> Complaints & Suggestions  </li>
                                </ol>
                            </div>
                        </div>

                        <?php
                        if ($_GET['complaintId']) {

                            $complaintId = $_GET['complaintId'];

                            $query_select = $con->query("SELECT * FROM `complaints` WHERE `id` = '{$complaintId}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $content = $row_select['content'];

                            $title = $row_select['title'];
                            $date = $row_select['date'];
                            $client_id = $row_select['client_id'];
                            $client_name = clientName($client_id);
                            $client_phone = clientPhone($client_id);

                            $query = $con->query("SELECT * FROM `messages` where `complaint_id`=$complaintId order by `id` desc");
                            $messages_count = mysqli_num_rows($query);

                            $query_complaint_images = $con->query("SELECT * FROM `complaint_images` where `complaint_id`=$complaintId");
                            $complaint_images_count = mysqli_num_rows($query_complaint_images);

                            if ($query_select) {
                                ?>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="">
                                            <div class="table-responsive m-t-20">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td width="400"> Client Name</td>
                                                            <td>
                                                                <?php echo $client_name; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Phone </td>
                                                            <td>
                                                                <?php echo $client_phone; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Title</td>
                                                            <td>
                                                                <?php echo $title; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Content</td>
                                                            <td>
                                                                <?php echo $content; ?>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <?php
                                            if ($messages_count > 0) {
                                                ?>
                                                <div class="form-group">
                                                    <h2> Reply To The Complaint Or Suggestion    :</h2>
                                                    <?php
                                                    $index = 1;
                                                    while ($row_messages = mysqli_fetch_assoc($query)) {
                                                        $date = $row_messages['date'];
                                                        $content = $row_messages['content'];
                                                        ?>
                                                        <div class="card-box" id="">
                                                            <div class="product-right-info">

                                                                <span><b> Content  :</b></span><?php echo $content; ?>
                                                                <br>
                                                                <span><b> Date Added   :</b></span><?php echo $date; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>   
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="product-right-info">

                                                    <h2> Reply To The Complaint Or Suggestion:</h2>
                                                    <?php echo "No Reply"; ?>
                                                </div>

                                            <?php }
                                            ?>
                                            <br>
                                            <hr>

                                            <?php
                                            if ($complaint_images_count > 0) {
                                                ?>
                                                <div class="form-group">
                                                    <h2> Images    :</h2>
                                                    <?php
                                                    $index = 1;
                                                    while ($row = mysqli_fetch_assoc($query_complaint_images)) {
                                                        $image = $row['image'];
                                                        ?>
                                                        <div class="col-md-9">
                                                            <div class="form-group col-md-4">
                                                                <div class="thumb">
                                                                    <img src="<?php echo $image; ?>" style="height: 200px;width: 200px;margin-left: 10px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>   
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="product-right-info">
                                                    <h2> Images    :</h2>
                                                    <b><?php echo "No Images"; ?></b>
                                                </div>
                                            <?php }
                                            ?>
                                        </div>
                                        <br>
                                        <hr>
                                        <div class="clearfix"></div>
                                        <h2>Add A Reply To The Complaint</h2>
                                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                            <input type="hidden" name="complaint_id" value="<?php echo $complaintId; ?>">
                                            <div class="form-group">
                                                <label class="control-label">Message Type</label>
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
                                                <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit_send_message"> Send </button>
                                            </div>
                                        </form>

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
                $("#item13").addClass("active");
            });
        </script>
    </body>
</html>