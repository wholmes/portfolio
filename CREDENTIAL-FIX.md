# 🔐 LOGIN ISSUES? - QUICK FIX

If you're getting "Invalid username or password", here are 3 instant fixes:

---

## ⚡ Method 1: Password Reset Tool (Easiest)

Run this in your terminal:

```bash
php reset-password.php
```

This will:
- ✅ Create/reset admin user
- ✅ Set password to `admin123`
- ✅ Show you all users in database
- ✅ Confirm it worked

Then try logging in again!

---

## 🔍 Method 2: Test Login Page

Visit in your browser:
```
http://localhost:8000/test-login.php
```

This shows you:
- ✅ Database connection status
- ✅ All users in database
- ✅ Whether password works
- ✅ Direct link to login if working

---

## 🗄️ Method 3: Fresh Database

If using **SQLite**, just delete the database and restart:

```bash
# Delete existing database
rm portfolio.db

# Restart server (will recreate DB automatically)
php -S localhost:8000
```

If using **MySQL**, re-import:

```bash
mysql -u root -p portfolio_db < database.sql
```

---

## 🐛 Common Issues & Fixes

### Issue: "Connection failed"
**Fix:** Make sure you're using the right config
```bash
# For SQLite (no MySQL needed)
cp config-sqlite.php config.php

# For MySQL (MySQL must be running)
cp config-mysql-backup.php config.php
```

### Issue: Password hash problems
**Fix:** The SQLite config now generates fresh passwords automatically. Just delete `portfolio.db` and restart.

### Issue: Database doesn't exist
**Fix for SQLite:** Just start the server, it creates automatically
```bash
php -S localhost:8000
```

**Fix for MySQL:** Import the SQL file
```bash
mysql -u root -p portfolio_db < database.sql
```

---

## 🎯 Quick Checklist

Before trying to login:

1. ✅ Server is running: `http://localhost:8000` shows portfolio
2. ✅ Run: `php reset-password.php`
3. ✅ Visit: `http://localhost:8000/test-login.php`
4. ✅ Look for green "✅ Password 'admin123' works!"
5. ✅ Click "Go to Login Page"
6. ✅ Use: username `admin`, password `admin123`

---

## 💡 Still Not Working?

### Check what database you're using:

```bash
# See what config is active
head -n 5 config.php
```

Look for either:
- `mysql:host=` → Using MySQL (need MySQL running)
- `sqlite:` → Using SQLite (should just work)

### Switch to SQLite (easiest):

```bash
cp config-sqlite.php config.php
rm portfolio.db  # Fresh start
php -S localhost:8000
```

### Create admin manually in SQLite:

```bash
# Open SQLite database
sqlite3 portfolio.db

# Delete old admin (if exists)
DELETE FROM users WHERE username='admin';

# Create fresh admin
# Note: Run reset-password.php instead, it's easier!
```

---

## 📞 Debug Output

Run this to see what's happening:

```bash
php -r "
require 'config.php';
\$conn = getDBConnection();
\$stmt = \$conn->query('SELECT username, email FROM users');
while (\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) {
    echo 'User: ' . \$row['username'] . ' (' . \$row['email'] . ')\n';
}
"
```

---

## ✅ Expected Result

After running `php reset-password.php`, you should see:

```
========================================
Portfolio Site - Password Reset Tool
========================================

✅ Database connection successful
✅ Password reset for existing user 'admin'

========================================
Login Credentials:
========================================
Username: admin
Password: admin123
========================================

Current users in database:
  - ID: 1, Username: admin, Email: admin@portfolio.com

✅ Password reset complete!
```

Then login will work! 🎉

---

## 🔑 Default Credentials (After Reset)

```
Username: admin
Password: admin123
```

**Important:** Change this password after first login!

---

**TL;DR:** Run `php reset-password.php` and you're good to go! ✨
