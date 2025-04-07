# Cuevas Theme Structure Documentation

## Overview

The Cuevas theme is a custom WordPress theme designed specifically for Cuevas Western Wear's eCommerce website. This document outlines the theme's structure, file organization, and development guidelines.

## Directory Structure

```
cuevas-theme/
├── assets/                 # Theme assets
│   ├── css/               # Stylesheets
│   │   ├── main.css      # Main stylesheet
│   │   ├── woocommerce.css # WooCommerce specific styles
│   │   └── widgets/      # Widget-specific styles
│   ├── js/               # JavaScript files
│   │   ├── animations/   # GSAP animation scripts
│   │   ├── custom/      # Custom JavaScript functionality
│   │   └── vendor/      # Third-party scripts
│   └── img/             # Theme images
├── inc/                  # Theme functionality
│   ├── components/       # Reusable PHP components
│   │   ├── headers/     # Header components
│   │   └── footers/     # Footer components
│   ├── widgets/         # Custom widgets
│   │   ├── product-showcase.php
│   │   └── featured-categories.php
│   ├── core/           # Core theme functions
│   │   ├── setup.php   # Theme setup and features
│   │   ├── enqueue.php # Script and style registration
│   │   └── menus.php   # Menu registration and setup
│   ├── customizer/     # Theme customizer settings
│   │   ├── colors.php
│   │   └── typography.php
│   └── helpers/        # Helper functions
│       ├── template.php
│       └── woocommerce.php
├── template-parts/      # Reusable template parts
│   ├── header/         # Header templates
│   ├── footer/         # Footer templates
│   ├── content/        # Content templates
│   │   ├── content.php
│   │   ├── content-page.php
│   │   └── content-product.php
│   └── components/     # Component templates
├── woocommerce/        # WooCommerce template overrides
│   ├── single-product/ # Single product templates
│   ├── archive-product/ # Product archive templates
│   ├── cart/          # Cart templates
│   └── checkout/      # Checkout templates
├── functions.php       # Theme functions and includes
├── style.css          # Theme stylesheet and metadata
├── index.php          # Main template file
├── header.php         # Header template
├── footer.php         # Footer template
└── screenshot.png     # Theme screenshot

## File Descriptions

### Core Theme Files

1. **style.css**
   - Theme metadata
   - Basic CSS reset
   - Core theme styles

2. **functions.php**
   - Theme setup and initialization
   - Include core functionality
   - Register features and supports

3. **index.php**
   - Main template file
   - Default template hierarchy fallback

### Asset Organization

1. **CSS Structure**
   - Modular approach with separate files for different components
   - Use of CSS custom properties for theme customization
   - Responsive breakpoints system

2. **JavaScript Organization**
   - Modular GSAP animations
   - Custom functionality in separate files
   - Third-party scripts managed separately

### Component System

1. **Template Parts**
   - Reusable header and footer variations
   - Content templates for different post types
   - Modular component templates

2. **PHP Components**
   - Reusable PHP functions and classes
   - Widget implementations
   - Helper functions

### WooCommerce Integration

1. **Template Overrides**
   - Custom product templates
   - Modified cart and checkout experience
   - Enhanced archive templates

2. **Custom Functionality**
   - Product showcase widgets
   - Custom product filters
   - Enhanced shopping features

## Development Guidelines

### Coding Standards

1. **PHP**
   - Follow WordPress PHP Coding Standards
   - Use proper documentation blocks
   - Implement proper error handling

2. **CSS**
   - Use BEM naming convention
   - Implement mobile-first approach
   - Maintain consistent spacing and organization

3. **JavaScript**
   - Use ES6+ features where appropriate
   - Implement proper error handling
   - Document complex functionality

### Best Practices

1. **Performance**
   - Optimize asset loading
   - Implement proper caching
   - Minimize database queries

2. **Security**
   - Validate and sanitize data
   - Use WordPress security functions
   - Implement proper capability checks

3. **Maintenance**
   - Keep documentation updated
   - Use version control effectively
   - Maintain changelog

## Theme Customization

### Customizer Options

1. **Colors**
   - Primary and secondary colors
   - Background colors
   - Text colors

2. **Typography**
   - Font families
   - Font sizes
   - Line heights

### Layout Options

1. **Header Layouts**
   - Multiple header styles
   - Mobile menu options
   - Sticky header settings

2. **Footer Layouts**
   - Widget areas
   - Copyright section
   - Newsletter integration

## Support and Updates

### Documentation Updates

- Keep this document updated with any structural changes
- Document new features and components
- Maintain changelog in separate file

### Support Resources

- Internal development team contact
- External resources and references
- Troubleshooting guides

# Theme Development Plan

## Current Issues and Solutions

### 1. Missing Core Files
- Create essential WordPress template files
- Set up proper theme initialization
- Implement template hierarchy

### 2. GSAP Integration
- Set up proper script loading
- Create animation initialization system
- Implement performance optimizations

### 3. Structure Reorganization
- Convert HTML widgets to PHP
- Complete WooCommerce integration
- Organize template parts properly

## Implementation Steps

### Phase 1: Core Theme Setup

1. **Create Essential Files**
   ```
   cuevas-theme/
   ├── functions.php           # Theme setup and functionality
   ├── index.php              # Main template file
   ├── header.php             # Header template
   ├── footer.php             # Footer template
   ├── sidebar.php            # Sidebar template
   ├── 404.php               # 404 error page
   ├── archive.php           # Archive template
   ├── single.php            # Single post template
   ├── page.php              # Page template
   └── search.php            # Search results template
   ```

2. **Theme Initialization**
   - Register theme support features
   - Set up navigation menus
   - Register widget areas
   - Configure image sizes

### Phase 2: GSAP Integration

1. **Script Management**
   ```php
   // functions.php
   function cuevas_enqueue_scripts() {
       // GSAP Core
       wp_enqueue_script('gsap-core', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true);
       
       // GSAP Plugins
       wp_enqueue_script('gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap-core'], '3.12.5', true);
       
       // Custom animations
       wp_enqueue_script('cuevas-animations', get_template_directory_uri() . '/assets/js/animations/init.js', ['gsap-core', 'gsap-scroll-trigger'], '1.0.0', true);
   }
   ```

2. **Animation Structure**
   ```
   assets/js/animations/
   ├── init.js               # GSAP initialization
   ├── global.js            # Global animations
   ├── home.js              # Homepage animations
   ├── product.js           # Product page animations
   └── components/          # Reusable animation components
   ```

### Phase 3: Template Organization

1. **Template Parts**
   ```
   template-parts/
   ├── header/             # Header variations
   │   ├── default.php
   │   └── transparent.php
   ├── footer/             # Footer variations
   ├── content/            # Content templates
   │   ├── content.php
   │   ├── content-page.php
   │   └── content-product.php
   └── components/         # Reusable components
   ```

2. **WooCommerce Integration**
   ```
   woocommerce/
   ├── single-product/     # Single product templates
   ├── archive-product/    # Product archive templates
   ├── cart/              # Cart templates
   ├── checkout/          # Checkout templates
   └── global/            # Global templates
   ```

3. **Widget Conversion**
   ```
   inc/widgets/
   ├── class-deal-timer.php
   ├── class-featured-product.php
   ├── class-heritage-story.php
   └── class-western-style.php
   ```

### Phase 4: Asset Organization

1. **CSS Structure**
   ```
   assets/css/
   ├── main.css           # Main styles
   ├── woocommerce.css    # WooCommerce styles
   ├── animations.css     # Animation styles
   └── components/        # Component styles
   ```

2. **JavaScript Structure**
   ```
   assets/js/
   ├── animations/        # GSAP animations
   ├── components/       # Component scripts
   └── vendor/          # Third-party scripts
   ```

## Implementation Priority

1. Core Theme Files (Essential for functionality)
2. GSAP Integration (Required for animations)
3. Template Organization (Improves maintainability)
4. Asset Organization (Optimizes performance)

## Development Guidelines

### 1. File Naming
- Use hyphen-case for file names
- Prefix functions and classes with `cuevas_`
- Use descriptive names for templates

### 2. Code Organization
- Follow WordPress coding standards
- Use proper documentation blocks
- Implement modular functionality

### 3. Performance
- Optimize GSAP animations
- Minimize asset loading
- Use proper caching

### 4. Testing
- Test all templates
- Verify GSAP animations
- Check mobile responsiveness

## Next Steps

1. Create missing core files
2. Set up GSAP integration
3. Convert HTML widgets to PHP
4. Organize template structure

Would you like me to start implementing any of these changes? 