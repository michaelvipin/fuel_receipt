<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $vehicle = trim($_POST['vehicle_no']);
    $password = trim($_POST['password']);

    // Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();








    
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "User already exists!";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user (status = active by default)
    $status = "active";
    $role = "user"; // default role

    $stmt = $conn->prepare("INSERT INTO users (name, email, vehicle_no, password, role, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $vehicle, $hashedPassword, $role, $status);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "failed";
    }
}
$conn->close();
?>
