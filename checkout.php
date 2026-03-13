<?php
$page_title = 'Checkout';
include 'header.php';

if(!isLoggedIn()) {
    $_SESSION['redirect_after_login'] = 'checkout.php';
    header('Location: login.php');
    exit;
}

// Get cart items
$user_id = $_SESSION['user_id'];
$cart_items = $conn->query("SELECT cart.*, products.name, products.price, products.sale_price, products.stock 
                           FROM cart 
                           JOIN products ON cart.product_id = products.id 
                           WHERE cart.user_id = $user_id");

if($cart_items->num_rows == 0) {
    header('Location: cart.php');
    exit;
}

$total = 0;
$items_array = [];
while($item = $cart_items->fetch_assoc()) {
    $price = $item['sale_price'] ?: $item['price'];
    $total += $price * $item['quantity'];
    $items_array[] = $item;
}

// Get user data
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
?>

<div class="checkout-page">
    <div class="container">
        <h1>Checkout</h1>
        
        <div class="checkout-grid">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form id="checkoutForm" action="process-order.php" method="POST">
                    <!-- Shipping Information -->
                    <div class="checkout-section">
                        <h3>Shipping Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="tel" name="phone" value="<?php echo $user['phone']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" value="<?php echo $user['address']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" value="<?php echo $user['city']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" value="<?php echo $user['state']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>ZIP Code</label>
                                <input type="text" name="zip_code" value="<?php echo $user['zip_code']; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country" required>
                                    <option value="USA" <?php echo $user['country'] == 'USA' ? 'selected' : ''; ?>>United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="checkout-section">
                        <h3>Payment Method</h3>
                        
                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="card" checked>
                                <div class="method-content">
                                    <i class="fas fa-credit-card"></i>
                                    <div>
                                        <strong>Credit / Debit Card</strong>
                                        <small>Visa, Mastercard, Amex</small>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="paypal">
                                <div class="method-content">
                                    <i class="fab fa-paypal"></i>
                                    <div>
                                        <strong>PayPal</strong>
                                        <small>Pay with your PayPal account</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Card Details (shown when card selected) -->
                        <div id="cardDetails">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" placeholder="1234 5678 9012 3456">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" placeholder="MM/YY">
                                </div>
                                
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large place-order-btn">
                        Place Order • <?php echo CURRENCY; ?><?php echo number_format($total, 2); ?>
                    </button>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Your Order</h3>
                
                <div class="order-items">
                    <?php foreach($items_array as $item): ?>
                    <div class="order-item">
                        <span class="item-name"><?php echo $item['name']; ?> x<?php echo $item['quantity']; ?></span>
                        <span class="item-price"><?php echo CURRENCY; ?><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span><?php echo CURRENCY; ?><?php echo number_format($total, 2); ?></span>
                </div>
                
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                
                <div class="summary-row total">
                    <span>Total</span>
                    <span><?php echo CURRENCY; ?><?php echo number_format($total, 2); ?></span>
                </div>
                
                <!-- Secure Checkout Notice -->
                <div class="secure-checkout">
                    <i class="fas fa-lock"></i>
                    <span>Secure SSL Encrypted Checkout</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle card details based on payment method
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if(this.value === 'card') {
            document.getElementById('cardDetails').style.display = 'block';
        } else {
            document.getElementById('cardDetails').style.display = 'none';
        }
    });
});
</script>

<?php include 'footer.php'; ?>
