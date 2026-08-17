<?php
// Prevent direct access
if (!defined('APP_NAME')) {
    exit;
}
?>

<?php if ($category): ?>
<!-- Category hero banner -->
<?php 
$hero_bg = !empty($category['image_url']) ? $category['image_url'] : ''; 
$hero_style = $hero_bg ? "style=\"background-image: linear-gradient(rgba(44, 53, 72, 0.5), rgba(44, 53, 72, 0.5)), url('{$hero_bg}'); background-size: cover; background-position: center;\"" : '';
?>
<div class="vp-category-hero" <?php echo $hero_style; ?>>
    <div class="container px-4 py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="vp-hero-title"><?php echo htmlspecialchars($category['name']); ?></h1>
                <p class="vp-hero-subtitle"><?php echo !empty($category['description']) ? htmlspecialchars($category['description']) : "Design and print professional " . strtolower(htmlspecialchars($category['name'])) . " with high-definition printing capturing rich colors on premium quality paper."; ?></p>
                <div class="d-flex gap-2 flex-wrap mt-4">
                    <a href="#" class="btn btn-light fw-semibold px-4">Browse templates</a>
                    <a href="#" class="btn btn-light fw-semibold px-4">Upload design</a>
                    <a href="#" class="btn btn-outline-light fw-semibold px-4">Reorder</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container py-5 px-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="index.php" class="text-secondary text-decoration-none">Home</a></li>
            <?php if ($category): ?>
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?php echo htmlspecialchars($category['name']); ?></li>
            <?php else: ?>
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Search Results</li>
            <?php endif; ?>
        </ol>
    </nav>

    <?php if (empty($products)): ?>
        <div class="text-center py-5 border rounded bg-light">
            <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-dark">No Products Found</h4>
            <p class="text-secondary mb-4">We couldn't find any products matching your criteria. Try searching for something else.</p>
            <a href="index.php" class="btn btn-vp-dark">Back to Home</a>
        </div>
    <?php else: ?>
        <?php foreach ($sections as $sec): ?>
            <?php if (empty($sec['items'])) continue; ?>
            <div class="mb-5">
                <h3 class="fw-bold font-outfit text-dark mb-1"><?php echo htmlspecialchars($sec['title']); ?></h3>
                <?php if (!empty($sec['subtitle'])): ?>
                    <p class="text-muted mb-4"><?php echo htmlspecialchars($sec['subtitle']); ?></p>
                <?php endif; ?>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php foreach ($sec['items'] as $prod): ?>
                        <?php render_product_card($prod); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
