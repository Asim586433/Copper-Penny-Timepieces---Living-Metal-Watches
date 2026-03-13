<?php
$page_title = 'Home';
include 'header.php';

// Get featured products
$featured = $conn->query("SELECT * FROM products WHERE featured = 1 LIMIT 3");
if ($featured->num_rows == 0) {
    $featured = $conn->query("SELECT * FROM products LIMIT 3");
}

// Get latest blog posts
$blogs = $conn->query("SELECT * FROM blog_posts WHERE published = 1 ORDER BY created_at DESC LIMIT 3");
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1 class="animate-text">Living Metal.<br>Timeless Stories.</h1>
        <p class="animate-text-delay">CuSn8 Bronze watches that age uniquely with you. Each scratch, each patina tells your story.</p>
        <div class="hero-buttons">
            <a href="shop.php" class="btn btn-primary">Shop Collection</a>
            <a href="about.php" class="btn btn-outline">Discover More</a>
        </div>
    </div>
    
    <div class="hero-stats">
        <div class="stat">
            <span class="stat-number">100%</span>
            <span class="stat-label">CuSn8 Bronze</span>
        </div>
        <div class="stat">
            <span class="stat-number">200m</span>
            <span class="stat-label">Water Resistance</span>
        </div>
        <div class="stat">
            <span class="stat-number">9015</span>
            <span class="stat-label">Miyota Movement</span>
        </div>
    </div>
</section>

<!-- Featured Collections -->
<section class="section">
    <div class="container">
        <h2 class="section-title"><span>Featured Timepieces</span></h2>
        
        <div class="products-grid">
            <?php while($product = $featured->fetch_assoc()): 
                $specs = json_decode($product['specs'], true);
            ?>
            <div class="product-card" data-aos="fade-up">
                <div class="product-image">
                    <?php if($product['sale_price'] < $product['price']): ?>
                    <span class="product-badge sale">Sale</span>
                    <?php elseif($product['collection'] == 'limited'): ?>
                    <span class="product-badge limited">Limited</span>
                    <?php else: ?>
                    <span class="product-badge">New</span>
                    <?php endif; ?>
                    
                    <img src="assets/images/products/<?php echo json_decode($product['images'], true)[0] ?? 'placeholder.jpg'; ?>" 
                         alt="<?php echo $product['name']; ?>">
                    
                    <div class="product-actions">
                        <a href="product.php?slug=<?php echo $product['slug']; ?>" class="quick-view">Quick View</a>
                    </div>
                </div>
                
                <div class="product-info">
                    <div class="product-category"><?php echo ucfirst($product['collection']); ?> Edition</div>
                    <h3 class="product-title"><?php echo $product['name']; ?></h3>
                    
                    <div class="product-specs">
                        <?php if(isset($specs['case_size'])): ?>
                        <span><?php echo $specs['case_size']; ?></span>
                        <span>•</span>
                        <?php endif; ?>
                        <span>CuSn8 Bronze</span>
                        <?php if(isset($specs['water_resistance'])): ?>
                        <span>•</span>
                        <span><?php echo $specs['water_resistance']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="product-description"><?php echo $product['short_desc']; ?></p>
                    
                    <div class="product-price">
                        <?php if($product['sale_price'] < $product['price']): ?>
                        <span class="original"><?php echo CURRENCY; ?><?php echo number_format($product['price'], 2); ?></span>
                        <span class="sale"><?php echo CURRENCY; ?><?php echo number_format($product['sale_price'], 2); ?></span>
                        <?php else: ?>
                        <?php echo CURRENCY; ?><?php echo number_format($product['price'], 2); ?>
                        <?php endif; ?>
                    </div>
                    
                    <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                        Add to Cart
                    </button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <div class="view-all">
            <a href="shop.php" class="btn btn-secondary">View All Timepieces <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- Collection Showcase -->
<section class="collection-showcase">
    <div class="collection-grid">
        <div class="collection-item heritage" onclick="location.href='shop.php?collection=heritage'">
            <div class="collection-content">
                <span class="collection-tag">Heritage Edition</span>
                <h3>The Field Officer</h3>
                <p>38mm • Slim Profile • 5ATM</p>
                <a href="shop.php?collection=heritage" class="collection-link">Explore <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        
        <div class="collection-item diver" onclick="location.href='shop.php?collection=diver'">
            <div class="collection-content">
                <span class="collection-tag">Deep Sea Diver</span>
                <h3>The Abyss</h3>
                <p>42mm • 200m WR • Ceramic Bezel</p>
                <a href="shop.php?collection=diver" class="collection-link">Explore <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Miyota 9015</h4>
                <p>Premium automatic movement with 42-hour power reserve</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-water"></i>
                </div>
                <h4>Professional WR</h4>
                <p>Up to 200m water resistance with screw-down crowns</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-gem"></i>
                </div>
                <h4>Sapphire Crystal</h4>
                <p>Scratch-resistant with anti-reflective coating</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h4>Living Metal</h4>
                <p>CuSn8 bronze develops unique patina over time</p>
            </div>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="about-preview">
    <div class="container">
        <div class="about-grid">
            <div class="about-image">
                <img src="assets/images/about-preview.jpg" alt="Copper Penny Workshop">
            </div>
            
            <div class="about-content">
                <h2>The <span class="bronze-text">Living Metal</span> Philosophy</h2>
                <p>At Copper Penny, we believe a watch should tell more than time. It should tell your story. Our CuSn8 bronze cases are engineered to develop a unique patina over time, reacting to your skin, your environment, your adventures.</p>
                
                <div class="about-stats">
                    <div class="about-stat">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">CuSn8 Bronze</span>
                    </div>
                    <div class="about-stat">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Year Warranty</span>
                    </div>
                    <div class="about-stat">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Support</span>
                    </div>
                </div>
                
                <a href="about.php" class="btn btn-primary">Our Story <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Blog Preview -->
<?php if($blogs->num_rows > 0): ?>
<section class="blog-preview">
    <div class="container">
        <h2 class="section-title"><span>From The Journal</span></h2>
        
        <div class="blog-grid">
            <?php while($post = $blogs->fetch_assoc()): ?>
            <div class="blog-card">
                <div class="blog-image">
                    <img src="assets/images/blog/<?php echo $post['image'] ?? 'placeholder.jpg'; ?>" alt="<?php echo $post['title']; ?>">
                </div>
                
                <div class="blog-content">
                    <span class="blog-date"><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                    <h3><?php echo $post['title']; ?></h3>
                    <p><?php echo $post['excerpt']; ?></p>
                    <a href="blog-post.php?slug=<?php echo $post['slug']; ?>" class="blog-link">Read More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <h3>Join The Patina Club</h3>
            <p>Subscribe for new releases, patina stories, and exclusive offers.</p>
            
            <form class="newsletter-form-large" action="subscribe.php" method="POST">
                <input type="email" name="email" placeholder="Your email address" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
            
            <small>We respect your privacy. Unsubscribe anytime.</small>
        </div>
    </div>
</section>

<script>
// Add to Cart AJAX
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        
        fetch('ajax/add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId + '&quantity=1'
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update cart count
                document.querySelector('.cart-count').textContent = data.cart_count;
                
                // Show success message
                this.textContent = 'Added! ✓';
                this.style.background = '#28a745';
                
                setTimeout(() => {
                    this.textContent = 'Add to Cart';
                    this.style.background = '';
                }, 2000);
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>
