<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['about'] != '1')) {
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

    <?php include("include/heads.php"); ?>
    <style>.red.btn {
            /* color: #FFFFFF; */
            background-color: #cb5a5e;
        }</style>
    <body class="fixed-left">

        <div id="wrapper">
            <!-- Top Bar Start -->
            <?php include("include/topbar.php"); ?>
            <!-- Top Bar End -->

            <!-- Left Sidebar Start -->
            <?php include("include/leftsidebar.php"); ?>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->  		

            <?php
// error_reporting(0);

            if (isset($_POST['contact_update'])) {
                $id = $_POST['id'];
                $address_en = $_POST['address_en'];
                $email_update = $_POST['email'];
                $phone_update = $_POST['phone'];
                $address_update = $_POST['address'];
                $fb_update = $_POST['facebook'];
                $tw_update = $_POST['twitter'];
                $insta_update = $_POST['instagram'];
                $snapchat_update = $_POST['snapchat'];
                $whatsapp_update = $_POST['whatsapp'];
                $mobile_update = $_POST['mobile'];
                $website = $_POST['website'];


                $update = $con->query("UPDATE `contact` SET `address_en`='$address_en',`email`='$email_update',
`phone`='$phone_update',`address`='$address_update',`instagram`='$insta_update',`mobile`='$mobile_update',`snapchat`='$snapchat_update',`whatsapp`='$whatsapp_update',
`facebook`='$fb_update',`twitter`='$tw_update',`website`='$website' WHERE `id`='$id'");
                if ($update) {
                    $contact_id = $id;
                    $query = $con->query("DELETE FROM `contact_links` WHERE `contact_id`='$contact_id' ");
                    for ($i = 0; $i <= $_POST['branche_itr']; $i++) {
                        if (isset($_POST['branche_id_' . $i . '']) && $_POST['branche_id_' . $i . ''] != '') {
                            $con->query("INSERT INTO `contact_links` VALUES (null,'" . $_POST['branche_id_' . $i . ''] . "','" . $_POST['link_' . $i . ''] . "','$contact_id')");
                        }
                    }

                    echo get_success("Successfully Updated");
                } else {
                    echo get_error("Here's a error!");
                }
            }
            ?>


            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Contact Us</h4>
                                <ol class="breadcrumb">
                                    <!--<li><a href="user_add.php">المديرين</a></li>-->
                                    <!--<li class="active">تعديل مدير</li>-->
                                </ol>
                            </div>
                        </div>

                        <div class="updateData"></div>

                        <?php
                        $query_select = $con->query("SELECT * FROM `contact` order by id desc");

                        $row_select = mysqli_fetch_array($query_select);

                        $id = $row_select['id'];
                        $email = $row_select['email'];
                        $phone = $row_select['phone'];
                        $address = $row_select['address'];
                        $address_en = $row_select['address_en'];
                        $fb = $row_select['facebook'];
                        $tw = $row_select['twitter'];
                        $insta = $row_select['instagram'];
                        $snapchat = $row_select['snapchat'];
                        $whatsapp = $row_select['whatsapp'];
                        $mob = $row_select['mobile'];
                        $website = $row_select['website'];
                        $accept_orders = $row_select['accept_orders'];

                        if ($query_select) {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-box"> 									
                                        <form method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                                            <input type="hidden" name="id" id="id" parsley-trigger="change" required value="<?php echo $id; ?>" class="form-control">

                                            <div class="form-group">
                                                <label for="address">Arabic Address</label>
                                                <textarea class="form-control" rows="3" name="address"  minlength="3" maxlength="1000" required=""><?php echo $address; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="address_en">English Address</label>
                                                <textarea class="form-control" rows="3" name="address_en"  minlength="3" maxlength="1000" required=""><?php echo $address_en; ?></textarea>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="phone">Phone</label>
                                                <input type="number" name="phone" id="phone" parsley-trigger="change" value="<?php echo $phone; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="mobile">Mobile</label>
                                                <input type="number" name="mobile" id="mobile" parsley-trigger="change" value="<?php echo $mob; ?>" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="email">Email</label>
                                                <input type="text" name="email" id="email" parsley-trigger="change" required value="<?php echo $email; ?>" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="instagram">Instagram</label>
                                                <input type="text" name="instagram" id="instagram" parsley-trigger="change" required value="<?php echo $insta; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="twitter">Twitter</label>
                                                <input type="text" name="twitter" id="twitter" parsley-trigger="change" required value="<?php echo $tw; ?>" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="facebook"> Facebook</label>
                                                <input type="text" name="facebook" id="facebook" parsley-trigger="change" required value="<?php echo $fb; ?>" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="Snapchat"> Snapchat </label>
                                                <input type="text" name="snapchat" id="snapchat" parsley-trigger="change" required value="<?php echo $snapchat; ?>" class="form-control">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="Whatsapp"> Whatsapp </label>
                                                <input type="text" name="whatsapp" id="whatsapp" parsley-trigger="change" required value="<?php echo $whatsapp; ?>" class="form-control">
                                            </div>

                                            <br>
                                            <div class="form-group col-md-3">
                                                <label for="website">Website</label>
                                                <input type="text" name="website" id="website" parsley-trigger="change" required value="<?php echo $website; ?>" class="form-control">
                                            </div>
                                            <div class="clearfix"></div>
                                            <br>

                                            <?php
                                            $itr;
                                            $count_contact_links = $con->query("SELECT * FROM `contact_links` where `contact_id`='1'  ORDER BY `id` ASC");
                                            $count = mysqli_num_rows($count_contact_links);
                                            if ($count > 0) {
                                                $itr = $count;
                                            } else {
                                                $itr = 1;
                                            }
                                            echo "<input type='hidden' name='branche_itr' id='branche_itr' value='{$itr}'>";
                                            ?>

                                            <div class="block_branche">
                                                <?php
                                                $query_contact_links = $con->query("SELECT * FROM `contact_links` where `contact_id`='1' ORDER BY `id` ASC");
                                                $index = 1;
                                                while ($row_contact_links = mysqli_fetch_assoc($query_contact_links)) {
                                                    $branche_id = $row_contact_links['branche_id'];
                                                    $link = $row_contact_links['link'];
                                                    ?>
                                                    <div id="branche_cont_<?php echo $index; ?>">

                                                        <label class="control-label">Branches   </label>
                                                        <div class='block_two' id='cont_<?php echo $index; ?>'>
                                                            <select class="form-control select2me branche_id" name="branche_id_<?php echo $index; ?>"  id="branche_id_<?php echo $index; ?>" required>
                                                                <option value="">Choose  </option>
                                                                <?php
                                                                $query_branches = $con->query("SELECT * FROM `branches` ORDER BY `id` ASC");
                                                                while ($row_branches = mysqli_fetch_assoc($query_branches)) {
                                                                    $get_branche_id = $row_branches['id'];
                                                                    $branche_name_ar = $row_branches['name_ar'];
                                                                    $branche_name = $row_branches['name'];
                                                                    $cat_id = $row_branches['cat_id'];
                                                                    if ($get_branche_id == $branche_id) {
                                                                        echo "<option value='{$get_branche_id}' selected>{$branche_name}" . '-' . $branche_name_ar . "</option>";
                                                                    } else {
                                                                        echo "<option value='{$get_branche_id}'>{$branche_name}" . '-' . $branche_name_ar . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <div class="block">
                                                                <input name="link_<?php echo $index; ?>" value="<?php echo $link; ?>"   id="link_<?php echo $index; ?>"  type="text" parsley-trigger="change" required  class="form-control thisField">
                                                            </div>
                                                            <button type="button" style="margin-bottom: 20px;" data-itra="<?php echo $index; ?>" class="btn red remove_branche">-</button>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $index++;
                                                }
                                                ?>
                                                <div class="block_two">
                                                    <span class="btn add-more add_two" style="    margin-top: 320px;
                                                          margin-left: 44px;">+</span>
                                                </div>
                                            </div>


                                            <div class="clearfix"></div>

                                            <br />

                                            <br>                                                                                <br>                                    

                                            <div class="form-group text-right m-b-0">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit" name="contact_update" id="contact_update">Update</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
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
        $(document).ready(function () {
            $("#cssmenu ul>li").removeClass("active");
            $("#item90").addClass("active");
        });
    </script>	
    <script>

        $(".select2, .select2-multiple").select2();


        $('.add_two').click(function (e) {
            e.preventDefault();
            var branche_itr = $('#branche_itr').val();
            var branche_itr = Number(branche_itr) + 1;
            $('#branche_itr').val(branche_itr);
            var branche = '';
            branche += '<div id="branche_cont_' + branche_itr + '">';
            branche += '<button type="button" style="margin-bottom: 20px;" data-itra="' + branche_itr + '" class="btn red remove_branche">-</button>';
            branche += '<div class="form-group optionBox_two show_branche" style="position: relative;">';
            branche += '<label class="control-label">branches   </label>';
            branche += '<select class="form-control select2me branche_id" name="branche_id_' + branche_itr + '"  id="branche_id_' + branche_itr + '" required>';
            branche += "<option value=''>choose  </option>";
<?php
$query = $con->query("SELECT * FROM `branches`   ORDER BY `id` ASC");
while ($row = mysqli_fetch_assoc($query)) {
    $branche_id = $row['id'];
    $branche_name = $row['name'];
    $branche_name_ar = $row['name_ar'];
    ?>
                branche += "<option value='<?php echo $branche_id; ?>'> <?php echo $branche_name . '-' . $branche_name_ar; ?></option>";

    <?php
}
?>
            branche += '</select>';
            branche += '<div class="block">';
            branche += '<input name="link_' + branche_itr + '"   id="link_' + branche_itr + '"  type="text" parsley-trigger="change" required  class="form-control thisField">';
            branche += '</div>';
            branche += '</div>';
            branche += '</div>';
            $('.block_branche').append(branche);
        });
        $('body').on('click', '.remove_branche', function () {
            var branche_itra = $(this).attr('data-itra');
            $('#branche_cont_' + branche_itra + '').remove();
        });
    </script>
</body>
</html>