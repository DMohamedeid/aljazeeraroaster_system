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

    $result = mysql_query("SELECT * FROM `parent_categories` where `display`=1 order by `arrangement` asc") or die(mysql_error());

// check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["product"] = array();

        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $product = array();
            $product["parent_category_id"] = $row["parent_category_id"];
            if ($lang == "ar") {
                $product["parent_category_name"] = $row["parent_category_name_ar"];
                $product["parent_category_desc"] = $row["parent_category_desc_ar"];
            } else {
                $product["parent_category_name"] = $row["parent_category_name"];
                $product["parent_category_desc"] = $row["parent_category_desc"];
            }
            $product["parent_category_image"] = $row["parent_category_image"];
            $product["type"] = $row["type"];
            $product["arrangement"] = $row["arrangement"];

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
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echo no users JSON
    echo json_encode($response);
}
?>