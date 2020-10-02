<?php
if (isset($_POST['change_setting_status_off'])) {

    include("../connection.php");

    $branche_id = $_POST['change_setting_status_off'];

    $query = $con->query("UPDATE `branches` SET `branch_show`=0 WHERE `id`='$branche_id'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_setting_status_on'])) {

    include("../connection.php");

    $branche_id = $_POST['change_setting_status_on'];
    $query = $con->query("UPDATE `branches` SET `branch_show`=1 WHERE `id`='$branche_id'");
    if ($query) {
        echo get_success("Status changed successfully");
    }
}
function add_branches($name, $name_ar,$show) {
    global $con;
    $con->query("INSERT INTO `branches` VALUES (Null,'$name','$name_ar','0','$show','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}

function branchesName($branche_id) {

    global $con;

    $query_select = $con->query("SELECT * FROM `branches` WHERE `id`='$branche_id' ORDER BY `id` LIMIT 1 ");
    $row_select = mysqli_fetch_array($query_select);
    $name = $row_select['name'];
    return $name;
}

function branches_count() {

    global $con;

    $query = $con->query("SELECT * FROM `branches` ORDER BY `id` ASC");

    $branches_count = mysqli_num_rows($query);

    return $branches_count;
}

function view_branches() {

    global $con;

    $query = $con->query("SELECT * FROM `branches` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query )) {
        $id = $row['id'];
        $name = $row['name'];
        $name_ar = $row['name_ar'];
        $date = $row['date'];
        $display = $row['display'];
        $branch_show=$row['branch_show']
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><a href="branches_regions_view.php?branch_id=<?php echo $id ;?>"><?php echo $name; ?></a></td>
            <td><a href="branches_regions_view.php?branch_id=<?php echo $id ;?>"><?php echo $name_ar; ?></a></td>
            <td>
                                                        <?php if ($display == 1) { ?>
                                                            <input class="change_cat_status_off" data-id="<?php echo $id; ?>" type="checkbox" 
                                                                   checked
                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php } else if ($display == 0) {
                                                                   ?>
                                                            <input class="change_cat_status_on" data-id="<?php echo $id; ?>" type="checkbox" 

                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php }
                                                               ?>

            </td>   
            <td>
                                                        <?php if ($branch_show == 1) { ?>
                                                            <input class="change_cat_status_off_show" data-id="<?php echo $id; ?>" type="checkbox" 
                                                                   checked
                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php } else if ($branch_show == 0) {
                                                                   ?>
                                                            <input class="change_cat_status_on_show" data-id="<?php echo $id; ?>" type="checkbox" 

                                                                   data-plugin="switchery" data-color="#81c868"/>
                                                               <?php }
                                                               ?>

            </td>     

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="branches_edit.php?brancheID=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_branches_id'])) {

    include("../connection.php");

    $branches_id = $_POST['delete_branches_id'];
    $query = $con->query("DELETE FROM `branches` WHERE `id`='$branches_id'");

    if ($query) {
        echo get_success("Deleted Successfully  ");
    }
}






if (isset($_POST['change_cat_status_on_show'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_on_show'];

    $query = $con->query("UPDATE `branches` SET `branch_show`=1 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("  تم تغيير الحالة بنجاح");
    }
}

if (isset($_POST['change_cat_status_off_show'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_off_show'];

    $query = $con->query("UPDATE `branches` SET `branch_show`=0 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("  تم تغيير الحالة بنجاح");
    }
}











if (isset($_POST['change_cat_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_on'];

    $query = $con->query("UPDATE `branches` SET `display`=1 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_cat_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_cat_status_off'];

    $query = $con->query("UPDATE `branches` SET `display`=0 WHERE `id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
?>
