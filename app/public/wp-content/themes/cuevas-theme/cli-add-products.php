<?php
// Bootstrap WordPress
require_once(dirname(__FILE__) . '/../../../wp-load.php');

// Required for media handling
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die("WooCommerce must be installed and activated.\n");
}

// Product data
$mock_products = array(
    array(
        'name' => 'Western Leather Boots',
        'description' => 'Handcrafted genuine leather boots with intricate stitching and comfortable fit. Perfect for both work and style.',
        'price' => '299.99',
        'image' => 'woocommerce-placeholder-1024x1024.png',
        'categories' => array('Footwear', 'Featured')
    ),
    array(
        'name' => 'Classic Western Hat',
        'description' => 'Premium quality western hat made from 100% wool felt. Features a decorative band and shaped brim.',
        'price' => '189.99',
        'image' => 'woocommerce-placeholder-768x768.png',
        'categories' => array('Accessories', 'Featured')
    ),
    array(
        'name' => 'Traditional Western Belt',
        'description' => 'Genuine leather belt with decorative buckle. Perfect complement to any western outfit.',
        'price' => '89.99',
        'image' => 'woocommerce-placeholder-600x600.png',
        'categories' => array('Accessories', 'Featured')
    ),
    array(
        'name' => 'Western Denim Jacket',
        'description' => 'Classic denim jacket with western styling. Features contrast stitching and pearl snap buttons.',
        'price' => '159.99',
        'image' => 'woocommerce-placeholder-300x300.png',
        'categories' => array('Outerwear', 'Featured')
    )
);

// Create categories
$categories = array('Footwear', 'Accessories', 'Outerwear', 'Featured');
foreach ($categories as $category) {
    if (!term_exists($category, 'product_cat')) {
        $result = wp_insert_term($category, 'product_cat');
        if (is_wp_error($result)) {
            echo "Warning: Could not create category: $category\n";
        } else {
            echo "Created category: $category\n";
        }
    }
}

// Add products
foreach ($mock_products as $product_data) {
    echo "Processing {$product_data['name']}...\n";
    
    // Check if product exists
    $existing_product = get_page_by_title($product_data['name'], OBJECT, 'product');
    if ($existing_product) {
        echo "Product '{$product_data['name']}' already exists. Updating...\n";
        $product = wc_get_product($existing_product->ID);
    } else {
        echo "Creating new product '{$product_data['name']}'...\n";
        $product = new WC_Product_Simple();
    }
    
    // Set product data
    $product->set_name($product_data['name']);
    $product->set_description($product_data['description']);
    $product->set_regular_price($product_data['price']);
    $product->set_status('publish');
    $product->set_featured(true);
    
    // Save product to get ID
    $product_id = $product->save();
    
    // Add image
    if ($product_data['image']) {
        $image_path = dirname(__FILE__) . '/../../../wp-content/uploads/' . $product_data['image'];
        if (file_exists($image_path)) {
            echo "Adding image from: $image_path\n";
            $upload = wp_upload_bits($product_data['image'], null, file_get_contents($image_path));
            if (!$upload['error']) {
                $wp_filetype = wp_check_filetype($product_data['image'], null);
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', $product_data['image']),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                $attachment_id = wp_insert_attachment($attachment, $upload['file'], $product_id);
                if (!is_wp_error($attachment_id)) {
                    $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
                    wp_update_attachment_metadata($attachment_id, $attachment_data);
                    $product->set_image_id($attachment_id);
                    $product->save();
                    echo "Image added successfully\n";
                }
            }
        } else {
            echo "Warning: Image file not found at: $image_path\n";
        }
    }
    
    // Add categories
    if (!empty($product_data['categories'])) {
        $term_ids = array();
        foreach ($product_data['categories'] as $category_name) {
            $term = get_term_by('name', $category_name, 'product_cat');
            if ($term) {
                $term_ids[] = $term->term_id;
            }
        }
        wp_set_object_terms($product_id, $term_ids, 'product_cat');
        echo "Categories added\n";
    }
    
    echo "Completed processing {$product_data['name']}\n\n";
}

echo "All mock products have been added successfully!\n"; 