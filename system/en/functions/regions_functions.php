<?php



function getRegionDataById($id){
    
    global $con;
    $query = $con->query("SELECT * FROM `regions` WHERE `region_id`='$id' LIMIT 1");
    $row_select = mysqli_fetch_assoc($query);
    return $row_select;
}

if (isset($_POST['change_setting_status_on'])){
    include("../connection.php");
    $change_status = $_POST['change_setting_status_on'];
    $query = $con->query("UPDATE `setting` SET `close_charge`=1 WHERE `id`='$change_status'");
    $con->query("UPDATE `regions` SET `transfer_charge`=`charge` ");
    $con->query("UPDATE `regions` SET `charge`=0 ");
    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_setting_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_setting_status_off'];

    $query = $con->query("UPDATE `setting` SET `close_charge`=0 WHERE `id`='$change_status'");
    $con->query("UPDATE `regions` SET `charge`=`transfer_charge` ");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}

// Add Sub Category
function add_region($charge, $min_order, $region_name_ar, $display, $region_name_en, $order_period) {

    global $con;

    $con->query("INSERT INTO `regions` VALUES (null,'$region_name_ar','$region_name_en','$charge','0','$min_order','$order_period','$display')");
    return mysqli_insert_id($con);
}

function region_exists($region_name, $lang) {

    global $con;

    $query = $con->query("SELECT 1 FROM `regions` WHERE `$lang`='$region_name' LIMIT 1");

    return (mysqli_num_rows($query) == 1) ? true : false;
}

function get_region_id($client_id, $client_address_id) {

    global $con;

    $query = $con->query("SELECT * FROM `client_addresses` WHERE `client_address_id`='$client_address_id' and `client_id`='$client_id' ORDER BY `client_address_id` DESC");
    $row_select = mysqli_fetch_array($query);

    $region = $row_select['region'];
    return $region;
}

function getRegionName($regionID) {

    global $con;

    $query = $con->query("SELECT * FROM `regions` WHERE `region_id`='$regionID' LIMIT 1");
    $row_select = mysqli_fetch_array($query);

    $region_name_ar = $row_select['region_name_ar'];
    return $region_name_ar;
}

function getRegionId($regionID) {

    global $con;

    $query = $con->query("SELECT * FROM `regions` WHERE `region_id`='$regionID' LIMIT 1");
    $row_select = mysqli_fetch_array($query);

    $region_name_ar = $row_select['region_name_ar'];
    return array($region_name_ar);
}

function getChargeRegionId($regionID) {

    global $con;

    $query = $con->query("SELECT * FROM `regions` WHERE `region_id`='$regionID' LIMIT 1");
    $row_select = mysqli_fetch_array($query);

    $charge = $row_select['charge'];
    return $charge;
}

//Delete Sub Category By Sub Category ID
if (isset($_POST['region_delete'])) {

    include("../connection.php");

    $region_id = $_POST['region_delete'];
    $query = $con->query("DELETE FROM `regions` WHERE `region_id`='$region_id'");
    if ($query) {
        echo get_success("Deleted Successfully");
    }
}

function regions_count() {

    global $con;

    $query = $con->query("SELECT * FROM `regions` ORDER BY `region_id` ASC");

    $regions_count = mysqli_num_rows($query);

    return $regions_count;
}

// View Sub Category Table
function view_regions() {

    global $con;
    $regions = array();

    $query = $con->query("SELECT * FROM `regions` ORDER BY `region_id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $region_id = $row['region_id'];
        $region_name_ar = $row['region_name_ar'];
        $charge = $row['charge'];
        $min_order = $row['min_order'];


        $x++;
        array_push($regions, $row);
    }

    return $regions;
}

if (isset($_POST['change_region_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_region_status_on'];

    $query = $con->query("UPDATE `regions` SET `display`=1 WHERE `region_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_region_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_region_status_off'];

    $query = $con->query("UPDATE `regions` SET `display`=0 WHERE `region_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
?>