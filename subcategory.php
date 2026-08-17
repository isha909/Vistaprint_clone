<?php
require_once __DIR__ . '/functions.php';

$subcategory_id = isset($_GET['id']) ? intval($_GET['id']) : null;

$subcategory = null;
$category = null;
$products = [];
$page_title = "Shop Printing Products";

if ($subcategory_id) {
    // Fetch Subcategory details
    if (is_db_available()) {
        $rows = db_query("SELECT s.*, c.name as category_name 
                          FROM subcategories s
                          INNER JOIN categories c ON s.category_id = c.id
                          WHERE s.id = ? LIMIT 1", [$subcategory_id], 'i');
        if (!empty($rows)) {
            $subcategory = $rows[0];
            $category = [
                'id' => $subcategory['category_id'],
                'name' => $subcategory['category_name']
            ];
        }
    } else {
        // Fallback mock check
        global $mock_subcategories, $mock_categories;
        foreach ($mock_subcategories as $sub) {
            if ($sub['id'] == $subcategory_id) {
                $subcategory = $sub;
                foreach ($mock_categories as $cat) {
                    if ($cat['id'] == $sub['category_id']) {
                        $category = $cat;
                        break;
                    }
                }
                break;
            }
        }
    }

    if ($subcategory) {
        $page_title = $subcategory['name'];
        $products = get_products_by_subcategory($subcategory_id);
    }
}

if (!$subcategory) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>

<div class="container py-5 px-4">
    <!-- Breadcrumb navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <?php if ($category): ?>
                <li class="breadcrumb-item"><a href="category.php?id=<?php echo $category['id']; ?>" class="text-secondary text-decoration-none"><?php echo htmlspecialchars($category['name']); ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?php echo htmlspecialchars($subcategory['name']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar filters -->
        <div class="col-lg-3 mb-4">
            <div class="custom-card p-4">
                <h5 class="fw-bold font-outfit text-dark mb-3">All Categories</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2" style="font-size: 14px;">
                    <?php
                    $cats = get_categories();
                    foreach ($cats as $c):
                    ?>
                        <li>
                            <a href="category.php?id=<?php echo $c['id']; ?>" class="text-secondary text-decoration-none hover-primary <?php echo ($category && $category['id'] == $c['id']) ? 'fw-bold text-primary' : ''; ?>">
                                <?php echo htmlspecialchars($c['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <hr class="my-4">
                <h5 class="fw-bold font-outfit text-dark mb-3">Professional Printing</h5>
                <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.5;">
                    Vistaprint is trusted by millions of small businesses worldwide for professional marketing materials, visiting cards, apparel, signage and custom promotional merchandise.
                </p>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold font-outfit text-dark mb-1"><?php echo htmlspecialchars($subcategory['name']); ?></h2>
                    <p class="text-muted mb-0" style="font-size: 14px;">
                        Found <?php echo count($products); ?> product(s) in this subcategory
                    </p>
                </div>
            </div>

            <?php if (empty($products)): ?>
                <div class="text-center py-5 border rounded bg-light">
                    <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                    <h4 class="fw-bold text-dark">Coming Soon</h4>
                    <p class="text-secondary mb-4">We are currently updating our products in this section. Please check back later.</p>
                    <a href="index.php" class="btn btn-vp-dark">Back to Home</a>
                </div>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <?php foreach ($products as $prod): ?>
                        <div class="col">
                            <div class="card h-100 custom-card d-flex flex-column justify-content-between position-relative overflow-hidden">
                                <div class="badge-custom-tag position-absolute top-0 start-0 m-3 z-3">
                                    <?php echo isset($prod['tag']) ? htmlspecialchars($prod['tag']) : 'Starting at ' . format_price($prod['starting_price']); ?>
                                </div>

                                <div class="p-4 d-flex align-items-center justify-content-center bg-white border-bottom" style="height: 200px;">
                                    <img src="<?php echo $prod['image_url']; ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                </div>

                                <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-2"><?php echo htmlspecialchars($prod['name']); ?></h6>
                                        <p class="text-muted mb-3" style="font-size: 13px;"><?php echo htmlspecialchars($prod['description']); ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-secondary fw-semibold" style="font-size: 13px;">Starting Price</span>
                                        <a href="product.php?id=<?php echo $prod['id']; ?>" class="btn btn-vp-dark btn-sm px-3">Customize</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$hide_newsletter = true;
require_once __DIR__ . '/footer.php';
?>