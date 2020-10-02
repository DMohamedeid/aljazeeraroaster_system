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

if (isset($_GET['parent_category_id']) && $_GET['lang'] != '') {

    $parent_category_id = $_GET['parent_category_id'];
    $lang = $_GET['lang'];
    $client_id = $_GET['client_id'];

    $result = mysql_query("SELECT * FROM `sub_categories` WHERE `parent_category_id`='$parent_category_id' and `display`=1 order by sub_category_id desc") or die(mysql_error());


// check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["product"] = array();

        while ($row = mysql_fetch_array($result)) {

            // temp user array
            $product = array();
            $product["sub_category_id"] = $row["sub_category_id"];
            if ($lang == "ar") {
                $product["sub_category_name"] = $row["sub_category_name_ar"];
                $product["sub_category_desc"] = $row["sub_category_desc_ar"];
            } else {
                $product["sub_category_name"] = $row["sub_category_name"];
                $product["sub_category_desc"] = $row["sub_category_desc"];
            }
            $product["sub_category_image"] = $row["sub_category_image"];
            $product["parent_category_id"] = $row["parent_category_id"];
            $sub_category_id = $row["sub_category_id"];
            $product["evaluate"] = resume_evaluate($sub_category_id);
            $product["sizes"] = get_sizes($lang,$sub_category_id);

            $result_zero = mysql_query("SELECT * FROM `client_fav` WHERE `sub_category_id`='$sub_category_id' AND `client_id`='$client_id'") or die(mysql_error());
            if (mysql_fetch_array($result_zero) >= 1) {
                $product["sub_category_fav"] = 1;
            } else {
                $product["sub_category_fav"] = 0;
            }

    

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