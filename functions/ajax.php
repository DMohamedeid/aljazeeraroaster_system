<?php

include("../public/functions.php");
include("../public/connection.php");
if (isset($_POST['email_subscribe']) && $_POST['email_subscribe'] != '') {

    $client_email = $_POST['email_subscribe'];

    $result = $con->query("SELECT * FROM `subscriptions` WHERE `email`='$client_email' ORDER BY `id` DESC limit 1") or die(mysqli_error());
    // check for empty result
    if (mysqli_num_rows($result) > 0) {


        // no products found
        $response["success"] = 0;
        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "Sorry, this Email is  subscriped before";
        } else {
            $response["message"] = "عفوا،هذا الإيميل  مسجل من قبل";
        }
        // echo no clients JSON
        echo json_encode($response);
    } else {
        $result = $con->query("INSERT INTO subscriptions(email) VALUES('$client_email')");


        $message = 'تم الإشتراك بنجاح';
        $to = $client_email;
        $subject = "Aljazeeraroastery - Forget Password";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .="From: Aljazeeraroastery " . get_email_for_send_actions() . "\r\n" . "Reply-To:apps@emcan-group.com\r\n";
        mail($to, $subject, $message, $headers);

        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "subscriped Successfully";
        } else {
            $response["message"] = "تم الإشتراك بنجاح";
        }
        $response["success"] = 1;
        // echoing JSON response
        echo json_encode($response);
    }
    die();
}
if (isset($_POST['email']) && $_POST['email'] != '') {

    $client_email = $_POST['email'];
    $contact = $con->query("SELECT * FROM `contact`") or die(mysqli_error());
    $row = mysqli_fetch_array($contact);
    $email = $row["email"];


    $result = $con->query("SELECT * FROM `clients` WHERE `client_email`='$client_email' ORDER BY `client_id` DESC limit 1") or die(mysqli_error());
    // check for empty result
    if (mysqli_num_rows($result) > 0) {
        // looping through all results
        // products node
        $row_select = mysqli_fetch_array($result);


        $password = $row_select["client_password"];


        $message = 'Your Password is: ' . $password;
        $to = $client_email;
        $subject = "Aljazeeraroastery - Forget Password";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .="From: Aljazeeraroastery " . get_email_for_send_actions() . "\r\n" . "Reply-To:apps@emcan-group.com\r\n";
        mail($to, $subject, $message, $headers);

        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "Successfully,Password is sent to email";
        } else {
            $response["message"] = "تم إرسال رقم المرور الي الإيميل";
        }
        $response["success"] = 1;
        // echoing JSON response
        echo json_encode($response);
    } else {

        // no products found
        $response["success"] = 0;
        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "Sorry, this Email is not registered before";
        } else {
            $response["message"] = "عفوا،هذا الإيميل غير مسجل من قبل";
        }
        // echo no clients JSON
        echo json_encode($response);
    }
    die();
}

if (empty($client_info['client_id'])) {
    if (isset($_GET['ac']) && $_GET['ac'] == 'login') {
        $temp = $_POST;
        $res = check_client_login($temp);
        if ($res == "error_pass") {
            echo $res;
            die();
        } elseif ($res == "noactive") {
            echo $res;
            die();
        } elseif ($res == "1") {
            echo "1";
            die();
        } elseif (!$res) {
            echo "no";
            die();
        }
    }
} else {
    header("Location:" . $site_url);
}


if (isset($_POST['get_client_id'])) {
    $get_client_id = $_POST['get_client_id'];
    $sub_category_id = $_POST['data_id'];
    $data_fav = $_POST['data_fav'];
    if ($data_fav == 0) {
        $result = $con->query("INSERT INTO client_fav(client_id,sub_category_id) VALUES('$get_client_id','$sub_category_id')");
    } elseif ($data_fav == 1) {
        $result = $con->query("DELETE FROM `client_fav` WHERE `client_id`='$get_client_id' AND `sub_category_id`='$sub_category_id'");
    }
    if ($result) {
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}
if (isset($_POST['password']) && $_POST['password'] != '') {

    $client_id = $_POST['client_id'];
    $old_password = $_POST['old_password'];
    $password = $_POST['password'];

    $result = $con->query("SELECT * FROM `clients` WHERE `client_id`='$client_id' and `client_password`='$old_password' ORDER BY `client_id` DESC limit 1") or die(mysqli_error());
    // check for empty result
    if (mysqli_num_rows($result) > 0) {
        // looping through all results

        if ($old_password == $password) {
            // no products found
            $response["success"] = 0;
            if ($_COOKIE['lang'] == "en") {
                $response["message"] = "Please Enter Different Password ";
            } else {
                $response["message"] = "برجاء إدخال كلمة مرور لم يعد إستخدامها من قبل";
            }
            // echo no clients JSON
            echo json_encode($response);
        } else {
            $update = $con->query("UPDATE `clients` SET `client_password`='$password' WHERE `client_id`='$client_id'");
            if ($_COOKIE['lang'] == "en") {
                $response["message"] = "Password is Updated Successfully";
            } else {
                $response["message"] = "تم تحديث كلمة المرور بنجاح";
            }
            $response["success"] = 1;
            // echoing JSON response
            echo json_encode($response);
        }
    } else {

        // no products found
        $response["success"] = 0;
        if ($_COOKIE['lang'] == "en") {
            $response["message"] = "Sorry,Old Password Is Wrong";
        } else {
            $response["message"] = "عفوا،كلمة المرور القديمة غير صحيحة";
        }
        // echo no clients JSON
        echo json_encode($response);
    }
}

if (isset($_POST['data_remove'])) {
    $client_address_id = $_POST['data_remove'];

    $result = $con->query("DELETE FROM `client_addresses` WHERE `client_address_id`='$client_address_id'");

    if ($result) {
        $mes['success'] = 1;
        if ($_COOKIE['lang'] == "en") {
            $mes['massge'] = "Added Successfully!";
        } else {
            $mes["massge"] = "تم الإضافة بنجاح";
        }
        echo json_encode($mes);
        exit();
    } else {
        $mes['success'] = 0;
        if ($_COOKIE['lang'] == "en") {
            $mes['massge'] = "Sorry,there is an error!";
        } else {
            $mes["massge"] = "عفوا،لقد حدث خطأ  ";
        }
        echo json_encode($mes);
        exit();
    }
}
?>
