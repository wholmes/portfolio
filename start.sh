#!/bin/bash

echo "=========================================="
echo "🚀 Portfolio Site - Starting Server"
echo "=========================================="
echo ""
echo "✅ Using SQLite (no setup needed)"
echo "✅ Database will be created automatically"
echo ""
echo "📍 Your portfolio will be at:"
echo "   http://localhost:8000/"
echo ""
echo "🔐 Admin login:"
echo "   http://localhost:8000/login.php"
echo "   Username: admin"
echo "   Password: admin123"
echo ""
echo "Press Ctrl+C to stop the server"
echo "=========================================="
echo ""

php -S localhost:8000
