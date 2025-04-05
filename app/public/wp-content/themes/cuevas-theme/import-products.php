<?php
// Load WordPress
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');

// Check if user is logged in and has permissions
if (!current_user_can('manage_options')) {
    die('You need to be an administrator to run this script.');
}

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die('WooCommerce is not active');
}

// Required for media handling
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 300); // 5 minutes
ini_set('memory_limit', '512M');

// Debug function
function debug_log($message, $data = null) {
    echo $message;
    if ($data !== null) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    echo "<br>";
    flush();
    ob_flush();
}

// Function to download and import image from live site
function import_product_image($image_url, $product_title) {
    try {
        // If the URL is just a number (attachment ID), try to find it in uploads
        if (is_numeric($image_url)) {
            debug_log("Found numeric image ID from original site: $image_url");
            
            // Get WordPress upload directory info
            $upload_dir = wp_upload_dir();
            
            // Try different possible file paths - using exact path where files are stored
            $possible_paths = [
                'C:/Users/I7 8700k/Local Sites/Cuevas-site-revamp-final/app/public/wp-content/uploads/2025/' . $image_url . '.jpg',
                'C:/Users/I7 8700k/Local Sites/Cuevas-site-revamp-final/app/public/wp-content/uploads/2025/' . $image_url . '.jpeg',
                'C:/Users/I7 8700k/Local Sites/Cuevas-site-revamp-final/app/public/wp-content/uploads/2025/' . $image_url . '.png'
            ];
            
            foreach ($possible_paths as $file_path) {
                debug_log("Checking for file at: $file_path");
                if (file_exists($file_path)) {
                    debug_log("Found existing file: $file_path");
                    
                    // Generate a unique filename
                    $filename = sanitize_file_name($product_title . '-' . basename($file_path));
                    
                    // Check if we already have this image
                    $existing_attachment = get_page_by_title($filename, OBJECT, 'attachment');
                    if ($existing_attachment) {
                        debug_log("Found existing attachment: $filename (ID: {$existing_attachment->ID})");
                        return $existing_attachment->ID;
                    }
                    
                    // Prepare file data
                    $filetype = wp_check_filetype(basename($file_path), null);
                    $attachment = array(
                        'post_mime_type' => $filetype['type'],
                        'post_title' => $filename,
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    
                    // Copy file to new location in uploads directory
                    $new_file = $upload_dir['path'] . '/' . $filename;
                    copy($file_path, $new_file);
                    
                    // Insert attachment
                    $attach_id = wp_insert_attachment($attachment, $new_file);
                    
                    if (!is_wp_error($attach_id)) {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        $attach_data = wp_generate_attachment_metadata($attach_id, $new_file);
                        wp_update_attachment_metadata($attach_id, $attach_data);
                        debug_log("Successfully imported image: $filename (ID: $attach_id)");
                        return $attach_id;
                    }
                    
                    debug_log("Error creating attachment: " . ($attach_id->get_error_message() ?? 'Unknown error'));
                    return false;
                }
            }
            
            debug_log("Could not find image file for ID: $image_url in any of these locations:");
            foreach ($possible_paths as $path) {
                debug_log("- $path");
            }
            return false;
        }

        // For non-numeric URLs, try to find the file locally first
        $image_url = trim($image_url);
        if (empty($image_url)) {
            debug_log("Empty image URL provided");
            return false;
        }

        // Get the filename from the URL
        $filename = basename($image_url);
        
        // Try to find the file in uploads directory
        $file_path = 'C:/Users/I7 8700k/Local Sites/Cuevas-site-revamp-final/app/public/wp-content/uploads/2025/' . $filename;
        
        if (file_exists($file_path)) {
            debug_log("Found existing file: $file_path");
            
            // Generate a unique filename
            $new_filename = sanitize_file_name($product_title . '-' . basename($file_path));
            
            // Check if we already have this image
            $existing_attachment = get_page_by_title($new_filename, OBJECT, 'attachment');
            if ($existing_attachment) {
                debug_log("Found existing attachment: $new_filename (ID: {$existing_attachment->ID})");
                return $existing_attachment->ID;
            }
            
            // Prepare file data
            $filetype = wp_check_filetype(basename($file_path), null);
            $attachment = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => $new_filename,
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            // Copy file to new location in uploads directory
            $new_file = $upload_dir['path'] . '/' . $new_filename;
            copy($file_path, $new_file);
            
            // Insert attachment
            $attach_id = wp_insert_attachment($attachment, $new_file);
            
            if (!is_wp_error($attach_id)) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata($attach_id, $new_file);
                wp_update_attachment_metadata($attach_id, $attach_data);
                debug_log("Successfully imported image: $new_filename (ID: $attach_id)");
                return $attach_id;
            }
            
            debug_log("Error creating attachment: " . ($attach_id->get_error_message() ?? 'Unknown error'));
            return false;
        }
        
        debug_log("Could not find image file locally: $file_path");
        return false;
    } catch (Exception $e) {
        debug_log("Exception while importing image: " . $e->getMessage());
        debug_log("Stack trace: " . $e->getTraceAsString());
        return false;
    }
}

