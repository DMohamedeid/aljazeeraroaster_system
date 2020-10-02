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
error_reporting(0);
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


            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <div class="">
                            <?php
                            if (isset($_GET['sub_category_id']) && $_GET['sub_category_id'] != '') {
                                $con->query("UPDATE `sub_category_comments` SET `viewed`=1  where `sub_category_id`='" . $_GET['sub_category_id'] . "'");
                            }
                            ?>
                            <div class="p-20">
                                <h4 class="m-b-20 header-title"><b>Sub Category Comments</b></h4>
                                <div class="nicescroll p-l-r-10" style="max-height: 555px;">
                                    <div class="timeline-2">
                                        <?php
                                        $items = (int) $_GET['items'];
                                        $items = $items ? $items : 20;
                                        $query_items = '';
                                        if ((INT) $_GET['items'] > 0) {
                                            $query_items = '&items=' . (INT) $_GET['items'];
                                        }
                                        $sub_category_id = $_GET['sub_category_id'];
                                        $client_id = $_GET['client_id'];

                                        define(ITEMS_PER_PAGE, $items);

                                        $page = (int) $_GET['page'];
                                        $page = ($page < 1) ? 1 : $page;
                                        $start = ($page - 1) * ITEMS_PER_PAGE;
                                        $data_num = subcat_comments_count($_GET);
//                                    echo $data_num; die();
                                        $allData = view_subcat_comments($start, ITEMS_PER_PAGE, $_GET);
//                                    echo '<pre>'; print_r($allData); die();

                                        $url = "subcat_comments_view.php?items=" . ITEMS_PER_PAGE . (($sub_category_id) ? "&sub_category_id=" . $sub_category_id : "") . (($client_id) ? "&client_id=" . $client_id : "");
                                        $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
                                        ?>
                                        <?php foreach ($allData as $one) { ?>
                                            <div class="card-box" id="comment_<?php echo $one['comment_id']; ?>">
                                                <div class="table-detail table-actions-bar" style="margin-right: 1028px;">
                                                    <a href="edit_comment.php?comment_id=<?php echo $one['comment_id']; ?>" class="table-action-btn " ><i class="md md-edit"></i></a>
                                                    <a href="#" class="table-action-btn delete-comment" data-id="<?php echo $one['comment_id']; ?> " style="margin-right: 31px;"><i class="md md-close"></i></a>
                                                </div>
                                                <div class="product-right-info">
                                                    <span><b> client name:</b></span><?php echo clientName($one['client_id']); ?>
                                                    <br>
                                                    <span><b> phone  :</b></span><?php echo clientPhone($one['client_id']); ?>
                                                    <br>
                                                    <span><b> Subcategory name   :</b></span><a href="sub-cat-details.php?subCatId=<?php echo $one['sub_category_id']; ?>"><?php echo sub_category_name($one['sub_category_id']); ?><a>
                                                            <br>

                                                            <span><b> Date Added :</b></span><?php echo $one['date']; ?> 
                                                            <br>
                                                            <span><b> Comment :</b></span><?php echo $one['comment']; ?>
                                                            <br>
                                                            <span><b> Rate :</b></span><?php echo $one['rate']; ?>
                                                            </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($data_num == 0) { ?>
                                                            No Comments

                                                        <?php } ?>

                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>	
                                                        <div class="pull-left" style="width: auto; ">
                                                            <?php echo $navigation; ?>
                                                        </div>

                                                        </div>			
                                                        </div>
                                                        <?php include("include/footer_text.php"); ?>
                                                        </div>			
                                                        <div id="myModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title">Confirm deletion</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>
                                                                            Delete Comment?

                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                                                                        <button type="button" data-dismiss="modal" class="btn green" id="confirm"> Delete</button>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                $("#item101").addClass("active");
                                                            });
                                                            $('.delete-comment').on("click", function () {
                                                                $('#myModal').modal('show');
                                                                var comment_id = $(this).attr('data-id');
                                                                $('body').on('click', '#confirm', function () {
                                                                    var dataString = 'comment_id=' + comment_id;
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "functions/sub_cat_functions.php",
                                                                        data: dataString,
                                                                        dataType: 'text',
                                                                        cache: false,
                                                                        success: function (data) {
                                                                            $("#comment_" + comment_id + "").remove();
                                                                            //alert(category);
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>

                                                        </body>
                                                        </html>