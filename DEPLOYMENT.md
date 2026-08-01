# Deployment Guide - InfinityFree

## Prerequisites
- A GitHub account with the `rental_market` repository
- An InfinityFree account with a hosted website
- A MySQL database created on InfinityFree

## Step 1: Prepare the Database
1. Log in to your InfinityFree cPanel
2. Go to **MySQL Databases** and create a new database and user
3. Note the database name, username, and password
4. Import your existing database backup via **phpMyAdmin**

## Step 2: Update Configuration
Edit `app/config/config.php` and update the database credentials:

```php
define('DB_HOST', 'localhost');         // InfinityFree MySQL host
define('DB_USER', 'your_db_username');  // Your InfinityFree MySQL username
define('DB_PASS', 'your_db_password');  // Your InfinityFree MySQL password
define('DB_NAME', 'your_db_name');      // Your InfinityFree database name
```

The `BASEURL` is auto-detected from the current request — no manual update needed.

## Step 3: Upload Files to InfinityFree
1. Connect to your InfinityFree hosting via **FTP** (FileZilla or Cyberduck)
2. Navigate to your **web root directory** — it could be any of these:
   - `public_html/` (most common)
   - `htdocs/`
   - `www/`
   - `httpdocs/`
3. Upload the entire project, ensuring the following structure:

```
<web_root>/
├── index.php              ← Front controller
├── .htaccess              ← URL rewriting rules
├── .gitignore             ← Excludes sensitive files
├── assets/                ← CSS, JS, uploads (images, avatars)
│   ├── css/
│   │   └── style.css
│   └── uploads/
│       ├── avatars/
│       └── items/
├── app/                   ← Application code (protected by .htaccess)
│   ├── .htaccess          ← Blocks web access to app directory
│   ├── config/
│   │   └── config.php     ← Edit DB credentials here
│   ├── controllers/
│   ├── core/
│   ├── init.php
│   ├── models/
│   └── views/
└── DEPLOYMENT.md          ← This file
```

> **Note:** If your hosting uses `htdocs` instead of `public_html`, simply upload to the `htdocs/` folder instead. The structure is the same.

## Step 4: Verify .htaccess
Make sure `mod_rewrite` is enabled on your InfinityFree hosting. The `.htaccess` file handles URL rewriting automatically.

Test by visiting `yoursite.com/item/detail/some-item-slug` — it should route through `index.php`.

## Step 5: Set File Permissions
Via FTP or cPanel File Manager, set these permissions:
- `app/config/config.php` — `644` (readable by web server, not writable)
- `assets/uploads/` — `755` (web server needs write access for uploads)
- All other directories — `755`
- All other files — `644`

## Step 6: Test the Deployment
1. Visit your domain in a browser
2. Check that the homepage loads
3. Try navigating to a few pages (e.g., `/home/explore`, `/auth/login`)
4. Verify that database connections work (try creating a test booking)
5. Check that file uploads work (try uploading an item image)

## Troubleshooting
- **White page**: Check PHP error logs in cPanel → Errors
- **Database connection failed**: Verify DB credentials in `app/config/config.php`
- **404 on all pages**: Ensure `mod_rewrite` is enabled and `.htaccess` is being read
- **CSS not loading**: Verify `BASEURL` is correct and assets are in the right path
- **500 Internal Server Error**: Check `.htaccess` syntax and file permissions

## Security Notes
- The `app/` directory is protected by `.htaccess` (Deny from all)
- `config.php` contains database credentials — never expose it publicly
- Change the default `DB_HOST`/`DB_USER`/`DB_PASS` after deployment
