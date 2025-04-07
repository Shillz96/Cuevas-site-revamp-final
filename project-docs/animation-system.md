# GSAP Animation System Documentation

## Overview
The theme uses GSAP (GreenSock Animation Platform) for smooth, performant animations throughout the site. This document outlines the animation system implementation and usage.

## Core Setup

### Included Libraries
```javascript
- GSAP Core (3.12.5)
- ScrollTrigger Plugin
- SplitText Plugin
```

### Configuration
```javascript
// Default GSAP configuration
gsap.config({
    nullTargetWarn: false,
    autoSleep: 60,
    force3D: true
});

// ScrollTrigger defaults
ScrollTrigger.config({
    autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load,resize'
});
```

## Utility Functions

### Staggered Animations
```javascript
window.createStaggerAnimation(elements, fromVars = {}, toVars = {})

// Example usage:
createStaggerAnimation('.products li', {
    opacity: 0,
    y: 30,
    duration: 0.8,
    stagger: {
        amount: 0.5,
        grid: 'auto'
    }
});
```

### Text Reveal
```javascript
window.createTextReveal(element, options = {})

// Example usage:
createTextReveal('.hero-title', {
    y: 30,
    opacity: 0,
    duration: 1.2,
    stagger: 0.05
});
```

## Page-Specific Animations

### Homepage
```javascript
- Hero section reveal
- Product grid stagger
- Category card animations
- Promotional section parallax
```

### Product Pages
```javascript
- Product image gallery
- Custom field reveals
- Add to cart animations
- Related products slider
```

### Category Pages
```javascript
- Hero section parallax
- Filter animation
- Product grid reveal
- Subcategory card animations
```

## Animation Guidelines

### Performance Best Practices
1. Use `will-change` sparingly
2. Implement mobile-specific animations
3. Reduce animation complexity on slower devices
4. Use `force3D: true` for better performance

### Responsive Considerations
```javascript
// Animation configuration based on screen size
const config = {
    mobile: {
        duration: 0.5,
        distance: 20
    },
    desktop: {
        duration: 0.8,
        distance: 30
    }
};
```

### Animation Timing
```javascript
// Standard timing values
const timing = {
    fast: 0.3,
    normal: 0.5,
    slow: 0.8,
    stagger: 0.1
};
```

## Implementation Examples

### Product Grid Animation
```javascript
gsap.from('.products li', {
    opacity: 0,
    y: 30,
    duration: 0.8,
    stagger: {
        amount: 0.5,
        grid: 'auto'
    },
    scrollTrigger: {
        trigger: '.products',
        start: 'top 80%',
        toggleActions: 'play none none reverse'
    }
});
```

### Hero Section Animation
```javascript
gsap.timeline()
    .from('.hero-title', {
        opacity: 0,
        y: 50,
        duration: 1
    })
    .from('.hero-subtitle', {
        opacity: 0,
        y: 30,
        duration: 0.8
    }, '-=0.5')
    .from('.hero-cta', {
        opacity: 0,
        y: 20,
        duration: 0.5
    }, '-=0.3');
```

## Debugging

### Common Issues
1. **Animation Flickering**
   - Check transform-style
   - Verify z-index stacking
   - Monitor GPU usage

2. **Performance Issues**
   - Reduce animation complexity
   - Implement will-change
   - Check timeline nesting

3. **Mobile Issues**
   - Verify touch events
   - Check viewport units
   - Monitor memory usage

### Debug Mode
```javascript
// Enable debug mode
gsap.config({
    debug: true
});
```

## Animation Classes

### CSS Helper Classes
```css
.animate-in {
    opacity: 0;
    transform: translateY(20px);
}

.animate-fade {
    opacity: 0;
}

.animate-scale {
    transform: scale(0.95);
}
```

### JavaScript Triggers
```javascript
// Automatic animation based on class
document.querySelectorAll('.animate-in').forEach(element => {
    gsap.to(element, {
        opacity: 1,
        y: 0,
        duration: 0.8,
        scrollTrigger: {
            trigger: element
        }
    });
});
```

## Custom Animations

### Adding New Animations
1. Create animation function
2. Add to appropriate template
3. Configure ScrollTrigger
4. Test performance

### Template Integration
```php
// Add to wp_footer
add_action('wp_footer', function() {
    ?>
    <script>
        // Your animation code
    </script>
    <?php
}, 20);
```

## Testing Checklist
- [ ] Animations work on all browsers
- [ ] Mobile performance is smooth
- [ ] No layout shifts
- [ ] Proper fallbacks exist
- [ ] ScrollTrigger positions are correct 