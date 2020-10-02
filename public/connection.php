<?php

//$con = mysqli_connect("localhost", "yournightbh_root", "LsE3PkVEAc2f", "yournightbh_system");
//mysqli_query($con, "set character_set_server='utf8'");
//mysqli_query($con, "set names 'utf8'");
//mysqli_query($con, "SET sql_mode=''");

$con = mysqli_connect("localhost", "root", "", "aljazeeraroaster_system");
mysqli_query($con, "set character_set_server='utf8'");
mysqli_query($con, "set names 'utf8'");
// Check connection
if (mysqli_connect_errno()) {
    echo get_error("هناك خطأ فى قاعدة البيانات !");
}

include("site-url.php");
?>