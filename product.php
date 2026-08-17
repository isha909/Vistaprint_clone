<?php
require_once __DIR__ . '/functions.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$product = get_product_by_id($product_id);

if (!$product) {
    header("Location: index.php");
    exit;
}

$page_title = "Customize " . $product['name'];

// Add to Cart Logic
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;
    if ($qty < 1) $qty = 1;
    
    $options = [
        'finish' => isset($_POST['finish']) ? sanitize($_POST['finish']) : 'matte',
        'paper' => isset($_POST['paper']) ? sanitize($_POST['paper']) : 'standard'
    ];
    
    // Calculate final single product price based on options
    $item_price = $product['starting_price'];
    
    // Apply options price logic to database checkout as well
    if ($options['finish'] === 'glossy') {
        $item_price *= 1.15;
    } elseif ($options['finish'] === 'metallic') {
        $item_price *= 1.35;
    }
    
    if ($options['paper'] === 'premium') {
        $item_price *= 1.25;
    }
    
    // Add item to cart session (overriding price calculation in session block)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $option_str = serialize($options);
    $cart_key = md5($product_id . '_' . $option_str);
    
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'id' => $product_id,
            'name' => $product['name'],
            'image_url' => $product['image_url'],
            'price' => round($item_price, 2),
            'qty' => $qty,
            'options' => $options
        ];
    }
    
    header("Location: cart.php?added=1");
    exit;
}

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>

<div class="container py-5 px-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="category.php?id=<?php echo $product['category_id']; ?>" class="text-secondary text-decoration-none"><?php echo htmlspecialchars($product['category_name']); ?></a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Product Image Showcase -->
        <div class="col-lg-6">
            <div class="custom-card p-4 bg-white text-center d-flex align-items-center justify-content-center" style="min-height: 400px;">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid rounded" style="max-height: 380px; object-fit: contain;">
            </div>
        </div>

        <!-- Customizer Configuration panel -->
        <div class="col-lg-6">
            <div class="product-info-panel">
                <span class="badge-custom-tag mb-3 d-inline-block"><?php echo htmlspecialchars($product['tag']); ?></span>
                <h1 class="fw-bold font-outfit text-dark mb-2" style="font-size: 32px;"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="d-flex align-items-center mb-4 text-warning">
                    <div class="fs-6 me-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="text-muted" style="font-size: 13px;">(4.7/5 stars based on 124 reviews)</span>
                </div>

                <p class="text-secondary mb-4" style="line-height: 1.6; font-size: 15px;"><?php echo htmlspecialchars($product['description']); ?></p>
                <hr class="my-4">

                <!-- Selection Form -->
                <form action="product.php?id=<?php echo $product['id']; ?>" method="POST">
                    <input type="hidden" name="action" value="add_to_cart">
                    
                    <!-- Option 1: Paper Stock -->
                    <div class="mb-3">
                        <label for="paperSelect" class="form-label fw-semibold text-dark" style="font-size: 14px;">Paper Quality</label>
                        <select class="form-select" id="paperSelect" name="paper" style="border-radius: 6px; padding: 10px;">
                            <option value="standard" selected>Standard (Thick card stock)</option>
                            <option value="premium">Premium (Thicker stock, luxury feel) - Add 25%</option>
                        </select>
                    </div>

                    <!-- Option 2: Finish Type -->
                    <div class="mb-4">
                        <label for="finishSelect" class="form-label fw-semibold text-dark" style="font-size: 14px;">Finish Coating</label>
                        <select class="form-select" id="finishSelect" name="finish" style="border-radius: 6px; padding: 10px;">
                            <option value="matte" selected>Matte (Non-reflective, smooth write)</option>
                            <option value="glossy">Glossy (Vivid colors, shining finish) - Add 15%</option>
                            <option value="metallic">Metallic Foil (Selected silver/gold accents) - Add 35%</option>
                        </select>
                    </div>

                    <!-- Options 3: Quantity selector and Live pricing -->
                    <div class="row align-items-end g-3 mb-4">
                        <div class="col-6 col-sm-4">
                            <label class="form-label fw-semibold text-dark" style="font-size: 14px;">Quantity</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" id="btnMinus" style="border-radius: 6px 0 0 6px;"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" name="qty" id="qtyInput" class="form-control text-center" value="1" min="1" max="10000" style="padding: 10px; border-left: 0; border-right: 0;">
                                <button type="button" class="btn btn-outline-secondary" id="btnPlus" style="border-radius: 0 6px 6px 0;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>

                        <!-- Live Price Display -->
                        <div class="col-6 col-sm-8 text-end">
                            <div class="text-secondary" style="font-size: 13px;">Estimated Price</div>
                            <!-- Save base price for JS dynamic changes -->
                            <div class="d-none" id="basePrice" data-base-price="<?php echo $product['starting_price']; ?>"></div>
                            <h2 class="fw-bold text-primary mb-0 font-outfit" id="totalPrice">
                                <?php echo format_price($product['starting_price']); ?>
                            </h2>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-vp-dark py-3 px-5 fw-bold flex-grow-1" style="border-radius: 8px;">
                            <i class="fa-solid fa-cart-shopping me-2"></i> Add to Cart
                        </button>
                    </div>
                </form>

                <hr class="my-4">
                
                <!-- Guarantee icon list -->
                <div class="d-flex flex-column gap-2" style="font-size: 13px;">
                    <div class="text-secondary d-flex align-items-center">
                        <i class="fa-solid fa-truck text-success me-2"></i> Free shipping on orders above ₹1499.
                    </div>
                    <div class="text-secondary d-flex align-items-center">
                        <i class="fa-solid fa-shield text-primary me-2"></i> 100% Quality Guaranteed: reprint or refund options.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/footer.php';
?>
