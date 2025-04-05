<?php
// Database settings for Local by Flywheel
$db_host = '127.0.0.1:3306';  // Use IP and port
$db_name = 'local';
$db_user = 'root';
$db_pass = 'root';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set table prefix
$table_prefix = 'wp_';

// Product data
$products = array(
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
foreach ($products as $product) {
    foreach ($product['categories'] as $category) {
        $sql = "INSERT IGNORE INTO {$table_prefix}terms (name, slug) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $slug = strtolower(str_replace(' ', '-', $category));
        $stmt->bind_param("ss", $category, $slug);
        $stmt->execute();
        
        // Get term_id
        $term_id = $stmt->insert_id;
        if (!$term_id) {
            $sql = "SELECT term_id FROM {$table_prefix}terms WHERE slug = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $term_id = $row['term_id'];
        }
        
        // Add to taxonomy
        $sql = "INSERT IGNORE INTO {$table_prefix}term_taxonomy (term_id, taxonomy, description) VALUES (?, 'product_cat', '')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $term_id);
        $stmt->execute();
    }
}

// Add products
foreach ($products as $product) {
    // Insert post
    $sql = "INSERT INTO {$table_prefix}posts (post_title, post_content, post_status, post_type) VALUES (?, ?, 'publish', 'product')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $product['name'], $product['description']);
    $stmt->execute();
    $product_id = $stmt->insert_id;
    
    // Add price
    $sql = "INSERT INTO {$table_prefix}postmeta (post_id, meta_key, meta_value) VALUES (?, '_regular_price', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $product_id, $product['price']);
    $stmt->execute();
    
    // Add categories
    foreach ($product['categories'] as $category) {
        $sql = "SELECT term_id FROM {$table_prefix}terms WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $term_id = $row['term_id'];
        
        $sql = "SELECT term_taxonomy_id FROM {$table_prefix}term_taxonomy WHERE term_id = ? AND taxonomy = 'product_cat'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $term_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $term_taxonomy_id = $row['term_taxonomy_id'];
        
        $sql = "INSERT IGNORE INTO {$table_prefix}term_relationships (object_id, term_taxonomy_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $product_id, $term_taxonomy_id);
        $stmt->execute();
    }
    
    // Add image
    if ($product['image']) {
        $image_path = dirname(__FILE__) . '/../../../wp-content/uploads/' . $product['image'];
        if (file_exists($image_path)) {
            $sql = "INSERT INTO {$table_prefix}posts (post_title, post_mime_type, post_type, guid) VALUES (?, 'image/png', 'attachment', ?)";
            $stmt = $conn->prepare($sql);
            $guid = 'http://localhost:10005/wp-content/uploads/' . $product['image'];
            $stmt->bind_param("ss", $product['image'], $guid);
            $stmt->execute();
            $attachment_id = $stmt->insert_id;
            
            $sql = "INSERT INTO {$table_prefix}postmeta (post_id, meta_key, meta_value) VALUES (?, '_thumbnail_id', ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $product_id, $attachment_id);
            $stmt->execute();
        }
    }
    
    echo "Added product: {$product['name']}\n";
}

$conn->close();
echo "All products added successfully!\n"; 