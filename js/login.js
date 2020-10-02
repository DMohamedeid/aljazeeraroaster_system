///دخول العميل 

//تسجيل دخول
var login = function () {
    var ths_form = $('#client-login');
    var action = site_url + 'functions/ajax.php?ac=login';
    if (lang == "ar") {
        var txt_failed_1 = "عفوا،هذا الرقم غير مسجل من قبل";
        var txt_failed_2 = "عفوا،رقم المرور غير صالح";
    } else {
        var txt_failed_1 = "Sorry,Phone number not exist";
        var txt_failed_2 = "Sorry,Invalid password";
    }
    if (ths_form.valid()) {
        $.post(action, ths_form.serialize(), function (data) {
            if (data == "1")
            {
//                window.location.href = site_url + lang + '/index.php';
                window.location.href = site_url + 'index.php';
            } else if (data == "no")
            {
                $.toast({
                    heading: txt_failed_1,
                    text: txt_failed_1,
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            } else if (data == "error_pass")
            {
                $.toast({
                    heading: txt_failed_2,
                    text: txt_failed_2,
                    showHideTransition: 'slide',
                    icon: 'error'
                });

            }

        });

    }
}
//تسجيل 
var reg = function () {
    var ths_form = $('#client-reg');
    if (ths_form.valid()) {
        var action = site_url + 'functions/reg.php';
        $.post(action, ths_form.serialize(), function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.success == 0)
            {
                $.toast({
                    heading: obj.message,
                    text: obj.message,
                    showHideTransition: 'slide',
                    icon: 'error'
                });
            } else {
                window.location.href = site_url + 'index.php';

            }

        });

    }
}

$("#login-submit").on('click', function () {
    login();
});

$('input[type="text"]').keypress(function (e) {
    var type = $(this).attr("data-type");
    if (type == "reg") {
        if (e.which == 13) {
            reg();
            return false;
        }
    } else if (type == "login") {
        if (e.which == 13) {
            login();
            return false;
        }
    }
});
$('input[type="password"]').keypress(function (e) {
    var type = $(this).attr("data-type");
    if (type == "reg") {
        if (e.which == 13) {
            reg();
            return false;
        }
    } else if (type == "login") {
        if (e.which == 13) {
            login();
            return false;
        }
    }
});


/// register//


$("#signup-submit").on('click', function () {
    reg();
});

