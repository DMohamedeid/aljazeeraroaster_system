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
<!DOCtype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Emcan">
        <link rel="shortcut icon" href="assets/images/favicon_1.ico">
        <title> Report</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="assets/js/modernizr.min.js"></script>
    </head>
    <style>
        body{
            background-color:#FFFFFF;
            direction:rtl;
            text-align:right;
            height:100vh;
        }
        .content-page > .content {
            padding: 30px !important;
            margin:0 !important;
        }
        .rightCon {
            display: block;
            float: right;
        }
        .rightCon > h3 {
            display: block;
            font-family: tahoma;
            font-size: 15px;
            font-weight: bold;
            line-height: 16px;
            text-align: right;
        }
        .leftCon {
            display: block;
            text-align: left;
            direction:ltr;
        }
        .leftCon > h3 {
            display: block;
            font-family: tahoma;
            font-size: 15px;
            font-weight: bold;
            line-height: 16px;
            text-align: left;
        }
        h1 {
            color: red;
            display: block;
            font-family: tahoma;
            font-size: 25px;
            font-weight: bold;
            line-height: 46px;
            margin: 30px 0;
            text-align: center;
        }
        h2 {
            font-family: tahoma;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            margin-top: -30px;
            text-align: center;
        }
        table {
            width: 100%;
            text-align:right;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align:right;
        }
        th, td {
            border-right: medium none;
            padding: 10px 5px;
            text-align: right;
        }
        button {
            display: block;
            font-size: 20px;
            height: 70px;
            margin: auto;
            text-align: center;
            width: 150px;
            position:absolute;
            bottom:0;
            left:50%;
        }
    </style>
