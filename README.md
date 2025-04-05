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