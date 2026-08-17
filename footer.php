<?php if (empty($hide_newsletter)): ?>
<!-- Newsletter Block -->
<section class="newsletter-section py-5 mt-5" style="background-color: #f7f7f7; border-top: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
    <div class="container px-4">
        <div class="row align-items-start g-4 g-lg-5">

            <!-- Image column: last on mobile, first on desktop -->
            <div class="col-12 col-lg-6 order-2 order-lg-1">
                <img src="assets/images/newsletter-cards.jpg"
                    alt="Custom printed business cards"
                    class="newsletter-image w-100">
            </div>

            <!-- Text + form column: first on mobile, second on desktop -->
            <div class="col-12 col-lg-6 order-1 order-lg-2 text-center text-lg-start">
                <h3 class="newsletter-title font-outfit text-dark mb-2" style="font-size: 30px;">It's good to be on the list.</h3>
                <p class="newsletter-subtitle text-secondary mb-4" style="font-size: 20px;">Get 15% off* your first order when you sign up for our emails.</p>

                <form action="" method="POST" id="newsletterForm" class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-lg-start align-items-center mb-3">
                    <input type="email" class="form-control newsletter-input py-2 px-3 border" placeholder="Subscription Email" style="max-width: 320px; border-radius: 4px; font-size: 14px;" required>
                </form>

                <p class="newsletter-disclaimer text-muted mx-auto mx-lg-0" style="font-size: 11px; max-width: 480px; line-height: 1.5;">
                    *Yes, I'd like to receive special offer emails from VistaPrint, as well as news about products, services and my designs in progress. Read our <a href="#" class="text-dark text-decoration-underline">Privacy and Cookie Policy</a>.
                </p>
                <button type="submit" class="btn btn-dark newsletter-btn py-2 px-4 fw-semibold text-uppercase" style="border-radius: 4px; font-size: 13px; letter-spacing: 0.5px; height: 100%;">Submit</button>
            </div>

        </div>
    </div>
</section>

<!-- Footer Main Links Grid -->
<footer class="bg-white pt-5">
    <div class="container px-4">
        <!-- Top Columns -->
        <div class="row pb-4 border-bottom g-4" style="font-size: 16px; line-height: 1.6;">
            <!-- Column 1 -->
            <div class="col-12 col-md-6">
                <h6 class="fw-bold text-dark mb-3">VistaPrint India: The leader in customisation</h6>
                <p class="text-secondary mb-0">
                    For more than 20 years, VistaPrint has helped business owners, enterpreneurs and individuals create their identities with custom designs and professional marketing. Our online printing services are intended to help you find high quality customised products you need- visiting cards, personalized clothing, gifting products, and much more.
                </p>
            </div>
            <!-- Column 2 -->
            <div class="col-12 col-md-6">
                <h6 class="fw-bold text-dark mb-3">Even Low Qualities @ Best Prices</h6>
                <p class="text-secondary mb-0">
                    We offer low/ single product quantities at affordable prices.
                </p>
                <p></p>
                <h6 class="fw-bold text-dark mb-3">High quality products and Easy design</h6>
                <p class="text-secondary mb-0">
                    Our wide selection of high - quality products and online design tools make it easy for you to customize and order your favourite products.
                </p>
                <p></p>
                <h6 class="fw-bold text-dark mb-3">Free replacement or Full Refund</h6>
                <p class="text-secondary mb-0">
                    We stand by everything we sell. So if you're not satisfied, we'll make it right.
                </p>
            </div>
        </div>

