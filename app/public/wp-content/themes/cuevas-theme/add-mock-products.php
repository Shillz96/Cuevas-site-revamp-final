<?php
/**
 * Script to add mock products
 * Place this file in your theme directory and run it once through the browser
 */

// Bootstrap WordPress
require_once('../../../wp-load.php');

// Required for media handling functions
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Verify admin privileges
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

// Mock product data
$mock_products = array(
    array(
        'name' => 'Western Leather Boots',
        'description' => 'Handcrafted genuine leather boots with intricate stitching and comfortable fit. Perfect for both work and style.',
        'price' => '299.99',
        'image' => '5EF7A697-07FB-4BA0-A67B-FFE3C946D010-scaled.jpeg',
        'categories' => array('Footwear', 'Featured'),
        'featured' => true
    ),
    array(
        'name' => 'Classic Western Hat',
        'description' => 'Premium quality western hat made from 100% wool felt. Features a decorative band and shaped brim.',
        'price' => '189.99',
        'image' => 'C1178884-6319-4421-9B3D-9DB67A923B1B-scaled.jpeg',
        'categories' => array('Accessories', 'Featured'),
        'featured' => true
    ),
    array(
        'name' => 'Traditional Western Belt',
        'description' => 'Genuine leather belt with decorative buckle. Perfect complement to any western outfit.',
        'price' => '89.99',
        'image' => 'IMG_3371.jpeg',
        'categories' => array('Accessories', 'Featured'),
        'featured' => true
    ),
    array(
        'name' => 'Western Denim Jacket',
        'description' => 'Classic denim jacket with western styling. Features contrast stitching and pearl snap buttons.',
        'price' => '159.99',
        'image' => 'DSC8855-1-scaled.jpg',
        'categories' => array('Outerwear', 'Featured'),
        'featured' => true
    )
);

// Create product categories if they don't exist
$categories = array('Footwear', 'Accessories', 'Outerwear', 'Featured');
foreach ($categories as $category_name) {
    if (!term_exists($category_name, 'product_cat')) {
        wp_insert_term($category_name, 'product_cat');
    }
}

// Function to get image ID from filename
function get_image_id_from_filename($filename) {
    $upload_dir = wp_upload_dir();
    $source_path = "C:/Users/I7 8700k/Local Sites/Cuevas-site-revamp-final/Featured prodcuts/" . $filename;
    
    // Check if file exists
    if (!file_exists($source_path)) {
        return false;
    }
    
    // Prepare file for upload
    $file = array(
        'name' => $filename,
        'tmp_name' => $source_path
    );
    
    // Copy file to uploads directory
    $upload = wp_handle_sideload(
        $file,
        array('test_form' => false)
    );
    
    if (isset($upload['error'])) {
        return false;
    }
    
    // Prepare attachment data
    $attachment = array(
        'post_mime_type' => $upload['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    // Insert attachment
    $attach_id = wp_insert_attachment($attachment, $upload['file']);
    
    // Generate attachment metadata
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);
    
    return $attach_id;
}

// Add products
foreach ($mock_products as $product_data) {
    // Check if product already exists
    $existing_product = get_page_by_title($product_data['name'], OBJECT, 'product');
    if ($existing_product) {
        continue; // Skip if product exists
    }
    
    // Create product
    $product = new WC_Product_Simple();
    $product->set_name($product_data['name']);
    $product->set_description($product_data['description']);
    $product->set_regular_price($product_data['price']);
    $product->set_status('publish');
    
    // Set product as featured if specified
    if ($product_data['featured']) {
        $product->set_featured(true);
    }
    
    // Save product to get ID
    $product_id = $product->save();
    
    // Set product image
    if ($product_data['image']) {
        $image_id = get_image_id_from_filename($product_data['image']);
        if ($image_id) {
            $product->set_image_id($image_id);
            $product->save();
        }
    }
    
    // Set product categories
    if (!empty($product_data['categories'])) {
        $category_ids = array();
        foreach ($product_data['categories'] as $category_name) {
            $term = get_term_by('name', $category_name, 'product_cat');
            if ($term) {
                $category_ids[] = $term->term_id;
            }
        }
        wp_set_object_terms($product_id, $category_ids, 'product_cat');
    }
}

echo 'Mock products have been added successfully!'; 