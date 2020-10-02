<?php
if (isset($_POST['del_size_id'])) {
    include("../connection.php");
    $size_id = $_POST['del_size_id'];
    $query_select = $con->query("SELECT * FROM `cart` WHERE `size_id`='" . $size_id . "' ORDER BY `cart_id`  ");
    $cart_count = mysqli_num_rows($query_select);

    if ($cart_count > 0) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['delete_subcat_size_id'])) {
    include("../connection.php");
    $size_id = $_POST['delete_subcat_size_id'];
    $delete = $con->query("DELETE FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id` ='$size_id'");

    if ($delete) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['comment_id'])) {

    include("../connection.php");

    $comment_id = $_POST['comment_id'];
    $delete_comment = $con->query("DELETE FROM `sub_category_comments` WHERE `comment_id`='$comment_id'");

    if ($delete_comment) {
        echo get_success("Deleted Successfully  ");
    }
}

function view_subcat_comments($aStart = 0, $aLimit = 0, $get) {

    global $con;
    $subcat_comments = array();
    $sql = " SELECT * FROM `sub_category_comments`  ";
    if (isset($get['sub_category_id']) && $get['sub_category_id'] != '') {
        $sql .= " where `sub_category_id` = '" . $get['sub_category_id'] . "'  ";
    }
    if (isset($get['client_id']) && $get['client_id'] != '') {
        $sql .= " where `client_id` = '" . $get['client_id'] . "'  ";
    }
    $sql.= " ORDER BY `comment_id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";
    $query_select = $con->query($sql);
    $x = 1;

    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($subcat_comments, $row);

        $x++;
    }
    return $subcat_comments;
}

