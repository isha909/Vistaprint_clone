<?php
$categories = get_categories();
$view_all_menu = get_view_all_menu();
$cart_count = get_cart_count();
$current_user = get_logged_in_user();
?>
<!-- Top Navigation Header -->
<header class="navbar-wrapper bg-white border-bottom">
    <!-- Top Bar with Brand, Search and Icons -->
    <div class="container py-3 px-4">
        <div class="row align-items-center">
            <!-- Brand Logo -->
            <div class="col-6 col-lg-3 d-flex align-items-center">
                <a href="index.php" class="d-flex align-items-center text-decoration-none logo-container">
                    <img src="assets/images/vista_logo.jpg"
                        alt=""
                        width="40"
                        height="40"
                        class="me-2">
                    <span class="logo-text-vista">vista</span><span class="logo-text-print">print</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="col-12 col-lg-7 my-3 my-lg-0 order-3 order-lg-2">
                <form action="search.php" method="GET" class="search-form position-relative">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control search-input" placeholder="Search..." aria-label="Search" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
                        <button class="btn btn-search position-absolute end-0 h-100 px-3 border-0 bg-transparent text-secondary" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Icons Actions -->
            <div class="col-6 col-lg-2 d-flex align-items-center justify-content-end header-icons order-2 order-lg-3">
                <!-- Desktop-only icon group: profile, help, heart, cart -->
                <div class="d-none d-lg-flex align-items-center desktop-icons">
                    <!-- User Profile / Login -->
                    <?php if ($current_user): ?>

                        <!-- LOGGED IN -->
                        <div class="dropdown profile-login-wrapper">

                            <a href="#"
                                class="profile-login-link"
                                id="profileDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">

                                <i class="fa-regular fa-user fs-4 text-dark"></i>

                                <span class="profile-tooltip">Account</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu"
                                aria-labelledby="profileDropdown">

                                <!-- User Name -->
                                <li>
                                    <h6 class="profile-welcome">
                                        Hello, <?php echo htmlspecialchars($current_user['name']); ?>
                                    </h6>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Dashboard
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Account Profile
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        My Projects
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        My Design Services
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Websites & Digital
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Brand Kit
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        My Uploads
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        My Favorites
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Order History & Reorder
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Subscriptions
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Account Settings
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="profile-dropdown-item">
                                        Payment & Delivery
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <!-- Sign Out -->
                                <li>
                                    <a href="login.php?action=logout"
                                        class="profile-signout">
                                        Sign out
                                    </a>
                                </li>

                            </ul>
                        </div>

                    <?php else: ?>

                        <!-- NOT LOGGED IN -->
                        <div class="profile-login-wrapper">

                            <a href="login.php"
                                class="profile-login-link"
                                aria-label="Sign In">

                                <i class="fa-regular fa-user fs-4 text-dark"></i>

                                <span class="profile-tooltip">Sign In</span>

                            </a>

                        </div>

                    <?php endif; ?>

                    <!-- help icon  -->
                    <a href="help.php" class="help-icon">
                        <i class="fa-regular fa-circle-question text-dark"></i>
                        <span class="profile-tooltip">Follow this link to help center or call us at 02522-669393</span>
                    </a>

                    <!-- Wishlist Icon -->
                    <a href="#" class="text-secondary text-decoration-none nav-action-btn">
                        <i class="fa-regular fa-heart fs-4 text-dark"></i>
                        <span class="profile-tooltip">My favourites</span>
                    </a>

                    <!-- Cart Icon -->
                    <a href="cart.php" class="text-secondary text-decoration-none nav-action-btn position-relative">
                        <i class="fa-solid fa-shopping-bag fs-4 text-dark"></i>
                        <span class="profile-tooltip">Cart</span>
                        <?php if ($cart_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-primary text-white border border-white" style="font-size: 10px; padding: 3px 6px;">
                                <?php echo $cart_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Mobile Hamburger (always visible below lg) -->
                <button class="mobile-menu-toggle navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Secondary Nav Bar with Categories -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-top py-1">
        <div class="container px-4">

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- Drawer header: logo + close button -->
                <div class="mobile-drawer-header d-lg-none">
                    <a href="index.php" class="d-flex align-items-center text-decoration-none">
                        <img src="assets/images/vista_logo.jpg" alt="" width="32" height="32" class="me-2">
                        <span class="logo-text-vista" style="font-size: 22px;">vista</span><span class="logo-text-print" style="font-size: 22px;">print</span>
                    </a>
                    <button type="button" class="mobile-drawer-close" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-label="Close menu">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Mobile-only account icons: profile, help, heart, cart -->
                <div class="mobile-account-icons d-lg-none">
                    <a href="<?php echo $current_user ? 'checkout.php' : 'login.php'; ?>" class="mobile-account-link">
                        <i class="fa-regular fa-user"></i>
                        <span><?php echo $current_user ? 'My Account' : 'Sign In'; ?></span>
                    </a>
                    <a href="help.php" class="mobile-account-link">
                        <i class="fa-regular fa-circle-question"></i>
                        <span>Help</span>
                    </a>
                    <a href="#" class="mobile-account-link">
                        <i class="fa-regular fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="cart.php" class="mobile-account-link position-relative">
                        <i class="fa-solid fa-shopping-bag"></i>
                        <span>Cart</span>
                        <?php if ($cart_count > 0): ?>
                            <span class="badge rounded-pill bg-primary text-white ms-1"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                <div class="navbar-collapse-inner">
                    <ul class="navbar-nav w-100  fw-semibold" style="font-size: 13px; letter-spacing: 0.5px;">
                        <!-- View All -->
                        <li class="nav-item dropdown dropdown-hover">
                            <a class="nav-link dropdown-toggle text-dark py-2 px-1"
                                href="view-all.php"
                                role="button">
                                View All
                            </a>

                            <div class="mega-menu view-all-mega shadow-lg">
                                <div class="mega-menu-inner">
                                    <?php foreach ($view_all_menu as $group): ?>
                                        <div class="mega-column">
                                            <h5 class="view-all-group-title">
                                                <?php echo htmlspecialchars($group['title']); ?>
                                            </h5>
                                            <?php foreach ($group['links'] as $link): ?>
                                                <a class="mega-link" href="<?php echo htmlspecialchars($link['url']); ?>">
                                                    <?php echo htmlspecialchars($link['label']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                            <?php
                            $subs = get_subcategories($cat['id']);
                            if (!empty($subs)):
                            ?>
                                <li class="nav-item dropdown dropdown-hover">
                                    <a class="nav-link dropdown-toggle text-dark py-2 px-1" href="category.php?id=<?php echo $cat['id']; ?>" role="button">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                    <div class=" mega-menu shadow-lg">

                                        <div class="mega-menu-inner">

                                            <?php foreach ($subs as $sub): ?>

                                                <?php
                                                $products = get_products_by_subcategory($sub['id']);
                                                ?>

                                                <div class="mega-column">

                                                    <h5>
                                                        <a href="subcategory.php?id=<?php echo $sub['id']; ?>">
                                                            <?php echo htmlspecialchars($sub['name']); ?>
                                                        </a>
                                                        <?php if (!empty($sub['is_new'])): ?>
                                                            <span class="badge-new">NEW</span>
                                                        <?php endif; ?>
                                                    </h5>

                                                    <?php if (!empty($products)): ?>
                                                        <?php foreach ($products as $product): ?>
                                                            <a class="mega-link" href="product.php?id=<?php echo $product['id']; ?>">
                                                                <?php echo htmlspecialchars($product['name']); ?>
                                                                <?php if (!empty($product['is_new'])): ?>
                                                                    <span class="badge-new">NEW</span>
                                                                <?php endif; ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>

                                            <?php endforeach; ?>

                                        </div>

                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link text-dark py-2 px-1" href="category.php?id=<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Social icons at the end of the mobile drawer -->
                    <div class="mobile-drawer-social d-lg-none">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
    </nav>
</header>

<?php if (empty($hidePromoBar)): ?>
    <!-- Promotional Announcement Stripe -->
    <div class="promo-stripe text-center text-white py-2" style="background: #111111; font-size: 15px; font-weight: 500; letter-spacing: 0.5px;">
        Buy more, Save more! Flat 5% OFF on Orders ₹10,000+ | Code: <span class="fw-bold">SAVE5</span>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var drawer = document.getElementById('navbarNavDropdown');
        if (!drawer) return;
        drawer.addEventListener('show.bs.collapse', function() {
            document.body.classList.add('mobile-menu-open');
        });
        drawer.addEventListener('hidden.bs.collapse', function() {
            document.body.classList.remove('mobile-menu-open');
        });
    });

    function updateNavbarOffset() {
        var navbar = document.querySelector('.navbar');
        if (!navbar) return;
        var rect = navbar.getBoundingClientRect();
        document.documentElement.style.setProperty('--navbar-bottom', rect.bottom + 'px');
    }
    window.addEventListener('load', updateNavbarOffset);
    window.addEventListener('resize', updateNavbarOffset);
</script>