function updatecart(cart_id) {
    var new_value = $('#qquantity_' + cart_id).val();
    var get_client_id = $('#client_id').val();
    if (lang == "ar") {
        var txt_success_1 = "تم التحديث بنجاح";
        var txt_failed = "عفوا،لقد حدث خطأ";
        var txt_failed_1 = "برجاء تسجيل الدخول أولا";
    } else {
        var txt_success_1 = "Success,Cart Updated Successfully!";
        var txt_failed = "Sorry,there is an error";
        var txt_failed_1 = " Login First";

    }
    if (get_client_id != '') {
        var dataString = 'new_value=' + new_value + '&cart_id=' + cart_id + '&get_client_id=' + get_client_id;
        $.ajax({
            type: "POST",
            url: site_url + "functions/delivery_address_ajax.php",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function (res) {
                if (res.success == 1) {
                    window.location.href = site_url + 'my-cart.php';

                } else {
                    $.toast({
                        heading: txt_failed,
                        text: txt_failed,
                        showHideTransition: 'slide',
                        icon: 'error'
                    });
                }
            }
        });
    } else {
        $.toast({
            heading: txt_failed_1,
            text: txt_failed_1,
            showHideTransition: 'slide',
            icon: 'error'
        });
    }
}

$('body').on('change', '.updatecart', function () {
    var cart_id = $(this).attr("data-cart");
    updatecart(cart_id);
});
$('body').on('click', '.more', function () {
    var cart_id = $(this).attr("data-cart");
    updatecart(cart_id);
});
$('body').on('click', '.less', function () {
    var cart_id = $(this).attr("data-cart");
    updatecart(cart_id);
});
$('body').on('click', '#click_to_continue', function () {
    var client_id = $("#client_id").val();
    var dataString = 'client_id=' + client_id;
    $.ajax({
        type: "POST",
        url: site_url + "functions/delivery_address_ajax.php",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.success == 1) {
//                    alert(data.cart_id)
                var link = 'confirm-order.php?cart_id=' + data.cart_id;
                document.location.href = link;
            } else {
                if (lang == "ar") {
                    alert("عفوا ,السلة فارغة");
                } else {
                    alert("Sorry,Cart Is Empty");
                }
            }
        }
    });
});

