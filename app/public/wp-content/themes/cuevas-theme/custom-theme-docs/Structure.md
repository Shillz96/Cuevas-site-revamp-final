# Project Structure

## Overview
The project follows a standard WordPress theme structure with additional directories for custom rules and assets.

## Directory Layout
- `/wp-content/themes/your-theme-name/`  
  - `assets/`  
    - `css/` - Compiled CSS files (e.g., `style.min.css`)  
    - `js/` - JavaScript files, including GSAP scripts (e.g., `scripts.js`)  
    - `images/` - Theme images (e.g., hero backgrounds, product placeholders)  
  - `inc/` - Includes for theme functions (e.g., `custom-functions.php`)  
  - `templates/` - Custom page templates (e.g., `page-home.php`)  
  - `woocommerce/` - Overrides for WooCommerce templates (e.g., `single-product.php`)  
  - `.cursor/rules/` - Project-specific rules for AI behavior  
  - `functions.php` - Theme setup and custom functions  
  - `style.css` - Main stylesheet with theme metadata (e.g., Theme Name, Author)  
  - `header.php`, `footer.php`, etc. - Standard WordPress template parts  

## Key Files
- `page-home.php`: Custom template for the home page with hero and gallery sections.  
- `js/scripts.js`: Contains GSAP animations and other JavaScript logic.  
- `.cursor/rules/*.md`: Rules for AI behavior, applied to specific file types or folders. 