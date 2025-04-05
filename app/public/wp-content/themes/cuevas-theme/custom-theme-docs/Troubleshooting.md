# Troubleshooting

## Common Issues

### GSAP Animations Not Triggering
- **Cause**: GSAP or ScrollTrigger not loaded.  
- **Fix**: Ensure they are enqueued in `functions.php` (e.g., `wp_enqueue_script('gsap', 'path/to/gsap.min.js')`).  
- **Check**: Verify container and trigger elements are correctly selected in `scripts.js`.

### WooCommerce Templates Not Overriding
- **Cause**: Incorrect directory or file names.  
- **Fix**: Confirm the `woocommerce` folder is in the theme root and matches WooCommerce's template structure (e.g., `woocommerce/single-product.php`).  

### Cursor Rules Not Applying
- **Cause**: Misconfigured file paths or glob patterns.  
- **Fix**: Ensure rules are in `.cursor/rules/` and check for typos in paths or `@file` references.  

## Debugging Tips
- Use browser dev tools to inspect GSAP timelines and scroll positions.  
- Enable WordPress debug mode (`define('WP_DEBUG', true);` in `wp-config.php`) to catch PHP errors.  
- Review the Cursor documentation for rule syntax and troubleshooting. 