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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


// get all products from products table
// Start Functionality  

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = $_GET['query'];


    $result = mysql_query($query) or die(mysql_error());

// check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $product= array();

        while ($row = mysql_fetch_array($result)) {

            // temp user array

            $product[] = $row;

            // push single product into final response array
        }
        // success
        $response["success"] = 1;
        echo json_encode($product);

    } else {

        $response["product"] = array();

        // temp user array
        $product = array();

        // success
        $response["success"] = 1;

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    
    // echo no users JSON
    echo json_encode($response);
}
?>