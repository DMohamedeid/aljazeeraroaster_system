<?php

function add_slider($sliderImage, $product_id,$parent_cat_id) {
    global $con;
    $con->query("INSERT INTO `slider` VALUES (Null,'$parent_cat_id','$product_id','$sliderImage','" . date("Y-m-d H:i:s") . "')");
    return mysqli_insert_id($con);
}

function slider_count() {

    global $con;

    $query = $con->query("SELECT * FROM `slider` ORDER BY `id` ASC");

    $slider_count = mysqli_num_rows($query);

    return $slider_count;
}

function view_sliders() {

    global $con;

    $query = $con->query("SELECT * FROM `slider` ORDER BY `id` ASC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $product_id = $row['product_id'];
        $image = $row['image'];
        $parent_category_id=$row['parent_category_id'];
        $date = $row['date_added'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo sub_category_data($product_id)["sub_category_name"]; ?></td>
            <td><?php echo get_parent_cat_by_id($parent_category_id)['parent_category_name']; ?></td>
            <td>
                <a href="<?php echo $image; ?>" class="image-popup" title="image">
                    <img src="<?php echo $image; ?>" class="thumb-img" alt="image" height="100" style="width:100px;">
                </a>			
            </td>
            <td><?php echo $date; ?></td>
            <td class="actions">
                <a href="slider_edit.php?sliderID=<?php echo $id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $id; ?>" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

if (isset($_POST['slider_id'])) {

    include("../connection.php");

    $slider_id = $_POST['slider_id'];

    $querya = $con->query("SELECT * FROM `slider` WHERE `id`='$slider_id' limit 1");

    $row_select = mysqli_fetch_array($querya);

    $slider_image = $row_select['image'];

    $mostafa = explode('/', $slider_image);

    $image_name = $mostafa[7];

    $full_img_path = "../../api/uploads/slider/{$slider_id}/{$image_name}";

    $folder_full_img_path = "../../api/uploads/slider/{$slider_id}";

    if (file_exists($full_img_path)) {
        @unlink($full_img_path);
    }

    rmdir($folder_full_img_path);

    $query = $con->query("DELETE FROM `slider` WHERE `id`='$slider_id'");

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
