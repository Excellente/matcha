<?php
session_start();
require_once "database.php";
require_once "../db_object.php";
require_once "../class/Database.class.php";

$conn = $start->server_connect();
print $start->__getReport();
$start->create_schema($conn);
?>
