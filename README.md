# Cuevas Western Wear - Website Rebuild

This project is a complete rebuild of the Cuevas Western Wear website using WordPress, focusing on modern eCommerce functionality with WooCommerce, Elementor Pro, and custom GSAP animations.

## Project Overview

We are recreating the Cuevas Western Wear website with enhanced features, better performance, and improved user experience. The project includes a complete WordPress setup, custom theme development, and full eCommerce functionality with sophisticated animations.

## Project Structure

```
Cuevas-site-revamp-final/
├── app/                            # WordPress installation
│   └── public/                    # Public WordPress files
│       ├── wp-admin/             # WordPress admin
│       ├── wp-content/           # Themes, plugins, and uploads
│       │   ├── themes/          # WordPress themes
│       │   │   └── cuevas-theme/    # Our custom theme
│       │   │       ├── assets/     # Theme assets
│       │   │       │   ├── js/    # JavaScript files
│       │   │       │   │   ├── about-animations.js    # About page animations
│       │   │       │   │   ├── animations.js          # Global animations
│       │   │       │   │   ├── hero-customizer.js     # Hero section customization
│       │   │       │   │   ├── home-animations.js     # Homepage animations
│       │   │       │   │   ├── navigation.js          # Navigation functionality
│       │   │       │   │   └── product-page.js        # Product page interactions
│       │   │       │   ├── css/   # Stylesheets
│       │   │       │   └── img/   # Theme images
│       │   │       └── template-parts/  # Theme templates
│       │   ├── plugins/        # WordPress plugins
│       │   └── uploads/        # Media uploads
│       └── wp-includes/        # WordPress core
├── conf/                         # Server configuration
├── logs/                        # Server logs
└── project-docs/                # Project documentation
```

## Tech Stack

- **CMS**: WordPress
- **Page Builder**: Elementor Pro
- **eCommerce**: WooCommerce
- **Custom Theme**: Custom-built WordPress theme
- **Animations**: GSAP (GreenSock Animation Platform)
  - ScrollTrigger plugin
  - SplitText plugin
  - ScrollToPlugin
- **Development Environment**: Local by Flywheel

## Key Features

1. **Advanced Animations**
   - Smooth page transitions
   - Scroll-triggered animations
   - Interactive product displays
   - Text reveal effects
   - Parallax scrolling
   - Custom hero section animations

2. **eCommerce Functionality**
   - Enhanced product displays
   - Custom category layouts
   - Optimized checkout process
   - Inventory management

3. **Custom Theme Development**
   - Responsive design
   - Custom WooCommerce templates
   - Elementor integrations
   - Modular JavaScript architecture

4. **Performance Optimizations**
   - Optimized GSAP animations
   - Image optimization
   - Caching setup
   - Asset management

## JavaScript Architecture

Our theme includes several specialized JavaScript modules:

1. **animations.js**
   - Global animation configurations
   - Common animation utilities
   - Header and footer animations

2. **home-animations.js**
   - Homepage-specific animations
   - Featured product slider
   - Section transitions

3. **about-animations.js**
   - Timeline animations
   - Craftsmanship section effects
   - Trust badges animation
   - Brand story parallax

4. **product-page.js**
   - Product gallery interactions
   - Price slider functionality
   - Mobile sidebar handling
   - Responsive behaviors

5. **hero-customizer.js**
   - Hero section customization
   - Overlay opacity controls

6. **navigation.js**
   - Mobile menu functionality
   - Menu toggle animations
   - Click event handling

## Development Setup

1. **Local Environment**
   ```bash
   git clone https://github.com/Shillz96/Cuevas-site-revamp-final.git
   ```
   - Local by Flywheel configuration
   - WordPress core setup
   - Database initialization

2. **Required Plugins**
   - Elementor Pro
   - WooCommerce
   - GSAP (included in theme)
   - Additional optimization plugins

3. **Theme Development**
   - Custom theme setup
   - WooCommerce integration
   - GSAP animation implementation

## Documentation

See the `project-docs` directory for detailed documentation:

1. **Development Setup**: `dev-setup-instructions.md`
2. **Project Architecture**: `project-architecture.md`
3. **Design Specifications**: `visual-design-and-animation-plan.md`
4. **Project Status**: `project-summary.md`

## License

This project is proprietary and confidential. Unauthorized copying or distribution of this project's files, via any medium, is strictly prohibited.

## Support

For development questions or support, please contact the development team.

## Theme Structure

The theme follows a standard WordPress structure, with enhancements for organization:

- **`/` (Root):** Contains standard template files (`index.php`, `page.php`, `single.php`, `archive.php`, `header.php`, `footer.php`, `style.css`, etc.).
- **`functions.php`:** Main functions file, kept minimal. Includes files from the `/inc` directory.
- **`/inc`:** Contains modular PHP files for theme functionality:
  - `theme-setup.php`: Theme support, nav menus, image sizes.
  - `enqueue.php`: Script and style enqueueing (including GSAP).
  - `template-tags.php`: Custom functions for use in templates.
  - `woocommerce.php`: WooCommerce specific hooks and functions.
  - `wp-cli.php`: Custom WP-CLI command registration and logic.
  - `helpers.php`: General utility functions.
  - `debug.php`: Debugging utility functions (conditionally loaded).
- **`/template-parts`:** Holds reusable template partials (e.g., `content-page.php`, `content-post.php`) included via `get_template_part()`.
- **`/assets`:** Contains all front-end assets:
  - `/css`: Stylesheets.
    - `animations.css`: Initial states and structural CSS specifically for GSAP animations.
  - `/js`: JavaScript files.
    - `main-animations.js`: All custom GSAP animation logic.
  - `/images`: Theme images.
  - `/fonts`: Theme fonts.
- **`/woocommerce`:** Contains WooCommerce template overrides.
- **`.cursorules/`**: Contains rules for the Cursor AI assistant to help maintain code standards.
  - `gsap-wordpress-structure.mdc`: Rules specifically for GSAP integration and code separation.

## GSAP Integration

GSAP animations are handled following best practices for WordPress integration:

1.  **Enqueueing:** GSAP library and the custom `main-animations.js` script are enqueued via `inc/enqueue.php`.
2.  **Styling:** Initial states for animated elements are defined in `assets/css/animations.css`.
3.  **Animation Logic:** All GSAP tweens, timelines, and ScrollTrigger instances reside in `assets/js/main-animations.js`.
4.  **HTML Structure:** PHP templates output the necessary HTML with classes/IDs targeted by the JavaScript.

## Custom WP-CLI Commands

Custom WP-CLI commands are defined in `inc/wp-cli.php`. Refer to the code comments within that file for usage details. 