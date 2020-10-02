<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}
if (($_SESSION['comments'] != '1')) {
    header("Location: error.php");
    exit();
}
?>

<?php
// error_reporting(0);

if (isset($_POST['comment_update'])) {
    $temp = $_POST;

    $update = $con->query("UPDATE `sub_category_comments` SET `comment`='" . $temp['comment'] . "',`rate`='" . $temp['rate'] . "' WHERE `comment_id`='" . $temp['id'] . "'");

    if ($update) {
        echo get_success("Successfully updated");
    } else {
        echo get_error("Here's a error!");
    }
}
?>

<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <style>.red.btn {
            /* color: #FFFFFF; */
            background-color: #cb5a5e;
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

            <div class="content-page">
                <div class="content">
                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Edit Comment </h4>
                            </div>
                        </div>
                        <?php
                        if ($_GET['comment_id']) {

                            $comment_id = $_GET['comment_id'];

                            $query_select = $con->query("SELECT * FROM `sub_category_comments` WHERE `comment_id` = '{$comment_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $comment = $row_select['comment'];
                            $id = $row_select['comment_id'];
                            $rate = $row_select['rate'];

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									

                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="id" id="id" parsley-trigger="change" required value="<?php echo $id; ?>" class="form-control">

                                                <div class="form-group col-md-6">
                                                    <label for="comment">Comment</label>
                                                    <input type="text" name="comment" value="<?php echo $comment; ?>" parsley-trigger="change" required placeholder="comment" class="form-control" id="comment">
                                                </div>
                                                <div class="clearfix"></div>

                                                <div class="form-group col-md-6">
                                                    <label class="control-label">Rate </label>
                                                    <select class="form-control" name="rate" required parsley-trigger="change">
                                                        <option value="">choose</option>
                                                        <option value="1" <?php
                                                        if ($rate == 1) {
                                                            echo "selected";
                                                        }
                                                        ?>>1</option>
                                                        <option value="2" <?php
                                                        if ($rate == 3) {
                                                            echo "selected";
                                                        }
                                                        ?>>2</option>
                                                        <option value="3" <?php
                                                        if ($rate == 3) {
                                                            echo "selected";
                                                        }
                                                        ?>>3</option>
                                                        <option value="4" <?php
                                                        if ($rate == 4) {
                                                            echo "selected";
                                                        }
                                                        ?>>4</option>
                                                        <option value="5" <?php
                                                        if ($rate == 5) {
                                                            echo "selected";
                                                        }
                                                        ?>>5</option>
                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>

                                                <br>
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="comment_update" id="comment_update">Update</button>
                                                </div>
                                            </form>								
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
                                    $("#item101").addClass("active");
                                });
                            </script>
                        </div>	
                    </div>          

                </div>
            </div>
    </body>
</html>