</head>
<body>
    <div class="content-page" style="margin-right:15px;">
        <!-- Start content -->
        <div class="content">



            <?php
            if ((isset($_GET['report']) && $_GET['report'] == "daily")) {
                $report = $_GET['report'];
                ?>
                <h1>daily report </h1>
                <h3 style="text-align:center;font-size:15px;">   بتاريخ
                    <?php echo date("Y-m-d"); ?>
                </h3>
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> Order Id  </th>
                            <th> Client Name </th>
                            <th> Phone </th>
                            <th> Charge Cost </th>
                            <th> Discount Percentage  </th>
                            <th> Sum </th>
                            <th> Payment Way </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $x = 1;
                        global $con;
                        $showRecordPerPage = 10;
                        if (isset($_GET['page']) && !empty($_GET['page'])) {
                            $currentPage = $_GET['page'];
                        } else {
                            $currentPage = 1;
                        }
                        $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;

                        $query = $con->query("SELECT * FROM `orders` where  date(date) = '" . date("Y-m-d") . "' and `order_status`=1 and  `order_follow`=3");
                        $orders_count = mysqli_num_rows($query);
                        $lastPage = ceil($orders_count / $showRecordPerPage);
                        $firstPage = 1;
                        $nextPage = $currentPage + 1;
                        $previousPage = $currentPage - 1;
                        $orderSQL = "SELECT *
FROM `orders` where date(date) = '" . date("Y-m-d") . "' and `order_status`=1 and  `order_follow`=3 LIMIT $startFrom, $showRecordPerPage";
                        $orderResult = $con->query($orderSQL);

                        while ($row = mysqli_fetch_assoc($orderResult)) {
                            $order_id = $row['order_id'];
                            $payment = $row['payment'];
                            $client_id = $row['client_id'];
                            $client_address_id = $row['client_address_id'];
                            $date = $row['date'];
                            $get_region_id = get_region_by_client_address($client_id, $client_address_id);
                            $discount_percentage = $row['discount_percentage'];
                            $net_price = $row['net_price'];
                            $getCharge = $row['charge_cost'];
                            $order_price = totalPrice($order_id);
                            ?>
                            <tr class="gradeX <?php echo $order_id; ?>">
                                <td><?php echo $x; ?></td>
                                <td><?php echo $order_id; ?></td>
                                <td><?php echo get_client_name_by_id($client_id); ?></td>
                                <td class="customFont"><?php echo get_client_phone_by_id($client_id); ?></td>
                                <td style="text-align:center;"> <?php echo $getCharge; ?> د.ب </td>
                                <td style="text-align:center;"> <?php echo $discount_percentage; ?> %</td>
                                <td style="text-align:center;"> <?php echo $net_price; ?> د.ب </td>

                                <td class="customFont"><?php echo $payment; ?></td>
                                <td class="customFont"><?php echo $date; ?></td>

                            </tr>
                        <?php } ?>
                        <?php if ($orders_count == 0) { ?>
                            <tr class="selectable" >
                                <td colspan="8" class="center uniformjs" style="text-align: center"> لا يوجد عناصر</td>
                            </tr>
                            <?php
                            $x++;
                        }
                        ?>
                    </tbody>

                </table>	

                <?php if ($orders_count > 0) { ?>

                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($currentPage != $firstPage) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($currentPage >= 2) { ?>
                                <li class="page-item"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
                            <?php } ?>
                            <li class="page-item active"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
                            <?php if ($currentPage != $lastPage) { ?>
                                <li class="page-item"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
                                <li class="page-item">
                                    <a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $lastPage ?>" aria-label="Next">
                                        <span aria-hidden="true">Last</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                <?php } ?>
                <h1>The total report today</h1>

                <table>
                    <tr>
                        <th> Number Of Clients </th>
                        <th> Number Of Orders </th>
                        <th> Total Cost Of Orders</th>
                        <th> Total Cost Of Charge
                        </th>
                    </tr>
                    <?php
                    $x = 1;
                    global $con;
                    $sql = "SELECT count(order_id) as order_count  FROM `orders` WHERE date(date) = '" . date("Y-m-d") . "' and `order_status`=1 and `order_follow`=3 ";

                    $querya = $con->query($sql);
                    $order_count = mysqli_fetch_row($querya);
//                    echo $order_count[0];
//عدد العملاء
                    $sqlc = "SELECT DISTINCT client_id  FROM `orders` WHERE date(date) = '" . date("Y-m-d") . "' and `order_status`=1 and `order_follow`=3 ";

                    $queryc = $con->query($sqlc);
                    $client_count = mysqli_num_rows($queryc);

                    //اجمالي التكلفة

                    $sqlx = "SELECT *  FROM `orders` WHERE date(date) = '" . date("Y-m-d") . "' and `order_status`=1 and `order_follow`=3 ";

                    $queryx = $con->query($sqlx);
                    $price = 0;
                    $charge = 0;
                    $discount = 0;
                    while ($row_select = mysqli_fetch_assoc($queryx)) {

                        $client_id = $row_select['client_id'];
                        $discount_percentage = $row_select['discount_percentage'];
                        $net_price = $row_select['net_price'];
                        $getCharge = $row_select['charge_cost'];

                        $charge +=$getCharge;
                        $price+=$net_price;
                        $discount+= $discount_percentage;
                    }
//                    echo 'price=' . $price;
                    $financial_report[] = array("client_count" => $client_count, "charge" => $charge, "discount" => $discount, "order_count" => $order_count[0], "price" => $price);
                    foreach ($financial_report as $value) {
                        ?>				  
                        <tr>
                            <td><?php echo $value["client_count"]; ?></td>						
                            <td><?php echo $value["order_count"]; ?></td>						
                            <td><?php echo $value["price"]; ?> د.ب </td>						
                            <td><?php echo $value["charge"]; ?> د.ب </td>						
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } elseif ((isset($_GET['report']) && $_GET['report'] == "week")) {
                $report = $_GET['report'];
                ?>
                <h1>Weekly Report</h1>
                <h3 style="text-align:center;font-size:15px;">   from date 
                    <?php echo date('Y-m-d', strtotime('-6 days')); ?>
                </h3>
                <h3 style="text-align:center;font-size:15px;">   To date today
                    <?php echo date("Y-m-d"); ?>
                </h3>
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Id  </th>
                            <th>Client Name </th>
                            <th>Phone </th>
                            <th> Charge Cost </th>
                            <th> Discount Percentage  </th>
                            <th>Sum </th>
                            <th> Payment Way </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $x = 1;
                        global $con;
                        $showRecordPerPage = 10;
                        if (isset($_GET['page']) && !empty($_GET['page'])) {
                            $currentPage = $_GET['page'];
                        } else {
                            $currentPage = 1;
                        }
                        $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;

                        $query = $con->query("SELECT * FROM `orders` where  (date(date) BETWEEN '" . date('Y-m-d', strtotime('-6 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and  `order_follow`=3");
                        $orders_count = mysqli_num_rows($query);
                        $lastPage = ceil($orders_count / $showRecordPerPage);
                        $firstPage = 1;
                        $nextPage = $currentPage + 1;
                        $previousPage = $currentPage - 1;
                        $orderSQL = "SELECT *
FROM `orders` where (date(date) BETWEEN '" . date('Y-m-d', strtotime('-6 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and  `order_follow`=3 LIMIT $startFrom, $showRecordPerPage";
                        $orderResult = $con->query($orderSQL);

                        while ($row = mysqli_fetch_assoc($orderResult)) {
                            $order_id = $row['order_id'];
                            $payment = $row['payment'];
                            $client_id = $row['client_id'];
                            $client_address_id = $row['client_address_id'];
                            $date = $row['date'];
                            $discount_percentage = $row['discount_percentage'];
                            $net_price = $row['net_price'];
                            $getCharge = $row['charge_cost'];
                            ?>
                            <tr class="gradeX <?php echo $order_id; ?>">
                                <td><?php echo $x; ?></td>
                                <td><?php echo $order_id; ?></td>
                                <td><?php echo get_client_name_by_id($client_id); ?></td>
                                <td class="customFont"><?php echo get_client_phone_by_id($client_id); ?></td>
                                <td style="text-align:center;"> <?php echo $getCharge; ?> د.ب </td>
                                <td style="text-align:center;"> <?php echo $discount_percentage; ?> %</td>
                                <td style="text-align:center;"> <?php echo $net_price; ?> د.ب </td>
                                <td class="customFont"><?php echo $payment; ?></td>
                                <td class="customFont"><?php echo $date; ?></td>

                            </tr>
                            <?php
                            $x++;
                        }
                        ?>
                        <?php if ($orders_count == 0) { ?>
                            <tr class="selectable" >
                                <td colspan="8" class="center uniformjs" style="text-align: center"> لا يوجد عناصر</td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>	

                <?php if ($orders_count > 0) { ?>

                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($currentPage != $firstPage) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($currentPage >= 2) { ?>
                                <li class="page-item"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
                            <?php } ?>
                            <li class="page-item active"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
                            <?php if ($currentPage != $lastPage) { ?>
                                <li class="page-item"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
                                <li class="page-item">
                                    <a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $lastPage ?>" aria-label="Next">
                                        <span aria-hidden="true">Last</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                <?php } ?>
                <h1>Total Weekly Report</h1>

                <table>
                    <tr>
                        <th> Number Of Clients </th>
                        <th> Number Of Orders </th>
                        <th> Total Cost Of Orders</th>
                        <th> Total Cost Of Charge
                        </th>
                    </tr>
                    <?php
                    $x = 1;
                    global $con;
                    $sql = "SELECT count(order_id) as order_count  FROM `orders` WHERE (date(date) BETWEEN '" . date('Y-m-d', strtotime('-6 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and `order_follow`=3 ";

                    $querya = $con->query($sql);
                    $order_count = mysqli_fetch_row($querya);
//                    echo $order_count[0];
//عدد العملاء
                    $sqlc = "SELECT DISTINCT client_id  FROM `orders` WHERE (date(date) BETWEEN '" . date('Y-m-d', strtotime('-6 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and `order_follow`=3 ";

                    $queryc = $con->query($sqlc);
                    $client_count = mysqli_num_rows($queryc);

                    //اجمالي التكلفة

                    $sqlx = "SELECT *  FROM `orders` WHERE (date(date) BETWEEN '" . date('Y-m-d', strtotime('-6 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and `order_follow`=3 ";

                    $queryx = $con->query($sqlx);
                    $price = 0;
                    $charge = 0;
                    while ($row_select = mysqli_fetch_assoc($queryx)) {

                        $client_id = $row_select['client_id'];

                        $net_price = $row_select['net_price'];
                        $price +=$net_price;
                        $getCharge = $row_select['charge_cost'];
                        $charge +=$getCharge;
                    }
//                    echo 'price=' . $price;
                    $financial_report[] = array("client_count" => $client_count, "charge" => $charge, "order_count" => $order_count[0], "price" => $price);
                    foreach ($financial_report as $value) {
                        ?>				  
                        <tr>
                            <td><?php echo $value["client_count"]; ?></td>						
                            <td><?php echo $value["order_count"]; ?></td>						
                            <td><?php echo $value["price"]; ?> د.ب </td>						
                            <td><?php echo $value["charge"]; ?> د.ب </td>						
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } elseif ((isset($_GET['report']) && $_GET['report'] == "month")) {
                $report = $_GET['report'];
                ?>
                <h1>Month Report
                </h1>
                <h3 style="text-align:center;font-size:15px;">   from date 
                    <?php echo date('Y-m-d', strtotime('-29 days')); ?>
                </h3>
                <h3 style="text-align:center;font-size:15px;">  To date today
                    <?php echo date("Y-m-d"); ?>
                </h3>
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> Order Id  </th>
                            <th> Client Name </th>
                            <th> Phone </th>
                            <th> Charge Cost </th>
                            <th> Discount Percentage  </th>
                            <th>Sum </th>
                            <th> Payment Way </th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $x = 1;
                        global $con;
                        $showRecordPerPage = 10;
                        if (isset($_GET['page']) && !empty($_GET['page'])) {
                            $currentPage = $_GET['page'];
                        } else {
                            $currentPage = 1;
                        }
                        $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;

                        $query = $con->query("SELECT * FROM `orders` where  (date(date) BETWEEN '" . date('Y-m-d', strtotime('-29 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and  `order_follow`=3");
                        $orders_count = mysqli_num_rows($query);
                        $lastPage = ceil($orders_count / $showRecordPerPage);
                        $firstPage = 1;
                        $nextPage = $currentPage + 1;
                        $previousPage = $currentPage - 1;
                        $orderSQL = "SELECT *
FROM `orders` where (date(date) BETWEEN '" . date('Y-m-d', strtotime('-29 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and  `order_follow`=3 LIMIT $startFrom, $showRecordPerPage";
                        $orderResult = $con->query($orderSQL);
                        while ($row = mysqli_fetch_assoc($orderResult)) {
                            $order_id = $row['order_id'];
                            $payment = $row['payment'];
                            $client_id = $row['client_id'];
                            $client_address_id = $row['client_address_id'];
                            $date = $row['date'];
                            $discount_percentage = $row['discount_percentage'];
                            $net_price = $row['net_price'];
                            $getCharge = $row['charge_cost'];
                            ?>
                            <tr class="gradeX <?php echo $order_id; ?>">
                                <td><?php echo $x; ?></td>
                                <td><?php echo $order_id; ?></td>
                                <td><?php echo get_client_name_by_id($client_id); ?></td>
                                <td class="customFont"><?php echo get_client_phone_by_id($client_id); ?></td>
                                <td style="text-align:center;"> <?php echo $getCharge; ?> د.ب </td>
                                <td style="text-align:center;"> <?php echo $discount_percentage; ?> %</td>
                                <td style="text-align:center;"> <?php echo $net_price; ?> د.ب </td>

                                <td class="customFont"><?php echo $payment; ?></td>
                                <td class="customFont"><?php echo $date; ?></td>

                            </tr>
                            <?php
                            $x++;
                        }
                        ?>
                        <?php if ($orders_count == 0) { ?>
                            <tr class="selectable" >
                                <td colspan="8" class="center uniformjs" style="text-align: center"> لا يوجد عناصر</td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>	

                <?php if ($orders_count > 0) { ?>

                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($currentPage != $firstPage) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
                                        <span aria-hidden="true">First</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($currentPage >= 2) { ?>
                                <li class="page-item"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
                            <?php } ?>
                            <li class="page-item active"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
                            <?php if ($currentPage != $lastPage) { ?>
                                <li class="page-item"><a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
                                <li class="page-item">
                                    <a class="page-link" href="print_selected_financial_report.php?report=<?php echo $report; ?>&page=<?php echo $lastPage ?>" aria-label="Next">
                                        <span aria-hidden="true">Last</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                <?php } ?>
                <h1>Total report of the month</h1>

                <table>
                    <tr>
                        <th> Number Of Clients </th>
                        <th> Number Of Orders </th>
                        <th> Total Cost Of Orders</th>
                        <th> Total Cost Of Charge
                        </th>
                    </tr>
                    <?php
                    $x = 1;
                    global $con;
                    $sql = "SELECT count(order_id) as order_count  FROM `orders` WHERE (date(date) BETWEEN '" . date('Y-m-d', strtotime('-29 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and `order_follow`=3 ";

                    $querya = $con->query($sql);
                    $order_count = mysqli_fetch_row($querya);
//                    echo $order_count[0];
//عدد العملاء
                    $sqlc = "SELECT DISTINCT client_id  FROM `orders` WHERE (date(date) BETWEEN '" . date('Y-m-d', strtotime('-29 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and `order_follow`=3 ";

                    $queryc = $con->query($sqlc);
                    $client_count = mysqli_num_rows($queryc);

                    //اجمالي التكلفة

                    $sqlx = "SELECT *  FROM `orders` WHERE (date(date) BETWEEN '" . date('Y-m-d', strtotime('-29 days')) . "' AND '" . date("Y-m-d") . "' ) and `order_status`=1 and `order_follow`=3 ";

                    $queryx = $con->query($sqlx);
                    $price = 0;
                    $charge = 0;
                    while ($row_select = mysqli_fetch_assoc($queryx)) {

                        $client_id = $row_select['client_id'];
                        $net_price = $row_select['net_price'];
                        $price +=$net_price;
                        $getCharge = $row_select['charge_cost'];
                        $charge +=$getCharge;
                    }
//                    echo 'price=' . $price;
                    $financial_report[] = array("client_count" => $client_count, "charge" => $charge, "order_count" => $order_count[0], "price" => $price);
                    foreach ($financial_report as $value) {
                        ?>				  
                        <tr>
                            <td><?php echo $value["client_count"]; ?></td>						
                            <td><?php echo $value["order_count"]; ?></td>						
                            <td><?php echo $value["price"]; ?> د.ب</td>						
                            <td><?php echo $value["charge"]; ?> د.ب</td>						
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            <?php } ?>

        </div>



    </div>	

    <script src="assets/js/jquery.min.js"></script>
</body>
</html>