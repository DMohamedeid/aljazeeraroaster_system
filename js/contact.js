$("#contact-site-submit").on('click', function () {
    var ths_form = $('#contact-site-form');
    if (lang == "ar") {
        var txt_failed = "عفوا،لقد حدث خطأ";
        var txt_success = "تم ارسال الرسالة بنجاح";

    } else {
        var txt_success = "Message Is Sent Successfully";
        var txt_failed = "Sorry,there is an error";

    }
    if (ths_form.valid()) {
        $.post(site_url + "functions/ajax_2.php?ac=save", ths_form.serialize(), function (data) {
//            alert(data)
            if (data == 1) {
                $.toast({
                    heading: txt_success,
                    text: txt_success,
                    showHideTransition: 'slide',
                    icon: 'success'
                });
            } else if (data == 0 || data == '') {
                $.toast({
                    heading: txt_failed,
                    text: txt_failed,
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            }
            $("#edit-name").val("");
            $("#edit-mail").val("");
            $("#subject").val("");
            $("#title").val("");
            $("#edit-message").val("");
        });
    }
});