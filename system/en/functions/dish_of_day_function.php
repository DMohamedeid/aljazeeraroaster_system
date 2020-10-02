<?php

function dish_exists($show_date) {

    global $con;

    $query = $con->query("SELECT 1 FROM `dish_of_day` WHERE `show_date`='$show_date'  LIMIT 1");

    return (mysqli_num_rows($query) == 1) ? true : false;
}

function getDishById($dish_id) {

    global $con;

    $query = $con->query("SELECT * FROM `dish_of_day` WHERE `id`='$dish_id' LIMIT 1");
    $row_select = mysqli_fetch_array($query);
    $show_date = $row_select['show_date'];
    return $show_date;
}

function add_dish_of_day($parent_category_id, $sub_category_id, $show_date, $dish_image) {
    global $con;
    $con->query("INSERT INTO `dish_of_day` VALUES (Null,'$parent_category_id','$sub_category_id','$dish_image','$show_date','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}

function view_dish_of_day() {

    global $con;

    $query = $con->query("SELECT * FROM `dish_of_day` ORDER BY `id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $parent_category_id = $row['parent_category_id'];
        $sub_category_id = $row['sub_category_id'];
        $show_date = $row['show_date'];
        $image = $row['image'];
        $date = $row['date'];
        $get_image_ext = explode('.', $image);
        $image_ext = strtolower(end($get_image_ext));
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo parent_category_name($parent_category_id); ?></td>
            <td><?php echo $show_date; ?></td>
            <td>
                <a href="<?php echo $image; ?>" class="image-popup" title="image">
                    <img src="<?php echo $image; ?>" class="thumb-img" alt="image" height="100" style="width:100px;">
                </a>			
            </td>
            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="dish_of_day_edit.php?dish_of_day_id=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_dish_of_day_id'])) {

    include("../connection.php");

    $dish_of_day_id = $_POST['delete_dish_of_day_id'];

    $querya = $con->query("SELECT * FROM `dish_of_day` WHERE `id`='$dish_of_day_id' limit 1");

    $row_select = mysqli_fetch_array($querya);

    $dish_of_day_image = $row_select['image'];

    $mostafa = explode('/', $dish_of_day_image);

    $image_name = $mostafa[8];

    $full_img_path = dirname(__FILE__) . "/../../api/uploads/dish/{$dish_of_day_id}/{$image_name}";

    $folder_full_img_path = dirname(_FILE_) . "/../../api/uploads/dish/{$dish_of_day_id}";

    if (file_exists($full_img_path)) {
        @unlink($full_img_path);
    }

    rmdir($folder_full_img_path);

    $query = $con->query("DELETE FROM `dish_of_day` WHERE `id`='$dish_of_day_id'");

    if ($query) {
        echo get_success("Deleted Successfully");
    }
}
?>
