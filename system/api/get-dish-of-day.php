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

$date_now = date('Y-m-d');

$result = mysql_query("SELECT * FROM `dish_of_day` where `show_date`='$date_now' ") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["product"] = array();

    while ($row = mysql_fetch_array($result)) {

        // temp user array
        $product = array();

        $product["id"] = $row["id"];
        $product["parent_category_id"] = $row["parent_category_id"];
        $parent_category_id = $row["parent_category_id"];
        $product["parent_category_name"] = get_category_name_from_id($parent_category_id);
        $product["sub_category_id"] = $row["sub_category_id"];
        $sub_category_id = $row["sub_category_id"];
        $product["evaluate"] = resume_evaluate($sub_category_id);

        $product["sub_category_name"] = get_sub_category_name_from_id($sub_category_id);
        $product["show_date"] = $row["show_date"];

        $product["type"] = $row["type"];
        $product["image"] = $row["image"];

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