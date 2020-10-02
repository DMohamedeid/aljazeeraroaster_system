<?php
require_once __DIR__ . '/db_config.php';

$con = mysqli_connect("localhost", "root", "", "aljazeeraroaster_system");
mysqli_query($con, "set character_set_server='utf8'");
mysqli_query($con, "set names 'utf8'");
