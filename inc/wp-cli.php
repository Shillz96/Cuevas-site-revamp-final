<?php
/**
 * WP-CLI Commands for the Cuevas theme.
 *
 * @package Cuevas
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return; // Only load if WP-CLI is running.
}

// Register WP-CLI commands and their logic here
// Example:
/*
if ( class_exists( 'WP_CLI_Command' ) ) {
    class Cuevas_CLI_Command extends WP_CLI_Command {
        /**
         * Example command.
         *
         * ## EXAMPLES
         *
         *     wp cuevas hello
         *
         * @when after_wp_load
         * /
        public function hello() {
            WP_CLI::success( 'Hello from the Cuevas theme CLI command!' );
        }
    }
    WP_CLI::add_command( 'cuevas', 'Cuevas_CLI_Command' );
}
*/
