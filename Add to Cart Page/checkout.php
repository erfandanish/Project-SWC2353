<?php
session_start();

// Clear the cart after checkout
$_SESSION['cart'] = [];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Checkout Confirmation</title>
    <link href="checkout.css" rel="stylesheet" type="text/css"> <!-- Link to external CSS file -->
</head>
<body>
    <div id="mainWrapper">
        <header> 
            <div id="logo">
                <a href="index3.html">
                    <img src="Images/[removal.ai]_9651b07c-253f-4750-b768-9fe85fca1f47-brews.png" alt="" width="160" height="160">
                </a>
            </div>
            <div class="navbar">
                <nav>
                    <ul>
                        <li><a href="menu.php">Menu</a></li>
                        <li><a href="aboutus.html">About Us</a></li> 
                        <li><a href="rewards.html">Rewards</a></li>
                        <li><a href="brews.html">Brews & Tips</a></li>
                        <li><a href="cart.php"><img src="Images/free-add-to-cart-icon-3046-thumb.png" width="40" height="41" alt="cart"></a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <h1>Thank you for your order!</h1>
            <p>Your payment method was <strong><?php echo htmlspecialchars($_POST['paymentMethod']); ?></strong>.</p>
            <p><a href='menu.php' class='return-link'>Return to Menu</a></p>
        </main>
    </div>
</body>
</html>
