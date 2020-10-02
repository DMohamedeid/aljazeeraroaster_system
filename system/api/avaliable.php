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


$result = mysql_query("SELECT * FROM `setting`") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["product"] = array();

    while ($row = mysql_fetch_array($result)) {

        // temp user array
        $product = array();
        $product["accept_orders"] = $row["accept_orders"];
        $product["discount"] = $row["discount"];
        $product["discount_percentage"] = (int)$row["discount_percentage"];

        // push single product into final response array
        array_push($response["product"], $product);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {

    $response["product"] = array();

    // temp user array
    $product = array();

    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
}
?>