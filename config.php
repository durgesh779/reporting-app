<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reporting_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If user is logged in, store their role
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($role);
    $stmt->fetch();
    $_SESSION['role'] = $role;
    $stmt->close();
}
?>
