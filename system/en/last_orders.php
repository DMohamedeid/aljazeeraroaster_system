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
                                <h4 class="page-title">View Previous Orders</h4>
                                <ol class="breadcrumb">
                                    <li><a href="order_view.php"> View Previous Orders</a></li>
                                    <li class="active">View Previous Orders  </li>
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
                        $order_id = $_GET['order_id'];
                        $client_phone = $_GET['client_phone'];
                        $data_num = last_orders_count($_GET); //echo $data_num; die();
                        $allData = last_orders($start, ITEMS_PER_PAGE,$_GET);  //echo '<pre>'; print_r($allData); die();
                        $url = "last_orders.php?items=" . ITEMS_PER_PAGE . (($order_id) ? "&order_id=" . $order_id : ""). (($client_phone) ? "&client_phone=" . $client_phone : "");
                        $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
                        ?>

                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-3 form-group">
                                    <label  for="order_id" class=" control-label">Search By Order Id     </label> 
                                    <input   class="form-control search-input-text" name="order_id" placeholder="Order Id " id="order_id" value="<?php echo $_GET['order_id']; ?>" type="text" >
                                </div> 
                                <div class="col-md-3 form-group">
                                    <label  for="client_phone" class=" control-label">Search By Client Phone </label> 
                                    <input   class="form-control search-input-text" name="client_phone" placeholder="Client Phone" id="client_phone" value="<?php echo $_GET['client_phone']; ?>" type="text" >
                                </div> 
                                <div class="col-md-3 form-group">
                                    <button class="btn btn-icon btn-default" type="button" style="padding:6px 16px;    margin-top: 51px;" onclick="setAction();">Search </button>
                                    <button class="btn btn-icon btn-success" type="button" style="padding:6px 16px;    margin-top: 51px;" onclick="setNoAction();">Retry </button>
                                </div>                                
                                <div class="">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Id </th>
                                                <th> Phone Number </th>
                                                <th>Order Details </th>
                                                <th>Approve / Refuse</th>
                                                <th> Delivery Way</th>     
                                                <th> Device Type</th>     
                                                <th> Net Price (BD)</th>     
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php $last_orders = last_orders($start, ITEMS_PER_PAGE,$_GET); ?> 

                                            <?php
                                            foreach ($last_orders as $key => $row) {

                                                $order_id = $row['order_id'];
                                                $client_id = $row['client_id'];
                                                $client_address_id = $row['client_address_id'];
                                                $payment = $row['payment'];
                                                $deliver_id = $row['deliver_id'];
                                                $get_charge = $row['charge_cost'];
                                                $date = $row['date'];
                                                $order_status = $row['order_status'];
                                                $client_phone = get_client_phone_by_id($client_id);
                                                $net_price = $row['net_price'];
                                                $get_region_id = get_region_by_client_address($client_id, $client_address_id);
                                                ?>
                                                <tr class="gradeX <?php echo $order_id; ?>">
                                                    <td><?php echo $key; ?></td>
                                                    <td class="customFont"><?php echo $order_id; ?></td>
                                                    <td class="customFont"><?php echo $client_phone; ?></td>

                                                    <td>
                                                        <button class="btn btn-info waves-effect waves-light btn-sm order_details" data-id="<?php echo $order_id; ?>" type="button" >Order Details </button>
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
                                                    <td> <?php
                                                        if ($order_status == 1) {
                                                            echo "Approved";
                                                        } elseif ($order_status == 0) {
                                                            echo "Not Approved ";
                                                        } elseif ($order_status == 2) {
                                                            echo "Refused";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo get_deliver_name($deliver_id); ?></td>
                                                    <td class="customFont"><?php echo get_device_type_by_client_id($client_id); ?></td>
                                                    <td class="customFont"><?php echo $net_price; ?></td>
                                                    <td class="customFont"><?php echo $date; ?></td>
                                                    <td>     
                                                        <a href="order_edit.php?order_Id=<?php echo $order_id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                    <td class="actions">
                                                        <a href="javascript:;" data-id="<?php echo $order_id; ?>" class="deletemsg" id=""><i class="fa fa-trash-o"></i></a>
                                                    </td>			
                                                </tr>
                                            <?php } ?>
                                            <?php if ($data_num == 0) { ?>
                                                <tr class="selectable" >
                                                    <td colspan="7" class="center uniformjs" style="text-align: center"> No Elements  </td>
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
                                    <label for="delete_reason">Delete Reason  </label>
                                    <input type="text" name="delete_reason" parsley-trigger="change" required value="" class="form-control delete_reason">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="submit_delete_reason" i class="btn btn-danger submit_delete_reason">Delete</button>
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
                    var link = 'last_orders.php?order_id=' + order_id;
                    document.location.href = link;
                } else if (client_phone != '' && order_id == '') {
                    var link = 'last_orders.php?client_phone=' + client_phone;
                    document.location.href = link;
                } else if (client_phone != '' && order_id != '') {
                    var link = 'last_orders.php?order_id=' + order_id + '&client_phone=' + client_phone;
                    document.location.href = link;

                } else {
                    window.location = 'last_orders.php';
                }
            }
            function setNoAction() {
                window.location = 'last_orders.php';
            }          
          
          
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

        </script>


        <script type="text/javascript">
            $(document).ready(function () {
                $('.verify').click(function () {
                    var verify = $(this).attr('lang');
                    swal({
                        title: "Confirm verification?",
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
                            swal("approved ", "", "success");
                            var dataString = 'verify=' + verify;
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
                            swal("cancelled ", "cancelled  :)", "error");
                        }
                    });
                });
                $('.cancel_verify').click(function (event) {
                    event.preventDefault();
                    var cancel_verify = $(this).attr('lang');
                    swal({
                        title: "Cancel approve?",
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
                            swal("cancelled approve", "", "success");
                            //alert(cancel_verify);
                            var dataString = 'cancel_verify=' + cancel_verify;
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
                            swal("cancelled ", "cancelled  :)", "error");
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