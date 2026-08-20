<?php
if (defined('APP_CONFIG_LOADED')) {
    return;
}
define('APP_CONFIG_LOADED', true);

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
define('DB_PORT', getenv('DB_PORT') ?: 3306);
define('DB_SSL', getenv('DB_SSL') ? filter_var(getenv('DB_SSL'), FILTER_VALIDATE_BOOLEAN) : false);

// Establish Database Connection
$conn = null;
try {
    $conn = mysqli_init();
    if (!$conn) {
        throw new Exception("mysqli_init failed");
    }

    $flags = 0;
    if (DB_SSL) {
        $ca_path = getenv('DB_SSL_CA') ?: (__DIR__ . '/ca.pem');
        if (!file_exists($ca_path)) {
            throw new Exception("SSL CA certificate file not found at: " . $ca_path);
        }
        $conn->ssl_set(NULL, NULL, $ca_path, NULL, NULL);
        $conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
        $flags = MYSQLI_CLIENT_SSL;
    }

    if (!@$conn->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT, NULL, $flags)) {
        throw new Exception("Connection failed: " . $conn->connect_error);
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
// define('CURRENCY_SYMBOL', '₹');
?>