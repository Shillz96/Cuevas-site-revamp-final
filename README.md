# Cuevas Western Wear - Website Redesign

This project involves cloning and completely redesigning the Cuevas Western Wear website using WordPress, Elementor, WooCommerce, and GSAP animations.

## Project Overview

The redesign aims to create a visually stunning, high-performance eCommerce store that reflects the western wear brand's identity while providing an exceptional user experience to increase sales.

## Project Structure

```
C:\Users\I7 8700k\Local Sites\Cuevas-site-revamp-final\
├── app/                          # WordPress core files
│   └── public/                   # Public WordPress directory
│       ├── wp-content/
│       │   ├── cuevas-custom-template/
│       │   │   └── hello-elementor-child/  # Our custom child theme
│       │   ├── plugins/          # WordPress plugins
│       │   └── uploads/          # Media uploads
├── conf/                         # Configuration files
├── logs/                         # Server logs
└── project-docs/                 # Project documentation
    ├── project-architecture.md   # Project architecture overview
    ├── dev-setup-instructions.md # Development setup guide
    ├── website-cloning-guide.md  # Guide for cloning the original website
    └── visual-design-and-animation-plan.md  # Design and animation specifications
```

## Tech Stack

- **CMS**: WordPress 6.7.2
- **Page Builder**: Elementor Pro
- **eCommerce**: WooCommerce
- **Animations**: GSAP (GreenSock Animation Platform)
- **Local Development**: Local by Flywheel

## Getting Started

### Prerequisites

- Local by Flywheel installed
- Elementor Pro license
- Basic knowledge of WordPress, PHP, and JavaScript

### Setup Instructions

1. Clone this repository or download it as a ZIP file
2. Follow the instructions in `dev-setup-instructions.md` to set up your local environment
3. Install all required plugins as listed in the setup instructions
4. Activate the Hello Elementor Child theme
5. Import the demo content (if available)

## Development Guidelines

### Code Standards

- Follow WordPress coding standards
- Use proper indentation and comments
- Keep files organized according to the structure outlined in `child-theme-structure.md`

### Workflow

1. Work on feature branches for significant changes
2. Test thoroughly before merging to main/master
3. Document all custom code and configurations
4. Optimize images before adding them to the project

### Performance Considerations

- Minimize the use of third-party plugins
- Optimize all images for the web
- Use caching and minification for CSS and JavaScript
- Implement lazy loading for images and videos

## Project Documentation

The following documentation files are available in the `project-docs` directory:

- **Project Architecture**: Overall architecture and structure
- **Development Setup**: Step-by-step guide for setting up the development environment
- **Website Cloning Guide**: Instructions for cloning the original website
- **Visual Design & Animation Plan**: Detailed design specifications and animation implementations

## Animation Implementation

GSAP animations are implemented in modular JavaScript files:

- `animations-global.js`: Global animations used across the site
- `animations-home.js`: Homepage-specific animations
- `animations-products.js`: Product page animations
- `animations-cart.js`: Cart and checkout animations

## WooCommerce Customization

WooCommerce templates are customized via:

- Child theme template overrides in the `woocommerce` directory
- Custom hooks and filters in `inc/woocommerce-hooks.php`
- Custom styles in `assets/css/woocommerce-custom.css`
- Custom JavaScript in `assets/js/woocommerce-custom.js`

## Elementor Templates

Custom Elementor templates are stored in the `elementor-templates` directory and can be imported into Elementor:

- Homepage template
- Product category template
- Single product template
- Checkout template

## Credits

- Original website: [Cuevas Western Wear](https://cuevaswesternwear.com/)
- Developer: [Your Name]
- Design: [Your Name/Team]

## License

This project is licensed under [appropriate license] - see the LICENSE file for details.

## Support

For questions or support, please contact [your contact information]. 