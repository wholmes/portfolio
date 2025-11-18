# Professional PHP Portfolio Website

A modern, responsive portfolio website with admin dashboard for showcasing your projects. Built with PHP, MySQL, and vanilla JavaScript.

## Features

- **Public Portfolio Page**: Clean, professional showcase of your work
- **Secure Login System**: Password-protected admin area
- **Admin Dashboard**: Easy-to-use interface for managing projects
- **Project Management**: Add, edit, delete, and reorder projects
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Modern UI**: Clean, professional design with smooth animations

## Your Projects Included

The site comes pre-loaded with your impressive portfolio:

1. **Datalayer Tracker** (WordPress Plugin)
2. **Tab Anything Block** (WordPress Plugin)
3. **Code My Brand** (WordPress Theme)
4. **Datalayer Tracker SaaS** (SaaS Service)
5. **eBook** (Digital Product)
6. **Prompt Enhancer** (AI Tool)
7. **Prompt Builder** (AI Tool)
8. **Casetext Websites Manager** (Web Application)
9. **Tag Management Consulting** (Service)
10. **Web Development** (Service)

## Installation Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- phpMyAdmin (optional, for database management)

### Step 1: Database Setup

1. Open phpMyAdmin or your MySQL client
2. Create a new database or use the SQL file:
   ```sql
   CREATE DATABASE portfolio_db;
   ```
3. Import the `database.sql` file or run the SQL commands from it

### Step 2: Configure Database Connection

1. Copy `config.example.php` to `config.php`:
   ```bash
   cp config.example.php config.php
   ```
2. Open `config.php` and update the database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'portfolio_db');
   ```

### Step 3: Upload Files

Upload all files to your web server:
- For local development: Place in `htdocs` (XAMPP) or `www` (WAMP)
- For live server: Upload to public_html or your domain root

### Step 4: Set Permissions

Ensure PHP can write sessions (usually automatic, but check if you have issues):
```bash
chmod 755 /path/to/your/site
```

### Step 5: Access Your Site

- **Portfolio**: `http://yourdomain.com/` or `http://localhost/yourfolder/`
- **Admin Login**: `http://yourdomain.com/login.php`

### Default Admin Credentials

- **Username**: admin
- **Email**: admin@portfolio.com
- **Password**: admin123

**IMPORTANT**: Change the default password immediately after first login!

## Changing Your Password

To change the admin password:

1. Use this PHP code to generate a new password hash:
   ```php
   <?php
   echo password_hash('your_new_password', PASSWORD_DEFAULT);
   ?>
   ```

2. Update the database:
   ```sql
   UPDATE users SET password = 'your_generated_hash' WHERE username = 'admin';
   ```

Or create a simple password change page (recommended for production).

## File Structure

```
portfolio-site/
├── index.php            # Main portfolio page
├── login.php            # Login page
├── admin.php            # Admin dashboard
├── logout.php           # Logout script
├── config.php           # Database configuration (create from config.example.php)
├── config.example.php   # Configuration template
├── styles.css           # All styling
├── database.sql         # Database schema and initial data
├── .gitignore           # Git ignore rules
├── LICENSE              # MIT License
├── CONTRIBUTING.md      # Contributing guidelines
└── README.md            # This file
```

## Customization

### Adding Your Own Content

1. **Update Projects**: Login to admin dashboard and edit projects
2. **Change Colors**: Edit CSS variables in `styles.css`:
   ```css
   :root {
       --primary-color: #2563eb;
       --primary-dark: #1e40af;
   }
   ```
3. **Update Hero Section**: Edit `index.php` hero section
4. **Add Your Email**: Replace contact email in `index.php`

### Adding Project Images

To add images to projects:

1. Create an `images` folder in your site root
2. Upload project images
3. Update the `image_url` column in the database
4. Modify the project card in `index.php` to display images

## Security Best Practices

1. **Change Default Password** immediately
2. **Use HTTPS** on production (Let's Encrypt is free)
3. **Keep PHP Updated** to the latest stable version
4. **Backup Database** regularly
5. **Restrict Admin Access** by IP if possible
6. **Use Strong Passwords** with a mix of characters

## Troubleshooting

### "Connection failed" Error
- Check database credentials in `config.php`
- Ensure MySQL service is running
- Verify database exists

### "Session" Issues
- Check that sessions are enabled in `php.ini`
- Ensure `/tmp` or session directory is writable

### Login Not Working
- Verify username/password
- Check that password hash was created correctly
- Clear browser cookies/cache

### Styling Not Loading
- Verify `styles.css` is in the same directory
- Check file permissions (should be readable)
- Clear browser cache

## Adding New Features

### Enable User Registration

Add a registration page:
```php
// register.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Insert into database
}
```

### Add Project Categories Filter

Modify `index.php` to add category filtering with JavaScript.

### Add Image Uploads

Implement file upload functionality in `admin.php` for project images.

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL with PDO
- **Frontend**: HTML5, CSS3, JavaScript (ES6)
- **Security**: Password hashing with bcrypt, prepared statements

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

This is a custom-built portfolio site. Feel free to modify and use it for your personal portfolio.

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review PHP error logs
3. Verify all files are uploaded correctly
4. Ensure database connection is working

## Future Enhancements

Consider adding:
- Contact form with email functionality
- Project image gallery
- Blog section
- Testimonials
- Analytics integration
- SEO optimization
- Social media links
- Dark mode toggle

---

**Ready to showcase your work!** 🚀

After setup, customize the content to match your brand and start impressing potential clients and employers.
