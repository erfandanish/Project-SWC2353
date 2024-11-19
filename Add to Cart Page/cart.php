<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cart</title>
    <link href="cart.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="mainWrapper">
        <header>
            <div id="logo">
                <a href="index3.html"><img src="Images/[removal.ai]_9651b07c-253f-4750-b768-9fe85fca1f47-brews.png" alt="" width="160" height="160"></a>
            </div>
            <div class="navbar">
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
    </div>

    <section id="cartContent">
        <h2>Your Cart</h2>
        <?php
			ob_start();
            session_start();

            
            if (empty($_SESSION['cart'])) {
                echo "<p>Your cart is empty. Go back to the <a href='menu.php'>menu</a> to add items.</p>";
            } else {
                echo "<table>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>";
                $total = 0;

                foreach ($_SESSION['cart'] as $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                    echo "<tr>
                            <td>{$item['name']}</td>
                            <td>RM " . number_format($item['price'], 2) . "</td>
                            <td>
                                <form action='cart.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='update' value='increase'>
                                    <input type='hidden' name='product' value='{$item['name']}'>
                                    <button type='submit'>+</button>
                                </form>
                                <span>{$item['quantity']}</span>
                                <form action='cart.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='update' value='decrease'>
                                    <input type='hidden' name='product' value='{$item['name']}'>
                                    <button type='submit'>-</button>
                                </form>
                            </td>
                            <td>RM " . number_format($itemTotal, 2) . "</td>
                            <td>
                                <form action='cart.php' method='POST'>
                                    <input type='hidden' name='remove' value='{$item['name']}'>
                                    <button type='submit'>Remove</button>
                                </form>
                            </td>
                        </tr>";
                }

                echo "<tr>
                        <td colspan='3'>Total:</td>
                        <td>RM " . number_format($total, 2) . "</td>
                        <td></td>
                    </tr>
                </table>";
            }

            // Handle removal of an item
            if (isset($_POST['remove'])) {
                $removeProduct = $_POST['remove'];
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['name'] === $removeProduct) {
                        unset($_SESSION['cart'][$key]);
                        break;
                    }
                }
                // Refresh the page to update the cart
                header("Location: cart.php");
                exit;
            }

            // Handle updating item quantities
            if (isset($_POST['update'])) {
                $updateAction = $_POST['update'];
                $productName = $_POST['product'];

                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['name'] === $productName) {
                        if ($updateAction === 'increase') {
                            $item['quantity']++;
                        } elseif ($updateAction === 'decrease') {
                            if ($item['quantity'] > 1) {
                                $item['quantity']--;
                            }
                        }
                        break;
                    }
                }
                // Refresh the page to update the cart
                header("Location: cart.php");
                exit;
            }
		ob_end_flush();
        ?>
		<h3>Checkout</h3>
    <form action="checkout.php" method="POST">
        <label for="paymentMethod">Choose a payment method:</label>
        <select name="paymentMethod" id="paymentMethod" required>
            <option value="Credit Card">Credit Card</option>
            <option value="eWallet">eWallet</option>
            <option value="Pay Pal">PayPal</option>
            <option value="FPX Bank Transfer">FPX Bank Transfer</option>
        </select>
        <button type="submit">Place Order</button>
    </form>
    </section>

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
</body>
</html>
