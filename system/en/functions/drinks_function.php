<?php

function add_drinks($title_ar, $title_en, $price,$price_sar) {
    global $con;
    $con->query("INSERT INTO `drinks` VALUES (Null,'$title_ar','$title_en','$price','$price_sar','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}



function drinks_count() {

    global $con;

    $query = $con->query("SELECT * FROM `drinks` ORDER BY `id` ASC");

    $drinks_count = mysqli_num_rows($query);

    return $drinks_count;
}

function view_drinks() {

    global $con;

    $query = $con->query("SELECT * FROM `drinks` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $title_en = $row['title_en'];
        $title_ar = $row['title_ar'];
        $price = $row['price'];
        $date = $row['date'];
        $price_sar = $row['price_sar'];

        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $title_en; ?></td>
            <td><?php echo $title_ar; ?></td>
            <td><?php echo $price; ?> B.D</td>
            <td><?php echo $price_sar; ?> SAR</td>

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="drinks_edit.php?drinks_id=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_drinks_id'])) {

    include("../connection.php");

    $drinks_id = $_POST['delete_drinks_id'];
    $query = $con->query("DELETE FROM `drinks` WHERE `id`='$drinks_id'");

    if ($query) {
        echo get_success("Deleted Successfully  ");
    }
}
?>
