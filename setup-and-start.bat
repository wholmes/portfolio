@echo off
echo ==========================================
echo Portfolio Site - Setup and Start
echo ==========================================
echo.

REM Check if PHP is installed
php -v >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP is not installed!
    echo Please install PHP first
    pause
    exit /b 1
)

echo [OK] PHP is installed
php -v | findstr "PHP"
echo.

REM Check for SQLite
php -m | findstr "sqlite3" >nul 2>&1
if errorlevel 1 (
    set SQLITE_AVAILABLE=false
    echo [WARNING] SQLite3 extension not found
) else (
    set SQLITE_AVAILABLE=true
    echo [OK] SQLite3 extension available
)

echo.
echo Choose your database option:
echo 1) SQLite (recommended - no setup needed)
echo 2) MySQL (requires MySQL server running)
echo.
set /p CHOICE="Enter choice (1 or 2): "

if "%CHOICE%"=="1" (
    if "%SQLITE_AVAILABLE%"=="true" (
        echo.
        echo [OK] Using SQLite - no database setup needed!
        
        REM Backup original config
        if exist config.php (
            if not exist config-mysql-backup.php (
                copy config.php config-mysql-backup.php >nul
                echo [OK] Original config backed up
            )
        )
        
        REM Use SQLite config
        copy config-sqlite.php config.php >nul
        echo [OK] Switched to SQLite configuration
        echo [OK] Database will be created automatically
    ) else (
        echo.
        echo [ERROR] SQLite extension not available
        echo Please enable php_sqlite3.dll in php.ini
        pause
        exit /b 1
    )
) else (
    echo.
    echo [WARNING] MySQL Mode Selected
    echo.
    echo Make sure:
    echo 1. MySQL is running
    echo 2. Database 'portfolio_db' is created
    echo 3. database.sql is imported
    echo.
    
    REM Restore MySQL config if backup exists
    if exist config-mysql-backup.php (
        copy config-mysql-backup.php config.php >nul
        echo [OK] Restored MySQL configuration
    )
    
    pause
)

echo.
echo Starting PHP development server...
echo.
echo Your portfolio is ready at:
echo    http://localhost:8000/
echo.
echo Admin login:
echo    http://localhost:8000/login.php
echo    Username: admin
echo    Password: admin123
echo.
echo Press Ctrl+C to stop
echo ==========================================
echo.

REM Start server
php -S localhost:8000
