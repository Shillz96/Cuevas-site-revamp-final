# Cloning Guide - Cuevas Western Wear Website

This document outlines the step-by-step process for cloning the [Cuevas Western Wear](https://cuevaswesternwear.com/) website to our local development environment and setting it up for redesign.

## Prerequisites

### Local Server Configuration
- **Web Server**: nginx
- **PHP Version**: 8.2.27
- **Database**: MySQL 8.0.35
- **WordPress Version**: 6.7.2
- **Site URL**: localhost:10005
- **SSL Status**: HTTPS not available in localhost Routing Mode

### Required Access
- Local by Flywheel installed
- Admin access to the original website (optional, but helpful)
- FTP access to the original website (if available)
- Administrator privileges on your local machine

### Development Environment
The local development environment is set up at:
```
C:\Users\I7 8700k\Local Sites\Cuevas-site-revamp-final
```

## Method 1: Using a WordPress Migration Plugin

### 1. Set Up the Local WordPress Site

1. Create a new site in Local by Flywheel:
   - Site Name: `Cuevas-site-revamp-final` (already set up at `C:\Users\I7 8700k\Local Sites\Cuevas-site-revamp-final`)
   - Environment: Custom (PHP 8.2, MySQL 8.0)
   - WordPress Username/Password: As configured

2. Access the local WordPress installation at `https://localhost:10011`

### 2. Install and Configure Migration Plugin

1. In the local WordPress admin, go to Plugins > Add New
2. Search for and install "All-in-One WP Migration" or "Duplicator"
3. Activate the plugin

### 3. Export from Live Site

1. Install the same migration plugin on the live Cuevas Western Wear site
2. Generate an export file that contains:
   - Database
   - Media files
   - Themes
   - Plugins
   - WordPress settings

3. Download the export file to your local computer

### 4. Import to Local Site

1. Go to your local WordPress admin
2. Use the migration plugin to import the downloaded file
3. The plugin will replace your local database and files with the content from the live site
4. Update site URL settings as needed

## Method 2: Manual Cloning

If plugin-based migration isn't possible, you can manually clone the site:

### 1. Database Export/Import

1. Export the database from the live site:
   - Access phpMyAdmin on the live server
   - Select the database and export as SQL
   - Download the SQL file

2. Import the database to local installation:
   - Access phpMyAdmin at http://localhost:10010
   - Select the `local` database
   - Import the downloaded SQL file
   - Replace all instances of the live URL with local URL in the database

### 2. File Transfer

1. Download files from the live site:
   - Connect via FTP
   - Download the `wp-content` folder (themes, plugins, uploads)

2. Upload to local installation:
   - Replace the `wp-content` folder in your local WordPress installation with the downloaded one

### 3. Configuration Update

1. Edit the `wp-config.php` file if necessary
2. Update database connection details if they differ
3. Update site and home URL in the `wp_options` table

## Method 3: Using Local by Flywheel's Import Feature

If you have access to a full backup of the site:

1. In Local by Flywheel, click "Import site"
2. Select the ZIP archive containing the backup
3. Follow the prompts to complete the import

## Post-Cloning Steps

After successfully cloning the website, perform these steps:

1. **Clear cache**: Delete any caching data from the original site
2. **Update permalinks**: Go to Settings > Permalinks and save (no changes needed)
3. **Test functionality**: Check that the site works correctly
4. **Install/activate required plugins**: Make sure Elementor, WooCommerce, etc. are active
5. **Check for broken links or images**: Fix any issues related to URL changes

## Preparing for Redesign

1. Create a backup of the cloned site before starting redesign
2. Document the existing site structure and content
3. Identify elements to keep vs. elements to redesign
4. Set up version control for the project
5. Create a staging environment for client review

## Troubleshooting Common Issues

### URLs Not Updating

If site URLs aren't updating properly, run these SQL queries in phpMyAdmin:

```sql
UPDATE wp_options SET option_value = replace(option_value, 'https://cuevaswesternwear.com', 'https://localhost:10011') WHERE option_name = 'home' OR option_name = 'siteurl';
UPDATE wp_posts SET post_content = replace(post_content, 'https://cuevaswesternwear.com', 'https://localhost:10011');
UPDATE wp_postmeta SET meta_value = replace(meta_value, 'https://cuevaswesternwear.com', 'https://localhost:10011');
```

### Missing Media Files

If media files are missing:
1. Check if the `uploads` folder was properly transferred
2. Verify file permissions
3. Check for hard-coded URLs in content

### Plugin Conflicts

If you encounter plugin conflicts:
1. Deactivate all plugins
2. Reactivate them one by one to identify the problematic plugin
3. Look for alternative plugins if needed 