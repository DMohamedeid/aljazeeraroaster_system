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

mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");


// get all products from products table

if (isset($_GET['client_id'])) {

    $client_id = $_GET['client_id'];

    $result = mysql_query("SELECT * FROM `complaints` WHERE `client_id`='$client_id' ORDER BY `id` DESC ") or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node

        $response["product"] = array();

        while ($row = mysql_fetch_array($result)) {

            $product = array();
            $arr_mess = array();


            $product["complaint_id"] = $row['id'];
            $complaint_id = $row['id'];
            $product["content"] = $row['content'];
            $product["title"] = $row['title'];

            $product["date"] = $row['date'];
            $product["type"] = "1";

            array_push($arr_mess, $product);

            $result_2 = mysql_query("SELECT * FROM `messages` WHERE `complaint_id`='$complaint_id' order by `id` ASC") or die(mysql_error());
            while ($row_2 = mysql_fetch_array($result_2)) {

                $messages = array();

                $messages["content"] = $row_2["content"];
                $messages["is_read"] = $row_2["is_read"];
                $messages["date"] = $row_2["date"];
                $messages["type"] = $row_2["type"];


                array_push($arr_mess, $messages);
            }
            $product["messages"] = $arr_mess;

            array_push($response["product"], $product);
        }

        $response["success"] = 1;
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