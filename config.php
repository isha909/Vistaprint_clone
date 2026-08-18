<?php
// Prevent direct access to config file
if (basename($_SERVER['PHP_SELF']) == 'config.php') {
    die('Direct access not permitted');
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') ?: 'vistaprint_db');

// Establish Database Connection
$conn = null;
try {
    // Connect to mysql server
    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Try to select database
    if (!@$conn->select_db(DB_NAME)) {
        // Database might not exist yet, we will handle database creation in database_setup.php
        $conn_error = "Database '" . DB_NAME . "' does not exist. Please run database_setup.php to set it up.";
    }
} catch (Exception $e) {
    $conn_error = $e->getMessage();
}

// Set UTF-8 encoding
if ($conn && !$conn->connect_error && !isset($conn_error)) {
    $conn->set_charset("utf8mb4");
}

// App Constants
define('APP_NAME', 'Vistaprint');
define('CURRENCY_SYMBOL', '₹');
?>
