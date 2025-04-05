<?php
require_once('../../../../wp-load.php');

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die("WooCommerce must be installed and activated.\n");
}

// Create a simple product
$product = new WC_Product_Simple();
$product->set_name('Western Leather Boots');
$product->set_description('Handcrafted genuine leather boots with intricate stitching and comfortable fit. Perfect for both work and style.');
$product->set_regular_price('299.99');
$product->set_status('publish');

// Save the product
$product_id = $product->save();

if ($product_id) {
    echo "Product created successfully with ID: $product_id\n";
} else {
    echo "Failed to create product\n";
}

// Add categories
$categories = array('Footwear', 'Featured');
foreach ($categories as $category_name) {
    $term = get_term_by('name', $category_name, 'product_cat');
    if (!$term) {
        $term = wp_insert_term($category_name, 'product_cat');
        if (!is_wp_error($term)) {
            echo "Created category: $category_name\n";
        }
    }
}

// Set product categories
wp_set_object_terms($product_id, $categories, 'product_cat');

// Add image
$image_path = dirname(__FILE__) . '/../../uploads/woocommerce-placeholder-1024x1024.png';
if (file_exists($image_path)) {
    $upload = wp_upload_bits('woocommerce-placeholder-1024x1024.png', null, file_get_contents($image_path));
    if (!$upload['error']) {
        $wp_filetype = wp_check_filetype($upload['file'], null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name('woocommerce-placeholder-1024x1024.png'),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attachment_id = wp_insert_attachment($attachment, $upload['file'], $product_id);
        if (!is_wp_error($attachment_id)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
            update_post_meta($product_id, '_thumbnail_id', $attachment_id);
            echo "Image added successfully\n";
        }
    }
} 