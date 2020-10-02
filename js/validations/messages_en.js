(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery", "../jquery.validate"], factory);
    } else if (typeof module === "object" && module.exports) {
        module.exports = factory(require("jquery"));
    } else {
        factory(jQuery);
    }
}(function ($) {

    /*
     * Translated default messages for the jQuery validation plugin.
     * Locale: AR (Arabic; العربية)
     */
    $.extend($.validator.messages, {
        required: "This field is required" ,
        lettersonly: "Must enter letters only",
        remote: "Correct this field to continuo",
        email: "Please Enter A Valid E-Mail Address",
        url: "Please Enter A Valid URL",
        date: "Please Enter A Valid date",
        dateISO: "Please Enter A Valid(ISO)",
        number: "Please Enter A Valid Number",
        digits: "Please Enter A Valid Digit",
        creditcard: "Please Enter A Valid credit card",
        equalTo: "This value must be the same",
        extension: "Please Enter A Valid Extension",
        maxlength: $.validator.format("Muximum Length is {0}"),
        minlength: $.validator.format("Minimum Length is {0}"),
        rangelength: $.validator.format("Number of letters between {0} and {1}"),
        range: $.validator.format("Number of digits between{0} and {1}"),
        max: $.validator.format("Please enter number greater than or equal{0}"),
        min: $.validator.format("Please enter number less than or equal {0}")
    });
    return $;
}));