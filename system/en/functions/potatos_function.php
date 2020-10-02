<?php

function add_potatos($title_ar, $title_en, $price,$price_sar) {
    global $con;
    $con->query("INSERT INTO `potatos` VALUES (Null,'$title_ar','$title_en','$price','$price_sar','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}

// Get Parent Categories Name And ID


function potatos_count() {

    global $con;

    $query = $con->query("SELECT * FROM `potatos` ORDER BY `id` ASC");

    $potatos_count = mysqli_num_rows($query);

    return $potatos_count;
}

function view_potatos() {

    global $con;

    $query = $con->query("SELECT * FROM `potatos` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $title_en = $row['title_en'];
        $title_ar = $row['title_ar'];
        $price = $row['price'];
        $price_sar = $row['price_sar'];

        $date = $row['date'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $title_en; ?></td>
            <td><?php echo $title_ar; ?></td>
            <td><?php echo $price; ?> B.D</td>
            <td><?php echo $price_sar; ?> SAR</td>

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="potatos_edit.php?potatos_id=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_potatos_id'])) {

    include("../connection.php");

    $potatos_id = $_POST['delete_potatos_id'];
    $query = $con->query("DELETE FROM `potatos` WHERE `id`='$potatos_id'");

    if ($query) {
        echo get_success(" Deleted Successfully ");
    }
}
?>
