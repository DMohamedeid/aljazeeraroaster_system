
window.onload = function () {
    render();
};
function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}
function phoneAuth() {
    var ths_form = $('#client-reg');
    if (lang == "ar") {
        var txt_failed = "عفوا،لقد حدث خطأ";
        var txt_success = "تم ارسال الرسالة بنجاح";

    } else {
        var txt_success = "Message Is Sent Successfully";
        var txt_failed = "Sorry,there is an error";

    }
    if (ths_form.valid()) {
//get the number
        var number = document.getElementById('client_phone').value;
//        number = '+' + 20 + number;
        number = '+' + 973 + number;
        //phone number authentication function of firebase
        //it takes two parameter first one is number,,,second one is recaptcha
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
//s is in lowercase
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            console.log(coderesult);
            $.toast({
                heading: txt_success,
                text: txt_success,
                showHideTransition: 'slide',
                icon: 'success'
            });
            $("#Phone_Verification").css("display", "block");
            $("#Regis").css("display", "none");
        }).catch(function (error) {
//        alert(error.message);
            $.toast({
                heading: error.message,
                text: error.message,
                showHideTransition: 'slide',
                icon: 'error'
            });
        });
    }
}
function codeverify() {
    var code = document.getElementById('verificationCode').value;
    coderesult.confirm(code).then(function (result) {
//        alert("Successfully registered");
        var ths_form = $('#client-reg');
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
                window.location.href = site_url + '/index.php';
//                window.location.href = site_url + lang + '/index.php';
            }

        });


//        var user = result.user;
//        console.log(user);
    }).catch(function (error) {
        $.toast({
            heading: error.message,
            text: error.message,
            showHideTransition: 'slide',
            icon: 'error'
        });
    });
}