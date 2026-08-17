<?php
// Prevent direct access
if (!defined('APP_NAME')) {
    exit;
}

$trending_categories = [
    ['label' => 'Visiting Cards', 'link' => 'category.php?id=1'],
    ['label' => 'Clothing, Caps & Bags', 'link' => 'category.php?id=6'],
    ['label' => 'Umbrellas and Raincoats', 'link' => 'category.php?id=11'],
    ['label' => 'Signs, Posters & Marketing Materials', 'link' => 'category.php?id=4'],
    ['label' => 'Labels, Stickers & Packaging', 'link' => 'category.php?id=5'],
    ['label' => 'Stamps and Ink', 'link' => 'category.php?id=3'],
];

if (!isset($view_all_menu)) {
    $view_all_menu = get_view_all_menu();
}
?>

<div class="container-fluid px-4 py-4">
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?php echo htmlspecialchars($category['name']); ?></li>
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
                            <h1 class="fw-bold text-white mb-2" style="font-size: 32px;"><?php echo htmlspecialchars($category['name']); ?></h1>
                            <p class="text-white mb-0"><?php echo !empty($category['description']) ? htmlspecialchars($category['description']) : "Find high-quality customised " . strtolower(htmlspecialchars($category['name'])) . " products you need."; ?></p>
                        </div>
                        <div class="col-12 col-md-5 view-all-hero-img-wrap">
                            <img src="<?php echo !empty($category['image_url']) ? htmlspecialchars($category['image_url']) : 'assets/images/vc.jpg'; ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="view-all-hero-img">
                        </div>
                    </div>
                </div>

                <section class="mb-5">
                    <h3 class="fw-bold font-outfit text-dark mb-4">Shop by category</h3>
                    
                    <?php if (empty($subcategories)): ?>
                        <div class="text-center py-5 border rounded bg-light">
                            <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                            <h4 class="fw-bold text-dark">No Subcategories Found</h4>
                            <p class="text-secondary mb-4">There's nothing to browse here yet.</p>
                            <a href="index.php" class="btn btn-vp-dark">Back to Home</a>
                        </div>
                    <?php else: ?>
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                            <?php foreach ($subcategories as $sub): ?>
                                <?php 
                                // Fetch image dynamically from subcategory column
                                $tile_img = !empty($sub['image_url']) ? $sub['image_url'] : 'assets/images/vc.jpg'; 
                                ?>
                                <div class="col">
                                    <a href="subcategory.php?id=<?php echo $sub['id']; ?>" class="va-tile text-decoration-none">
                                        <div class="va-tile-img-wrap">
                                            <img src="<?php echo htmlspecialchars($tile_img); ?>" alt="<?php echo htmlspecialchars($sub['name']); ?>">
                                        </div>
                                        <div class="va-tile-label"><?php echo htmlspecialchars($sub['name']); ?></div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</div>
