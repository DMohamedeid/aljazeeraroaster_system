<?php

function add_most_request($product_id, $parent_cat_id) {
    global $con;
    $con->query("INSERT INTO `most_request_sub` VALUES (NULL, '$parent_cat_id', '$product_id','" . date("Y-m-d H:i:s") . "')") or die(mysqli_error($con));
    return mysqli_insert_id($con);
}



function view_most_requests() {

    global $con;

    $query = $con->query("SELECT * FROM `most_request_sub` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        // var_dump($row);
        $id = $row['id'];
        $product_id = $row['sub_category_id'];
        $parent_category_id=$row['parent_category_id'];
        $date = $row['date_added'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php 
            
                $result = $con->query("SELECT `parent_category_name` FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id'");
                $r = mysqli_fetch_assoc($result);
                echo $r['parent_category_name'];
            
            ?></td>
            <td><?php 
            
                $result = $con->query("SELECT `sub_category_name` FROM `sub_categories` WHERE `sub_category_id`='$product_id'");
                $r = mysqli_fetch_assoc($result);
                echo $r['sub_category_name'];
            
            ?></td>
            

            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="most_requested_edit.php?requestID=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['request_id'])) {

    include("../connection.php");

    $request_id = $_POST['request_id'];

    $query = $con->query("DELETE FROM `most_request_sub` WHERE `id`='$request_id'");

    if ($query) {
        echo get_success("تم الحذف بنجاح");
    }
}



if (isset($_POST['parent_cat_id_products'])) {

    include("../connection.php");
    global $con;
    $parent_cat_id = $_POST['parent_cat_id_products'];

    $query = $con->query("SELECT * FROM `sub_categories`  WHERE `parent_category_id`='$parent_cat_id' ");
    $options="";
    while ($row = mysqli_fetch_assoc($query)) {
    
        $product_id = $row['sub_category_id'];
        $product_name_ar = $row['sub_category_name'];
        $options.= "<option value='{$product_id}'>{$product_name_ar}</option>";
    
        
    }
            
    echo $options;    
           

}


?>