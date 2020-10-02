<?php
include("../public/functions.php");
include("../public/connection.php");

$note = ($_COOKIE['lang'] == 'en' ? "Note" : "ملاحظات");
$additions = ($_COOKIE['lang'] == 'en' ? "Additions" : "الإضافات");
$removes = ($_COOKIE['lang'] == 'en' ? "Removes" : "الإزالات");
$bhd = ($_COOKIE['lang'] == 'en' ? "BHD" : "دينار بحريني");

if (isset($_POST['sub_category_id']) && isset($_POST['sub_category_id'])) {
    $sub_category_id = $_POST['sub_category_id'];
    $get_parent_category_id = get_category_id($sub_category_id);
    $query = $con->query("SELECT * FROM `sub_categories_size_prices` where `sub_category_id`='$sub_category_id'  ORDER BY `sub_category_size_price_id` ASC");
    $index = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        $size_price = $row['sub_category_size_price'];
        $size_name = ($_COOKIE['lang'] == 'en' ? $row['sub_category_size_name'] : $row['sub_category_size_name_ar']);
        $size_price_id = $row['sub_category_size_price_id'];
        $display = $row['display'];
        $currency = ($_COOKIE['lang'] == 'en' ? "BHD" : "دينار بحريني");
        ?>

        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" value="<?php echo $size_price_id; ?>" required id="size_id_<?php echo $size_price_id; ?>" name="size_id">
            <label class="custom-control-label" for="size_id_<?php echo $size_price_id; ?>"><?php echo $size_name . ' - ' . number_format((float) ($size_price), 3, '.', '') ; ?> <?= $currency ?></label>
        </div>

    <?php }
    ?>
    <?php
    $query = $con->query("SELECT * FROM `sub_categories_addition_prices` where parent_category_id='$get_parent_category_id'  ORDER BY `sub_category_addition_price_id` ASC");
    if(mysqli_num_rows($query)>0){ 
    ?>
    <h4><?= $additions ?> </h4>
    <?php
    $index = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        $addition_price_id = $row['sub_category_addition_price_id'];
        $addition_price = $row['sub_category_addition_price'];
        $addition_name = ($_COOKIE['lang'] == 'en' ? $row['sub_category_addition_name'] : $row['sub_category_addition_name_ar']);
        ?>
        <div class = "custom-control custom-radio">
            <input type = "radio"  name="addition_id_<?php echo $addition_price_id; ?>"  value="<?php echo $addition_price_id; ?>" id="addcustomCheck_<?php echo $addition_price_id; ?>"  class="custom-control-input addition_id">
            <label class = "custom-control-label" for = "addcustomCheck_<?php echo $addition_price_id; ?>">
                <?php
                echo $addition_name . '-' . number_format((float) ($addition_price), 3, '.', '') . $bhd;
                ?>
            </label>
        </div>
    <?php } ?>
    
    
    <?php }
    
    $query = $con->query("SELECT * FROM `removes` where parent_category_id='$get_parent_category_id'  ORDER BY `id` ASC");
    if(mysqli_num_rows($query)>0){ 
    ?>
    <h4><?= $removes ?> </h4>
    <?php
    
    
    $index = 0;
    
    while ($row = mysqli_fetch_assoc($query)) {
        $remove_id = $row['id'];
        $remove_name = ($_COOKIE['lang'] == 'en' ? $row['title'] : $row['title_ar']);
        ?>
        <div class = "custom-control custom-radio">
            <input type = "radio"  name="remove_id_<?php echo $remove_id; ?>"  value="<?php echo $remove_id; ?>" id="removes_<?php echo $remove_id; ?>" class = "custom-control-input remove_id">
            <label class = "custom-control-label" for = "removes_<?php echo $remove_id; ?>">
                <?php echo $remove_name; ?>
            </label>
        </div>
    <?php } ?>



    <?php }?>

    <div>
        <label for="" class="text-capitalize text-OceanGreen font-weight-bold"><?= $note ?> </label>
        <textarea class="form-control" rows="4" name="notes" id="notes" class=""></textarea>
    </div>    
    <input type="hidden" value="<?php echo $sub_category_id; ?>" id="item_id">
<?php }
?>