<?php endif; ?>
        <!-- Category-like links with dark background styling -->
    </div>

    <!-- Dark Bottom Menu Footer -->
    <div class="bg-footer-dark text-white-50 py-5" style="background-color: #2b3547;">
        <div class="container px-4">

            <div class="row g-0 footer-menu-row">

                <!-- Easy Returns -->
                <div class="col-12 col-lg-3 footer-column footer-easy-returns">
                    <div class="footer-column-header">
                        <h5 class="text-white fw-bold mb-2 footer-easy-returns-title font-outfit">
                            Easy Returns:
                        </h5>

                        <a href="#"
                            class="text-white fw-bold text-decoration-underline footer-easy-returns-link">
                            Free Replacement or Full Refund
                        </a>
                    </div>
                </div>


                <!-- Let Us Help -->
                <div class="col-12 col-lg-3 footer-column">

                    <button class="footer-mobile-toggle"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#footerHelp"
                        aria-expanded="false"
                        aria-controls="footerHelp">

                        <span>Let us help</span>
                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div id="footerHelp" class="collapse footer-mobile-content">

                        <ul class="list-unstyled mb-0">

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Let us help
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    My Account
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Contact us
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Bulk Order Inquiry
                                </a>
                            </li>

                        </ul>
                        <!-- Mobile-only: Social + Country inside dark section -->
                        <div class="d-flex d-lg-none align-items-center gap-3 mt-4">
                            <div class="social-links d-flex align-items-center gap-3">
                                <a href="#" class="text-white hover-white"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="#" class="text-white hover-white"><i class="fa-brands fa-facebook"></i></a>
                                <a href="#" class="text-white hover-white"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" class="text-white hover-white"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                            <div class="footer-country-select-wrap">
                                <img src="assets/images/india.png" alt="India" width="30" height="25">
                                <select class="footer-country-select">
                                    <option>IN</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Our Company -->
                <div class="col-12 col-lg-3 footer-column">

                    <button class="footer-mobile-toggle"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#footerCompany"
                        aria-expanded="false"
                        aria-controls="footerCompany">

                        <span>Our Company</span>
                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div id="footerCompany" class="collapse footer-mobile-content">

                        <ul class="list-unstyled mb-0">

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Careers
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    For investors
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    For media
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Sustainability
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Annual Returns
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Corporate Social Responsibility
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>


                <!-- Our Policies -->
                <div class="col-12 col-lg-3 footer-column">

                    <button class="footer-mobile-toggle"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#footerPolicies"
                        aria-expanded="false"
                        aria-controls="footerPolicies">

                        <span>Our policies</span>
                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div id="footerPolicies" class="collapse footer-mobile-content">

                        <ul class="list-unstyled mb-0">

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Terms and Conditions
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Vista Privacy and Cookie Policy
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Copyright matters
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-white text-decoration-none hover-white">
                                    Patents & trademarks
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Solid Black Bottom Bar -->
    <div class="bg-footer-black text-white-50 py-4">
        <div class="container px-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pb-3">

                <!-- Left: Payment icons + Home link -->
                <div class="d-flex align-items-center">
                    <a href="index.php" class="footer-home-link text-white text-decoration-underline hover-white">
                        Home
                    </a>
                </div>
                <div class="payment-icons d-flex align-items-center gap-3 mx-auto">
                    <img src="assets/images/mastercard.jpg" alt="Mastercard" height="30">
                    <img src="assets/images/visa.jpg" alt="Visa" height="30">
                    <img src="assets/images/rupay.jpg" alt="RuPay" height="50">
                </div>


                <!-- Right: Social icons + Country selector -->
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <div class="social-links d-flex align-items-center gap-3">
                        <a href="#" class="text-white hover-white"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="text-white hover-white"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-white hover-white"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-white hover-white"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                    <div class="footer-country-select-wrap">
                        <img src="assets/images/india.png" alt="India" width="30" height="25">
                        <select class="footer-country-select">
                            <option>IN</option>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Copyright -->
            <div class="footer-copyright border-top pt-3" style="border-color: rgba(255,255,255,0.15) !important;">
                <p class="mb-1">
                    A CIMPRESS company &copy; 2001-<?php echo date('Y'); ?> Vistaprint. All rights reserved.
                </p>
                <p class="mb-0">
                    Unless stated otherwise, prices are exclusive of delivery and product options.
                </p>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS with Popper CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script src="assets/js/main.js"></script>
    </body>

    </html>