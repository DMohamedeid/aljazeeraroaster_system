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


// To Get Orders Summary 

        $run_query = "SELECT  count(order_id) as order_count,sum(total_price) as total_sales,sum(vat) as total_vat,sum(charge_cost) as delivery_charge "
                . " ,sum((total_price*(discount_percentage/100))) as total_discount  FROM     orders  where  " ;
        if (isset($_GET['from_date'])) {
            $from_date=$_GET['from_date'];
            $date = new DateTime($from_date);$from_date=$date->format('m-d-Y');
            $run_query = $run_query."  DATE_FORMAT(date, '%m-%d-%Y')  = '$from_date'  ";
        }
            
        if (isset($_GET['branch_id'])) {
            $branch_id=$_GET['branch_id'];
            $run_query = $run_query." and orders.branch_id='$branch_id' ";
        }
       
        $result = mysql_query($run_query);
        $response["orders"]= array();
        while ($row = mysql_fetch_array($result)) {
            $order = array();
            $order["order_count"] = $row["order_count"];
            $order["total_sales"] = number_format($row["total_sales"], 3, '.', '') ;
            $order["total_vat"] = number_format($row["total_vat"], 3, '.', '') ;
            $order["delivery_charge"] = number_format($row["delivery_charge"], 3, '.', '') ;
            $order["total_discount"] = number_format($row["total_discount"], 3, '.', '') ;
            
            $order["net_sales"] = number_format($row["total_sales"], 3, '.', '') - number_format($row["total_discount"], 3, '.', '') ;
            array_push($response["orders"], $order);

}



// To Get Payment Summary 

        $run_query = "SELECT  sum(net_price) as total_amount,payment  FROM     orders    where   " ;
        if (isset($_GET['from_date'])) {
            $from_date=$_GET['from_date'];
            $date = new DateTime($from_date);$from_date=$date->format('m-d-Y');
            $run_query = $run_query."  DATE_FORMAT(date, '%m-%d-%Y')  = '$from_date'  ";
        }
            
        if (isset($_GET['branch_id'])) {
            $branch_id=$_GET['branch_id'];
            $run_query = $run_query." and orders.branch_id='$branch_id' ";
        }
        
       $run_query=$run_query. "  group by payment ;" ;
               
        $result = mysql_query($run_query);
        $response["payment"]= array();
        while ($row = mysql_fetch_array($result)) {
            $payment = array();
            $payment["payment"] = $row["payment"];
            $payment["total_amount"] = number_format($row["total_amount"], 3, '.', '') ;
            array_push($response["payment"], $payment);

}


// To Get Mode Wise 

        $run_query = "select sum(net_price) as total_amount,sum((total_price*(discount_percentage/100))) as total_discount,delivered_way.name_en as mode from orders inner join delivered_way on orders.deliver_id=delivered_way.id where   " ;
        if (isset($_GET['from_date'])) {
            $from_date=$_GET['from_date'];
            $date = new DateTime($from_date);$from_date=$date->format('m-d-Y');
            $run_query = $run_query."  DATE_FORMAT(date, '%m-%d-%Y')  = '$from_date'  ";
        }
            
        if (isset($_GET['branch_id'])) {
            $branch_id=$_GET['branch_id'];
            $run_query = $run_query." and orders.branch_id='$branch_id' ";
        }
        
       $run_query=$run_query. "  group by delivered_way.name_en  ;" ;
               
        $result = mysql_query($run_query);
        $response["mode"]= array();
        while ($row = mysql_fetch_array($result)) {
            $mode = array();
            $mode["mode"] = $row["mode"];
            $mode["total_amount"] = number_format($row["total_amount"], 3, '.', '') ;
            //$mode["total_amount"] = number_format($row["total_amount"], 3, '.', '') - number_format($row["total_discount"], 3, '.', '') ;
                       
            array_push($response["mode"], $mode);

}


        // To Get Grou Wise Summary 
       $all_cart_id = "";
        $run_query = "select cart_id from orders where " ;
        if (isset($_GET['from_date'])) {
            $from_date=$_GET['from_date'];
            $date = new DateTime($from_date);$from_date=$date->format('m-d-Y');
            $run_query = $run_query."  DATE_FORMAT(date, '%m-%d-%Y')  = '$from_date'  ";
        }
            
        if (isset($_GET['branch_id'])) {
            $branch_id=$_GET['branch_id'];
            $run_query = $run_query." and orders.branch_id='$branch_id' ";
        }
        
         $result = mysql_query($run_query);
       //  echo $run_query;
                     $all_cart_id = $all_cart_id . "'-1'" ;

        while ($row = mysql_fetch_array($result)) {

            $cart_id = $row["cart_id"] ;

            if (strpos($cart_id, ',')) { 
            $cart_id = explode(",", $cart_id);

            foreach($cart_id as $cat) {
               // echo 'Sub '.$cat . "\r\n" ;
                
               $all_cart_id= $all_cart_id . ",'".  $cat . "'";
            }

            } else {
                $all_cart_id = $all_cart_id . ",'".  $cart_id . "'";
            }
            }
           
       //    echo  $all_cart_id ."\r\n" ;

        $run_query = "select sum(cart.price) as amount ,parent_categories.parent_category_name from cart  inner JOIN sub_categories
        ON cart.sub_category_id = sub_categories.sub_category_id inner JOIN parent_categories
        ON sub_categories.parent_category_id = parent_categories.parent_category_id 
        where cart.cart_id in ($all_cart_id)  group by parent_categories.parent_category_name " ;
        // echo $run_query;
        
        $result = mysql_query($run_query);
        $response["category"]= array();
        while ($row = mysql_fetch_array($result))   {
            $category = array();
            $category["parent_category_name"] = $row["parent_category_name"];
            $category["amount"] = number_format($row["amount"], 3, '.', '') ;
            array_push($response["category"], $category);
                                                    
            
        }











    $response["success"] = 1;
    echo json_encode($response);
    
    
    
    
?>