function sub_category_data($sub_category_id) {

    global $con;
    $queryB = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` ASC limit 1");
    $row_select = mysqli_fetch_array($queryB);
    return $row_select;
}


function subcat_comments_count($get) {

    global $con;
    $sql = " SELECT * FROM `sub_category_comments`  ";
    if (isset($get['sub_category_id']) && $get['sub_category_id'] != '') {
        $sql .= " where `sub_category_id` = '" . $get['sub_category_id'] . "'  ";
    }
    if (isset($get['client_id']) && $get['client_id'] != '') {
        $sql .= " where `client_id` = '" . $get['client_id'] . "'  ";
    }
    $query = $con->query($sql);

    $subcat_comments_count = mysqli_num_rows($query);

    return $subcat_comments_count;
}

function sub_cat_comments_count($sub_category_id) {

    global $con;
    $sql = " SELECT * FROM `sub_category_comments`  ";
    if ($sub_category_id) {
        $sql .= " where `sub_category_id` = '$sub_category_id'  ";
    }
    if ($client_id) {
        $sql .= " where `client_id` = '$client_id'  ";
    }
    $query = $con->query($sql);

    $subcat_comments_count = mysqli_num_rows($query);

    return $subcat_comments_count;
}

function sub_cat_client_comments_count($client_id) {

    global $con;
    $sql = " SELECT * FROM `sub_category_comments`  ";
    if ($client_id) {
        $sql .= " where `client_id` = '$client_id'  ";
    }
    $query = $con->query($sql);

    $subcat_comments_count = mysqli_num_rows($query);

    return $subcat_comments_count;
}

// Add Sub Category
function add_sub_cat($points_num,$sub_cat_name, $sub_cat_name_ar, $sub_cat_desc, $sub_cat_desc_ar, $parent_category_id, $sub_cat_image, $display) {

    global $con;

    $con->query("INSERT INTO `sub_categories` VALUES (null,'$sub_cat_name','$sub_cat_name_ar','$sub_cat_desc','$sub_cat_desc_ar','$sub_cat_image','$parent_category_id','$points_num','$display','" . date("Y-m-d H:i:s") . "')");
    global $sub_category_id;

    $sub_category_id = mysqli_insert_id($con);

    return mysqli_insert_id($con);
}

// Add Sub Category Sizes Name And Price
function add_sub_cat_size_prices($sub_cat_size_name, $sub_cat_size_name_ar, $sub_cat_size_price) {

    global $con;

    global $sub_category_id;

    $sub_cat_size_name_ar = $_POST['size_ar'];
    $sub_cat_size_name = $_POST['size'];
    $sub_cat_size_price = $_POST['size_price'];
    $size_price_sar = $_POST['size_price_sar'];

    foreach ($sub_cat_size_name as $key => $n) {
        $con->query("INSERT INTO `sub_categories_size_prices` VALUES (null,'" . $n . "','" . $sub_cat_size_name_ar[$key] . "','" . $sub_cat_size_price[$key] . "' ,'" . $sub_category_id . "','" . date("Y-m-d H:i:s") . "')");
    }

    return mysqli_insert_id($con);
}

function sub_cat_size_prices_update($temp) {
    global $con;
    $sub_category_id = $temp['sub_cat_id_update'];
    $itr = $temp['itr'];
    for ($i = 0; $i <= $itr; $i++) {

        if ($temp['size_price_' . $i . ''] != '') {

            $query_size = $con->query("SELECT * FROM `sub_categories_size_prices` where `sub_category_size_price_id`='" . $temp['size_id_' . $i . ''] . "'");
          
            $size_count = mysqli_num_rows($query_size);
            if ($size_count == 0) {
                $con->query("INSERT INTO `sub_categories_size_prices` VALUES (null,'" . $temp['size_' . $i . ''] . "','" . $temp['size_ar_' . $i . ''] . "','" . $temp['size_price_' . $i . ''] . "' , '" . $sub_category_id . "','" . date("Y-m-d H:i:s") . "')");
            } else {
                $con->query("UPDATE  `sub_categories_size_prices` SET  `sub_category_size_name_ar`='" . $temp['size_ar_' . $i . ''] . "' , `sub_category_size_name`='" . $temp['size_' . $i . ''] . "' , `sub_category_size_price`='" . $temp['size_price_' . $i . ''] . "'   WHERE `sub_category_size_price_id`='" . $temp['size_id_' . $i . ''] . "' AND `sub_category_id`='$sub_category_id' ");

            }
        }
    }
}

// Add Sub Category Additions Name & Price For Each Size
function add_sub_cat_addition_prices($sub_cat_addition_name, $sub_cat_addition_name_ar, $sub_cat_addition_price,$sub_cat_addition_price_sar) {

    global $con;

    global $sub_category_id_cus;
    global $sub_category_size_id_cus;

    $sub_cat_addition_name = $_POST['addition'];
    $sub_cat_addition_name_ar = $_POST['addition_ar'];
    $sub_cat_addition_price = $_POST['addition_price'];
    $sub_cat_addition_price_sar= $_POST['addition_price_sar'];

    foreach ($sub_cat_addition_name as $key => $m) {
        $con->query("INSERT INTO `sub_categories_addition_prices` VALUES (null,'" . $m . "','" . $sub_cat_addition_name_ar[$key] . "','" . $sub_cat_addition_price[$key] . "','" . $sub_cat_addition_price_sar[$key] . "','" . date("Y-m-d H:i:s") . "')");
    }

    return mysqli_insert_id($con);
}

// Add Sub Category Images
function add_sub_cat_images($sub_cat_images) {

    global $con;

    global $sub_category_id;

    if (!file_exists(dirname(__FILE__) . "/../../uploads/sub_category/{$sub_category_id}")) {
        mkdir(dirname(__FILE__) . "/../../uploads/sub_category/{$sub_category_id}", 0777, true);
    }

    //Loop through each file
    for ($i = 0; $i < count($sub_cat_images); $i++) {

        // $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

        $sub_cat_photo_name = $_FILES['sub_cat_photo']['name'][$i];
        $sub_cat_photo_tmp = $_FILES['sub_cat_photo']['tmp_name'][$i];
        $allowed_ext = array('jpg', 'jpeg', 'gif', 'png');
        $get_image_ext = explode('.', $sub_cat_photo_name);
        $image_ext = strtolower(end($get_image_ext));

        $image_path = dirname(__FILE__) . "/../uploads/sub_category/{$sub_category_id}/" . $sub_cat_photo_name;

        if (move_uploaded_file($sub_cat_photo_tmp, $image_path)) {

            $con->query("INSERT INTO `sub_categories_images` VALUES (null,'$sub_cat_photo_name','" . $sub_category_id . "','" . date("Y-m-d H:i:s") . "')");
            ;
        }
    }

    return mysqli_insert_id($con);
}

// Get Parent Categories Name And ID
function parent_category_name($parent_category_id) {

    global $con;

    $queryB = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' ORDER BY `parent_category_id` ASC limit 1");
    $row_select = mysqli_fetch_array($queryB);
    $parent_category_name = $row_select['parent_category_name'];
    return $parent_category_name;
}

function sub_category_name($sub_category_id) {

    global $con;

    $queryB = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` ASC limit 1");
    $row_select = mysqli_fetch_array($queryB);
    $sub_category_name = $row_select['sub_category_name'];
    return $sub_category_name;
}

