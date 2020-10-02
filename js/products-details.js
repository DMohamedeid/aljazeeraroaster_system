$('body').on('click', '.edit_comment', function () {
    var comment_id = $(this).attr('data-id');
    var client_id = $("#client_id").val();
    var edited_comment = $("#edited_comment").val();
    $('.edit_review').css('display', 'block');
});
$('body').on('click', '.update_review', function () {
    var comment_id = $(this).attr('data-id');
    var client_id = $("#client_id").val();
    var edited_comment = $("#edited_comment").val();
    $('.edit_review').css('display', 'block');
    var dataString = 'comment_id=' + comment_id + '&edited_comment=' + edited_comment + '&client_id=' + client_id;
    if (lang == "ar") {
        var txt_success = "تم تحديث التعليق بنجاح";
        var txt_failed = "عفوا،لقد حدث خطأ";
    } else {
        var txt_success = "Success,Comment Updated Successfully";
        var txt_failed = "Sorry,there is an error";
    }
    $.ajax({
        type: "POST",
        url: site_url + "functions/ajax_2.php",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.success == 1)
            {
                $.toast({
                    heading: txt_success,
                    text: txt_success,
                    showHideTransition: 'slide',
                    icon: 'success'
                });
                $('.edit_review').css('display', 'none');
                $("#comment_" + comment_id).html(edited_comment);

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

});
$('body').on('click', '.delete_comment', function () {
    var comment_id = $(this).attr('data-id');
    var client_id = $("#client_id").val();
    var dataString = 'client_id=' + client_id + '&delete_comment_id=' + comment_id;
    $.ajax({
        type: "POST",
        url: site_url + "functions/ajax_2.php",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.success == 1)
            {
                if (lang == "ar") {
                    $.toast({
                        heading: 'تم حذف التقييم بنجاح!',
                        text: 'تم حذف التقييم  بنجاح!',
                        showHideTransition: 'slide',
                        icon: 'success'
                    });
                } else {
                    $.toast({
                        heading: 'Success,Comment Deleted Successfully!',
                        text: 'Success,Comment Deleted Successfully!',
                        showHideTransition: 'slide',
                        icon: 'success'
                    });
                }
                $(".delete_" + comment_id).remove();

            } else {
                if (lang == "ar") {
                    $.toast({
                        heading: 'عفوا،لقد حدث خطأ',
                        text: 'عفوا،لقد حدث خطأ',
                        showHideTransition: 'slide',
                        icon: 'error'
                    });
                } else {
                    $.toast({
                        heading: 'Sorry,there is error',
                        text: 'Sorry,there is error',
                        showHideTransition: 'slide',
                        icon: 'error'
                    });
                }
            }
        }
    });
});

$('body').on('click', '.add_rate', function () {
    var data_rate = $(this).attr("data-rate");
    if (!$(this).hasClass("filled")) {
        if (data_rate == 1) {
            $("#add_rate_1").addClass("filled");
        } else if (data_rate == 2) {
            $("#add_rate_1").addClass("filled");
            $("#add_rate_2").addClass("filled");
        } else if (data_rate == 3) {
            $("#add_rate_1").addClass("filled");
            $("#add_rate_2").addClass("filled");
            $("#add_rate_3").addClass("filled");
        } else if (data_rate == 4) {
            $("#add_rate_1").addClass("filled");
            $("#add_rate_2").addClass("filled");
            $("#add_rate_3").addClass("filled");
            $("#add_rate_4").addClass("filled");

        } else if (data_rate == 5) {
            $("#add_rate_1").addClass("filled");
            $("#add_rate_2").addClass("filled");
            $("#add_rate_3").addClass("filled");
            $("#add_rate_4").addClass("filled");
            $("#add_rate_5").addClass("filled");

        }

    } else {
        if (data_rate == 1) {
            $("#add_rate_2").removeClass("filled");
            $("#add_rate_3").removeClass("filled");
            $("#add_rate_4").removeClass("filled");
            $("#add_rate_5").removeClass("filled");
        } else if (data_rate == 2) {
            $("#add_rate_2").removeClass("filled");
            $("#add_rate_3").removeClass("filled");
            $("#add_rate_4").removeClass("filled");
            $("#add_rate_5").removeClass("filled");
        } else if (data_rate == 3) {
            $("#add_rate_3").removeClass("filled");
            $("#add_rate_4").removeClass("filled");
            $("#add_rate_5").removeClass("filled");
        } else if (data_rate == 4) {
            $("#add_rate_4").removeClass("filled");
            $("#add_rate_5").removeClass("filled");

        } else if (data_rate == 5) {
            $("#add_rate_5").removeClass("filled");

        }
    }

});

$('body').on('click', '.set-fav', function () {
    var client_id = $("#client_id").val();
    var data_fav = $(this).attr('data-fav');
    var data_id = $(this).attr('data-id');

    if (data_fav == 1) {
        $(this).attr("data-fav", "0");
        $(this).removeClass("in-fav");

    } else {
        $(this).attr("data-fav", "1");
        $(this).addClass("in-fav");

    }
    if (client_id == '') {
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
    } else {
        var dataString = 'data_fav=' + data_fav + '&get_client_id=' + client_id + '&data_id=' + data_id;
        $.ajax({
            type: "POST",
            url: site_url + "functions/ajax.php",
            data: dataString,
            dataType: 'text',
            cache: false,
            success: function (data) {
                if (data == 1) {

                }
            }
        });

    }
});


$('body').on('click', '#add_review', function () {
    var client_id = $("#client_id").val();
    var comment = $('textarea#comment').val();
    var data_rate = $(this).attr('data-rate');
    var sub_category_id = $(this).attr('data-product');

//        $(".add_rate").addClass("checked");
    var dataString = 'check_review=' + client_id + '&sub_category_id=' + sub_category_id;

    $.ajax({
        type: "POST",
        url: site_url + "functions/ajax_2.php",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data.success == 1)
            {

                var numItems = $('#new_rating').find('.filled').length;
//                    alert(numItems)
                if (numItems < 1) {
                    if (lang == "en") {
                        $.toast({
                            heading: 'Please,Add Review First',
                            text: 'Please,Add Review First',
                            showHideTransition: 'slide',
                            icon: 'error'
                        });
                    } else {
                        $.toast({
                            heading: 'عفوا يجب إضافة تقييم أولا',
                            text: 'عفوا يجب إضافة تقييم أولا',
                            showHideTransition: 'slide',
                            icon: 'error'
                        });
                    }
                } else {
                    if (client_id != '') {
                        var dataString = 'add_review=' + client_id + '&sub_category_id=' + sub_category_id + '&comment=' + comment + '&rate=' + numItems;
                        $.ajax({
                            type: "POST",
                            url: site_url + "functions/ajax_2.php",
                            data: dataString,
                            dataType: 'json',
                            cache: false,
                            success: function (data) {
                                if (data.success == 1)
                                {
                                    $(".add_rate").removeClass("filled");
                                    $('textarea#comment').val("");
                                    $('#add_reviews').append(data.div);
                                    if (lang == "en") {

                                        $.toast({
                                            heading: 'Success, Added Review To Product',
                                            text: 'Success, Added Review To Product',
                                            showHideTransition: 'slide',
                                            icon: 'success'
                                        });
                                    } else {
                                        $.toast({
                                            heading: 'تم إضافة تقييم للمنتج بنجاح',
                                            text: 'تم إضافة تقييم للمنتج بنجاح',
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
            } else {
                $.toast({
                    heading: data.message,
                    text: data.message,
                    showHideTransition: 'slide',
                    icon: 'error'
                });

            }
        }
    });
});
