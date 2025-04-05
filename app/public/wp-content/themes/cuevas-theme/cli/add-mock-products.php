<?php
/**
 * Add mock products WP-CLI command
 */

if (!defined('WP_CLI') || !WP_CLI) {
    return;
}

class Mock_Products_CLI {
    private $image_dir;
    
    public function __construct() {
        $this->image_dir = "C:/Users/I7 8700k/Local Sites/Cuevas-site-revamp-final/Featured prodcuts/";
    }
    
    /**
     * Adds mock products with images from the Featured Products directory
     *
     * ## OPTIONS
     *
     * [--force]
     * : Override existing products with the same names
     *
     * ## EXAMPLES
     *
     *     wp mock-products add
     *     wp mock-products add --force
     */
    public function add($args, $assoc_args) {
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            WP_CLI::error('WooCommerce must be installed and activated.');
            return;
        }
        
        $force = isset($assoc_args['force']);
        
        // Product data
        $mock_products = array(
            array(
                'name' => 'Western Leather Boots',
                'description' => 'Handcrafted genuine leather boots with intricate stitching and comfortable fit. Perfect for both work and style.',
                'price' => '299.99',
                'image' => '5EF7A697-07FB-4BA0-A67B-FFE3C946D010-scaled.jpeg',
                'categories' => array('Footwear', 'Featured')
            ),
            array(
                'name' => 'Classic Western Hat',
                'description' => 'Premium quality western hat made from 100% wool felt. Features a decorative band and shaped brim.',
                'price' => '189.99',
                'image' => 'C1178884-6319-4421-9B3D-9DB67A923B1B-scaled.jpeg',
                'categories' => array('Accessories', 'Featured')
            ),
            array(
                'name' => 'Traditional Western Belt',
                'description' => 'Genuine leather belt with decorative buckle. Perfect complement to any western outfit.',
                'price' => '89.99',
                'image' => 'IMG_3371.jpeg',
                'categories' => array('Accessories', 'Featured')
            ),
            array(
                'name' => 'Western Denim Jacket',
                'description' => 'Classic denim jacket with western styling. Features contrast stitching and pearl snap buttons.',
                'price' => '159.99',
                'image' => 'DSC8855-1-scaled.jpg',
                'categories' => array('Outerwear', 'Featured')
            )
        );
        
        // Create categories
        $categories = array('Footwear', 'Accessories', 'Outerwear', 'Featured');
        foreach ($categories as $category) {
            if (!term_exists($category, 'product_cat')) {
                $result = wp_insert_term($category, 'product_cat');
                if (is_wp_error($result)) {
                    WP_CLI::warning("Could not create category: $category");
                } else {
                    WP_CLI::success("Created category: $category");
                }
            }
        }
        
        // Add products
        $progress = \WP_CLI\Utils\make_progress_bar('Adding products', count($mock_products));
        
        foreach ($mock_products as $product_data) {
            // Check if product exists
            $existing_product = get_page_by_title($product_data['name'], OBJECT, 'product');
            
            if ($existing_product && !$force) {
                WP_CLI::warning("Product '{$product_data['name']}' already exists. Skipping.");
                $progress->tick();
                continue;
            }
            
            // Create or update product
            $product = new WC_Product_Simple();
            if ($existing_product) {
                $product = wc_get_product($existing_product->ID);
            }
            
            $product->set_name($product_data['name']);
            $product->set_description($product_data['description']);
            $product->set_regular_price($product_data['price']);
            $product->set_status('publish');
            $product->set_featured(true);
            
            // Save product
            $product_id = $product->save();
            
            // Add image
            if ($product_data['image']) {
                $image_path = $this->image_dir . $product_data['image'];
                if (file_exists($image_path)) {
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
                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
                            wp_update_attachment_metadata($attachment_id, $attachment_data);
                            $product->set_image_id($attachment_id);
                            $product->save();
                        }
                    }
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
            }
            
            $progress->tick();
        }
        
        $progress->finish();
        WP_CLI::success('Mock products have been added successfully!');
    }
}

WP_CLI::add_command('mock-products', 'Mock_Products_CLI'); 