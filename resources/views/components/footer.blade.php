

    <!-- Footer -->
    <footer>
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element" style="width: 80px; height: 80px; top: 10%; left: 5%;"></div>
            <div class="floating-element" style="width: 60px; height: 60px; top: 20%; right: 10%;"></div>
            <div class="floating-element" style="width: 100px; height: 100px; bottom: 20%; left: 15%;"></div>
            <div class="floating-element" style="width: 40px; height: 40px; bottom: 10%; right: 20%;"></div>
        </div>
        
        <div class="footer-container">
            <!-- Logo Section -->
            <div class="footer-logo-section">
                <div class="logo-wrapper">
                    <div class="logo-border"></div>
                    <a href="{{ url(app()->getLocale() . '/') }}">
                        <!-- Updated logo path - using a placeholder with white background -->
                        <img src="{{ asset('images/footer-logo.png') }}" 
                             class="footer-logo" 
                             alt="CouponsArena Logo"
                             onerror="this.src='https://via.placeholder.com/140x140/2e2bb1/ffffff?text=LOGO'">
                    </a>
                </div>
                <p class="tagline">Smart shopping starts here</p>
                
                <!-- Social Media Icons -->
                <div class="social-section">
                    <a href="https://www.facebook.com/profile.php?id=61571970471132" class="social-icon" aria-label="Facebook" target="_blank" >
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/coupons.arena/" class="social-icon" aria-label="Instagram" target="_blank" >
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@couponsarena" class="social-icon" aria-label="TikTok" target="_blank" >
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Content Section -->
            <div class="footer-content">
                <!-- Newsletter Section -->
                <div class="newsletter-section">
                    <h3 class="newsletter-title">Subscribe to our Newsletter</h3>
                    <p class="newsletter-subtitle">Get exclusive deals, coupons, and shopping tips delivered directly to your inbox. Don't miss out on amazing savings!</p>
                    
                    <form class="subscribe-form" id="subscribeForm">
                        @csrf
                        <input type="email" 
                               name="email" 
                               class="email-input" 
                               placeholder="Enter your email address" 
                               required>
                        <button type="submit" class="subscribe-btn">
                            Subscribe <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                    
                    <div id="thankYouMessage" class="success-message">
                        <span><i class="fas fa-check-circle me-2"></i> Thank you for subscribing! Check your email for confirmation.</span>
                        <button type="button" class="close-btn" onclick="hideSuccessMessage()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="footer-links-section">
                    <a href="{{url(app()->getLocale() . '/about') }}" class="footer-link">
                        <i class="fas fa-info-circle"></i>
                        <span>About Us</span>
                    </a>
                    <a href="{{ url(app()->getLocale() . '/privacy') }}" class="footer-link">
                        <i class="fas fa-shield-alt"></i>
                        <span>Privacy Policy</span>
                    </a>
                    <a href="{{ url(app()->getLocale() . '/terms-and-condition') }}" class="footer-link">
                        <i class="fas fa-file-contract"></i>
                        <span>Terms & Conditions</span>
                    </a>
                    <a href="{{ url(app()->getLocale() . '/imprint') }}" class="footer-link">
                        <i class="fas fa-stamp"></i>
                        <span>Imprint</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="copyright">Copyright &copy; 2024 couponsarena.com - All rights reserved</p>
            <p class="disclaimer">
                This website uses cookies to ensure you get the best experience. By continuing to browse, you agree to our cookie policy. 
                All trademarks are property of their respective owners.
            </p>
        </div>
    </footer>

