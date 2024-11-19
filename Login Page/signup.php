<?php
session_start();
require 'config.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $role])) {
        echo "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        echo "Registration failed! Username might already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <div class="signup-container">
        <h1>Create an Account</h1>
        <form action="signup_process.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <!-- Dropdown for selecting user or admin role -->
            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>


