<div class="content-page">
    <div class="content">
        <div class="container">

            <h3 style="display:block;text-align:center;margin-top: 15px;border-bottom: 1px solid #000;width: 40%;margin-right: auto;padding: 20px 0;margin-left: auto;margin-bottom: 60px;">
                Welcome to Aljazeera Roastery

            </h3>

            <div class="row pricing-plan">
                <div class="col-md-12">
                    <div class="row">

                        <?php if ($_SESSION['cat_and_sub'] == '1') { ?>
                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-folder"></i> Parent categories</span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="parent_category_view.php"><span>View All </span></a></li>
                                        <li><a href="parent_category_add.php"><span>Add New Category</span></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-file"></i> Sub Categories </span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="sub_category_add.php"><span>Add New Sub Category  </span></a></li>
                                        <li><a href="sub_category_view.php"><span>View All </span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>



                        <?php if ($_SESSION['orders'] == '1') { ?>

                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-cart-arrow-down"></i> Orders</span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="order_add.php"><span>Add New Order  </span></a></li>
                                        <li><a href="order_view.php"><span>Current Orders  </span></a></li>
                                        <li><a href="last_orders.php"><span>Last Orders  </span></a></li>
                                        <li><a href="payment.php"><span>Payment</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['clients'] == '1') { ?>
                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-users"></i> Clients</span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="client_view.php"><span>View All</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['about'] == '1') { ?>
                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-info"></i> About restaurant </span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="about_edit.php?id=1"><span>About restaurant
                                                </span></a></li>
                                        <li><a href="contact_edit.php"><span>Call Us</span></a></li>
                                        <li><a href="setting_edit.php"><span>Setting</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['users'] == '1') { ?>

                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-user"></i> Users</span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="user_add.php"><span>Add New User</span></a></li>
                                        <li><a href="users_view.php"><span>View All</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['reports'] == '1') { ?>

                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-file"></i> Reports</span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="financial_report.php"><span>Financial Report By Date</span></a></li>

                                        <li><a href="select_financial_report.php"><span>Choose  Report Type</span></a></li>
                                        <li><a href="print_deleted_report.php"><span>  Report Deleted Requests</span></a></li>
                                        <li><a href="print_edited_report.php"><span>Report Edited Requests
                                                </span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($_SESSION['statics'] == '1') { ?>

                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="price_card text-center">
                                    <div class="pricing-header bg-success" style="background-color:#967041 !important;">
                                        <span class="name"> <i class="fa fa-dollar"></i> Statistics</span>
                                    </div>
                                    <ul class="price-features">
                                        <li><a href="statistics.php">View Statistics </a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include("include/footer_text.php"); ?>
</div>
