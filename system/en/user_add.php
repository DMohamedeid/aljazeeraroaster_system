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
            if (isset($_POST['submit'])) {

                $userName = mysqli_real_escape_string($con, trim($_POST['userName']));

                $userEmail = mysqli_real_escape_string($con, trim($_POST['userEmail']));

                $userPassword = trim($_POST['userPassword']);

                $userPhone = trim($_POST['userPhone']);
                $userPhone = trim($_POST['userPhone']);

                $date_added = date("Y-m-d");
                $userType = $_POST['userType'];


                $photo_name = $_FILES['photo']['name'];
                $photo_tmp = $_FILES['photo']['tmp_name'];
                $allowed_ext = array('jpg', 'jpeg', 'gif', 'png');
                $get_image_ext = explode('.', $photo_name);
                $image_ext = strtolower(end($get_image_ext));
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
                $errors = array();

                if (empty($userName)) {
                    $errors[] = "Please enter all fields !";
                } else {
                    if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false) {
                        $errors[] = "Email is incorrect!";
                    }
                    if (strlen($userPassword) > 255) {
                        $errors[] = "Password is too large !!";
                    }
                    if (user_exists($userEmail) === true) {
                        $errors[] = "This email already exists!";
                    }
                    if (in_array($image_ext, $allowed_ext) === false) {
                        echo get_error("This file is not allowed!");
                    }
                }
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        //echo $error, '<br />';
                        echo get_error($error);
                    }
                } else {
                    $add_user = add_user($orders, $users, $clients, $statics, $problems, $comments, $reports, $about, $regions, $messages, $dishs, $adds_and_removes, $cat_and_sub, $userName, $userEmail, $userPassword, $userPhone, $userType, $photo_name, $date_added);

                    $image_path = dirname(__FILE__) . "/../uploads/users/" . mysqli_insert_id($con) . "." . $image_ext;

                    if (move_uploaded_file($photo_tmp, $image_path)) {
                        
                    }
                    echo get_success("Successfully Added");
                }
            }
            ?>	

            <?php // if(isset($_POST['submit'])) { echo add_user(); }  ?>

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
                                    <li class="active">Add New User  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b> Add New User  </b></h4>


                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>
                                        <div class="form-group">
                                            <label for="userName">Name</label>
                                            <input type="text" name="userName" parsley-trigger="change" required placeholder="Name" class="form-control" id="userName">
                                        </div>
                                        <div class="form-group">
                                            <label for="emailAddress"> Email</label>
                                            <input type="email" name="userEmail" parsley-trigger="change" required placeholder="Email " class="form-control" id="emailAddress">
                                        </div>
                                        <div class="form-group">
                                            <label for="pass1"> Password</label>
                                            <input id="pass1" name="userPassword" type="password" placeholder="Password " required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="number"> Phone </label>
                                            <input type="number" name="userPhone" required placeholder="Phone " class="form-control" id="userPhone">
                                        </div>
                                        <div class="form-group m-b-0">
                                            <label class="control-label"> Image</label>
                                            <input type="file" name="photo" id="photo" class="filestyle" data-buttonname="btn-primary">
                                        </div>										
                                        <div class="form-group col-md-3">
                                            <label class="control-label">user type </label>
                                            <select class="form-control" name="userType" id="userType" required parsley-trigger="change">
                                                <option value="1"> Manager</option>
                                                <option value="2"> User </option>
                                            </select>
                                        </div>

                                        <div id="sectionTwo" class="getSections">
                                            <h2>Permissions</h2>	
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="cat_and_sub" class="form-control">
                                                    <label>Parent Categories and Sub Categories    </label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="adds_and_removes" class="form-control">
                                                    <label> Addes   </label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="dishs" class="form-control">
                                                    <label> New Items  </label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="orders" class="form-control">
                                                    <label>  Orders</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="clients" class="form-control">
                                                    <label>  Clients</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="problems" class="form-control">
                                                    <label>  Complaints And Suggestions</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="regions" class="form-control">
                                                    <label>  Regions</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="about" class="form-control">
                                                    <label>  About The Restaurant </label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="reports" class="form-control">
                                                    <label>  Reports</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="messages" class="form-control">
                                                    <label>  Messages</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="comments" class="form-control">
                                                    <label>  Comments</label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="statics" class="form-control">
                                                    <label>  Statistics </label>
                                                </div>										
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="users" class="form-control">
                                                    <label>  Users </label>
                                                </div>										
                                            </div>

                                        </div>	

                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit">
                                                Add
                                            </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                                Cancel
                                            </button>
                                        </div>
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
                $("#item12").addClass("active");
            });
        </script>

    </body>
</html>