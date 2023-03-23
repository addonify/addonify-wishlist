<?php
/**
 * The file that defines the helper functions.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

if ( ! function_exists( 'addonify_wishlist_is_woocommerce_active' ) ) {

	/**
	 * Check if woocommerce is active.
	 *
	 * @return boolean If woocommerce is active.
	 */
	function addonify_wishlist_is_woocommerce_active() {

		if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true ) ) {

			return true;
		}

		return false;
	}
}


if ( ! function_exists( 'addonify_wishlist_get_wishlist_items' ) ) {
	/**
	 * Get the items in the wishlist.
	 *
	 * @since 1.0.0
	 * @return array $wishlist_items Array of wishlist items.
	 */
	function addonify_wishlist_get_wishlist_items() {
		if ( is_user_logged_in() ) {
			$wishlist      = new Addonify\Wishlist();
			$user_id       = get_current_user_id();
			$wishlist_data = array();
			foreach ( $wishlist->get_all_rows() as $row ) {
				if ( get_bloginfo( 'url' ) === $row->site_url && $user_id === (int) $row->user_id ) {
					if ( null !== $row->wishlist_name ) {
						$wishlist_data[ $row->id ] = array(
							'name'       => $row->wishlist_name,
							'visibility' => $row->wishlist_visibility,
						);
					} else {
						if ( array_key_exists( $row->parent_wishlist_id, $wishlist_data ) ) {
							$wishlist_data[ $row->parent_wishlist_id ]['product_ids'][] = (int) $row->product_id;
						}
					}
				}
			}
			return $wishlist_data;
		}
		return array();
	}
}

if ( ! function_exists( 'addonify_wishlist_get_wishlist_items_count' ) ) {

	/**
	 * Get the count of items in the wishlist.
	 *
	 * @since 1.0.0
	 * @return int Count of items.
	 */
	function addonify_wishlist_get_wishlist_items_count() {
		$items = addonify_wishlist_get_wishlist_items();
		if ( is_countable( $items ) ) {
			$count = 0;
			foreach ( $items as $item ) {
				if ( array_key_exists( 'product_ids', $item ) && is_array( $item['product_ids'] ) ) {
					$count += count( $item['product_ids'] );
				}
			}
			return $count;
		}
		return 0;
	}
}

if ( ! function_exists( 'addonify_wishlist_is_product_in_wishlist' ) ) {
	/**
	 * Check if product is in wishlist.
	 *
	 * @since 1.0.0
	 * @param int $product_id Product ID.
	 * @return boolean True if product is in wishlist, false otherwise.
	 */
	function addonify_wishlist_is_product_in_wishlist( $product_id ) {

		$wishlist_items = addonify_wishlist_get_wishlist_items();
		if (
			is_array( $wishlist_items ) &&
			count( $wishlist_items ) > 0
		) {
			foreach ( $wishlist_items as $item ) {
				if ( array_key_exists( 'product_ids', $item ) && is_array( $item['product_ids'] ) ) {
					if ( in_array( (int) $product_id, $item['product_ids'], true ) ) {
						return true;
					}
				}
			}
		}

		return false;
	}
}

if ( ! function_exists( 'addonify_wishlist_is_product_in_this_wishlist' ) ) {
	/**
	 * Check if product is in wishlist.
	 *
	 * @since 1.0.0
	 * @param int $wishlist_id wishlist ID.
	 * @param int $product_id Product ID.
	 * @return boolean True if product is in wishlist, false otherwise.
	 */
	function addonify_wishlist_is_product_in_this_wishlist( $wishlist_id, $product_id ) {

		$wishlist_items = addonify_wishlist_get_wishlist_items();

		if (
			is_array( $wishlist_items ) &&
			count( $wishlist_items ) > 0
		) {
			if ( array_key_exists( (int) $wishlist_id, $wishlist_items ) && array_key_exists( 'product_ids', $wishlist_items[ $wishlist_id ] ) ) {
				return in_array( (int) $product_id, $wishlist_items[ $wishlist_id ]['product_ids'], true );
			}
		}

		return false;
	}
}

if ( ! function_exists( 'addonify_wishlist_get_button_label' ) ) {

	/**
	 * Get wishlist button label.
	 * If $in_wishlist is true, then already in wishlist button label will be returned. Else, active wishlist button label  * will be returned.
	 *
	 * @since 1.0.0
	 * @param boolean $in_wishlist If the item is in wishlist.
	 * @return string .
	 */
	function addonify_wishlist_get_button_label( $in_wishlist = false ) {

		$addonify_db_initial = ADDONIFY_WISHLIST_DB_INITIALS;

		return ( ! $in_wishlist ) ? get_option( "{$addonify_db_initial}btn_label" ) : get_option( "{$addonify_db_initial}btn_label_if_added_to_wishlist" );
	}
}

if ( ! function_exists( 'addonify_wishlist_get_wishlist_page_url' ) ) {

	/**
	 * Get wishlist page url.
	 *
	 * @since 1.0.0
	 * @return string|boolean $wishlist_page_url Wishlist page url if found else false.
	 */
	function addonify_wishlist_get_wishlist_page_url() {

		$wislist_page = get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page' );

		if ( $wislist_page ) {
			return get_permalink( $wislist_page );
		} else {
			return false;
		}
	}
}
