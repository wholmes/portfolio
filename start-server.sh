#!/bin/bash

# Quick Start Script for Portfolio Site
# This uses PHP's built-in server and SQLite for instant testing

echo "=========================================="
echo "Portfolio Site - Quick Test Setup"
echo "=========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed!"
    echo "Please install PHP or use XAMPP"
    exit 1
fi

echo "✅ PHP found: $(php -v | head -n 1)"
echo ""

# Check if port 8000 is available
if lsof -Pi :8000 -sTCP:LISTEN -t >/dev/null 2>&1; then
    echo "⚠️  Port 8000 is already in use"
    echo "Trying port 8080..."
    PORT=8080
else
    PORT=8000
fi

echo "🚀 Starting development server on port $PORT..."
echo ""
echo "📍 Access your portfolio at:"
echo "   http://localhost:$PORT/"
echo ""
echo "🔐 Admin login:"
echo "   http://localhost:$PORT/login.php"
echo "   Username: admin"
echo "   Password: admin123"
echo ""
echo "Press Ctrl+C to stop the server"
echo "=========================================="
echo ""

# Start PHP built-in server
php -S localhost:$PORT
