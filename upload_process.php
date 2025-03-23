<?php
session_start();
require 'db_connection.php'; // Ensure this file connects to your database

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please login first");
    exit();
}

// File Upload Configuration
$targetDir = "uploads/"; // Directory where files will be saved
$allowedExtensions = ['pdf', 'docx', 'xlsx', 'csv']; // Allowed file types
$maxFileSize = 5 * 1024 * 1024; // Max file size (5MB)

// Check if file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["report_file"])) {
    $fileName = basename($_FILES["report_file"]["name"]);
    $fileSize = $_FILES["report_file"]["size"];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $targetFilePath = $targetDir . time() . "_" . $fileName; // Rename file to avoid duplicates

    // Validate file type
    if (!in_array($fileType, $allowedExtensions)) {
        header("Location: upload_report.php?error=Invalid file type. Only PDF, DOCX, XLSX, and CSV allowed.");
        exit();
    }

    // Validate file size
    if ($fileSize > $maxFileSize) {
        header("Location: upload_report.php?error=File too large. Maximum size is 5MB.");
        exit();
    }

    // Move file to target directory
    if (move_uploaded_file($_FILES["report_file"]["tmp_name"], $targetFilePath)) {
        // Insert file details into database
        $stmt = $conn->prepare("INSERT INTO reports (file_name, file_path, uploaded_by) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $fileName, $targetFilePath, $user_id);

        
        if ($stmt->execute()) {
            header("Location: upload_report.php?success=File uploaded successfully!");
        } else {
            header("Location: upload_report.php?error=Database error. Could not save file.");
        }
        $stmt->close();
    } else {
        header("Location: upload_report.php?error=Error uploading file.");
    }
} else {
    header("Location: upload_report.php?error=No file uploaded.");
}

$conn->close();
