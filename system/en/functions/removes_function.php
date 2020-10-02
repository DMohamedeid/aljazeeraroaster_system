<?php

function add_removes($title,$title_ar,$parent_category_id) {
    global $con;
    $con->query("INSERT INTO `removes` VALUES (Null,'$title','$title_ar','$parent_category_id','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}

function removes_count() {

    global $con;

    $query = $con->query("SELECT * FROM `removes` ORDER BY `id` ASC");

    $removes_count = mysqli_num_rows($query);

    return $removes_count;
}

function view_parent_category_removes() {

    global $con;
    if (isset($_SESSION['branch_id']) && $_SESSION['branch_id'] != '') {
    $query = $con->query("SELECT removes.* FROM `removes` left join parent_categories on parent_categories.parent_category_id=removes.id where parent_categories.branch_id='" . $_SESSION['branch_id'] . "'    ORDER BY parent_categories.parent_category_id ASC");
    }else{
    $query = $con->query("SELECT removes.* FROM `removes` left join parent_categories on parent_categories.parent_category_id=removes.id    ORDER BY parent_categories.parent_category_id ASC");
    }
    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $title_ar = $row['title_ar'];
        $parent_category_id = $row['parent_category_id'];
        $branch_id=get_branch_from_parent_category($parent_cat_id);
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo branchesName($branch_id); ?></td>
            <td><?php echo parent_category_name($parent_category_id); ?></td>

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="remove_view.php?parent_category_id=<?php echo $parent_category_id; ?>" class="on-default"><i class="fa fa-eye"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}
function view_removes($get) {

    global $con;

    $query = $con->query("SELECT * FROM `removes` where `parent_category_id`='{$get['parent_category_id']}' ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $title_ar = $row['title_ar'];
        $parent_category_id = $row['parent_category_id'];
        $title = $row['title'];
        $date = $row['date'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $title; ?></td>

            <td><?php echo $title_ar; ?></td>
            <td><?php echo parent_category_name($parent_category_id); ?></td>

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="remove_edit.php?removeID=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_removes_id'])) {

    include("../connection.php");

    $removes_id = $_POST['delete_removes_id'];
    $query = $con->query("DELETE FROM `removes` WHERE `id`='$removes_id'");

    if ($query) {
        echo get_success("Deleted Successfully");
    }
}
?>
