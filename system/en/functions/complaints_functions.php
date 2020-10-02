<?php

function add_message($temp) {
    global $con;
    $con->query("INSERT INTO `messages` VALUES (null,'" . $temp['message_type_id'] . "','" . $temp['content'] . "','','','0','0','" . date("Y-m-d H:i:s") . "')");

    return mysqli_insert_id($con);
}

if (isset($_POST['complaint_delete'])) {

    include("../connection.php");

    $complaint_id = $_POST['complaint_delete'];
    $query = $con->query("DELETE FROM `complaints` WHERE `id`='$complaint_id'");
    if ($query) {
        echo get_success("Deleted Successfully  ");
    }
}
if (isset($_POST['message_delete'])) {

    include("../connection.php");

    $message_id = $_POST['message_delete'];
    $query = $con->query("DELETE FROM `messages` WHERE `id`='$message_id'");
    if ($query) {
        echo get_success("Deleted Successfully  ");
    }
}

function reply_complaints_count($complaint_id) {

    global $con;

    $query = $con->query("SELECT * FROM `messages`  where `complaint_id`='$complaint_id'");

    $messages_count = mysqli_num_rows($query);

    return $messages_count;
}

// View Sub Category Table
function view_messages() {

    global $con;

    $query = $con->query("SELECT * FROM `messages` ORDER BY `id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $messages_id = $row['id'];
        $complaint_id = $row['complaint_id'];
        $message_type_id = $row['message_type_id'];
        $date = $row['date'];
        $type = $row['type'];
        $content = $row['content'];
        $is_read = $row['is_read'];
        $client_id = $row['client_id'];

        $client_name = clientName($client_id);
        $messages_type_name = messages_type_name($message_type_id);
        ?>
        <tr class="gradeX <?php echo $messages_id; ?>">
            <td><?php echo $x; ?></td>
            <td><?php
                echo $messages_type_name;
                ?>
            </td>
            <td><?php
                echo $content;
                ?>
            </td>
            <td><?php
                if ($type == 0) {
                    echo "sent";
                } else {
                    echo "<span style='color:red'>received   </span>";
                }
                ?>
            </td>
            <td><?php
                if ($is_read == 0 && $type == 1) {
                    echo "<span style='color:red'>Not Read   </span>";
                } elseif ($is_read == 1 && $type == 1) {
                    echo "Read";
                } else {
                    
                }
                ?>
            </td>
            <td><?php echo $date; ?></td>
            <td><?php
                if ($client_id == '') {
                    echo "All";
                } else {
                    echo $client_name;
                }
                ?>
            </td>
            <td class="actions">
                <a href="message_details.php?messages_id=<?php echo $messages_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
            </td>
            <td class="actions">
                <a href="javascript:;" data-id="<?php echo $messages_id; ?>" class="deletemsg" id="deleteParent"><i class="fa fa-trash-o"></i></a>
            </td>

        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

// View Sub Category Table
function view_complaints() {

    global $con;

    $query = $con->query("SELECT * FROM `complaints` ORDER BY `id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $complaint_id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $client_id = $row['client_id'];
        $client_name = clientName($client_id);
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $client_name; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php
                if (reply_complaints_count($complaint_id) > 0) {
                    echo "Replied ";
                } else {
                    echo "<span style='color:red'>No Reply  </span>";
                }
                ?></td>
            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="complaints_details.php?complaintId=<?php echo $complaint_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
            </td>

            <td class="actions">
                <a href="javascript:;" data-id="<?php echo $complaint_id; ?>" data-client="<?php echo $client_id; ?>" class="sendmsg" id="sendParent"><i class="fa fa-send"></i></a>
            </td>

        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}
?>