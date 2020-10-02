<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['about'] != '1')) {
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
// error_reporting(0);

            if (isset($_POST['setting_update'])) {

                $id = $_POST['id'];

                $accept_orders = $_POST['accept_orders'];
                $branch_id = $_POST['branch_id'];
                $discount = $_POST['discount'];
                $vat_percentage = $_POST['vat_percentage'];
                $android_version = $_POST['android_version'];
                $ios_version = $_POST['ios_version'];
                $ios_link=$_POST['ios_link'];
                $android_link=$_POST['android_link'];
                $main_color=$_POST['main_color'];
                $footer_caption=$_POST['footer_caption'];
                $footer_caption_en=$_POST['footer_caption_en'];

                $hover_color=$_POST['hover_color'];

                
                if ($discount == 1) {
                    $discount_percentage = $_POST['discount_percentage'];
                } else {
                    $discount_percentage = '';
                }

                $update = $con->query("UPDATE `setting` SET `footer_caption_en`='$footer_caption_en',`footer_caption`='$footer_caption', `main_color`='$main_color',`hover_color`='$hover_color', `android_version`='$android_version', `ios_version`='$ios_version',`ios_link`='$ios_link',`android_link`='$android_link', `vat`='$vat_percentage', `branch_id`='$branch_id',`discount_percentage`='$discount_percentage',`discount`='$discount',`accept_orders`='$accept_orders' WHERE `id`='$id'");
                if ($update) {
                    echo get_success("Successfully Updated");
                } else {
                    echo get_error("Here's a error!");
                }
            }
            ?>


            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Setting</h4>
                                <ol class="breadcrumb">
                                    <!--<li><a href="user_add.php">المديرين</a></li>-->
                                    <!--<li class="active">تعديل مدير</li>-->
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>

                        <?php
                        $query_select = $con->query("SELECT * FROM `setting` order by id desc");

                        $row_select = mysqli_fetch_array($query_select);

                        $id = $row_select['id'];
                        $accept_orders = $row_select['accept_orders'];
                        $discount = $row_select['discount'];
                        $discount_percentage = $row_select['discount_percentage'];
                        $get_branch_id = $row_select['branch_id'];
                        $close_charge = $row_select['close_charge'];
                        $vat_percentage = $row_select['vat'];
                        $footer_caption=$row_select['footer_caption'];
                       $footer_caption_en=$row_select['footer_caption_en'];

                        $android_version= $row_select['android_version'];  
                        
                        $ios_version= $row_select['ios_version'];    
                        
                        $ios_link=$row_select['ios_link'];
                       $android_link=$row_select['android_link'];
                       $main_color=$row_select['main_color'];
                       $hover_color=$row_select['hover_color'];

                        if ($query_select) {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-box"> 									
                                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                            <input type="hidden" name="id" id="id" parsley-trigger="change" required value="<?php echo $id; ?>" class="form-control">
                                        <div class="form-group">
                                                <label class="control-label">  Free Charge </label>
                                                <?php if ($close_charge == 1) { ?>
                                                    <input class="change_setting_status_off" data-id="<?php echo $id; ?>" type="checkbox" 
                                                           checked
                                                           data-plugin="switchery" data-color="#81c868"/>
                                                       <?php } else if ($close_charge == 0) {
                                                           ?>
                                                    <input class="change_setting_status_on" data-id="<?php echo $id; ?>" type="checkbox" 

                                                           data-plugin="switchery" data-color="#81c868"/>
                                                       <?php }
                                                       ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">  Accept Orders</label>
                                                <select class="form-control" name="accept_orders" required parsley-trigger="change">

                                                    <option value="">Choose</option>
                                                    <option value="1" <?php
                                                    if ($accept_orders == '1') {
                                                        echo 'selected';
                                                    }
                                                    ?>>yes</option>
                                                    <option value="0"  <?php
                                                    if ($accept_orders == '0') {
                                                        echo 'selected';
                                                    }
                                                    ?>>no</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>VAT</label>
                                                <input type="number" min="0" value="<?php echo $vat_percentage; ?>" step="1" name="vat_percentage" parsley-trigger="change"  placeholder="VAT" class="form-control">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label> footer english caption </label>
                                                <input type="text" value="<?php echo $footer_caption_en; ?>" name="footer_caption_en" parsley-trigger="change"  placeholder="footer caption" class="form-control">
                                            </div> 
                                            
                                          <div class="form-group">
                                                <label> footer arabic caption </label>
                                                <input type="text" value="<?php echo $footer_caption; ?>" name="footer_caption" parsley-trigger="change"  placeholder="footer caption" class="form-control">
                                            </div>                                             
                                            
                                            <div class="form-group">
                                                <label>Android Version</label>
                                                <input type="number" min="0" value="<?php echo $android_version; ?>" step="0.1" name="android_version" parsley-trigger="change"  placeholder="Android Version" class="form-control">
                                            </div> 
                                            
                                                                                       
                                            <div class="form-group">
                                                <label>IOS Version</label>
                                                <input type="number" min="0" value="<?php echo $ios_version; ?>" step="0.1" name="ios_version" parsley-trigger="change"  placeholder="IOS Version" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label> Apple Store Link   </label>
                                                <input type="text" value="<?php echo $ios_link; ?>"  name="ios_link" parsley-trigger="change"  placeholder="IOS Link" class="form-control">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label> Play Store Link   </label>
                                                <input type="text"  value="<?php echo $android_link; ?>" name="android_link" parsley-trigger="change"  placeholder="Android Link" class="form-control">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label> Main Color Code     </label>
                                                <input type="text"  value="<?php echo $main_color; ?>" name="main_color" parsley-trigger="change"  placeholder="Main Color" class="form-control">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label> Second Color Code      </label>
                                                <input type="text"  value="<?php echo $hover_color; ?>" name="hover_color" parsley-trigger="change"  placeholder="Hover Color" class="form-control">
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="control-label">  Discount</label>
                                                <select class="form-control" name="discount" id="discount"  parsley-trigger="change">
                                                    <option value="">choose</option>

                                                    <option value="1" <?php
                                                    if ($discount == '1') {
                                                        echo 'selected';
                                                    }
                                                    ?>>yes</option>
                                                    <option value="0"  <?php
                                                    if ($discount == '0') {
                                                        echo 'selected';
                                                    }
                                                    ?>>no</option>
                                                </select>
                                            </div>
                                            <div class="block_two">
                                                <label class="control-label">  Main Branch </label>
                                                <select class="form-control branch_id select2me" name="branch_id" id="branch_id">
                                                    <option value=''>Choose Branch</option>
                                                    <?php
                                                    $query = $con->query("SELECT * FROM `branches` ORDER BY `id` ASC");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $branch_id = $row['id'];
                                                        $name = $row['name'];
                                                        if ($get_branch_id == $branch_id) {
                                                            echo " <option value = '{$branch_id}' selected>{$name}</option>";
                                                        } else {
                                                            echo " <option value = '{$branch_id}'>{$name}</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group" id="discount_percentage_div" <?php if ($discount != 1) { ?> style="display: none;" <?php } ?>>
                                                <label for="discount_percentage">  Discount Percentage</label>
                                                <input type="number" min="0" value="<?php echo $discount_percentage; ?>" step="1" name="discount_percentage" parsley-trigger="change"  placeholder="discount percentage " class="form-control" id="discount_percentage">
                                            </div>


                                    </div>
                                    <br>
                                    <div class="form-group text-right m-b-0">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="setting_update" id="updateSetting">Update</button>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

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
        $("#discount").change(function () {
            var discount = $(this).val();
            if (discount == 1) {
                $("#discount_percentage_div").show();
            } else {
                $('#discount_percentage_div').css('display', 'none');
            }
        });
    </script>
    <script>
                $('body').on('change', '.change_setting_status_off', function () {
                var change_setting_status_off = $(this).attr('data-id');
                swal({
                    title: "Confirm hidden?",
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
                        location.reload()
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
                        location.reload()
                    } else {
                        swal("changed ", "changed  :)", "error");
                    }
                });
            });

        $('.select2me').select2({
            placeholder: "Select",
            width: 'auto',
            allowClear: true
        });
        $(document).ready(function () {
            $("#cssmenu ul>li").removeClass("active");
            $("#item112").addClass("active");
        });
    </script>	

</body>
</html>