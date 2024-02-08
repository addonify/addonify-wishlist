<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 * @author     Adodnify <contact@addonify.com>
 */
class Addonify_Wishlist_Activator {

	/**
	 * Tasks that needs to be done during plugin activation.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/addonify-wishlist-user-meta-functions.php';

		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-database-handler.php';

		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-addonify-wishlist-handler.php';

		$database_handler = new Addonify_Wishlist_Database_Handler();

		$wishlist_table_exists = $database_handler->check_wishlist_table_exists();

		if ( ! $wishlist_table_exists ) {

			$database_handler->create_table();

			$database_handler->migrate_wishlist_data( get_current_user_id() );
		} else {

			$database_handler->delete_where( array( 'user_id' => 0 ) );

			$wishlist_handler = Addonify_Wishlist_Handler::get_instance();

			if ( ! $wishlist_handler->get_default_wishlist_id( get_current_user_id() ) ) {
				$database_handler = new Addonify_Wishlist_Database_Handler();
				$database_handler->migrate_wishlist_data( get_current_user_id() );
			}
		}

		self::create_wishlist_page();

		set_transient( 'addonify_wishlist_ask_for_review_transient', '1', 5 * DAY_IN_SECONDS );
	}

	/**
	 * Create wishlist page.
	 */
	private static function create_wishlist_page() {

		// create page only once.
		// do not regenerate even if plugin is deleted by user.

		if ( get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page' ) ) {

			return;
		}

		$args = array(
			'pagename' => __( 'Wishlist', 'addonify-wishlist' ),
		);

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			update_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page', $query->post->ID );
			return;
		}

		// Create page object.
		$new_page = array(
			'post_title'   => __( 'Wishlist', 'addonify-wishlist' ),
			'post_content' => '[addonify_wishlist]',
			'post_status'  => 'publish',
			'post_author'  => get_current_user_id(),
			'post_type'    => 'page',
		);

		// Insert the post into the database.
		$page_id = wp_insert_post( $new_page );

		update_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page', $page_id );

	}
}
