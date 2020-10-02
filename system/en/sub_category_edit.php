<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['cat_and_sub'] != '1')) {
    header("Location: error.php");
    exit();
}
?>

<?php
// error_reporting(0);

if (isset($_POST['sub_cat_update'])) {
    $temp = $_POST;

    $sub_category_id_update = $temp['sub_cat_id_update'];
    $sub_category_name = $temp['sub_cat_name'];
    $sub_category_desc = $temp['sub_category_desc'];
    $sub_category_name_ar = $temp['sub_cat_name_ar'];
    $sub_category_desc_ar = $temp['sub_category_desc_ar'];
    $parent_category_id_update = $temp['parent_category_id_update'];
    $display = $temp['display'];
    $points_num = $temp['points_num'];

    if (isset($_FILES['sub_cat_image_update']['name']) && !empty($_FILES['sub_cat_image_update']['name'])) {
        $image_ext_old = $_POST['image_ext_old'];
        $mostafa = explode('/', $image_ext_old);
        $image_name = $mostafa[8];
        $full_img_path = dirname(__FILE__) . "/../api/uploads/sub_category/{$sub_category_id_update}/{$image_name}";
        if (file_exists($full_img_path)) {
            @unlink($full_img_path);
        }

        if (!file_exists("../api/uploads/sub_category/" . $sub_category_id_update))     {
               mkdir("../api/uploads/sub_category/" . $sub_category_id_update, 0777, true);
                   }

        $image_name_update = $_FILES['sub_cat_image_update']['name'];
        $image_tmp_update = $_FILES['sub_cat_image_update']['tmp_name'];
        $allowed_ext = array('jpg', 'jpeg', 'gif', 'png');
        $get_image_ext = explode('.', $image_name_update);
        $image_ext = strtolower(end($get_image_ext));


        $image_path = "../api/uploads/sub_category/" . $sub_category_id_update . "/";
        $image_database = "{$sit_url}/api/uploads/sub_category/" . $sub_category_id_update . "/" . round(microtime(true)) . '.' . "jpg";
        $target_path = $image_path . round(microtime(true)) . '.' . "jpg";


        $update = $con->query("UPDATE `sub_categories` SET  `points_num`='$points_num', `display`='$display', `sub_category_name`='$sub_category_name', `sub_category_name_ar`='$sub_category_name_ar',`sub_category_image`='$image_database',`sub_category_desc`='$sub_category_desc',`sub_category_desc_ar`='$sub_category_desc_ar',`parent_category_id`='$parent_category_id_update' WHERE `sub_category_id`='$sub_category_id_update'");


        if (move_uploaded_file($image_tmp_update, $target_path)) {

        }
    } else {
        $update = $con->query("UPDATE `sub_categories` SET `points_num`='$points_num', `display`='$display', `sub_category_name`='$sub_category_name', `sub_category_name_ar`='$sub_category_name_ar',`parent_category_id`='$parent_category_id_update',`sub_category_desc`='$sub_category_desc',`sub_category_desc_ar`='$sub_category_desc_ar' WHERE `sub_category_id`='$sub_category_id_update'");
    }
    $sub_cat_size_prices_update = sub_cat_size_prices_update($temp);


    if ($update) {
        echo get_success("Successfully Updated");
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo get_error("Here's a error!");
    }
}
?>

