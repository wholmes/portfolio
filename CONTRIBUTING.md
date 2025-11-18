# Contributing to Portfolio Website

Thank you for your interest in contributing to this project! This document provides guidelines for development and contribution.

## Development Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Git
- A local development environment (XAMPP, WAMP, MAMP, or similar)

### Getting Started

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd portfolio
   ```

2. **Set up the database**
   - Create a database named `portfolio_db`
   - Import the `database.sql` file
   - Update `config.php` with your local database credentials

3. **Configure your web server**
   - Point your web server to the project directory
   - Ensure PHP is enabled
   - Verify `.htaccess` is being processed (if using Apache)

4. **Access the site**
   - Portfolio: `http://localhost/portfolio/`
   - Admin: `http://localhost/portfolio/login.php`

## Coding Standards

### PHP Standards
- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding style
- Use meaningful variable and function names
- Add comments for complex logic
- Always use prepared statements for database queries
- Never expose sensitive information in error messages

### Security Best Practices
- **Always** use prepared statements (PDO) for database queries
- Validate and sanitize all user inputs
- Use `password_hash()` and `password_verify()` for passwords
- Implement CSRF protection for forms
- Use proper session management
- Never commit sensitive data (passwords, API keys, etc.)

### Database
- Use meaningful table and column names
- Always include proper indexes
- Document any schema changes
- Provide migration scripts for updates

### Frontend
- Keep JavaScript modular and organized
- Use semantic HTML5 elements
- Ensure responsive design works on all devices
- Test across different browsers
- Follow BEM or similar CSS methodology

## File Structure

```
portfolio/
├── index.php          # Main portfolio page
├── login.php          # Login page
├── admin.php          # Admin dashboard
├── logout.php         # Logout functionality
├── config.php         # Database configuration (DO NOT COMMIT)
├── styles.css         # All styling
├── database.sql       # Database schema
├── .gitignore         # Git ignore rules
├── README.md          # Project documentation
├── LICENSE            # License information
└── CONTRIBUTING.md    # This file
```

## Making Changes

### Before You Start
1. Create a new branch for your feature/fix
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. Ensure your local environment is working
3. Make sure you understand the existing code structure

### During Development
1. Write clean, readable code
2. Test your changes thoroughly
3. Ensure no PHP errors or warnings
4. Verify database queries are optimized
5. Test on multiple browsers/devices

### Committing Changes
1. Write clear, descriptive commit messages
   ```
   Add feature: Project image upload functionality

   - Implemented file upload validation
   - Added image resize functionality
   - Updated database schema
   - Added error handling
   ```

2. Keep commits focused and atomic
3. Reference issue numbers if applicable

### Submitting Changes
1. Push your branch to the repository
   ```bash
   git push origin feature/your-feature-name
   ```

2. Create a pull request with:
   - Clear description of changes
   - Screenshots (if UI changes)
   - Testing steps
   - Any breaking changes noted

## Testing Checklist

Before submitting your changes, verify:

- [ ] Code follows PSR-12 standards
- [ ] All PHP errors/warnings resolved
- [ ] Database queries use prepared statements
- [ ] User inputs are validated and sanitized
- [ ] No sensitive data in code or commits
- [ ] Responsive design works on mobile/tablet/desktop
- [ ] Cross-browser compatibility (Chrome, Firefox, Safari, Edge)
- [ ] Admin panel functionality works correctly
- [ ] Login/logout functionality works
- [ ] No console errors in browser
- [ ] Changes documented in commit message

## Common Issues

### Database Connection Fails
- Check `config.php` credentials
- Verify MySQL service is running
- Ensure database exists

### Session Issues
- Check PHP session configuration
- Verify session directory is writable
- Clear browser cookies

### Styling Not Applied
- Clear browser cache
- Check CSS file path
- Verify file permissions

## Feature Requests

Have an idea for a new feature? Great! Please:

1. Check if the feature has already been requested
2. Open an issue describing:
   - The problem it solves
   - Proposed solution
   - Any alternatives considered
3. Wait for discussion before implementing

## Bug Reports

Found a bug? Please report it with:

1. Clear description of the issue
2. Steps to reproduce
3. Expected behavior
4. Actual behavior
5. Screenshots if applicable
6. Environment details (PHP version, browser, OS)

## Code Review Process

All submissions require review. We look for:

- Code quality and standards compliance
- Security best practices
- Performance considerations
- Documentation and comments
- Test coverage

## Questions?

If you have questions about contributing:

1. Check existing documentation
2. Review closed issues/PRs for similar questions
3. Open a new issue with your question

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing to this project!
