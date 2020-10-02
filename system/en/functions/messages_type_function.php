<?php

function add_messages_type($title,$title_ar) {
    global $con;
    $con->query("INSERT INTO `messages_type` VALUES (Null,'$title','$title_ar','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}

// Get Parent Categories Name And ID
function messages_type_name($messages_type_id) {

    global $con;

    $queryB = $con->query("SELECT * FROM `messages_type` WHERE `id`='$messages_type_id' ORDER BY `id` ASC limit 1");
    $row_select = mysqli_fetch_array($queryB);
    $title = $row_select['title'];
    return $title;
}

function messages_type_count() {

    global $con;

    $query = $con->query("SELECT * FROM `messages_type` ORDER BY `id` ASC");

    $messages_type_count = mysqli_num_rows($query);

    return $messages_type_count;
}

function view_messages_type() {

    global $con;

    $query = $con->query("SELECT * FROM `messages_type` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $title = $row['title'];
        $title_ar = $row['title_ar'];

        $date = $row['date'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $title_ar; ?></td>

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="message_type_edit.php?messages_type_id=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_messages_type_id'])) {

    include("../connection.php");

    $messages_type_id = $_POST['delete_messages_type_id'];
    $query = $con->query("DELETE FROM `messages_type` WHERE `id`='$messages_type_id'");

    if ($query) {
        echo get_success(" Deleted Successfully");
    }
}
?>
