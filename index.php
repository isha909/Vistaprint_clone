<?php
$page_title = "Online Printing Services, Business Cards, T-Shirts";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';

// Fetch banners
$hero_banners = get_banners('hero_stacked');
$promo_banners = get_banners('promo_mid');

// Fetch popular products (first 6 products)
$popular_products = [
    get_product_by_id(1),
    get_product_by_id(2),
    get_product_by_id(3),
    get_product_by_id(4),
    get_product_by_id(5),
    get_product_by_id(6)
];

// Fetch trending products
$trending_products = [
    get_product_by_id(7),
    get_product_by_id(8),
    get_product_by_id(9),
    get_product_by_id(10),
    get_product_by_id(11),
    get_product_by_id(12)
];

// Fetch Labels, Stickers, Packaging
$label_products = [
    get_product_by_id(13),
    get_product_by_id(14),
    get_product_by_id(15),
    get_product_by_id(16),
    get_product_by_id(17),
    get_product_by_id(18)
];

// Fetch Explore More
$explore_products = [
    get_product_by_id(19),
    get_product_by_id(20),
    get_product_by_id(21),
    get_product_by_id(22),
    get_product_by_id(23),
    get_product_by_id(24)
];

// Fetch New Arrivals
$new_arrival_products = [
    get_product_by_id(25),
    get_product_by_id(26),
    get_product_by_id(27),
    get_product_by_id(28),
    get_product_by_id(29),
    get_product_by_id(30)
];

// Explore Categories Circle Data
$circle_categories = [
    ['name' => 'Visiting Cards', 'link' => 'category.php?id=1', 'image' => 'assets/images/vc.jpg'],
    ['name' => 'Custom Polo T-shirts', 'link' => 'subcategory.php?id=5', 'image' => 'assets/images/polo.jpg'],
    ['name' => 'Custom Office shirts', 'link' => 'subcategory.php?id=6', 'image' => 'assets/images/shirt.jpg'],
    ['name' => 'Custom T-shirts', 'link' => 'subcategory.php?id=7', 'image' => 'assets/images/tee.jpg'],
    ['name' => 'Custom Caps', 'link' => 'subcategory.php?id=8', 'image' => 'assets/images/cap.jpg'],
    ['name' => 'Bags & Packaging', 'link' => 'subcategory.php?id=29', 'image' => 'assets/images/bag.jpg'],
    ['name' => 'Office Stationery', 'link' => 'subcategory.php?id=32', 'image' => 'assets/images/office.jpg'],
    ['name' => 'Mugs & Drinkware', 'link' => 'subcategory.php?id=13', 'image' => 'assets/images/mug.jpg']
];
?>

