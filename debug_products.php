<?php
require_once __DIR__ . '/config.php';

echo "<pre>";
echo "is_db_available-style check: ";
echo ($conn && !$conn->connect_error && !isset($conn_error)) ? "TRUE\n\n" : "FALSE\n\n";

if ($conn && !$conn->connect_error) {
    echo "Connected OK to database: " . DB_NAME . "\n\n";

    // 1. Raw count, no joins, no prepared statement
    $res = $conn->query("SELECT COUNT(*) as cnt FROM products");
    if ($res) {
        $row = $res->fetch_assoc();
        echo "Total rows in products table: " . $row['cnt'] . "\n\n";
    } else {
        echo "COUNT query failed: " . $conn->error . "\n\n";
    }

    // 2. Raw listing of Visiting Cards products (subcategory ids 1-9), no joins
    $res2 = $conn->query("SELECT id, subcategory_id, name, status FROM products WHERE subcategory_id BETWEEN 1 AND 9 ORDER BY id");
    if ($res2) {
        echo "Products with subcategory_id 1-9 (" . $res2->num_rows . " found):\n";
        while ($r = $res2->fetch_assoc()) {
            echo "  id={$r['id']}  subcategory_id={$r['subcategory_id']}  status={$r['status']}  name={$r['name']}\n";
        }
        echo "\n";
    } else {
        echo "Raw listing query failed: " . $conn->error . "\n\n";
    }

    // 3. Confirm subcategories 1-9 actually belong to category_id 1
    $res3 = $conn->query("SELECT id, category_id, name FROM subcategories WHERE id BETWEEN 1 AND 9 ORDER BY id");
    if ($res3) {
        echo "Subcategories 1-9:\n";
        while ($r = $res3->fetch_assoc()) {
            echo "  id={$r['id']}  category_id={$r['category_id']}  name={$r['name']}\n";
        }
        echo "\n";
    }

    // 4. Run the EXACT prepared statement + get_result() that get_products_by_category() uses
    echo "--- Testing the real JOIN query used by the site (category_id = 1) ---\n";
    $stmt = $conn->prepare("SELECT p.* FROM products p INNER JOIN subcategories s ON p.subcategory_id = s.id WHERE s.category_id = ? AND p.status = 1 ORDER BY p.id ASC");
    if (!$stmt) {
        echo "PREPARE FAILED: " . $conn->error . "\n";
    } else {
        $cat_id = 1;
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            echo "get_result() FAILED — this usually means the mysqlnd PHP driver is not installed.\n";
            echo "stmt error: " . $stmt->error . "\n";
        } else {
            echo "Rows returned by JOIN query: " . $result->num_rows . "\n";
        }
    }
} else {
    echo "Connection FAILED.\n";
    echo "connect_error: " . ($conn ? $conn->connect_error : "no \$conn object") . "\n";
    if (isset($conn_error)) echo "conn_error: $conn_error\n";
}
echo "</pre>";