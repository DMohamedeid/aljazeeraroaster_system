
<?php


//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

include("db_connect.php");
$db = new DB_CONNECT();
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");


if (isset($_GET['allbranch'])) {
        if($_GET['allbranch']){ 

    $response = array();
    $allbranch = $_GET['allbranch'];
    $run_query = 'SELECT * FROM `branches` ';
    $result = mysql_query($run_query);
    $response["branches"]= array();
        while ($row = mysql_fetch_array($result))   {
            $order = array();
            $order["id"] = $row["id"];
            
            $order["name"] = $row["name"];

            array_push($response["branches"], $order);
                                                    }
    $response["success"] = 1;
    echo json_encode($response["branches"]);
            
        }
}


if (isset($_GET['branch_id'], $_GET['categories'])) {//do the fields exist
    if($_GET['branch_id'] && $_GET['categories']){ //do the fields contain data

    $response = array();
    $branch_id = $_GET['branch_id'];
    
    $run_query = 'SELECT parent_category_id,parent_category_name,"" as  printer_name FROM  `parent_categories`  where branch_id=$branch_id';
    $result = mysql_query($run_query);
    $response["categories"]= array();
        while ($row = mysql_fetch_array($result))   {
            $order = array();
            $order["parent_category_id"] = $row["parent_category_id"];
            $order["parent_category_name"] = $row["parent_category_name"];
            $order["printer_name"] = $row["printer_name"];
            array_push($response["categories"], $order);
                                                    }
    $response["success"] = 1;
    echo json_encode($response["categories"]);
    
    }
    
}


if (isset($_GET['branch_id'], $_GET['drivers'])) {//do the fields exist
    if($_GET['branch_id'] && $_GET['drivers']){ //do the fields contain data

    $response = array();
    $branch_id = $_GET['branch_id'];
    $run_query = 'SELECT id,name from `drivers`  where branch_id=$branch_id';
    $result = mysql_query($run_query);
    $response["branches"]= array();

        while ($row = mysql_fetch_array($result))   {
            $order = array();
            $order["id"] = $row["id"];
            $order["name"] = $row["name"];
            array_push($response["drivers"], $order);
                                                    }
    $response["success"] = 1;
    echo json_encode($response["drivers"]);
            



    }
    
}





