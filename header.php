<?php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Custom printing services for business cards, t-shirts, corporate gifts, signs, banners, and marketing materials. Precision-tailored to help your brand stand out.">
    <title><?php echo isset($page_title) ? $page_title . ' | ' . APP_NAME : APP_NAME . ' - Custom Business Cards, T-Shirts & Marketing Materials'; ?></title>
    
    <!-- Google Fonts: Inter and Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (isset($conn_error)): ?>
    <!-- Notice for Developer/User about MySQL connectivity fallback -->
    <div class="alert alert-warning alert-dismissible fade show rounded-0 mb-0 py-2 border-0 text-center" style="font-size: 13px; z-index: 1050; background: #fff3cd; color: #856404;" role="alert">
        <i class="fa-solid fa-circle-exclamation me-1"></i> Database offline: The application is running using dynamic mock-data system fallback.
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
</body>
</html>