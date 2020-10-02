<?php

include("../public/functions.php");
include("../public/connection.php");


if (isset($_POST['sub_category_id']) && isset($_POST['sub_category_id'])) {
    $sub_category_id = $_POST['sub_category_id'];
    $count_sizes = count_sizes($sub_category_id);
    $get_size_id = get_size_id($sub_category_id);

    $response["count"] = $count_sizes;
    $response["size_id"] = $get_size_id;



    echo json_encode($response);
}
?>
