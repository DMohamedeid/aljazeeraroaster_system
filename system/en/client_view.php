<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['clients'] != '1')) {
    header("Location: error.php");
    exit();
}

// $page = $start = 0;

// if(isset($_POST['prev']) && $_POST['ajax'] == 1){
    
//     $page = $_POST['prev'] - 1;
//     $start = ($page - 1) * ITEMS_PER_PAGE;
    
//     // view_client($start);
    
//     echo json_encode(['page' => $page]);
//     exit();
// }

?>
<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <!--<link href="assets/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />-->
    <!--<link href="assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />-->

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
                                <h4 class="page-title">Clients View </h4>
                                <ol class="breadcrumb">
                                    <li><a href="client_view.php">Clients</a></li>
                                    <li class="active">Clients </li>
                                </ol>
                            </div>
                        </div>

                        <div class="panel">
                            
                            <div class="panel-body">
                                <form id="formSearch">
                                    <div class="form-group col-md-3">
                                        <select class="form-control" id="search">
                                            <?php 
                                                
                                                $selected1 = $selected2 = $selected3 = $selected4 = $selected = '';
                                                $search = $_GET['search']; 
                                                if($search == 1){
                                                    $selected1 = 'selected';
                                                } elseif($search == 2){
                                                    $selected2 = 'selected';
                                                } elseif($search == 3){
                                                    $selected3 = 'selected';
                                                } elseif($search == 4){
                                                    $selected4 = 'selected';
                                                } else {
                                                    $selected = 'selected';
                                                } 
                                            
                                            ?>
                                            <option value='0' 
                                            
                                                <?php  echo $selected;    ?>
                                            
                                            > Search With</option>
                                            <option value='1'
                                                
                                                <?php  echo $selected1;    ?>
                                                
                                            >Most Ordering</option>
                                            <option value='2'
                                            
                                                <?php  echo $selected2;    ?>
                                            
                                            >Most Commenting</option>
                                            <option value='3'
                                            
                                                <?php  echo $selected3;    ?>
                                            
                                            >Most Fav</option>
                                            <option value='4'
                                            
                                                <?php  echo $selected4;    ?>
                                            
                                            >Most Addresses</option>
                                        </select>
    
                                    </div>
                                    <div class="form-group col-md-1">
                                        <input type="submit" value="Search" class="btn btn-primary">
                                    </div>
                                </form>
                                <div class="">
                                    <?php
                                    
                                    // $items = (int) $_GET['items'];
                                    // $items = $items ? $items : 20;
                                    // $query_items = '';
                                    // if ((INT) $_GET['items'] > 0) {
                                    //     $query_items = '&items=' . (INT) $_GET['items'];
                                    // }

                                    // define(ITEMS_PER_PAGE, 20);

                                    // $page = (int) $_GET['page'];
                                    // $page = ($page < 1) ? 1 : $page;
                                    // $start = ($page - 1) * 20;
                                    $data_num = client_count();
                                    $total = ceil($data_num / 20);
                                    // $url = "client_view.php?items=" . ITEMS_PER_PAGE;

                                    // $navigation = navigationHomee($data_num, $start, $url, ITEMS_PER_PAGE);
                                
                                    ?>
                                    <input type='hidden' value='<?php echo $total;  ?>' id='paginate'>
                                    
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="text-align:center;"> Orders Count</th>

                                                <th style="text-align:center;">Client Name </th>
                                                <th style="text-align:center;">Phone </th>
                                                <th style="text-align:center;">Favourite Subcategory </th>
                                                <th style="text-align:center;">Comments </th>
                                                <th style="text-align:center;"> Client Addresses </th>
                                                <th style="text-align:center;">Status </th>
                                                <th style="text-align:center;">Date Added </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php 

                                        
                                        $search = 0;
                                        $page = (int) $_GET['page'];
                                        
                                        $page = ($page < 1) ? 1 : $page;
                                        $start = ($page - 1) * 20;
                                    
                                        
                                        if(isset($_GET['search'])){
                                            $search = $_GET['search'];
                                            $view_client = view_clients_by_search($search, $start);
                                        } else {
                                            $view_client = view_client($start);
                                        }
                                           
                                            $x = $start;
                                            foreach ($view_client as $key => $row) {
                                                $client_id = $row['client_id'];
                                                $client_first_name = $row['client_name'];
                                                $client_email = $row['client_email'];
                                                $client_phone = $row['client_phone'];
                                                $client_verify = $row['client_verify'];

                                                $date = $row['date'];
                                                ?>
                                                <tr class="gradeX <?php echo $client_id; ?>">
                                                    <td style="text-align:center;"><?php echo $x; ?></td>
                                                    <td><a href="client_orders.php?client_id=<?php echo $client_id;?>"><?php echo count_orders($client_id); ?></a></td>
                                                    
                                                    <td style="text-align:center;"><?php echo $client_first_name; ?></td>
                                                    <td style="text-align:center;"><?php echo $client_phone; ?></td>

                                                    <td style="text-align:center;">  
                                                        <?php
                                                        $count_client_fav_sub = count_client_fav_sub($client_id);
                                                        if ($count_client_fav_sub > 0) {
                                                            ?>
                                                            <a href="client_fav_sub_view.php?client_id=<?php echo $client_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
                                                            <?php
                                                        } else {
                                                            echo "no favorites  ";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align:center;">  
                                                        <?php
                                                        $sub_cat_client_comments_count = sub_cat_client_comments_count($client_id);
                                                        if ($sub_cat_client_comments_count > 0) {
                                                            ?>
                                                            <a href="subcat_comments_view.php?client_id=<?php echo $client_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
                                                            <?php
                                                        } else {
                                                            echo "no comments";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td style="text-align:center;">  
                                                        <?php
                                                        $count_client_address = count_client_address($client_id);
                                                        if ($count_client_address > 0) {
                                                            ?>
                                                            <a href="client_address_view.php?client_id=<?php echo $client_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
                                                            <?php
                                                        } else {
                                                            echo "no addresses";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align:center;" class="mousta">
                                                        <?php
                                                        if ($client_verify == 0) {
                                                            echo '<div class="verifyMeTwo"><a> not verify</a><br /><br /><a  lang="' . $client_id . '" class="btn btn-info waves-effect waves-light btn-sm verify">verify</a></div>';
                                                        } else {
                                                            echo '<div class="cancelVerifyMeTwo"><a>verified</a><br /><br /><a lang="' . $client_id . '" class="btn btn-info waves-effect waves-light btn-sm cancel_verify">cancell verify </a></div>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align:center;"><?php echo $date; ?></td>

                                                    <td>     
                                                        <a href="client_edit.php?clientId=<?php echo $client_id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                                                    </td>
                                                    <!--<td class="actions">-->
                                                    <!--    <a data-id="<?php echo $client_id ?>" class="deletemsg" id="deleteParent"><i class="fa fa-trash-o"></i></a>-->
                                                    <!--</td>-->
                                                </tr>		
                                            <?php $x++; } ?>
                                            <?php if ($data_num == 0) { ?>
                                                <tr class="selectable" >
                                                    <td colspan="7" class="center uniformjs" style="text-align: center"> لا يوجد عناصر</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div >
                                        <div class='pagination'>
                                            <a href="" id='prev'>&laquo;</a>
                                            <a class="active" id='navigate'>
                                                
                                                <?php
                                                
                                                
                                                    if(isset($_GET['page'])){
                                                        echo intval($_GET['page']);
                                                    } else {
                                                        echo 1;
                                                    }
                                                
                                                
                                                ?>
                                                
                                            </a>
                                            <a href="" id='next'>&raquo;</a>
                                        </div>
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
        <style>
            .pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
        </style>
        <?php include("include/footer.php"); ?>
        <script src="assets/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"></script>

        <script type="text/javascript">
            $('body').on('click', '.deletemsg', function () {
                var client = $(this).attr('data-id');
                var dataString = 'client=' + client;
                var urlgo = $(this).attr('data-link');
                bootbox.dialog({
                    message: "Delete this item?",
                    title: "Message Confirm deletion",
                    buttons: {
                        danger: {
                            label: "cancell",
                            className: "btn-danger"
                        },
                        main: {
                            label: "delete",
                            className: "btn-primary",
                            callback: function () {
                                //do something else
                                $.ajax({
                                    type: "POST",
                                    url: "functions/client_functions.php",
                                    data: dataString,
                                    dataType: 'text',
                                    cache: false,
                                    success: function (data) {
                                        $(".deleteData").html(data);
                                        $("." + client).remove();

                                        //alert(category);
                                    }
                                });
                            }
                        }
                    }
                });
            });
            $('body').on('click', '.verify', function () {
                var verify = $(this).attr('lang');
                var dataString = 'verify=' + verify;
                swal({
                    title: "confirm verify?",
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
                        swal("verified ", "", "success");
                        var dataString = 'verify=' + verify;
                        $.ajax({
                            type: "POST",
                            url: "functions/client_functions.php",
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
        </script>


        <script type="text/javascript">


            $('body').on('click', '.cancel_verify', function () {

                event.preventDefault();
                var cancel_verify = $(this).attr('lang');
                swal({
                    title: " cancell verify?",
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
                        swal("cancell verify  ", "", "success");
                        //alert(cancel_verify);
                        var dataString = 'cancel_verify=' + cancel_verify;
                        $.ajax({
                            type: "POST",
                            url: "functions/client_functions.php",
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
            });</script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item7").addClass("active");
                
                $('#formSearch').submit(function(e){
                    
                    let search = $('#search').val();
                    let url = window.location.href;

                    if(search == 0){
                        
                        if (uri.indexOf("search") > 0) {
                            
                            let clean_uri = url.substring(0, uri.indexOf("search"));

                        }
                        
                    } else {
                        
                        url = new URL(url);
                        url.searchParams.set("search", search);
                        
                    } 
                    
                    document.location = url;
                    
                    e.preventDefault();
                })
                
                $('#prev').click(function(e){
   
                    let page = parseInt($('#navigate').html());
                    
                    if(page >= 2){
                          
                        let url = window.location.href;

                        url = new URL(url);
   
                        url.searchParams.set("page", page - 1);

                        location.href = url.href;

                        
                    }
                    
                    e.preventDefault();
                
                })
                
                $('#next').click(function(e){
                    let page = parseInt($('#navigate').html());
                    let pagesNum = $('#paginate').val();

                    if(page <= pagesNum){
                        
                        let url = window.location.href;

                        url = new URL(url);
   
                        url.searchParams.set("page", page + 1);

                        location.href = url.href;  
                        
                    }
                    
                    e.preventDefault();
                    
                })
                
                
                // let searchParams = new URLSearchParams(window.location.search);

                //     if(searchParams.has('page')){   
                    
                //         let page = searchParams.get('page');
                        
                //         if(page >= 2){
                //             let url = `client_view.php`;
                //             page = page - 1;
                //             url = `client_view.php?page=${page}`;
                //             document.location = url;
                //         }
                        
                //     }
                
            });
            
            
            
        </script>		

    </body>
</html>