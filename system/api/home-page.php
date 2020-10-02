<?php
$response = array();

//header('Content-type: text/html');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// include db connect class
include("db_connect.php");
// connecting to db
$db = new DB_CONNECT();
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");
if (isset($_GET['lang']) && $_GET['lang'] != '') {

    $lang = $_GET['lang'];
    $response["success"] = 1;
    $response["slider"]=get_slider(); 
    $response["latest"]=get_latest_products($lang); 

} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
}

// echoing JSON response
echo json_encode($response);

?>