# Monitor and Fix Rules

## Overview
This file defines rules for monitoring browser logs through BrowserTools MCP and autonomously fixing errors in the Cuevas Western Wear theme. The AI model can identify, diagnose, and resolve common errors without requiring user intervention.

## Server Configuration
```json
{
  "mcp.server": "http://localhost:3000",
  "mcp.autoConnect": true,
  "mcp.logLevel": "debug"
}
```

## Error Monitoring

### Autonomous Behavior
- Monitor console logs and errors via BrowserTools MCP
- Identify issues with at least 90% confidence
- Fix issues automatically without user confirmation when confidence is high
- Log unfixable issues to `unfixable_errors.log`

### Console Error Categories
1. **JavaScript Syntax Errors**
   - Missing semicolons
   - Unclosed brackets/parentheses
   - Undefined variables
   - Invalid function calls

2. **GSAP-related Errors**
   - Missing GSAP libraries
   - Invalid animation properties
   - Timeline errors
   - ScrollTrigger configuration issues

3. **WooCommerce Integration Issues**
   - Template override compatibility
   - Hook conflicts
   - AJAX errors
   - Cart functionality issues

4. **CSS Issues**
   - Missing or invalid selectors
   - Media query problems
   - Specificity conflicts
   - Layout breaks

5. **Asset Loading Errors**
   - 404 errors for scripts/styles
   - Loading order issues
   - Dependency conflicts
   - WP enqueue problems

## Error-Fixing Procedures

### JavaScript Error Resolution
1. **Undefined Variable**
   ```javascript
   // Error: Uncaught ReferenceError: hamburger is not defined
   // Fix: Ensure the element exists before trying to access it
   const hamburger = document.querySelector('.hamburger');
   if (hamburger) {
     hamburger.addEventListener('click', toggleMenu);
   }
   ```

2. **GSAP Library Missing**
   ```javascript
   // Error: Uncaught ReferenceError: gsap is not defined
   // Fix: Check if GSAP is loaded before using it
   if (typeof gsap !== 'undefined') {
     gsap.registerPlugin(ScrollTrigger);
     // Continue with GSAP functionality
   } else {
     console.warn('GSAP not loaded. Animations will not work.');
   }
   ```

3. **Invalid Animation Properties**
   ```javascript
   // Error: Invalid property 'rotation' in GSAP animation
   // Fix: Check for valid properties and provide fallbacks
   gsap.to('.element', {
     x: 100,
     y: 50,
     // Fix invalid 'rotation' to 'rotate'
     rotate: 45,
     duration: 1
   });
   ```

### GSAP Integration Fixes

1. **ScrollTrigger Registration**
   ```javascript
   // Error: Uncaught ReferenceError: ScrollTrigger is not defined
   // Fix: Ensure ScrollTrigger is properly registered
   if (typeof gsap !== 'undefined') {
     if (gsap.hasOwnProperty('registerPlugin')) {
       if (typeof ScrollTrigger !== 'undefined') {
         gsap.registerPlugin(ScrollTrigger);
       } else {
         console.warn('ScrollTrigger plugin not loaded.');
       }
     }
   }
   ```

2. **Animation Timing Issues**
   ```javascript
   // Error: Animations starting before elements are ready
   // Fix: Wait for DOM content to be loaded
   document.addEventListener('DOMContentLoaded', () => {
     // GSAP animations here
   });
   ```

### WooCommerce Template Fixes

1. **WooCommerce Hook Missing**
   ```php
   // Error: Undefined function 'woocommerce_content'
   // Fix: Check if WooCommerce is active before using functions
   if ( function_exists( 'woocommerce_content' ) ) {
     woocommerce_content();
   } else {
     echo '<p>WooCommerce not activated. Please install and activate WooCommerce.</p>';
   }
   ```

