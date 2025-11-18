# 🔐 PORTFOLIO SHOWCASE SYSTEM

A beautiful, secure portfolio showcase for recruiters and clients with access code protection.

## 📁 Files Created

1. **portfolio-access.php** - Secure login page with access code
2. **portfolio-gallery.php** - Grid gallery showing all projects
3. **portfolio-project.php** - Individual project case study pages
4. **portfolio-logout.php** - Logout functionality

## 🔑 Default Access Codes

You can share these codes with recruiters:

- `RECRUITER2025`
- `PORTFOLIO2025`
- `VIEWWORK`

**To change codes:** Edit the `$valid_codes` array in `portfolio-access.php`

## 🎨 Features

### Portfolio Access Page
- Beautiful dark theme with gradient effects
- Lock icon and professional messaging
- Secure access code system
- Mobile responsive

### Portfolio Gallery
- Grid layout of all projects
- Animated cards with hover effects
- Project numbers and categories
- Click to view full case studies

### Project Pages
- Full-screen hero with project details
- Image gallery grid (5 placeholder images)
- Challenge / Solution / Results sections
- Tech stack display
- Beautiful typography and spacing
- Smooth animations

## 🚀 How To Use

### For You:
1. Visit `http://localhost:8000/portfolio-access.php`
2. Enter any of the access codes above
3. Browse the gallery and click projects to see detailed pages

### For Recruiters:
Share this link and access code:
```
URL: https://yoursite.com/portfolio-access.php
Access Code: RECRUITER2025
```

## 📸 Adding Real Images

Currently using placeholder gradients. To add real images:

### Option 1: Database Field
Add an `images` column to the projects table:
```sql
ALTER TABLE projects ADD COLUMN images TEXT;
-- Store JSON array: ["img1.jpg", "img2.jpg"]
```

### Option 2: File System
Create `/uploads/projects/` folder structure:
```
/uploads/projects/
  /1/  (project ID)
    - hero.jpg
    - screenshot1.jpg
    - screenshot2.jpg
```

### Option 3: Update Manually
Edit `portfolio-project.php` and replace placeholder divs with:
```php
<img src="/uploads/project-<?php echo $project_id; ?>-img1.jpg" alt="">
```

## 🎯 Customization

### Change Access Codes
Edit `portfolio-access.php` line ~17:
```php
$valid_codes = [
    'YOURCUSTOMCODE',
    'ANOTHER-CODE'
];
```

### Add More Project Details
Edit the `$projectDetails` array in `portfolio-project.php` with real content for each project.

### Change Colors
Primary colors in CSS:
- Purple: `#6366f1`
- Pink: `#ec4899`
- Update these throughout the CSS

## 🔒 Security Features

- Session-based access control
- No passwords stored in database
- Simple access code system (easy to share, easy to change)
- Auto-logout on browser close
- Protected pages redirect to login if not authenticated

## 💡 Pro Tips

1. **Multiple Codes**: Create different codes for different clients/recruiters to track who's viewing

2. **Expiring Codes**: Add this to `portfolio-access.php`:
```php
$code_expiry = [
    'TEMP-CODE-123' => '2025-12-31'
];
```

3. **Analytics**: Add view tracking to see which projects get most attention

4. **Download PDF**: Add a "Download PDF" button to generate case study PDFs

## 📱 Mobile Responsive

All pages are fully responsive and look great on:
- Desktop
- Tablet  
- Mobile phones

## 🎨 Design Features

- Dark theme (professional, modern)
- Playfair Display (elegant serif for headers)
- Inter (clean sans-serif for body)
- Gradient accents
- Smooth animations
- Glassmorphism effects
- Professional spacing

## 🚀 Next Steps

1. Add your real project images
2. Write detailed case study content
3. Customize access codes
4. Share with recruiters!

---

**Access the system:**
- Login: `http://localhost:8000/portfolio-access.php`
- Gallery: (auto-redirects after login)
- Logout: Click logout button in header

**Looking impressive and professional!** ✨
