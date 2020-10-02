<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
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
        <title>Most Ordered Customers </title>
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
    <div class="content-page" style="margin-right:15px;    margin-top: 6px;">
        <!-- Start content -->
        <div class="content">




            <h1>  Most Ordered customers</h1>
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
            <?php
            $sql = "SELECT clients.client_name ,clients.client_phone , COUNT(`order_id`) as ct  FROM `orders` left join clients on clients.client_id=orders.client_id where 1=1  ";
            if ($_POST['from']) {
                $sql .= " AND orders.date >= '" . $_POST['from'] . "' ";
            }
            if ($_POST['to']) {
                $sql .= " AND orders.date  <= '" . $_POST['to'] . "'";
            }
            $sql .=" GROUP by orders.client_id ORDER BY ct DESC limit 10";
            $query = $con->query($sql);
            ?>

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th> Name</th>
                        <th>Phone </th>
                        <th>Number Of Orders  </th>
                    </tr>
                </thead>
                <tbody> <?php
                    $x = 1;
                    $clients = array();

                    while ($row = mysqli_fetch_assoc($query)) {

                        $x++;
                        array_push($clients, $row);
                    }
                    ?> 
                    <?php
                    foreach ($clients as $key => $row) {
                        $client_phone = $row['client_phone'];
                        $client_name = $row['client_name'];
                        $order_ct = $row['ct'];
                        ?>
                        <tr class="gradeX">
                            <td><?php echo $key; ?></td>
                            <td><?php echo $client_name; ?></td>
                            <td class="customFont"><?php echo $client_phone; ?></td>
                            <td class="customFont"><?php echo $order_ct; ?></td>
                        </tr>	
                    <?php } ?>
                    <?php if (mysqli_num_rows($query) == 0) { ?>
                        <tr class="selectable" >
                            <td colspan="7" class="center uniformjs" style="text-align: center"> No Elements</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>



    </div>



    <script src="assets/js/jquery.min.js"></script>
</body>
</html>