<!DOCTYPE html>
<html>
    <?php include("include/heads.php"); ?>	
    <body class="fixed-left">
        <div id="wrapper">
            <!-- Top Bar Start -->
            <?php include("include/topbar.php"); ?>
            <!-- Top Bar End -->

            <!-- Left Sidebar Start -->
            <?php include("include/leftsidebar.php"); ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <div class="content">
                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title"> Sub Categories </h4>
                                <ol class="breadcrumb">
                                    <li><a href="sub_category_view.php">Sub Categories </a></li>
                                    <li class="active">Edit Subcategory  </li>
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>
                        <?php
                        if ($_GET['subCatId']) {

                            $get_sub_cat_id = $_GET['subCatId'];

                            $query_select = $con->query("SELECT * FROM `sub_categories` WHERE `sub_category_id` = '{$get_sub_cat_id}' LIMIT 1");
                            $row_select = mysqli_fetch_array($query_select);

                            $sub_category_id = $row_select['sub_category_id'];
                            $sub_category_name = $row_select['sub_category_name'];
                            $sub_category_desc = $row_select['sub_category_desc'];
                            $sub_category_name_ar = $row_select['sub_category_name_ar'];
                            $sub_category_desc_ar = $row_select['sub_category_desc_ar'];
                            $get_parent_category_id = $row_select['parent_category_id'];
                            $display = $row_select['display'];
                            $points_num=$row_select['points_num'];

                            $sub_category_image = $row_select['sub_category_image'];
                            $get_image_ext = explode('.', $sub_category_image);
                            $image_ext = strtolower(end($get_image_ext));

                            if ($query_select) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box"> 									
                                            <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                                <input type="hidden" name="sub_cat_id_update" id="sub_cat_id_update" parsley-trigger="change"  value="<?php echo $sub_category_id; ?>" class="form-control">
                                               
                                                <div class="form-group col-md-3">
                                                    <label for="parent_category_id_update">Parent Category </label>
                                                    <select class="form-control select2me" name="parent_category_id_update" id="parent_category_id" required parsley-trigger="change">
                                                        <option value="" >Choose</option>
                                                        <?php
                                                        $query = $con->query("SELECT * FROM `parent_categories`   ORDER BY `parent_category_id` ASC");
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                            $parent_category_id = $row['parent_category_id'];
                                                            $parent_category_name_ar = $row['parent_category_name_ar'];
                                                            $parent_category_name = $row['parent_category_name'];
                                                            if ($get_parent_category_id == $parent_category_id) {
                                                                echo "<option value='{$parent_category_id}' selected='selected'>{$parent_category_name}-{$parent_category_name_ar}</option>";
                                                            } else {
                                                                echo "<option value='{$parent_category_id}'>{$parent_category_name}-{$parent_category_name_ar}</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>					
                                                </div>                                               
                                                <div class="form-group col-md-3">
                                                    <label for="sub_cat_name">English Name</label>
                                                    <input type="text" name="sub_cat_name" id="sub_cat_name_update" parsley-trigger="change"  value="<?php echo $sub_category_name; ?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="sub_cat_name_ar"> Arabic Name</label>
                                                    <input type="text" name="sub_cat_name_ar" id="sub_cat_name_update" parsley-trigger="change"  value="<?php echo $sub_category_name_ar; ?>" class="form-control">
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group col-md-3">
                                                    <label for="sub_cat_desc"> English Description</label>
                                                    <textarea class="form-control" rows="3" name="sub_category_desc"  minlength="3" maxlength="1000" ><?php echo $sub_category_desc; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="sub_category_desc_ar"> Arabic Description</label>
                                                    <textarea class="form-control" rows="3" name="sub_category_desc_ar"  minlength="3" maxlength="1000" ><?php echo $sub_category_desc_ar; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="points_num">  Number Of Points</label>
                                                    <input type="number"  step='0.01' min='0' name="points_num" id="points_num" parsley-trigger="change"  value="<?php echo $points_num; ?>" class="form-control">
                                                </div>

	
                                                <div class="clearfix"></div>

                                                <div class="form-group col-md-3">
                                                    <label class="control-label">  Status</label>
                                                    <select class="form-control" name="display" required parsley-trigger="change">
                                                        <option value="1" <?php
                                                        if ($display == '1') {
                                                            echo 'selected';
                                                        }
                                                        ?>>show</option>
                                                        <option value="0"  <?php
                                                        if ($display == '0') {
                                                            echo 'selected';
                                                        }
                                                        ?>>hidden</option>
                                                    </select>hidden
                                                </div>


                                                <div class="clearfix"></div>

                                                <input type="hidden" name="image_ext_old" value="<?php echo $sub_category_image; ?>" />
                                                <div class="form-group m-b-0">
                                                    <label for="userName">Image  <a class="showImg">edit?</a> </label>								

                                                    <div class="gal-detail thumb getImage">
                                                        <a href="<?php echo $sub_category_image; ?>" class="image-popup" title="<?php echo $sub_category_name; ?>">
                                                            <img src="<?php echo $sub_category_image; ?>" class="thumb-img" alt="<?php echo $sub_category_name; ?>">
                                                        </a>
                                                    </div>					

                                                    <div class="form-group m-b-0">
                                                        <label class="control-label">Image </label>
                                                        <input type="file" name="sub_cat_image_update" id="sub_cat_image_update" class="filestyle" data-buttonname="btn-primary">
                                                    </div>
                                                    <?php
                                                    $itr;
                                                    $count_sub_categories_size_prices = $con->query("SELECT * FROM `sub_categories_size_prices` where sub_category_id='$sub_category_id' ORDER BY `sub_category_size_price_id` ASC");
                                                    $count = mysqli_num_rows($count_sub_categories_size_prices);
                                                    if ($count > 0) {
                                                        $itr = $count;
                                                    } else {
                                                        $itr = 1;
                                                    }
                                                    echo "<input type='hidden' name='itr' id='itr' value='{$itr}'>";
                                                    ?>

                                                </div>
                                                <br />										
                                                <div class="form-group optionBox_two" style="position: relative;">
                                                    <label class="control-label">Sizes</label>

                                                    <?php
                                                    $query = $con->query("SELECT * FROM `sub_categories_size_prices` where sub_category_id='$sub_category_id' ORDER BY `sub_category_size_price_id` ASC");
                                                    $index = 0;
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $sub_category_size_price = $row['sub_category_size_price'];
                                                        $sub_category_size_name = $row['sub_category_size_name'];
                                                        $sub_category_size_name_ar = $row['sub_category_size_name_ar'];
                                                        $sub_category_size_price_id = $row['sub_category_size_price_id'];

                                                        echo "<div class='block_two ' id='cont_{$index}'>
                                                        <input name='size_id_{$index}' id='size_id_{$index}' type='hidden'  value='{$sub_category_size_price_id}'>
                                                        <input name='size_{$index}' id='size_{$index}' type='text' parsley-trigger='change' required placeholder='Size EN ' value='{$sub_category_size_name}' class='form-control thisField'>
                                                        <input name='size_ar_{$index}' id='size_ar_{$index}' type='text' parsley-trigger='change' required placeholder='Size AR ' value='{$sub_category_size_name_ar}' class='form-control thisField'>
                                                        <input name='size_price_{$index}' id='size_price_{$index}' type='number' step='0.01' min='0' parsley-trigger='change' required placeholder='price' value='{$sub_category_size_price}' class='form-control thisField'>
                                                        <button class='btn add-remove remove-me remove_two' data-id='{$sub_category_size_price_id}'  data-itra='{$index}' type='button'>-</button>
                                                    <br></div>";
                                                        $index++;
                                                    }
                                                    ?>
                                                    <br>


                                                    <div class="block_two">
                                                        <span class="btn add-more add_two" data-itra="1">+</span>
                                                    </div>											
                                                </div>


                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-primary waves-effect waves-light" type="submit" name="sub_cat_update" id="sub_cat_update">Update</button>
                                                </div>
                                            </form>								
                                        </div>
                                    </div>
                                </div>          
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('.image-popup').magnificPopup({
                                            type: 'image',
                                            closeOnContentClick: true,
                                            mainClass: 'mfp-fade',
                                            gallery: {
                                                enabled: true,
                                                navigateByImgClick: true,
                                                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                                            }
                                        });
                                    });
                                </script>
                                <?php
                            }
                        }
                        ?>

                    </div>			
                </div>
                <?php include("include/footer_text.php"); ?>

            </div>			

            <!-- End Right content here -->

            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <?php include("include/rightbar.php"); ?>
            </div>
            <!-- /Right-bar -->
        </div>
        <!-- END wrapper -->
        
        
        <?php include("include/footer.php"); ?>
        
        <script>
            $("#branch_id").change(function () {
               var branch_id= $(this).val();
                var dataString = 'parent_categories_by_branch_id=' + branch_id;
                $.ajax({
                    type: "POST",
                    url: "functions/sub_cat_functions.php",
                    data: dataString,
                    dataType: 'text',
                    cache: false,
                    success: function (html) {
                        $("#parent_category_id").html(html);
                    }
                });

            });
        </script>        
        
        <script>
            $('.add').click(function () {
                $('.block:last').before('<div class="block"><input name="addition[]" type="text" parsley-trigger="change" required placeholder="add" class="form-control thisField"><input name="addition_price[]" type="text" parsley-trigger="change" required placeholder="price" class="form-control thisField"><button class="btn add-remove remove-me remove" type="button">-</button></div>');
            });
            $('.optionBox').on('click', '.remove', function () {
                $(this).parent().remove();
            });
            var field = 1;
            $('.add_two').click(function () {
                var subj_itra = $(this).attr('data-itra');
                var itr = $('#itr').val();
                var itr = Number(itr) + 1;
                $('#itr').val(itr);
                field++;

                $('.block_two:last').before('<div class="block_two" id="cont_' + itr + '"><input name="size_' + itr + '" id="size_' + itr + '" type="text" parsley-trigger="change" required placeholder="size en " class="form-control thisField"><input name="size_ar_' + itr + '" id="size_ar_' + itr + '" type="text" parsley-trigger="change" required placeholder="size ar " class="form-control thisField"><input id="size_price_' + itr + '" name="size_price_' + itr + '" type="number" step="0.01" min="0" parsley-trigger="change" required placeholder="price" class="form-control thisField"><button class="btn add-remove remove-me remove_two" data-itra="' + itr + '" type="button">-</button></div>');


            });
            $('.optionBox_two').on('click', '.remove_two', function () {
//                $(this).parent().remove();

                var itra = $(this).attr('data-itra');
                var size_id = $(this).attr('data-id');
                var dataString = 'del_size_id=' + size_id;
                var dataString2 = 'delete_subcat_size_id=' + size_id;
                $.ajax({
                    type: "POST",
                    url: "functions/sub_cat_functions.php",
                    data: dataString,
                    dataType: 'text',
                    cache: false,
                    success: function (data) {
                        if (data == 1) {
                            alert("Sorry, you can not delete size")
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "functions/sub_cat_functions.php",
                                data: dataString2,
                                dataType: 'text',
                                cache: false,
                                success: function (data) {
                                    if (data == 1) {
                                        $('#cont_' + itra + '').remove();
                                    }
                                }
                            });

                        }
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item3").addClass("active");
            });
        </script>		
        <script type="text/javascript">
            $('.select2me').select2({
                placeholder: "Select",
                width: 'auto',
                allowClear: true
            });
        </script>
    </body>
</html>