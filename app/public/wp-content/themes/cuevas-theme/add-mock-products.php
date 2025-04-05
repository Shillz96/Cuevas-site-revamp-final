<?php
/**
 * Script to add mock products
 * Place this file in your theme directory and run it once through the browser
 */

// Load WordPress
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '\\wp-load.php');

// Check if user is logged in and has permissions
if (!current_user_can('manage_options')) {
    die('You need to be an administrator to run this script.');
}

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die('WooCommerce is not active');
}

// Function to create a placeholder image
function create_placeholder_image($title) {
    // Create a placeholder image file
    $upload_dir = wp_upload_dir();
    $filename = sanitize_title($title) . '-placeholder.jpg';
    $file = $upload_dir['path'] . '/' . $filename;
    
    // Create a 800x800 image
    $image = imagecreatetruecolor(800, 800);
    $bg_color = imagecolorallocate($image, 245, 245, 245);
    $text_color = imagecolorallocate($image, 100, 100, 100);
    
    // Fill background
    imagefill($image, 0, 0, $bg_color);
    
    // Add text
    $text = $title;
    imagestring($image, 5, 300, 390, $text, $text_color);
    
    // Save image
    imagejpeg($image, $file);
    imagedestroy($image);
    
    // Prepare file data
    $file_data = array(
        'name' => $filename,
        'type' => 'image/jpeg',
        'tmp_name' => $file,
        'error' => 0,
        'size' => filesize($file)
    );
    
    // Insert attachment into media library
    $attachment_id = media_handle_sideload($file_data, 0);
    
    if (is_wp_error($attachment_id)) {
        return false;
    }
    
    return $attachment_id;
}

// Required for media handling functions
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Define mock products
$mock_products = array(
    array(
        'name' => 'Western Leather Boots',
        'description' => 'Handcrafted leather boots with authentic western styling',
        'price' => 299.99,
        'categories' => array('Footwear', 'Featured')
    ),
    array(
        'name' => 'Classic Western Hat',
        'description' => 'Traditional western hat with premium materials',
        'price' => 189.99,
        'categories' => array('Accessories', 'Featured')
    ),
    array(
        'name' => 'Traditional Western Belt',
        'description' => 'Genuine leather belt with decorative buckle',
        'price' => 89.99,
        'categories' => array('Accessories', 'Featured')
    ),
    array(
        'name' => 'Western Denim Jacket',
        'description' => 'Classic denim jacket with western-inspired details',
        'price' => 159.99,
        'categories' => array('Outerwear', 'Featured')
    )
);

// Create products
foreach ($mock_products as $product_data) {
    // Check if product already exists
    $existing_product = get_page_by_title($product_data['name'], OBJECT, 'product');
    
    if ($existing_product) {
        $product = wc_get_product($existing_product->ID);
        echo "Updating existing product: {$product_data['name']}<br>";
    } else {
        $product = new WC_Product_Simple();
        echo "Creating new product: {$product_data['name']}<br>";
    }
    
    // Set product data
    $product->set_name($product_data['name']);
    $product->set_description($product_data['description']);
    $product->set_regular_price($product_data['price']);
    $product->set_status('publish');
    
    // Explicitly set as featured
    $product->set_featured(true);
    
    // Save product first to get ID
    $product_id = $product->save();
    
    if ($product_id) {
        echo "Product '{$product_data['name']}' saved successfully (ID: $product_id)<br>";
        
        // Add featured image if none exists
        if (!has_post_thumbnail($product_id)) {
            $image_id = create_placeholder_image($product_data['name']);
            if ($image_id) {
                set_post_thumbnail($product_id, $image_id);
                echo "Added placeholder image to product<br>";
            }
        }
        
        // Add categories
        foreach ($product_data['categories'] as $category_name) {
            $term = get_term_by('name', $category_name, 'product_cat');
            
            if (!$term) {
                $term = wp_insert_term($category_name, 'product_cat');
                if (!is_wp_error($term)) {
                    echo "Created category: $category_name<br>";
                }
            }
            
            if (!is_wp_error($term)) {
                wp_set_object_terms($product_id, $category_name, 'product_cat', true);
                echo "Added product to category: $category_name<br>";
            }
        }
        echo "<hr>";
    } else {
        echo "Failed to save product '{$product_data['name']}'<br><hr>";
    }
}

echo "<br>Done! <a href='/wp-admin/edit.php?post_type=product'>View products in admin</a>"; 