<?php
$page_title = 'Shopping Cart';
include 'header.php';

$cart_items = [];
$total = 0;

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_query = "SELECT cart.*, products.name, products.price, products.sale_price, products.images 
                   FROM cart 
                   JOIN products ON cart.product_id = products.id 
                   WHERE cart.user_id = $user_id";
} else {
    $session_id = session_id();
    $cart_query = "SELECT cart.*, products.name, products.price, products.sale_price, products.images 
                   FROM cart 
                   JOIN products ON cart.product_id = products.id 
                   WHERE cart.session_id = '$session_id'";
}

$cart_result = $conn->query($cart_query);

if($cart_result->num_rows > 0) {
    while($item = $cart_result->fetch_assoc()) {
        $price = $item['sale_price'] ?: $item['price'];
        $item_total = $price * $item['quantity'];
        $total += $item_total;
        
        $images = json_decode($item['images'], true);
        $item['image'] = $images[0] ?? 'placeholder.jpg';
        $item['item_total'] = $item_total;
        $item['price'] = $price;
        
        $cart_items[] = $item;
    }
}
?>

<div class="cart-page">
    <div class="container">
        <h1>Shopping Cart</h1>
        
        <?php if(empty($cart_items)): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-bag"></i>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any watches to your collection yet.</p>
            <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
        </div>
        
        <?php else: ?>
        
        <div class="cart-grid">
            <!-- Cart Items -->
            <div class="cart-items">
                <?php foreach($cart_items as $item): ?>
                <div class="cart-item" data-cart-id="<?php echo $item['id']; ?>">
                    <div class="item-image">
                        <img src="assets/images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                    </div>
                    
                    <div class="item-details">
                        <h3><?php echo $item['name']; ?></h3>
                        
                        <div class="item-price">
                            <?php echo CURRENCY; ?><?php echo number_format($item['price'], 2); ?>
                        </div>
                        
                        <div class="item-actions">
                            <div class="item-quantity">
                                <button class="quantity-btn minus" onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease')">-</button>
                                <input type="number" value="<?php echo $item['quantity']; ?>" min="1" readonly>
                                <button class="quantity-btn plus" onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase')">+</button>
                            </div>
                            
                            <button class="remove-item" onclick="removeFromCart(<?php echo $item['id']; ?>)">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                    
                    <div class="item-total">
                        <?php echo CURRENCY; ?><?php echo number_format($item['item_total'], 2); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Cart Summary -->
            <div class="cart-summary">
                <h3>Order Summary</h3>
                
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
                
                <div class="promo-code">
                    <input type="text" placeholder="Promo code">
                    <button class="btn btn-secondary">Apply</button>
                </div>
                
                <a href="checkout.php" class="btn btn-primary btn-large checkout-btn">
                    Proceed to Checkout
                </a>
                
                <a href="shop.php" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
                
                <!-- Trust Badges -->
                <div class="trust-badges">
                    <img src="assets/images/trust/ssl.png" alt="SSL Secure">
                    <img src="assets/images/trust/payments.png" alt="Payment Methods">
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateQuantity(cartId, action) {
    fetch('ajax/update-cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'cart_id=' + cartId + '&action=' + action
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        }
    });
}

function removeFromCart(cartId) {
    if(confirm('Remove this item from your cart?')) {
        fetch('ajax/remove-from-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'cart_id=' + cartId
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.querySelector('.cart-count').textContent = data.cart_count;
                location.reload();
            }
        });
    }
}
</script>

<?php include 'footer.php'; ?>
