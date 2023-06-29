<?php
/**
 * Addonify Wishlist
 *
 * @link              https://www.addonify.com
 * @since             1.0.0
 * @package           Addonify_Wishlist
 *
 * @wordpress-plugin
 * Plugin Name:       Addonify - WooCommerce Wishlist
 * Plugin URI:        https://wordpress.org/plugins/addonify-wishlist
 * Description:       Addonify WooCommerce Wishlist is a light-weight yet powerful tool that adds a wishlist functionality to your e-commerce shop.
 * Version:           2.0.5
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            Addonify
 * Author URI:        https://www.addonify.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       addonify-wishlist
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ADDONIFY_WISHLIST_VERSION', '2.0.5' );
define( 'ADDONIFY_WISHLIST_DB_INITIALS', 'addonify_wishlist_' );
define( 'ADDONIFY_WISHLIST_PLUGIN_PATH', dirname( __FILE__ ) );
define( 'ADDONIFY_WISHLIST_PLUGIN_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 */
function activate_addonify_wishlist() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-addonify-wishlist-activator.php';
	Addonify_Wishlist_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_addonify_wishlist() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-addonify-wishlist-deactivator.php';
	Addonify_Wishlist_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_addonify_wishlist' );
register_deactivation_hook( __FILE__, 'deactivate_addonify_wishlist' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-addonify-wishlist.php';

/**
* The code that runs during plugin bootstrap.
*/
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/app.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_addonify_wishlist() {

	$plugin = new Addonify_Wishlist();
	$plugin->run();

}

run_addonify_wishlist();
