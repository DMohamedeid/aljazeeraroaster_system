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

if (isset($_GET['client_id'])) {

    $client_id = $_GET['client_id'];
    $lang = $_GET['lang'];

    $result = mysql_query("SELECT * FROM `client_addresses` WHERE `client_id`='$client_id'") or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["product"] = array();

        while ($row = mysql_fetch_array($result)) {

            // temp user array
            $product = array();

            $product["client_address_id"] = $row["client_address_id"];
            $product["lat"] = $row["lat"];
            $product["lang"] = $row["lang"];
            $product["region_id"] = $row["region"];
            $region_id = $row["region"];

            if ($lang == "ar") {
            $product["region_name"] = get_region_name($region_id);
            } else {
                $product["region_name"] = get_region_name_en($region_id);
            }
            $product["charge"] = get_charge($region_id);
            $product["min_order"] = get_min_order($region_id);

            $product["block"] = $row["block"];
            $product["road"] = $row["road"];
            $product["building"] = $row["building"];
            $product["flat_number"] = $row["flat_number"];
            $product["client_phone"] = $row["client_phone"];
            $product["note"] = $row["note"];
            $product["client_id"] = $row["client_id"];

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
    if ($lang == "ar") {
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    } else {
        $response["message"] = "Missing data Please review your data";
    }
    // echo no users JSON
    echo json_encode($response);
}
?>