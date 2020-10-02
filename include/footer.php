<!--start footer-->
<footer>
    <div class="lay-out">
        <div class="container-md">
            <!-- 1 -->
            <div class="row">
                <div class="col-md-8 col-12 mena">
                    <img src="assets/img/Footer%20Logo.png" class="d-block mane" alt="footer"/>
                    <div class="once">
                        <h5 class="mt-2"><?= lang('Got_Questions_Call_Us') ?></h5>
                        <span class="d-block mb-3"><?= $phone ?></span>
                        <h5><?= lang('contact_info') ?></h5>
                        <span><?= $address ?></span>
                        <ul class="list-group list-group-horizontal list-unstyled col-md-3">
                            <li><a href="<?= $fb ?>" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                            <li><a href="<?= $tw ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="<?= $insta ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="<?= $snapchat ?>" target="_blank"><i class="fab fa-snapchat-square"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- ./1 -->
                <!-- 2 -->
                <div class="col-md-4 col-12 mero">
                    <h3><?= lang('sections') ?></h3>
                    <div class="second">
                        <div class="row">
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    <?php
                                        $parent_categories = $con->query("SELECT * FROM parent_categories limit 6");
                                        while ($row = mysqli_fetch_array($parent_categories)) {
                                            $get_parent_category_id = $row['parent_category_id'];
                                            $parent_category_name = (lang('lang_key') == 'en' ? $row['parent_category_name'] : $row['parent_category_name_ar']);
                                            $count_sub_categories_by_category_id = count_sub_categories_by_category_id($get_parent_category_id);
                                            ?>
                                            <li><a href="products.php?parent_category_id=<?= $get_parent_category_id ?>"><?= $parent_category_name; ?></a></li>
                                        <?php } ?>

                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    <?php
                                        $parent_categories = $con->query("SELECT * FROM parent_categories limit 6,20 ");
                                        while ($row = mysqli_fetch_array($parent_categories)) {
                                            $get_parent_category_id = $row['parent_category_id'];
                                            $parent_category_name = (lang('lang_key') == 'en' ? $row['parent_category_name'] : $row['parent_category_name_ar']);
                                            $count_sub_categories_by_category_id = count_sub_categories_by_category_id($get_parent_category_id);
                                            ?>
                                            <li><a  href="products.php?parent_category_id=<?= $get_parent_category_id ?>"><?= $parent_category_name; ?></a></li>
                                        <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./2 -->
            </div>
        </div>
        <hr>
        <div class="copy-rights text-center">
            <div class="copy p-4 mt-1"><?= $footer_caption ?></div>
        </div>
    </div>
</footer>

<!-- Modal -->
<div class="modal fade" id="address_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="model_content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('add_new_address') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  action="#" method="post" id="address-submit-form">

                <div class="modal-body" >

                    <div class="form-group">
                        <label class="pl-2"><?= lang('phone_number') ?></label>
                        <input type="text" name="client_phone" id="client_phone" required="" class="form-control" placeholder="<?= lang('phone_number') ?>">
                    </div>

                    <div class="form-group">
                        <label class="pl-2"><?= lang('area') ?></label>
                        <select name="region_id" class="form-control" id="region_id" required="">
                            <option selected><?= lang('choose') ?>...</option>
                            <?php
                                $result = $con->query("SELECT * FROM `regions` where `display`=1 ORDER BY `region_id` DESC") or die(mysqli_error());
                                while ($row = mysqli_fetch_array($result)) {
                                    $region_id = $row["region_id"];
                                    $region_name = (lang('lang_key') == 'en' ? $row['region_name_en'] : $row['region_name_ar']);
                                    ?>
                                    <option value="<?php echo $region_id; ?>"><?php echo $region_name; ?></option>
                                <?php }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="pl-2"><?= lang('block') ?></label>
                        <input type="text" name="block"  id="block" required="" class="form-control location-block" placeholder="<?= lang('block') ?>">
                    </div>

                    <div class="form-group">
                        <label class="pl-2"><?= lang('road') ?></label>
                        <input type="text" name="road" id="road" required="" class="form-control" placeholder="<?= lang('road') ?>">
                    </div>
                    <div class="form-group">
                        <label class="pl-2"><?= lang('building') ?></label>
                        <input type="text" name="building" id="building" required="" class="form-control" placeholder="<?= lang('building') ?>">
                    </div>

                    <div class="form-group">
                        <label class="pl-2"><?= lang('floor_no') ?></label>
                        <input type="text" name="flat_number" id="flat_number" required="" class="form-control" placeholder="<?= lang('floor_no') ?>">
                    </div>


                    <div class="form-group">
                        <label class="pl-2"><?= lang('note') ?> </label>
                        <textarea class="form-control" rows="4" name="note" class=""></textarea>
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="button" style="width: auto!important" class="btn-lg"  id="address-submit" name="submit" > <?= lang('add_new_address') ?> </button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade"  id="add_to_cart_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('size_details') ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="set_content">
                </div>
                <hr>
                <div class="pack">
                    <h4><?= lang('quantity') ?></h4>
                    <div class="count">
                        <div class="row counter border border-warning rounded">
                            <div class="col-2 px-0 py-2 text-center quantity-plus border-right border-warning"><i class="fas fa-plus d-block m-auto"></i></div>
                            <div class="col-8 px-0"><input id="quantity" type="text" value="1" class="form-control border-0 input-number"></div>
                            <div class="col-2 px-0 py-2 text-center quantity-minus border-left border-warning"><i class="fas fa-minus d-block m-auto"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add_q_to_cart"><?= lang('add_to_cart') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/plug.js"></script>
<script src="assets/js/puge.js"></script>
<script src="assets/js/popper.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/all.min.js"></script>
<script src="assets/js/wow.min.js"></script>

<script type="text/javascript">
        $(document).ready(function () {
            $('.quantity-plus').click(function () {
                var index = $('.quantity-plus').index(this);
                var quantity = parseInt($('.input-number').eq(index).val());
                $('.input-number').eq(index).val(quantity + 1);
            });
            $('.quantity-minus').click(function () {
                var index = $('.quantity-minus').index(this);
                var quantity = parseInt($('.input-number').eq(index).val());
                if (quantity > 1) {
                    $('.input-number').eq(index).val(quantity - 1);
                }
            });
        });
        new WOW().init();
</script>
<script type="text/javascript" src="js/validations/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/validations/additional-methods.min.js"></script>
<script type="text/javascript" src="js/validations/messages_en.js"></script>
<script type="text/javascript" src="js/toast/jquery.toast.min.js"></script>
<script src="js/bootbox/bootbox.min.js" type="text/javascript"></script>

<script src="js/products-details.js" type="text/javascript"></script>
<script src="js/cart.js" type="text/javascript"></script>


<script>

        var site_url = $("#site_url").val();
        var lang = $("#lang").val();
        var payment_url = $("#payment_url").val();


        $('.add_to_cart').click(function () {
            var sub_category_id = $(this).attr("data-id");
            $.ajax({
                type: "POST",
                url: site_url + "functions/count_sizes.php",
                data: "sub_category_id=" + sub_category_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
//                if (data.count > 1) {
                    $("#set_content").html(data)
                    $('#add_to_cart_modal').modal('show');
                    $.ajax({
                        type: "POST",
                        url: site_url + "functions/get-product-details.php",
                        data: "sub_category_id=" + sub_category_id,
                        dataType: 'text',
                        cache: false,
                        success: function (data) {
                            if (data) {
                                $("#set_content").html(data)
                                $('#add_to_cart_modal').modal('show');
                            }
                        }
                    });
//                } else {
//                    addToCart(data.size_id, sub_category_id);
//                }
                }
            });
        });


        $('body').on('click', '#change-lang', function () {
            var date_change = $(this).attr("date-change");
            var date_link = $(this).attr("data-link");
            $.ajax({
                type: "POST",
                url: site_url + "functions/ajax_2.php",
                data: "change_lang=" + date_change,
                dataType: 'text',
                cache: false,
                success: function (data) {
                    if (data == 1) {
                        var link = date_link + date_change;
                        document.location.href = link;
                    }
                }
            });
        });

        $('body').on('click', '#submitIt', function () {
            var ths_form = $('#search_form');
            ths_form.submit();

        });
        function setNoAction() {
            window.location = 'products.php';
        }




        $('body').on('click', '#add_address', function () {
            $("#address_modal").modal('show');
        });
        $("#address-submit").on('click', function () {
            var ths_form = $('#address-submit-form');
            var count_address = $('#count_address').val();
            if (ths_form.valid()) {
                $.post(payment_url + "functions/save-address.php?ac=save-order", ths_form.serialize(), function (data) {
//                alert(data.success)
                    if (data.success == 1) {
                        $.toast({
                            heading: 'Address Added Successfully ',
                            text: 'Address Added Successfully ',
                            showHideTransition: 'slide',
                            icon: 'success'
                        });
                        location.reload();
                    } else if (data.success == 0 || data.success == '') {
                        $.toast({
                            heading: 'error ',
                            text: 'error ',
                            showHideTransition: 'slide',
                            icon: 'error'
                        });
                    }

                }, "json");
            }
        });
</script>

</body>
</html>

