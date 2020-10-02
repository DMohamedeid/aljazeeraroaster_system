<div id="cssmenu">
    <ul>
        <li id="item1" class="active"><a href="index.php"><span>Home</span></a></li>
        <?php if ($_SESSION['cat_and_sub'] == '1') { ?>

            <li id="item2" class="has-sub">
                <a href="#"><span>Parent Categories</span></a>
                <ul class="has-sub">
                    <li><a href="parent_category_add.php"><span>Add New Category  </span></a></li>
                    <li><a href="parent_category_view.php"><span>View All </span></a></li>
                </ul>
            </li>

            <li id="item3" class="has-sub">
                <a href="#"><span>Sub Categories</span></a>
                <ul class="has-sub">
                    <li><a href="sub_category_add.php"><span>Add New Sub Category  </span></a></li>
                    <li><a href="sub_category_view.php"><span>View All </span></a></li>
                </ul>
            </li>
             <li id="item202" class="has-sub">
                <a href="#"><span> Latest Items </span></a>
                <ul class="has-sub">
                    <li><a href="latest_add.php"><span>Add New Item</span></a></li>
                    <li><a href="latest_view.php"><span> View All  </span></a></li>
                </ul>
                </li>

            <li id="item67" class="has-sub">
                <a href="#"><span>Most Selling</span></a>
                <ul class="has-sub">
                    <li><a href="most_requested_add.php"><span>Add New Item </span></a></li>
                    <li><a href="most_requested_view.php"><span>   View All </span></a></li>

                </ul>
            </li>

             <li id="item5" class="has-sub">
                <a href="#"><span> Slider</span></a>
                <ul class="has-sub">
                    <li><a href="slider_add.php"><span>Add Slider  </span></a></li>
                    <li><a href="slider_view.php"><span> View All </span></a></li>
                </ul>
            </li>


        <?php } ?>

        <?php if ($_SESSION['adds_and_removes'] == '1') { ?>

            <li id="item4" class="has-sub">
                <a href="#"><span>Additions</span></a>
                <ul class="has-sub">
                    <li><a href="sub_category_customize_additions.php"><span>Add New Addition  </span></a></li>
                    <li><a href="sub_category_customize_view.php"><span>View All </span></a></li>
                </ul>
            </li>
            <li id="item41" class="has-sub">
                <a href="#"><span>Removes</span></a>
                <ul class="has-sub">
                    <li><a href="remove_add.php"><span>Add New Remove</span></a></li>
                    <li><a href="remove_view.php"><span>View All </span></a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if ($_SESSION['regions'] == '1') { ?>

            <li id="item8" class="has-sub">
                <a href="#"><span>Branches</span></a>
                <ul class="has-sub">
                    <li><a href="regions_add.php"><span>Add New Region  </span></a></li>
                    <li><a href="regions_view.php"><span>View All Regions </span></a></li>
                    <li><a href="branches_add.php"><span>Add New Branch  </span></a></li>
                    <li><a href="branches_view.php"><span>View Branches </span></a></li>
                    <li><a href="branches_regions_add.php"><span>  Customizing Branches</span></a></li>
                    <li><a href="branches_regions_view.php"><span>View Customizing Branches</span></a></li>
                </ul>
            </li>
        <?php } ?>

        <?php if ($_SESSION['dishs'] == '1') { ?>

            <li id="item59" class="has-sub">
                <a href="#"><span> New Items </span></a>
                <ul class="has-sub">
                    <li><a href="dish_of_day_add.php"><span>Add New item</span></a></li>
                    <li><a href="dish_of_day_view.php"><span>View All</span></a></li>
                </ul>
            </li>


        <?php } ?>

        <?php if ($_SESSION['orders'] == '1') { ?>

            <li id="item6" class="has-sub">
                <a href="#"><span>Orders</span></a>
                <ul class="has-sub">
                    <li><a href="order_view.php"><span>Current Orders  </span></a></li>
                    <li><a href="last_orders.php"><span>Last Orders  </span></a></li>
                </ul>
            </li>
        <?php } ?>
        <?php if ($_SESSION['clients'] == '1') { ?>
            <li id="item7" class="has-sub">
                <a href="client_view.php"><span>Clients</span></a>
            </li>
        <?php } ?>

        <?php if ($_SESSION['about'] == '1') { ?>
            <li id="item9" class="has-sub">
                <a href="about_edit.php?id=1"><span>About Us</span></a>
            </li>

            <li id="item90" class="has-sub">
                <a href="contact_edit.php"><span>Contact Us</span></a>
            </li>

        <?php } ?>
        <?php if ($_SESSION['reports'] == '1') { ?>

            <li id="item10" class="has-sub">
                <a href="#"><span>Reports</span></a>
                <ul class="has-sub">
                    <li><a href="financial_report.php"><span>Financial Report By Date</span></a></li>
                    <li><a href="client_report.php"><span>  Client Report </span></a></li>
                    <li><a href="select_financial_report.php"><span>Choose  Report Type</span></a></li>
                    <li><a href="print_deleted_report.php"><span>  Report Deleted Requests</span></a></li>
                    <li><a href="print_edited_report.php"><span>Report Edited Requests</span></a></li>
                    <li><a href="average_cost_report.php"><span>Average check report</span></a></li>
                    <li><a href="clients_most_order_report.php" target="_blank"><span> Most Requested Customers</span></a></li>
                    <li><a href="sub_cats_high_rate_report.php" target="_blank"><span>Highest Rated Sub categories   </span></a></li>
                    <li><a href="subcats_most_paid_report.php" target="_blank"><span>   Best Selling Sub categories   </span></a></li>
                    <li><a href="payment.php"><span>Payment</span></a></li>
                </ul>
            </li>
        <?php } ?>

        <?php if ($_SESSION['statics'] == '1') { ?>
            <li id="item11" class="has-sub">
                <a href="statistics.php"><span>Statistics</span></a>
            </li>
        <?php } ?>
        <?php if ($_SESSION['problems'] == '1') { ?>

            <li id="item13" class="has-sub">
                <a href="complaints_view.php"><span>Complaints</span></a>
            </li>
        <?php } ?>
        <?php if ($_SESSION['comments'] == '1') { ?>

            <li id="item101" class="has-sub"><a href="subcat_comments_view.php"><span>Comments </span></a></li>
        <?php } ?>

        <?php if ($_SESSION['messages'] == '1') { ?>

            <li id="item103" class="has-sub"
                ><a href="#"><span>Messages </span></a>
                <ul class="has-sub">
                    <li><a href="message_type_add.php"><span>Add The Message Type </span></a></li>
                    <li><a href="message_type_view.php"><span>View All Types Of Messages</span></a></li>
                    <li><a href="messages_add.php"><span>Add New Message </span></a></li>
                    <li><a href="messages_view.php"><span>View All messages</span></a></li>
                </ul>

            </li>
        <?php } ?>

        <?php if ($_SESSION['users'] == '1') { ?>

            <li id="item111" class="has-sub">
                <a href="payment_methods_view.php"><span>Payment Methods</span></a>
            </li>

            <li id="item000" class="has-sub">
                <a href="delivery_ways_view.php"><span>Delivery Ways</span></a>
            </li>

            <li id="item12" class="has-sub">
                <a href="#"><span>Users</span></a>
                <ul class="has-sub">
                    <li><a href="user_add.php"><span>Add New User</span></a></li>
                    <li><a href="users_view.php"><span>View All</span></a></li>
                </ul>
            </li>

            <li id="item112" ><a href="setting_edit.php"><span>Setting</span></a></li>

        <?php } ?>


        <li><a href="logout.php"><span>Logout </span></a></li>



    </ul>
</div>