<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please log in first.");
    exit();
}

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['reportFile']) && $_FILES['reportFile']['error'] == 0) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['reportFile']['name']);
        $filePath = $uploadDir . time() . "_" . $fileName; // Add timestamp to avoid duplicates
        $userId = $_SESSION['user_id'];

        // Ensure the file is successfully moved before inserting into the database
        if (move_uploaded_file($_FILES['reportFile']['tmp_name'], $filePath)) {
            if (file_exists($filePath)) {
                // Insert into DB
                $stmt = $conn->prepare("INSERT INTO reports (user_id, file_name, file_path) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $userId, $fileName, $filePath);

                if ($stmt->execute()) {
                    $message = "<div class='alert alert-success text-center'>File uploaded successfully!</div>";
                } else {
                    $message = "<div class='alert alert-danger text-center'>Database error: " . $stmt->error . "</div>";
                }
                $stmt->close();
            } else {
                $message = "<div class='alert alert-danger text-center'>File was not saved correctly. Check folder permissions.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger text-center'>Error moving the uploaded file. Check folder permissions.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>Please select a valid file to upload.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Reporting App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="view_reports.php">View Reports</a></li>
                <li class="nav-item"><a class="nav-link active" href="upload.php">Upload Report</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card p-4">
        <h2 class="text-center">Upload a Report</h2>

        <!-- Display error or success message -->
        <?php echo $message; ?>

        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="reportFile" class="form-label">Choose a report file</label>
                <input type="file" class="form-control" name="reportFile" id="reportFile" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload Report</button>
        </form>
    </div>
</div>

</body>
</html>
