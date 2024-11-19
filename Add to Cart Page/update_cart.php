<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $action = $_POST['action'];

    // Find the product in the cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            if ($action === 'increase') {
                $item['quantity']++;
            } elseif ($action === 'decrease' && $item['quantity'] > 1) {
                $item['quantity']--;
            }
            break;
        }
    }

    // Redirect back to the cart
    header('Location: cart.php');
    exit();
}
?>
