<?php
// WP-CLI will handle loading WordPress for us

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die('WooCommerce is not active');
}

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
    } else {
        $product = new WC_Product_Simple();
    }
    
    // Set product data
    $product->set_name($product_data['name']);
    $product->set_description($product_data['description']);
    $product->set_regular_price($product_data['price']);
    $product->set_status('publish');
    
    // Save product
    $product_id = $product->save();
    
    if ($product_id) {
        echo "Product '{$product_data['name']}' saved successfully (ID: $product_id)\n";
        
        // Add categories
        foreach ($product_data['categories'] as $category_name) {
            $term = get_term_by('name', $category_name, 'product_cat');
            
            if (!$term) {
                $term = wp_insert_term($category_name, 'product_cat');
                if (!is_wp_error($term)) {
                    echo "Created category: $category_name\n";
                }
            }
            
            if (!is_wp_error($term)) {
                wp_set_object_terms($product_id, $category_name, 'product_cat', true);
                echo "Added product to category: $category_name\n";
            }
        }
    } else {
        echo "Failed to save product '{$product_data['name']}'\n";
    }
} 