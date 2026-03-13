<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    <meta name="description" content="CuSn8 Bronze watches that age uniquely with you. Heritage Edition and Deep Sea Diver collections.">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">
                    COPPER<span>PENNY</span>
                </a>
            </div>
            
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="shop.php">Collections</a>
                <a href="about.php">About</a>
                <a href="blog.php">Journal</a>
                <a href="contact.php">Contact</a>
            </div>
            
            <div class="nav-icons">
                <?php if(isLoggedIn()): ?>
                <div class="dropdown">
                    <a href="#"><i class="fas fa-user"></i></a>
                    <div class="dropdown-content">
                        <a href="account.php">My Account</a>
                        <a href="orders.php">My Orders</a>
                        <?php if(isAdmin()): ?>
                        <a href="admin/">Admin Panel</a>
                        <?php endif; ?>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
                <?php else: ?>
                <a href="login.php"><i class="fas fa-user"></i></a>
                <?php endif; ?>
                
                <a href="cart.php" class="cart-icon">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count"><?php echo getCartCount(); ?></span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <a href="index.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </div>
    
    <main>
