<?php
// Password Reset Utility
// Use this to reset your admin password if login fails

echo "========================================\n";
echo "Portfolio Site - Password Reset Tool\n";
echo "========================================\n\n";

// Check which config is being used
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    die("Error: config.php not found!\n");
}

// Get connection
try {
    $conn = getDBConnection();
    echo "✅ Database connection successful\n\n";
} catch (Exception $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}

// Default credentials
$username = 'admin';
$password = 'admin123';
$email = 'admin@portfolio.com';

// Generate new password hash
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Check if user exists
$stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Update existing user
    $stmt = $conn->prepare("UPDATE users SET password = ?, email = ? WHERE username = ?");
    $stmt->execute([$passwordHash, $email, $username]);
    echo "✅ Password reset for existing user '$username'\n";
} else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $passwordHash]);
    echo "✅ Created new admin user '$username'\n";
}

echo "\n";
echo "========================================\n";
echo "Login Credentials:\n";
echo "========================================\n";
echo "Username: $username\n";
echo "Password: $password\n";
echo "========================================\n";
echo "\n";
echo "You can now login at:\n";
echo "http://localhost:8000/login.php\n";
echo "\n";

// Show all users in database
$stmt = $conn->query("SELECT id, username, email FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($users) > 0) {
    echo "Current users in database:\n";
    foreach ($users as $u) {
        echo "  - ID: {$u['id']}, Username: {$u['username']}, Email: {$u['email']}\n";
    }
}

echo "\n✅ Password reset complete!\n";
?>
