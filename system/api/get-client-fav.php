<?php
/*
 * Following code will list all the products
*/
// array for JSON response
$response = array();
 
// include db connect class
  include("db_connect.php");
 
// connecting to db
$db = new DB_CONNECT();

    mysql_query("SET NAMES 'utf8'");

    mysql_query("SET CHARACTER SET utf8");

    mysql_query("SET SESSION collation_connection = 'utf8_unicode_ci'");


// get all products from products table

if (isset($_GET['client_id'])) {

	$client_id = $_GET['client_id'];
	$lang = $_GET['lang'];

	$result = mysql_query("SELECT sub_categories.*,client_fav.fav_id,client_fav.client_id FROM `client_fav` left join sub_categories on sub_categories.sub_category_id=client_fav.sub_category_id WHERE client_fav.`client_id`='$client_id' and sub_categories.`display`=1  ") or die(mysql_error());
 
	// check for empty result
	if (mysql_num_rows($result) > 0) {
		// looping through all results
		// products node
		$response["product"] = array();
	 
		while ($row = mysql_fetch_array($result)) {
			
			// temp user array
			$product = array();
			
			$product["fav_id"] = $row["fav_id"];
			$product["client_id"] = $row["client_id"];
        	$product["sub_category_id"] = $row["sub_category_id"];
            if ($lang == "ar") {
                $product["sub_category_name"] = $row["sub_category_name_ar"];
                $product["sub_category_desc"] = $row["sub_category_desc_ar"];
            } else {
                $product["sub_category_name"] = $row["sub_category_name"];
                $product["sub_category_desc"] = $row["sub_category_desc"];
            }
            $product["sub_category_image"] = $row["sub_category_image"];
            $product["spicy_show"] = $row["spicy_show"];
            $product["parent_category_id"] = $row["parent_category_id"];
            $parent_category_id = $row["parent_category_id"];
            $sub_category_id = $row["sub_category_id"];
            $product["sizes"] = get_sizes($lang,$sub_category_id);

            $product["evaluate"] = resume_evaluate($sub_category_id);
            $product["sub_category_fav"] = 1;
            $product["type"] =get_category_type_from_id($parent_category_id);


			
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
    // no products found
    $response["success"] = 0;
    $response["message"] = "هناك بيانات مفقوده برجاء مراجعة بياناتك";
 
    // echo no users JSON
    echo json_encode($response);
}
?>