<?php
// Quick Test - Verify Login Credentials

require_once 'config.php';

echo "<h2>Portfolio Site - Login Verification</h2>";
echo "<hr>";

try {
    $conn = getDBConnection();
    echo "<p style='color: green;'>✅ Database connection: OK</p>";
    
    // Get all users
    $stmt = $conn->query("SELECT id, username, email, created_at FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "<h3>Users in Database:</h3>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Created</th><th>Test Login</th></tr>";
        
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td><strong>{$user['username']}</strong></td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['created_at']}</td>";
            
            // Test password
            $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->execute([$user['username']]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $testPassword = 'admin123';
            $loginWorks = password_verify($testPassword, $userData['password']);
            
            if ($loginWorks) {
                echo "<td style='color: green; font-weight: bold;'>✅ Password 'admin123' works!</td>";
            } else {
                echo "<td style='color: red;'>❌ Password incorrect</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
        // Check if admin123 works
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = 'admin'");
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && password_verify('admin123', $admin['password'])) {
            echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 5px;'>";
            echo "<h3 style='color: #155724; margin-top: 0;'>✅ Login Should Work!</h3>";
            echo "<p><strong>Username:</strong> admin</p>";
            echo "<p><strong>Password:</strong> admin123</p>";
            echo "<p><a href='login.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Go to Login Page</a></p>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; border: 2px solid #dc3545; padding: 20px; margin: 20px 0; border-radius: 5px;'>";
            echo "<h3 style='color: #721c24; margin-top: 0;'>❌ Password Issue Detected</h3>";
            echo "<p>Run the password reset tool:</p>";
            echo "<code style='background: #000; color: #0f0; padding: 5px 10px; display: block; margin: 10px 0;'>php reset-password.php</code>";
            echo "</div>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ No users found in database!</p>";
        echo "<p>Run the password reset tool to create admin user:</p>";
        echo "<code style='background: #000; color: #0f0; padding: 10px; display: block;'>php reset-password.php</code>";
    }
    
    // Check projects
    $stmt = $conn->query("SELECT COUNT(*) as count FROM projects");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<hr>";
    echo "<p>📊 Projects in database: <strong>{$result['count']}</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>← Back to Portfolio</a></p>";
?>
