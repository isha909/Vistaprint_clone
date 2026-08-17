<?php
require_once __DIR__ . '/functions.php';

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$products = [];
$page_title = "Search Results";

if (!empty($search_query)) {
    $page_title = "Search Results for '" . htmlspecialchars($search_query) . "'";
    if (is_db_available()) {
        $products = db_query("SELECT p.*, s.name as subcategory_name, c.name as category_name 
                              FROM products p
                              INNER JOIN subcategories s ON p.subcategory_id = s.id
                              INNER JOIN categories c ON s.category_id = c.id
                              WHERE (p.name LIKE ? OR p.description LIKE ? OR s.name LIKE ? OR c.name LIKE ? OR p.tag LIKE ?)
                                AND p.status = 1
                              ORDER BY p.id ASC", 
                              ["%$search_query%", "%$search_query%", "%$search_query%", "%$search_query%", "%$search_query%"], 
                              'sssss');
    } else {
        // Fallback mockup
        global $mock_products, $mock_subcategories, $mock_categories;
        foreach ($mock_products as $prod) {
            $sub_name = '';
            $cat_name = '';
            foreach ($mock_subcategories as $sub) {
                if ($sub['id'] == $prod['subcategory_id']) {
                    $sub_name = $sub['name'];
                    foreach ($mock_categories as $cat) {
                        if ($cat['id'] == $sub['category_id']) {
                            $cat_name = $cat['name'];
                            break;
                        }
                    }
                    break;
                }
            }
            if (stripos($prod['name'], $search_query) !== false || 
                stripos($prod['description'], $search_query) !== false || 
                (isset($prod['tag']) && stripos($prod['tag'], $search_query) !== false) ||
                stripos($sub_name, $search_query) !== false || 
                stripos($cat_name, $search_query) !== false) {
                $products[] = array_merge($prod, [
                    'subcategory_name' => $sub_name,
                    'category_name' => $cat_name
                ]);
            }
        }
    }
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';

function render_product_card($prod) {
    $rating = isset($prod['rating']) ? floatval($prod['rating']) : 4.5;
    $reviews = isset($prod['review_count']) ? intval($prod['review_count']) : 0;
    $unit_price = isset($prod['unit_price']) && $prod['unit_price'] !== null ? $prod['unit_price'] : ($prod['starting_price'] / 100);
    $unit_label = isset($prod['unit_label']) && $prod['unit_label'] ? $prod['unit_label'] : '100 units';
    ?>
    <div class="col">
        <div class="vp-product-card position-relative">
            <?php if (!empty($prod['is_new'])): ?>
                <span class="vp-new-badge">New</span>
            <?php endif; ?>
            <button class="vp-wishlist-btn" type="button" aria-label="Add to favorites">
                <i class="fa-regular fa-heart"></i>
            </button>

            <a href="product.php?id=<?php echo $prod['id']; ?>" class="vp-product-img-wrap">
                <img src="<?php echo htmlspecialchars($prod['image_url']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>">
            </a>

            <div class="vp-product-info">
                <a href="product.php?id=<?php echo $prod['id']; ?>" class="vp-product-name"><?php echo htmlspecialchars($prod['name']); ?></a>

                <div class="vp-product-rating">
                    <?php
                    $full = floor($rating);
                    $half = ($rating - $full) >= 0.5;
                    for ($i = 0; $i < $full; $i++) echo '<i class="fa-solid fa-star"></i>';
                    if ($half) echo '<i class="fa-solid fa-star-half-stroke"></i>';
                    ?>
                    <span class="vp-rating-value"><?php echo number_format($rating, 1); ?></span>
                    <?php if ($reviews > 0): ?>
                        <span class="vp-review-count">(<?php echo $reviews; ?>)</span>
                    <?php endif; ?>
                </div>

                <div class="vp-product-price">
                    From <?php echo format_price($prod['starting_price']); ?>
                </div>
                <div class="vp-product-unit-price">
                    <?php echo format_price($unit_price); ?> each / <?php echo htmlspecialchars($unit_label); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<div class="container py-5 px-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Search Results</li>
        </ol>
    </nav>

    <h2 class="fw-bold font-outfit text-dark mb-4">
        <?php if (!empty($search_query)): ?>
            Search Results for "<?php echo htmlspecialchars($search_query); ?>"
        <?php else: ?>
            Search Products
        <?php endif; ?>
    </h2>

    <?php if (empty($products)): ?>
        <div class="text-center py-5 border rounded bg-light">
            <i class="fa-solid fa-magnifying-glass fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-dark">No Products Found</h4>
            <p class="text-secondary mb-4">We couldn't find any products matching your search criteria. Try a different query.</p>
            <form action="search.php" method="GET" class="max-width-600 mx-auto px-4" style="max-width: 500px;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search for items..." value="<?php echo htmlspecialchars($search_query); ?>" required style="border-radius: 6px 0 0 6px; padding: 10px;">
                    <button class="btn btn-dark px-4" type="submit" style="border-radius: 0 6px 6px 0;">Search</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="mb-5">
            <p class="text-muted mb-4">Found <?php echo count($products); ?> matching product(s).</p>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($products as $prod): ?>
                    <?php render_product_card($prod); ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$hide_newsletter = true;
require_once __DIR__ . '/footer.php';
?>
