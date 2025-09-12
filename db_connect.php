<?php
$host = "localhost"; 
$db_user = "root";   // change if needed
$db_pass = "";       // your DB password
$db_name = "fuel_receipt_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
