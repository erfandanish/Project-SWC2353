<?php
session_start();
require 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        
        if ($user['role'] === 'admin') {
            // If the user is an admin, redirect to admin dashboard
            header("Location: admin_dashboard.php");
        } else {
            // If the user is a regular user, redirect to index3.html
            header("Location: index3.html");
        }
        exit();
    } else {
        // Invalid login attempt
        echo "<p>Invalid username or password. Please try again.</p>";
        echo "<p><a href='login.php'>Back to Login</a></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> >
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <h3>Don't have an account? <a href="signup.php">Sign up</a> right now! </h3>
</body>
</html>
