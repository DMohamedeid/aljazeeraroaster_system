<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");


if (isset($_GET['client_id'])) {

    $client_id = $_GET['client_id'];
    $sub_category_id = $_GET['sub_category_id'];
    $lang = $_GET['lang'];

    $check_item_fav = check_item_fav($client_id, $sub_category_id);

    if ($check_item_fav >= 1) {

        // failed to insert row
        $response["success"] = 0;
        if ($lang == "ar") {
            $response["message"] = "تم إضافة العنصر في المفضلة من قبل!";
        } else {
            $response["message"] = "The item has been added to favorites before";
        }
        // echoing JSON response
        echo json_encode($response);
    } else {

        $result = mysql_query("INSERT INTO client_fav(client_id,sub_category_id) VALUES('$client_id','$sub_category_id')");


        $response["product"] = array();

        // temp user array
        $product = array();
        $product["fav_id"] = mysql_insert_id();
        $product["client_id"] = $_GET["client_id"];
        $product["sub_category_id"] = $_GET["sub_category_id"];

        // push single product into final response array
        array_push($response["product"], $product);


        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["success"] = 1;
            if ($lang == "ar") {
                $response["message"] = "تم إضافة العنصر في المفضلة .";
            } else {
                $response["message"] = "Item added to favorites.";
            }

            // echoing JSON response
            echo json_encode($response);
        } else {
            // failed to insert row
            $response["success"] = 0;
            if ($lang == "ar") {
                $response["message"] = "عفوا لقد حدث خطأ.";
            } else {
                $response["message"] = "Sorry, an error has occurred";
            }
            // echoing JSON response
            echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 0;
    if ($lang == "ar") {
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    } else {
        $response["message"] = "There are missing data";
    }
    // echoing JSON response
    echo json_encode($response);
}
?>