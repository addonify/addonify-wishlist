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

		global $addonify_wishlist;
		$addonify_wishlist->create_table();
		$wishlist_data = get_user_meta( get_current_user_id(), 'addonify-wishlist', true );
		if ( ! empty( $wishlist_data ) ) {
			$wishlist_data = json_decode( $wishlist_data, true );

			foreach ( $wishlist_data as $index => $row ) {
				$insert_data = array();

				$insert_data['site_url']            = $index;
				$insert_data['user_id']             = get_current_user_id();
				$insert_data['wishlist_name']       = array_key_first( $row );
				$insert_data['wishlist_visibility'] = 'public';

				$wishlist_id = $addonify_wishlist->insert_row( $insert_data );

				$wishlist_single_data = (array) $row[ array_key_first( $row ) ];
				if ( $wishlist_id && ! empty( $wishlist_single_data['products'] ) ) {
					$insert_data = array();
					foreach ( $wishlist_single_data['products'] as $i => $product_id ) {
						$insert_data[ $i ]['site_url']           = $index;
						$insert_data[ $i ]['user_id']            = get_current_user_id();
						$insert_data[ $i ]['product_id']         = $product_id;
						$insert_data[ $i ]['parent_wishlist_id'] = $wishlist_id;
					}
					$addonify_wishlist->insert_multiple_rows( $insert_data );
				}
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
