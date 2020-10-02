<?php

if (isset($_POST['change_setting_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_setting_status_on'];

    $query = $con->query("UPDATE `setting` SET `accept_orders`=1 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("تم تغيير الحالة بنجاح");
    }
}
if (isset($_POST['change_setting_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_setting_status_off'];

    $query = $con->query("UPDATE `setting` SET `accept_orders`=0 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}

function view_contacts($aStart = 0, $aLimit = 0, $get) {

    global $con;
    $contacts = array();

    $sql = " SELECT * FROM `client_contact` where 1=1";
    if (isset($get['client_name']) && $get['client_name'] != '') {
        $sql .= " and `client_contact`.`name` LIKE '%{$get['client_name']}%'  ";
    }
    if (isset($get['client_phone']) && $get['client_phone'] != '') {
        $sql .= " and `client_contact`.`phone_number` = {$get['client_phone']} ";
    }
    $sql.= " ORDER BY `id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        $row['x'] = $x;
        array_push($contacts, $row);
        $x++;
    }
    return $contacts;
}

function current_contacts_count($get) {

    global $con;
    $sql = " SELECT * FROM `client_contact` where 1=1";
    if (isset($get['client_name']) && $get['client_name'] != '') {
        $sql .= " and `client_contact`.`name` LIKE '%{$get['client_name']}%'  ";
    }
    if (isset($get['client_phone']) && $get['client_phone'] != '') {
        $sql .= " and `client_contact`.`phone_number` = {$get['client_phone']} ";
    }
    $query = $con->query($sql);

    $contacts_count = mysqli_num_rows($query);

    return $contacts_count;
}

?>