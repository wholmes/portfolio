<?php
/**
 * Database Configuration Template
 *
 * Copy this file to config.php and update with your actual database credentials.
 * Never commit config.php to version control!
 */

// Database Configuration
define('DB_HOST', 'localhost');          // Database host (usually 'localhost')
define('DB_USER', 'your_username');      // Your MySQL username
define('DB_PASS', 'your_password');      // Your MySQL password
define('DB_NAME', 'portfolio_db');       // Database name

// Application Settings
define('SITE_URL', 'http://localhost/portfolio');  // Your site URL (no trailing slash)
define('ADMIN_EMAIL', 'admin@example.com');        // Admin email address

// Security Settings
define('SESSION_LIFETIME', 3600);        // Session lifetime in seconds (1 hour)
define('ENABLE_HTTPS', false);           // Set to true in production with SSL

// Error Reporting (set to false in production)
define('DEBUG_MODE', true);
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    if (DEBUG_MODE) {
        die("Connection failed: " . $e->getMessage());
    } else {
        die("Connection failed. Please contact the administrator.");
    }
}

// Session Configuration
ini_set('session.cookie_httponly', 1);
if (ENABLE_HTTPS) {
    ini_set('session.cookie_secure', 1);
}
session_start();
?>
