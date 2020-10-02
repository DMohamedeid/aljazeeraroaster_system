<?php

include("../public/functions.php");
include("../public/connection.php");


if (isset($_POST) && !empty($_POST)) {
    $client_name = trim($_POST['client_name']);
    $client_email = trim($_POST['client_email']);
    $client_phone = trim($_POST['client_phone']);
    $client_password = trim($_POST['client_password']);

    $get_client_phone = check_register($client_phone);

    if ($get_client_phone >= 1) {
        $response["success"] = 0;
        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "Phone Number is Registerd Before!";
        } else {
            $response["message"] = "عفوا،هذا الرقم غير مسجل من قبل";
        }
// echoing JSON response
        echo json_encode($response);
    } else {
        $count_c = $con->query("select count(client_id) from `clients`");
        $cnt = mysqli_fetch_array($count_c);
        $count_clients = $cnt['count(client_id)'];
        $count_clients+=1;
        $key = 'O' . $count_clients;
        $result = $con->query("INSERT INTO clients(client_name,client_email,client_phone,client_password,client_verify,date) VALUES('$client_name','$client_email','$client_phone','$client_password','1','" . date("Y-m-d H:i:s") . "')");
        $client_id = mysqli_insert_id($con);
        $client_name=get_client_name_from_id($client_id);
        setcookie("client_id", '', time() - 3600, '/');
        setcookie("client_password", '', time() - 3600, '/');
        setcookie("client_name", $client_name, time() + 60 * 60 * 24 * 2, '/');
        setcookie("client_id", $client_id, time() + 60 * 60 * 24 * 2, '/');
        setcookie("client_password", $client_password, time() + 60 * 60 * 24 * 2, '/');
        $response["success"] = 1;
        echo json_encode($response);

        //        echo "<meta http-equiv='refresh' content='0'>";
    }
//    print_r("<pre>");
//    print_r($_COOKIE);
//    print_r("<pre>");
    exit();
}
?>
