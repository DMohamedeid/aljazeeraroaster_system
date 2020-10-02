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


// get all products from products table

if (isset($_GET['lang']) && $_GET['lang'] != '') {

        $lang = $_GET['lang'];
        $client_id=$_GET['client_id'];
        
        $response["slider"] = get_slider($lang,$client_id);
        $response["parent_categories"] = get_parent_categories($lang);
        $response["most_request"] = most_request_sub($client_id,$lang);
        $response["latest"] = get_latest_products($client_id,$lang);
        
        $response["success"] = 1;


} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
}


    //echo data    
   echo json_encode($response);



?>