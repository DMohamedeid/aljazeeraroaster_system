<?php

function add_latest($product_id,$parent_cat_id) {

    global $con;

    $con->query("INSERT INTO `latest` VALUES (null,'$product_id','$parent_cat_id','" . date("Y-m-d H:i:s") . "')");

    return mysqli_insert_id($con);
}

function view_latest() {

    global $con;

    $query = $con->query("SELECT * FROM `latest` ORDER BY `id` DESC");

    while ($row = mysqli_fetch_assoc($query)) {

        $latest_id = $row['id'];
        $product_id = $row['product_id'];
        $date = $row['date_added'];
        $parent_category_id=$row['parent_category_id'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><a href="products_view.php?product_id=<?php echo $product_id; ?>"><?php echo sub_category_data($product_id)["sub_category_name"]; ?></a></td>
            <td> <?php echo get_parent_cat_by_id($parent_category_id)['parent_category_name']; ?></td>
            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="latest_edit.php?latestId=<?php echo $latest_id ?>" class=""><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $latest_id; ?>"  class="on-default remove-row" id="deleteParent"><i class="fa fa-trash-o"></i></a>

            </td>
        </tr>
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_latest'])) {

    include("../connection.php");

    $latest_id = $_POST['delete_latest'];

    $query = $con->query("DELETE FROM `latest` WHERE `id`='$latest_id'");


    if ($query) {

        echo get_success("تم الحذف بنجاح");
    }
}
?>