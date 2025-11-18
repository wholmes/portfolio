# 🚀 LOCAL TESTING - QUICK START GUIDE

## Method 1: XAMPP (Recommended - Easiest)

### Step 1: Install XAMPP
- Download: https://www.apachefriends.org/
- Install and launch XAMPP Control Panel
- Click "Start" for **Apache** and **MySQL**

### Step 2: Setup Files
1. Extract `portfolio-site.zip`
2. Copy folder to: `C:\xampp\htdocs\portfolio`
   - Mac: `/Applications/XAMPP/htdocs/portfolio`
   - Linux: `/opt/lampp/htdocs/portfolio`

### Step 3: Setup Database
1. Open: `http://localhost/phpmyadmin`
2. Click "New" button
3. Database name: `portfolio_db`
4. Click "Create"
5. Select `portfolio_db` from left sidebar
6. Click "Import" tab
7. Choose `database.sql` file
8. Click "Go" button at bottom

### Step 4: Access Your Site
- **Portfolio**: http://localhost/portfolio/
- **Admin**: http://localhost/portfolio/login.php
- **Login**: username `admin`, password `admin123`

**Done!** 🎉

---

## Method 2: PHP Built-in Server (If You Have PHP)

**Note**: This method still requires MySQL/MariaDB for the database.

### Quick Command:
```bash
# Navigate to your portfolio folder
cd /path/to/portfolio

# Start server
php -S localhost:8000
```

Then visit: `http://localhost:8000/`

**But you still need to:**
1. Install MySQL or MariaDB separately
2. Create the database using phpMyAdmin or command line
3. Import `database.sql`

---

## Method 3: Docker (Advanced but Isolated)

If you want everything in containers:

```bash
# Coming to next steps...
```

---

## 🎯 Recommended: XAMPP

**Why XAMPP?**
- ✅ One-click install of PHP + MySQL
- ✅ Includes phpMyAdmin (database management)
- ✅ No configuration needed
- ✅ Works on Windows, Mac, Linux
- ✅ Perfect for testing

---

## ⚠️ Common Issues

### "Connection failed" error
- Make sure MySQL is running in XAMPP
- Check database name is `portfolio_db`
- Verify config.php has correct credentials

### "Page not found" error
- Make sure Apache is running
- Check you're using correct URL: `http://localhost/portfolio/`
- Ensure files are in htdocs folder

### phpMyAdmin won't open
- Make sure Apache AND MySQL are both started
- Try: `http://127.0.0.1/phpmyadmin`

---

## 🔧 Default XAMPP Credentials

```php
DB_HOST: 'localhost'
DB_USER: 'root'
DB_PASS: ''  // empty (no password)
DB_NAME: 'portfolio_db'
```

These are already set in `config.php` - should work out of the box!

---

## 📱 Testing on Phone/Tablet

1. Find your computer's IP address:
   - Windows: `ipconfig` in Command Prompt
   - Mac/Linux: `ifconfig` or `ip addr`

2. On same WiFi network, visit:
   `http://YOUR_IP_ADDRESS/portfolio/`

Example: `http://192.168.1.100/portfolio/`

---

**Need help?** Check the main README.md for troubleshooting!