$('body').on('click', '.remvoe', function () {
    var client_id = $("#client_id").val();
    var data_cart = $(this).attr('data-cart');
    var dataString = 'data_cart=' + data_cart + '&getClient_id=' + client_id;
    if (lang == "ar") {
        var txt_failed = "عفوا،لقد حدث خطأ";
        var txt_success = "تم الحذف بنجاح";
        var message = "هل تريد حذف هذا العنصر؟";
        var title = "تأكيد الحذف";
        var label = "إلغاء";
        var del = "حذف";

    } else {
        var txt_success = "Deleted Successfully";
        var txt_failed = "Sorry,there is an error";
        var message = "Do you want to delete this item?";
        var title = "Message Confirm deletion";
        var label = "cancel";
        var del = "delete";

    }
    bootbox.dialog({
        message: message,
        title: title, buttons: {
            danger: {
                label: label,
                className: "btn-danger"
            },
            main: {
                label: del, className: "btn-primary",
                callback: function () {
                    //do something else
                    $.ajax({
                        type: "POST",
                        url: site_url + "functions/delivery_address_ajax.php",
                        data: dataString,
                        dataType: 'json',
                        cache: false,
                        success: function (data) {

//                            $('.' + data_cart).remove();
                            window.location.href = site_url + 'my-cart.php';

                            $.toast({
                                heading: txt_success,
                                text: txt_success,
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                        }
                    });
                }
            }
        }
    });

});

$('body').on('click', '#add_q_to_cart', function () {

    var client_id = $("#client_id").val();
    var quantity = $("#quantity").val();
    var sub_category_id = $("#item_id").val();
    var size_id = $('input[name="size_id"]:checked').val();
    var notes = $("textarea#notes").val();
    var remove_id = [];
    $('.remove_id:checked').each(function () {
        remove_id.push(this.value);
    });
    var addition_id = [];
    $('.addition_id:checked').each(function () {
        addition_id.push(this.value);
    });
    if (client_id != '') {
        if (!size_id) {
            if (lang == "en") {
                $.toast({
                    heading: 'Please Choose Size',
                    text: 'Please Choose Size',
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            } else {
                $.toast({
                    heading: 'عفوا ،يجب إختيار الحجم أولا',
                    text: 'عفوا ،يجب إختيار الحجم أولا',
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            }
        } else {

            var dataString = 'add_q_to_cart=' + client_id + '&addition_id=' + addition_id + '&remove_id=' + remove_id + '&size_id=' + size_id + '&quantity=' + quantity + '&sub_category_id=' + sub_category_id + '&notes=' + notes;

            $.ajax({
                type: "POST",
                url: site_url + "functions/add-to-cart.php",
                data: dataString,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.success == 1)
                    {
                        window.location.href = site_url + 'my-cart.php';
//                    $("#count_all").html(data.count_all);
                        if (lang == "en") {
                            $.toast({
                                heading: 'Success,Product Added To cart',
                                text: 'Success,Product Added To cart',
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                        } else {
                            $.toast({
                                heading: 'تم إضافة المنتج للسلة بنجاح',
                                text: 'تم إضافة المنتج للسلة بنجاح',
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                        }
                    } else {
                        if (lang == "en") {
                            $.toast({
                                heading: 'Sorry,there is error',
                                text: 'Sorry,there is error',
                                showHideTransition: 'slide',
                                icon: 'error'
                            });
                        } else {
                            $.toast({
                                heading: 'عفوا،لقد حدث خطأ',
                                text: 'عفوا،لقد حدث خطأ',
                                showHideTransition: 'slide',
                                icon: 'error'
                            });
                        }

                    }
                }
            });

        }
    } else {
        if (lang == "en") {
            $.toast({
                heading: 'Please,Login first!',
                text: 'Please,Login first!',
                showHideTransition: 'slide',
                icon: 'error'
            });
        } else {
            $.toast({
                heading: 'برجاء تسجيل الدخول أولا',
                text: 'برجاء تسجيل الدخول أولا!',
                showHideTransition: 'slide',
                icon: 'error'
            });
        }
    }

});


function addToCart(size_id, sub_category_id) {
    var client_id = $("#client_id").val();
    var quantity = $("#quantity").val();
    var notes = $("textarea#notes").val();
    var remove_id = [];
    $('.remove_id:checked').each(function () {
        remove_id.push(this.value);
    });
    var addition_id = [];
    $('.addition_id:checked').each(function () {
        addition_id.push(this.value);
    });
    if (client_id != '') {
        if (!size_id) {
            if (lang == "en") {
                $.toast({
                    heading: 'Please Choose Size',
                    text: 'Please Choose Size',
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            } else {
                $.toast({
                    heading: 'عفوا ،يجب إختيار الحجم أولا',
                    text: 'عفوا ،يجب إختيار الحجم أولا',
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            }
        } else {

            var dataString = 'add_q_to_cart=' + client_id + '&addition_id=' + addition_id + '&remove_id=' + remove_id + '&size_id=' + size_id + '&quantity=' + quantity + '&sub_category_id=' + sub_category_id + '&notes=' + notes;

            $.ajax({
                type: "POST",
                url: site_url + "functions/add-to-cart.php",
                data: dataString,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.success == 1)
                    {
                        window.location.href = site_url + 'my-cart.php';
//                    $("#count_all").html(data.count_all);
                        if (lang == "en") {
                            $.toast({
                                heading: 'Success,Product Added To cart',
                                text: 'Success,Product Added To cart',
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                        } else {
                            $.toast({
                                heading: 'تم إضافة المنتج للسلة بنجاح',
                                text: 'تم إضافة المنتج للسلة بنجاح',
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                        }
                    } else {
                        if (lang == "en") {
                            $.toast({
                                heading: 'Sorry,there is error',
                                text: 'Sorry,there is error',
                                showHideTransition: 'slide',
                                icon: 'error'
                            });
                        } else {
                            $.toast({
                                heading: 'عفوا،لقد حدث خطأ',
                                text: 'عفوا،لقد حدث خطأ',
                                showHideTransition: 'slide',
                                icon: 'error'
                            });
                        }

                    }
                }
            });

        }
    } else {
        if (lang == "en") {
            $.toast({
                heading: 'Please,Login first!',
                text: 'Please,Login first!',
                showHideTransition: 'slide',
                icon: 'error'
            });
        } else {
            $.toast({
                heading: 'برجاء تسجيل الدخول أولا',
                text: 'برجاء تسجيل الدخول أولا!',
                showHideTransition: 'slide',
                icon: 'error'
            });
        }
    }
}

