<?php

include("../public/functions.php");
include("../public/connection.php");
if (isset($_GET['ac']) && $_GET['ac'] == 'save-order') {

    $client_id = $_COOKIE['client_id'];

    $region = trim($_POST['region_id']);
    $block = trim($_POST['block']);
    $road = trim($_POST['road']);
    $building = trim($_POST['building']);
    $flat_number = trim($_POST['flat_number']);
    $client_phone = trim($_POST['client_phone']);
    $note = trim($_POST['note']);

    $result = $con->query("INSERT INTO client_addresses(lat,lang,region,block,road,building,flat_number,client_phone,note,client_id,date) 
	VALUES('','','$region','$block','$road','$building','$flat_number','$client_phone','$note','$client_id','" . date("Y-m-d H:i:s") . "')");
    if ($result) {
        $client_address_id = mysqli_insert_id($con);
// no products found
        $response["success"] = 1;
        if ($_COOKIE['lang'] == "en") {
            $region_name = get_region_name_en($region);
        } else {
            $region_name = get_region_name($region);
        }


        $div = '<div class="row w-100 d-flex nomargin delete_' . $client_address_id . '" id="delete_' . $client_address_id . '">';
        $div .= '<input  data-id="' . $client_address_id . '" name="client_address_id" class="client_address_id custom-control-input" id="client_address_id_' . $client_address_id . '">';
        $div .= '<div class="col-sm-12 col-md-7 col-lg-7">';
        $div .=$region_name . '-' . $road . '-' . $block . ' - ' . $building . ' - ' . $flat_number;
        $div .= '<input name="client_address_id" class="client_address_id" type="checkbox" data-id="' . $client_address_id . '">';
        $div .= '<a href="javascript:;" data-remove="' . $client_address_id . '" class="remove remove-add float-left">حذف</a>';
        $div .= '</div>';
        $div .= '</div>';

        $response["message"] = $div;
    } else {
        $response["success"] = 0;
    }
// echo no clients JSON
    echo json_encode($response);

    die();
}
