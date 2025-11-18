# Deploying to Namecheap

This guide covers deploying your PHP portfolio to Namecheap shared hosting.

## Prerequisites

- Active Namecheap hosting account with cPanel access
- Your Namecheap hosting credentials
- FTP client (FileZilla recommended) or Git access if available
- Database access via phpMyAdmin

## Deployment Steps

### Step 1: Access cPanel

1. Log into your Namecheap account
2. Go to **Hosting List** and click **Manage** for your domain
3. Click **Go to cPanel** button
4. You'll be redirected to your cPanel dashboard

### Step 2: Create MySQL Database

1. In cPanel, find **MySQL Databases** under the Databases section
2. Create a new database:
   - Database name: `youruser_portfolio` (Namecheap adds prefix automatically)
   - Click **Create Database**
3. Create a database user:
   - Username: `youruser_portfolio`
   - Generate a strong password (save this!)
   - Click **Create User**
4. Add user to database:
   - Select the database and user you just created
   - Grant **ALL PRIVILEGES**
   - Click **Add**
5. **Save these credentials** - you'll need them for configuration

### Step 3: Upload Files

#### Option A: Using File Manager (Easy)

1. In cPanel, go to **File Manager**
2. Navigate to `public_html` (or your domain's root directory)
3. Upload all files EXCEPT:
   - `.git/` directory
   - `README.md` (optional)
   - `DEPLOYMENT.md` (optional)
   - `CONTRIBUTING.md` (optional)
   - `config.php` (you'll create this separately)
4. Click **Upload** and select your files
5. Ensure proper file structure is maintained

#### Option B: Using FTP (FileZilla)

1. Open FileZilla
2. Connect with these settings:
   - **Host**: ftp.yourdomain.com (or IP from Namecheap)
   - **Username**: Your cPanel username
   - **Password**: Your cPanel password
   - **Port**: 21
3. Navigate to `public_html` on the remote side
4. Upload all project files (excluding .git, docs, etc.)

#### Option C: Using Git (If Available)

1. In cPanel, go to **Terminal** or use **Git Version Control**
2. Clone your repository:
   ```bash
   cd public_html
   git clone https://github.com/yourusername/portfolio.git .
   ```
3. Remove git files from production:
   ```bash
   rm -rf .git
   ```

### Step 4: Configure Database Connection

1. In File Manager or FTP, copy `config.example.php` to `config.php`
2. Edit `config.php` with the correct credentials:
   ```php
   define('DB_HOST', 'localhost');  // Usually 'localhost' on Namecheap
   define('DB_USER', 'youruser_portfolio');  // Database username
   define('DB_PASS', 'your_secure_password');  // Database password
   define('DB_NAME', 'youruser_portfolio');  // Database name
   ```
3. Update other settings:
   ```php
   define('SITE_URL', 'https://yourdomain.com');  // Your actual domain
   define('ADMIN_EMAIL', 'your@email.com');
   define('ENABLE_HTTPS', true);  // Set to true
   define('DEBUG_MODE', false);  // IMPORTANT: Set to false in production!
   ```
4. Save the file

### Step 5: Import Database

1. In cPanel, go to **phpMyAdmin**
2. Select your database from the left sidebar
3. Click **Import** tab
4. Choose your `database.sql` file
5. Click **Go** to import
6. Verify tables were created successfully

### Step 6: Set File Permissions

1. In File Manager, set proper permissions:
   - **Directories**: 755
   - **PHP files**: 644
   - **config.php**: 600 (most secure)
2. Right-click files/folders and select **Change Permissions**

### Step 7: Configure SSL (HTTPS)

1. In cPanel, go to **SSL/TLS Status**
2. If using Namecheap's free SSL:
   - Click **Install SSL** next to your domain
   - Wait for AutoSSL to activate
3. Force HTTPS in `.htaccess` (see Security section below)

### Step 8: Test Your Site

1. Visit: `https://yourdomain.com`
2. Test admin login: `https://yourdomain.com/login.php`
3. Default credentials (CHANGE IMMEDIATELY):
   - Username: `admin`
   - Password: `admin123`
4. Test adding/editing projects in admin dashboard

## Security Configuration

### Force HTTPS Redirect

The `.htaccess` file should already include HTTPS redirect rules. If not:

```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Protect Sensitive Files

Ensure `.htaccess` protects config files:

```apache
<Files "config.php">
    Order Allow,Deny
    Deny from all
</Files>
```

### Change Default Password

**IMMEDIATELY** after first login:

1. Use phpMyAdmin to update admin password
2. Generate hash with PHP:
   ```php
   <?php echo password_hash('YourNewSecurePassword', PASSWORD_DEFAULT); ?>
   ```
3. Update users table with new hash

## Troubleshooting

### 500 Internal Server Error
- Check `.htaccess` syntax
- Verify file permissions (644 for files, 755 for directories)
- Check PHP error logs in cPanel

### Database Connection Failed
- Verify database credentials in `config.php`
- Ensure database user has correct privileges
- Check if database exists in phpMyAdmin

### Images/CSS Not Loading
- Check file paths (use absolute URLs if needed)
- Verify file permissions are readable (644)
- Clear browser cache

### Session Issues
- Check PHP version (7.4+ required)
- Verify session directory permissions
- Check `php.ini` settings in cPanel

## Namecheap-Specific Tips

### Finding Your Database Host
- Usually `localhost`
- Check cPanel > MySQL Databases for exact host
- Some accounts use `127.0.0.1`

### PHP Version
1. In cPanel, go to **Select PHP Version**
2. Choose PHP 7.4 or higher
3. Enable required extensions:
   - PDO
   - pdo_mysql
   - mbstring
   - json

### File Path
- Your site root is typically: `/home/username/public_html/`
- Use cPanel File Manager to verify exact path

### Email Configuration
1. Create email account in cPanel
2. Use Namecheap SMTP settings for contact forms
3. Check Namecheap documentation for mail server details

## Updating Your Site

### Manual Updates
1. Edit files via File Manager or FTP
2. Clear any PHP opcode cache
3. Test changes immediately

### Using Git (If Available)
1. Make changes locally
2. Push to repository
3. SSH/Terminal into server
4. Pull latest changes:
   ```bash
   cd public_html
   git pull origin main
   ```

## Backup Strategy

### Database Backups
1. Use cPanel **Backup Wizard**
2. Or phpMyAdmin > Export > Save
3. Schedule automatic backups in cPanel

### File Backups
1. Use cPanel **Backup** tool
2. Download full backup monthly
3. Keep offsite copies (Google Drive, Dropbox)

## Performance Optimization

### Enable Caching
Add to `.htaccess`:
```apache
# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### Enable Compression
```apache
# Gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css text/javascript
</IfModule>
```

## Monitoring

### Check Error Logs
1. cPanel > **Errors** section
2. Review PHP error log regularly
3. Monitor access logs for unusual activity

### Uptime Monitoring
- Use free services like UptimeRobot
- Monitor from Namecheap hosting dashboard

## Support Resources

- **Namecheap Support**: https://www.namecheap.com/support/
- **cPanel Documentation**: https://docs.cpanel.net/
- **PHP Documentation**: https://www.php.net/docs.php

---

## Quick Deployment Checklist

- [ ] Created MySQL database in cPanel
- [ ] Created database user with privileges
- [ ] Uploaded all files to public_html
- [ ] Created config.php from config.example.php
- [ ] Updated config.php with database credentials
- [ ] Set DEBUG_MODE to false in config.php
- [ ] Imported database.sql via phpMyAdmin
- [ ] Set correct file permissions (644/755)
- [ ] Enabled SSL/HTTPS
- [ ] Tested site functionality
- [ ] Changed default admin password
- [ ] Configured .htaccess for security
- [ ] Set up regular backups
- [ ] Tested on mobile devices

---

**Your portfolio is now live on Namecheap!** 🎉
