<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['cat_and_sub'] != '1')) {
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
                                <h4 class="page-title">View Parent Categories  </h4>
                                <ol class="breadcrumb">
                                    <li><a href="parent_category_view.php"> Parent Categories</a></li>
                                    <li class="active">Parent Categories  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
<!--                                    pagination -->
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

                                    $data_num = parent_categories_count($_GET); //echo $data_num; die();
                                    $allData = view_parent_categories($start, ITEMS_PER_PAGE, $_GET);  //echo '<pre>'; print_r($allData); die();
                                    $url = "parent_category_view.php?items=" . ITEMS_PER_PAGE;
                                    $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
                                    ?>
                                    <h4>
                                        Count All   :
                                        <?php echo $data_num; ?></h4>
                                    <table class="table table-striped" id="">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>English Name </th>
                                                <th>Arabic Name </th>
                                                <th>Image</th>
                                                <th>Details </th>
                                                <th>Show?</th>
                                                <th>Date Added </th>
                                                <th>Arrangement</th>
                                                <th>  </th>
                                                <th>  </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($allData as $key => $one) {
                                                    $image=$one['parent_category_image'];


                                            ?>
                                                <tr class="gradeX <?php echo $one['parent_category_id']; ?>">
                                                    <td><?php echo $key; ?></td>
                                                    <td><a href="sub_category_view.php?parent_category_id=<?php echo $one['parent_category_id']; ?>"><?php echo $one['parent_category_name']; ?></a></td>
                                                    <td><a href="sub_category_view.php?parent_category_id=<?php echo $one['parent_category_id']; ?>"><?php echo $one['parent_category_name_ar']; ?></a></td>

                                                    <td>
                                                        <a href="<?php echo $image; ?>" class="image-popup" title="<?php echo $one['parent_category_name']; ?>">
                                                            <img src="<?php echo $image; ?>" class="thumb-img" alt="<?php echo $one['parent_category_name']; ?>" height="100" style="width:100px;">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="parent-cat-details.php?catId=<?php echo $one['parent_category_id']; ?>" class="on-default"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>
                                                        <?php if ($one['display'] == 1) { ?>
                                                            <input class="change_cat_status_off" data-id="<?php echo $one['parent_category_id']; ?>" type="checkbox"
                                                                   checked
                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php } else if ($one['display'] == 0) {
                                                                   ?>
                                                            <input class="change_cat_status_on" data-id="<?php echo $one['parent_category_id']; ?>" type="checkbox"
                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php }
                                                               ?>

                                                    </td>
                                                    <td><?php echo $one['date']; ?></td>
                                                    <td><?php echo $one['arrangement']; ?></td>

                                                    <td class="actions">
                                                        <a href="parent_category_edit.php?catId=<?php echo $one['parent_category_id']; ?>" class=""><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                    <td class="actions">
                                                        <a data-id="<?php echo $one['parent_category_id']; ?>" class="deletemsg"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <?php if ($data_num == 0) { ?>
                                                <tr class="selectable" >
                                                    <td colspan="7" class="center uniformjs" style="text-align: center">  No Elements </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="pull-left" style="width: auto; ">
                                        <?php echo $navigation; ?>
                                    </div>
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
        <script type="text/javascript">

            //to open model for accept del
            $('body').on('click', '.deletemsg', function () {
                var category = $(this).attr('data-id');
                var dataString = 'category=' + category;
                bootbox.dialog({
                    message: "Delete This Item?",
                    title: "Message Confirm Deletion",
                    buttons: {
                        danger: {
                            label: "Cancel",
                            className: "btn-danger"
                        },
                        main: {
                            label: "delete",
                            className: "btn-primary",
                            callback: function () {
                                //do something else
                                $.ajax({
                                    type: "POST",
                                    url: "functions/parent_cat_functions.php",
                                    data: dataString,
                                    dataType: 'text',
                                    cache: false,
                                    success: function (data) {
                                        $(".deleteData").html(data);
                                        $("." + category).remove();

                                        //alert(category);
                                    }
                                });
                            }
                        }
                    }
                });
            });

            $('body').on('change', '.change_cat_status_off', function () {
                var change_cat_status_off = $(this).attr('data-id');
                var dataString = 'change_cat_status_off=' + change_cat_status_off;
                swal({
                    title: "Confirm hide?",
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
                        swal("changed ", "", "success");
                        var dataString = 'change_cat_status_off=' + change_cat_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_cat_status_on', function () {
                var change_cat_status_on = $(this).attr('data-id');
                var dataString = 'change_cat_status_on=' + change_cat_status_on;
                swal({
                    title: "Change Status?",
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
                        var dataString = 'change_cat_status_on=' + change_cat_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_sweetness_status_off', function () {
                var change_sweetness_status_off = $(this).attr('data-id');
                var dataString = 'change_sweetness_status_off=' + change_sweetness_status_off;
                swal({
                    title: "Confirm hide?",
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
                        swal("changed ", "", "success");
                        var dataString = 'change_sweetness_status_off=' + change_sweetness_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_sweetness_status_on', function () {
                var change_sweetness_status_on = $(this).attr('data-id');
                var dataString = 'change_sweetness_status_on=' + change_sweetness_status_on;
                swal({
                    title: "Change Status?",
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
                        var dataString = 'change_sweetness_status_on=' + change_sweetness_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_milk_status_off', function () {
                var change_milk_status_off = $(this).attr('data-id');
                var dataString = 'change_milk_status_off=' + change_milk_status_off;
                swal({
                    title: "Confirm hide?",
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
                        swal("changed ", "", "success");
                        var dataString = 'change_milk_status_off=' + change_milk_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_milk_status_on', function () {
                var change_milk_status_on = $(this).attr('data-id');
                var dataString = 'change_milk_status_on=' + change_milk_status_on;
                swal({
                    title: "Change Status?",
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
                        var dataString = 'change_milk_status_on=' + change_milk_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_shot_status_off', function () {
                var change_shot_status_off = $(this).attr('data-id');
                var dataString = 'change_shot_status_off=' + change_shot_status_off;
                swal({
                    title: "Confirm hide?",
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
                        swal("changed ", "", "success");
                        var dataString = 'change_shot_status_off=' + change_shot_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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
            $('body').on('change', '.change_shot_status_on', function () {
                var change_shot_status_on = $(this).attr('data-id');
                var dataString = 'change_shot_status_on=' + change_shot_status_on;
                swal({
                    title: "Change Status?",
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
                        var dataString = 'change_shot_status_on=' + change_shot_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/parent_cat_functions.php",
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

        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item2").addClass("active");
            });
        </script>

    </body>
</html>