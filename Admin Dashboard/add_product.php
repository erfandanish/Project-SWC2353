<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'brews_views_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $category_id = $_POST['category_id'];

    // Handle file upload
    $upload_dir = "Images/";  // This is the relative directory
    $upload_file = $upload_dir . basename($_FILES["image_path"]["name"]);

    // Move the uploaded file to the server
    if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $upload_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["image_path"]["name"])) . " has been uploaded.";

        // Insert product data along with image path into the database
        $sql = "INSERT INTO products (product_name, product_price, image_path, category_id) 
                VALUES ('$product_name', '$product_price', '$upload_file', '$category_id')";

        if ($conn->query($sql) === TRUE) {
            echo "New product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the image file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
<link href="add_product.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Add New Product</h1>
    <a href="admin_dashboard.php">Back to Dashboard</a>

    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" required><br><br>

        <label>Product Price:</label><br>
        <input type="number" name="product_price" required step="0.01"><br><br>

        <label>Image:</label><br>
        <input type="file" name="image_path" accept="image/*" required><br><br>

        <label>Category:</label><br>
        <select name="category_id" required>
            <option value="1">1 - Coffee</option>
            <option value="2">2 - Chocolate</option>
            <option value="3">3 - Smoothie</option>
        </select><br><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>
