<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['regions'] != '1')) {
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <link href="assets/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />

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
                                <h4 class="page-title">View Regions </h4>
                                <ol class="breadcrumb">
                                    <li><a href="regions_view.php">Regions</a></li>
                                    <li class="active">Regions </li>
                                </ol>
                            </div>
                        </div>
                       
                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-striped" id="custom_tbl_dt">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Region English Name </th>
                                                <th>Region Arabic Name </th>
                                                <th>Charge Cost  </th>
                                                <th>Minimum order     </th>
                                                <th>Status</th>
                                                <th>  </th>
                                                <th>  </th>

                                            </tr>
                                        </thead>
                                        <tbody> <?php $regions = view_regions() ?>
                                            <?php foreach ($regions as $key => $one) { ?>
                                                <tr class="gradeX  <?php echo $one['region_id']; ?>">
                                                    <td><?php echo $key; ?></td>
                                                    <td><?php echo $one['region_name_ar']; ?></td>
                                                    <td><?php echo $one['region_name_en']; ?></td>
                                                    <td><?php echo $one['charge']; ?>  B.D</td>
                                                    <td><?php echo $one['min_order']; ?>   B.D</td>
                                                    <td>
                                                        <?php if ($one['display'] == 1) { ?>
                                                            <input class="change_region_status_off" data-id="<?php echo $one['region_id']; ?>" type="checkbox" 
                                                                   checked
                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php } else if ($one['display'] == 0) {
                                                                   ?>
                                                            <input class="change_region_status_on" data-id="<?php echo $one['region_id']; ?>" type="checkbox" 

                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php }
                                                               ?>

                                                    </td>
                                                    <td>
                                                        <a href="regions_edit.php?regionId=<?php echo $one['region_id']; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                    <td >
                                                        <a data-id="<?php echo $one['region_id']; ?>" data-link="functions/regions_functions.php" class="deletemsg"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
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
        <script src="assets/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>

        <script type="text/javascript">

            //to open model for accept del
            $('body').on('click', '.deletemsg', function () {
                var region_delete = $(this).attr('data-id');
                var dataString = 'region_delete=' + region_delete;
                var urlgo = $(this).attr('data-link');
                bootbox.dialog({
                    message: "Do you want to delete this item?",
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
                                    url: urlgo,
                                    data: dataString,
                                    dataType: 'text',
                                    cache: false,
                                    success: function (data) {
                                        $(".deleteData").html(data);
                                        $("." + region_delete).remove();

                                        //alert(category);
                                    }
                                });
                            }
                        }
                    }
                });
            });

            $('body').on('change', '.change_region_status_off', function () {
                var change_region_status_off = $(this).attr('data-id');
                var dataString = 'change_region_status_off=' + change_region_status_off;
                swal({
                    title: "Confirm hidden?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "yes",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("changed ", "", "success");
                        var dataString = 'change_region_status_off=' + change_region_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/regions_functions.php",
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
            $('body').on('change', '.change_region_status_on', function () {
                var change_region_status_on = $(this).attr('data-id');
                var dataString = 'change_region_status_on=' + change_region_status_on;
                swal({
                    title: "Change Status?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "yes",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("changed ", "", "success");
                        var dataString = 'change_region_status_on=' + change_region_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/regions_functions.php",
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
            $('body').on('change', '.change_setting_status_off', function () {
                var change_setting_status_off = $(this).attr('data-id');
                swal({
                    title: "Confirm hidden?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "yes",
                    cancelButtonText: "cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        swal("changed ", "", "success");
                        var dataString = 'change_setting_status_off=' + change_setting_status_off;
                        $.ajax({
                            type: "POST",
                            url: "functions/regions_functions.php",
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
            $('body').on('change', '.change_setting_status_on', function () {
                var change_setting_status_on = $(this).attr('data-id');
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
                        swal("changed ", "", "success");
                        var dataString = 'change_setting_status_on=' + change_setting_status_on;
                        $.ajax({
                            type: "POST",
                            url: "functions/regions_functions.php",
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
                $("#item8").addClass("active");
            });
        </script>		

    </body>
</html>