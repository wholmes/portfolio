# ⚡ INSTANT FIX - "No such file or directory"

This error means you're using MySQL config but need SQLite config.

## 🔧 One-Command Fix:

**Mac/Linux:**
```bash
./use-sqlite.sh
```

**Windows:**
```cmd
use-sqlite.bat
```

**Or manually:**
```bash
cp config-sqlite.php config.php
```

Then **restart** your PHP server:
```bash
php -S localhost:8000
```

## ✅ Complete Fresh Start (Recommended):

```bash
# 1. Switch to SQLite
cp config-sqlite.php config.php

# 2. Delete old database (if exists)
rm portfolio.db

# 3. Start server (will auto-create database)
php -S localhost:8000
```

Now login will work! **Username:** `admin` **Password:** `admin123`

---

## 🎯 What Happened?

- The default `config.php` was set to MySQL
- You need to use `config-sqlite.php` for PHP-only testing
- After switching, everything works with zero setup

---

## 🚀 Full Setup (Copy-Paste):

```bash
# All in one command:
cp config-sqlite.php config.php && rm -f portfolio.db && php -S localhost:8000
```

That's it! Open http://localhost:8000/ and you're good! 🎉

---

## 💡 To Use MySQL Instead:

If you actually want MySQL:

1. Make sure MySQL is running
2. Create database: `CREATE DATABASE portfolio_db;`
3. Import: `mysql -u root -p portfolio_db < database.sql`
4. Keep the default `config.php` (don't copy config-sqlite.php)

---

**TL;DR:** Run `cp config-sqlite.php config.php` then restart server! ✨
