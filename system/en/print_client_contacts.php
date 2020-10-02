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
        <title>Clients Numbers</title>
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




            <h1>أرقام العملاء (<?php
                $con->query("UPDATE `client_contact` SET `phone_number` = REPLACE(`phone_number`, ' ', '')");


                echo current_contacts_count($_GET);
                ?>)</h1>

            <?php
            error_reporting(0);
            $items = (int) $_GET['items'];
            $items = $items ? $items : 10;
            $query_items = '';
            if ((INT) $_GET['items'] > 0) {
                $query_items = '&items=' . (INT) $_GET['items'];
            }

            define(ITEMS_PER_PAGE, $items);

            $page = (int) $_GET['page'];
            $page = ($page < 1) ? 1 : $page;
            $start = ($page - 1) * ITEMS_PER_PAGE;
            $client_name = $_GET['client_name'];
            $client_phone = $_GET['client_phone'];
            $data_num = current_contacts_count($_GET); //echo $data_num; die();
            $allData = view_contacts($start, ITEMS_PER_PAGE, $_GET);  //echo '<pre>'; print_r($allData); die();
            $url = "print_client_contacts.php?items=" . ITEMS_PER_PAGE . (($client_name) ? "&client_name=" . $client_name : "") . (($client_phone) ? "&client_phone=" . $client_phone : "");
            $navigation = navigationHomee($data_num, $start, count($allData), $url, ITEMS_PER_PAGE);
            ?>
            <div class="col-md-3">
                <div class="form-group">  
                    <label  for="client_name" class=" control-label">ابحث  بإسم  العميل</label> 
                    <input name="client_name" placeholder="إسم  العميل" id="client_name" value="<?php echo $_GET['client_name']; ?>" type="text"  class= "form-control  search-input-text"  >
                    <label  for="client_phone"  class=" control-label">ابحث  برقم الهاتف  </label> 
                    <input name="client_phone" placeholder="رقم  العميل" id="client_phone" value="<?php echo $_GET['client_phone']; ?>" type="text"  class= "form-control  search-input-text"  >
                </div> 

            </div> 
            <div class="clearfix"></div>

            <div class="col-md-3">
                <div class="form-group " >  
                    <button class="btn btn-icon btn-default" type="button" style="    margin-left:-450px!important;
                            width: 65px;
                            height: 57px;" onclick="setAction();">بحث </button>
                    <button class="btn btn-icon btn-success" type="button" style="    margin-left: -529px!important;
                            width: 65px;
                            height: 57px;" onclick="setNoAction();">إعاده </button>
                </div> 
            </div> 
            <div class="clearfix"></div>

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th> الإسم</th>
                        <th>رقم الهاتف</th>
                    </tr>
                </thead>
                <tbody> <?php $contacts = view_contacts($start, ITEMS_PER_PAGE, $_GET); ?> 
                    <?php
                    foreach ($contacts as $key => $row) {
                        $id = $row['id'];
                        $phone_number = $row['phone_number'];
                        $name = $row['name'];
                        $x = $row['x'];
                        ?>
                        <tr class="gradeX">
                            <td><?php echo $x; ?></td>
                            <td><?php echo $name; ?></td>
                            <td class="customFont"><?php echo $phone_number; ?></td>
                        </tr>	
                    <?php } ?>
                    <?php if ($data_num == 0) { ?>
                        <tr class="selectable" >
                            <td colspan="7" class="center uniformjs" style="text-align: center"> لا يوجد عناصر</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if ($data_num > 0) { ?>
                <div class="pull-left" style="width: auto; ">
                    <?php echo $navigation; ?>
                </div>
            <?php } ?>
        </div>



    </div>



    <script src="assets/js/jquery.min.js"></script>
    <script>
                                function setAction() {
                                    var client_name = $("#client_name").val();
                                    var client_phone = $("#client_phone").val();

                                    if (client_name !== '' && client_phone === '') {
                                        var link = 'print_client_contacts.php?client_name=' + client_name;
                                        document.location.href = link;
                                    }
                                    else if (client_phone !== '' && client_name === '') {
                                        var link = 'print_client_contacts.php?client_phone=' + client_phone;
                                        document.location.href = link;
                                    } else {
                                        window.location = 'print_client_contacts.php';
                                    }
                                }
                                function setNoAction() {
                                    window.location = 'print_client_contacts.php';
                                }
    </script>
</body>
</html>