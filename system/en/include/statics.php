
<?php
$clients = $con->query("SELECT * FROM `clients` ");
$clients_num = mysqli_num_rows($clients);

$orders = $con->query("SELECT * FROM `orders`");
$orders_num = mysqli_num_rows($orders);

$regions = $con->query("SELECT * FROM `regions`");
$regions_num = mysqli_num_rows($regions);

$staff = $con->query("SELECT * FROM `staff`");
$staff_num = mysqli_num_rows($staff);

$orders_accepted = $con->query("SELECT * FROM `orders` where `order_status`=1");
$orders_accepted_num = mysqli_num_rows($orders_accepted);

$orders_cancelled = $con->query("SELECT * FROM `orders` where `order_status`=2");
$orders_cancelled_num = mysqli_num_rows($orders_cancelled);

$complaints = $con->query("SELECT * FROM `complaints`");
$complaints_num = mysqli_num_rows($complaints);

$parent_cat = $con->query("SELECT * FROM `parent_categories`");
$parent_cat_num = mysqli_num_rows($parent_cat);

$sub_cat = $con->query("SELECT * FROM `sub_categories` ORDER BY `sub_category_id` ASC");
$sub_cat_count = mysqli_num_rows($sub_cat);

$sub_category_comments = $con->query("SELECT * FROM `sub_category_comments` ");
$sub_category_comments_count = mysqli_num_rows($sub_category_comments);

//revenue
$date = date("Y-m-d");
$revenue = $con->query("SELECT COUNT(*) FROM orders WHERE `order_status`='1' and `date` >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)
");
$revenue_by_day = mysqli_num_rows($revenue);


$revenue_week = $con->query("SELECT * FROM orders WHERE `order_status`='1' and `date` > DATE_SUB(NOW(), INTERVAL 1 WEEK)");
$revenue_by_week = mysqli_num_rows($revenue_week);

$revenue_month = $con->query("SELECT * FROM orders WHERE `order_status`='1' and `date` > DATE_SUB(NOW(), INTERVAL 1 MONTH)");
$revenue_by_month = mysqli_num_rows($revenue_month);

$revenue_year = $con->query("SELECT * FROM orders WHERE `order_status`='1' and `date` > DATE_SUB(NOW(), INTERVAL 1 YEAR)");
$revenue_by_year = mysqli_num_rows($revenue_year);
?>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box fadeInDown animated">
            <div class="bg-icon bg-icon-info pull-left">
                <i class="md md-attach-money text-info"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $clients_num; ?></b></h3>
                <p class="text-muted">Number Of Clients</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-pink pull-left">
                <i class="md md-add-shopping-cart text-pink"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $orders_num; ?></b></h3>
                <p class="text-muted">Total Number Of Orders</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-pink pull-left">
                <i class="md md-add-shopping-cart text-pink"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $orders_accepted_num; ?></b></h3>
                <p class="text-muted">Total Number Of Orders Approved</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-pink pull-left">
                <i class="md md-add-shopping-cart text-pink"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $orders_cancelled_num; ?></b></h3>
                <p class="text-muted">Total Number of Orders Refused</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-remove-red-eye text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $parent_cat_num; ?></b></h3>
                <p class="text-muted">Number Of Main Categories</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-remove-red-eye text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $sub_cat_count; ?></b></h3>
                <p class="text-muted">Number of Sub Categories</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-remove-red-eye text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $sub_category_comments_count; ?></b></h3>
                <p class="text-muted">Number Of Comments</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-remove-red-eye text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $regions_num; ?></b></h3>
                <p class="text-muted">Number Of Regions</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-remove-red-eye text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter"><?php echo $staff_num; ?></b></h3>
                <p class="text-muted">Number of Employees</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- end row -->



