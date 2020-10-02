<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['reports'] != '1')) {
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
                                <h4 class="page-title">   Client Report</h4>
                                <ol class="breadcrumb">
                                    <li><a href="financial_report.php">  Client Report</a></li>
                                    <li class="active">  View  Client Report</li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Search </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>  
                                    <form method="get" action="print_client_orders.php" enctype="multipart/form-data" target="_blank" data-parsley-validate>
                                        
                                            <div class="col-md-3">
                                                <label class="control-label">  Clients</label>
                                                <select  class="form-control  select2me" name="client_id" id="client_id">
                                                    <option value=''>Choose </option>
                                                    <?php
                                                    $query = $con->query("SELECT * FROM `clients` ORDER BY `client_id` ASC");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $client_id = $row['client_id'];
                                                        $client_name = $row['client_name'];
                                                        echo " <option value = '{$client_id}'>{$client_name}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        
                                        <div class='clearfix'></div>

                                        <div class="form-group text-left" style="margin-top:60px;width:100%;clear:both;">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit" name="submit">Search</button>
                                        </div>

                                        <br /><br /><br /><br />

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

        <script type="text/javascript">
            $('.date-picker').datepicker();
            $('.select2me').select2({
                placeholder: "Select",
                width: 'auto',
                allowClear: true
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item10").addClass("active");
            });
        </script>
    </body>
</html>