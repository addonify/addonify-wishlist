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
 * @author     Adodnify <info@addonify.com>
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

		if ( get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'page_id' ) ) {
			return;
		}

		$page_title = __( 'Wishlist', 'addonify-wishlist' );

		// Create page object.
		$new_page = array(
			'post_title' => $page_title,
			'post_content' => '[addonify_wishlist]',
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
			'post_type' => 'page',
		);

		// Insert the post into the database.
		$page_id = wp_insert_post( $new_page );

		update_option( ADDONIFY_WISHLIST_DB_INITIALS . 'page_id', $page_id );

		// add current page to menu item.
		$theme_locations = get_nav_menu_locations();
		$menu_obj = get_term( $theme_locations['primary'], 'nav_menu' );

		$term = get_term_by( 'name', $menu_obj->name, 'nav_menu' );
		$menu_id = $term->term_id;

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title' => $page_title,
				'menu-item-object-id' => $page_id,
				'menu-item-object' => 'page',
				'menu-item-status' => 'publish',
				'menu-item-type' => 'post_type',
			)
		);
	}

}
