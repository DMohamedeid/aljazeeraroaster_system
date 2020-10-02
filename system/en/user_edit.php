<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['users'] != '1')) {
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

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->  		

            <?php
// error_reporting(0);

            if (isset($_POST['user_update'])) {

                $userID_update = $_POST['userID_update'];
                $userName_update = $_POST['userName_update'];
                if (isset($_POST['userPassword_update']) && ($_POST['userPassword_update'] != '')) {
                    $userPassword_update = trim($_POST['userPassword_update']);
                } else {
                    $old_pass = $_POST['old_pass'];
                    $userPassword_update = $old_pass;
                }
                $userEmail_update = $_POST['userEmail_update'];
                $date_added = date("Y-m-d");
                $userPhone_update = $_POST['userPhone_update'];
                $userType_update = $_POST['userType_update'];
                if (isset($_POST['cat_and_sub'])) {
                    $cat_and_sub = 1;
                } else {
                    $cat_and_sub = 0;
                }
                if (isset($_POST['adds_and_removes'])) {
                    $adds_and_removes = 1;
                } else {
                    $adds_and_removes = 0;
                }

                if (isset($_POST['dishs'])) {
                    $dishs = 1;
                } else {
                    $dishs = 0;
                }
                if (isset($_POST['messages'])) {
                    $messages = 1;
                } else {
                    $messages = 0;
                }

                if (isset($_POST['regions'])) {
                    $regions = 1;
                } else {
                    $regions = 0;
                }
                if (isset($_POST['about'])) {
                    $about = 1;
                } else {
                    $about = 0;
                }
                if (isset($_POST['reports'])) {
                    $reports = 1;
                } else {
                    $reports = 0;
                }
                if (isset($_POST['comments'])) {
                    $comments = 1;
                } else {
                    $comments = 0;
                }
                if (isset($_POST['statics'])) {
                    $statics = 1;
                } else {
                    $statics = 0;
                }
                if (isset($_POST['problems'])) {
                    $problems = 1;
                } else {
                    $problems = 0;
                }
                if (isset($_POST['users'])) {
                    $users = 1;
                } else {
                    $users = 0;
                }
                if (isset($_POST['clients'])) {
                    $clients = 1;
                } else {
                    $clients = 0;
                }
                if (isset($_POST['orders'])) {
                    $orders = 1;
                } else {
                    $orders = 0;
                }
                if (isset($_FILES['image_update']['name']) && !empty($_FILES['image_update']['name'])) {

                    $image_name_update = $_FILES['image_update']['name'];
                    $image_tmp_update = $_FILES['image_update']['tmp_name'];
                    $allowed_ext = array('jpg', 'jpeg', 'gif', 'png');
                    $get_image_ext = explode('.', $image_name_update);
                    $image_ext = strtolower(end($get_image_ext));

                    $update = $con->query("UPDATE `users` SET `orders`='$orders',`cat_and_sub`='$cat_and_sub',`dishs`='$dishs',`adds_and_removes`='$adds_and_removes',`messages`='$messages',`reports`='$reports',`about`='$about',`clients`='$clients',`users`='$users',`problems`='$problems',`statics`='$statics',`comments`='$comments',`reports`='$reports',`about`='$about',`regions`='$regions',`date_added`='$date_added', `user_name`='$userName_update',`user_password`='$userPassword_update',`user_email`='$userEmail_update',
`user_phone`='$userPhone_update',`user_type`='$userType_update',`user_image`='$image_name_update' WHERE `user_id`='$userID_update'");
                    $image_path = dirname(__FILE__) . "/../uploads/users/" . $userID_update . "." . $image_ext;

                    if (move_uploaded_file($image_tmp_update, $image_path)) {
                    }
                } else {

                    $update = $con->query("UPDATE `users` SET `orders`='$orders', `cat_and_sub`='$cat_and_sub',`dishs`='$dishs',`adds_and_removes`='$adds_and_removes',`messages`='$messages',`reports`='$reports',`about`='$about',`clients`='$clients',`users`='$users',`problems`='$problems',`statics`='$statics',`comments`='$comments',`reports`='$reports',`about`='$about',`regions`='$regions',`date_added`='$date_added', `user_name`='$userName_update',`user_password`='$userPassword_update',`user_email`='$userEmail_update',
`user_phone`='$userPhone_update',`user_type`='$userType_update' WHERE `user_id`='$userID_update'");
                }
                if ($update) {
                    echo get_success("Successfully Updated");
                } else {
                    echo get_error("Here's a error!");
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
                                <h4 class="page-title">Users</h4>
                                <ol class="breadcrumb">
                                    <li><a href="user_add.php">Users</a></li>
                                    <li class="active">Edit User </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>

                        <?php
                        if ($_GET['userID']) {

                            $get_user_id = $_GET['userID'];

                            $query_select = $con->query("SELECT * FROM `users` WHERE `user_id` = '{$get_user_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $user_id = $row_select['user_id'];
                            $user_name = $row_select['user_name'];
                            $user_password = $row_select['user_password'];
                            $user_email = $row_select['user_email'];
                            $user_phone = $row_select['user_phone'];
                            $user_image = $row_select['user_image'];
                            $user_type = $row_select['user_type'];

                            $users = $row_select['users'];
                            $statics = $row_select['statics'];
                            $comments = $row_select['comments'];
                            $reports = $row_select['reports'];
                            $about = $row_select['about'];
                            $regions = $row_select['regions'];
                            $problems = $row_select['problems'];
                            $clients = $row_select['clients'];
                            $orders = $row_select['orders'];
                            $adds_and_removes = $row_select['adds_and_removes'];
                            $cat_and_sub = $row_select['cat_and_sub'];
                            $dishs = $row_select['dishs'];
                            $messages = $row_select['messages'];


                            $get_image_ext = explode('.', $user_image);
                            $image_ext = strtolower(end($get_image_ext));
                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="userID_update" id="userID_update" parsley-trigger="change" required value="<?php echo $user_id; ?>" class="form-control">
                                                <input type="hidden" name="old_pass" id="old_pass" parsley-trigger="change" required value="<?php echo $user_password; ?>" class="form-control">

                                                <div class="form-group">
                                                    <label for="userName">Name</label>
                                                    <input type="text" name="userName_update" id="userName_update" parsley-trigger="change" required value="<?php echo $user_name; ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName"> Email</label>
                                                    <input type="text" name="userEmail_update" id="userEmail_update" parsley-trigger="change" required value="<?php echo $user_email; ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName"> Password</label>
                                                    <input type="password" name="userPassword_update" id="userPassword_update" parsley-trigger="change"  value="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName"> Phone</label>
                                                    <input type="text" name="userPhone_update" id="userPhone_update" parsley-trigger="change" required value="<?php echo $user_phone; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="userName">User Type </label>
                                                    <select class="form-control" name="userType_update" id="userType" required parsley-trigger="change">
                                                        <?php if ($user_type == 1) { ?>						
                                                            <option selected value="1"> Manager </option>
                                                            <option value="2">  User </option></option>
                                                        <?php } else if ($user_type == 2) { ?>
                                                            <option selected value="2">  User </option>
                                                            <option value="1"> Manager </option>
                                                        <?php } ?>
                                                    </select>					
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                <input type="hidden" name="image_ext_old" value="<?php echo $image_ext; ?>" />
                                                <div class="form-group m-b-0">
                                                    <label for="userName"> image <a class="showImg">edit?</a> </label>								

                                                    <div class="gal-detail thumb getImage">
                                                        <a href="../uploads/users/<?php echo $user_id . "." . $image_ext; ?>" class="image-popup" title="<?php echo $user_name; ?>">
                                                            <img src="../uploads/users/<?php echo $user_id . "." . $image_ext; ?>" class="thumb-img" alt="<?php echo $user_name; ?>">
                                                        </a>
                                                    </div>					

                                                    <div class="form-group m-b-0">
                                                        <label class="control-label">Image </label>
                                                        <input type="file" name="image_update" id="image_update" class="filestyle" data-buttonname="btn-primary">
                                                    </div>

                                                </div>
                                                <br>
                                                <div id="sectionTwo" class="getSections">
                                                    <h2> Permissions </h2>	
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="cat_and_sub" class="form-control"  <?php
                                                            if ($cat_and_sub == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label> Parent Categories And Sub Categories    </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="adds_and_removes" class="form-control"  <?php
                                                            if ($adds_and_removes == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label> Addes   </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="dishs" class="form-control"  <?php
                                                            if ($dishs == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label> New Items  </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="orders" class="form-control"  <?php
                                                            if ($orders == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Orders </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="clients" class="form-control"  <?php
                                                            if ($clients == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Clients</label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="problems" class="form-control"  <?php
                                                            if ($problems == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Complaints And Suggestions </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="regions" class="form-control"  <?php
                                                            if ($regions == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Regions</label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="about" class="form-control"  <?php
                                                            if ($about == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  About The Restaurant   </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="reports" class="form-control"  <?php
                                                            if ($reports == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Reports</label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="messages" class="form-control"  <?php
                                                            if ($messages == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Messages</label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="comments" class="form-control"  <?php
                                                            if ($comments == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Comments</label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="statics" class="form-control"  <?php
                                                            if ($statics == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Statistics </label>
                                                        </div>										
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="users" class="form-control"  <?php
                                                            if ($users == 1) {
                                                                echo "checked";
                                                            }
                                                            ?>>
                                                            <label>  Users</label>
                                                        </div>										
                                                    </div>

                                                </div>	

                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="user_update" id="updateUser">Update</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

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
                $("#item12").addClass("active");
            });
        </script>		

    </body>
</html>