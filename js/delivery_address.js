$('body').on('click', '.remove-add', function () {
    var client_id = $("#client_id").val();
    var data_remove = $(this).attr('data-remove');
    var dataString = 'data_remove=' + data_remove + '&client_id=' + client_id;
            // alert(lang)

    if (lang == "ar") {
        var txt_failed = "عفوا،لقد حدث خطأ";
        var txt_success = "تم الحذف بنجاح";
        var message = "هل تريد حذف هذا العنصر؟";
        var title = "تأكيد الحذف";
        var label = "إلغاء";
    } else {
        var txt_success = "Deleted Successfully";
        var txt_failed = "Sorry,there is an error";
        var message = "Do you want to delete this item?";
        var title = "Message Confirm deletion";
        var label = "cancel";
    }
    bootbox.dialog({
        message: message,
        title: title, buttons: {
            danger: {
                label: label,
                className: "btn-danger"
            },
            main: {
                label: "delete", className: "btn-primary",
                callback: function () {
                    //do something else

//        alert(dataString)
                    $.ajax({
                        type: "POST",
                        url: site_url + "functions/ajax.php",
                        data: dataString,
                        dataType: 'text',
                        cache: false,
                        success: function (data) {
                            if (data) {
                                $.toast({
                                    heading: txt_success,
                                    text: txt_success,
                                    showHideTransition: 'slide',
                                    icon: 'success'
                                });
                            } else {
                                $.toast({
                                    heading: txt_failed,
                                    text: txt_failed,
                                    showHideTransition: 'slide',
                                    icon: 'error'
                                });

                            }
                            $(".delete_" + data_remove).remove();
                        }
                    });
                }
            }
        }
    });

});

$(document).ready(function () {
    $('.payment:checkbox').click(function () {
        $('.payment:checkbox').not(this).prop('checked', false);
    });
});
$(document).ready(function () {
    $('.client_address_id:checkbox').click(function () {
        $('.client_address_id:checkbox').not(this).prop('checked', false);
    });
});

$('body').on('click', 'input[name="deliver_id"]', function () {
    if ($(this).is(':checked'))
    {
//            alert($(this).val());
        var checked_value = $(this).val();
        if (checked_value == 1) {
            $('#viewAddress').show();
        } else {
            $('#viewAddress').css('display', 'none');
        }
    }
});

$('.btn .custom-control').on('click', function () {
    $(this).find('[type="radio"]')[0].click();
});