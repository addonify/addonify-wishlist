<?php

if ( ! function_exists( 'addonify_wishlist_is_woocommerce_active' ) ) {

    function addonify_wishlist_is_woocommerce_active() {

        if ( in_array( 'woocommerce/woocommerce.php', get_option('active_plugins') ) ) {

            return true;
        }

        return false;
    }
}


/**
 * Get the items in the wishlist.
 * 
 * @since 1.0.0
 * @return array $wishlist_items Array of wishlist items.
 */
if ( ! function_exists( 'addonify_wishlist_get_wishlist_items' ) ) {

	function addonify_wishlist_get_wishlist_items() {

		/*
		// For future update.
		$wishlist_items = null;

		if ( is_user_logged_in() ) {
			$current_user_id = get_current_user_id();
			$wishlist_items = get_user_meta( $current_user_id, "_addonify-wishlist", true );
		} else {
		} */

		$wishlist_cookie = ( array_key_exists( 'addonify-wishlist', $_COOKIE ) ) ? json_decode( wp_unslash( $_COOKIE['addonify-wishlist'] ), true ) : array();
		
		return ( array_key_exists( 'wishlist_items', $wishlist_cookie ) ) ? $wishlist_cookie['wishlist_items'] : array(); 
	}
}


/**
 * Get the count of items in the wishlist.
 * 
 * @since 1.0.0
 * @return int|boolean Count ot items if found else false.
 */
if ( ! function_exists( 'addonify_wishlist_get_wishlist_items_count' ) ) {

	function addonify_wishlist_get_wishlist_items_count() {

		$wishlist_items = addonify_wishlist_get_wishlist_items();

		return ( is_array( $wishlist_items ) ) ? count( $wishlist_items ) : false;
	}
}


/**
 * Check if product is in wishlist.
 * 
 * @since 1.0.0
 * @param int $product_id Product ID.
 * @return boolean True if product is in wishlist, false otherwise.
 */
if ( ! function_exists( 'addonify_wishlist_is_product_in_wishlist' ) ) {

	function addonify_wishlist_is_product_in_wishlist( $product_id ) {

		$wishlist_items = addonify_wishlist_get_wishlist_items();

		if ( 
			is_array( $wishlist_items ) &&
			count( $wishlist_items ) > 0
		) {
			return array_key_exists( $product_id, $wishlist_items );
		}

		return false;
	}
}


/**
 * Get wishlist button label.
 * 
 * If $in_wishlist is true, then already in wishlist button label will be returned. Else, active wishlist button label  * will be returned.
 * 
 * @since 1.0.0
 * @param boolean $in_wishlist.
 * @return string .
 */
if ( ! function_exists( 'addonify_wishlist_get_button_label' ) ) {

	function addonify_wishlist_get_button_label( $in_wishlist = false ) {

		$addonify_db_initial = ADDONIFY_WISHLIST_DB_INITIALS;

		return  ( ! $in_wishlist ) ? get_option( "{$addonify_db_initial}btn_label" ) : get_option( "{$addonify_db_initial}btn_label_if_added_to_wishlist" );
	}
}


/**
 * Get wishlist page url.
 * 
 * @since 1.0.0
 * @return string|boolean $wishlist_page_url Wishlist page url if found else false.
 */
if ( ! function_exists( 'addonify_wishlist_get_wishlist_page_url' ) ) {

	function addonify_wishlist_get_wishlist_page_url() {

		$wislist_page = get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page' );

		if ( $wislist_page ) {
			return get_permalink( $wislist_page );
		} else {
			return false;
		}
	}
}