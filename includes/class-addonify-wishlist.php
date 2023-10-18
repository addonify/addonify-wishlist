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
 * @author     Adodnify <contact@addonify.com>
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
	 * True if wishlist table exists. Else false.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    True if wishlist table exists. Else false.
	 */
	protected $wishlist_table_exists = false;

	/**
	 * The wishlist database handler object.
	 *
	 * @since    2.0.6
	 * @access   private
	 * @var      object    $database_handler    The wishlist database handler object.
	 */
	protected $database_handler;

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
		$this->rest_api();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Addonify_Wishlist_Loader. Orchestrates the hooks of the plugin.
	 * - Addonify_Wishlist_I18n. Defines internationalization functionality.
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

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/addonify-wishlist-user-meta-functions.php';

		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-database-handler.php';

		$database_handler = new Addonify_Wishlist_Database_Handler();

		$this->wishlist_table_exists = $database_handler->check_wishlist_table_exists();

		if ( $this->wishlist_table_exists ) {

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-handler.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-addonify-wishlist-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/setting-functions/helpers.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/setting-functions/settings-v2.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-rest-api.php';

		if ( $this->wishlist_table_exists ) {

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/addonify-wishlist-helper-functions.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/addonify-wishlist-template-functions.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/addonify-wishlist-template-hooks.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-addonify-wishlist-public.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/guest-ajax-callbacks.php';
		} else {

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/deprecated/addonify-wishlist-helper-functions-deprecated.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/deprecated/addonify-wishlist-template-functions-deprecated.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/deprecated/addonify-wishlist-template-hooks-deprecated.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-addonify-wishlist-public-deprecated.php';
		}

		/**
		 * User data processing functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/udp/init.php';

		$this->loader = new Addonify_Wishlist_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Addonify_Wishlist_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Addonify_Wishlist_I18n();

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

		$plugin_admin = new Addonify_Wishlist_Admin(
			$this->get_plugin_name(),
			$this->get_version()
		);

		if ( ! $this->wishlist_table_exists ) {
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'maybe_show_insert_table_notice' );
		}

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'maybe_show_table_created_message' );

		// Display review message on certain time interval if not already reviewed.
		if ( ! get_transient( 'addonify_wishlist_ask_for_review_transient' ) ) {
			$review_status = get_option( 'addonify_wishlist_plugin_review_status' );
			if ( ! $review_status ) {
				update_option( 'addonify_wishlist_plugin_review_status', 'later' );
				set_transient( 'addonify_wishlist_ask_for_review_transient', '1', 3 * DAY_IN_SECONDS );
			} elseif ( 'reviewed' !== $review_status ) {
				$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_add_a_review_notice' );
			}
		}

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		/**
		 * Maybe create table when plugin updates.
		 */
		$this->loader->add_action( 'upgrader_process_complete', $this, 'check_for_table', 20, 2 );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_init' );

		// admin menu.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_callback', 20 );

		// custom link in plugins.php page in wp-admin.
		$this->loader->add_filter( 'plugin_action_links_' . ADDONIFY_WISHLIST_BASENAME, $plugin_admin, 'plugin_action_links', 10, 2 );

		$this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'plugin_row_meta', 10, 2 );

		// add custom post status "Addonify Wishlist Page" after page name.
		$this->loader->add_filter( 'display_post_states', $plugin_admin, 'display_custom_post_states_after_page_title', 10, 2 );
	}

	/**
	 * Register rest api endpoints for admin settings page.
	 *
	 * @since    1.0.7
	 * @access   private
	 */
	private function rest_api() {

		$plugin_rest = new Addonify_Wishlist_Rest_API();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		if ( $this->wishlist_table_exists ) {

			$plugin_public = new Addonify_Wishlist_Public( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'wp_login', $plugin_public, 'maybe_create_and_migrate_wishlist_data', 10, 2 );

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 15 );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 15 );

			$this->loader->add_action( 'init', $plugin_public, 'public_init' );
		} else {
			$plugin_public = new Addonify_Wishlist_Public_Deprecated( $this->get_plugin_name(), $this->get_version() );
			$this->loader->add_action( 'init', $plugin_public, 'public_init' );
		}
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

	/**
	 * Function runs during upgrade.
	 *
	 * @param object $upgrader_object Upgrader Object.
	 * @param array  $options Options.
	 */
	public function check_for_table( $upgrader_object, $options ) {

		$current_plugin_path_name = plugin_basename( ADDONIFY_WISHLIST_PLUGIN_FILE );

		if (
			( isset( $options['action'] ) && 'update' === $options['action'] ) &&
			( isset( $options['type'] ) && 'plugin' === $options['type'] ) &&
			isset( $options['plugins'] )
		) {
			foreach ( $options['plugins'] as $each_plugin ) {
				if ( $each_plugin === $current_plugin_path_name ) {
					$database_handler = new Addonify_Wishlist_Database_Handler();

					$database_handler->create_table();
					$database_handler->migrate_wishlist_data();
				}
			}
		}
	}
}

