<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and other required variables.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin
 * @author     Adodnify <contact@addonify.com>
 */
class Addonify_Wishlist_Admin {

	/**
	 * Settings page slug
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings_page_slug    Default settings page slug for this plugin
	 */
	private $settings_page_slug = 'addonify_wishlist';


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of this plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// load styles in this plugin page only.
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->settings_page_slug ) {

			wp_enqueue_style( "{$this->plugin_name}-icon", plugin_dir_url( __FILE__ ) . 'assets/fonts/icon.css', array(), $this->version, 'all' );

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', array(), $this->version, 'all' );
		}
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( 
			"{$this->plugin_name}-manifest", 
			plugin_dir_url( __FILE__ ) . 'assets/js/manifest.js', 
			null, 
			$this->version, 
			true 
		);

		wp_register_script( 
			"{$this->plugin_name}-vendor", 
			plugin_dir_url( __FILE__ ) . 'assets/js/vendor.js', 
			array(  "{$this->plugin_name}-manifest" ), 
			$this->version, 
			true 
		);

		wp_register_script( 
			"{$this->plugin_name}-main", 
			plugin_dir_url( __FILE__ ) . 'assets/js/main.js', 
			array("{$this->plugin_name}-vendor", 'lodash', 'wp-i18n', 'wp-api-fetch' ), 
			$this->version, 
			true 
		);

		// load scripts in plugin page only.
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->settings_page_slug ) {

			wp_enqueue_script( "{$this->plugin_name}-manifest" );

			wp_enqueue_script( "{$this->plugin_name}-vendor" );

			wp_enqueue_script( "{$this->plugin_name}-main" );

			wp_localize_script( "{$this->plugin_name}-main", 'ADDONIFY_WISHLIST_LOCOLIZER', array(
				'admin_url'  						=> admin_url( '/' ),
				'ajax_url'   						=> admin_url( 'admin-ajax.php' ),
				'rest_namespace' 					=> 'addonify_wishlist_options_api',
				'version_number' 					=> $this->version,
			) );
		}

		wp_set_script_translations( "{$this->plugin_name}-main", $this->plugin_name );
	}


	/**
	 * Generate admin menu for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function add_menu_callback() {

		// do not show menu if woocommerce is not active.
		if ( ! class_exists( 'woocommerce' ) ) {
			return;
		}

		global $admin_page_hooks;

		$parent_menu_slug = array_search( 'addonify', $admin_page_hooks, true );

		if ( ! $parent_menu_slug ) {

			add_menu_page( 
				'Addonify Settings', 
				'Addonify', 
				'manage_options', 
				$this->settings_page_slug, 
				array( $this, 'get_settings_screen_contents' ), 
				'dashicons-superhero', 
				70 
			);

			add_submenu_page( 
				$this->settings_page_slug, 
				'Wishlist Settings', 
				'Wishlist', 
				'manage_options', 
				$this->settings_page_slug, 
				array( $this, 'get_settings_screen_contents' ), 
				1 
			);

		} else {
			
			add_submenu_page( 
				$parent_menu_slug, 
				'Wishlist Settings', 
				'Wishlist', 
				'manage_options', 
				$this->settings_page_slug, 
				array( $this, 'get_settings_screen_contents' ), 
				1 
			);
		}
	}



	/**
	 * Print "settings" link in plugins.php admin page
	 *
	 * @since    1.0.0
	 * @param string $links links.
	 * @param string $file File.
	 */
	public function custom_plugin_link_callback( $links, $file ) {

		if ( plugin_basename( ADDONIFY_WISHLIST_PLUGIN_PATH . '/addonify-wishlist.php' ) === $file ) {
			// add "Settings" link.
			$links[] = '<a href="admin.php?page=' . esc_attr( $this->settings_page_slug ) . '">' . __( 'Settings', 'addonify-wishlist' ) . '</a>';
		}

		return $links;
	}


	/**
	 * Get contents from settings page templates and print it
	 * Called from "add_menu_callback".
	 *
	 * @since    1.0.0
	 */
	public function get_settings_screen_contents() {
		?>
		<div id="___adfy-wishlist-app___"></div>
		<?php
	}


	/**
	 * Show admin error message if woocommerce is not active
	 *
	 * @since    1.0.0
	 */
	public function show_woocommerce_not_active_notice_callback() {

		if ( ! class_exists( 'woocommerce' ) ) {

			add_action(
				'admin_notices',
				function() {
					require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/woocommerce-not-active-notice.php';
				}
			);
		}

	}


	/**
	 * Show custom "post status" label after page title in "Pages" admin menu.
	 * shows "Addonify Wishlist Page" label after the page title.
	 *
	 * @since    1.0.0
	 * @param array  $states Post Status.
	 * @param object $post  Post object.
	 */
	public function display_custom_post_states_after_page_title( $states, $post ) {

		$wishlist_page_id = addonify_wishlist_get_option( 'wishlist_page' ) ? (int) addonify_wishlist_get_option( 'wishlist_page' ) : '';

		if ( 
			get_post_type( $post->ID ) == 'page' && 
			$post->ID == $wishlist_page_id 
		) {
			$states[] = __( 'Addonify Wishlist Page', 'addonify-wishlist' );
		}

		return $states;
	}

}
