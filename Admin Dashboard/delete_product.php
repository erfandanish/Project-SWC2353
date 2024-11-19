<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'brews_views_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle product deletion
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Delete product from database
    $sql = "DELETE FROM products WHERE product_id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
<link href="delete_product.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Delete Product</h1>
    <a href="admin_dashboard.php">Back to Dashboard</a>

    <form action="delete_product.php" method="GET">
        <label>Enter Product ID to Delete:</label><br>
        <input type="number" name="product_id" required><br><br>
        <input type="submit" value="Delete Product">
    </form>
</body>
</html>
