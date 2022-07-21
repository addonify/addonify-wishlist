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

		// create page only once.
		// do not regenerate even if plugin is deleted by user.

		if ( get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page' ) ) {
			
			return;
		}
		
		// Create page object.
		$new_page = array(
			'post_title' => __( 'Wishlist', 'addonify-wishlist' ),
			'post_content' => '[addonify_wishlist]',
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
			'post_type' => 'page',
		);

		// Insert the post into the database.
		$page_id = wp_insert_post( $new_page );

		update_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page', $page_id );
	}

}
