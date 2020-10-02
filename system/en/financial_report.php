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
                                <h4 class="page-title"> Financial Report  </h4>
                                <ol class="breadcrumb">
                                    <li><a href="financial_report.php">Financial Report </a></li>
                                    <li class="active">Financial Report  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Search </b></h4>
                                    <p class="text-muted font-13 m-b-30"></p>  
                                    <form method="post" action="print.php" enctype="multipart/form-data" target="_blank" data-parsley-validate>

                                        <div class="col-md-6">
                                            <label > Date</label>
                                            <div class="input-group  date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd" >
                                                <input type="text" class="form-control input-sm" readonly="" name="from" id="date_report_from">
                                                <span class="input-group-addon"> To </span>
                                                <input type="text" class="form-control input-sm" readonly="" name="to" id="date_report_to"> 
                                            </div>
                                        </div>
                                        <div class='clearfix'></div>
                                        <br>
                                        <div class="form-group col-md-3">
                                            <label for="select_payment_type">  Payment</label>
                                            <select class="form-control select2me" name="select_payment_type" id="select_payment_type"  parsley-trigger="change">
                                                <option value=''>All</option>
                                                <option value='cash'>cach</option>
                                                <option value='online'>online</option>

                                            </select>					
                                        </div>
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

    </body>
</html>