function sub_parent_category($parent_category_id) {

    global $con;

    $queryB = $con->query("SELECT * FROM `parent_categories` WHERE `parent_category_id`='$parent_category_id' ORDER BY `parent_category_id` ASC");

    while ($row = mysqli_fetch_assoc($queryB)) {

        echo $parent_category_name = $row['parent_category_name'];
    }
}

// Count Number Of Sub Categories
function sub_cat_count() {

    global $con;

    $query = $con->query("SELECT * FROM `sub_categories` ORDER BY `sub_category_id` ASC");

    $sub_cat_count = mysqli_num_rows($query);

    return $sub_cat_count;
}

//Delete Sub Category By Sub Category ID
if (isset($_POST['sub_category_delete'])) {

    include("../connection.php");

    $sub_category = $_POST['sub_category_delete'];
    $querya = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category' limit 1");
    $row_select = mysqli_fetch_array($querya);
    $sub_category_image = $row_select['sub_category_image'];
    $sub_category_logo = $row_select['sub_category_logo'];
    $mostafa = explode('/', $sub_category_image);

    $image_name = $mostafa[8];

    $full_img_path = dirname(__FILE__) . "/../../api/uploads/sub_category/{$sub_category}/{$image_name}";

    $folder_full_img_path = dirname(_FILE_) . "/../../api/uploads/sub_category/{$sub_category}";

    if (file_exists($full_img_path)) {
        @unlink($full_img_path);
    }

    rmdir($folder_full_img_path);

    $mostafa = explode('/', $sub_category_logo);

    $image_name = $mostafa[9];

    $full_img_path = dirname(__FILE__) . "/../../api/uploads/sub_category/logo/{$sub_category}/{$image_name}";

    $folder_full_img_path = dirname(_FILE_) . "/../../api/uploads/sub_category/logo/{$sub_category}";

    if (file_exists($full_img_path)) {
        @unlink($full_img_path);
    }

    rmdir($folder_full_img_path);

    $query = $con->query("DELETE FROM `sub_categories` WHERE `sub_category_id`='$sub_category'");
    $querya = $con->query("DELETE FROM `sub_categories_size_prices` WHERE `sub_category_id`='$sub_category'");
    $queryb = $con->query("DELETE FROM `sub_categories_addition_prices` WHERE `sub_category_id`='$sub_category'");
    if ($query) {
        echo get_success("Deleted Successfully  ");
    }
}
if (isset($_POST['delete_sub_category_addition_price_id'])) {

    include("../connection.php");

    $sub_category_addition_price_id = $_POST['delete_sub_category_addition_price_id'];


    $query = $con->query("DELETE FROM `sub_categories_addition_prices` WHERE `sub_category_addition_price_id`='$sub_category_addition_price_id'");

    if ($query) {
        echo get_success("Deleted Successfully  ");
    }
}

