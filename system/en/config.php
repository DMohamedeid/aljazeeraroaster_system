<?php ob_start();

session_start();

$sit_url = "https://localhost/Projects/Work/aljazeeraroaster_system/system/";
date_default_timezone_set('Asia/Bahrain');
ini_set('session.gc_maxlifetime', 3600);

error_reporting(0);


include("connection.php");
include("functions/user_functions.php");
include("functions/parent_cat_functions.php");
include("functions/sub_cat_functions.php");
include("functions/regions_functions.php");
include("functions/navigation_functions.php");
include("functions/client_functions.php");
include("functions/order_functions.php");
include("functions/easyphpthumbnail.php");
include("functions/complaints_functions.php");
include("functions/contacts_functions.php");
include("functions/payments_functions.php");
include("functions/dish_of_day_function.php");
include("functions/removes_function.php");
include("functions/messages_type_function.php");
include("functions/branches_function.php");
include("functions/branches_regions_function.php");
include("functions/drinks_function.php");
include("functions/potatos_function.php");
include("functions/slider_functions.php");
include("functions/latest_functions.php");
include("functions/most_requested_functions.php");
include("functions/payment_delivery_view_functions.php");


function About(){
    global $con;
    $qurey=$con->query("SELECT * FROM `about` WHERE 1 ");
    $data=mysqli_fetch_assoc($qurey);
    return $data;
}

$logo_image=About()['image'];

?>