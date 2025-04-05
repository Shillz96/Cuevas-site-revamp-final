<?php
/**
 * Debugging functions for the Cuevas theme.
 *
 * @package Cuevas
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Add debugging related functions here
// Consider wrapping in checks like if ( WP_DEBUG && WP_DEBUG_DISPLAY )

// --- Start of code moved from debugger.php ---

if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Log messages to the debug.log file.
	 *
	 * @param mixed $log The message or data to log.
	 */
	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

if ( ! function_exists( 'console_log' ) ) {
    /**
     * Output data to the browser console.
     *
     * @param mixed $data The data to log.
     * @param string $context Optional context label for the log.
     */
    function console_log( $data, $context = 'PHP' ) {
        // Only run if WP_DEBUG is true and not doing AJAX
        if ( true !== WP_DEBUG || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            return;
        }

        $output = json_encode( $data ); // Try to encode complex data
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            // If encoding fails, fallback to print_r
            $output = json_encode( print_r( $data, true ) );
        }

        echo "<script>console.log('" . esc_js( $context ) . ":', " . $output . ");</script>\n";
    }
}

if ( ! function_exists( 'dump_and_die' ) ) {
	/**
	 * Dump variable information and exit.
	 *
	 * @param mixed $var The variable to dump.
	 * @param bool $detailed Use print_r for more detail.
	 */
	function dump_and_die( $var, $detailed = false ) {
		if ( true === WP_DEBUG ) {
			echo '<pre>';
			if ( $detailed ) {
				print_r( $var );
			} else {
				var_dump( $var );
			}
			echo '</pre>';
			die();
		}
	}
}

if ( ! function_exists('dd') ) {
    /**
     * Alias for dump_and_die.
     *
     * @param mixed $var Variable to dump.
     * @param bool $detailed Use print_r for more detail.
     */
    function dd( $var, $detailed = false ) {
        if ( function_exists('dump_and_die') ) {
            dump_and_die( $var, $detailed );
        }
    }
}

// Example Usage (Keep these commented out or remove if not needed)
/*
add_action('wp_footer', function(){
    $test_data = ['a' => 1, 'b' => ['c' => 3]];
    console_log($test_data, 'Footer Data');
    write_log("Debug log message from footer.");
});

add_action('admin_init', function() {
   // Example: Check if a specific option exists
   $option = get_option('some_nonexistent_option', 'default');
   // write_log("Checked option value: " . print_r($option, true));
   // Uncomment below to test dump_and_die in admin
   // if ( current_user_can('manage_options') ) { // Check capability
   //     dd($GLOBALS[\'wp_actions\']);
   // }
});
*/

// --- End of code moved from debugger.php ---
