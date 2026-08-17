<?php
require_once __DIR__ . '/functions.php';

// Force authentication for tracking orders
if (!is_logged_in()) {
    header("Location: login.php?redirect=track-order.php");
    exit;
}

$page_title = "Track Your Order";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';

$order_id_input = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;
$order = null;
$order_items = [];
$error_msg = '';

if ($order_id_input) {
    $user_id = $_SESSION['user_id'];
    if (is_db_available()) {
        // Query the order belonging to the current logged-in user
        $orders_res = db_query("SELECT * FROM orders WHERE id = ? AND user_id = ? LIMIT 1", [$order_id_input, $user_id], 'ii');
        if (!empty($orders_res)) {
            $order = $orders_res[0];
            // Query the order items
            $order_items = db_query("SELECT oi.*, p.name as product_name, p.image_url 
                                     FROM order_items oi 
                                     LEFT JOIN products p ON oi.product_id = p.id 
                                     WHERE oi.order_id = ? ORDER BY oi.id ASC", [$order_id_input], 'i');
        } else {
            $error_msg = "Order #" . htmlspecialchars($order_id_input) . " not found or you do not have permission to view it.";
        }
    } else {
        // Fallback for mock tracking (always allow if database is offline)
        $order = [
            'id' => $order_id_input,
            'user_id' => $user_id,
            'total_amount' => 1249.00,
            'shipping_address' => $_SESSION['user_name'] . "\nMock Street 123\nMock City, State - 110001\nPhone: 9876543210",
            'payment_status' => 'Paid',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ];
        $order_items = [
            [
                'product_name' => 'Standard Visiting Cards',
                'image_url' => 'assets/images/vc.jpg',
                'quantity' => 100,
                'price' => 2.00,
                'options' => serialize(['paper' => 'standard', 'finish' => 'matte'])
            ]
        ];
    }
}
?>

<div class="container py-5 px-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Track Order</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="custom-card p-4 p-sm-5 bg-white mb-4">
                <h3 class="fw-bold font-outfit text-dark mb-4 text-center">Track Your Order</h3>
                
                <!-- Track Order Search Form -->
                <form action="track-order.php" method="GET" class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-secondary"><i class="fa-solid fa-hashtag"></i></span>
                        <input type="number" name="order_id" class="form-control border-start-0 py-3" placeholder="Enter your Order ID (e.g. 1)" value="<?php echo $order_id_input ? htmlspecialchars($order_id_input) : ''; ?>" required style="border-radius: 0 6px 6px 0; font-size: 15px;">
                        <button type="submit" class="btn btn-vp-dark px-4 fw-bold">Track Status</button>
                    </div>
                </form>

                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger py-3 px-4 rounded-3 text-center" style="font-size: 14px;">
                        <i class="fa-solid fa-circle-xmark me-2"></i> <?php echo $error_msg; ?>
                    </div>
                <?php endif; ?>

                <?php if ($order): ?>
                    <hr class="my-4">
                    
                    <!-- Order Details Header -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center bg-light p-3 rounded-3 mb-4" style="font-size: 14px;">
                        <div>
                            <span class="text-secondary">Order ID:</span> 
                            <strong class="text-dark">#<?php echo $order['id']; ?></strong>
                        </div>
                        <div>
                            <span class="text-secondary">Placed on:</span> 
                            <strong class="text-dark"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></strong>
                        </div>
                        <div>
                            <span class="text-secondary">Status:</span> 
                            <span class="badge bg-success py-2 px-3 fw-bold text-uppercase"><?php echo htmlspecialchars($order['payment_status']); ?></span>
                        </div>
                    </div>

                    <!-- Progress bar -->
                    <div class="order-progress-tracker mb-5 px-3">
                        <div class="row text-center position-relative" style="font-size: 12px;">
                            <div class="col-4">
                                <div class="progress-dot mx-auto mb-2 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="fa-solid fa-check"></i></div>
                                <div class="fw-semibold text-dark">Order Confirmed</div>
                            </div>
                            <div class="col-4">
                                <div class="progress-dot mx-auto mb-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="fa-solid fa-print"></i></div>
                                <div class="fw-semibold text-dark">Printing & Assembly</div>
                            </div>
                            <div class="col-4">
                                <div class="progress-dot mx-auto mb-2 bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="fa-solid fa-truck-fast"></i></div>
                                <div class="fw-semibold text-secondary">Shipped / In Transit</div>
                            </div>
                            <!-- Connecting Line -->
                            <div class="position-absolute top-50 start-50 translate-middle w-75 bg-secondary" style="height: 2px; z-index: -1; transform: translateY(-15px) !important;"></div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-3">Order Items</h5>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-secondary" style="font-size: 13px; text-transform: uppercase;">
                                    <th scope="col">Item</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-end">Price</th>
                                    <th scope="col" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_items as $item): 
                                    $item_options = !empty($item['options']) ? unserialize($item['options']) : [];
                                    $item_name = isset($item['product_name']) ? $item['product_name'] : 'Custom Product';
                                    $item_img = isset($item['image_url']) ? $item['image_url'] : 'assets/images/vc.jpg';
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light p-1 rounded" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="<?php echo $item_img; ?>" alt="<?php echo htmlspecialchars($item_name); ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark" style="font-size: 14px;"><?php echo htmlspecialchars($item_name); ?></div>
                                                    <?php if (!empty($item_options)): ?>
                                                        <div class="text-muted" style="font-size: 11px;">
                                                            Paper: <strong class="text-capitalize text-dark"><?php echo htmlspecialchars($item_options['paper'] ?? 'standard'); ?></strong> | 
                                                            Finish: <strong class="text-capitalize text-dark"><?php echo htmlspecialchars($item_options['finish'] ?? 'matte'); ?></strong>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center font-outfit text-dark" style="font-size: 14px;"><?php echo $item['quantity']; ?></td>
                                        <td class="text-end font-outfit text-dark" style="font-size: 14px;"><?php echo format_price($item['price']); ?></td>
                                        <td class="text-end fw-bold text-primary font-outfit" style="font-size: 14px;"><?php echo format_price($item['price'] * $item['quantity']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Shipping details and Summary -->
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <h6 class="fw-bold text-dark mb-2">Delivery Address</h6>
                            <p class="text-secondary bg-light p-3 rounded-3" style="font-size: 13px; line-height: 1.6; white-space: pre-line;"><?php echo htmlspecialchars($order['shipping_address']); ?></p>
                        </div>
                        <div class="col-sm-6 text-end">
                            <div class="d-flex justify-content-between mb-2 text-secondary" style="font-size: 14px;">
                                <span>Total Amount Paid:</span>
                                <strong class="text-primary font-outfit fs-4"><?php echo format_price($order['total_amount']); ?></strong>
                            </div>
                            <div class="text-muted" style="font-size: 11px;">Payment Method: <strong>Cash on Delivery</strong></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/footer.php';
?>
