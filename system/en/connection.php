<?php
//   $con = mysqli_connect("localhost","root","","emcangroup_sofra");
//   mysqli_query($con,"set character_set_server='utf8'");
//   mysqli_query($con,"set names 'utf8'");
$con = mysqli_connect("localhost","root","","aljazeeraroaster_system");
mysqli_query($con,"set character_set_server='utf8'");
mysqli_query($con,"set names 'utf8'");
mysqli_query($con, "SET sql_mode=''");

// Check connection
if (mysqli_connect_errno()) {
  echo get_error("There is an error in the database !") ;
}

function loggedin()	{
	if(isset($_SESSION['user_id'])) {
	   $loggedin = TRUE;
	   return $loggedin;
	}
}

function get_error($the_error) {
	$get_error = '<div style="top: 0px; left: 0px;" class="notifyjs-corner"><div class="notifyjs-wrapper notifyjs-hidable">
	  <div class="notifyjs-arrow" style=""></div>
	  <div class="notifyjs-container" style=""><div class="notifyjs-metro-base notifyjs-metro-error">
	  <div data-notify-html="image" class="image"><i class="fa fa-exclamation"></i></div><div class="text-wrapper">
	  <div data-notify-html="title" class="title"> '.$the_error.' </div>
	  <div data-notify-html="text" class="text"> '.$the_error.' </div></div></div></div>
	</div></div>';
	return $get_error;
}

function get_success($the_success) {
	$get_success = '<div style="top: 0px; left: 0px;" class="notifyjs-corner"><div class="notifyjs-wrapper notifyjs-hidable">
  <div class="notifyjs-arrow" style=""></div>
  <div class="notifyjs-container" style=""><div class="notifyjs-metro-base notifyjs-metro-success">
  <div data-notify-html="image" class="image"><i class="fa fa-check"></i></div><div class="text-wrapper">
  <div data-notify-html="title" class="title">'.$the_success.'</div>
  <div data-notify-html="text" class="text">'.$the_success.'</div></div></div></div></div></div>';
	return $get_success;
}

?>