    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>COPPER PENNY</h3>
                <p>Living Metal Timepieces<br>Est. 2023</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Collections</h3>
                <ul>
                    <li><a href="shop.php?collection=heritage">Heritage Edition</a></li>
                    <li><a href="shop.php?collection=diver">Deep Sea Diver</a></li>
                    <li><a href="shop.php?collection=limited">Limited Editions</a></li>
                    <li><a href="shop.php">All Watches</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="shipping.php">Shipping Info</a></li>
                    <li><a href="returns.php">Returns & Warranty</a></li>
                    <li><a href="care-guide.php">Patina Care Guide</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Newsletter</h3>
                <p>Subscribe for new releases and patina stories.</p>
                <form class="newsletter-form" action="subscribe.php" method="POST">
                    <input type="email" name="email" placeholder="Your email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
                <div class="payment-methods">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-cc-paypal"></i>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                © <?php echo date('Y'); ?> Copper Penny Timepieces. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="privacy.php">Privacy Policy</a>
                <a href="terms.php">Terms of Service</a>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    
    <?php if(isset($extra_js)): ?>
    <script><?php echo $extra_js; ?></script>
    <?php endif; ?>
    
</body>
</html>
