<?php
include("config.php");
error_reporting(0);

if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['orders'] != '1')) {
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
                                <h4 class="page-title">View  Client Orders </h4>
                                <ol class="breadcrumb">
                                    <li><a href="order_view.php"> Client Orders</a></li>
                                    <li class="active">View  Client Orders <?php echo clientName($_GET['client_id']);?></li>
                                </ol>
                            </div>
                        </div>
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
                        $client_id=$_GET['client_id'];

                        $data_num = client_orders_count(); //echo $data_num; die();
                        $allData = client_orders($start, ITEMS_PER_PAGE);  //echo '<pre>'; print_r($allData); die();
                        $url = "client_orders.php?items=" . ITEMS_PER_PAGE. (($client_id) ? "&client_id=" . $client_id : "");
                        $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
                        ?>

                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order id</th>
                                                <th> Branch</th>
                                                <th style="width:250px;"> Order Details</th>
                                                <th> Delivered</th>  
                                                <th> Status</th>  
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php $last_orders = client_orders($start, ITEMS_PER_PAGE); ?> 

                                            <?php
                                            foreach ($last_orders as $key => $row) {

                                                $order_id = $row['order_id'];
                                                $client_id = $row['client_id'];
                                                $client_address_id = $row['client_address_id'];
                                                $payment = $row['payment'];
                                                $deliver_id = $row['deliver_id'];
                                                                                        $branch_id = $row['branch_id'];
                                         $order_status= $row['order_status'];
                                                                                        $order_follow= $row['order_follow'];

                                                $get_charge = $row['charge_cost'];
                                                $date = $row['date'];
                                                $get_region_id = get_region_by_client_address($client_id, $client_address_id);
                                                ?>
                                                <tr class="gradeX <?php echo $order_id; ?>">
                                                    <td><?php echo $key; ?></td>
                                                    <td class="customFont"><?php echo $order_id; ?></td>
                                                    <td class="customFont"><?php echo get_branche_Name($branch_id); ?></td>

                                                    <td>
                                                        <button class="btn btn-info waves-effect waves-light btn-sm order_details" data-id="<?php echo $order_id; ?>" type="button" > View Details</button>
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form method="post">

                                                                        <div id="show_details">

                                                                            <div class="getDetails">





                                                                            </div>

                                                                        </div>

                                                                        <div class="clearfix"></div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td> <?php echo get_deliver_name($deliver_id); ?></td>
                                                    <td> <?php  if($order_status==1&&$order_follow==3){echo "Accepted";}elseif($order_status==2&&$order_follow==0){echo "Refused";}else{echo "Pendding";} ?></td>

                                                    <td class="customFont"><?php echo $date; ?></td>
                                                    <td>     
                                                        <a href="order_edit.php?order_Id=<?php echo $order_id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                    <td>     
                                                        <a target="_blank" href="print_bill.php?order_id=<?php echo $order_id; ?>" class="on-default"><i class="fa fa-print"></i></a>
                                                    </td>
                                                    <td class="actions">
                                                        <a href="javascript:;" data-id="<?php echo $order_id; ?>" class="deletemsg" id=""><i class="fa fa-trash-o"></i></a>
                                                    </td>			
                                                </tr>
                                            <?php } ?>
                                            <?php if ($data_num == 0) { ?>
                                                <tr class="selectable" >
                                                    <td colspan="11" class="center uniformjs" style="text-align: center"> No Elements </td>
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

            <!-- MODAL -->
            <div class="modal fade" id="delete_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="delete_reason">Delete Reason</label>
                                    <input type="text" name="delete_reason" parsley-trigger="change" required value="" class="form-control delete_reason">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="submit_delete_reason"  class="btn btn-danger submit_delete_reason">Delete</button>
                            </div>
                        </form>

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




        <script type="text/javascript">
            $('body').on('click', '.order_details', function () {
                var order_id = $(this).attr("data-id");

                $.ajax({
                    url: "functions/order_functions.php",
                    type: "POST",
                    data: {get_order: order_id},
                    success: function (data)
                    {

                        $("#show_details").empty().append(data);
                    }
                });
                $('#exampleModal').modal('show');
            });
            function count() {
                var interval = 5000;//1000=1second,3000=3seconds
                var last = $("#last").val();
                var branch_id = $("#branch_id").val();
                var user_type = $("#user_type").val();
                var dataString = 'last=' + last + '&branch_id=' + branch_id + '&user_type=' + user_type;
                $.ajax({
                    type: "POST",
                    url: "functions/order_functions.php",
                    data: dataString,
                    dataType: 'text',
                    cache: false,
                    success: function (data) {
                        if (data > 0) {
                            //alert(data)
                            ion.sound.play("door_bell", {loop: 15});
                            //location.reload();
                        }
                    },
                    complete: function (data) {
                        setTimeout(count, interval);
                    }
                });

            }
            count();

            $(document).ready(function () {

                $('body').on('click', '.deletemsg', function () {
                    var remove_order_id = $(this).attr('data-id');
                    var urlgo = $(this).attr('data-link');
                    $('#delete_order').modal('show');
                    $('body').on('click', '.submit_delete_reason', function () {
                        var delete_reason = $(".delete_reason").val();
                        var dataString = 'remove_order_id=' + remove_order_id + '&delete_reason=' + delete_reason;

                        if (delete_reason != '') {
                            $.ajax({
                                type: "POST",
                                url: "functions/order_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                    $("." + remove_order_id).remove();

                                    //alert(category);
                                }
                            });
                            $('#delete_order').modal('hide');

                        } else {
                            alert("Please Enter The Reason For The Deletion")
                        }
                    });
                });

            });

            $(document).ready(function () {
                $('.verify').click(function () {
                    var verify = $(this).attr('lang');
                    var client_id = $(this).attr('data-id');

                    swal({
                        title: "Confirmation of approve?",
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
                            swal("approved", "", "success");
                            var dataString = 'verify=' + verify + '&client_id=' + client_id;
                            $.ajax({
                                type: "POST",
                                url: "functions/order_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });

                        } else {
                            swal("Cancelled ", "Cancelled:)", "error");
                        }
                    });
                });
                $('.cancel_verify').click(function (event) {
                    event.preventDefault();
                    var cancel_verify = $(this).attr('lang');
                    var client_id = $(this).attr('data-id');
                    // alert(client_id);
                    swal({
                        title: "cancel approve?",
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
                            swal("Approval canceled", "", "success");
                            //alert(cancel_verify);
                            var dataString = 'cancel_verify=' + cancel_verify + '&client_id=' + client_id;
                            $.ajax({
                                type: "POST",
                                url: "functions/order_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });

                        } else {
                            swal(" canceled", "canceled  :)", "error");
                        }
                    });
                });
                $('.edit_process').change(function (event) {
                    event.preventDefault();
                    var order_id = $(this).attr('lang');
                    var client_id = $(this).attr('data-id');
                    var edit_follow = $(this).val();
                    swal({
                        title: "Change status",
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
                            swal("Status changed", "", "success");
                            //alert(cancel_verify);
                            var dataString = 'edit_follow=' + edit_follow + '&order_id=' + order_id + '&client_id=' + client_id;
                            $.ajax({
                                type: "POST",
                                url: "functions/order_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });

                        } else {
                            swal("changed ", "changed  :)", "error");
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item7").addClass("active");
            });
        </script>		

        <script>
            $(document).ready(function () {

                ion.sound({
                    sounds: [
                        {name: "door_bell"},
                        {name: "door_bell"}
                    ],
                    path: "sounds/",
                    preload: true,
                    volume: 1.0
                });


                $("#b01").on("click", function () {
                    ion.sound.play("door_bell");
                });

                $("#b02").on("click", function () {
                    ion.sound.play("door_bell");
                });



            });
            $('body').on('change', '.change_setting_status_off', function () {
                var change_setting_status_off = $(this).attr('data-id');
                var user_type = $(this).attr('data-type');
                var branch_id = $(this).attr('data-branch');
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
                        if (user_type == 1) {

                            var dataString = 'change_setting_status_off=' + change_setting_status_off;
                            $.ajax({
                                type: "POST",
                                url: "functions/contacts_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });
                        } else {
                            var dataString = 'change_setting_status_off=' + change_setting_status_off + '&branch_id=' + branch_id;
                            $.ajax({
                                type: "POST",
                                url: "functions/branches_function.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });
                        }
                    } else {
                        swal("changed ", "changed  :)", "error");
                    }
                });
            });
            $('body').on('change', '.change_setting_status_on', function () {
                var change_setting_status_on = $(this).attr('data-id');
                var user_type = $(this).attr('data-type');
                var branch_id = $(this).attr('data-branch');
                swal({
                    title: "Change the status?",
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
                        swal("changed", "", "success");
                        if (user_type == 1) {

                            var dataString = 'change_setting_status_on=' + change_setting_status_on;
                            $.ajax({
                                type: "POST",
                                url: "functions/contacts_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });
                        } else {
                            var dataString = 'change_setting_status_on=' + change_setting_status_on + '&branch_id=' + branch_id;
                            $.ajax({
                                type: "POST",
                                url: "functions/branches_function.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                }
                            });
                        }
                    } else {
                        swal("changed", "changed  :)", "error");
                    }
                });
            });

        </script>		

        <script>

            $(window).ready(function () {

                var time = 60

                setInterval(function () {

                    time--;

                    $('#time').html(time);

                    if (time === 0) {

                        location.reload()
                    }


                }, 1000);

            });

        </script>


        <style>
            .autoRef {
                display: block;
                float: left;
                margin-bottom: 30px;
            }

            .autoRef #time {
                display: block;
                float: left;
                color: #FFFFFF;
                font-size: 40px;
                width: 100px;
                height: 80px;
                border: 1px solid #FFFFFF;
                border-radius: 3px;
                line-height: 60px;
                padding: 10px;
                background-color: orange;
                text-align: center;
            }

            .autoRef #text {
                display: block;
                float: left;
                margin-left: 10px;
                padding: 5px;
                text-align: center;
                font-size: 30px;
                width: 100px;
                height: 80px;
                color: #000;
                border-radius: 3px;
                border: 1px solid #eee;
                background-color: #FFFFFF;
                line-height: 60px;
            }
            .getDetails {
                display:block;
            }
            .getLogo {
                display: block;
                width: 30%;
                text-align: center;
                margin: auto;
            }
            .getLogo img {
                display: block;
                max-width: 100%;
                height: auto;
                text-align: center;
            }
            .getAddress {
                display:block;
            }
            .getAddress p {
                display: block;
                text-align: center !important;
                margin: 15px 0 !important;
                color: orange;
                font-size: 18px;
            }
            .getAddress table {

            }
            .getOrder {
                display:block;
            }
            .getOrder p {
                display: block;
                text-align: center !important;
                margin: 15px 0 !important;
                color: orange;
                font-size: 18px;
            }
            .getOrder table {

            }
            .getTotal {
                display:block;
            }
            .getTotal table {

            }


            .modal-dialog {
                width: 850px !important;
                margin: 30px auto;
            }

        </style>



    </body>
</html>