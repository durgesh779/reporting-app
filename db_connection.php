<?php
$host = '10.0.2.28'; // Change this
$user = 'app_user';
$password = 'securepassword';
$database = 'reporting_app';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
