<?php
$page_title = "View All Categories";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';

// Sidebar: trending categories + grouped sub-links (reuses the same curated menu as the nav)
$view_all_menu = [
    [
        'title' => 'Visiting Cards',
        'links' => [
            ['label' => 'Brilliant Finishes', 'url' => 'subcategory.php?id=36'],
            ['label' => 'Standard Papers', 'url' => 'subcategory.php?id=37'],
            ['label' => 'Speciality Cards', 'url' => 'subcategory.php?id=38'],
            ['label' => 'Premium Papers', 'url' => 'subcategory.php?id=39'],
        ]
    ],
    [
        'title' => 'Business Essentials',
        'links' => [
            ['label' => 'Signs, Posters & Marketing Materials', 'url' => 'category.php?id=4'],
            ['label' => 'Stationery, Letterheads & Notebooks', 'url' => 'category.php?id=2'],
            ['label' => 'Labels, Stickers & Packaging', 'url' => 'category.php?id=5'],
            ['label' => 'Stamps & Ink', 'url' => 'category.php?id=3'],
            ['label' => 'Office Supplies', 'url' => 'category.php?id=2'],
            ['label' => 'Visiting card holders', 'url' => 'subcategory.php?id=41'],
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
];

$trending_categories = [
    ['label' => 'Visiting Cards', 'link' => 'category.php?id=1'],
    ['label' => 'Clothing, Caps & Bags', 'link' => 'category.php?id=6'],
    ['label' => 'Umbrellas and Raincoats', 'link' => 'category.php?id=11'],
    ['label' => 'Signs, Posters & Marketing Materials', 'link' => 'category.php?id=4'],
    ['label' => 'Labels, Stickers & Packaging', 'link' => 'category.php?id=5'],
    ['label' => 'Stamps and Ink', 'link' => 'category.php?id=3'],
];

// Sections: each tile links into a real category/subcategory page
$sections = [
    [
        'title' => 'Business Essentials',
        'tiles' => [
            ['label' => 'Visiting Cards', 'link' => 'category.php?id=1', 'image' => 'assets/images/vc.jpg'],
            ['label' => 'Stationery', 'link' => 'category.php?id=2', 'image' => 'assets/images/letter.jpg'],
            ['label' => 'Custom Signs, Banners & Posters', 'link' => 'category.php?id=4', 'image' => 'assets/images/posters.jpg'],
            ['label' => 'Custom Clothing, Caps & Bags', 'link' => 'category.php?id=6', 'image' => 'assets/images/outerwear.jpg'],
            ['label' => 'Labels, Stickers & Packaging', 'link' => 'category.php?id=5', 'image' => 'assets/images/sticker.jpg'],
            ['label' => 'Custom Stamps & Ink', 'link' => 'category.php?id=3', 'image' => 'assets/images/tape.jpg'],
        ],
    ],
    [
        'title' => 'Love your new look',
        'tiles' => [
            ['label' => 'Custom Polo T-shirts', 'link' => 'category.php?id=10', 'image' => 'assets/images/polo.jpg'],
            ['label' => 'Custom T-shirts', 'link' => 'category.php?id=6', 'image' => 'assets/images/tee.jpg'],
            ['label' => 'Custom Dress Shirts', 'link' => 'category.php?id=6', 'image' => 'assets/images/shirt.jpg'],
            ['label' => 'Custom Caps', 'link' => 'category.php?id=6', 'image' => 'assets/images/cap.jpg'],
            ['label' => 'Bags', 'link' => 'category.php?id=6', 'image' => 'assets/images/bag.jpg'],
            ['label' => 'Tote Bags', 'link' => 'category.php?id=6', 'image' => 'assets/images/bag.jpg'],
            ['label' => 'Raincoats', 'link' => 'category.php?id=11', 'image' => 'assets/images/outerwear.jpg'],
            ['label' => 'Umbrellas', 'link' => 'category.php?id=11', 'image' => 'assets/images/collapse.jpg'],
            ['label' => 'Custom Winter Wear', 'link' => 'category.php?id=6', 'image' => 'assets/images/outerwear.jpg'],
            ['label' => 'Custom Aprons', 'link' => 'category.php?id=6', 'image' => 'assets/images/chef.jpg'],
            ['label' => 'Lab Coats', 'link' => 'category.php?id=6', 'image' => 'assets/images/office.jpg'],
            ['label' => 'Bottom Wear', 'link' => 'category.php?id=6', 'image' => 'assets/images/american.jpg'],
        ],
    ],
    [
        'title' => 'Made by You',
        'tiles' => [
            ['label' => 'Photo Albums', 'link' => 'category.php?id=7', 'image' => 'assets/images/photo.jpg'],
            ['label' => 'Personalised Pens', 'link' => 'category.php?id=8', 'image' => 'assets/images/canva.jpg'],
            ['label' => 'Notebooks', 'link' => 'category.php?id=2', 'image' => 'assets/images/office.jpg'],
            ['label' => 'Diary', 'link' => 'category.php?id=2', 'image' => 'assets/images/letter.jpg'],
            ['label' => 'Calendars', 'link' => 'category.php?id=7', 'image' => 'assets/images/large.jpg'],
            ['label' => 'Magnets', 'link' => 'category.php?id=7', 'image' => 'assets/images/magnetic.jpg'],
        ],
    ],
    [
        'title' => 'For your packaging needs',
        'tiles' => [
            ['label' => 'Custom Labels', 'link' => 'category.php?id=5', 'image' => 'assets/images/sticker.jpg'],
            ['label' => 'Custom Stickers', 'link' => 'category.php?id=5', 'image' => 'assets/images/round.jpg'],
            ['label' => 'Packaging Materials', 'link' => 'category.php?id=5', 'image' => 'assets/images/packing.jpg'],
        ],
    ],
    [
        'title' => 'Home & Gifts',
        'tiles' => [
            ['label' => 'Photo Gifts', 'link' => 'category.php?id=7', 'image' => 'assets/images/photo.jpg'],
            ['label' => 'Custom Drinkware', 'link' => 'category.php?id=9', 'image' => 'assets/images/mug.jpg'],
            ['label' => 'Mugs', 'link' => 'category.php?id=7', 'image' => 'assets/images/mug.jpg'],
            ['label' => 'Gift Hampers', 'link' => 'category.php?id=7', 'image' => 'assets/images/multi.jpg'],
            ['label' => 'Wedding Stationery', 'link' => 'category.php?id=2', 'image' => 'assets/images/wedding1.jpg'],
            ['label' => 'Invitations and Announcements', 'link' => 'category.php?id=2', 'image' => 'assets/images/wedding1.jpg'],
        ],
    ],
    [
        'title' => 'Design & Logo',
        'tiles' => [
            ['label' => 'Design Services', 'link' => '#', 'image' => 'assets/images/canva.jpg'],
            ['label' => 'Logo Maker', 'link' => '#', 'image' => 'assets/images/banner.jpg'],
            ['label' => 'QR Code Generator', 'link' => '#', 'image' => 'assets/images/roll.jpg'],
            ['label' => 'Ideas and Advice', 'link' => '#', 'image' => 'assets/images/office.jpg'],
        ],
    ],
];
?>

<div class="container-fluid px-4 py-4">
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">View all</li>
        </ol>
    </nav>

    <!-- Decorative teal gradient behind the hero only -->
    <div class="view-all-hero-bg-wrap">
        <div class="view-all-gradient-bg"></div>

        <div class="row g-4 position-relative view-all-content-row">
            <!-- Unified sidebar: Trending Categories + all groups -->
            <aside class="col-12 col-lg-3 col-xl-3">
                <div class="view-all-sidebar-unified rounded-4 p-4">
                    <h6 class="fw-bold text-dark mb-3">Trending Categories</h6>
                    <ul class="list-unstyled va-sidebar-list mb-4">
                        <?php foreach ($trending_categories as $tc): ?>
                            <li><a href="<?php echo htmlspecialchars($tc['link']); ?>"><?php echo htmlspecialchars($tc['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php foreach ($view_all_menu as $group): ?>
                        <?php if ($group['title'] === 'Looking for more?') continue; ?>
                        <h6 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($group['title']); ?></h6>
                        <ul class="list-unstyled va-sidebar-list mb-4">
                            <?php foreach (array_slice($group['links'], 0, 4) as $link): ?>
                                <li><a href="<?php echo htmlspecialchars($link['url']); ?>"><?php echo htmlspecialchars($link['label']); ?></a></li>
                            <?php endforeach; ?>
                            <li><a href="category.php" class="fw-semibold">View all in <?php echo htmlspecialchars($group['title']); ?></a></li>
                        </ul>
                    <?php endforeach; ?>
                </div>
            </aside>

            <!-- Main content: hero + product sections -->
            <div class="col-12 col-lg-9 col-xl-9">
                <div class="view-all-hero align-items-stretch mb-5">
                    <div class="row g-0 w-100 align-items-stretch">
                        <div class="col-12 col-md-7 p-4 p-lg-5">
                            <h1 class="fw-bold text-white mb-2" style="font-size: 32px;">View all categories</h1>
                            <p class="text-white mb-0">Find high-quality customised products you need.</p>
                        </div>
                        <div class="col-12 col-md-5 view-all-hero-img-wrap">
                            <img src="assets/images/vc.jpg" alt="Customised products" class="view-all-hero-img">
                        </div>
                    </div>
                </div>

                <?php foreach ($sections as $section): ?>
                    <section class="mb-5">
                        <h3 class="fw-bold font-outfit text-dark mb-4"><?php echo htmlspecialchars($section['title']); ?></h3>
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                            <?php foreach ($section['tiles'] as $tile): ?>
                                <div class="col">
                                    <a href="<?php echo htmlspecialchars($tile['link']); ?>" class="va-tile text-decoration-none">
                                        <div class="va-tile-img-wrap">
                                            <img src="<?php echo htmlspecialchars($tile['image']); ?>" alt="<?php echo htmlspecialchars($tile['label']); ?>">
                                        </div>
                                        <div class="va-tile-label"><?php echo htmlspecialchars($tile['label']); ?></div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php
$hide_newsletter = true;
require_once __DIR__ . '/footer.php';
