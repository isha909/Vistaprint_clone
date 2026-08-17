<?php
require_once __DIR__ . '/functions.php';

// Force authentication for checkout
if (!is_logged_in()) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}

$cart_items = get_cart_items();
if (empty($cart_items)) {
    header("Location: cart.php");
    exit;
}

$subtotal = get_cart_total();
$shipping_cost = ($subtotal >= 1499.00) ? 0.00 : 150.00;
$grand_total = $subtotal + $shipping_cost;

$order_success = false;
$order_id = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'place_order') {
    $name = isset($_POST['fullName']) ? sanitize($_POST['fullName']) : '';
    $address = isset($_POST['address']) ? sanitize($_POST['address']) : '';
    $city = isset($_POST['city']) ? sanitize($_POST['city']) : '';
    $state = isset($_POST['state']) ? sanitize($_POST['state']) : '';
    $zip = isset($_POST['zip']) ? sanitize($_POST['zip']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    
    if (empty($name) || empty($address) || empty($city) || empty($state) || empty($zip) || empty($phone)) {
        $error = 'All shipping address fields are required.';
    } else {
        $full_address = $name . "\n" . $address . "\n" . $city . ", " . $state . " - " . $zip . "\nPhone: " . $phone;
        $user_id = $_SESSION['user_id'];
        
        $order_id = create_order($user_id, $grand_total, $full_address, $cart_items);
        if ($order_id) {
            $order_success = true;
            clear_cart(); // Clear cart after placing order successfully
        } else {
            $error = 'There was an issue processing your order. Please try again.';
        }
    }
}

$page_title = "Checkout";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>

<div class="container py-5 px-4">
    <?php if ($order_success): ?>
        <!-- Order Success State -->
        <div class="text-center py-5 px-4 max-width-600 mx-auto custom-card bg-white mt-4">
            <div class="mb-4">
                <i class="fa-solid fa-circle-check text-success" style="font-size: 80px;"></i>
            </div>
            <h1 class="fw-bold font-outfit text-dark mb-2">Order Confirmed!</h1>
            <p class="text-secondary fs-5 mb-4">Thank you for your order. We are starting to print your custom items.</p>
            
            <div class="bg-light p-3 rounded-3 mb-4 text-start" style="font-size: 14px;">
                <div class="mb-2 text-secondary">Order ID: <strong class="text-dark">#<?php echo $order_id; ?></strong></div>
                <div class="mb-2 text-secondary">Estimated Delivery: <strong class="text-dark"><?php echo date('d M Y', strtotime('+7 days')); ?></strong></div>
                <div class="text-secondary">Amount Paid: <strong class="text-primary font-outfit"><?php echo format_price($grand_total); ?></strong></div>
            </div>
            
            <p class="text-muted mb-4" style="font-size: 12px;">A confirmation email has been sent to your registered address. You can check the status of your order in your Profile dashboard at any time.</p>
            
            <a href="index.php" class="btn btn-vp-dark px-5 py-2">Continue Shopping</a>
        </div>
    <?php else: ?>
        <!-- Checkout Form / Summary State -->
        <h2 class="fw-bold font-outfit text-dark mb-4">Checkout</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <!-- Shipping Information -->
            <div class="col-lg-7">
                <div class="custom-card p-4 bg-white">
                    <h5 class="fw-bold font-outfit text-dark mb-4 pb-2 border-bottom">Shipping Address</h5>
                    
                    <form action="checkout.php" method="POST" id="checkoutForm">
                        <input type="hidden" name="action" value="place_order">
                        
                        <div class="mb-3">
                            <label for="fullName" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>" style="border-radius: 6px; padding: 10px;" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Street Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Flat / House No. / Area" style="border-radius: 6px; padding: 10px;" required>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="city" class="form-label text-secondary fw-semibold" style="font-size: 13px;">City</label>
                                <input type="text" class="form-control" id="city" name="city" style="border-radius: 6px; padding: 10px;" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="state" class="form-label text-secondary fw-semibold" style="font-size: 13px;">State</label>
                                <input type="text" class="form-control" id="state" name="state" style="border-radius: 6px; padding: 10px;" required>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label for="zip" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Postal / ZIP Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" style="border-radius: 6px; padding: 10px;" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="phone" class="form-label text-secondary fw-semibold" style="font-size: 13px;">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="10-digit number" style="border-radius: 6px; padding: 10px;" required>
                            </div>
                        </div>

                        <h5 class="fw-bold font-outfit text-dark mb-4 pb-2 border-bottom">Payment Method</h5>
                        <div class="mb-4">
                            <div class="form-check p-3 border rounded-3 bg-light d-flex align-items-center mb-3">
                                <input class="form-check-input ms-0 me-3" type="radio" name="paymentMethod" id="cod" value="COD" checked>
                                <label class="form-check-label text-dark fw-semibold d-flex flex-column" for="cod" style="font-size: 14px;">
                                    <span>Cash on Delivery (COD) / Pay on Delivery</span>
                                    <span class="text-secondary fw-normal" style="font-size: 11px;">Pay securely using cash/card upon receiving the package.</span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-vp-dark w-100 py-3 fw-bold fs-5" style="border-radius: 8px;">
                            Place Order (<?php echo format_price($grand_total); ?>)
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Checkout Items Summary -->
            <div class="col-lg-5">
                <div class="custom-card p-4 bg-white">
                    <h5 class="fw-bold font-outfit text-dark mb-4 pb-2 border-bottom">Review Items</h5>
                    
                    <div class="d-flex flex-column gap-3 mb-4" style="max-height: 250px; overflow-y: auto;">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light p-2 rounded text-center" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark" style="font-size: 14px; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo htmlspecialchars($item['name']); ?></div>
                                        <div class="text-muted" style="font-size: 11px;">Qty: <?php echo $item['qty']; ?> | Finish: <?php echo htmlspecialchars($item['options']['finish']); ?></div>
                                    </div>
                                </div>
                                <span class="font-outfit text-dark fw-bold" style="font-size: 13px;">
                                    <?php echo format_price($item['price'] * $item['qty']); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between mb-2 text-secondary" style="font-size: 13px;">
                        <span>Subtotal</span>
                        <span class="text-dark font-outfit"><?php echo format_price($subtotal); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-secondary" style="font-size: 13px;">
                        <span>Shipping Cost</span>
                        <span class="text-dark font-outfit"><?php echo $shipping_cost > 0 ? format_price($shipping_cost) : 'FREE'; ?></span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center text-dark">
                        <span class="fw-bold" style="font-size: 15px;">Order Total</span>
                        <span class="fw-bold text-primary fs-4 font-outfit"><?php echo format_price($grand_total); ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/footer.php';
?>
