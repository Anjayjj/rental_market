# Deployment Guide - InfinityFree

## Prerequisites
- A GitHub account with the `rental_market` repository
- An InfinityFree account with a hosted website
- A MySQL database created on InfinityFree

## Step 1: Prepare the Database
1. Log in to your InfinityFree cPanel
2. Go to **MySQL Databases** and create a new database and user
3. Note the database name, username, and password
4. Import `database_schema.sql` via **phpMyAdmin** to create all tables

## Step 2: Update Configuration
Edit `app/config/config.php` and update the following:

```php
// Change BASEURL to your InfinityFree domain (auto-detected, but verify)
// Change database credentials to match your InfinityFree MySQL setup
define('DB_HOST', 'localhost');        // InfinityFree MySQL host
define('DB_USER', 'your_db_username');  // Your InfinityFree MySQL username
define('DB_PASS', 'your_db_password');  // Your InfinityFree MySQL password
define('DB_NAME', 'your_db_name');      // Your InfinityFree database name
```

## Step 3: Upload Files to InfinityFree
1. Connect to your InfinityFree hosting via **FTP** (FileZilla or Cyberduck)
2. Navigate to `public_html/` (this is your web root)
3. Upload the entire project, ensuring the following structure:

```
public_html/
├── index.php              ← Front controller (auto-generated)
├── .htaccess              ← URL rewriting rules (auto-generated)
├── app/                   ← Application code (protected by .htaccess)
│   ├── .htaccess          ← Blocks web access to app directory
│   ├── config/
│   ├── controllers/
│   ├── core/
│   ├── init.php
│   ├── models/
│   └── views/
├── public/
│   ├── index.php          ← Front controller (redirects to app/)
│   ├── .htaccess          ← URL rewriting for public/
│   └── assets/
│       ├── css/
│       └── uploads/
├── database_schema.sql    ← SQL schema (optional, for reference)
└── DEPLOYMENT.md          ← This file
```

### Important: Directory Structure
InfinityFree's web root is `public_html/`. You have two options:

**Option A (Recommended):** Upload everything directly to `public_html/`
- The `app/` directory will be at `public_html/app/`
- The `public/` directory will be at `public_html/public/`
- Assets will be accessible at `yoursite.com/public/assets/...`

**Option B:** Use `public/` as the web root
- In cPanel, set the document root of your domain to point to `public_html/public/`
- This makes assets accessible at `yoursite.com/assets/...` (cleaner URLs)
- Requires InfinityFree plan that supports custom document roots

## Step 4: Verify .htaccess
Make sure `mod_rewrite` is enabled on your InfinityFree hosting. The `.htaccess` files should handle URL rewriting automatically.

Test by visiting `yoursite.com/item/detail/some-item-slug` — it should route through `index.php`.

## Step 5: Set File Permissions
Via FTP or cPanel File Manager, set these permissions:
- `app/config/config.php` — `644` (readable by web server, not writable)
- `public/assets/uploads/` — `755` (web server needs write access for uploads)
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
- Consider adding `.env` support for credentials in production
