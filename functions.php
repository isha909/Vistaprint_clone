<?php
require_once __DIR__ . '/config.php';

// Sanitize user inputs
function sanitize($data) {
    global $conn;
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Format prices
function format_price($price) {
    return CURRENCY_SYMBOL . number_format($price, 2);
}

// Check database availability
function is_db_available() {
    global $conn, $conn_error;
    return ($conn && !$conn->connect_error && !isset($conn_error));
}

// General function to execute prepared statements
function db_query($query, $params = [], $types = '') {
    global $conn;
    
    if (!is_db_available()) {
        return false;
    }
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return false;
    }
    
    if (!empty($params)) {
        if (empty($types)) {
            // Auto-detect types
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_double($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
        }
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        return false;
    }
    
    $result = $stmt->get_result();
    
    // For SELECT queries, return the result rows
    if ($result !== false) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }
    
    // For INSERT, UPDATE, DELETE queries, return affected rows or insert_id
    $affected_rows = $stmt->affected_rows;
    $insert_id = $stmt->insert_id;
    $stmt->close();
    
    if ($insert_id > 0) {
        return $insert_id;
    }
    return $affected_rows;
}

  // --- STATIC FALLBACK DATA ---
  $mock_categories = [
      ['id' => 1, 'name' => 'Visiting Cards', 'icon_class' => 'fa-address-card', 'template_type' => 'category_detail', 'description' => 'Design and print professional visiting cards with high-definition printing capturing rich colors on premium quality paper.', 'image_url' => 'assets/images/vc.jpg', 'status' => 1],
      ['id' => 2, 'name' => 'Stationery, Letterheads & Notebooks', 'icon_class' => 'fa-tshirt', 'template_type' => 'view_all', 'description' => 'Shop custom letterheads, notebooks, diaries, and office essentials to keep your business organized.', 'image_url' => 'assets/images/letter.jpg', 'status' => 1],
      ['id' => 3, 'name' => 'Stamps and Inks', 'icon_class' => 'fa-gift', 'template_type' => 'view_all', 'description' => 'Create custom self-inking and pre-inked stamps, dater stamps, and refilling inks for your daily tasks.', 'image_url' => 'assets/images/tape.jpg', 'status' => 1],
      ['id' => 4, 'name' => 'Signs, posters and marketing materials', 'icon_class' => 'fa-bullhorn', 'template_type' => 'view_all', 'description' => 'Spread the word with large-scale printed banners, signs, posters, and table coverings.', 'image_url' => 'assets/images/posters.jpg', 'status' => 1],
      ['id' => 5, 'name' => 'Labels, Stickers & Packaging', 'icon_class' => 'fa-tags', 'template_type' => 'view_all', 'description' => 'Custom sticker sheets, product labels, roll stickers, and printed shipping packaging.', 'image_url' => 'assets/images/sticker.jpg', 'status' => 1],
      ['id' => 6, 'name' => 'Clothing Caps & Bags', 'icon_class' => 'fa-box-open', 'template_type' => 'view_all', 'description' => 'Custom branded outerwear, caps, tote bags, and activewear for your workforce.', 'image_url' => 'assets/images/outerwear.jpg', 'status' => 1],
      ['id' => 7, 'name' => 'Mugs, Albums & gifts', 'icon_class' => 'fa-pen-nib', 'template_type' => 'view_all', 'description' => 'Unique personalized gifts including custom photo albums, mugs, magnets, and coasters.', 'image_url' => 'assets/images/mug.jpg', 'status' => 1],
      ['id' => 8, 'name' => 'Pens', 'icon_class' => 'fa-coffee', 'template_type' => 'category_detail', 'description' => 'Write in style with standard ballpoints, engraved executive metal pens, or luxury fountain pens.', 'image_url' => 'assets/images/canva.jpg', 'status' => 1],
      ['id' => 9, 'name' => 'Drinkware', 'icon_class' => 'fa-drinks', 'template_type' => 'category_detail', 'description' => 'Custom printed steel water bottles, travel tumblers, and sippers featuring your logo.', 'image_url' => 'assets/images/mug.jpg', 'status' => 1],
      ['id' => 10, 'name' => 'Custom Polo T - shirts', 'icon_class' => 'fa-shirts', 'template_type' => 'view_all', 'description' => 'Elevate your team appearance with high quality custom embroidered and printed polo shirts.', 'image_url' => 'assets/images/polo.jpg', 'status' => 1],
      ['id' => 11, 'name' => 'Umbrellas and rainwear', 'icon_class' => 'fa-umbrellas', 'template_type' => 'category_detail', 'description' => 'Protect your team from the elements with wind-resistant foldable umbrellas and custom raincoats.', 'image_url' => 'assets/images/collapse.jpg', 'status' => 1],
  ];

  $mock_subcategories = [
      ['id' => 1, 'category_id' => 1, 'name' => 'Visiting Cards', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 2, 'category_id' => 1, 'name' => 'Digital Visiting Cards', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 3, 'category_id' => 1, 'name' => 'Brilliant Finishes', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 4, 'category_id' => 1, 'name' => 'Standard Papers', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 5, 'category_id' => 1, 'name' => 'Reorder Visiting Cards', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 6, 'category_id' => 1, 'name' => 'Specialty Cards', 'image_url' => 'assets/images/magnetic.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 7, 'category_id' => 1, 'name' => 'Premium Papers', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 8, 'category_id' => 1, 'name' => 'Design and Logo', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 1, 'status' => 1],
      ['id' => 9, 'category_id' => 1, 'name' => 'Visiting Cards Holder', 'image_url' => 'assets/images/vc.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 10, 'category_id' => 2, 'name' => 'Custom Stationery', 'image_url' => 'assets/images/letter.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 11, 'category_id' => 2, 'name' => 'Office Supplies', 'image_url' => 'assets/images/office.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 12, 'category_id' => 2, 'name' => 'Custom Notebooks and Diaries', 'image_url' => 'assets/images/office.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 13, 'category_id' => 2, 'name' => 'Wedding Stationery', 'image_url' => 'assets/images/wedding1.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 14, 'category_id' => 2, 'name' => 'Invitations & Announcements', 'image_url' => 'assets/images/wedding1.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 15, 'category_id' => 2, 'name' => 'Custom Keychains', 'image_url' => 'assets/images/multi.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 16, 'category_id' => 2, 'name' => 'Files and Folders', 'image_url' => 'assets/images/office.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 17, 'category_id' => 2, 'name' => 'Explore more', 'image_url' => 'assets/images/letter.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 18, 'category_id' => 3, 'name' => 'Self-Inking Stamps', 'image_url' => 'assets/images/acrylic.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 19, 'category_id' => 3, 'name' => 'Pre-Inked Stamps', 'image_url' => 'assets/images/acrylic.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 20, 'category_id' => 3, 'name' => 'Custom Date & Time Stamps', 'image_url' => 'assets/images/multi.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 21, 'category_id' => 3, 'name' => 'Ink Pads & Refills', 'image_url' => 'assets/images/multi.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 22, 'category_id' => 4, 'name' => 'Signs & Posters', 'image_url' => 'assets/images/posters.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 23, 'category_id' => 4, 'name' => 'Marketing Materials', 'image_url' => 'assets/images/banner.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 24, 'category_id' => 4, 'name' => 'More in signs', 'image_url' => 'assets/images/posters.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 25, 'category_id' => 4, 'name' => 'More in marketing', 'image_url' => 'assets/images/collapse.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 26, 'category_id' => 4, 'name' => 'Tale Coverings', 'image_url' => 'assets/images/tape.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 27, 'category_id' => 4, 'name' => 'New Arrivals', 'image_url' => 'assets/images/acrylic.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 28, 'category_id' => 5, 'name' => 'Custom Packaging', 'image_url' => 'assets/images/packing.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 29, 'category_id' => 5, 'name' => 'Custom Stickers', 'image_url' => 'assets/images/round.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 30, 'category_id' => 5, 'name' => 'Custom Labels', 'image_url' => 'assets/images/sticker.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 31, 'category_id' => 5, 'name' => 'Tags', 'image_url' => 'assets/images/shape.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 32, 'category_id' => 5, 'name' => 'Packaging Boxes', 'image_url' => 'assets/images/packing.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 33, 'category_id' => 5, 'name' => 'Newly launched', 'image_url' => 'assets/images/roll.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 34, 'category_id' => 5, 'name' => 'Laptop Skin', 'image_url' => 'assets/images/transparent.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 35, 'category_id' => 6, 'name' => 'Custom T-shirts', 'image_url' => 'assets/images/tee.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 36, 'category_id' => 6, 'name' => 'Custom Polo T-shirts', 'image_url' => 'assets/images/polo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 37, 'category_id' => 6, 'name' => 'Custom Dress Shirts', 'image_url' => 'assets/images/shirt.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 38, 'category_id' => 6, 'name' => 'Custom Bags', 'image_url' => 'assets/images/bag.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 39, 'category_id' => 6, 'name' => 'Tote Bags', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 40, 'category_id' => 6, 'name' => 'Custom Caps', 'image_url' => 'assets/images/cap.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 41, 'category_id' => 6, 'name' => 'Custom Activewear', 'image_url' => 'assets/images/outerwear.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 42, 'category_id' => 7, 'name' => 'Bestsellers', 'image_url' => 'assets/images/photo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 43, 'category_id' => 7, 'name' => 'Mugs', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 44, 'category_id' => 7, 'name' => 'Gift Hampers', 'image_url' => 'assets/images/multi.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 45, 'category_id' => 7, 'name' => 'Custom Magnets', 'image_url' => 'assets/images/magnetic.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 46, 'category_id' => 7, 'name' => 'Coasters', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 47, 'category_id' => 7, 'name' => 'Custom Pens', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 48, 'category_id' => 7, 'name' => 'Custom Photo frame', 'image_url' => 'assets/images/photo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 49, 'category_id' => 7, 'name' => 'Custom Calenders', 'image_url' => 'assets/images/large.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 50, 'category_id' => 7, 'name' => 'Looking for more?', 'image_url' => 'assets/images/multi.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 51, 'category_id' => 7, 'name' => 'Corporate gifts', 'image_url' => 'assets/images/multi.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 52, 'category_id' => 8, 'name' => 'Bestsellers', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 53, 'category_id' => 8, 'name' => 'Value pens', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 54, 'category_id' => 8, 'name' => 'Executive pens', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 55, 'category_id' => 8, 'name' => 'Premium pens', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 56, 'category_id' => 8, 'name' => 'Luxury pens', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 57, 'category_id' => 8, 'name' => 'Newly launched', 'image_url' => 'assets/images/canva.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 58, 'category_id' => 9, 'name' => 'Bestsellers', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 59, 'category_id' => 9, 'name' => 'Waterbottles', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 60, 'category_id' => 9, 'name' => 'Sippers and Tumblers', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 61, 'category_id' => 9, 'name' => 'Looking for more?', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 62, 'category_id' => 9, 'name' => 'New in Drinkware', 'image_url' => 'assets/images/mug.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 63, 'category_id' => 10, 'name' => 'Bestsellers', 'image_url' => 'assets/images/polo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 64, 'category_id' => 10, 'name' => 'Brandes Polos', 'image_url' => 'assets/images/polo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 65, 'category_id' => 10, 'name' => 'Multi-location Polos', 'image_url' => 'assets/images/mens_polo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 66, 'category_id' => 10, 'name' => 'Puma & Adidas', 'image_url' => 'assets/images/mens_polo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 67, 'category_id' => 10, 'name' => 'Sports Polos', 'image_url' => 'assets/images/tee.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 68, 'category_id' => 10, 'name' => 'More in Polos', 'image_url' => 'assets/images/polo.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 69, 'category_id' => 11, 'name' => 'Bestsellers', 'image_url' => 'assets/images/foldable.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 70, 'category_id' => 11, 'name' => 'Umbrellas', 'image_url' => 'assets/images/foldable.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 71, 'category_id' => 11, 'name' => 'Raincoats and Rainwear', 'image_url' => 'assets/images/foldable.jpg', 'is_new' => 0, 'status' => 1],
      ['id' => 72, 'category_id' => 11, 'name' => 'Explore More', 'image_url' => 'assets/images/foldable.jpg', 'is_new' => 0, 'status' => 1],
  ];

  $mock_products = [
      ['id' => 1, 'subcategory_id' => 1, 'name' => 'Standard Visiting Cards', 'starting_price' => 200.0, 'tag' => 'Starting at ₹200.00', 'image_url' => 'assets/images/vc.jpg', 'description' => 'High-quality professional visiting cards with crisp text and vivid colors.', 'section' => 'shapes', 'status' => 1],
      ['id' => 2, 'subcategory_id' => 1, 'name' => 'Rounded Corner Visiting Cards', 'starting_price' => 250.0, 'tag' => 'Starting at ₹250.00', 'image_url' => 'assets/images/round.jpg', 'description' => 'Smooth rounded corners that make your business card stand out from the crowd.', 'section' => 'shapes', 'status' => 1],
      ['id' => 3, 'subcategory_id' => 17, 'name' => 'Letterheads', 'starting_price' => 350.0, 'tag' => 'Starting at ₹350.00', 'image_url' => 'assets/images/letter.jpg', 'description' => 'Elegant letterheads on premium paper to give your correspondence a professional touch.', 'section' => 'other', 'status' => 1],
      ['id' => 4, 'subcategory_id' => 42, 'name' => 'Photo Albums', 'starting_price' => 599.0, 'tag' => 'Starting at ₹599.00', 'image_url' => 'assets/images/photo.jpg', 'description' => 'Preserve your beautiful memories in a premium bound photo album.', 'section' => 'other', 'status' => 1],
      ['id' => 5, 'subcategory_id' => 29, 'name' => 'Stickers', 'starting_price' => 150.0, 'tag' => 'Starting at ₹150.00', 'image_url' => 'assets/images/sticker.jpg', 'description' => 'Versatile multi-purpose stickers for products, branding, or events.', 'section' => 'other', 'status' => 1],
      ['id' => 6, 'subcategory_id' => 1, 'name' => 'Classic Visiting Cards', 'starting_price' => 220.0, 'tag' => 'Starting at ₹220.00', 'image_url' => 'assets/images/vc.jpg', 'description' => 'Traditional business cards on thick card stock. A timeless choice.', 'section' => 'shapes', 'status' => 1],
      ['id' => 7, 'subcategory_id' => 6, 'name' => 'Magnetic Visiting Cards', 'starting_price' => 399.0, 'tag' => 'Starting at ₹399.00', 'image_url' => 'assets/images/magnetic.jpg', 'description' => 'Keep your business details on the fridge or metal cabinets where it stays visible.', 'section' => 'specialty', 'status' => 1],
      ['id' => 8, 'subcategory_id' => 41, 'name' => 'Outerwear', 'starting_price' => 1490.0, 'tag' => 'Starting at ₹1,490.00', 'image_url' => 'assets/images/outerwear.jpg', 'description' => 'Premium warmth with custom branded jackets and hoodies for your team.', 'section' => 'other', 'status' => 1],
      ['id' => 9, 'subcategory_id' => 70, 'name' => 'Large Foldable Umbrellas', 'starting_price' => 699.0, 'tag' => 'Starting at ₹699.00', 'image_url' => 'assets/images/large.jpg', 'description' => 'Large canopy umbrellas, custom printed with your brand logo.', 'section' => 'other', 'status' => 1],
      ['id' => 10, 'subcategory_id' => 70, 'name' => 'Small Umbrellas', 'starting_price' => 499.0, 'tag' => 'Starting at ₹499.00', 'image_url' => 'assets/images/foldable.jpg', 'description' => 'Compact, easy to carry wind-resistant umbrellas for daily commuting.', 'section' => 'other', 'status' => 1],
      ['id' => 11, 'subcategory_id' => 40, 'name' => 'Unisex Caps', 'starting_price' => 180.0, 'tag' => 'Starting at ₹180.00', 'image_url' => 'assets/images/cap.jpg', 'description' => 'Embroidered or printed classic caps to top off your company uniform.', 'section' => 'other', 'status' => 1],
      ['id' => 12, 'subcategory_id' => 29, 'name' => 'Sheet Stickers', 'starting_price' => 120.0, 'tag' => 'Starting at ₹120.00', 'image_url' => 'assets/images/sticker.jpg', 'description' => 'Easy-to-peel custom sticker sheets in square, circular, or rectangular cuts.', 'section' => 'other', 'status' => 1],
      ['id' => 13, 'subcategory_id' => 30, 'name' => 'Premium Packaging Labels', 'starting_price' => 199.0, 'tag' => 'Starting at ₹199.00', 'image_url' => 'assets/images/packing.jpg', 'description' => 'Sleek custom labels to seal box packaging and elevate unboxing.', 'section' => 'other', 'status' => 1],
      ['id' => 14, 'subcategory_id' => 29, 'name' => 'Custom Shape Stickers', 'starting_price' => 220.0, 'tag' => 'Starting at ₹220.00', 'image_url' => 'assets/images/shape.jpg', 'description' => 'Die-cut stickers shaped precisely around your custom design outline.', 'section' => 'other', 'status' => 1],
      ['id' => 15, 'subcategory_id' => 29, 'name' => 'Roll Stickers', 'starting_price' => 299.0, 'tag' => 'Starting at ₹299.00', 'image_url' => 'assets/images/roll.jpg', 'description' => 'High-volume roll stickers perfect for rapid product packaging application.', 'section' => 'other', 'status' => 1],
      ['id' => 16, 'subcategory_id' => 28, 'name' => 'Packaging Tape', 'starting_price' => 150.0, 'tag' => 'Starting at ₹150.00', 'image_url' => 'assets/images/tape.jpg', 'description' => 'Heavy duty shipping tape printed with your company name or brand marks.', 'section' => 'other', 'status' => 1],
      ['id' => 17, 'subcategory_id' => 30, 'name' => 'Transparent Labels', 'starting_price' => 180.0, 'tag' => 'Starting at ₹180.00', 'image_url' => 'assets/images/transparent.jpg', 'description' => 'Clear transparent labels that let your product show through seamlessly.', 'section' => 'other', 'status' => 1],
      ['id' => 18, 'subcategory_id' => 40, 'name' => 'Personalised Unisex Caps', 'starting_price' => 180.0, 'tag' => 'Starting at ₹180.00', 'image_url' => 'assets/images/cap.jpg', 'description' => 'Durable cotton caps with adjustable strap, printed or embroidered.', 'section' => 'other', 'status' => 1],
      ['id' => 19, 'subcategory_id' => 38, 'name' => 'Premium Canvas Bags', 'starting_price' => 250.0, 'tag' => 'Starting at ₹250.00', 'image_url' => 'assets/images/canva.jpg', 'description' => 'Eco-friendly and durable heavy-duty canvas tote bags.', 'section' => 'other', 'status' => 1],
      ['id' => 20, 'subcategory_id' => 38, 'name' => 'American Tourister Laptop Bags With Black Cover', 'starting_price' => 2490.0, 'tag' => 'Starting at ₹2,490.00', 'image_url' => 'assets/images/american.jpg', 'description' => 'Premium brand laptop bags custom detailed for employee onboarding.', 'section' => 'other', 'status' => 1],
      ['id' => 21, 'subcategory_id' => 70, 'name' => 'Premium Umbrellas', 'starting_price' => 799.0, 'tag' => 'Starting at ₹799.00', 'image_url' => 'assets/images/premium.jpg', 'description' => 'Top-tier executive umbrellas featuring wood-handle designs.', 'section' => 'other', 'status' => 1],
      ['id' => 22, 'subcategory_id' => 41, 'name' => 's Outerwear", 1490.00, ', 'starting_price' => 1.0, 'tag' => '490.00', 'image_url' => ', ', 'description' => ', ', 'section' => ', ', 'status' => 1],
      ['id' => 23, 'subcategory_id' => 22, 'name' => 'Posters', 'starting_price' => 199.0, 'tag' => 'Starting at ₹199.00', 'image_url' => 'assets/images/posters.jpg', 'description' => 'Bright glossy posters for wall advertising, sales promos, or decor.', 'section' => 'other', 'status' => 1],
      ['id' => 24, 'subcategory_id' => 41, 'name' => 'Chef Coats', 'starting_price' => 1250.0, 'tag' => 'Starting at ₹1,250.00', 'image_url' => 'assets/images/chef.jpg', 'description' => 'Professional-grade customizable chef coats with breathable fabric.', 'section' => 'other', 'status' => 1],
      ['id' => 25, 'subcategory_id' => 23, 'name' => 'Acrylic Stand', 'starting_price' => 499.0, 'tag' => 'Starting at ₹499.00', 'image_url' => 'assets/images/acrylic.jpg', 'description' => 'Sleek clear acrylic table standees to display menu items or signages.', 'section' => 'other', 'status' => 1],
      ['id' => 26, 'subcategory_id' => 23, 'name' => 'Collapsible Stand', 'starting_price' => 999.0, 'tag' => 'Starting at ₹999.00', 'image_url' => 'assets/images/collapse.jpg', 'description' => 'Portable X-frame stands perfect for trade shows, events, and setups.', 'section' => 'other', 'status' => 1],
      ['id' => 27, 'subcategory_id' => 23, 'name' => 'Premium Matte Media Stand', 'starting_price' => 2999.0, 'tag' => 'Starting at ₹2,999.00', 'image_url' => 'assets/images/matte.jpg', 'description' => 'Luxury matte finish media backdrop banner stand for press events.', 'section' => 'other', 'status' => 1],
      ['id' => 28, 'subcategory_id' => 23, 'name' => 'Banner Stand', 'starting_price' => 1899.0, 'tag' => 'Starting at ₹1,899.00', 'image_url' => 'assets/images/banner.jpg', 'description' => 'Heavy base roll-up banner stand for retail storefront branding.', 'section' => 'other', 'status' => 1],
      ['id' => 29, 'subcategory_id' => 11, 'name' => 'Multi-Purpose Red Desk Organizer', 'starting_price' => 399.0, 'tag' => 'Starting at ₹399.00', 'image_url' => 'assets/images/multi.jpg', 'description' => 'Elegant leatherette red desk organizer to clean up workspace clutter.', 'section' => 'other', 'status' => 1],
      ['id' => 30, 'subcategory_id' => 18, 'name' => 'Self-Inking Address Stamp', 'starting_price' => 349.0, 'tag' => 'Starting at ₹349.00', 'image_url' => 'assets/images/multi.jpg', 'description' => 'Reusable self-inking stamp for fast, consistent address or signature marking.', 'section' => 'other', 'status' => 1],
      ['id' => 31, 'subcategory_id' => 20, 'name' => 'Custom Date/Time Stamp', 'starting_price' => 499.0, 'tag' => 'Starting at ₹499.00', 'image_url' => 'assets/images/multi.jpg', 'description' => 'Adjustable date and time stamp for invoices, logs, and paperwork.', 'section' => 'other', 'status' => 1],
      ['id' => 32, 'subcategory_id' => 52, 'name' => 'Classic Ballpoint Pen', 'starting_price' => 20.0, 'tag' => 'Starting at ₹20.00', 'image_url' => 'assets/images/canva.jpg', 'description' => 'Reliable everyday ballpoint pen, custom printed with your logo.', 'section' => 'other', 'status' => 1],
      ['id' => 33, 'subcategory_id' => 54, 'name' => 'Executive Metal Pen', 'starting_price' => 150.0, 'tag' => 'Starting at ₹150.00', 'image_url' => 'assets/images/canva.jpg', 'description' => 'Weighted metal-barrel pen with a laser-engraved finish.', 'section' => 'other', 'status' => 1],
      ['id' => 34, 'subcategory_id' => 56, 'name' => 'Luxury Fountain Pen', 'starting_price' => 899.0, 'tag' => 'Starting at ₹899.00', 'image_url' => 'assets/images/canva.jpg', 'description' => 'Gift-boxed fountain pen with gold-tone trim.', 'section' => 'other', 'status' => 1],
      ['id' => 35, 'subcategory_id' => 58, 'name' => 'Classic Steel Water Bottle', 'starting_price' => 349.0, 'tag' => 'Starting at ₹349.00', 'image_url' => 'assets/images/mug.jpg', 'description' => 'Insulated steel bottle that keeps drinks cold for hours.', 'section' => 'other', 'status' => 1],
      ['id' => 36, 'subcategory_id' => 59, 'name' => 'Sports Water Bottle', 'starting_price' => 250.0, 'tag' => 'Starting at ₹250.00', 'image_url' => 'assets/images/mug.jpg', 'description' => 'Lightweight bottle with a leak-proof flip cap.', 'section' => 'other', 'status' => 1],
      ['id' => 37, 'subcategory_id' => 60, 'name' => 'Travel Sipper Tumbler', 'starting_price' => 399.0, 'tag' => 'Starting at ₹399.00', 'image_url' => 'assets/images/mug.jpg', 'description' => 'Double-wall tumbler with a spill-resistant sipper lid.', 'section' => 'other', 'status' => 1],
  ];

  $mock_banners = [
      [
          'id' => 1,
          'type' => 'hero_stacked',
          'title' => 'Visiting Cards',
          'subtitle' => '100 visiting cards at Rs. 200',
          'image_url' => 'assets/images/hero.png',
          'button1_text' => 'Shop Now',
          'button1_link' => 'category.php?id=1',
          'button2_text' => null,
          'button2_link' => null,
          'button3_text' => null,
          'button3_link' => null
      ],
      [
          'id' => 2,
          'type' => 'hero_stacked',
          'title' => 'Look professional with custom rainwear',
          'subtitle' => '1 Starting at Rs. 655',
          'image_url' => 'assets/images/banner2.png',
          'button1_text' => 'Umbrellas',
          'button1_link' => 'category.php?id=11',
          'button2_text' => 'Raincoats',
          'button2_link' => 'category.php?id=11',
          'button3_text' => null,
          'button3_link' => null
      ],
      [
          'id' => 3,
          'type' => 'promo_mid',
          'title' => 'Preserve your cherished moments',
          'subtitle' => '1 Starting at Rs. 650',
          'image_url' => 'assets/images/wedding1.jpg',
          'button1_text' => 'Photo Albums',
          'button1_link' => 'category.php?id=7',
          'button2_text' => 'Mugs',
          'button2_link' => 'category.php?id=7',
          'button3_text' => 'Canvas Prints',
          'button3_link' => 'category.php?id=4'
      ],
      [
          'id' => 4,
          'type' => 'promo_mid',
          'title' => 'Wear your brand with pride',
          'subtitle' => '1 Starting at Rs. 320',
          'image_url' => 'assets/images/promo2.png',
          'button1_text' => 'Custom Polo T-Shirts',
          'button1_link' => 'category.php?id=10',
          'button2_text' => 'Custom T-shirts',
          'button2_link' => 'category.php?id=6',
          'button3_text' => 'Caps',
          'button3_link' => 'category.php?id=6'
      ]
  ];
// Fetch all categories
function get_categories() {
    global $mock_categories;
    if (is_db_available()) {
        return db_query("SELECT * FROM categories WHERE status = 1 ORDER BY id ASC");
    }
    return $mock_categories;
}

// Fetch a single category by ID
function get_category_by_id($category_id) {
    global $mock_categories;
    if (is_db_available()) {
        $rows = db_query("SELECT * FROM categories WHERE id = ? AND status = 1 LIMIT 1", [$category_id], 'i');
        return !empty($rows) ? $rows[0] : null;
    }
    foreach ($mock_categories as $cat) {
        if ($cat['id'] == $category_id) {
            return $cat;
        }
    }
    return null;
}

// Curated "View All" mega menu — grouped links for the homepage-style flyout
function get_view_all_menu() {
    return [
        [
            'title' => 'Business Essentials',
            'links' => [
                ['label' => 'Visiting Cards', 'url' => 'category.php?id=1'],
                ['label' => 'Signs, Posters & Marketing Materials', 'url' => 'category.php?id=4'],
                ['label' => 'Stationery, Letterheads & Notebooks', 'url' => 'category.php?id=2'],
                ['label' => 'Labels, Stickers & Packaging', 'url' => 'category.php?id=5'],
                ['label' => 'Stamps & Ink', 'url' => 'category.php?id=3'],
                ['label' => 'Office Supplies', 'url' => 'category.php?id=2'],
            ]
        ],
        [
            'title' => 'Love your new look',
            'links' => [
                ['label' => 'Clothing, Caps & Bags', 'url' => 'category.php?id=6'],
                ['label' => 'Custom Polo T-Shirts', 'url' => 'category.php?id=10'],
                ['label' => 'Printed T-Shirts', 'url' => 'category.php?id=6'],
                ['label' => 'Custom Office Shirts', 'url' => 'category.php?id=6'],
                ['label' => 'Caps', 'url' => 'category.php?id=6'],
                ['label' => 'Bags', 'url' => 'category.php?id=6'],
                ['label' => 'Reflective Safety Vest', 'url' => 'category.php?id=6'],
            ]
        ],
        [
            'title' => 'Made by You',
            'links' => [
                ['label' => 'Photo Albums', 'url' => 'category.php?id=7'],
                ['label' => 'Personalised Pens', 'url' => 'category.php?id=8'],
                ['label' => 'Magnets', 'url' => 'category.php?id=7'],
                ['label' => 'Notebooks & Diaries', 'url' => 'category.php?id=2'],
                ['label' => 'Calendars', 'url' => 'category.php?id=7'],
            ]
        ],
        [
            'title' => 'Home & Gifts',
            'links' => [
                ['label' => 'Mugs, Albums & Gifts', 'url' => 'category.php?id=7'],
                ['label' => 'Drinkware', 'url' => 'category.php?id=9'],
                ['label' => 'Mugs', 'url' => 'category.php?id=7'],
                ['label' => 'Gift Hampers', 'url' => 'category.php?id=7'],
            ]
        ],
        [
            'title' => 'Design & Logo',
            'links' => [
                ['label' => 'Design Services', 'url' => '#'],
                ['label' => 'Logo Maker', 'url' => '#'],
            ]
        ],
        [
            'title' => 'Looking for more?',
            'links' => [
                ['label' => 'Technology', 'url' => '#'],
                ['label' => 'Invitations & Announcements', 'url' => 'category.php?id=2'],
                ['label' => 'Weddings', 'url' => '#'],
                ['label' => 'Passport Size Photographs', 'url' => '#'],
            ]
        ],
    ];
}

// Fetch subcategories by category ID
function get_subcategories($category_id) {
    global $mock_subcategories;
    if (is_db_available()) {
        return db_query("SELECT * FROM subcategories WHERE category_id = ? AND status = 1 ORDER BY id ASC", [$category_id], 'i');
    }
    $filtered = [];
    foreach ($mock_subcategories as $sub) {
        if ($sub['category_id'] == $category_id) {
            $filtered[] = $sub;
        }
    }
    return $filtered;
}

// Fetch a single subcategory by ID (with its parent category attached)
function get_subcategory_by_id($subcategory_id) {
    global $mock_subcategories, $mock_categories;
    if (is_db_available()) {
        $rows = db_query("SELECT * FROM subcategories WHERE id = ? AND status = 1", [$subcategory_id], 'i');
        return $rows ? $rows[0] : null;
    }
    foreach ($mock_subcategories as $sub) {
        if ($sub['id'] == $subcategory_id) {
            foreach ($mock_categories as $cat) {
                if ($cat['id'] == $sub['category_id']) {
                    $sub['category'] = $cat;
                    break;
                }
            }
            return $sub;
        }
    }
    return null;
}

// Fetch products by subcategory ID
function get_products_by_subcategory($subcategory_id) {
    global $mock_products;
    if (is_db_available()) {
        return db_query("SELECT * FROM products WHERE subcategory_id = ? AND status = 1 ORDER BY id ASC", [$subcategory_id], 'i');
    }
    $filtered = [];
    foreach ($mock_products as $prod) {
        if ($prod['subcategory_id'] == $subcategory_id) {
            $filtered[] = $prod;
        }
    }
    
    // If no mock products found, generate a dynamic fallback product so the subcategory page is never empty
    if (empty($filtered)) {
        $sub = get_subcategory_by_id($subcategory_id);
        if ($sub) {
            $cat_id = $sub['category_id'] ?? 1;
            $image_url = 'assets/images/vc.jpg';
            if ($cat_id == 2) $image_url = 'assets/images/letter.jpg';
            elseif ($cat_id == 3) $image_url = 'assets/images/acrylic.jpg';
            elseif ($cat_id == 4) $image_url = 'assets/images/posters.jpg';
            elseif ($cat_id == 5) $image_url = 'assets/images/sticker.jpg';
            elseif ($cat_id == 6 || $cat_id == 10) $image_url = 'assets/images/polo.jpg';
            elseif ($cat_id == 7) $image_url = 'assets/images/photo.jpg';
            elseif ($cat_id == 8) $image_url = 'assets/images/canva.jpg';
            elseif ($cat_id == 9) $image_url = 'assets/images/mug.jpg';
            elseif ($cat_id == 11) $image_url = 'assets/images/foldable.jpg';
            
            $filtered[] = [
                'id' => 1000 + $subcategory_id,
                'subcategory_id' => $subcategory_id,
                'name' => 'Custom ' . $sub['name'],
                'starting_price' => 199.00,
                'tag' => 'Starting at ₹199.00',
                'image_url' => $image_url,
                'description' => 'High-quality personalized ' . strtolower($sub['name']) . ' tailored for your professional needs.',
                'status' => 1
            ];
        }
    }
    return $filtered;
}

// Fetch products by category ID (joining with subcategories)
function get_products_by_category($category_id, $limit = null) {
    global $mock_products, $mock_subcategories;
    if (is_db_available()) {
        $sql = "SELECT p.* FROM products p 
                INNER JOIN subcategories s ON p.subcategory_id = s.id 
                WHERE s.category_id = ? AND p.status = 1 
                ORDER BY p.id ASC";
        if ($limit !== null) {
            $sql .= " LIMIT " . intval($limit);
        }
        return db_query($sql, [$category_id], 'i');
    }
    
    // Fallback logic
    $sub_ids = [];
    foreach ($mock_subcategories as $sub) {
        if ($sub['category_id'] == $category_id) {
            $sub_ids[] = $sub['id'];
        }
    }
    
    $filtered = [];
    foreach ($mock_products as $prod) {
        if (in_array($prod['subcategory_id'], $sub_ids)) {
            $filtered[] = $prod;
        }
    }
    
    if ($limit !== null) {
        return array_slice($filtered, 0, $limit);
    }
    return $filtered;
}

// Fetch a single product
function get_product_by_id($product_id) {
    global $mock_products, $mock_subcategories, $mock_categories;
    if (is_db_available()) {
        $rows = db_query("SELECT p.*, s.name as subcategory_name, s.category_id, c.name as category_name 
                          FROM products p
                          INNER JOIN subcategories s ON p.subcategory_id = s.id
                          INNER JOIN categories c ON s.category_id = c.id
                          WHERE p.id = ? LIMIT 1", [$product_id], 'i');
        return !empty($rows) ? $rows[0] : null;
    }
    
    // Fallback logic
    foreach ($mock_products as $prod) {
        if ($prod['id'] == $product_id) {
            $sub_name = '';
            $cat_id = 0;
            $cat_name = '';
            
            // find subcategory info
            foreach ($mock_subcategories as $sub) {
                if ($sub['id'] == $prod['subcategory_id']) {
                    $sub_name = $sub['name'];
                    $cat_id = $sub['category_id'];
                    break;
                }
            }
            
            // find category info
            foreach ($mock_categories as $cat) {
                if ($cat['id'] == $cat_id) {
                    $cat_name = $cat['name'];
                    break;
                }
            }
            
            return array_merge($prod, [
                'subcategory_name' => $sub_name,
                'category_id' => $cat_id,
                'category_name' => $cat_name
            ]);
        }
    }
    return null;
}

// Fetch banners by type
function get_banners($type = null) {
    global $mock_banners;
    if (is_db_available()) {
        if ($type) {
            return db_query("SELECT * FROM banners WHERE type = ? ORDER BY id ASC", [$type], 's');
        }
        return db_query("SELECT * FROM banners ORDER BY id ASC");
    }
    
    if ($type) {
        $filtered = [];
        foreach ($mock_banners as $ban) {
            if ($ban['type'] == $type) {
                $filtered[] = $ban;
            }
        }
        return $filtered;
    }
    return $mock_banners;
}

// Add item to Cart
function add_to_cart($product_id, $qty, $options = []) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $product = get_product_by_id($product_id);
    if (!$product) return false;
    
    $option_str = serialize($options);
    $cart_key = md5($product_id . '_' . $option_str);
    
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$cart_key] = [
            'id' => $product_id,
            'name' => $product['name'],
            'image_url' => $product['image_url'],
            'price' => $product['starting_price'],
            'qty' => $qty,
            'options' => $options
        ];
    }
    return true;
}

