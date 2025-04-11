<?php
/**
 * Plugin Name: Bookium
 * Plugin URI: https://ollyo.com
 * Description: This is a simple book manager where user can add, update & delete books.
 * Author: Md. Ashraful
 * Version: 1.0.0
 * Author URI: https://ollyo.com
 * Requires PHP: 7.4
 * Requires at least: 5.3
 * Tested up to: 6.7
 * License: GPLv2 or later
 * Text Domain: bookium
 */

use Ashraful\Bookium\Bookium;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Constants for the plugin.
 */
define( 'BOOKIUM_VERSION', '1.0.0' );
define( 'BOOKIUM_FILE', __FILE__ );

Bookium::instance();