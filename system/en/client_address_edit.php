<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['clients'] != '1')) {
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

            <?php
            if (isset($_POST['client_address_update'])) {

                $temp = $_POST;
                $sql = "UPDATE `client_addresses` SET ";
                foreach ($temp as $k => $v) {
                    $sql .= ($k == 'client_address_update' || $k == 'client_address_id') ? "" : "`{$k}`=\"{$v}\",";
                }
                $sql = substr($sql, 0, -1);
                $sql .= "WHERE client_address_id='{$temp['client_address_id']}'";
                $update = $con->query($sql);

                if ($update) {
                    echo get_success("Successfully Updated");
                    echo "<meta http-equiv='refresh' content='0'>";
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
                                <h4 class="page-title"> Addresses  </h4>
                                <ol class="breadcrumb">
                                    <li><a href="client_address_view.php">Addresses </a></li>
                                    <li class="active">Edit Address  </li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b> Edit Address </b></h4>
                                    <?php
                                    if ($_GET['client_address_Id']) {

                                        $client_address_id = $_GET['client_address_Id'];

                                        $query_select = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id` = '$client_address_id' LIMIT 1");
                                        $row_select = mysqli_fetch_array($query_select);

                                        $client_addressid = $row_select['client_id'];
                                        $client_name = clientName($client_addressid);
                                        $lat = $row_select['lat'];
                                        $lang = $row_select['lang'];
                                        $region = $row_select['region'];
                                        $block = $row_select['block'];
                                        $road = $row_select['road'];
                                        $building = $row_select['building'];
                                        $region = $row_select['region'];
                                        $flat_number = $row_select['flat_number'];
                                        $client_phone = $row_select['client_phone'];
                                        $note = $row_select['note'];


                                        if ($query_select) {
                                            ?>
                                            <form method="POST"  enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <div class="form-group">
                                                    <label class="control-label"> Client Name :</label>

                                                    <span>        <?php echo $client_name; ?>    </span>
                                                    <input name="client_id" id="client_id" type="hidden" value="<?php echo $client_addressid; ?>">
                                                    <br />
                                                    <!--<input type='hidden' name='itr' id='itr' >-->
                                                    <input type='hidden' name='client_address_id' id='client_address_id' value='<?php echo $client_address_id; ?>' >

                                                    <div class="form-group optionBox_two" style="position: relative;
                                                         ">
                                                        <label class="control-label">Address</label>
                                                        <div class="appendblock">
                                                            <div class="block_two">
                                                                <div>
                                                                    <label>Lat</label>
                                                                    <input  name="lat" id="lat" type="text" parsley-trigger="change" required placeholder="lat" class="form-control thisField" value="<?php echo $lat; ?>">
                                                                    <label>Log</label>

                                                                    <input  name="lang" id="lang" type="text" parsley-trigger="change" required placeholder="Long" class="form-control thisField"  value="<?php echo $lang; ?>">
                                                                    <label>Eegion</label>
                                                                    <select  class="form-control" name="region" id="region" required>
                                                                        <option value="">Choose</option>                                                           
                                                                        <?php
                                                                        $query = $con->query("SELECT * FROM `regions` ORDER BY `region_id` ASC");
                                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                                            $region_id = $row['region_id'];
                                                                            $region_name_ar = $row['region_name_ar'];
                                                                            if ($region == $region_id) {
                                                                                echo "<option value='{$region_id}' selected>{$region_name_ar}</option>";
                                                                            } else {
                                                                                echo "<option value='{$region_id}'>{$region_name_ar}</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>	
                                                                    
                                                                    <label>Block</label>

                                                                    <input  name="block" id="block" type="text" parsley-trigger="change" required placeholder="Block" class="form-control thisField"  value="<?php echo $block; ?>">
                                                                </div>										
                                                                <div >
                                                                    <label>Road</label>
                                                                    <input  name="road" id="road" type="text" parsley-trigger="change" required placeholder="Road" class="form-control thisField"  value="<?php echo $road; ?>">
                                                                    <label>Building</label>

                                                                    <input  name="building" id="building" type="text" parsley-trigger="change" required placeholder="Building" class="form-control thisField"  value="<?php echo $building; ?>">
                                                                    <label>Flat Number </label>
                                                                    <input  name="flat_number" id="flat_number" type="text" parsley-trigger="change" required placeholder="Flat " class="form-control thisField"  value="<?php echo $flat_number; ?>">
                                                                    <label>Phone </label>

                                                                    <input  name="client_phone" id="phone" type="text" parsley-trigger="change" required placeholder="phone " class="form-control thisField"  value="<?php echo $client_phone; ?>">
                                                                </div>										
                                                                <label>Notes</label>

                                                                <input  name="note" type="text" parsley-trigger="change" required placeholder="notes" class="form-control thisField" value="<?php echo $note; ?>">
                                                            </div>										

                                                            <!--<button class="btn add-remove remove-me remove_two" type="button">-</button>-->
                                                            <!--                                                        <div class="block_two">
                                                                                                                                <span class="btn add-more add_two">+</span>
                                                                                                                            </div>											-->
                                                        </div>
                                                    </div>
                                                    <br />

                                                    <div class="form-group text-right m-b-0">
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="client_address_update"> Update </button>
                                                        <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancel </button>
                                                    </div>
                                            </form>
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

                <?php
            }
        }
        ?>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item7").addClass("active");
            });
        </script>

    </body>
</html>