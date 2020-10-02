<?php

/*
 * Following code will list all the products
 */
// array for JSON response
$response = array();

// include db connect class
include("db_connect.php");

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");




        $response["orders"]= array();
            


        $run_query = "SELECT  orders.client_id,orders.deliver_id,orders.order_follow,orders.order_id,cast((orders.total_price-orders.vat)  as decimal(18,3))  AS Amount,
        cast(orders.net_price as decimal(18,3))  AS Net_Amount,cast(orders.charge_cost as decimal(18,3))  AS Charge,cast(orders.vat as decimal(18,4))  AS VAT,
        cast((orders.net_price-orders.vat-orders.charge_cost)/((100-discount_percentage)/100) as decimal(18,3))-cast(orders.net_price-orders.vat-orders.charge_cost as decimal(18,3))
        AS discount, orders.date AS OrderDate, (select clients.client_name from clients where clients.client_id=orders.client_id ) AS ClientName,     
        (select clients.client_phone from clients where clients.client_id=orders.client_id )  AS Phone,     orders.payment AS Payment,(SELECT   region_name_en  FROM            
        regions         WHERE             regions.region_id = (select client_addresses.region from client_addresses where client_addresses.client_address_id=orders.client_address_id))
        AS Area,(select block from client_addresses where client_addresses.client_address_id=orders.client_address_id) AS Block,(select road from client_addresses where 
        client_addresses.client_address_id=orders.client_address_id) AS Road,(select building from client_addresses where client_addresses.client_address_id=orders.client_address_id)
        AS Building,(select flat_number from client_addresses where client_addresses.client_address_id=orders.client_address_id) AS Flat,(select note from client_addresses 
        where client_addresses.client_address_id=orders.client_address_id) AS Note,order_status as status,  (select name_en from delivered_way where id=orders.deliver_id)   
        as OrderMode  ,IF(IFNULL(mobile_type, '') = '', 'ios', mobile_type)  as mobile_type  " ;
        
         if (isset($_GET['$is_drivers'])) {$is_drivers=$_GET['is_drivers']; if (  $is_drivers=='1') {
              $run_query = $run_query.",(select  name from drivers   where drivers.id=orders.driver_id) as Driver_name ";
          }else {
                            $run_query = $run_query.",('') as Driver_name ";

          }
        }
        
        
        $run_query = $run_query . " FROM     orders where IF(IFNULL(mobile_type, '') = '', 'ios', mobile_type) in ('ios','android','web') ";
        
        
        if (isset($_GET['from_date'])) {
            
            $from_date=$_GET['from_date'];
            $date = new DateTime($from_date);$from_date=$date->format('m-d-Y');
            $run_query = $run_query." and DATE_FORMAT(date, '%m-%d-%Y')  = '$from_date'  ";
        
        }
        
        
          if (isset($_GET['new_orders'])) {
            
            $new_orders=$_GET['new_orders'];
                if ($new_orders == '1' ) {$run_query = $run_query." and orders.order_status=0" ;}
            }
        
        if (isset($_GET['branch_id'])) {
            $branch_id=$_GET['branch_id'];
            if ($branch_id > 0) 
            {
             $run_query = $run_query." and orders.branch_id='$branch_id' ";

            }
}
        
        if (isset($_GET['order_follow'])) {
                $order_follow=$_GET['order_follow'];
                if ($order_follow >0 ) {$run_query = $run_query." and orders.order_follow = $order_follow";}
        
        }
        
        if (isset($_GET['order_id'])) {
                $order_id=$_GET['order_id'];
                if ($order_id >0 ) {$run_query = $run_query." and orders.order_id = $order_id";}
        
        }
        
        if (isset($_GET['limit'])) {
            
                $limit=$_GET['limit'];
                if ($limit >0 ) {$run_query = $run_query." limit 0,$limit";}
        
        }
        
        
       
        
        $result = mysql_query($run_query);

        //  echo $run_query;

        while ($row = mysql_fetch_array($result)) {
            $order = array();
            $order["client_id"] = $row["client_id"];
            $order["deliver_id"] = $row["deliver_id"];
            $order["order_follow"] = $row["order_follow"];
            $order["order_id"] = $row["order_id"];
            $order["Amount"] = $row["Amount"];
            $order["Net_Amount"] = $row["Net_Amount"];
            $order["Charge"] = $row["Charge"];
            $order["VAT"] = $row["VAT"];
            $order["discount"] = $row["discount"];
            $order["OrderDate"] = $row["OrderDate"];
            $order["ClientName"] = $row["ClientName"];
            $order["Phone"] = $row["Phone"];
            $order["Payment"] = $row["Payment"];
            $order["Area"] = $row["Area"];
            $order["Road"] = $row["Road"];
            $order["Building"] = $row["Building"];
            $order["Flat"] = $row["Flat"];
            $order["Block"] = $row["Block"];
            $order["Note"] = $row["Note"];
            $order["status"] = $row["status"];
            $order["OrderMode"] = $row["OrderMode"];
            $order["mobile_type"] = $row["mobile_type"];
            $order["Driver_name"] = $row["Driver_name"];
            
            array_push($response["orders"], $order);

}


  



if (count($response["orders"]) == 0) {
            $order = array();
            $order["client_id"] = '0';
            $order["deliver_id"] ='0';
            $order["order_follow"] = 0;
            $order["order_id"] = '0';
            $order["Amount"] = '0';
            $order["Net_Amount"] = '0';
            $order["Charge"] = '0';
            $order["VAT"] = '0';
            $order["discount"] ='0';
            $order["OrderDate"] = '0';
            $order["ClientName"] ='0';
            $order["Phone"] = '0';
            $order["Payment"] = '0';
            $order["Area"] ='0';
            $order["Road"] = '0';
            $order["Building"] = '0';
            $order["Flat"] = '0';
            $order["Block"] = '0';
            $order["Note"] = '0';
            $order["status"] = '0';
            $order["OrderMode"] = '0';
            $order["mobile_type"] ='0';
            $order["Driver_name"] ='0';

array_push($response["orders"], $order);
}





$response["success"] = 1;

    echo json_encode($response["orders"]);
    
    



function tableexist() {
$result      = mysql_query("SHOW TABLES LIKE 'user_addresses_session'");
$tableExists = mysql_num_rows($result);

echo $tableExists ;

}

    
    
?>





