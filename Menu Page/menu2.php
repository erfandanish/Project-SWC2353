<?php
// Start the session and include the database connection
session_start();
include('db_connection.php');

// Sample array of chocolate products (you can remove this once you fetch from DB)
$products = [];
// Fetch products from the database for Chocolate category (category_id = 2)
$query = "SELECT * FROM products WHERE category_id = 2"; // Chocolate category_id = 2
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = [
            'name' => $row['product_name'],
            'price' => $row['product_price'],
            'image' => $row['image_path']
        ];
    }
} else {
    echo "Error fetching products: " . mysqli_error($conn);
}

// Handle adding items to the cart (same as before)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product'];
    $productPrice = $_POST['price'];

    // Check if the product already exists in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $productName) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    // If the product is not in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $productName,
            'price' => (float)$productPrice,
            'quantity' => 1,
            'id' => uniqid() // Unique ID for each item
        ];
    }

    $_SESSION['message'] = "$productName has been added to your cart!";
    
    // Redirect to reload the page without resubmitting the form
    header("Location: menu2.php");
    exit;
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chocolate Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="menu1.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="mainWrapper">
  <header> 
      <div id="logo"> 
          <a href="index3.html"><img src="Images/[removal.ai]_9651b07c-253f-4750-b768-9fe85fca1f47-brews.png" alt="" width="160" height="130"></a>
      </div>
      <div class="nav bar">
          <nav>
              <ul>
                  <li><a href="menu.php">Menu</a></li>
                  <li><a href="aboutus.html">About Us</a></li> 
                  <li><a href="rewards.html">Rewards</a></li>
                  <li><a href="brews.html">Brews & Tips</a></li>
				  <a href="login.php"><img src="Images/login-computer-icons-download-avatar-icon-thumbnail.jpg" width="40" height="40" alt="login"></a>
                  <li><a href="cart.php"><img src="Images/free-add-to-cart-icon-3046-thumb.png" width="40" height="41" alt="cart"></a></li>
              </ul>
          </nav>
      </div>
  </header>

    <section id="offer">
        <h2>Awaken Your Senses.</h2>
        <p>Let our brews inspire your moments of joy</p>
    </section>

    <div id="content">
        <section class="sidebar">
            <div id="menubar">
                <nav class="menu">
                    <h2>DRINKS</h2>
                    <hr>
                    <ul>
                        <li><a href="menu.php">Big Three (Top Picks)</a></li>
                        <li><a href="menu1.php">Coffee</a></li>
                        <li><a href="menu2.php" class="active">Chocolate</a></li>
                        <li><a href="menu3.php">Smoothie</a></li>
                    </ul>
                </nav>
            </div>
      </section>

        <!-- Success Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <p class="success-message"><?= $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <section class="mainContent">
            <div class="productRow">
                <?php
                // Loop through products and display them
                foreach ($products as $product) {
                    echo '<article class="productInfo">';
                    
                    // Display the product image
                    echo '<div><img alt="' . htmlspecialchars($product['name']) . '" src="' . htmlspecialchars($product['image']) . '" width="100" height="100"></div>';
                    
                    // Display product price and name
                    echo '<p class="price">RM ' . number_format($product['price'], 2) . '</p>';
                    echo '<p class="productContent">' . htmlspecialchars($product['name']) . '</p>';
                    
                    // Add to cart form
                    echo '<form action="menu2.php" method="POST">';
                    echo '<input type="hidden" name="product" value="' . htmlspecialchars($product['name']) . '">';
                    echo '<input type="hidden" name="price" value="' . htmlspecialchars($product['price']) . '">';
                    echo '<button type="submit" class="buyButton">Add To Cart</button>';
                    echo '</form>';
                    echo '</article>';
                }
                ?>
            </div>
        </section>

  </div>

    <!-- Footer -->
  <footer>
        <div>
            <p>© Brews & Views 2024. ALL COPYRIGHT RESERVED.</p>
        </div>
        <div class="footerlinks">
            <p><a href="index3.html">Home</a></p>
            <p><a href="menu.php">Menu</a></p>
            <p><a href="rewards.php">Rewards</a></p>
            <p><a href="brews.php">Brews & Tips</a></p>
        </div>
  </footer>
</div>
</body>
</html>
