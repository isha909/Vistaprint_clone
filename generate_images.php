<?php
header('Content-Type: text/plain');

echo "Generating mock SVG images for Vistaprint Clone...\n";

$img_dir = __DIR__ . '/assets/images';
if (!file_exists($img_dir)) {
    mkdir($img_dir, 0777, true);
    echo "Created directory assets/images\n";
}

// Function to write SVG files
function save_svg($filename, $content) {
    global $img_dir;
    $filepath = $img_dir . '/' . $filename;
    file_put_contents($filepath, $content);
    echo "Saved $filename\n";
}

// 1. Hero Banner 1: Visiting Cards (Abstract premium background with smiling elements / vector card)
save_svg('hero_visiting_cards.svg', '
<svg width="1200" height="380" viewBox="0 0 1200 380" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#eef2f6"/>
      <stop offset="100%" stop-color="#cfe3f6"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="380" fill="url(#g1)"/>
  <!-- Decorative background circles -->
  <circle cx="950" cy="190" r="160" fill="#0079C1" fill-opacity="0.08"/>
  <circle cx="850" cy="280" r="120" fill="#4BC3E6" fill-opacity="0.15"/>
  <!-- Graphic mockup representing business cards stack -->
  <g transform="translate(680, 80)">
    <!-- Bottom card shadow/stacked effect -->
    <rect x="25" y="45" width="320" height="190" rx="8" fill="#1e293b" fill-opacity="0.05"/>
    <rect x="20" y="40" width="320" height="190" rx="8" fill="#ffffff" stroke="#e2e8f0" stroke-width="2"/>
    <line x1="45" y1="75" x2="145" y2="75" stroke="#4BC3E6" stroke-width="8" stroke-linecap="round"/>
    <line x1="45" y1="105" x2="220" y2="105" stroke="#94a3b8" stroke-width="4" stroke-linecap="round"/>
    <line x1="45" y1="120" x2="180" y2="120" stroke="#cbd5e1" stroke-width="4" stroke-linecap="round"/>
    <!-- Top card overlapping -->
    <g transform="rotate(-6, 180, 100)">
      <rect x="10" y="10" width="320" height="190" rx="8" fill="#ffffff" stroke="#0079C1" stroke-width="3" style="filter: drop-shadow(0 10px 20px rgba(0,0,0,0.15));"/>
      <circle cx="50" cy="50" r="18" fill="#0079C1"/>
      <circle cx="50" cy="50" r="8" fill="#4BC3E6"/>
      <text x="80" y="55" font-family="Outfit, sans-serif" font-weight="700" font-size="18" fill="#1e293b">Vistaprint</text>
      <text x="80" y="70" font-family="Inter, sans-serif" font-size="10" fill="#64748b">PREMIUM PRINTING</text>
      
      <line x1="50" y1="110" x2="290" y2="110" stroke="#e2e8f0" stroke-width="2"/>
      
      <text x="50" y="140" font-family="Inter, sans-serif" font-weight="600" font-size="14" fill="#0f172a">John Doe</text>
      <text x="50" y="155" font-family="Inter, sans-serif" font-size="11" fill="#64748b">Creative Director</text>
      
      <text x="180" y="140" font-family="Inter, sans-serif" font-size="10" fill="#334155">P: +91 98765 43210</text>
      <text x="180" y="155" font-family="Inter, sans-serif" font-size="10" fill="#334155">E: hello@domain.com</text>
    </g>
  </g>
</svg>
');

// 2. Hero Banner 2: Custom Outerwear
save_svg('hero_outerwear.svg', '
<svg width="1200" height="380" viewBox="0 0 1200 380" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#1e293b"/>
      <stop offset="100%" stop-color="#0f172a"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="380" fill="url(#g2)"/>
  <circle cx="950" cy="190" r="160" fill="#ffffff" fill-opacity="0.03"/>
  
  <!-- Outerwear Jacket Graphic vector -->
  <g transform="translate(750, 70)" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none">
    <!-- Hanger -->
    <path d="M100,20 C100,5 90,0 80,10 C70,20 100,30 100,30 C100,30 130,20 120,10 C110,0 100,5 100,20 Z" stroke="#94a3b8" fill="none"/>
    
    <!-- Jacket Body -->
    <path d="M60,40 L140,40 L170,80 L200,160 L180,170 L150,110 L150,260 L50,260 L50,110 L20,170 L0,160 L30,80 Z" fill="#334155" fill-opacity="0.8"/>
    <!-- Collar & Zip line -->
    <path d="M80,40 L100,90 L120,40" stroke="#4BC3E6" stroke-width="4"/>
    <path d="M100,90 L100,260" stroke="#4BC3E6" stroke-width="4"/>
    <!-- Branded badge mockup -->
    <circle cx="75" cy="110" r="10" fill="#0079C1" stroke="none"/>
    <circle cx="75" cy="110" r="4" fill="#4BC3E6" stroke="none"/>
  </g>
</svg>
');

// 3. Mid Promo Banner 1: Banners & Posters
save_svg('promo_events.svg', '
<svg width="600" height="280" viewBox="0 0 600 280" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#fff5f5"/>
      <stop offset="100%" stop-color="#fed7d7"/>
    </linearGradient>
  </defs>
  <rect width="600" height="280" fill="url(#g3)"/>
  <circle cx="480" cy="140" r="100" fill="#f87171" fill-opacity="0.1"/>
  <!-- Standing roll-up banner icon -->
  <g transform="translate(420, 40)">
    <!-- Base -->
    <rect x="10" y="180" width="100" height="15" rx="2" fill="#475569"/>
    <!-- Pole -->
    <line x1="60" y1="20" x2="60" y2="180" stroke="#64748b" stroke-width="4"/>
    <!-- Banner material -->
    <rect x="25" y="20" width="70" height="150" rx="2" fill="#ffffff" stroke="#ef4444" stroke-width="3" style="filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));"/>
    <!-- Graphic layout on banner -->
    <circle cx="60" cy="50" r="15" fill="#f87171" fill-opacity="0.2"/>
    <line x1="40" y1="90" x2="80" y2="90" stroke="#f87171" stroke-width="6"/>
    <line x1="40" y1="110" x2="70" y2="110" stroke="#cbd5e1" stroke-width="4"/>
    <line x1="40" y1="125" x2="75" y2="125" stroke="#cbd5e1" stroke-width="4"/>
  </g>
</svg>
');

// 4. Mid Promo Banner 2: Branding Clothing
save_svg('promo_pride.svg', '
<svg width="600" height="280" viewBox="0 0 600 280" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#f0fdf4"/>
      <stop offset="100%" stop-color="#bbf7d0"/>
    </linearGradient>
  </defs>
  <rect width="600" height="280" fill="url(#g4)"/>
  <circle cx="480" cy="140" r="100" fill="#22c55e" fill-opacity="0.1"/>
  <!-- T-shirt icon -->
  <g transform="translate(420, 50)" fill="#16a34a" stroke="#ffffff" stroke-width="4" stroke-linejoin="round">
    <path d="M10,30 L35,10 L60,25 L60,40 L45,45 L45,90 L5,90 L5,45 L-10,40 L-10,25 L10,30 Z" style="filter: drop-shadow(0 5px 12px rgba(22,163,74,0.25));"/>
    <circle cx="25" cy="50" r="8" fill="#ffffff" stroke="none"/>
  </g>
</svg>
');

// General Product SVG Generator Helper
function generate_product_svg($filename, $title, $bg_color, $icon_path, $icon_fill = '#0079C1') {
    $svg = '
<svg width="250" height="220" viewBox="0 0 250 220" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect width="250" height="220" fill="' . $bg_color . '"/>
  <g transform="translate(125, 100)">
    ' . $icon_path . '
  </g>
  <text x="125" y="190" text-anchor="middle" font-family="Outfit, sans-serif" font-weight="600" font-size="13" fill="#1e293b">' . htmlspecialchars($title) . '</text>
</svg>';
    save_svg($filename, $svg);
}

// 5. Build various product icon paths
$card_icon = '<rect x="-40" y="-25" width="80" height="50" rx="4" fill="#ffffff" stroke="#0079C1" stroke-width="3" style="filter:drop-shadow(0 4px 6px rgba(0,0,0,0.1));"/><line x1="-30" y1="-10" x2="10" y2="-10" stroke="#0079C1" stroke-width="4"/><line x1="-30" y1="5" x2="30" y2="5" stroke="#cbd5e1" stroke-width="3"/><line x1="-30" y1="15" x2="20" y2="15" stroke="#cbd5e1" stroke-width="3"/>';
$card_rounded_icon = '<rect x="-40" y="-25" width="80" height="50" rx="12" fill="#ffffff" stroke="#4BC3E6" stroke-width="3" style="filter:drop-shadow(0 4px 6px rgba(0,0,0,0.1));"/><circle cx="-20" cy="-5" r="8" fill="#4BC3E6"/><line x1="0" y1="-8" x2="30" y2="-8" stroke="#4BC3E6" stroke-width="3"/><line x1="0" y1="0" x2="20" y2="0" stroke="#cbd5e1" stroke-width="3"/>';
$tshirt_icon = '<path d="-25,-25 L-10,-40 L10,-40 L25,-25 L25,-10 L15,-12 L15,30 L-15,30 L-15,-12 L-25,-10 Z" fill="#0079C1" stroke="#ffffff" stroke-width="2"/><circle cx="0" cy="-5" r="6" fill="#4BC3E6"/>';
$shirt_icon = '<path d="-25,-25 L-10,-40 L10,-40 L25,-25 L25,-10 L15,-12 L15,30 L-15,30 L-15,-12 L-25,-10 Z" fill="#3b82f6" stroke="#ffffff" stroke-width="2"/><line x1="0" y1="-25" x2="0" y2="30" stroke="#ffffff" stroke-width="2"/>';
$cap_icon = '<path d="-20,10 C-20,-15 20,-15 20,10 L-20,10 Z" fill="#0f172a"/><path d="-20,10 C-30,10 -35,20 -10,20 L15,20 C10,15 0,10 -20,10 Z" fill="#475569"/>';
$bag_icon = '<rect x="-25" y="-15" width="50" height="40" rx="2" fill="#b45309" stroke="#ffffff" stroke-width="2"/><path d="-15,-15 C-15,-28 15,-28 15,-15" fill="none" stroke="#b45309" stroke-width="3"/>';
$stationery_icon = '<rect x="-20" y="-30" width="40" height="60" rx="3" fill="#ffffff" stroke="#64748b" stroke-width="2"/><line x1="-12" y1="-15" x2="12" y2="-15" stroke="#cbd5e1" stroke-width="2"/><line x1="-12" y1="-5" x2="5" y2="-5" stroke="#64748b" stroke-width="2"/><line x1="-12" y1="5" x2="12" y2="5" stroke="#cbd5e1" stroke-width="2"/>';
$drinkware_icon = '<path d="-15,-20 L15,-20 L12,25 C12,30 -12,30 -12,25 Z" fill="#0891b2" stroke="#ffffff" stroke-width="2"/><path d="M12,-10 C20,-10 20,10 12,10" fill="none" stroke="#0891b2" stroke-width="3"/>';
$album_icon = '<rect x="-30" y="-20" width="60" height="40" rx="2" fill="#ffffff" stroke="#db2777" stroke-width="2"/><line x1="0" y1="-20" x2="0" y2="20" stroke="#db2777" stroke-width="2"/><circle cx="-15" cy="0" r="6" fill="#fbcfe8"/>';
$umbrella_icon = '<path d="-30,5 C-30,-25 30,-25 30,5 Z" fill="#0284c7"/><line x1="0" y1="5" x2="0" y2="25" stroke="#475569" stroke-width="3"/><path d="M0,25 C0,29 5,29 5,25" fill="none" stroke="#475569" stroke-width="3"/>';
$sticker_icon = '<circle cx="0" cy="-5" r="25" fill="#facc15" stroke="#ffffff" stroke-width="2"/><text x="0" y="0" text-anchor="middle" font-size="12" font-weight="bold" fill="#000" font-family="sans-serif">SALE</text>';
$poster_icon = '<rect x="-25" y="-35" width="50" height="70" fill="#ffffff" stroke="#f97316" stroke-width="2"/><circle cx="0" cy="-10" r="12" fill="#ffedd5"/><line x1="-15" y1="12" x2="15" y2="12" stroke="#cbd5e1" stroke-width="3"/><line x1="-15" y1="20" x2="5" y2="20" stroke="#cbd5e1" stroke-width="3"/>';
$stand_icon = '<line x1="-20" y1="35" x2="20" y2="35" stroke="#334155" stroke-width="5"/><line x1="0" y1="-30" x2="0" y2="35" stroke="#475569" stroke-width="3"/><rect x="-18" y="-30" width="36" height="55" fill="#ffffff" stroke="#0079C1" stroke-width="2"/>';

// Standard Visiting Cards
generate_product_svg('standard_visiting_cards.svg', 'Standard Visiting Cards', '#f0f9ff', $card_icon);
// Rounded Corner Cards
generate_product_svg('rounded_corner_visiting_cards.svg', 'Rounded Corner Cards', '#ecfeff', $card_rounded_icon);
// Letterheads
generate_product_svg('letterheads.svg', 'Corporate Letterheads', '#f8fafc', $stationery_icon);
// Photo Albums
generate_product_svg('photo_albums.svg', 'Photo Albums', '#fdf2f8', $album_icon);
// Stickers
generate_product_svg('stickers.svg', 'Stickers & Labels', '#fefcbf', $sticker_icon);
// Men's Polo
generate_product_svg('mens_polo_tshirts.svg', 'Men\'s Polo T-Shirts', '#f0f9ff', $tshirt_icon);

// Trending
generate_product_svg('classic_visiting_cards.svg', 'Classic Visiting Cards', '#f0fafb', $card_icon);
generate_product_svg('magnetic_visiting_cards.svg', 'Magnetic Visiting Cards', '#f5f3ff', $card_rounded_icon);
generate_product_svg('outerwear.svg', 'Outerwear & Jackets', '#f1f5f9', $tshirt_icon);
generate_product_svg('large_foldable_umbrellas.svg', 'Foldable Umbrellas', '#f0f9ff', $umbrella_icon);
generate_product_svg('small_umbrellas.svg', 'Compact Umbrellas', '#f0f9ff', $umbrella_icon);
generate_product_svg('unisex_caps.svg', 'Unisex Caps', '#fafaf9', $cap_icon);

// Labels
generate_product_svg('sheet_stickers.svg', 'Sheet Stickers', '#fefce8', $sticker_icon);
generate_product_svg('premium_packaging_labels.svg', 'Packaging Labels', '#fffbeb', $sticker_icon);
generate_product_svg('custom_shape_stickers.svg', 'Custom Shape Stickers', '#fef9c3', $sticker_icon);
generate_product_svg('roll_stickers.svg', 'Roll Stickers', '#fefcbf', $sticker_icon);
generate_product_svg('packaging_tape.svg', 'Packaging Tape', '#fafaf9', '<rect x="-30" y="-15" width="60" height="30" rx="15" fill="#f59e0b"/>');
generate_product_svg('transparent_labels.svg', 'Transparent Labels', '#ffffff', $sticker_icon);

// Explore More
generate_product_svg('personalised_unisex_caps.svg', 'Personalised Caps', '#f5f5f4', $cap_icon);
generate_product_svg('premium_canvas_bags.svg', 'Premium Canvas Bags', '#fef3c7', $bag_icon);
generate_product_svg('american_tourister_laptop_bags.svg', 'Laptop Backpacks', '#f1f5f9', $bag_icon);
generate_product_svg('premium_umbrellas.svg', 'Premium Umbrellas', '#f8fafc', $umbrella_icon);
generate_product_svg('mens_outerwear.svg', 'Men\'s Outerwear', '#f8fafc', $tshirt_icon);
generate_product_svg('posters.svg', 'Posters & Banners', '#fff7ed', $poster_icon);

// New Arrivals
generate_product_svg('chef_coats.svg', 'Chef Coats', '#ffffff', $tshirt_icon);
generate_product_svg('acrylic_stand.svg', 'Acrylic Stands', '#f8fafc', $stand_icon);
generate_product_svg('collapsible_stand.svg', 'Collapsible Stands', '#f8fafc', $stand_icon);
generate_product_svg('premium_matte_media_stand.svg', 'Matte Media Stands', '#f8fafc', $stand_icon);
generate_product_svg('banner_stand.svg', 'Banner Stands', '#f8fafc', $stand_icon);
generate_product_svg('red_desk_organizer.svg', 'Desk Organizers', '#fff5f5', '<rect x="-25" y="-20" width="50" height="40" rx="4" fill="#dc2626"/><rect x="-15" y="-10" width="30" height="20" rx="2" fill="#ffffff"/>');

echo "Finished generating all SVG mock images successfully!\n";
?>
