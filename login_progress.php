<?php
session_start();
require 'db_connection.php'; // Ensure your database connection file is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Fetch user details
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: login.php?error=Invalid credentials");
                exit();
            }
        } else {
            header("Location: login.php?error=Invalid credentials");
            exit();
        }
    } else {
        header("Location: login.php?error=All fields are required");
        exit();
    }
}
?>
