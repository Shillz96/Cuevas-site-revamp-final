# Best Practices

## Coding Standards
- **JavaScript/TypeScript**:  
  - Use arrow functions for consistency (e.g., `const myFunc = () => {}`).  
  - Prefer interfaces over type aliases for TypeScript definitions.  
- **CSS**:  
  - Use BEM or a similar methodology for class naming (e.g., `.hero__title`).  
  - Leverage CSS variables for theme colors (e.g., `--western-brown: #8B4513`).  
- **WordPress**:  
  - Use `wp_enqueue_script` and `wp_enqueue_style` for loading assets.  
  - Follow WordPress coding standards for PHP (e.g., proper indentation, comments).  

## GSAP Usage
- Use the free GSAP core and ScrollTrigger for animations.  
- Optimize animations for performance, especially on mobile devices.  
- Test scroll-based triggers to ensure compatibility across devices.  

## Version Control
- Commit `.cursor/rules` files to maintain consistency across the team.  
- Use descriptive commit messages (e.g., "Add GSAP snap scrolling to home page"). 