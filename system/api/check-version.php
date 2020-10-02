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
$Req = json_decode($postdata, TRUE);

if (isset($Req) && !empty($Req)) {
    $mobile_type = $Req['mobile_type'];
    $version = $Req['version'];
    $lang = $Req['lang'];

    $result = mysql_query("SELECT * FROM `setting` where `id`=1") or die(mysql_error());

    $row = mysql_fetch_array($result);

    $ios_version = $row['ios_version'];
    $android_version = $row['android_version'];

    if ($mobile_type == "ios") {
        if ($version == $ios_version) {
            $response["success"] = 1;
            if ($lang == "ar") {
                $response["message"] = "اخر تحديث";
            } else {
                $response["message"] = "last version ";
            }
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            if ($lang == "ar") {
                $response["message"] = "Please update the app and make sure that you have the latest version";
            } else {
                $response["message"] = "برجاء تحديث التطبيق والتأكد من تحميل آخر إصدار";
            }
            echo json_encode($response);
        }
    } elseif ($mobile_type == "ios") {
        if ($version == $android_version) {
            $response["success"] = 1;
            if ($lang == "ar") {
                $response["message"] = "اخر تحديث";
            } else {
                $response["message"] = "last version ";
            }
            echo json_encode($response);
        } else {
            $response["success"] = 0;
            if ($lang == "ar") {
                $response["message"] = "Please update the app and make sure that you have the latest version";
            } else {
                $response["message"] = "برجاء تحديث التطبيق والتأكد من تحميل آخر إصدار";
            }
            echo json_encode($response);
        }
    } else {

        // required field is missing
        $response["success"] = 0;
        $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

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