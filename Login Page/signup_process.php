<link href="signup_process.css" rel="stylesheet" type="text/css">
<?php
session_start();
require 'config.php'; // Assumes 'config.php' sets up the database connection in `$pdo`

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // Get the selected role from the form

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        echo "<p>Username already exists. Please choose a different one.</p>";
        echo "<p><a href='signup.php'>Back to Signup</a></p>";
		echo "<p><a href='login.php'> Already have an Account?</a></p>";
        exit();
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database with selected role
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $role]);

    echo "<h1>Account created successfully!</h1>";
    echo "<p><a href='login.php'>Go to Login</a></p>";
}
?>
