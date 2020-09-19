<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 * @author     Adodnify <info@addonify.com>
 */
class Addonify_Wishlist {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Addonify_Wishlist_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ADDONIFY_WISHLIST_VERSION' ) ) {
			$this->version = ADDONIFY_WISHLIST_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'addonify-wishlist';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Addonify_Wishlist_Loader. Orchestrates the hooks of the plugin.
	 * - Addonify_Wishlist_i18n. Defines internationalization functionality.
	 * - Addonify_Wishlist_Admin. Defines all hooks for the admin area.
	 * - Addonify_Wishlist_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-addonify-wishlist-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-addonify-wishlist-public.php';

		$this->loader = new Addonify_Wishlist_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Addonify_Wishlist_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Addonify_Wishlist_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Addonify_Wishlist_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// admin menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_callback', 20 );

		// custom link in plugins.php page in wp-admin
		$this->loader->add_action( 'plugin_action_links', $plugin_admin, 'custom_plugin_link_callback', 10, 2 );

		// show settings page ui 
		$this->loader->add_action("admin_init", $plugin_admin, 'settings_page_ui' );
		
		//show notice if woocommerce is not active
		$this->loader->add_action('admin_init', $plugin_admin, 'show_woocommerce_not_active_notice_callback' );

		// show admin notices after form submission
		$this->loader->add_action('admin_notices', $plugin_admin, 'form_submission_notification_callback' );

		// add custom post status "Addonify Wishlist Page" after page name
		$this->loader->add_filter('display_post_states', $plugin_admin, 'custom_display_post_states_callback', 10, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Addonify_Wishlist_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		// add button after add to cart button
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'show_btn_after_add_to_cart_btn_callback', 20 );


		// add button before add to cart button
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'show_btn_before_add_to_cart_btn_callback' );


		// add button aside image
		$this->loader->add_action( 'woocommerce_shop_loop_item_title', $plugin_public, 'show_btn_aside_image_callback' );

		
		// image overlay container 
		$this->loader->add_action( 'woocommerce_before_shop_loop_item', $plugin_public, 'addonify_overlay_container_start_callback', 10 );
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'addonify_overlay_container_end_callback', 10 );


		$this->loader->add_action( 'init', $plugin_public, 'generate_cookies', 10 );	
		$this->loader->add_action( 'wp', $plugin_public, 'process_wishlist_form_submit', 10 );
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcode', 10 );
		

		// add to wishlist
		$this->loader->add_action( 'wp_ajax_add_to_wishlist', $plugin_public, 'add_to_wishlist_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_add_to_wishlist', $plugin_public, 'add_to_wishlist_callback' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Addonify_Wishlist_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
