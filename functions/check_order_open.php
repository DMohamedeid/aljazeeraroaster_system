<?php

include("../public/functions.php");
include("../public/connection.php");


$result = $con->query("SELECT * FROM `setting` where id=1") or die(mysqli_error());
$row = mysqli_fetch_array($result);

$response["accept_orders"] = $row["accept_orders"];

echo json_encode($response["accept_orders"]);
?>
