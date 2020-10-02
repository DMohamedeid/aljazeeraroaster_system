<?php

function user_exists($userEmail) {

    global $con;

    $query = $con->query("SELECT 1 FROM `users` WHERE `user_email`='$userEmail' LIMIT 1");

    return (mysqli_num_rows($query) == 1) ? true : false;
}

function add_user($orders, $users, $clients, $statics, $problems, $comments, $reports, $about, $regions, $messages, $dishs, $adds_and_removes, $cat_and_sub, $userName, $userEmail, $userPassword, $userPhone, $userType, $userImage, $date_added) {
    global $con;
    $con->query("INSERT INTO `users` VALUES (Null,'$userName','$userPassword','$userEmail','$userPhone','$userImage','$userType','$orders','$users','$clients', '$statics', '$problems', '$comments', '$reports', '$about', '$regions', '$messages', '$dishs', '$adds_and_removes', '$cat_and_sub', '$date_added')");

    return mysqli_insert_id($con);
}

function user_count() {

    global $con;

    $query = $con->query("SELECT * FROM `users` ORDER BY `user_id` ASC");

    $user_count = mysqli_num_rows($query);

    return $user_count;
}

function view_users() {

    global $con;

    $query = $con->query("SELECT * FROM `users` ORDER BY `user_id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_email = $row['user_email'];
        $user_phone = $row['user_phone'];
        $user_type = $row['user_type'];
        $user_image = $row['user_image'];
        $date = $row['date_added'];
        $get_image_ext = explode('.', $user_image);
        $image_ext = strtolower(end($get_image_ext));
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $user_name; ?></td>
            <td><?php echo $user_email; ?></td>
            <td><?php echo $user_phone; ?></td>

            <td>
                <a href="../uploads/users/<?php echo $user_id; ?>" class="image-popup" title="<?php echo $user_name; ?>">
                    <img src="../uploads/users/<?php echo $user_id . '.' . $image_ext; ?>" class="thumb-img" alt="<?php echo $user_name; ?>" height="100" style="width:100px;">
                </a>			
            </td>
            <td>
                <?php
                if ($user_type == 1) {
                    echo "Manager";
                } else {
                    echo "User";
                }
                ?>
            </td>
            <td>
                <?php
                echo $date;
                ?>

            </td>
            <td class="actions">
                <a href="user_edit.php?userID=<?php echo $user_id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $user_id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['user_id'])) {

    include("../connection.php");

    $user_id = $_POST['user_id'];
    $query = $con->query("DELETE FROM `users` WHERE `user_id`='$user_id' ");
    if ($query) {
        $img_path = dirname(__FILE__) . "/../uploads/users/" . $user_id . '.jpg';
        $img_path_thumb = dirname(__FILE__) . "/../uploads/users/thumbs/" . $user_id . '.jpg';
        if (file_exists($img_path)) {
            unlink($img_path);
        }
        if (file_exists($img_path_thumb)) {
            unlink($img_path_thumb);
        }
        echo get_success("Deleted Successfully  ");
    }
}
?>
