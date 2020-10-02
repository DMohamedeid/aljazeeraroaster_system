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
        <title> Average check report</title>
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
            <h1>Average check report</h1>
            <?php if (($_POST['from'] != '')) { ?>
                <h3 style="text-align:center;font-size:15px;">   From Date
                    <?php echo $_POST['from']; ?>
                </h3>
            <?php } ?>
            <?php if (($_POST['to'] != '')) { ?>
                <h3 style="text-align:center;font-size:15px;">   To Date 
                    <?php echo $_POST['to']; ?>
                </h3>
            <?php } ?>

            <h3 style="text-align:center;font-size:15px;">  Total
            </h3>
            <table>
                <tr>
                    <th>Clients Number</th>
                    <th>Orders Number </th>
                    <th>Total Cost Of Orders</th>
                    <th>Total Cost Of Charge</th>
                    <th>Total Cost </th>
                    <th> Average Check</th>
                </tr>
                <?php
                $x = 1;
                global $con;
                $sql = "SELECT count(order_id) as order_count  FROM `orders` WHERE `order_status`=1 and `order_follow`=3 ";
                if (($_POST['from'] != '') && ($_POST['to'] != '')) {
                    $sql .= "AND (date(date) BETWEEN '" . $_POST['from'] . "' AND '" . $_POST['to'] . "' )";
                } else if ($_POST['from'] && ($_POST['to'] == '')) {
                    $sql .= "AND date(date) >= '" . $_POST['from'] . "' ";
                } else if ($_POST['to'] && ($_POST['from'] == '')) {
                    $sql .= "AND date(date) < '" . $_POST['to'] . "'";
                }
                if ($_POST['select_payment_type'] && ($_POST['select_payment_type'] != '')) {
                    $sql .= " AND `payment`='" . $_POST['select_payment_type'] . "'";
                }
                $querya = $con->query($sql);
                $order_count = mysqli_fetch_row($querya);
//                    echo $order_count[0];
//عدد العملاء
                $sqlc = "SELECT DISTINCT client_id  FROM `orders` WHERE `order_status`=1 and `order_follow`=3 ";
                if (($_POST['from'] != '') && ($_POST['to'] != '')) {
                    $sqlc .= "AND (date(date) BETWEEN '" . $_POST['from'] . "' AND '" . $_POST['to'] . "' )";
                } else if ($_POST['from'] && ($_POST['to'] == '')) {
                    $sqlc .= "AND date(date) >= '" . $_POST['from'] . "'";
                } else if ($_POST['to'] && ($_POST['from'] == '')) {
                    $sqlc .= "AND date(date) < '" . $_POST['to'] . "' ";
                }
                if ($_POST['select_payment_type'] && ($_POST['select_payment_type'] != '')) {
                    $sqlc .= " AND `payment`='" . $_POST['select_payment_type'] . "'";
                }
                $queryc = $con->query($sqlc);
                $client_count = mysqli_num_rows($queryc);

                //اجمالي التكلفة

                $sqlx = "SELECT *  FROM `orders` WHERE `order_status`=1 and `order_follow`=3 ";
                if (($_POST['from'] != '') && ($_POST['to'] != '')) {
                    $sqlx .= " AND  (date(date) BETWEEN '" . $_POST['from'] . "' AND '" . $_POST['to'] . "' )";
                } else if ($_POST['from'] && ($_POST['to'] == '')) {
                    $sqlx .= "AND date(date) >= '" . $_POST['from'] . "' ";
                } else if ($_POST['to'] && ($_POST['from'] == '')) {
                    $sqlx .= "AND date(date) < '" . $_POST['to'] . "' ";
                }

                $queryx = $con->query($sqlx);
                $price = 0;
                $charge = 0;
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
                $financial_report[] = array("client_count" => $client_count, "charge" => $charge, "order_count" => $order_count[0], "price" => $price);
                foreach ($financial_report as $value) {
                    $total_price = $value["charge"] + $value["price"];
                    $order_count = $value["order_count"];
                    if ($order_count == 0) {
                        $average = 0;
                    } else {
                        $average = $total_price / $order_count;
                    }
                    ?>				  
                    <tr>
                        <td><?php echo $value["client_count"]; ?></td>						
                        <td><?php echo $order_count; ?></td>						
                        <td><?php echo $value["price"]; ?> B.D</td>						
                        <td><?php echo $value["charge"]; ?> B.D</td>						
                        <td><?php echo $total_price; ?> B.D</td>						
                        <td><?php echo $average; ?> </td>						
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>