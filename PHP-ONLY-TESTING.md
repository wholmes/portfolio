# 🚀 TEST WITH PHP ONLY (No XAMPP)

## ⚡ Fastest Way: SQLite (Zero Setup!)

### Step 1: Run Setup Script

**Windows:**
```cmd
setup-and-start.bat
```

**Mac/Linux:**
```bash
chmod +x setup-and-start.sh
./setup-and-start.sh
```

### Step 2: Choose Option 1 (SQLite)

The script will:
- ✅ Auto-detect if SQLite is available
- ✅ Create database automatically
- ✅ Insert all your projects
- ✅ Start PHP server on port 8000

### Step 3: Open Browser

Visit: **http://localhost:8000/**

**Done!** No database setup needed! 🎉

---

## 🔧 Manual Method (If you prefer)

### 1. Switch to SQLite Config

```bash
# Backup MySQL config
cp config.php config-mysql-backup.php

# Use SQLite config
cp config-sqlite.php config.php
```

### 2. Start PHP Server

```bash
php -S localhost:8000
```

### 3. Access Site

- Portfolio: http://localhost:8000/
- Admin: http://localhost:8000/login.php
- Login: `admin` / `admin123`

---

## 🗄️ Option 2: Using MySQL (Without XAMPP)

If you have MySQL installed separately:

### 1. Start MySQL

```bash
# Mac (Homebrew)
brew services start mysql

# Linux
sudo systemctl start mysql
# or
sudo service mysql start

# Windows (if installed as service)
net start mysql
```

### 2. Create Database

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE portfolio_db;
exit;

# Import data
mysql -u root -p portfolio_db < database.sql
```

### 3. Update config.php

```php
define('DB_USER', 'root');
define('DB_PASS', 'your_mysql_password');
```

### 4. Start PHP Server

```bash
php -S localhost:8000
```

---

## 📋 Check PHP Extensions

Make sure you have required extensions:

```bash
# Check PHP version
php -v

# Check installed extensions
php -m

# Look for:
# - PDO
# - pdo_sqlite (for SQLite)
# - pdo_mysql (for MySQL)
```

### Enable SQLite (if missing)

**Mac/Linux:**
```bash
# Usually enabled by default
# If not, install php-sqlite3
sudo apt-get install php-sqlite3  # Ubuntu/Debian
brew install php                   # Mac (includes SQLite)
```

**Windows:**
```
1. Find php.ini file (run: php --ini)
2. Open php.ini
3. Uncomment (remove ;): extension=sqlite3
4. Restart
```

---

## 🎯 Comparison

| Method | Pros | Cons |
|--------|------|------|
| **SQLite** | ✅ Zero setup<br>✅ Auto-creates DB<br>✅ Single file<br>✅ Perfect for testing | ❌ Not for production<br>❌ Single connection |
| **MySQL** | ✅ Production-ready<br>✅ Multi-user<br>✅ Better performance | ❌ Requires MySQL install<br>❌ Manual DB setup |

**Recommendation**: Use SQLite for local testing!

---

## 🚨 Troubleshooting

### "SQLite extension not found"
```bash
# Check if enabled
php -m | grep sqlite

# Enable in php.ini
extension=sqlite3
```

### "Port 8000 already in use"
```bash
# Use different port
php -S localhost:8080
```

### "Permission denied" on .sh file
```bash
chmod +x setup-and-start.sh
```

---

## 📱 Test on Mobile (Same Network)

1. Find your computer's IP:
```bash
# Mac/Linux
ifconfig | grep "inet "

# Windows
ipconfig
```

2. On phone, visit: `http://YOUR_IP:8000/`

Example: `http://192.168.1.100:8000/`

---

## 🔄 Switch Back to MySQL

```bash
# Restore MySQL config
cp config-mysql-backup.php config.php

# Or run setup script and choose option 2
./setup-and-start.sh
```

---

## 💡 Quick Commands

```bash
# SQLite mode - instant start
cp config-sqlite.php config.php && php -S localhost:8000

# MySQL mode - after DB setup
cp config-mysql-backup.php config.php && php -S localhost:8000

# Check what's running
lsof -i :8000  # Mac/Linux
netstat -ano | findstr :8000  # Windows
```

---

**TL;DR**: Run `setup-and-start.sh` (or `.bat`), choose SQLite, done! ✨
