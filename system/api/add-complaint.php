<?php

// getting server ip address
$server_ip = gethostbyname(gethostname());

// array for final json respone
$response = array();

// final file url that is being uploaded
// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");


// get all products from products table
// Start Functionality  

if (isset($_POST) && !empty($_POST)) {

    $client_id = $_POST['client_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $result = mysql_query("INSERT INTO complaints(client_id,title,content,date) 
	VALUES('$client_id','$title','$content','" . date("Y-m-d H:i:s") . "')");
    $complaint_id = mysql_insert_id();

    $client_name = get_client_name_from_id($client_id);
    $client_phone = get_client_phone_from_id($client_id);
    $to = "jazeera.bahrain@gmail.com";
    $subject = "Al-Jazeera Roastery - New Complaint";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .="From:info@emcan-group.com\r\n" . "Reply-To:Info@emcan-group.com\r\n";

    $message = "Client Name : <br />" . $client_name . "<br /> <br />";
    $message .= "Phone : <br />" . $client_phone . "<br /> <br />";
    $message .= "Title: <br />" . $title . "<br /> <br />";
    $message .= "Content : <br />" . $content;

    mail($to, $subject, $message, $headers);
    $to = "emcancomplaints@gmail.com";
    $subject = "Al-Jazeera Roastery - New Complaint";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .="From:info@emcan-group.com\r\n" . "Reply-To:Info@emcan-group.com\r\n";


    $message = "Client Name : <br />" . $client_name . "<br /> <br />";
    $message .= "Phone : <br />" . $client_phone . "<br /> <br />";
    $message .= "Title: <br />" . $title . "<br /> <br />";
    $message .= "Content : <br />" . $content;

    mail($to, $subject, $message, $headers);

    if (!file_exists("uploads/complaints/" . $complaint_id)) {
        mkdir("uploads/complaints/" . $complaint_id, 0777, true);
    }

// Path to move uploaded files
    $path = "uploads/complaints/" . $complaint_id . '/';

    $file_upload_url = 'http://aljazeeraroastery.com/system/api/';
    $itr = $_POST['itr'];
    for ($i = 1; $i <= $itr; $i++) {
        // Path to move uploaded files

        if (isset($_FILES['image_' . $i . '']['name']) && !empty($_FILES['image_' . $i . '']['name'])) {
            $photo_name = $_FILES['image_' . $i . '']['name'];
            $photo_tmp = $_FILES['image_' . $i . '']['tmp_name'];

            $target_path = $path . $photo_name;
            $image_database = $file_upload_url . $target_path;
            $add_adv_images = mysql_query("INSERT INTO complaint_images(complaint_id,image) 
	VALUES('$complaint_id','$image_database')");

            // reading other post parameters

            $response['file_name'] = basename($photo_name);

            try {
                // Throws exception incase file is not being moved
                if (!move_uploaded_file($photo_tmp, $target_path)) {
                    // make error flag true
                    $response['error'] = true;
                    $response['message'] = 'Could not move the file!';
                }

                // File successfully uploaded
                $response['message'] = 'File uploaded successfully!';
                $response['error'] = false;
                $response['file_path'] = $file_upload_url . basename($photo_name);
            } catch (Exception $e) {
                // Exception occurred. Make error flag true
                $response['error'] = true;
                $response['message'] = $e->getMessage();
            }
        }
    }
    $response["product"] = array();

    // temp user array
    $product = array();
    $product["complaint_id"] = $complaint_id;

    // push single product into final response array
    array_push($response["product"], $product);


    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Successfully Added.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "عفوا لقد حدث خطأ";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";

    // echoing JSON response
    echo json_encode($response);
}
?>