// Update Cart Quantity
function update_cart_qty($cart_key, $qty) {
    if (isset($_SESSION['cart'][$cart_key])) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$cart_key]);
        } else {
            $_SESSION['cart'][$cart_key]['qty'] = $qty;
        }
        return true;
    }
    return false;
}

// Remove from Cart
function remove_from_cart($cart_key) {
    if (isset($_SESSION['cart'][$cart_key])) {
        unset($_SESSION['cart'][$cart_key]);
        return true;
    }
    return false;
}

// Get Cart items
function get_cart_items() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

// Get Cart count
function get_cart_count() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['qty'];
        }
    }
    return $count;
}

// Get Cart total
function get_cart_total() {
    $total = 0.0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
    }
    return $total;
}

// Clear Cart
function clear_cart() {
    $_SESSION['cart'] = [];
}

// User helper: check if logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// User helper: get user details
function get_logged_in_user() {
    if (!is_logged_in()) return null;
    if (is_db_available()) {
        $rows = db_query("SELECT id, name, email FROM users WHERE id = ? LIMIT 1", [$_SESSION['user_id']], 'i');
        return !empty($rows) ? $rows[0] : null;
    }
    
    // Mock user session details
    return [
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_name'] ?? 'Demo Customer',
        'email' => $_SESSION['user_email'] ?? 'customer@vistaprint.in'
    ];
}

