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

mysqli_query($con, "SET NAMES 'utf8'");

mysqli_query($con, "SET CHARACTER SET utf8");

mysqli_query($con, "SET SESSION collation_connection = 'utf8_unicode_ci'");


// get all products from products table

if (isset($_GET['lang']) && $_GET['lang'] != '') {

    $lang = $_GET['lang'];
    $parent_cat_id=$_GET['parent_category_id']?:0;

// get all products from products table

    $result = mysqli_query($con , "SELECT * FROM `sub_categories_addition_prices` WHERE `parent_category_id`='$parent_cat_id' ") or die(mysql_error());

// check for empty result
    if (mysqli_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["product"] = array();

        while ($row = mysqli_fetch_array($result)) {
            // temp user array
            $product = array();
            $product["addition_id"] = $row["sub_category_addition_price_id"];
            if ($lang == "ar") {
                $product["addition_name"] = $row["sub_category_addition_name_ar"];
            } else {
                $product["addition_name"] = $row["sub_category_addition_name"];
            }

            //$product["addition_price"] =number_format((float)$row["sub_category_addition_price"], 3, '.', '');

            $product["addition_price"] =$row["sub_category_addition_price"];

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