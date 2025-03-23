<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Reporting App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Welcome, <?php echo $_SESSION['username']; ?> (Admin)!</h2>
    <p>Manage reports and users from here.</p>
    <a href="upload.php" class="btn btn-primary">Upload Report</a>
    <a href="view_reports.php" class="btn btn-info">View Reports</a>
    <a href="manage_users.php" class="btn btn-warning">Manage Users</a>
</div>

</body>
</html>
