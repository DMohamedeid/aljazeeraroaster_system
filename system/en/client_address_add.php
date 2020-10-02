<?php
include("config.php");
if (!loggedin()) {
    header("Location: login.php");
    exit();
}if (($_SESSION['clients'] != '1')) {
    header("Location: error.php");
    exit();
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

            <?php
            if (isset($_POST['submit'])) {
                $temp = $_POST;

                $add_client_address = add_client_address($temp);

                echo get_success("Successfully added");
                echo "<meta http-equiv='refresh' content='0'>";
            }
            ?>	

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title"> Addresses </h4>
                                <ol class="breadcrumb">
                                    <li><a href="client_address_view.php">Addresses</a></li>
                                    <li class="active">  Add New Address</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b> add new address </b></h4>
                                    <form id="client_address_add" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" data-parsley-validate novalidate>
                                        <div class="form-group">
                                            <!--                                            <label class="control-label">Client Name</label>
                                                                                        <select class="form-control" name="client_id" id="client_id" required>
                                                                                            <option value=''>Choose Client</option>
                                            <?php
                                            $query = $con->query("SELECT * FROM `clients` ORDER BY `client_id` ASC");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $client_id = $row['client_id'];
                                                $client_name = $row['client_name'];
                                                echo " <option value = '{$client_id}'>{$client_name}</option>";
                                            }
                                            ?>
                                                                                        </select>-->

                                            <div class="" id="">
                                                <label for="">Search Client Name   </label>
                                                <input type="text" name="select_user" class="form-control input-circle"  placeholder="Client Name" type="text"  required="required" id="select_user" />
                                                <br />
                                                <br />

                                                <p id="empty-message"></p>
                                                <input type="hidden" name="client_id"   id="user_id"  />

                                            </div>
                                            <div class="error" id="user_error"></div>
                                        </div>
                                        <br />
                                        <input type='hidden' name='itr' id='itr' value="1">
                                        <div class="form-group optionBox_two" style="position: relative;
                                             ">
                                            <label class="control-label">Address</label>
                                            <div class="appendblock">
                                                <div class="block_two">
                                                    <div>
                                                        <label>Lat</label>
                                                        <input  name="lat_0" id="lat_0" type="text" parsley-trigger="change" required placeholder="Lat" class="form-control thisField">
                                                        <label>Long</label>

                                                        <input  name="lang_0" id="lang_0" type="text" parsley-trigger="change" required placeholder="Long" class="form-control thisField">
                                                        <label>Region</label>
                                                        <select  class="form-control" name="region_0" id="region_0" required>
                                                            <option value="">Choose</option>                                                           
                                                            <?php
                                                            $query = $con->query("SELECT * FROM `regions` ORDER BY `region_id` ASC");
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                                $region_id = $row['region_id'];
                                                                $region_name_ar = $row['region_name_ar'];
                                                                echo "<option value='{$region_id}'>{$region_name_ar}</option>";
                                                            }
                                                            ?>


                                                        </select>											
                                                        <label>Block</label>

                                                        <input  name="block_0" id="block_0" type="text" parsley-trigger="change" required placeholder="Block" class="form-control thisField">
                                                    </div>										
                                                    <div >
                                                        <label>Road</label>
                                                        <input  name="road_0" id="road_0" type="text" parsley-trigger="change" required placeholder="Road" class="form-control thisField">
                                                        <label>building</label>

                                                        <input  name="building_0" id="building_0" type="text" parsley-trigger="change" required placeholder="Building" class="form-control thisField">
                                                        <label>Flat Number </label>
                                                        <input  name="flat_number_0" id="flat_number_0" type="text" parsley-trigger="change" required placeholder="Flat Number " class="form-control thisField">
                                                        <label>Phone </label>

                                                        <input  name="phone_0" id="phone_o" type="text" parsley-trigger="change" required placeholder="Phone " class="form-control thisField">
                                                    </div>

                                                    <div class="clearfix"></div>
                                                    <label>Notes</label>

                                                    <input name="notes_0" type="text" parsley-trigger="change" required placeholder="notes" class="form-control thisField">
                                                </div>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <hr>
                                                <div class="block_two">
                                                    <span class="btn add-more add_two">+</span>
                                                </div>											
                                            </div>
                                        </div>
                                        <br />

                                        <div class="form-group text-right m-b-0">
                                            <button class="btn btn-primary waves-effect waves-light" id="submit" name="submit"> Submit </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5"> Cancel </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>			
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

            $('body').on('change', '#select_user', function () {
                var user_id = $("#user_id").val();
                if (user_id == "") {
                    $("#submit").attr("disabled", "disabled");
                    $("#user_error").html("Please enter a valid customer name");
                }
                else if (user_id != "") {
                    $('#submit').removeAttr("disabled") // Element(s) are now enabled.
                    $("#user_error").html("");
                    var ths_form = $('#client_address_add');
                    if (ths_form.valid()) {
                        ths_form.submit();
                    }
                }
            });
            ////auto complete
            $("#user_id").val("");
            $("#empty-message").empty();
            $("#select_user").autocomplete({
                source: function (request, response) {
                    // Fetch data
                    var dataString = 'search=' + request.term;

                    $.ajax({
                        type: "POST",
                        url: "functions/client_functions.php",
                        data: dataString,
                        dataType: 'JSON',
                        cache: false,
                        success: function (data) {
                            response(data);
//                            alert(data)
                            if (data = "null") {
                                $("#empty-message").text("No search results");
                                $("#user_id").val("");
                            } else {
                                $("#empty-message").empty();

                            }
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
//                    alert(ui.item.label)
                    $('#select_user').val(ui.item.label); // display the selected text
                    $('#user_id').val(ui.item.value); // display the selected text
                    $("#empty-message").empty();

                    return false;
                }
            });




            $('.optionBox').on('click', '.remove', function () {
                $(this).parent().remove();
            });
            var field = 1;
            $('body').on('click', '.add_two', function () {
                var subj_itra = $(this).attr('data-itra');
                var itr = $('#itr').val();
                var itr = Number(itr) + 1;
                $('#itr').val(itr);
                field++;

                var div_block = '';
                div_block += '<div id="cont_' + itr + '">';
                div_block += '    <label>lat</label>';
                div_block += '  <input  name="lat_' + itr + '" id="lat_' + itr + '" type="text" parsley-trigger="change" required placeholder="lat" class="form-control thisField">';
                div_block += '  <label>log</label>';
                div_block += '   <input  name="lang_' + itr + '" id="lang_' + itr + '" type="text" parsley-trigger="change" required placeholder="lang" class="form-control thisField">';
                div_block += '  <label>region</label>';
                div_block += '<select  class="form-control" name="region_' + itr + '" id="region_' + itr + '" required>';
                div_block += '<option value="">choose</option>';
<?php
$query = $con->query("SELECT * FROM `regions` ORDER BY `region_id` ASC");
while ($row = mysqli_fetch_assoc($query)) {
    $region_id = $row['region_id'];
    $region_name_ar = $row['region_name_ar'];
    ?>
                    div_block += '<option value="<?php echo $region_id; ?>"><?php echo $region_name_ar; ?></option>';
<?php }
?>


                div_block += '</select>';
                div_block += ' <label>block</label>';
                div_block += '  <input  name="block_' + itr + '" id="block_' + itr + '" type="text" parsley-trigger="change" required placeholder="block" class="form-control thisField">';
                div_block += ' </div>';
                div_block += '  <div >';
                div_block += ' <label>road</label>';
                div_block += '<input  name="road_' + itr + '" id="road_' + itr + '" type="text" parsley-trigger="change" required placeholder="road" class="form-control thisField">';
                div_block += '  <label>building</label>';
                div_block += ' <input  name="building_' + itr + '" id="building_' + itr + '" type="text" parsley-trigger="change" required placeholder="building" class="form-control thisField">';
                div_block += ' <label>flat number</label>';
                div_block += ' <input  name="flat_number_' + itr + '" id="flat_number_' + itr + '" type="text" parsley-trigger="change" required placeholder="flat number " class="form-control thisField">';
                div_block += '<label>notes</label>';
                div_block += '  <input ';
                div_block += '   width: 250px;" name="notes_' + itr + '" id="notes_' + itr + '"  type="text" parsley-trigger="change" required placeholder="notes" class="form-control thisField">';
                div_block += '</div>	';
                div_block += ' <button class="btn add-remove remove-me remove_two" data-itra="' + itr + '"  type="button">-</button>';
                div_block += '                                <div class="block_two">';
                div_block += '                                   <span class="btn add-more add_two">+</span>';
                div_block += '                       </div>';
                $(".appendblock").append('<div class="block_two">' + div_block + '</div>');
            });
            $('body').on('click', '.remove_two', function () {

                $(this).parent().remove();
            });
        </script>

        <script>
            $(document).ready(function () {
                $("#cssmenu ul>li").removeClass("active");
                $("#item7").addClass("active");
            });
        </script>

    </body>
</html>