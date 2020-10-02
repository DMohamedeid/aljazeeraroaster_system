<?php

/*
 * Following code will list all the products
 */
// array for JSON response
$response = array();
header('Content-type: text/html');

// include db connect class
include("db_connect.php");

// connecting to db
$db = new DB_CONNECT();

mysql_query("SET NAMES 'utf8'");

mysql_query("SET CHARACTER SET utf8");

mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");


// get all products from products table

if (isset($_GET['lang']) && $_GET['lang'] != '') {

    $lang = $_GET['lang'];


	$result = mysql_query("SELECT * FROM `setting`") or die(mysql_error());
 
	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// products node
		$response["product"] = array();
	 
		while ($row = mysql_fetch_array($result)) {
			
			// temp user array
			$product = array();
			
			$product["ios_version"] = $row["ios_version"];
			$product["android_version"] = $row["android_version"];
			$product["copyright_name"] = $row["copyright_name"];
			$product["copyright_link"] = $row["copyright_link"];

			// push single product into final response array
			array_push($response["product"], $product);
			
		}
		// success
		$response["success"] = 1;
	 
		// echoing JSON response
		echo json_encode($response);
	
	} else {
			
		$response["product"] = array();
			
		// temp user array
		$product = array();

		// success
		$response["success"] = 1;
	 
		// echoing JSON response
		echo json_encode($response);

	}
} else {
   $result = mysql_query("SELECT * FROM `setting`") or die(mysql_error());
 
	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// products node
		$response["product"] = array();
	 
		while ($row = mysql_fetch_array($result)) {
			
			// temp user array
			$product = array();
			
			$product["ios_version"] = $row["ios_version"];
			$product["android_version"] = $row["android_version"];
			$product["copyright_name"] = $row["copyright_name"];
			$product["copyright_link"] = $row["copyright_link"];

			// push single product into final response array
			array_push($response["product"], $product);
			
		}
		// success
		$response["success"] = 1;
	 
		// echoing JSON response
		echo json_encode($response);
	
	} else {
			
		$response["product"] = array();
			
		// temp user array
		$product = array();

		// success
		$response["success"] = 1;
	 
		// echoing JSON response
		echo json_encode($response);

	}
}
	

?>