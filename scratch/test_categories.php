<?php
// PHP Script to programmatically verify category page rendering for all templates

// Mock environment variables to satisfy config.php and headers
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/category.php';
$_SERVER['PHP_SELF'] = '/category.php';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Include the db connection and configurations
require_once __DIR__ . '/../functions.php';

$test_cases = [
    1  => ['name' => 'Visiting Cards',                     'template' => 'category_detail'],
    2  => ['name' => 'Stationery, Letterheads & Notebooks', 'template' => 'view_all'],
    3  => ['name' => 'Stamps and Inks',                     'template' => 'view_all'],
    4  => ['name' => 'Signs, posters and marketing materials','template' => 'view_all'],
    5  => ['name' => 'Labels, Stickers & Packaging',        'template' => 'view_all'],
    6  => ['name' => 'Clothing Caps & Bags',                'template' => 'view_all'],
    7  => ['name' => 'Mugs, Albums & gifts',                'template' => 'view_all'],
    8  => ['name' => 'Pens',                                'template' => 'category_detail'],
    9  => ['name' => 'Drinkware',                           'template' => 'category_detail'],
    10 => ['name' => 'Custom Polo T - shirts',              'template' => 'view_all'],
    11 => ['name' => 'Umbrellas and rainwear',              'template' => 'category_detail'],
];

echo "=== START CATEGORY PAGE VERIFICATION ===\n\n";

$all_passed = true;

foreach ($test_cases as $id => $info) {
    echo "Testing Category ID {$id}: '{$info['name']}' (Expected: {$info['template']})...\n";
    
    $_GET['id'] = $id;
    
    // Capture page output
    ob_start();
    try {
        // We include it in a separate function scope to avoid global variable conflicts
        $render = function() {
            global $conn, $conn_error, $mock_categories, $mock_subcategories, $mock_products;
            include __DIR__ . '/../category.php';
        };
        $render();
        $output = ob_get_clean();
        
        $success = true;
        
        // 1. Verify Category Name is in output
        if (stripos($output, htmlspecialchars($info['name'])) === false) {
            echo "   [FAIL] Category name '" . htmlspecialchars($info['name']) . "' not found in rendered output.\n";
            $success = false;
        }
        
        // 2. Verify Template specific tags
        if ($info['template'] === 'view_all') {
            if (stripos($output, 'view-all-sidebar-unified') === false || stripos($output, 'Shop by category') === false) {
                echo "   [FAIL] Expected View-All style elements ('view-all-sidebar-unified' or 'Shop by category') but they were missing.\n";
                $success = false;
            } else {
                echo "   [PASS] Rendered correctly with View-All Template (Template B).\n";
            }
        } else {
            // category_detail
            if (stripos($output, 'vp-category-hero') === false) {
                echo "   [FAIL] Expected Category Detail elements ('vp-category-hero') but they were missing.\n";
                $success = false;
            } else {
                echo "   [PASS] Rendered correctly with Category Detail Template (Template A).\n";
            }
        }
        
        if (!$success) {
            $all_passed = false;
        }
        
    } catch (Exception $e) {
        ob_get_clean();
        echo "   [FAIL] Exception encountered: " . $e->getMessage() . "\n";
        $all_passed = false;
    }
    
    echo "\n";
}

if ($all_passed) {
    echo "=== ALL CATEGORY PAGE VERIFICATIONS PASSED SUCCESSFULLY ===\n";
    exit(0);
} else {
    echo "=== SOME VERIFICATIONS FAILED ===\n";
    exit(1);
}