<main class=" px-0">

    <!-- 1. Hero Stacked Banners Section -->
    <section class="hero-section">
        <div class="row g-1">
            <?php foreach ($hero_banners as $banner): ?>
                <div class="col-12">
                    <div class="hero-banner-container" style="background-image: url('<?php echo $banner['image_url']; ?>');">
                        <div class="hero-overlay-card">
                            <h2><?php echo htmlspecialchars($banner['title']); ?></h2>
                            <p class="mb-4"><?php echo htmlspecialchars($banner['subtitle']); ?></p>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($banner['button1_text'])): ?>
                                    <a href="<?php echo $banner['button1_link']; ?>" class="btn btn-vp-dark"><?php echo htmlspecialchars($banner['button1_text']); ?></a>
                                <?php endif; ?>
                                <?php if (!empty($banner['button2_text'])): ?>
                                    <a href="<?php echo $banner['button2_link']; ?>" class="btn btn-vp-outline"><?php echo htmlspecialchars($banner['button2_text']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 2. Explore all categories row -->
    <section class="explore-categories-section container py-4 px-4">
        <h3 class="section-title">Explore all categories</h3>
        <div class="carousel-outer-wrapper">
            <!-- Navigation controls -->
            <div class="slider-control-btn slider-control-prev">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div class="slider-control-btn slider-control-next">
                <i class="fa-solid fa-chevron-right"></i>
            </div>

            <!-- Inner items wrapper -->
            <div class="carousel-inner-slider">
                <?php foreach ($circle_categories as $ccat): ?>
                    <a href="<?php echo $ccat['link']; ?>" class="category-circle-card product-slider-card">
                        <div class="category-image-wrap">
                            <img src="<?php echo $ccat['image']; ?>" alt="<?php echo htmlspecialchars($ccat['name']); ?>">
                        </div>
                        <div class="category-card-title"><?php echo htmlspecialchars($ccat['name']); ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Helper Function to Render Product Carousels -->
    <?php
    function render_carousel($title, $products)
    {
        $slug = strtolower(str_replace(' ', '-', $title));
    ?>
        <section class="product-carousel-section product-carousel-<?php echo $slug; ?> container py-4 px-4">
            <h3 class="section-title"><?php echo htmlspecialchars($title); ?></h3>
            <div class="carousel-outer-wrapper">
                <!-- Navigation controls -->
                <div class="slider-control-btn slider-control-prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <div class="slider-control-btn slider-control-next">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>

                <!-- Inner items wrapper -->
                <div class="carousel-inner-slider">
                    <?php foreach ($products as $prod):
                        if (!$prod) continue;
                    ?>
                        <a href="product.php?id=<?php echo $prod['id']; ?>" class="product-slider-card">
                            <!-- Badge Price Tag -->
                            <div class="product-badge-tag"><?php echo htmlspecialchars($prod['tag']); ?></div>

                            <!-- Image Container -->
                            <div class="product-image-container">
                                <img src="<?php echo $prod['image_url']; ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>">
                            </div>

                            <!-- Details Container -->
                            <div class="product-details-container">
                                <div class="product-card-name"><?php echo htmlspecialchars($prod['name']); ?></div>
                                
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php
    }
    ?>

    <!-- 3. Our Most Popular Products Carousel -->
    <?php render_carousel('Our Most Popular Products', $popular_products); ?>

    <!-- 4. Trending Carousel -->
    <?php render_carousel('Trending', $trending_products); ?>

    <!-- 5. Labels, Stickers and Packaging Carousel -->
    <?php render_carousel('Labels, Stickers and Packaging', $label_products); ?>

    <!-- 6. Mid Promo Banners Stacked -->
    <section class="mid-promos-section">
        <div class="promo-banners-stack">
            <?php foreach ($promo_banners as $banner): ?>
                <div class="promo-banner-item">
                    <div class="promo-mid-banner" style="background-image: url('<?php echo $banner['image_url']; ?>');">
                        <div class="promo-mid-card">
                            <h3><?php echo htmlspecialchars($banner['title']); ?></h3>
                            <p class="mb-3"><?php echo htmlspecialchars($banner['subtitle']); ?></p>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($banner['button1_text'])): ?>
                                    <a href="<?php echo $banner['button1_link']; ?>" class="btn btn-vp-dark btn-sm py-2 px-3"><?php echo htmlspecialchars($banner['button1_text']); ?></a>
                                <?php endif; ?>
                                <?php if (!empty($banner['button2_text'])): ?>
                                    <a href="<?php echo $banner['button2_link']; ?>" class="btn btn-vp-dark btn-sm py-2 px-3"><?php echo htmlspecialchars($banner['button2_text']); ?></a>
                                <?php endif; ?>
                                <?php if (!empty($banner['button3_text'])): ?>
                                    <a href="<?php echo $banner['button3_link']; ?>" class="btn btn-vp-dark btn-sm py-2 px-3"><?php echo htmlspecialchars($banner['button3_text']); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 7. Explore More Carousel -->
    <?php render_carousel('Explore More', $explore_products); ?>

    <!-- 8. New Arrivals Carousel -->
    <?php render_carousel('New Arrivals', $new_arrival_products); ?>

</main>

<?php
require_once __DIR__ . '/footer.php';
?>