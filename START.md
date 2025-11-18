# 🚀 START HERE - INSTANT SETUP

## ⚡ Quick Start (2 Commands):

```bash
cd portfolio
php -S localhost:8000
```

**That's it!** 

Visit: **http://localhost:8000/**

Login: **http://localhost:8000/login.php**
- Username: `admin`
- Password: `admin123`

---

## ✅ What Happens Automatically:

When you start the server, it will:
1. ✅ Auto-create SQLite database (`portfolio.db`)
2. ✅ Create all tables (users, projects)
3. ✅ Insert admin user with password `admin123`
4. ✅ Insert all 10 of your projects
5. ✅ Ready to use immediately!

**No database setup. No configuration. Just works!**

---

## 📦 What's Included:

Your portfolio site with:
- ✅ Modern, responsive design
- ✅ All 10 of your projects pre-loaded
- ✅ Secure admin login
- ✅ Full project management dashboard
- ✅ Add/Edit/Delete projects
- ✅ Mobile-friendly

---

## 🔧 Advanced Options:

### Want to use MySQL instead?
See `LOCAL-TESTING.md` for MySQL setup instructions.

### Need to reset password?
```bash
php reset-password.php
```

### Test if login works?
Visit: `http://localhost:8000/test-login.php`

---

## 📱 Test on Phone/Tablet:

1. Find your computer's IP:
```bash
ifconfig | grep "inet "  # Mac/Linux
ipconfig                 # Windows
```

2. On your phone (same WiFi), visit:
```
http://YOUR_IP:8000/
```

---

## 🎯 Default Credentials:

```
Username: admin
Password: admin123
```

**Change this after first login!**

---

## 📁 Project Structure:

```
portfolio/
├── index.php          - Your portfolio homepage
├── login.php          - Admin login
├── admin.php          - Project management dashboard
├── config.php         - SQLite database (ready to use!)
├── styles.css         - All styling
├── portfolio.db       - Created automatically on first run
└── *.md files         - Documentation
```

---

## 🐛 Troubleshooting:

**Port 8000 busy?**
```bash
php -S localhost:8080  # Use different port
```

**Need fresh start?**
```bash
rm portfolio.db        # Delete database
php -S localhost:8000  # Restart (recreates everything)
```

**Login not working?**
```bash
php reset-password.php
```

---

## 🎨 Customize:

- Edit projects: Login to admin dashboard
- Change colors: Edit `styles.css` (look for `:root` variables)
- Update content: Edit `index.php`

---

**Questions?** Check the other `.md` files:
- `README.md` - Complete documentation
- `PHP-ONLY-TESTING.md` - Detailed PHP setup
- `CREDENTIAL-FIX.md` - Login troubleshooting
- `QUICK-FIX.md` - Common issues

---

**TL;DR:** Just run `php -S localhost:8000` and you're done! ✨