// Path to your CSV file
$csv_file = dirname(__FILE__) . '/product-export_product-2025_04_04-21_14_25-75678195-uvaf0ovdgi.csv';

if (!file_exists($csv_file)) {
    die("CSV file not found at: $csv_file");
}

// Open CSV file
$handle = fopen($csv_file, 'r');
if ($handle === false) {
    die('Error opening CSV file');
}

// Skip header row and store headers
$headers = fgetcsv($handle);
if ($headers === false) {
    die('Error reading CSV headers');
}

debug_log("CSV Headers found:", $headers);

// Initialize counters
$imported = 0;
$updated = 0;
$skipped = 0;
$errors = 0;
$images_imported = 0;
$images_failed = 0;
$total_processed = 0;
$limit = 100; // Limit to 100 products

echo "<h2>Starting Product Import (Limited to $limit products)</h2>";

// Process each row
while (($data = fgetcsv($handle)) !== false && $total_processed < $limit) {
    try {
        $row = array_combine($headers, $data);
        $total_processed++;
        
        echo "<div style='background: #f0f0f0; padding: 10px; margin: 5px 0;'>";
        echo "Processing product {$total_processed} of {$limit}<br>";
        
        // Skip empty rows
        if (empty($row['Product Name'])) {
            debug_log("Skipping empty row");
            $skipped++;
            continue;
        }

        debug_log("Processing product: " . $row['Product Name']);
        
        // Check if product exists by SKU first, then by name
        $existing_product = null;
        if (!empty($row['Product SKU'])) {
            $existing_product = wc_get_product_id_by_sku($row['Product SKU']);
            if ($existing_product) {
                $existing_product = get_post($existing_product);
            }
        }
        
        if (!$existing_product) {
            $existing_product = get_page_by_title($row['Product Name'], OBJECT, 'product');
        }
        
        if ($existing_product) {
            $product = wc_get_product($existing_product->ID);
            if (!$product) {
                debug_log("Error getting existing product {$row['Product Name']}");
                $errors++;
                continue;
            }
            debug_log("Updating existing product: {$row['Product Name']} (ID: {$existing_product->ID})");
            $updated++;
        } else {
            try {
                $product = new WC_Product_Simple();
                debug_log("Creating new product: {$row['Product Name']}");
                $imported++;
            } catch (Exception $e) {
                debug_log("Error creating product {$row['Product Name']}: " . $e->getMessage());
                $errors++;
                continue;
            }
        }
        
        try {
            // Set basic product data
            $product->set_name($row['Product Name']);
            $product->set_status('publish'); // Default to publish
            $product->set_catalog_visibility('visible'); // Default to visible
            $product->set_description($row['Description']);
            $product->set_short_description($row['Excerpt']);
            if (!empty($row['Product SKU'])) {
                $product->set_sku($row['Product SKU']);
            }
            
            // Handle prices
            if (!empty($row['Price'])) {
                $price = preg_replace('/[^0-9.]/', '', $row['Price']);
                if (is_numeric($price)) {
                    debug_log("Setting regular price: " . $price);
                    $product->set_regular_price($price);
                }
            }
            
            if (!empty($row['Sale Price'])) {
                $sale_price = preg_replace('/[^0-9.]/', '', $row['Sale Price']);
                if (is_numeric($sale_price)) {
                    debug_log("Setting sale price: " . $sale_price);
                    $product->set_sale_price($sale_price);
                }
            }
            
            // Handle stock management
            $product->set_manage_stock(true);
            if (!empty($row['Quantity']) && is_numeric($row['Quantity'])) {
                debug_log("Setting stock quantity: " . $row['Quantity']);
                $product->set_stock_quantity(intval($row['Quantity']));
            } else {
                $product->set_stock_quantity(0);
            }
            $product->set_stock_status('instock');
            
            // Handle categories
            if (!empty($row['Category'])) {
                $categories = explode('|', $row['Category']);
                $category_ids = array();
                
                foreach ($categories as $category_name) {
                    $category_name = trim($category_name);
                    $term = get_term_by('name', $category_name, 'product_cat');
                    
                    if (!$term) {
                        $term = wp_insert_term($category_name, 'product_cat');
                        if (!is_wp_error($term)) {
                            $category_ids[] = $term['term_id'];
                            debug_log("Created category: $category_name");
                        } else {
                            debug_log("Error creating category $category_name: " . $term->get_error_message());
                        }
                    } else {
                        $category_ids[] = $term->term_id;
                        debug_log("Using existing category: $category_name (ID: {$term->term_id})");
                    }
                }
                
                if (!empty($category_ids)) {
                    debug_log("Setting category IDs:", $category_ids);
                    $product->set_category_ids($category_ids);
                }
            }
            
            // Handle featured status
            $product->set_featured(true); // Set all products as featured
            
            // Save product to get ID
            $product_id = $product->save();
            debug_log("Saved product with ID: $product_id");
            
            // Handle featured image
            if (!empty($row['Featured Image'])) {
                debug_log("Processing featured image: " . $row['Featured Image']);
                $featured_image_id = import_product_image($row['Featured Image'], $row['Product Name']);
                if ($featured_image_id) {
                    $product->set_image_id($featured_image_id);
                    $images_imported++;
                    debug_log("Set featured image ID: $featured_image_id");
                } else {
                    $images_failed++;
                    debug_log("Failed to set featured image");
                }
            }
            
            // Handle gallery images
            if (!empty($row['Product Gallery'])) {
                $gallery_images = explode('|', $row['Product Gallery']);
                $gallery_ids = array();
                
                foreach ($gallery_images as $index => $image_url) {
                    $image_url = trim($image_url);
                    if (empty($image_url)) continue;
                    
                    debug_log("Processing gallery image $index: $image_url");
                    $image_id = import_product_image($image_url, $row['Product Name'] . '-gallery-' . ($index + 1));
                    if ($image_id) {
                        $gallery_ids[] = $image_id;
                        $images_imported++;
                        debug_log("Added gallery image ID: $image_id");
                    } else {
                        $images_failed++;
                        debug_log("Failed to add gallery image");
                    }
                }
                
                if (!empty($gallery_ids)) {
                    debug_log("Setting gallery image IDs:", $gallery_ids);
                    $product->set_gallery_image_ids($gallery_ids);
                }
            }
            
            // Final save
            $product->save();
            debug_log("Successfully processed product: {$row['Product Name']}");
            echo "</div>";
            echo "<hr>";
            
        } catch (Exception $e) {
            debug_log("Error processing product {$row['Product Name']}: " . $e->getMessage());
            $errors++;
        }
    } catch (Exception $e) {
        debug_log("Error processing row: " . $e->getMessage());
        $errors++;
    }
}

fclose($handle);

echo "<h2>Import Summary</h2>";
echo "Total products processed: $total_processed<br>";
echo "Products imported: $imported<br>";
echo "Products updated: $updated<br>";
echo "Products skipped: $skipped<br>";
echo "Errors encountered: $errors<br>";
echo "Images successfully imported: $images_imported<br>";
echo "Images failed to import: $images_failed<br>";
echo "<br><a href='/wp-admin/edit.php?post_type=product'>View products in admin</a>";