<?php

include("../public/functions.php");
include("../public/connection.php");


if (isset($_POST['client_address_id']) && isset($_POST['client_address_id'])) {
    $client_address_id = $_POST['client_address_id'];
    $get_region_id = get_region_by_address_id($client_address_id);
    $get_charge = get_charge($get_region_id);

    if ($_COOKIE['lang'] == "ar") {
        $message = "سيتم إضافة تكلفة التوصيل    ";
        $message .=number_format((float) ($get_charge), 3, '.', '') . ' ' . 'دينار بحريني';
    } else {
        $message = " Charge value will be addd ";
        $message .=number_format((float) ($get_charge), 3, '.', '') . ' ' . 'BD';
    }
    $response["text"] = $message;
    $response["value"] = $get_charge;
    echo json_encode($response);
}
?>
