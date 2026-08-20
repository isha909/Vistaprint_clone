<?php
header('Content-Type: text/plain');

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') ?: 'vistaprint_db');
define('DB_PORT', getenv('DB_PORT') ?: 3306);
define('DB_SSL', getenv('DB_SSL') ? filter_var(getenv('DB_SSL'), FILTER_VALIDATE_BOOLEAN) : false);

echo "Starting Vistaprint Database Setup...\n";

$conn = mysqli_init();
if (!$conn) {
    die("mysqli_init failed\n");
}

$flags = 0;
if (DB_SSL) {
    $ca_path = getenv('DB_SSL_CA') ?: (__DIR__ . '/ca.pem');
    if (!file_exists($ca_path)) {
        die("SSL CA certificate file not found at: " . $ca_path . "\n");
    }
    $conn->ssl_set(NULL, NULL, $ca_path, NULL, NULL);
    $conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
    $flags = MYSQLI_CLIENT_SSL;
}

if (!@$conn->real_connect(DB_HOST, DB_USER, DB_PASS, null, DB_PORT, null, $flags)) {
    die("Connection failed: " . $conn->connect_error . "\n");
}

if ($conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME)) {
    echo "Database '" . DB_NAME . "' verified/created successfully.\n";
} else {
    die("Error creating database: " . $conn->error . "\n");
}

$conn->select_db(DB_NAME);

$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$tables = ['order_items', 'orders', 'users', 'banners', 'products', 'subcategories', 'categories'];
foreach ($tables as $table) {
    $conn->query("DROP TABLE IF EXISTS `$table`");
}
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "Cleaned up old tables.\n";

$conn->query("CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `icon_class` VARCHAR(100) DEFAULT NULL,
  `template_type` VARCHAR(50) DEFAULT 'category_detail',
  `description` TEXT DEFAULT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE `subcategories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `is_new` TINYINT DEFAULT 0,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `subcategory_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `starting_price` DECIMAL(10,2) NOT NULL,
  `unit_price` DECIMAL(10,2) DEFAULT NULL,
  `unit_label` VARCHAR(50) DEFAULT '100 units',
  `rating` DECIMAL(2,1) DEFAULT 4.5,
  `review_count` INT DEFAULT 0,
  `tag` VARCHAR(100) DEFAULT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `section` VARCHAR(50) DEFAULT 'other',
  `is_new` TINYINT DEFAULT 0,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) DEFAULT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `button1_text` VARCHAR(100) DEFAULT NULL,
  `button1_link` VARCHAR(255) DEFAULT NULL,
  `button2_text` VARCHAR(100) DEFAULT NULL,
  `button2_link` VARCHAR(255) DEFAULT NULL,
  `button3_text` VARCHAR(100) DEFAULT NULL,
  `button3_link` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `shipping_address` TEXT NOT NULL,
  `payment_status` VARCHAR(50) DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT DEFAULT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `options` TEXT DEFAULT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

echo "Tables created successfully.\n";

// --- SEED DATA ---

$categories = [
    ['Visiting Cards', 'fa-address-card', 'category_detail', 'Design and print professional visiting cards with high-definition printing capturing rich colors on premium quality paper.', 'assets/images/vc.jpg'],
    ['Stationery, Letterheads & Notebooks', 'fa-tshirt', 'view_all', 'Shop custom letterheads, notebooks, diaries, and office essentials to keep your business organized.', 'assets/images/letter.jpg'],
    ['Stamps and Inks', 'fa-gift', 'view_all', 'Create custom self-inking and pre-inked stamps, dater stamps, and refilling inks for your daily tasks.', 'assets/images/tape.jpg'],
    ['Signs, posters and marketing materials', 'fa-bullhorn', 'view_all', 'Spread the word with large-scale printed banners, signs, posters, and table coverings.', 'assets/images/posters.jpg'],
    ['Labels, Stickers & Packaging', 'fa-tags', 'view_all', 'Custom sticker sheets, product labels, roll stickers, and printed shipping packaging.', 'assets/images/sticker.jpg'],
    ['Clothing Caps & Bags', 'fa-box-open', 'view_all', 'Custom branded outerwear, caps, tote bags, and activewear for your workforce.', 'assets/images/outerwear.jpg'],
    ['Mugs, Albums & gifts', 'fa-pen-nib', 'view_all', 'Unique personalized gifts including custom photo albums, mugs, magnets, and coasters.', 'assets/images/mug.jpg'],
    ['Pens', 'fa-coffee', 'category_detail', 'Write in style with standard ballpoints, engraved executive metal pens, or luxury fountain pens.', 'assets/images/canva.jpg'],
    ['Drinkware', 'fa-drinks', 'category_detail', 'Custom printed steel water bottles, travel tumblers, and sippers featuring your logo.', 'assets/images/mug.jpg'],
    ['Custom Polo T - shirts', 'fa-shirts', 'view_all', 'Elevate your team appearance with high quality custom embroidered and printed polo shirts.', 'assets/images/polo.jpg'],
    ['Umbrellas and rainwear', 'fa-umbrellas', 'category_detail', 'Protect your team from the elements with wind-resistant foldable umbrellas and custom raincoats.', 'assets/images/collapse.jpg'],
];

