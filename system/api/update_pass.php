<?php
// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$required_parametrs = array("lang", "phone", "password");
$errors = array();


$postdata = file_get_contents("php://input");
$Req = json_decode($postdata, TRUE);


foreach ($Req as $key => $value) {
    if (in_array($key, $required_parametrs)) {
        $key = array_search($key, $required_parametrs);
        unset($required_parametrs[$key]);
    } else {
        $errors[] = "Parameter field is required:";
    }
}

if (count($required_parametrs) > 0) {
    //some parameters required
    $response["success"] = 0;
    if ($lang == "ar") {
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
    } else {
        $response["message"] = "error in inputs";
    }

    $response["required_parameters"] = $required_parametrs;
} else {


    $lang = trim($Req['lang']);

    $phone = trim($Req['phone']);

    $password = trim($Req['password']);


//   ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


    $query_insert = mysql_query("UPDATE `clients` SET `client_password`='$password' WHERE `client_phone`='$phone'  ");

    if ($query_insert) {

        $response["success"] = 1;
        if ($lang == "ar") {
            $response["message"] = "تم  التحديث";
        } else {
            $response["message"] = "Updated successfully";
        }
    } else {

        $response["success"] = 0;
        if ($lang == "ar") {
            $response["message"] = "خطأ في الأدخال";
        } else {
            $response["message"] = "error in insert";
        }
    }
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
