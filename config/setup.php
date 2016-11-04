<?php
session_start();
require_once "database.php";
require_once "../class/Database.class.php";

$start = new Database($DB_DSN, $DB_USER, $DB_PASSWORD);
$conn = $start->server_connect();
print $start->__getReport();
$start->create_schema($conn);
?>
