@echo off
echo ==========================================
echo Portfolio Site - Quick Test Setup
echo ==========================================
echo.

REM Check if PHP is installed
php -v >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP is not installed!
    echo Please install PHP or use XAMPP
    pause
    exit /b 1
)

echo [OK] PHP is installed
echo.

REM Set database instructions
echo IMPORTANT: Database Setup Required
echo ==========================================
echo 1. Install XAMPP from https://www.apachefriends.org/
echo 2. Start Apache and MySQL in XAMPP Control Panel
echo 3. Go to http://localhost/phpmyadmin
echo 4. Create database named 'portfolio_db'
echo 5. Import the database.sql file
echo.
echo Press any key once database is set up...
pause >nul

echo.
echo Starting development server on port 8000...
echo.
echo Access your portfolio at:
echo    http://localhost:8000/
echo.
echo Admin login:
echo    http://localhost:8000/login.php
echo    Username: admin
echo    Password: admin123
echo.
echo Press Ctrl+C to stop the server
echo ==========================================
echo.

REM Start PHP built-in server
php -S localhost:8000
