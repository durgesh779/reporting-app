<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please log in first.");
    exit();
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
                <li class="nav-item"><a class="nav-link active" href="upload_report.php">Upload Report</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card p-4">
        <h2 class="text-center">Upload a Report</h2>

        <!-- Error & Success Message Display -->
        <?php if (isset($_GET['error']) && !empty($_GET['error'])): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php elseif (isset($_GET['success']) && !empty($_GET['success'])): ?>
            <div class="alert alert-success text-center"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <form action="upload_process.php" method="POST" enctype="multipart/form-data">
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
