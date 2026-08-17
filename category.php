<?php
require_once __DIR__ . '/functions.php';
// var_dump(is_db_available());
// exit;

$category_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

$category = null;
$products = [];
$subcategories = [];
$page_title = "Shop Printing Products";

if ($category_id) {
    $category = get_category_by_id($category_id);

    if ($category) {
        $page_title = $category['name'];
        $subcategories = get_subcategories($category_id);
        $products = get_products_by_category($category_id);
    }
} elseif (!empty($search_query)) {
    $page_title = "Search Results for '" . htmlspecialchars($search_query) . "'";
    if (is_db_available()) {
        $products = db_query("SELECT * FROM products WHERE name LIKE ? AND status = 1", ["%$search_query%"], 's');
    } else {
        global $mock_products;
        foreach ($mock_products as $prod) {
            if (stripos($prod['name'], $search_query) !== false || stripos($prod['description'], $search_query) !== false) {
                $products[] = $prod;
            }
        }
    }
} else {
    header("Location: index.php");
    exit;
}

// Group products into display sections (falls back to one group if 'section' isn't set)
$sections = [
    'shapes'    => ['title' => 'Shop by shapes',           'subtitle' => 'Select from various shapes & sizes.', 'items' => []],
    'papers'    => ['title' => 'Shop by papers & textures', 'subtitle' => 'Most Popular',                        'items' => []],
    'specialty' => ['title' => 'Shop specialty business cards', 'subtitle' => 'Make a statement with our selection of specialty cards, intended for unique projects and uses.', 'items' => []],
    'other'     => ['title' => 'More products', 'subtitle' => '', 'items' => []],
];
foreach ($products as $prod) {
    $key = isset($prod['section']) && isset($sections[$prod['section']]) ? $prod['section'] : 'other';
    $sections[$key]['items'][] = $prod;
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';

// Renders one product card — kept as a local function so all sections share identical markup
if (!function_exists('render_product_card')) {
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
}

// Router: Include the appropriate template based on template_type
if ($category && isset($category['template_type']) && $category['template_type'] === 'view_all') {
    include __DIR__ . '/templates/category-view-all.php';
} else {
    // Falls back to category-detail template for search results and detail categories
    include __DIR__ . '/templates/category-detail.php';
}

$hide_newsletter = true;
require_once __DIR__ . '/footer.php';
?>