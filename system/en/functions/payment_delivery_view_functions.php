<?php
function view_delivered_ways() {

    global $con;

    $query = $con->query("SELECT * FROM `delivered_way` ORDER BY `id` DESC");

    $parent_cats = array();


    while ($row = mysqli_fetch_assoc($query)) {

        array_push($parent_cats, $row);
    }

    return $parent_cats;
}


function view_payment_methods() {

    global $con;

    $query = $con->query("SELECT * FROM `payment_methods` ORDER BY `id` DESC");

    $parent_cats = array();


    while ($row = mysqli_fetch_assoc($query)) {

        array_push($parent_cats, $row);
    }

    return $parent_cats;
}

if (isset($_POST['change_cat_status_off_deliver'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_off_deliver'];

    $query = $con->query("UPDATE `delivered_way` SET `display`=0 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("تم تغيير الحالة بنجاح");
    }
}

if (isset($_POST['change_cat_status_on_deliver'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_on_deliver'];

    $query = $con->query("UPDATE `delivered_way` SET `display`=1 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("تم تغيير الحالة بنجاح");
    }
}

if (isset($_POST['change_cat_status_off_payment'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_off_payment'];

    $query = $con->query("UPDATE `payment_methods` SET `display`=0 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("تم تغيير الحالة بنجاح");
    }
}

if (isset($_POST['change_cat_status_on_payment'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_on_payment'];

    $query = $con->query("UPDATE `payment_methods` SET `display`=1 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("تم تغيير الحالة بنجاح");
    }
}




?>