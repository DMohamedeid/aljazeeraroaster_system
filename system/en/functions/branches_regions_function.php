<?php

function branches_region_exists($region_id) {

    global $con;

    $query = $con->query("SELECT 1 FROM `branches_regions` WHERE `region_id`='$region_id' LIMIT 1");

    return (mysqli_num_rows($query) == 1) ? true : false;
}

function getBrancheRegionId($BrancheRegionId) {

    global $con;

    $query = $con->query("SELECT * FROM `branches_regions` WHERE `id`='$BrancheRegionId' LIMIT 1");
    $row_select = mysqli_fetch_array($query);

    $region_id = $row_select['region_id'];
    return $region_id;
}

function add_branches_region($region_id, $branche_id) {
    global $con;
    $con->query("INSERT INTO `branches_regions` VALUES (Null,'$region_id','$branche_id','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}
function view_branch_regions($get) {

    global $con;
    if(isset($get)&&$get!=''){
        $id=$get['branch_id'];
    $query = $con->query("SELECT * FROM `branches_regions` where `branche_id`='$id'  ORDER BY `id` ASC");
    }else{
    $query = $con->query("SELECT * FROM `branches_regions`  ORDER BY `id` ASC");
        
    }
    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $region_id = $row['region_id'];
        $branche_id = $row['branche_id'];
        $branchesName = branchesName($branche_id);
        $getRegionId = getRegionName($region_id);
        $date_added = $row['date'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $getRegionId ?></td>
            <td><a href="branches_regions_view.php?branch_id=<?php echo $branche_id ;?>"><?php echo $branchesName; ?></a></td>
            <td style="">
                <?php
                echo $date_added;
                ?>
            </td>
            <td class="actions">
                <a href="branches_regions_edit.php?branche_region_id=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}


function view_branches_regions() {

    global $con;

    $query = $con->query("SELECT * FROM `branches_regions` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $region_id = $row['region_id'];
        $branche_id = $row['branche_id'];
        $branchesName = branchesName($branche_id);
        $getRegionId = getRegionName($region_id);
        $date_added = $row['date'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $getRegionId ?></td>
            <td><a href="branches_regions_view.php?branch_id=<?php echo $branche_id ;?>"><?php echo $branchesName; ?></a></td>

            <td style="">
                <?php
                echo $date_added;
                ?>
            </td>
            <td class="actions">
                <a href="branches_regions_edit.php?branche_region_id=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['delete_branche_region_id'])) {

    include("../connection.php");

    $branche_region_id = $_POST['delete_branche_region_id'];
    $query = $con->query("DELETE FROM `branches_regions` WHERE `id`='$branche_region_id'");

    if ($query) {
        echo get_success(" Deleted Successfully");
    }
}
?>
