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
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// load styles in this plugin page only.
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->settings_page_slug ) { // phpcs:ignore

			wp_enqueue_style( "{$this->plugin_name}-icon", plugin_dir_url( __FILE__ ) . 'app/fonts/addonify-wishlist/icon.css', array(), $this->version, 'all' );

			/**
			*
			* Load Inter & Manrope font locally.
			* 
			* @since 2.0.1
			*/

			wp_enqueue_style( "{$this->plugin_name}-inter", plugin_dir_url( __FILE__ ) . 'app/fonts/inter/inter.css', array(), $this->version, 'all' );

			wp_enqueue_style( "{$this->plugin_name}-manrope", plugin_dir_url( __FILE__ ) . 'app/fonts/manrope/manrope.css', array(), $this->version, 'all' );
		}

		// Load global admin styles.
		wp_enqueue_style( "{$this->plugin_name}-global-admin", plugin_dir_url( __FILE__ ) . 'resources/global.css', array(), $this->version, 'all' );
	}


	/**
	 * Admin initial functions.
	 */
	public function admin_init() {
		$this->maybe_create_table();

		$this->maybe_show_table_created_message();

		$this->maybe_update_user_review_status();
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
		<div id="addonify-wishlist-app"></div>
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
			get_post_type( $post->ID ) === 'page' &&
			(int) $post->ID === (int) $wishlist_page_id
		) {
			$states[] = __( 'Addonify Wishlist Page', 'addonify-wishlist' );
		}

		return $states;
	}

	/**
	 * Create wishlist table if it does not exists.
	 */
	public function maybe_create_table() {
		if ( isset( $_GET['addonify-Wishlist-Install-Table'] ) ) { // phpcs:ignore
			global $addonify_wishlist;
			$addonify_wishlist->create_table();
			$addonify_wishlist->migrate_wishlist_data();
			wp_safe_redirect( esc_html( add_query_arg( 'addonify-wishlist-table-installed', true, admin_url() ) ) );
			exit;
		}
	}

	/**
	 * Show table created message after table created.
	 */
	public function maybe_show_table_created_message() {
		add_action(
			'admin_notices',
			function () {
				if ( isset( $_GET['addonify-wishlist-table-installed'] ) ) { // phpcs:ignore
					global $addonify_wishlist;
					if ( $addonify_wishlist->check_wishlist_table_exists() ) {
						?>
						<div class="addonify-wishlist-wp-notice notice notice-success is-dismissible" id="addonify-wishlist-upgrade-notice">
							<p class="notice-description">
								<?php esc_html_e( 'The Addonify WooCommerce Wishlist database update has been completed. Thank you for updating to the latest version!', 'addonify-wishlist' ); ?>
							</p>
							<a class="button button-primary" href="<?php echo esc_url( admin_url() ); ?>">
								<?php esc_html_e( 'Thanks!', 'addonify-wishlist' ); ?>
							</a>
						</div>
						<?php
					} else {
						?>
						<div class="addonify-wishlist-wp-notice notice notice-error" id="addonify-wishlist-upgrade-notice">
							<h3 class="notice-heading">
								<?php esc_html_e( 'The Addonify WooCommerce Wishlist database could not be updated!', 'addonify-wishlist' ); ?>
							</h3>
							<p class="notice-description">
								<?php esc_html_e( 'An error occurred while updating the Addonify WooCommerce Wishlist database. Please try again, and if the issue persists, contact the plugin support team for assistance.', 'addonify-wishlist' ); ?>
							</p>
							<a href="<?php echo esc_html( add_query_arg( 'addonify-Wishlist-Install-Table', true, admin_url() ) ); ?>" class="button button-primary">
								<?php esc_html_e( 'Update database', 'addonify-wishlist' ); ?>
							</a>
						</div>
						<?php
					}
				}
			}
		);
	}

	/**
	 * Show insert table notice on admin dashboard if not exists.
	 */
	public function maybe_show_insert_table_notice() {
		global $addonify_wishlist;
		if ( ! $addonify_wishlist->check_wishlist_table_exists() && ! isset( $_GET['addonify-wishlist-table-installed'] ) ) { // phpcs:ignore
			add_action(
				'admin_notices',
				function () {
					?>
					<div class="addonify-wishlist-wp-notice notice notice-info" id="addonify-wishlist-upgrade-notice">
						<h3 class="notice-heading">
							<?php esc_html_e( 'Addonify WooCommerce Wishlist database update required!', 'addonify-wishlist' ); ?>
						</h3>
						<p class="notice-description">
							<?php esc_html_e( 'Please update your database to ensure the smooth operation of the plugin. The database update process may take a few moments, so we kindly ask for your patience.', 'addonify-wishlist' ); ?>
						</p>
						<a href="<?php echo esc_html( add_query_arg( 'addonify-Wishlist-Install-Table', true, admin_url() ) ); ?>" class="button button-primary">
							<?php esc_html_e( 'Update database', 'addonify-wishlist' ); ?>
						</a>
					</div>
					<?php
				}
			);
		}
	}

	/**
	 * Review notice update on user choice.
	 */
	public function maybe_update_user_review_status() {
		if ( isset( $_GET['addonify-Wishlist-review-notice-already-did'] ) ) { //phpcs:ignore
			update_option( 'addonify_wishlist_plugin_review_status', 'reviewed' );
			wp_safe_redirect( esc_url( admin_url() ) );
		}
		if ( isset( $_GET['addonify-Wishlist-review-notice-maybe-later'] ) ) { //phpcs:ignore
			set_transient( 'addonify_wishlist_ask_for_review_transient', '1', 3 * DAY_IN_SECONDS );
			wp_safe_redirect( esc_url( admin_url() ) );
		}
	}

	/**
	 * Show add a review admin notice.
	 *
	 * @since 2.0.0
	 */
	public function show_add_a_review_notice() {
		add_action(
			'load-index.php',
			function () {
				add_action(
					'admin_notices',
					function () {
						?>
						<div class="addonify-wishlist-wp-notice notice notice-info" id="addonify-wishlist-review-notice">
							<h3 class="notice-heading">
								<?php esc_html_e( 'Thank you for choosing Addonify WooCommerce Wishlist!', 'addonify-wishlist' ); ?>
							</h3>
							<p class="notice-description">
								<?php esc_html_e( 'We hope you are enjoying the plugin. If you have a few minutes to spare, please consider leaving a review. We would deeply appreciate it and be grateful to you. It would encourage and help us improve our plugin and make it better.', 'addonify-wishlist' ); ?>
							</p>
							<div class="action-buttons">
								<a target="_blank" href="<?php echo esc_html( 'https://wordpress.org/plugins/addonify-wishlist/#reviews' ); ?>" class="button button-primary">
									<?php esc_html_e( 'Okay, You got it!', 'addonify-wishlist' ); ?>
									<i class="dashicons dashicons-smiley"></i>
								</a>
								<a href="<?php echo esc_html( add_query_arg( 'addonify-Wishlist-review-notice-already-did', true, admin_url() ) ); ?>" class="button button-secondary">
									<?php esc_html_e( 'I already did', 'addonify-wishlist' ); ?>
								</a>
								<a href="<?php echo esc_html( add_query_arg( 'addonify-Wishlist-review-notice-maybe-later', true, admin_url() ) ); ?>" class="button button-secondary">
									<?php esc_html_e( 'Maybe later', 'addonify-wishlist' ); ?>
								</a>
							</div>
						</div>
						<?php
					}
				);
			}
		);
	}

}
