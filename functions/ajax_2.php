<?php

include("../public/site-url.php");
include("../public/functions.php");
include("../public/connection.php");
if (isset($_POST['payment']) && $_POST['payment'] != '') {
    $set_payment = $_POST['payment'];
    $client_id = $_POST['client_id'];
    $cart_id = $_POST['cart_id'];
    $set_client_address_id = $_POST['client_address_id'];
    $deliver_id = $_POST['deliver_id'];

    setcookie("payment", $set_payment, time() + 60 * 60 * 24 * 2, '/');
    setcookie("client_address_id", $set_client_address_id, time() + 60 * 60 * 24 * 2, '/');
    setcookie("client_id", $client_id, time() + 60 * 60 * 24 * 2, '/');
    setcookie("deliver_id", $deliver_id, time() + 60 * 60 * 24 * 2, '/');
    setcookie("cart_id", $cart_id, time() + 60 * 60 * 24 * 2, '/');


    echo "1";
    die();
}

if (isset($_GET['ac']) && $_GET['ac'] == 'save') {
    include("../public/connection.php");

    $temp = $_POST;
    $name = $temp['name'];
    $email = $temp['email'];
    $subject_added = $temp['subject'];
    $title = $temp['title'];
    $send = $con->query("INSERT INTO contact_us(name,email,title,subject,date_added) VALUES('$name','$email','$title','$subject_added','" . date("Y-m-d H:i:s") . "')");
    if ($send) {
        $to = get_email_for_send_actions();
        $subject = " Aljazeeraroastery - الجزيزة ";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "From: Your Neight " . $email . "\r\n" . "Reply-To:Info@emcan-group.com\r\n";
        $message = 'الإسم:' . $name . "\n";
        $message .= 'عنوان الرسالة:' . $title . "\n";
        $message .= 'محتوى الرسالة:' . $subject_added . "\n";
        mail($to, $subject, $message, $headers);
        echo 1;
    } else {
        echo 0;
    }
    exit();
}

if (isset($_POST['change_lang']) && $_POST['change_lang'] != '') {
    $change_lang = $_POST['change_lang'];
    setcookie('lang', '', time() - 3600, '/');
    setcookie("lang", $change_lang, time() + 60 * 60 * 24 * 2, '/');
    echo 1;
    exit();
}
?>
