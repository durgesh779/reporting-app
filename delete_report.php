<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Get the file path before deleting
    $stmt = $conn->prepare("SELECT file_path FROM reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($file_path);
    $stmt->fetch();
    $stmt->close();

    // Delete the report record
    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $report_id);
    if ($stmt->execute()) {
        // Delete the actual file from the server
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        header("Location: admin_dashboard.php?msg=Report Deleted");
    } else {
        header("Location: admin_dashboard.php?msg=Error Deleting Report");
    }
}
?>
