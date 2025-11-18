#!/bin/bash

echo "=========================================="
echo "Portfolio Site - Setup & Start"
echo "=========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed!"
    echo "Please install PHP first"
    exit 1
fi

PHP_VERSION=$(php -v | head -n 1)
echo "✅ PHP found: $PHP_VERSION"
echo ""

# Check if SQLite extension is available
if php -m | grep -q sqlite3; then
    echo "✅ SQLite3 extension available"
    USE_SQLITE=true
else
    echo "⚠️  SQLite3 extension not found"
    USE_SQLITE=false
fi

echo ""
echo "Choose your database option:"
echo "1) SQLite (recommended - no setup needed)"
echo "2) MySQL (requires MySQL server running)"
echo ""
read -p "Enter choice (1 or 2): " CHOICE

if [ "$CHOICE" == "1" ]; then
    if [ "$USE_SQLITE" = true ]; then
        echo ""
        echo "✅ Using SQLite - no database setup needed!"
        
        # Backup original config if exists
        if [ -f "config.php" ] && [ ! -f "config-mysql-backup.php" ]; then
            cp config.php config-mysql-backup.php
            echo "📦 Original config backed up to config-mysql-backup.php"
        fi
        
        # Use SQLite config
        cp config-sqlite.php config.php
        echo "✅ Switched to SQLite configuration"
        echo "📊 Database will be created automatically on first run"
    else
        echo ""
        echo "❌ SQLite extension not available"
        echo "Install with: sudo apt-get install php-sqlite3"
        exit 1
    fi
else
    echo ""
    echo "⚠️  MySQL Mode Selected"
    echo ""
    echo "Make sure:"
    echo "1. MySQL is running"
    echo "2. Database 'portfolio_db' is created"
    echo "3. database.sql is imported"
    echo ""
    
    # Restore MySQL config if backup exists
    if [ -f "config-mysql-backup.php" ]; then
        cp config-mysql-backup.php config.php
        echo "✅ Restored MySQL configuration"
    fi
    
    read -p "Press Enter when ready..."
fi

echo ""
echo "🚀 Starting PHP development server..."
echo ""
echo "📍 Your portfolio is ready at:"
echo "   http://localhost:8000/"
echo ""
echo "🔐 Admin login:"
echo "   http://localhost:8000/login.php"
echo "   Username: admin"
echo "   Password: admin123"
echo ""
echo "Press Ctrl+C to stop"
echo "=========================================="
echo ""

# Start server
php -S localhost:8000
