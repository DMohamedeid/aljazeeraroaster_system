<?php

/*
 * Following code will list all the products
 */
// array for JSON response
$response = array();
header('Content-type: text/html');

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


    $result = mysql_query("SELECT * FROM `regions` where `display`=1 ORDER BY `region_id` DESC") or die(mysql_error());

// check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["product"] = array();

        while ($row = mysql_fetch_array($result)) {
            // temp client array
            $product = array();
            $product["region_id"] = $row["region_id"];
            if ($lang == "ar") {
                $product["region_name"] = $row["region_name_ar"];
            } else {
                $product["region_name"] = $row["region_name_en"];
            }
            $product["city_id"] = $row["city_id"];
            $product["charge"] = $row["charge"];
            $product["min_order"] = $row["min_order"];
            $product["order_period"] = $row["order_period"];

            // push single product into final response array
            array_push($response["product"], $product);
        }
        // success
        $response["success"] = 1;


        // echoing JSON response
        echo json_encode($response);
    } else {

        // no products found
        $response["success"] = 0;
        if ($lang == "ar") {
            $response["message"] = "لا يوجد احياء";
        } else {
            $response["message"] = "There is no regions";
        }
        // echo no clients JSON
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