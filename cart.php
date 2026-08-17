<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/header.php';

// Handle Quantity Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_qty' && isset($_POST['cart_key']) && isset($_POST['qty'])) {
        $cart_key = sanitize($_POST['cart_key']);
        $qty = intval($_POST['qty']);
        update_cart_qty($cart_key, $qty);
        header("Location: cart.php");
        exit;
    }
    if ($_POST['action'] === 'clear') {
        clear_cart();
        header("Location: cart.php");
        exit;
    }
}

// Handle Single Item Removal
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['key'])) {
    $cart_key = sanitize($_GET['key']);
    remove_from_cart($cart_key);
    header("Location: cart.php");
    exit;
}

$cart_items = get_cart_items();
$subtotal = get_cart_total();

// Shipping calculation (Free if > ₹1499, else ₹150)
$shipping_limit = 1499.00;
$shipping_cost = 150.00;
if ($subtotal >= $shipping_limit || $subtotal == 0) {
    $shipping_cost = 0.00;
}
$grand_total = $subtotal + $shipping_cost;

$page_title = "Your Shopping Cart";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>

<div class="container py-5">

    <?php if (isset($_GET['added'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> Product successfully added to your shopping cart!
            <button type="button" class="btn-close" data-bs-alert="dismiss" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <div class="empty-cart-container">
            <i class="fa-solid fa-bag-shopping empty-cart-icon"></i>
            <h2>Looks like your cart is empty.</h2>
            <p class="subtext">Let's fix that — there are lots of great things waiting for you!</p>

            <div class="empty-cart-options">
                <div class="empty-cart-option-card">
                    <h5>Sign in or create an account</h5>
                    <p>View and manage your account information.</p>
                    <a href="login.php?redirect=cart.php" class="empty-cart-btn">
                        <i class="fa-solid fa-user"></i> Sign in
                    </a>
                </div>

                <div class="empty-cart-option-card">
                    <h5>Track an order</h5>
                    <p>Find and track an order to see its status.</p>
                    <a href="track-order.php" class="empty-cart-btn">
                        <i class="fa-solid fa-box"></i> Track an order
                    </a>
                </div>

                <div class="empty-cart-option-card">
                    <h5>Shop with a promo code</h5>
                    <p>Apply a promo code to see discounted products as you shop.</p>
                    <a href="#" class="promo-toggle-link" id="promoToggle">
                        Have a promo code? <i class="fa-solid fa-chevron-down" id="promoChevron"></i>
                    </a>
                    <div class="promo-input-wrap d-none" id="promoInputWrap">
                        <input type="text" class="promo-input" id="promoCodeInput" placeholder="">
                        <button type="button" class="promo-apply-btn" id="promoApplyBtn" disabled>Apply</button>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-lg-8">
                <div class="custom-card p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr style="font-size: 13px; font-weight: 600; text-transform: uppercase;" class="text-secondary border-bottom">
                                    <th scope="col" colspan="2" class="pb-3">Product</th>
                                    <th scope="col" class="pb-3 text-center">Quantity</th>
                                    <th scope="col" class="pb-3 text-end">Price</th>
                                    <th scope="col" class="pb-3 text-end">Total</th>
                                    <th scope="col" class="pb-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $key => $item):
                                    $item_total = $item['price'] * $item['qty'];
                                ?>
                                    <tr class="border-bottom">
                                        <!-- Thumbnail -->
                                        <td style="width: 80px;" class="py-3">
                                            <div class="bg-light p-2 rounded text-center" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                            </div>
                                        </td>
                                        <!-- Name & Options -->
                                        <td class="py-3">
                                            <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;"><?php echo htmlspecialchars($item['name']); ?></h6>
                                            <div class="text-muted d-flex flex-wrap gap-2" style="font-size: 12px;">
                                                <span>Paper: <strong class="text-dark text-capitalize"><?php echo htmlspecialchars($item['options']['paper']); ?></strong></span>
                                                <span>•</span>
                                                <span>Finish: <strong class="text-dark text-capitalize"><?php echo htmlspecialchars($item['options']['finish']); ?></strong></span>
                                            </div>
                                        </td>
                                        <!-- Quantity Form -->
                                        <td class="py-3 text-center" style="width: 140px;">
                                            <form action="cart.php" method="POST" class="d-flex align-items-center justify-content-center">
                                                <input type="hidden" name="action" value="update_qty">
                                                <input type="hidden" name="cart_key" value="<?php echo $key; ?>">
                                                <input type="number" name="qty" class="form-control text-center form-control-sm" value="<?php echo $item['qty']; ?>" min="1" max="1000" style="width: 60px; border-radius: 4px;" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <!-- Price -->
                                        <td class="py-3 text-end text-dark font-outfit" style="font-size: 14px;">
                                            <?php echo format_price($item['price']); ?>
                                        </td>
                                        <!-- Item Total -->
                                        <td class="py-3 text-end fw-bold text-primary font-outfit" style="font-size: 14px;">
                                            <?php echo format_price($item_total); ?>
                                        </td>
                                        <!-- Action -->
                                        <td class="py-3 text-center">
                                            <a href="cart.php?action=remove&key=<?php echo $key; ?>" class="text-danger hover-opacity fs-5" title="Remove Item">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Cart Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3">
                        <a href="index.php" class="btn btn-outline-secondary btn-sm" style="border-radius: 4px;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
                        </a>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="action" value="clear">
                            <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm" onclick="return confirm('Are you sure you want to clear your shopping cart?')">
                                <i class="fa-solid fa-xmark me-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary Box -->
            <div class="col-lg-4">
                <div class="custom-card p-4 bg-white">
                    <h5 class="fw-bold font-outfit text-dark mb-4 pb-2 border-bottom">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-3 text-secondary" style="font-size: 14px;">
                        <span>Subtotal (<?php echo get_cart_count(); ?> items)</span>
                        <span class="text-dark font-outfit"><?php echo format_price($subtotal); ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-secondary" style="font-size: 14px;">
                        <span>Shipping & Handling</span>
                        <span class="text-dark font-outfit">
                            <?php echo $shipping_cost > 0 ? format_price($shipping_cost) : '<span class="text-success fw-semibold">FREE</span>'; ?>
                        </span>
                    </div>

                    <?php if ($shipping_cost > 0): ?>
                        <div class="alert alert-secondary py-2 px-3 mb-4 text-center rounded-3" style="font-size: 11px;">
                            Add <span class="fw-semibold"><?php echo format_price($shipping_limit - $subtotal); ?></span> more to get <span class="fw-semibold">FREE delivery</span>!
                        </div>
                    <?php endif; ?>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark" style="font-size: 16px;">Total</span>
                        <span class="fw-bold text-primary fs-4 font-outfit"><?php echo format_price($grand_total); ?></span>
                    </div>

                    <a href="checkout.php" class="btn btn-vp-dark w-100 py-3 fw-bold" style="border-radius: 8px;">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('promoToggle');
    const wrap = document.getElementById('promoInputWrap');
    const chevron = document.getElementById('promoChevron');
    const input = document.getElementById('promoCodeInput');
    const applyBtn = document.getElementById('promoApplyBtn');

    toggle.addEventListener('click', function (e) {
        e.preventDefault();
        wrap.classList.toggle('d-none');
        chevron.classList.toggle('fa-chevron-down');
        chevron.classList.toggle('fa-chevron-up');
    });

    input.addEventListener('input', function () {
        applyBtn.disabled = input.value.trim() === '';
    });
});
</script>

<?php
$hide_newsletter = true;
require_once __DIR__ . '/footer.php';
?>