<?php
$slug = $_GET['slug'] ?? '';
$product = $conn->query("SELECT * FROM products WHERE slug = '$slug'")->fetch_assoc();

if(!$product) {
    header('Location: shop.php');
    exit;
}

$specs = json_decode($product['specs'], true);
$images = json_decode($product['images'], true);

$page_title = $product['name'];
include 'header.php';
?>

<div class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Product Images -->
            <div class="product-gallery">
                <div class="main-image">
                    <img src="assets/images/products/<?php echo $images[0] ?? 'placeholder.jpg'; ?>" 
                         alt="<?php echo $product['name']; ?>" id="mainProductImage">
                </div>
                
                <div class="thumbnail-images">
                    <?php foreach($images as $index => $image): ?>
                    <div class="thumbnail <?php echo $index == 0 ? 'active' : ''; ?>" 
                         onclick="changeImage('<?php echo $image; ?>', this)">
                        <img src="assets/images/products/<?php echo $image; ?>" alt="Thumbnail">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-info-detail">
                <div class="breadcrumb">
                    <a href="shop.php">Shop</a> / 
                    <a href="shop.php?collection=<?php echo $product['collection']; ?>">
                        <?php echo ucfirst($product['collection']); ?>
                    </a> / 
                    <span><?php echo $product['name']; ?></span>
                </div>
                
                <h1><?php echo $product['name']; ?></h1>
                
                <div class="product-meta">
                    <div class="product-availability">
                        <?php if($product['stock'] > 0): ?>
                        <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock</span>
                        <?php else: ?>
                        <span class="out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-sku">
                        SKU: CP-<?php echo strtoupper(substr($product['collection'], 0, 3)); ?>-<?php echo $product['id']; ?>
                    </div>
                </div>
                
                <div class="product-price-large">
                    <?php if($product['sale_price'] < $product['price']): ?>
                    <span class="original"><?php echo CURRENCY; ?><?php echo number_format($product['price'], 2); ?></span>
                    <span class="sale"><?php echo CURRENCY; ?><?php echo number_format($product['sale_price'], 2); ?></span>
                    <?php else: ?>
                    <?php echo CURRENCY; ?><?php echo number_format($product['price'], 2); ?>
                    <?php endif; ?>
                </div>
                
                <div class="product-description">
                    <?php echo $product['description']; ?>
                </div>
                
                <!-- Key Specs -->
                <div class="key-specs">
                    <?php if(isset($specs['case_size'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Case Size</span>
                        <span class="spec-value"><?php echo $specs['case_size']; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($specs['case_material'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Material</span>
                        <span class="spec-value"><?php echo $specs['case_material']; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($specs['movement'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Movement</span>
                        <span class="spec-value"><?php echo $specs['movement']; ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(isset($specs['water_resistance'])): ?>
                    <div class="spec-item">
                        <span class="spec-label">Water Resistance</span>
                        <span class="spec-value"><?php echo $specs['water_resistance']; ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Add to Cart Section -->
                <div class="add-to-cart-section">
                    <div class="quantity-selector">
                        <button onclick="decrementQuantity()">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                        <button onclick="incrementQuantity()">+</button>
                    </div>
                    
                    <button class="btn btn-primary btn-large add-to-cart-detail" 
                            data-product-id="<?php echo $product['id']; ?>"
                            <?php echo $product['stock'] == 0 ? 'disabled' : ''; ?>>
                        <i class="fas fa-shopping-bag"></i>
                        Add to Cart
                    </button>
                </div>
                
                <!-- Actions -->
                <div class="product-actions">
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                    
                    <button class="share-btn">
                        <i class="far fa-share-square"></i> Share
                    </button>
                </div>
                
                <!-- Shipping Info -->
                <div class="shipping-info">
                    <div class="info-item">
                        <i class="fas fa-truck"></i>
                        <span>Free shipping worldwide</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-undo"></i>
                        <span>30-day returns</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>5-year warranty</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Detailed Specs Tabs -->
        <div class="product-tabs">
            <div class="tab-headers">
                <button class="tab-header active" data-tab="specs">Specifications</button>
                <button class="tab-header" data-tab="shipping">Shipping & Returns</button>
                <button class="tab-header" data-tab="care">Care Guide</button>
                <button class="tab-header" data-tab="reviews">Reviews</button>
            </div>
            
            <div class="tab-content active" id="specs">
                <table class="specs-table">
                    <?php foreach($specs as $key => $value): ?>
                    <tr>
                        <td><?php echo ucwords(str_replace('_', ' ', $key)); ?></td>
                        <td><?php echo $value; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            
            <div class="tab-content" id="shipping">
                <h4>Shipping Information</h4>
                <p>Free express shipping on all orders. Delivery within 3-5 business days worldwide.</p>
                
                <h4>Returns</h4>
                <p>30-day return policy. Watch must be in original condition with all packaging.</p>
                
                <h4>Warranty</h4>
                <p>5-year international warranty on all mechanical components.</p>
            </div>
            
            <div class="tab-content" id="care">
                <h4>Bronze Care</h4>
                <p>Your Copper Penny watch will develop a unique patina over time. To maintain or remove patina:</p>
                <ul>
                    <li>Use a soft cloth with lemon juice for light cleaning</li>
                    <li>Avoid harsh chemicals</li>
                    <li>Rinse with fresh water after saltwater exposure</li>
                    <li>Store in a dry place when not worn</li>
                </ul>
            </div>
            
            <div class="tab-content" id="reviews">
                <div class="reviews-summary">
                    <div class="average-rating">4.8/5</div>
                    <div class="total-reviews">Based on 24 reviews</div>
                </div>
                
                <!-- Sample Reviews -->
                <div class="review">
                    <div class="reviewer">John D.</div>
                    <div class="review-date">Verified Buyer - March 2023</div>
                    <p>The patina on this watch is incredible. Already getting compliments daily.</p>
                </div>
                
                <div class="review">
                    <div class="reviewer">Sarah M.</div>
                    <div class="review-date">Verified Buyer - February 2023</div>
                    <p>Perfect size, great quality. The bronze feels substantial on wrist.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<?php
$related = $conn->query("SELECT * FROM products WHERE collection = '{$product['collection']}' AND id != {$product['id']} LIMIT 3");
if($related->num_rows > 0):
?>
<section class="related-products">
    <div class="container">
        <h2 class="section-title"><span>You May Also Like</span></h2>
        
        <div class="products-grid">
            <?php while($rel = $related->fetch_assoc()): 
                $rel_specs = json_decode($rel['specs'], true);
            ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="assets/images/products/<?php echo json_decode($rel['images'], true)[0] ?? 'placeholder.jpg'; ?>" 
                         alt="<?php echo $rel['name']; ?>">
                </div>
                
                <div class="product-info">
                    <h3><?php echo $rel['name']; ?></h3>
                    <div class="product-price"><?php echo CURRENCY; ?><?php echo number_format($rel['price'], 2); ?></div>
                    <a href="product.php?slug=<?php echo $rel['slug']; ?>" class="btn btn-secondary">View Details</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function changeImage(image, element) {
    document.getElementById('mainProductImage').src = 'assets/images/products/' + image;
    
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    element.classList.add('active');
}

function incrementQuantity() {
    let input = document.getElementById('quantity');
    let max = parseInt(input.getAttribute('max'));
    let current = parseInt(input.value);
    if(current < max) {
        input.value = current + 1;
    }
}

function decrementQuantity() {
    let input = document.getElementById('quantity');
    let current = parseInt(input.value);
    if(current > 1) {
        input.value = current - 1;
    }
}

// Tabs
document.querySelectorAll('.tab-header').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.tab-header').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});

// Add to Cart
document.querySelector('.add-to-cart-detail')?.addEventListener('click', function() {
    if(this.disabled) return;
    
    const productId = this.dataset.productId;
    const quantity = document.getElementById('quantity').value;
    
    fetch('ajax/add-to-cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId + '&quantity=' + quantity
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            document.querySelector('.cart-count').textContent = data.cart_count;
            
            this.innerHTML = '<i class="fas fa-check"></i> Added to Cart!';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-shopping-bag"></i> Add to Cart';
            }, 2000);
        }
    });
});
</script>

<?php include 'footer.php'; ?>
