<?php

function سadd_parent_cat($arrangement, $parent_cat_name_ar, $parent_cat_desc_ar, $parent_cat_name, $parent_cat_desc, $parent_cat_photo_name, $display) {

    global $con;

    $con->query("INSERT INTO `parent_categories` VALUES (null,'$parent_cat_name','$parent_cat_desc','$parent_cat_name_ar','$parent_cat_desc_ar','$parent_cat_photo_name','$display','$arrangement','" . date("Y-m-d H:i:s") . "')");

    return mysqli_insert_id($con);
}

function parent_categories_count($get) {

    global $con;

    $sql = " SELECT * FROM `parent_categories` where 1=1  ";
    // echo $sql;
    $query = $con->query($sql);

    $sub_category_count = mysqli_num_rows($query);

    return $sub_category_count;
}

function view_parent_categories($aStart = 0, $aLimit = 0, $get) {

    global $con;
    $sub_categories = array();
    $sql = " SELECT * FROM `parent_categories` where 1=1  ";

    $sql.= " ORDER BY `parent_category_id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($sub_categories, $row);

        $x++;
    }
    return $sub_categories;
}

function get_parent_cat_by_id($id) {

    global $con;

    $query = $con->query("SELECT * FROM `parent_categories` WHERE  `parent_category_id`='$id' ");

    $row = mysqli_fetch_assoc($query);

    return $row;
}

function parent_cat_count() {

    global $con;

    $query = $con->query("SELECT * FROM `parent_categories` ORDER BY `parent_category_id` ASC");

    $parent_cat_count = mysqli_num_rows($query);

    return $parent_cat_count;
}

if (isset($_POST['category'])) {

    include("../connection.php");

    $parent_category_id = $_POST['category'];


    $querya = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' limit 1");
    $row_select = mysqli_fetch_array($querya);

    $parent_category_image = $row_select['parent_category_image'];

    $mostafa = explode('/', $parent_category_image);

    $image_name = $mostafa[8];

    $full_img_path = dirname(__FILE__) . "/../../api/uploads/parent_category/{$parent_category_id}/{$image_name}";

    $folder_full_img_path = dirname(__FILE__) . "/../../api/uploads/parent_category/{$parent_category_id}";

    if (file_exists($full_img_path)) {
        @unlink($full_img_path);
    }

    rmdir($folder_full_img_path);

    $query = $con->query("DELETE FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id'");

    $queryb = $con->query("SELECT * FROM `sub_categories` where `parent_category_id` ='$parent_category_id'");

    while ($row = mysqli_fetch_assoc($queryb)) {


        $sub_category_id = $row['sub_category_id'];

        $sub_category_image = $row['sub_category_image'];

        $mostafa = explode('/', $sub_category_image);

        $image_name = $mostafa[8];

        $full_img_path = dirname(__FILE__) . "/../../api/uploads/sub_category/{$sub_category_id}/{$image_name}";

        $folder_full_img_path = dirname(__FILE__) . "/../../api/uploads/sub_category/{$sub_category_id}";

        if (file_exists($full_img_path)) {
            @unlink($full_img_path);
        }

        rmdir($folder_full_img_path);

        $query_three = $con->query("DELETE FROM `milk` WHERE `id`='$parent_category_id'");
        $query_three = $con->query("DELETE FROM `shot` WHERE `id`='$parent_category_id'");
        $query_three = $con->query("DELETE FROM `sweetness` WHERE `id`='$parent_category_id'");

        $queryc = $con->query("DELETE FROM `sub_categories_size_prices` WHERE `sub_category_id`='" . $row['sub_category_id'] . "'");
    }
    $query_two = $con->query("DELETE FROM `sub_categories` WHERE `parent_category_id`='$category'");

    if ($query) {

        echo get_success("Deleted Successfully");
    }
}

function parent_category_arrange_exists($arrange) {

    global $con;

    $query = $con->query("SELECT 1 FROM `parent_categories` WHERE `arrangement`='$arrange' LIMIT 1");

    return (mysqli_num_rows($query) == 1) ? true : false;
}

function getArrangeById($parent_category_id) {

    global $con;

    $query = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' LIMIT 1");
    $row_select = mysqli_fetch_array($query);

    $arrangement = $row_select['arrangement'];
    return $arrangement;
}

if (isset($_POST['change_cat_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_on'];

    $query = $con->query("UPDATE `parent_categories` SET `display`=1 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_cat_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_off'];

    $query = $con->query("UPDATE `parent_categories` SET `display`=0 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_milk_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_milk_status_on'];

    $query = $con->query("UPDATE `parent_categories` SET `milk`=1 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_milk_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_milk_status_off'];

    $query = $con->query("UPDATE `parent_categories` SET `milk`=0 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}

if (isset($_POST['change_shot_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_shot_status_on'];

    $query = $con->query("UPDATE `parent_categories` SET `shot`=1 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_shot_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_shot_status_off'];

    $query = $con->query("UPDATE `parent_categories` SET `shot`=0 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_sweetness_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_sweetness_status_on'];

    $query = $con->query("UPDATE `parent_categories` SET `sweetness`=1 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_sweetness_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_sweetness_status_off'];

    $query = $con->query("UPDATE `parent_categories` SET `sweetness`=0 WHERE `parent_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
?>