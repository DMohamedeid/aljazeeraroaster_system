<?php

include("public/site-url.php");

setcookie('client_id', '', time() - 3600, '/');
setcookie('client_password', '', time() - 3600, '/');
header("Location:" . $site_url . "login.php");
?>