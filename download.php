<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to download files.");
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, filename, file_path FROM reports WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $filename, $file_path);

while ($stmt->fetch()) {
    echo "<a href='$file_path' download>$filename</a><br>";
}
$stmt->close();
?>
