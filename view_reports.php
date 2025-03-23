<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Define the uploads directory
$uploadsDir = __DIR__ . "/uploads"; // Absolute path
$webPath = "uploads/"; // Relative path for links

// Check if directory exists
if (!is_dir($uploadsDir)) {
    die("<p>Error: The uploads directory does not exist.</p>");
}

// Scan for files in the uploads directory
$files = array_diff(scandir($uploadsDir), array('.', '..'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 0; }
        .navbar { background: #2c3e50; padding: 10px; text-align: center; }
        .navbar a { color: white; text-decoration: none; padding: 10px 20px; margin: 0 10px; display: inline-block; }
        .navbar a:hover { background: #1abc9c; border-radius: 5px; }
        .container { margin-top: 20px; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; color: blue; }
        .btn { background-color: green; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="upload.php">Upload Report</a>
    <a href="view_reports.php">View Reports</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>Available Reports</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Report Name</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            foreach ($files as $file): 
                $filePath = $webPath . $file;
            ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo htmlspecialchars($file); ?></td>
                    <td>
                        <a href="<?php echo $filePath; ?>" class="btn" download>Download</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <?php if (empty($files)): ?>
                <tr>
                    <td colspan="3" class="text-center"><strong>No reports available.</strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