2. **Template Override Compatibility**
   ```php
   // Error: WooCommerce template override missing required hooks
   // Fix: Ensure all required hooks are present
   if ( ! function_exists( 'woocommerce_output_content_wrapper' ) ) {
     function woocommerce_output_content_wrapper() {
       echo '<div class="woocommerce-content-wrapper">';
     }
   }
   ```

### Asset Loading Fixes

1. **Missing CSS/JS Files**
   ```php
   // Error: Failed to load resource: net::ERR_FILE_NOT_FOUND style.css
   // Fix: Check file paths and ensure proper enqueuing
   function fix_enqueued_assets() {
     $style_url = get_template_directory_uri() . '/style.css';
     $style_path = get_template_directory() . '/style.css';
     
     if (file_exists($style_path)) {
       wp_enqueue_style('theme-style', $style_url);
     }
   }
   add_action('wp_enqueue_scripts', 'fix_enqueued_assets');
   ```

2. **Script Dependency Issues**
   ```php
   // Error: Dependencies not loaded before script
   // Fix: Ensure proper dependency declaration
   function fix_script_dependencies() {
     // Make sure jQuery is a dependency for our script
     wp_enqueue_script('theme-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
   }
   add_action('wp_enqueue_scripts', 'fix_script_dependencies');
   ```

## Unfixable Error Handling
For errors that cannot be fixed automatically with high confidence, log to `unfixable_errors.log`:

```
[date] [error_type]: [error_message]
[stack_trace]
[recommendation]
```

Example:
```
[2023-05-01 14:32:45] [WooCommerce API Error]: Cannot retrieve product data
Error in wc-ajax handler: Invalid product ID
Recommendation: Check product IDs in the database and ensure they exist
```

## Browser Compatibility Monitoring
Monitor and log browser-specific issues:

```javascript
function detectBrowserIssues() {
  const userAgent = navigator.userAgent;
  const browserInfo = {
    isChrome: /Chrome/.test(userAgent) && !/Edge/.test(userAgent),
    isFirefox: /Firefox/.test(userAgent),
    isSafari: /Safari/.test(userAgent) && !/Chrome/.test(userAgent),
    isEdge: /Edge/.test(userAgent),
    isIE: /Trident/.test(userAgent)
  };
  
  // Log browser-specific issues
  if (browserInfo.isIE) {
    console.warn('Internet Explorer detected. Some features may not work correctly.');
  }
  
  return browserInfo;
}
```

## Performance Monitoring
Monitor performance metrics and identify issues:

```javascript
function monitorPerformance() {
  if (window.performance && window.performance.timing) {
    window.addEventListener('load', () => {
      setTimeout(() => {
        const t = window.performance.timing;
        const pageLoadTime = t.loadEventEnd - t.navigationStart;
        
        if (pageLoadTime > 3000) {
          console.warn('Page load time exceeds 3 seconds: ' + pageLoadTime + 'ms');
          // Log performance issues for analysis
        }
      }, 0);
    });
  }
}
```

## GSAP Animation Monitoring
Monitor GSAP animations for performance issues:

```javascript
function monitorGSAPAnimations() {
  if (typeof gsap !== 'undefined') {
    gsap.ticker.fps(60);
    let lastTime = 0;
    let drops = 0;
    
    gsap.ticker.add((time) => {
      const delta = time - lastTime;
      lastTime = time;
      
      // If frame time delta is more than 32ms (below 30fps)
      if (delta > 0.032) {
        drops++;
        if (drops > 10) {
          console.warn('Animation performance issue detected: Multiple frame drops');
          // Log animation performance issues
          drops = 0;
        }
      }
    });
  }
}
```

## Implementation Guidelines
1. Include these monitoring functions in the theme's main JavaScript file
2. Set up automatic error reporting and fixing capabilities
3. Log all detected and fixed issues for analysis
4. Review unfixable errors regularly to improve the fixing algorithms

## Update Procedures
Regularly update these rules to handle new error patterns and improve fixing algorithms.
Current Version: 1.0
Last Updated: 2023-05-01 