// Order helper: create order
function create_order($user_id, $total, $shipping_address, $cart_items) {
    if (is_db_available()) {
        // Dynamic order creation in DB
        $order_id = db_query("INSERT INTO orders (user_id, total_amount, shipping_address, payment_status) VALUES (?, ?, ?, 'Paid')", [$user_id, $total, $shipping_address], 'ids');
        if (!$order_id) return false;
        
        foreach ($cart_items as $item) {
            $opt_str = serialize($item['options']);
            db_query("INSERT INTO order_items (order_id, product_id, quantity, price, options) VALUES (?, ?, ?, ?, ?)", [$order_id, $item['id'], $item['qty'], $item['price'], $opt_str], 'iiids');
        }
        return $order_id;
    }
    
    // Mock successful order ID when DB is unavailable
    return rand(100000, 999999);
}

// Login verification
function login_user($email, $password) {
    if (is_db_available()) {
        $users = db_query("SELECT * FROM users WHERE email = ? LIMIT 1", [$email], 's');
        if (!empty($users)) {
            $user = $users[0];
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                return true;
            }
        }
        return false;
    }
    
    // Fallback: accept default user or any login for mock
    if ($email === 'customer@vistaprint.in' && $password === 'password123') {
        $_SESSION['user_id'] = 999;
        $_SESSION['user_name'] = 'Demo Customer';
        $_SESSION['user_email'] = 'customer@vistaprint.in';
        return true;
    }
    return false;
}

// Register user
function register_user($name, $email, $password) {
    if (is_db_available()) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $user_id = db_query("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)", [$name, $email, $password_hash], 'sss');
        if ($user_id) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            return true;
        }
        return false;
    }
    
    // Mock register registration
    $_SESSION['user_id'] = rand(1000, 9999);
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    return true;
}
?>