$category_ids = []; // name => id
foreach ($categories as $cat) {
    $stmt = $conn->prepare("INSERT INTO categories (name, icon_class, template_type, description, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $cat[0], $cat[1], $cat[2], $cat[3], $cat[4]);
    if ($stmt->execute()) {
        $category_ids[$cat[0]] = $conn->insert_id;
    } else {
        echo "Category insert failed for '{$cat[0]}': " . $stmt->error . "\n";
    }
    $stmt->close();
}
echo "Seeded categories: " . count($category_ids) . "\n";

// Columns: category_name, subcategory_name, is_new, image_url
$subcategories = [
    // Category: Visiting Cards
    ['Visiting Cards', 'Visiting Cards', 0, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Digital Visiting Cards', 0, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Brilliant Finishes', 0, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Standard Papers', 0, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Reorder Visiting Cards', 0, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Specialty Cards', 0, 'assets/images/magnetic.jpg'],
    ['Visiting Cards', 'Premium Papers', 0, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Design and Logo', 1, 'assets/images/vc.jpg'],
    ['Visiting Cards', 'Visiting Cards Holder', 0, 'assets/images/vc.jpg'],

    // Category: Stationery, Letterheads & Notebooks
    ['Stationery, Letterheads & Notebooks', 'Custom Stationery', 0, 'assets/images/letter.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Office Supplies', 0, 'assets/images/office.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Custom Notebooks and Diaries', 0, 'assets/images/office.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Wedding Stationery', 0, 'assets/images/wedding1.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Invitations & Announcements', 0, 'assets/images/wedding1.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Custom Keychains', 0, 'assets/images/multi.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Files and Folders', 0, 'assets/images/office.jpg'],
    ['Stationery, Letterheads & Notebooks', 'Explore more', 0, 'assets/images/letter.jpg'],

    // Category: Stamps and Inks
    ['Stamps and Inks', 'Self-Inking Stamps', 0, 'assets/images/acrylic.jpg'],
    ['Stamps and Inks', 'Pre-Inked Stamps', 0, 'assets/images/acrylic.jpg'],
    ['Stamps and Inks', 'Custom Date & Time Stamps', 0, 'assets/images/multi.jpg'],
    ['Stamps and Inks', 'Ink Pads & Refills', 0, 'assets/images/multi.jpg'],

    // Category: Signs, posters and marketing materials
    ['Signs, posters and marketing materials', 'Signs & Posters', 0, 'assets/images/posters.jpg'],
    ['Signs, posters and marketing materials', 'Marketing Materials', 0, 'assets/images/banner.jpg'],
    ['Signs, posters and marketing materials', 'More in signs', 0, 'assets/images/posters.jpg'],
    ['Signs, posters and marketing materials', 'More in marketing', 0, 'assets/images/collapse.jpg'],
    ['Signs, posters and marketing materials', 'Tale Coverings', 0, 'assets/images/tape.jpg'],
    ['Signs, posters and marketing materials', 'New Arrivals', 0, 'assets/images/acrylic.jpg'],

    // Category: Labels, Stickers & Packaging
    ['Labels, Stickers & Packaging', 'Custom Packaging', 0, 'assets/images/packing.jpg'],
    ['Labels, Stickers & Packaging', 'Custom Stickers', 0, 'assets/images/round.jpg'],
    ['Labels, Stickers & Packaging', 'Custom Labels', 0, 'assets/images/sticker.jpg'],
    ['Labels, Stickers & Packaging', 'Tags', 0, 'assets/images/shape.jpg'],
    ['Labels, Stickers & Packaging', 'Packaging Boxes', 0, 'assets/images/packing.jpg'],
    ['Labels, Stickers & Packaging', 'Newly launched', 0, 'assets/images/roll.jpg'],
    ['Labels, Stickers & Packaging', 'Laptop Skin', 0, 'assets/images/transparent.jpg'],

    // Category: Clothing Caps & Bags
    ['Clothing Caps & Bags', 'Custom T-shirts', 0, 'assets/images/tee.jpg'],
    ['Clothing Caps & Bags', 'Custom Polo T-shirts', 0, 'assets/images/polo.jpg'],
    ['Clothing Caps & Bags', 'Custom Dress Shirts', 0, 'assets/images/shirt.jpg'],
    ['Clothing Caps & Bags', 'Custom Bags', 0, 'assets/images/bag.jpg'],
    ['Clothing Caps & Bags', 'Tote Bags', 0, 'assets/images/canva.jpg'],
    ['Clothing Caps & Bags', 'Custom Caps', 0, 'assets/images/cap.jpg'],
    ['Clothing Caps & Bags', 'Custom Activewear', 0, 'assets/images/outerwear.jpg'],

    // Category: Mugs, Albums & gifts
    ['Mugs, Albums & gifts', 'Bestsellers', 0, 'assets/images/photo.jpg'],
    ['Mugs, Albums & gifts', 'Mugs', 0, 'assets/images/mug.jpg'],
    ['Mugs, Albums & gifts', 'Gift Hampers', 0, 'assets/images/multi.jpg'],
    ['Mugs, Albums & gifts', 'Custom Magnets', 0, 'assets/images/magnetic.jpg'],
    ['Mugs, Albums & gifts', 'Coasters', 0, 'assets/images/mug.jpg'],
    ['Mugs, Albums & gifts', 'Custom Pens', 0, 'assets/images/canva.jpg'],
    ['Mugs, Albums & gifts', 'Custom Photo frame', 0, 'assets/images/photo.jpg'],
    ['Mugs, Albums & gifts', 'Custom Calenders', 0, 'assets/images/large.jpg'],
    ['Mugs, Albums & gifts', 'Looking for more?', 0, 'assets/images/multi.jpg'],
    ['Mugs, Albums & gifts', 'Corporate gifts', 0, 'assets/images/multi.jpg'],

    // Category: Pens
    ['Pens', 'Bestsellers', 0, 'assets/images/canva.jpg'],
    ['Pens', 'Value pens', 0, 'assets/images/canva.jpg'],
    ['Pens', 'Executive pens', 0, 'assets/images/canva.jpg'],
    ['Pens', 'Premium pens', 0, 'assets/images/canva.jpg'],
    ['Pens', 'Luxury pens', 0, 'assets/images/canva.jpg'],
    ['Pens', 'Newly launched', 0, 'assets/images/canva.jpg'],

    // Category: Drinkware
    ['Drinkware', 'Bestsellers', 0, 'assets/images/mug.jpg'],
    ['Drinkware', 'Waterbottles', 0, 'assets/images/mug.jpg'],
    ['Drinkware', 'Sippers and Tumblers', 0, 'assets/images/mug.jpg'],
    ['Drinkware', 'Looking for more?', 0, 'assets/images/mug.jpg'],
    ['Drinkware', 'New in Drinkware', 0, 'assets/images/mug.jpg'],

    // Category: Custom Polo T - shirts
    ['Custom Polo T - shirts', 'Bestsellers', 0, 'assets/images/polo.jpg'],
    ['Custom Polo T - shirts', 'Brandes Polos', 0, 'assets/images/polo.jpg'],
    ['Custom Polo T - shirts', 'Multi-location Polos', 0, 'assets/images/mens_polo.jpg'],
    ['Custom Polo T - shirts', 'Puma & Adidas', 0, 'assets/images/mens_polo.jpg'],
    ['Custom Polo T - shirts', 'Sports Polos', 0, 'assets/images/tee.jpg'],
    ['Custom Polo T - shirts', 'More in Polos', 0, 'assets/images/polo.jpg'],

    // Category: Umbrellas and rainwear
    ['Umbrellas and rainwear', 'Bestsellers', 0, 'assets/images/foldable.jpg'],
    ['Umbrellas and rainwear', 'Umbrellas', 0, 'assets/images/foldable.jpg'],
    ['Umbrellas and rainwear', 'Raincoats and Rainwear', 0, 'assets/images/foldable.jpg'],
    ['Umbrellas and rainwear', 'Explore More', 0, 'assets/images/foldable.jpg'],
];

$subcategory_ids = []; // "Category Name::Subcategory Name" => id
foreach ($subcategories as $sub) {
    [$cat_name, $sub_name, $is_new, $sub_image] = $sub;
    if (!isset($category_ids[$cat_name])) {
        echo "Subcategory insert SKIPPED for '{$sub_name}' — unknown category '{$cat_name}'.\n";
        continue;
    }
    $cat_id = $category_ids[$cat_name];
    $stmt = $conn->prepare("INSERT INTO subcategories (category_id, name, is_new, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $cat_id, $sub_name, $is_new, $sub_image);
    if ($stmt->execute()) {
        $subcategory_ids["{$cat_name}::{$sub_name}"] = $conn->insert_id;
    } else {
        echo "Subcategory insert failed for '{$sub_name}' (category '{$cat_name}'): " . $stmt->error . "\n";
    }
    $stmt->close();
}
echo "Seeded subcategories: " . count($subcategory_ids) . "\n";

// Columns: category_name, subcategory_name, name, starting_price, tag, image_url, description, section
// IMPORTANT: index.php pulls the 5 homepage carousels via get_product_by_id(1) through
// get_product_by_id(30) in fixed blocks of 6 (Popular=1-6, Trending=7-12, Labels=13-18,
// Explore More=19-24, New Arrivals=25-30). This array is ordered to reproduce that exact
// grouping so ids 1-30 land on the same products as your current homepage. Any product
// NOT currently shown on the homepage is appended after id 30 (ids 31+) so it can't shift
// the carousels. If you add/remove products later, keep this ordering intact or update
// index.php to stop relying on hardcoded ids.
$products = [
    // ids 1-6 — "Our Most Popular Products"
    ['Visiting Cards', 'Visiting Cards', 'Standard Visiting Cards', 200.00, 'Starting at ₹200.00', 'assets/images/vc.jpg', 'High-quality professional visiting cards with crisp text and vivid colors.', 'shapes'],
    ['Visiting Cards', 'Visiting Cards', 'Rounded Corner Visiting Cards', 250.00, 'Starting at ₹250.00', 'assets/images/round.jpg', 'Smooth rounded corners that make your business card stand out from the crowd.', 'shapes'],
    ['Stationery, Letterheads & Notebooks', 'Explore more', 'Letterheads', 350.00, 'Starting at ₹350.00', 'assets/images/letter.jpg', 'Elegant letterheads on premium paper to give your correspondence a professional touch.', 'other'],
    ['Mugs, Albums & gifts', 'Bestsellers', 'Photo Albums', 599.00, 'Starting at ₹599.00', 'assets/images/photo.jpg', 'Preserve your beautiful memories in a premium bound photo album.', 'other'],
    ['Labels, Stickers & Packaging', 'Custom Stickers', 'Stickers', 150.00, 'Starting at ₹150.00', 'assets/images/sticker.jpg', 'Versatile multi-purpose stickers for products, branding, or events.', 'other'],
    ['Clothing Caps & Bags', 'Custom Polo T-shirts', "Men's Polo T-Shirts", 450.00, 'Starting at ₹450.00', 'assets/images/polo.jpg', 'Classic comfortable polo t-shirts customizable with your brand logo.', 'other'],

    // ids 7-12 — "Trending"
    ['Visiting Cards', 'Visiting Cards', 'Classic Visiting Cards', 220.00, 'Starting at ₹220.00', 'assets/images/vc.jpg', 'Traditional business cards on thick card stock. A timeless choice.', 'shapes'],
    ['Visiting Cards', 'Specialty Cards', 'Magnetic Visiting Cards', 399.00, 'Starting at ₹399.00', 'assets/images/magnetic.jpg', 'Keep your business details on the fridge or metal cabinets where it stays visible.', 'specialty'],
    ['Clothing Caps & Bags', 'Custom Activewear', 'Outerwear', 1490.00, 'Starting at ₹1,490.00', 'assets/images/outerwear.jpg', 'Premium warmth with custom branded jackets and hoodies for your team.', 'other'],
    ['Umbrellas and rainwear', 'Umbrellas', 'Large Foldable Umbrellas', 699.00, 'Starting at ₹699.00', 'assets/images/large.jpg', 'Large canopy umbrellas, custom printed with your brand logo.', 'other'],
    ['Umbrellas and rainwear', 'Umbrellas', 'Small Umbrellas', 499.00, 'Starting at ₹499.00', 'assets/images/foldable.jpg', 'Compact, easy to carry wind-resistant umbrellas for daily commuting.', 'other'],
    ['Clothing Caps & Bags', 'Custom Caps', 'Unisex Caps', 180.00, 'Starting at ₹180.00', 'assets/images/cap.jpg', 'Embroidered or printed classic caps to top off your company uniform.', 'other'],

    // ids 13-18 — "Labels, Stickers and Packaging"
    ['Labels, Stickers & Packaging', 'Custom Stickers', 'Sheet Stickers', 120.00, 'Starting at ₹120.00', 'assets/images/sticker.jpg', 'Easy-to-peel custom sticker sheets in square, circular, or rectangular cuts.', 'other'],
    ['Labels, Stickers & Packaging', 'Custom Labels', 'Premium Packaging Labels', 199.00, 'Starting at ₹199.00', 'assets/images/packing.jpg', 'Sleek custom labels to seal box packaging and elevate unboxing.', 'other'],
    ['Labels, Stickers & Packaging', 'Custom Stickers', 'Custom Shape Stickers', 220.00, 'Starting at ₹220.00', 'assets/images/shape.jpg', 'Die-cut stickers shaped precisely around your custom design outline.', 'other'],
    ['Labels, Stickers & Packaging', 'Custom Stickers', 'Roll Stickers', 299.00, 'Starting at ₹299.00', 'assets/images/roll.jpg', 'High-volume roll stickers perfect for rapid product packaging application.', 'other'],
    ['Labels, Stickers & Packaging', 'Custom Packaging', 'Packaging Tape', 150.00, 'Starting at ₹150.00', 'assets/images/tape.jpg', 'Heavy duty shipping tape printed with your company name or brand marks.', 'other'],
    ['Labels, Stickers & Packaging', 'Custom Labels', 'Transparent Labels', 180.00, 'Starting at ₹180.00', 'assets/images/transparent.jpg', 'Clear transparent labels that let your product show through seamlessly.', 'other'],

    // ids 19-24 — "Explore More"
    ['Clothing Caps & Bags', 'Custom Caps', 'Personalised Unisex Caps', 180.00, 'Starting at ₹180.00', 'assets/images/cap.jpg', 'Durable cotton caps with adjustable strap, printed or embroidered.', 'other'],
    ['Clothing Caps & Bags', 'Custom Bags', 'Premium Canvas Bags', 250.00, 'Starting at ₹250.00', 'assets/images/canva.jpg', 'Eco-friendly and durable heavy-duty canvas tote bags.', 'other'],
    ['Clothing Caps & Bags', 'Custom Bags', 'American Tourister Laptop Bags With Black Cover', 2490.00, 'Starting at ₹2,490.00', 'assets/images/american.jpg', 'Premium brand laptop bags custom detailed for employee onboarding.', 'other'],
    ['Umbrellas and rainwear', 'Umbrellas', 'Premium Umbrellas', 799.00, 'Starting at ₹799.00', 'assets/images/premium.jpg', 'Top-tier executive umbrellas featuring wood-handle designs.', 'other'],
    ['Clothing Caps & Bags', 'Custom Activewear', "Men's Outerwear", 1490.00, 'Starting at ₹1,490.00', 'assets/images/outerwear.jpg', 'Weatherproof windbreakers and jackets with high-fidelity branding.', 'other'],
    ['Signs, posters and marketing materials', 'Signs & Posters', 'Posters', 199.00, 'Starting at ₹199.00', 'assets/images/posters.jpg', 'Bright glossy posters for wall advertising, sales promos, or decor.', 'other'],

    // ids 25-30 — "New Arrivals"
    ['Clothing Caps & Bags', 'Custom Activewear', 'Chef Coats', 1250.00, 'Starting at ₹1,250.00', 'assets/images/chef.jpg', 'Professional-grade customizable chef coats with breathable fabric.', 'other'],
    ['Signs, posters and marketing materials', 'Marketing Materials', 'Acrylic Stand', 499.00, 'Starting at ₹499.00', 'assets/images/acrylic.jpg', 'Sleek clear acrylic table standees to display menu items or signages.', 'other'],
    ['Signs, posters and marketing materials', 'Marketing Materials', 'Collapsible Stand', 999.00, 'Starting at ₹999.00', 'assets/images/collapse.jpg', 'Portable X-frame stands perfect for trade shows, events, and setups.', 'other'],
    ['Signs, posters and marketing materials', 'Marketing Materials', 'Premium Matte Media Stand', 2999.00, 'Starting at ₹2,999.00', 'assets/images/matte.jpg', 'Luxury matte finish media backdrop banner stand for press events.', 'other'],
    ['Signs, posters and marketing materials', 'Marketing Materials', 'Banner Stand', 1899.00, 'Starting at ₹1,899.00', 'assets/images/banner.jpg', 'Heavy base roll-up banner stand for retail storefront branding.', 'other'],
    ['Stationery, Letterheads & Notebooks', 'Office Supplies', 'Multi-Purpose Red Desk Organizer', 399.00, 'Starting at ₹399.00', 'assets/images/multi.jpg', 'Elegant leatherette red desk organizer to clean up workspace clutter.', 'other'],

    // ids 31+ — NOT referenced by index.php's hardcoded homepage ids.
    // These fill out categories that previously had zero products (Stamps and Inks,
    // Pens, Drinkware) so their category pages work; they simply won't appear on the
    // homepage carousels unless you later update index.php to include them.
    ['Stamps and Inks', 'Self-Inking Stamps', 'Self-Inking Address Stamp', 349.00, 'Starting at ₹349.00', 'assets/images/multi.jpg', 'Reusable self-inking stamp for fast, consistent address or signature marking.', 'other'],
    ['Stamps and Inks', 'Custom Date & Time Stamps', 'Custom Date/Time Stamp', 499.00, 'Starting at ₹499.00', 'assets/images/multi.jpg', 'Adjustable date and time stamp for invoices, logs, and paperwork.', 'other'],
    ['Pens', 'Bestsellers', 'Classic Ballpoint Pen', 20.00, 'Starting at ₹20.00', 'assets/images/canva.jpg', 'Reliable everyday ballpoint pen, custom printed with your logo.', 'other'],
    ['Pens', 'Executive pens', 'Executive Metal Pen', 150.00, 'Starting at ₹150.00', 'assets/images/canva.jpg', 'Weighted metal-barrel pen with a laser-engraved finish.', 'other'],
    ['Pens', 'Luxury pens', 'Luxury Fountain Pen', 899.00, 'Starting at ₹899.00', 'assets/images/canva.jpg', 'Gift-boxed fountain pen with gold-tone trim.', 'other'],
    ['Drinkware', 'Bestsellers', 'Classic Steel Water Bottle', 349.00, 'Starting at ₹349.00', 'assets/images/mug.jpg', 'Insulated steel bottle that keeps drinks cold for hours.', 'other'],
    ['Drinkware', 'Waterbottles', 'Sports Water Bottle', 250.00, 'Starting at ₹250.00', 'assets/images/mug.jpg', 'Lightweight bottle with a leak-proof flip cap.', 'other'],
    ['Drinkware', 'Sippers and Tumblers', 'Travel Sipper Tumbler', 399.00, 'Starting at ₹399.00', 'assets/images/mug.jpg', 'Double-wall tumbler with a spill-resistant sipper lid.', 'other'],
];

$products_seeded = 0;
foreach ($products as $prod) {
    [$cat_name, $sub_name, $name, $price, $tag, $image, $description, $section] = $prod;
    $key = "{$cat_name}::{$sub_name}";
    if (!isset($subcategory_ids[$key])) {
        echo "Product insert SKIPPED for '{$name}' — unknown subcategory '{$sub_name}' under category '{$cat_name}'.\n";
        continue;
    }
    $sub_id = $subcategory_ids[$key];
    $stmt = $conn->prepare("INSERT INTO products (subcategory_id, name, starting_price, tag, image_url, description, section) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdssss", $sub_id, $name, $price, $tag, $image, $description, $section);
    if ($stmt->execute()) {
        $products_seeded++;
    } else {
        echo "Product insert FAILED for '{$name}': " . $stmt->error . "\n";
    }
    $stmt->close();
}
echo "Seeded products: {$products_seeded} of " . count($products) . "\n";

// --- DYNAMICALLY GENERATE DEFAULT PRODUCTS FOR EMPTY SUBCATEGORIES ---
echo "Checking for empty subcategories and generating default products...\n";
$res = $conn->query("SELECT id, name, category_id, image_url FROM subcategories");
$subcats = [];
while ($row = $res->fetch_assoc()) {
    $subcats[] = $row;
}

$empty_subcategories_filled = 0;
foreach ($subcats as $sub) {
    $sub_id = $sub['id'];
    $check = $conn->query("SELECT COUNT(*) as cnt FROM products WHERE subcategory_id = $sub_id");
    $row = $check->fetch_assoc();
    if ($row['cnt'] == 0) {
        $prod_name = "Custom " . $sub['name'];
        $starting_price = 199.00;
        $tag = "Starting at ₹199.00";
        
        $cat_id = $sub['category_id'];
        $image_url = !empty($sub['image_url']) ? $sub['image_url'] : 'assets/images/vc.jpg';
        
        $desc = "High-quality personalized " . strtolower($sub['name']) . " tailored for your professional needs.";
        $section = "other";
        
        $stmt = $conn->prepare("INSERT INTO products (subcategory_id, name, starting_price, tag, image_url, description, section) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdssss", $sub_id, $prod_name, $starting_price, $tag, $image_url, $desc, $section);
        $stmt->execute();
        $stmt->close();
        $empty_subcategories_filled++;
    }
}
echo "Dynamic seeding complete: Filled {$empty_subcategories_filled} empty subcategories.\n";

// Columns: type, title, subtitle, image_url, button1_text, button1_link, button2_text, button2_link, button3_text, button3_link
$banners = [
    ['hero_stacked', 'Visiting Cards', '100 visiting cards at Rs. 200', 'assets/images/hero.png', 'Shop Now', 'category.php?id=' . $category_ids['Visiting Cards'], null, null, null, null],
    ['hero_stacked', 'Look professional with custom rainwear', '1 Starting at Rs. 655', 'assets/images/banner2.png', 'Umbrellas', 'category.php?id=' . $category_ids['Umbrellas and rainwear'], 'Raincoats', 'category.php?id=' . $category_ids['Umbrellas and rainwear'], null, null],
    ['promo_mid', 'Preserve your cherished moments', '1 Starting at Rs. 650', 'assets/images/wedding1.jpg', 'Photo Albums', 'category.php?id=' . $category_ids['Mugs, Albums & gifts'], 'Mugs', 'category.php?id=' . $category_ids['Mugs, Albums & gifts'], 'Canvas Prints', 'category.php?id=' . $category_ids['Signs, posters and marketing materials']],
    ['promo_mid', 'Wear your brand with pride', '1 Starting at Rs. 320', 'assets/images/promo2.png', 'Custom Polo T-Shirts', 'category.php?id=' . $category_ids['Custom Polo T - shirts'], 'Custom T-shirts', 'category.php?id=' . $category_ids['Clothing Caps & Bags'], 'Caps', 'category.php?id=' . $category_ids['Clothing Caps & Bags']],
];

$banners_seeded = 0;
foreach ($banners as $ban) {
    $stmt = $conn->prepare("INSERT INTO banners (type, title, subtitle, image_url, button1_text, button1_link, button2_text, button2_link, button3_text, button3_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $ban[0], $ban[1], $ban[2], $ban[3], $ban[4], $ban[5], $ban[6], $ban[7], $ban[8], $ban[9]);
    if ($stmt->execute()) {
        $banners_seeded++;
    } else {
        echo "Banner insert failed: " . $stmt->error . "\n";
    }
    $stmt->close();
}
echo "Seeded promotional banners: {$banners_seeded}\n";

$default_user_email = 'customer@vistaprint.in';
$default_password_hash = password_hash('password123', PASSWORD_BCRYPT);
$default_user_name = 'Demo Customer';

$stmt = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $default_user_name, $default_user_email, $default_password_hash);
if ($stmt->execute()) {
    echo "Seeded default customer account: email='customer@vistaprint.in', password='password123'\n";
} else {
    echo "Default user insert failed: " . $stmt->error . "\n";
}
$stmt->close();

echo "Vistaprint database configuration seeding COMPLETE!\n";
$conn->close();