// Get Sub Category Name And ID By Parent Category ID
if (isset($_POST['get_sub_category_by_parent_category_id'])) {

    global $con;

    include("../connection.php");

    $parent_category_id = $_POST['get_sub_category_by_parent_category_id'];

    $query = $con->query("SELECT * FROM `sub_categories` WHERE `parent_category_id`='$parent_category_id'");

    echo "<option value=''>choose </option>";
    while ($row = mysqli_fetch_assoc($query)) {
        $sub_category_id = $row['sub_category_id'];
        $sub_category_name = $row['sub_category_name'];
        echo "<option value='{$sub_category_id}'>{$sub_category_name}</option>";
    }
}

// Get Sub Category Size Name And Price By Parent Category ID
if (isset($_POST['get_sizes_by_sub_category_id'])) {

    global $con;

    include("../connection.php");

    $sub_category_id = $_POST['get_sizes_by_sub_category_id'];

    $query = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_id`='$sub_category_id'");
    echo "<option value=''>choose  </option>";

    while ($row = mysqli_fetch_assoc($query)) {
        $sub_category_size_price_id = $row['sub_category_size_price_id'];
        $sub_category_size_name = $row['sub_category_size_name'];
        $sub_category_size_price = $row['sub_category_size_price'];
        echo "<option value='{$sub_category_size_price_id}'>الحجم: {$sub_category_size_name} =>    السعر: {$sub_category_size_price}    د.ب</option>";
    }
}
if (isset($_POST['addition_sub_category_id'])) {

    global $con;

    include("../connection.php");

    $sub_category_id = $_POST['addition_sub_category_id'];

    $query = $con->query("SELECT * FROM `sub_categories_addition_prices` WHERE `sub_category_id`='$sub_category_id'");
    echo "<option value=''>choose </option>";
    while ($row = mysqli_fetch_assoc($query)) {
        $sub_category_addition_price_id = $row['sub_category_addition_price_id'];
        $sub_category_addition_name = $row['sub_category_addition_name'];
        echo "<option value='{$sub_category_addition_price_id}'>{$sub_category_addition_name}</option>";
    }
}

function count_client_fav_sub($client_id) {


    global $con;
    $query = $con->query("SELECT * FROM `client_fav` where `client_id`='$client_id' ORDER BY `fav_id` DESC");

    $sub_cat_count = mysqli_num_rows($query);

    return $sub_cat_count;
}

// View Sub Category Table
function view_client_fav_sub($client_id) {

    global $con;

    $query_1 = $con->query("SELECT * FROM `client_fav` where `client_id`='$client_id' ORDER BY `fav_id` DESC");

    while ($row_1 = mysqli_fetch_assoc($query_1)) {
        $sub_category_id = $row_1['sub_category_id'];

        $query = $con->query("SELECT * FROM `sub_categories` where `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` DESC");

        $x = 1;

        while ($row = mysqli_fetch_assoc($query)) {
            $sub_category_name = $row['sub_category_name'];
            $parent_category_id = $row['parent_category_id'];
            $date = $row['date'];

            $image = $row['sub_category_image'];
            $get_image_ext = explode('.', $image);
            $image_ext = strtolower(end($get_image_ext));
            ?>
            <tr class="gradeX">
                <td><?php echo $x; ?></td>
                <td><?php echo $sub_category_name; ?></td>
                <td><?php echo sub_parent_category($parent_category_id); ?></td>
                <td>
                    <a href="<?php echo $image; ?>" class="image-popup" title="<?php echo $sub_category_name; ?>">
                        <img src="<?php echo $image; ?>" class="thumb-img" alt="<?php echo $sub_category_name; ?>" height="100" style="width:100px;">
                    </a>			
                </td>
                <td><?php echo $date; ?></td>
            </tr>		
            <?php
            $x++;
        }
    }

    return mysqli_insert_id($con);
}

function sub_category_count($get) {

    global $con;

    $sql = " SELECT * FROM `sub_categories`  where 1  ";
    $sub_ct_name=$get['sub_ct_name'];
    $parent_cat_id=$get['parent_cat_id'];
    if (isset($sub_ct_name) && $sub_ct_name != '') {
        $sql .= " AND  `sub_category_name`LIKE '%{$sub_ct_name}%'  ";
    }
    
    if (isset($parent_cat_id) && $parent_cat_id != '') {
        $sql .= "  AND `parent_category_id` = '{$parent_cat_id}'  ";
    }
    
    $query = $con->query($sql);

    $sub_category_count = mysqli_num_rows($query);

    return $sub_category_count;
}

function view_sub_cat($aStart = 0, $aLimit = 0, $get) {

    global $con;
    $sub_categories = array();
    $sql = " SELECT * FROM `sub_categories`  where 1  ";
    $sub_ct_name=$get['sub_ct_name'];
   $parent_cat_id=$get['parent_cat_id'];

   if (isset($sub_ct_name) && $sub_ct_name != '') {
        $sql .= " AND `sub_category_name` LIKE '%{$sub_ct_name}%'  ";
    }
    if (isset($parent_cat_id) && $parent_cat_id != '') {
        $sql .= "  AND `parent_category_id` = '$parent_cat_id'  ";
    }
    
    $sql.= " ORDER BY `sub_category_id` DESC ";
    $sql.= $aLimit ? "LIMIT {$aStart},{$aLimit}" : "";

    //  echo $sql;
    // exit;
    $query_select = $con->query($sql);
    $x = 1;
    while ($row = mysqli_fetch_assoc($query_select)) {
        array_push($sub_categories, $row);

        $x++;
    }
    return $sub_categories;
}
function sub_category_customize() {

    global $con;

    $query = $con->query("SELECT * FROM `sub_categories_addition_prices` ORDER BY `sub_category_addition_price_id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $sub_category_addition_price_id = $row['sub_category_addition_price_id'];
        $sub_category_addition_name = $row['sub_category_addition_name'];
        $sub_category_addition_name_ar = $row['sub_category_addition_name_ar'];
        $sub_category_addition_price = $row['sub_category_addition_price'];
        $parent_category_id = $row['parent_category_id'];

        $date = $row['date'];
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $sub_category_addition_name; ?></td>
            <td><?php echo $sub_category_addition_name_ar; ?></td>
            <td><?php echo $sub_category_addition_price; ?></td>
            <td><?php echo parent_category_name($parent_category_id); ?></td>

            <td class="actions">
                <a href="sub_category_customize_edit.php?addition_id=<?php echo $sub_category_addition_price_id; ?>" class="on-default"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo $sub_category_addition_price_id; ?>" class="on-default remove-row" id="deleteParent"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}

function subCategory($sub_category_id) {

    global $con;

    $queryB = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' ORDER BY `sub_category_id` ASC");

    while ($row = mysqli_fetch_assoc($queryB)) {

        echo $sub_category_name = $row['sub_category_name'];
    }
}

function getSizeById($size_id) {

    global $con;

    $queryB = $con->query("SELECT * FROM `sub_categories_size_prices` WHERE `sub_category_size_price_id`='$size_id' limit 1");
    $row_select = mysqli_fetch_array($queryB);

    return $sub_category_size_name = $row_select['sub_category_size_name'];
}

function parentCatIdBySubId($sub_category_id) {
    global $con;

    $query = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id`='$sub_category_id' limit 1");
    $row_select = mysqli_fetch_array($query);

    $parent_category_id = $row_select['parent_category_id'];
    return $parent_category_id;
}

if (isset($_POST['change_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_status_on'];

    $query = $con->query("UPDATE `sub_categories` SET `display`=1 WHERE `sub_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_status_off'];

    $query = $con->query("UPDATE `sub_categories` SET `display`=0 WHERE `sub_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_spicy_status_on'])) {

    include("../connection.php");

    $change_status = $_POST['change_spicy_status_on'];

    $query = $con->query("UPDATE `sub_categories` SET `spicy_show`=1 WHERE `sub_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
if (isset($_POST['change_spicy_status_off'])) {

    include("../connection.php");

    $change_status = $_POST['change_spicy_status_off'];

    $query = $con->query("UPDATE `sub_categories` SET `spicy_show`=0 WHERE `sub_category_id`='$change_status'");

    if ($query) {
        echo get_success("Status changed successfully");
    }
}
?>