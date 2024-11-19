<?php
session_start();

// Check if the cart session array exists; if not, create it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Retrieve product details from POST request
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];

// Create a product array
$product = [
    'id' => $product_id,
    'name' => $product_name,
    'price' => $product_price,
    'quantity' => 1,
];

// Check if the product is already in the cart
$found = false;
foreach ($_SESSION['cart'] as &$cart_item) {
    if ($cart_item['id'] == $product_id) {
        // Increase quantity if product exists in the cart
        $cart_item['quantity'] += 1;
        $found = true;
        break;
    }
}

// If the product is not in the cart, add it
if (!$found) {
    $_SESSION['cart'][] = $product;
}

// Redirect to cart page
header("Location: cart.php");
exit();
?>
