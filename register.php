<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Reporting App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; }
        .container { max-width: 400px; margin-top: 100px; }
        .card { border-radius: 10px; }
        .btn-success { background-color: #2ecc71; border: none; }
        .btn-primary { background-color: #3498db; border: none; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow p-4">
        <h2 class="text-center text-success">Register</h2>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
        <hr>
        <p class="text-center">Already have an account?</p>
        <a href="login.php" class="btn btn-primary w-100">Login</a>
    </div>
</div>

</body>
</html>
