<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'brews_views_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search query
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Query to get products based on the search
$sql = "SELECT product_id, product_name, product_price, image_path, category_id 
        FROM products 
        WHERE product_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="view_products.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Product List</h1>	
<a href="admin_dashboard.php">Back to Dashboard</a>

    <!-- Search Form -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search Products..." value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
    </form>

<table border="1">
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Image</th>
            <th>Category ID</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["product_id"] . "</td>";
                echo "<td>" . $row["product_name"] . "</td>";
                echo "<td>" . $row["product_price"] . "</td>";
                // Display the product image
                echo "<td><img src='Images/" . htmlspecialchars(basename($row["image_path"])) . "' alt='" . htmlspecialchars($row["product_name"]) . "' width='100'></td>";
                echo "<td>" . $row["category_id"] . "</td>";
                // Add an "Update" button linking to update_product.php with the product_id
                echo "<td><a href='update_product.php?product_id=" . $row["product_id"] . "'>Update</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
