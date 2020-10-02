<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['cat_and_sub'] != '1')) {
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

            <div class="deleteData"></div>

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">View Sub Categories</h4>
                                <ol class="breadcrumb">
                                    <li><a href="sub_category_view.php">View Sub Categories</a></li>
                                    <li class="active">View Sub Categories  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-body">
                                <div class="">


                                    <div class="col-md-3">
                                        <label  for="sub_ct_name" class=" control-label">Search By English Sub Category Name     </label> 
                                        <input name="sub_ct_name" id="sub_ct_name" value="<?php echo $_GET['sub_ct_name']; ?>" type="text" value="" class= "form-control  search-input-text"  >

                                        <br>
                                        <button class="btn btn-icon btn-default" type="button" style="padding:6px 16px;" onclick="setAction();">Search </button>

                                    </div> 
                                    <div class="clearfix"></div>
                                    <?php
                                    $items = (int) $_GET['items'];
                                    $items = $items ? $items : 20;
                                    $query_items = '';
                                    if ((INT) $_GET['items'] > 0) {
                                        $query_items = '&items=' . (INT) $_GET['items'];
                                    }

                                    define(ITEMS_PER_PAGE, $items);

                                    $page = (int) $_GET['page'];
                                    $page = ($page < 1) ? 1 : $page;
                                    $start = ($page - 1) * ITEMS_PER_PAGE;
                                    $sub_ct_name = $_GET['sub_ct_name'];
                                    $parent_category_id = $_GET['parent_category_id'];
                                    $branch_id = $_GET['branch_id'];
                                    $data_num = sub_category_count($_GET); //echo $data_num; die();
                                    $allData = view_sub_cat($start, ITEMS_PER_PAGE, $_GET);  //echo '<pre>'; print_r($allData); die();
                                    $url = "sub_category_view.php?items=" . ITEMS_PER_PAGE . (($sub_ct_name) ? "&sub_ct_name=" . $sub_ct_name : "") . (($parent_category_id) ? "&parent_category_id=" . $parent_category_id : "") . (($branch_id) ? "&branch_id=" . $branch_id : "");
                                    $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
                                    ?>
                                    <h4>
                                        Sub Categories Number
                                        : 
                                        <?php echo $data_num; ?></h4>
                                    <table class="table table-striped" id="">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>English Name  </th>
                                                <th>Arabic Name </th>
                                                <th>Parent Category</th>
                                                <th>Image</th>
                                                <th>Details </th>
                                                <th>Show?</th>
                                                <th>Comments</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($allData as $key => $row) {
                                                $sub_category_id = $row['sub_category_id'];
                                                $sub_category_name = $row['sub_category_name'];
                                                $sub_category_name_ar = $row['sub_category_name_ar'];
                                                $sub_category_desc = $row['sub_category_desc'];
                                                $parent_category_id = $row['parent_category_id'];
                                                $date = $row['date'];
                                                $display = $row['display'];
                                                $image = $row['sub_category_image'];
                                                if (!remoteFileExists($image)) {
                                                        global $logo_image;
                                                        $image=$logo_image;
                                                    }
                                                
                                                ?>
                                                <tr class="gradeX <?php echo $sub_category_id; ?>">
                                                    <td><?php echo $key; ?></td>
                                                    <td><?php echo substr($sub_category_name, 0, 25); ?></td>
                                                    <td><?php echo substr($sub_category_name_ar, 0, 25); ?></td>
                                                    <td><?php echo sub_parent_category($parent_category_id); ?></td>
                                                    <td>
                                                        <a href="<?php echo $image; ?>" class="image-popup" title="<?php echo $sub_category_name; ?>">
                                                            <img src="<?php echo $image; ?>" class="thumb-img" alt="<?php echo $sub_category_name; ?>" height="100" style="width:100px;">
                                                        </a>			
                                                    </td>
                                                    <td style="text-align:center;">      
                                                        <a href="sub-cat-details.php?subCatId=<?php echo $sub_category_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
                                                    </td>

                                                    <td>
                                                        <?php if ($display == 1) { ?>
                                                            <input class="change_status_off" data-id="<?php echo $sub_category_id; ?>" type="checkbox" 
                                                                   checked
                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php } else if ($display == 0) {
                                                                   ?>
                                                            <input class="change_status_on" data-id="<?php echo $sub_category_id; ?>" type="checkbox" 

                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php }
                                                               ?>

                                                    </td>
                                                    <td>  
                                                        <?php if (sub_cat_comments_count($sub_category_id) >= 1) { ?>
                                                            <a href="subcat_comments_view.php?sub_category_id=<?php echo $sub_category_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
                                                            <?php
                                                        } else {
                                                            echo "No Comments";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="actions">
                                                        <a href="sub_category_edit.php?subCatId=<?php echo $sub_category_id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                                                    </td>			
                                                    <td class="actions">
                                                        <a href="javascript:;" data-id="<?php echo $sub_category_id; ?>" class="deletemsg" id="deleteParent"><i class="fa fa-trash-o"></i></a>
                                                    </td>			
                                                </tr>	
                                            <?php } ?>
                                            <?php if ($data_num == 0) { ?>
                                                <tr class="selectable" >
                                                    <td colspan="7" class="center uniformjs" style="text-align: center"> There Are No Items</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="pull-left" style="width: auto; ">
                                        <?php echo $navigation; ?>
                                    </div>                                </div>
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
                $('body').on('click', '.deletemsg', function () {
                    var remove_sub_category = $(this).attr('data-id');
                    var dataString = 'sub_category_delete=' + remove_sub_category;
                    bootbox.dialog({
                        message: "Delete this item?",
                        title: "Message Confirm deletion", buttons: {
                            danger: {
                                label: "cancell",
                                className: "btn-danger"
                            },
                            main: {
                                label: "delete", className: "btn-primary",
                                callback: function () {
                                    //do something else
                                    $.ajax({
                                        type: "POST",
                                        url: "functions/sub_cat_functions.php",
                                        data: dataString,
                                        dataType: 'text', cache: false,
                                        success: function (data) {
                                            $(".deleteData").html(data);
                                            $("." + remove_sub_category).remove();

                                            //alert(category);
                                        }
                                    });
                                }
                            }
                        }
                    });
                });

            });
            $('body').on('change', '.change_status_off', function () {
                var change_status_off = $(this).attr('data-id');
                var dataString = 'change_status_off=' + change_status_off;
                swal({
                    title: "submit hidden?",
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
                        swal("Changed ", "", "success");
                        var dataString = 'change_status_off=' + change_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/sub_cat_functions.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal("Changed ", "Changed  :)", "error");
                    }
                });
            });
            $('body').on('change', '.change_status_on', function () {
                var change_status_on = $(this).attr('data-id');
                var dataString = 'change_status_on=' + change_status_on;
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
                        swal("Changed", "", "success");
                        var dataString = 'change_status_on=' + change_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/sub_cat_functions.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal("Changed", "Changed  :)", "error");
                    }
                });
            });
            $('body').on('change', '.change_spicy_status_off', function () {
                var change_spicy_status_off = $(this).attr('data-id');
                var dataString = 'change_spicy_status_off=' + change_spicy_status_off;
                swal({
                    title: "submit hidden?",
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
                        swal("Changed ", "", "success");
                        var dataString = 'change_spicy_status_off=' + change_spicy_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/sub_cat_functions.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal("Changed ", "Changed  :)", "error");
                    }
                });
            });
            $('body').on('change', '.change_spicy_status_on', function () {
                var change_spicy_status_on = $(this).attr('data-id');
                var dataString = 'change_spicy_status_on=' + change_spicy_status_on;
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
                        swal("Changed", "", "success");
                        var dataString = 'change_spicy_status_on=' + change_spicy_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/sub_cat_functions.php",
                            data: dataString,
                            dataType: 'text',
                            cache: false,
                            success: function (data) {
                                $(".deleteData").html(data);
                            }
                        });
                    } else {
                        swal("Changed", "Changed  :)", "error");
                    }
                });
            });

        </script>

        <script>
            function setAction() {
                var sub_ct_name = $("#sub_ct_name").val();
                var branch_id = $("#branch_id").val();
                //alert(sub_ct_name)
                if (sub_ct_name !== '' && branch_id !== '') {
                    var link = 'sub_category_view.php?sub_ct_name=' + sub_ct_name;
                    document.location.href = link;
                } else {
                    window.location = 'sub_category_view.php';
                }
            }

            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item3").addClass("active");
            });
        </script>		

    </body>
</html>