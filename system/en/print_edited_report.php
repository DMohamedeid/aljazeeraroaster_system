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



            <h1>Report edited orders  </h1>
            <?php if (($_POST['from'] != '')) { ?>
                <h3 style="text-align:center;font-size:15px;">   date from  
                    <?php echo $_POST['from']; ?>
                </h3>
            <?php } ?>
            <?php if (($_POST['to'] != '')) { ?>
                <h3 style="text-align:center;font-size:15px;">   date to 
                    <?php echo $_POST['to']; ?>
                </h3>
            <?php } ?>
            <table class="table table-striped ">
                <thead>
                    <tr>

                        <th> Order Id  </th>
                        <th> Client Name </th>
                        <th> Date Added </th>
                        <th> Edit Date </th>
                        <th> Edit Reason </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $x = 1;
                    global $con;
                    $query = "SELECT * FROM `orders` WHERE `del`=1 ";
                    if (($_POST['from'] != '') && ($_POST['to'] != '')) {
                        $query .= "AND `date_del` BETWEEN '" . $_POST['from'] . "' AND '" . $_POST['to'] . "' ";
                    } else if ($_POST['from'] && ($_POST['to'] == '')) {
                        $query .= "AND date_del >= '" . $_POST['from'] . "' ";
                    } else if ($_POST['to'] && ($_POST['from'] == '')) {
                        $query .= "AND date_del < '" . $_POST['to'] . "' ";
                    }
//                    echo $query;
                    $orderResult = $con->query($query);
                    $orders_count = mysqli_num_rows($orderResult);
                    while ($row = mysqli_fetch_assoc($orderResult)) {
                        $order_id = $row['order_id'];
                        $get_order_reason_edited = get_order_reason_edited($order_id);

                        $client_id = $row['client_id'];
                        $date = $row['date'];
                        $date_report = $row['date_del'];
                        ?>
                        <tr class="gradeX <?php echo $order_id; ?>">
                            <td><?php echo $order_id; ?></td>
                            <td><?php echo clientName($client_id); ?></td>
                            <td class="customFont"><?php echo $date; ?></td>
                            <td class="customFont"><?php echo $date_report; ?></td>
                            <td class="customFont"><?php echo $get_order_reason_edited; ?></td>
                        </tr>
                        <?php
                        $x++;
                    }
                    ?>
                    <?php if ($orders_count == 0) { ?>
                        <tr class="selectable" >
                            <td colspan="10" class="center uniformjs" style="text-align: center"> no elements  </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>



    </div>
</div>


<script src="assets/js/jquery.min.js"></script>
</body>
</html>