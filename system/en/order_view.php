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
                            <div class="col-sm-6">
                                <h4 class="page-title">View Current Orders </h4>
                                <ol class="breadcrumb">
                                    <li><a href="order_view.php">View Current Orders </a></li>
                                    <li class="active">View Current Orders  </li>
                                </ol>
                            </div>

                            <div class="col-sm-6">
                                <div class="autoRef">
                                    <div id="time">0</div>
                                    <a id="text">Update</a>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="autoRef">

                                    <?php
                                    $query_select = $con->query("SELECT * FROM `setting` order by id desc");

                                    $row_select = mysqli_fetch_array($query_select);

                                    $setting_id = $row_select['id'];
                                    $accept_orders = $row_select['accept_orders'];
                                    ?>
                                    <?php if ($accept_orders == 1) { ?>
                                        <input class="change_setting_status_off" data-id="<?php echo $setting_id; ?>" type="checkbox" 
                                               checked
                                               data-plugin="switchery" data-color="#81c868"/>
                                           <?php } else if ($accept_orders == 0) {
                                               ?>
                                        <input class="change_setting_status_on" data-id="<?php echo $setting_id; ?>" type="checkbox" 

                                               data-plugin="switchery" data-color="#81c868"/>
                                           <?php }
                                           ?>
                                </div>
                            </div>

                        </div>


                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-3 form-group">
                                    <label  for="order_id" class=" control-label">Search By Order Id     </label> 
                                    <input   class="form-control search-input-text" name="order_id" placeholder="Order Id " id="order_id" value="<?php echo $_GET['order_id']; ?>" type="text" >
                                </div> 
                                <div class="col-md-3 form-group">
                                    <label  for="client_phone" class=" control-label">Search By Client Phone     </label> 
                                    <input   class="form-control search-input-text" name="client_phone" placeholder="Client Phone" id="client_phone" value="<?php echo $_GET['client_phone']; ?>" type="text" >
                                </div> 
                                <div class="col-md-3 form-group">
                                    <button class="btn btn-icon btn-default" type="button" style="padding:6px 16px;    margin-top: 51px;" onclick="setAction();">Search </button>
                                    <button class="btn btn-icon btn-success" type="button" style="padding:6px 16px;    margin-top: 51px;" onclick="setNoAction();">Retry </button>
                                </div>                                

                                <div class="">
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
                                    $order_id = $_GET['order_id'];
                                    $client_phone = $_GET['client_phone'];
                                    $data_num = current_order_count($_GET); //echo $data_num; die();
                                    $allData = view_order($start, ITEMS_PER_PAGE, $_GET);  //echo '<pre>'; print_r($allData); die();
                                    $url = "order_view.php?items=" . ITEMS_PER_PAGE . (($order_id) ? "&order_id=" . $order_id : "") . (($client_phone) ? "&client_phone=" . $client_phone : "");
                                    $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
                                    ?>
                                    <input type="hidden" name="last" id="last" value="<?php echo lastOrder($_SESSION['user_type']); ?>">
                                    <input type="hidden" name="user_type" id="user_type" value="<?php echo $_SESSION['user_type']; ?>">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Id </th>
                                                <th> Phone Number </th>
                                                <th> Client type </th>
                                                <th>Order Details </th>
                                                <th> Delivery way</th>                                  
                                                <th>Approve / Refuse</th>
                                                <th>Order Follow </th>
                                                <th>Device Type </th>
                                                <th>Net Price(BD) </th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php $view_order = view_order($start, ITEMS_PER_PAGE, $_GET); ?> 
                                            <?php
                                            $x=1;
                                            foreach ($view_order as $key => $row) {
                                                $order_id = $row['order_id'];
                                                $client_id = $row['client_id'];
                                                $order_status = $row['order_status'];
                                                $order_follow = $row['order_follow'];
                                                $client_address_id = $row['client_address_id'];
                                                $payment = $row['payment'];
                                                $deliver_id = $row['deliver_id'];
                                                $get_charge = $row['charge_cost'];
                                                $mobile_type = $row['mobile_type'];
                                                $get_region_id = get_region_by_client_address($client_id, $client_address_id);
                                                $client_phone = get_client_phone_by_id($client_id);
                                                $net_price = $row['net_price'];
                                                $date = $row['date'];
                                                ?>
                                                <tr class="gradeX <?php echo $order_id; ?>">
                                                    <td><?php echo $x; ?></td>
                                                    <td class="customFont"><?php echo $order_id; ?></td>
                                                    <td class="customFont"><?php echo $client_phone; ?></td>
                                                    <td><?php
                                                        if (check_client_exists_in_orders($client_id, $order_id) >= 1) {
                                                            echo " Old Client";
                                                        } else {
                                                            echo " New Client";
                                                        }
                                                        ?>
                                                    </td>                                                   
                                                    <td>
                                                        <button class="btn btn-info waves-effect waves-light btn-sm order_details"  data-id="<?php echo $order_id; ?>" type="button" >Order Details </button>
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

                                                    <td style="text-align:center;" class="mousta">
                                                        <?php
                                                        if ($order_status == 0) {
                                                            echo '<div class="verifyMeTwo"><a>Not Approved </a><br /><br /><a lang="' . $order_id . '" data-id="' . $client_id . '" class="btn btn-info waves-effect waves-light btn-sm verify">Approve </a><div class="clearfix"><br></div><a lang="' . $order_id . '" data-id="' . $client_id . '" class="btn btn-info waves-effect waves-light btn-sm cancel_verify"> Refuse</a></div>';
                                                        } elseif ($order_status == 1) {
                                                            echo '<div class="cancelVerifyMeTwo"><a>Approved</a><br /><br /><a lang="' . $order_id . '" data-id="' . $client_id . '"  class="btn btn-info waves-effect waves-light btn-sm cancel_verify">Cancel Approve </a></div>';
                                                        } elseif ($order_status == 2) {
                                                            echo '<div class="cancelVerifyMeTwo"><a>Refused </a><br /></div>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <select class="form-control edit_process" lang="<?php echo $order_id; ?>" data-type="<?php echo $deliver_id; ?>" data-id="<?php echo $client_id; ?>"  name="edit_process" style="    width: 102px;">
                                                            <option value=" "> choose</option>
                                                            <?php
                                                            if ($order_follow == 1) {
                                                                echo '<option value="1" selected> Processing</option>';
                                                                if ($deliver_id != 1) {
                                                                    echo ' <option value="2" > Ready</option>';
                                                                } else {
                                                                    echo ' <option value="2" > Deliver</option>';
                                                                }
                                                                echo '<option value="3"> Receipt</option>';
                                                            } else if ($order_follow == 2) {
                                                                echo '<option value="1" > Processing</option>';
                                                                if ($deliver_id != 1) {
                                                                    echo ' <option value="2" selected> Ready</option>';
                                                                } else {
                                                                    echo ' <option value="2" selected> deliver</option>';
                                                                }
                                                                echo '<option value="3"> Receipt</option>';
                                                            } else if ($order_follow == 3) {
                                                                echo '<option value="1" > Processing</option>';
                                                                if ($deliver_id != 1) {
                                                                    echo ' <option value="2" > Ready</option>';
                                                                } else {
                                                                    echo ' <option value="2" > Deliver</option>';
                                                                }
                                                                echo '<option value="3" selected> Receipt</option>';
                                                            } else {
                                                                echo '<option value="1" > Processing</option>';
                                                                if ($deliver_id != 1) {
                                                                    echo ' <option value="2" > Ready</option>';
                                                                } else {
                                                                    echo ' <option value="2" > Deliver</option>';
                                                                }
                                                                echo '<option value="3"> Receipt</option>';
                                                            }
                                                            ?>
                                                        </select>	
                                                    </td>
                                                    <td class="customFont"><?php echo $mobile_type; ?></td>
                                                    <td class="customFont"><?php echo $net_price; ?></td>
                                                    <td class="customFont"><?php echo $date; ?></td>

                                                    <td class="actions">
                                                        <a href="javascript:;" data-id="<?php echo $order_id; ?>" class="deletemsg" id="deleteParent"><i class="fa fa-trash-o"></i></a>

                                                    </td>			
                                                </tr>	
                                            <?php } ?>
                                            <?php if ($data_num == 0) { ?>
                                                <tr class="selectable" >
                                                    <td colspan="7" class="center uniformjs" style="text-align: center"> No Elements  </td>
                                                </tr>
                                            <?php $x++;} ?>
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
                                    <label for="delete_reason">Delete Reason  </label>
                                    <input type="text" name="delete_reason" parsley-trigger="change" required value="" class="form-control delete_reason">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
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
            function setAction() {
                var order_id = $("#order_id").val();
                var client_phone = $("#client_phone").val();
                if (order_id != '' && client_phone == '') {
                    var link = 'order_view.php?order_id=' + order_id;
                    document.location.href = link;
                } else if (client_phone != '' && order_id == '') {
                    var link = 'order_view.php?client_phone=' + client_phone;
                    document.location.href = link;
                } else if (client_phone != '' && order_id != '') {
                    var link = 'order_view.php?order_id=' + order_id + '&client_phone=' + client_phone;
                    document.location.href = link;

                } else {
                    window.location = 'order_view.php';
                }
            }
            function setNoAction() {
                window.location = 'order_view.php';
            }


            $('body').on('click', '.order_details', function () {
                var order_id = $(this).attr("data-id");
                var printbill = "https://aljazeeraroastery.com/system/en/print_receipt.php?get_order=";
                var fullpath = printbill.concat(order_id);
                window.open(fullpath);

            //     $.ajax({
            //         url: "functions/order_functions.php",
            //         type: "POST",
            //         data: {get_order: order_id},
            //         success: function (data)
            //         {

            //             $("#show_details").empty().append(data);
            //         }
            //     });
            //   // $('#exampleModal').modal('show');
               

            });
            function count() {
                var interval = 5000;//1000=1second,3000=3seconds
                var last = $("#last").val();
                var user_type = $("#user_type").val();
                var dataString = 'last=' + last + '&user_type=' + user_type;
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
                            alert("Please enter the reason for deletion ")
                        }
                    });
                });

            });

            $(document).ready(function () {
                $('.verify').click(function () {
                    var verify = $(this).attr('lang');
                    var client_id = $(this).attr('data-id');

                    swal({
                        title: "Confirm approve?",
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
                            swal("approved ", "", "success");
                            var dataString = 'verify=' + verify + '&client_id=' + client_id;
                            $.ajax({
                                type: "POST",
                                url: "functions/order_functions.php",
                                data: dataString,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    $(".deleteData").html(data);
                                    location.reload()

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
                        title: "Cancel approve?",
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
                            swal("Cancel Approve  ", "", "success");
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
                                    $("." + cancel_verify).remove();
                                    location.reload()

                                }
                            });

                        } else {
                            swal("Cancelled ", "Cancelled  :)", "error");
                        }
                    });
                });
                $('.edit_process').change(function (event) {
                    event.preventDefault();
                    var order_id = $(this).attr('lang');
                    var client_id = $(this).attr('data-id');
                    var deliver_type = $(this).attr('data-type');
                    var edit_follow = $(this).val();
                    var dataString = 'check_approved_order_id=' + order_id;
                    $.ajax({
                        type: "POST",
                        url: "functions/order_functions.php",
                        data: dataString,
                        dataType: 'text',
                        cache: false,
                        success: function (data) {

                            if (data == 1) {
                                swal({
                                    title: "change status?",
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
                                        swal("changed", "", "success");
                                        //alert(cancel_verify);
                                        var dataString = 'edit_follow=' + edit_follow + '&order_id=' + order_id + '&client_id=' + client_id + '&deliver_type=' + deliver_type;
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
                                        swal("changed", "changed:)", "error");
                                    }
                                });
                            } else {
                                swal("Sorry,  order must be approved first", "order must be approved first:)", "error");
                            }



                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item6").addClass("active");
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
                        swal("changed ", "changed  :)", "error");
                    }
                });
            });
            $('body').on('change', '.change_setting_status_on', function () {
                var change_setting_status_on = $(this).attr('data-id');
                swal({
                    title: "change status?",
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
                        swal("changed ", "changed  :)", "error");
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