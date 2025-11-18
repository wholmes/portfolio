<?php
// SQLite configuration - no MySQL needed!
define('DB_FILE', __DIR__ . '/portfolio.db');

// Create database connection
function getDBConnection() {
    try {
        $conn = new PDO("sqlite:" . DB_FILE);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create tables if they don't exist
        $conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $conn->exec("
            CREATE TABLE IF NOT EXISTS projects (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                category TEXT NOT NULL,
                description TEXT,
                url TEXT,
                image_url TEXT,
                display_order INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Check if we need to seed data
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] == 0) {
            // Insert default admin user (password: admin123)
            $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute(['admin', 'admin@portfolio.com', $passwordHash]);
            
            // Insert projects
            $conn->exec("
                INSERT INTO projects (title, category, description, url, display_order) VALUES
                ('Datalayer Tracker', 'WordPress Plugin', 'WordPress plugin for tracking and managing data layer events', NULL, 1),
                ('Tab Anything Block', 'WordPress Plugin', 'Gutenberg block for creating tabbed content in WordPress', NULL, 2),
                ('Code My Brand', 'WordPress Theme', 'Custom WordPress theme for brand development', NULL, 3),
                ('Datalayer Tracker SaaS', 'SaaS Service', 'Software as a Service platform for datalayer tracking and analytics', NULL, 4),
                ('eBook', 'Digital Product', 'Published eBook on web development and marketing', NULL, 5),
                ('Prompt Enhancer', 'AI Tool', 'Tool for optimizing and enhancing AI prompts', NULL, 6),
                ('Prompt Builder', 'AI Tool', 'Interactive builder for creating structured AI prompts', NULL, 7),
                ('Casetext Websites Manager', 'Web Application', 'Management system for multiple Casetext websites', NULL, 8),
                ('Tag Management Consulting', 'Service', 'Professional consulting services for tag management implementation', NULL, 9),
                ('Web Development', 'Service', 'Full-stack web development services', NULL, 10)
            ");
        }
        
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
