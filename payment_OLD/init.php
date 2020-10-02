<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/** Request Processing**/
//Merchant can connect iPay Benefit Plugin with the below step
require('iPayBenefitPipe.php');
$myObj =new iPayBenefitPipe();
//initialization
$resourcePath = "resource/";
$keystorePath = "resource/";

$ResponseURL= "https://aljazeeraroastery.com/payment/Response.php";

$errorURL= "https://aljazeeraroastery.com/payment/Error.php";
$action="1"; // 1–Purchase
$aliasName = "test03957950"; //Terminal Alias Name.
$currency = "048"; //Transaction Currency. (ex: “414”)
$language = "USA"; //(ex: “USA”)
$amount="10.000"; //Transaction Amount.
$track_number=rand(1, 1000000);
$trackid = $track_number; //Merchant Track ID.
//User Defined Fields.
$Udf2= "Udf2";
$Udf3= "Udf3";
$Udf4="Udf4";
$Udf5="saaaaaaafy";
//Set Values
$myObj->setResourcePath($resourcePath);
$myObj->setKeystorePath($keystorePath);
$myObj->setAlias($aliasName);
$myObj->setAction( $action );
$myObj->setCurrency($currency);
$myObj->setLanguage($language);
$myObj->setResponseURL($ResponseURL );
$myObj->setErrorURL($errorURL);
$myObj->setAmt($amount);
$myObj->setTrackId($trackid);
$myObj->setUdf2($Udf2);
$myObj->setUdf3($Udf3);
$myObj->setUdf4($Udf4);
$myObj->setUdf5($Udf5);




/** For Bank Hosted Payment Integration, the method to be called is **/
if(trim($myObj->performPaymentInitializationHTTP())!=0)
{
echo("ERROR OCCURED! SEE CONSOLE FOR MORE DETAILS");
return;
}else{
$url=$myObj->getwebAddress();
echo "<meta http-equiv='refresh' content='0;url=$url'>";
}
/** End of Request Processing**/


?>