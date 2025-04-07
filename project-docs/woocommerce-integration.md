# WooCommerce Integration Guide

## Overview
This document outlines the WooCommerce integration for Cuevas Western Wear, including product import processes, custom fields, and template customizations.

## Product Attributes

### Custom Western Wear Attributes
```php
Boot Attributes:
- Boot Style
- Material
- Heel Height
- Toe Shape
- Shaft Height
- Sole Type

Hat Attributes:
- Hat Style
- Brim Width
- Crown Height

General Attributes:
- Size Range
- Color Variations
```

## Product Import Process

### CSV Import Structure
1. **Standard WooCommerce Fields**
   - ID
   - Type (simple, variable)
   - SKU
   - Name
   - Published
   - Featured
   - Visibility
   - Description
   - Stock status
   - Price
   - Categories
   - Images

2. **Custom Fields Mapping**
   ```
   CSV Column Header => Internal Field
   Boot Style        => _boot_style
   Material         => _material
   Heel Height      => _heel_height
   Toe Shape        => _toe_shape
   Shaft Height     => _shaft_height
   Sole Type        => _sole_type
   Hat Style        => _hat_style
   Brim Width       => _brim_width
   Crown Height     => _crown_height
   ```

### Import Steps
1. Navigate to WooCommerce → Products → Import
2. Upload CSV file
3. Map columns using provided mapping
4. Run import
5. Verify custom fields display

## Template Structure

### Product Grid (`content-product.php`)
```php
- Product image
- Title
- Price
- Quick view button
- Add to cart button
- Custom field highlights
```

### Single Product (`single-product.php`)
```php
- Gallery slider
- Product information
- Custom fields display
- Size guide
- Related products
```

### Category Pages (`taxonomy-product_cat.php`)
```php
- Hero section
- Category description
- Filters
- Product grid
- Subcategories
```

## Custom Functions

### Product Display
- Custom field display in product pages
- Quick view functionality
- Enhanced gallery features
- Custom sorting options

### Category Management
- Hierarchical category structure
- Category image handling
- Custom category templates
- Filter system

## Animation Integration

### Product Grid Animations
```javascript
- Product card reveal
- Image hover effects
- Quick view transitions
- Add to cart feedback
```

### Single Product Animations
```javascript
- Gallery transitions
- Custom field reveals
- Related products slider
```

## Performance Considerations

### Image Optimization
- Proper image sizes
- Lazy loading
- WebP support
- Thumbnail generation

### Query Optimization
- Product queries
- Category queries
- Search functionality
- Filter performance

## Development Guidelines

### Adding New Custom Fields
1. Add field to `cuevas_add_product_attributes()`
2. Update import mapping in `cuevas_add_custom_import_columns()`
3. Add display logic in `cuevas_display_custom_fields()`
4. Update CSS for new field display

### Template Customization
1. Copy WooCommerce template to theme
2. Add custom markup and classes
3. Implement animations
4. Style new elements

### Testing Checklist
- [ ] Product import works
- [ ] Custom fields display correctly
- [ ] Animations perform well
- [ ] Mobile responsiveness
- [ ] Browser compatibility

## Troubleshooting

### Common Issues
1. **Import Failures**
   - Check CSV format
   - Verify column mapping
   - Check file permissions

2. **Display Issues**
   - Clear cache
   - Check template override
   - Verify CSS loading

3. **Performance Issues**
   - Check query optimization
   - Verify image sizes
   - Monitor AJAX requests

## Maintenance

### Regular Tasks
- Update WooCommerce version
- Check template compatibility
- Monitor performance
- Update product data

### Backup Procedures
- Database backup
- Product images backup
- Custom field data export
- Template files backup 