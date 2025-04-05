# Global Rules

Before diving into specific templates, here are the global rules applied across all pages:

## Classy Western Color Scheme
- **Background**: #F5F5DC (Beige) - A soft, warm base reminiscent of parchment or leather.
- **Text**: #3E2723 (Dark Brown) - A rich, earthy tone for readability and western flair.
- **Accents**: #8B4513 (Saddle Brown) - For borders, icons, or highlights.
- **Buttons/Links**: #A52A2A (Brown Red) - A bold yet classy call-to-action color.
- **Secondary Accent**: #D2691E (Chocolate) - For hover effects or subtle highlights.

These colors can be customized via the WordPress Customizer for flexibility.

## Full Page Width
All pages use `width: 100vw` and remove sidebars to ensure a full-width layout.

## Hamburger Menu
A clean, responsive hamburger menu replaces the traditional navigation bar across all pages. It's implemented globally in `header.php`.

## Cursor Rules
A set of CSS rules to enhance interactivity:

```css
/* Default cursor for non-interactive elements */
body {
  cursor: default;
}

/* Pointer for clickable elements */
a, button, .clickable {
  cursor: pointer;
}

/* Custom hover effect for specific sections (optional) */
.gallery-item:hover, .product:hover, .button:hover {
  cursor: url('/path/to/custom-cursor.png'), pointer; /* Optional: Add a western-themed cursor image */
}
```

These rules ensure the cursor indicates interactivity clearly, with an optional custom cursor for theme enhancement. 