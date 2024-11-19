<?php
// Start the session and include the database connection
session_start();
$conn = new mysqli('localhost', 'root', '', 'brews_views_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize product variable
$product = null;

// Get product data to update
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $result = $conn->query("SELECT * FROM products WHERE product_id = '$product_id'");
    if ($result) {
        $product = $result->fetch_assoc();
    } else {
        echo "Error fetching product: " . $conn->error;
    }
}

// Fetch categories from database
$categoryResult = $conn->query("SELECT id, category_name FROM categories");

// Handle form submission for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $category_id = $_POST['category_id'];

    // Handle file upload for image
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == UPLOAD_ERR_OK) {
        // If a new image is uploaded, move the file and set the path
        $image_path = 'Images/' . basename($_FILES['image_path']['name']);
        move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path);
    } else {
        // If no new image is uploaded, use the current image path
        $image_path = $product['image_path'];
    }

    // Debugging: Check what image path is being set
    // echo $image_path;

    // Prepare the update SQL statement
    $sql = "UPDATE products SET product_name='$product_name', product_price='$product_price', image_path='$image_path', category_id='$category_id' WHERE product_id='$product_id'";

    // Execute the update query
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Product updated successfully!";
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="update_product.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Update Product</h1>
    <a href="admin_dashboard.php">Back to Dashboard</a>

    <?php if ($product): ?>
    <form action="update_product.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <label>Product Name:</label><br>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br><br>

        <label>Product Price:</label><br>
        <input type="number" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required step="0.01"><br><br>

        <label>Image:</label><br>
        <input type="file" name="image_path"><br><br>
        <!-- Show current image if exists -->
        <?php if (!empty($product['image_path'])): ?>
            <img src="<?php echo $product['image_path']; ?>" alt="Current Image" width="100"><br><br>
        <?php endif; ?>

        <label>Category:</label><br>
        <select name="category_id" required>
            <?php
            if ($categoryResult->num_rows > 0) {
                while ($row = $categoryResult->fetch_assoc()) {
                    $selected = ($row['id'] == $product['category_id']) ? 'selected' : '';
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['id'] . " - " . htmlspecialchars($row['category_name']) . "</option>";
                }
            }
            ?>
        </select><br><br>

        <input type="submit" value="Update Product">
    </form>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</body>
</html>
