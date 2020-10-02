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
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $Req = json_decode($postdata, TRUE);

    $client_id = $Req['client_id'];
    $content = $Req['content'];
    $complaint_id = $Req['complaint_id'];
    $message_type_id = $Req['message_type_id'];

    $result = mysql_query("INSERT INTO messages(message_type_id,content,client_id,complaint_id,type,is_read,date) 
	VALUES('$message_type_id','$content','$client_id','$complaint_id','1','0','" . date("Y-m-d H:i:s") . "')");
    $message_id = mysql_insert_id();


    $response["product"] = array();
    $arr_mess = array();
    $product = array();

    $complaint_result = mysql_query("SELECT * FROM `complaints` WHERE `id`='$complaint_id' ORDER BY `id` DESC limit 1") or die(mysql_error());
    $complaint_row = mysql_fetch_array($complaint_result);

    $product["title"] = $complaint_row['title'];
    $product["content"] = $complaint_row['content'];
    $product["date"] = $complaint_row['date'];
    $product["type"] = "1";

    array_push($arr_mess, $product);

    $result_2 = mysql_query("SELECT * FROM `messages` WHERE `complaint_id`='$complaint_id' order by `id` ASC") or die(mysql_error());
    while ($row_2 = mysql_fetch_array($result_2)) {

        $messages = array();

        $messages["content"] = $row_2["content"];
        $messages["is_read"] = $row_2["is_read"];
        $messages["type"] = $row_2["type"];
        $messages["date"] = $row_2["date"];


        array_push($arr_mess, $messages);
    }

    $product["messages"] = $arr_mess;
    $product["message_id"] = $message_id;
    array_push($response["product"], $product);


    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Successfully Added.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "عفوا لقد حدث خطأ";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echoing JSON response
    echo json_encode($response);
}
?>