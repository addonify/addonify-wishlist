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

if ( ! function_exists( 'addonify_wishlist_get_button_label' ) ) {

	/**
	 * Get wishlist button label.
	 * If $in_wishlist is true, then already in wishlist button label will be returned. Else, active wishlist button label  * will be returned.
	 *
	 * @since 1.0.0
	 * @param boolean $in_wishlist If the item is in wishlist.
	 * @return string
	 */
	function addonify_wishlist_get_button_label( $in_wishlist = false ) {

		return ( ! $in_wishlist ) ? addonify_wishlist_get_option( 'btn_label' ) : addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' );
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


if ( ! function_exists( 'addonify_wishlist_reverse_num' ) ) {
	/**
	 * Get number reversed.
	 *
	 * @since 1.0.0
	 *
	 * @param int $num Any number.
	 *
	 * @return int Number reversed.
	 */
	function addonify_wishlist_reverse_num( $num ) {

		$num    = absint( $num );
		$revnum = 0;
		while ( $num > 1 ) {
			$rem    = $num % 10;
			$revnum = ( $revnum * 10 ) + $rem;
			$num    = ( $num / 10 );
		}
		return $revnum;
	}
}


if ( ! function_exists( 'addonify_wishlist_get_product_avaibility' ) ) {
	/**
	 * Get product's avaibility.
	 *
	 * @since 2.0.2
	 *
	 * @param object $product Product.
	 * @return array $product_avaibility Array containing avaibility class and label.
	 */
	function addonify_wishlist_get_product_avaibility( $product ) {

		if ( ! $product ) {
			return false;
		}

		$product_status     = $product->get_stock_status();
		$product_avaibility = array();

		switch ( $product_status ) {
			case 'instock':
				$product_avaibility['class']      = 'in-stock';
				$product_avaibility['avaibility'] = apply_filters(
					'addonify_wishlist_product_in_stock_label',
					addonify_wishlist_get_option( 'product_in_stock_label' )
				);
				break;
			case 'outofstock':
				$product_avaibility['class']      = 'out-of-stock';
				$product_avaibility['avaibility'] = apply_filters(
					'addonify_wishlist_product_out_of_stock_label',
					addonify_wishlist_get_option( 'product_out_of_stock_label' )
				);
				break;
			default:
		}

		return $product_avaibility;
	}
}


if ( ! function_exists( 'addonify_wishlist_get_default_wishlist_items' ) ) {
	/**
	 * Get wishlist items of default wishlist from the user wishlist data.
	 *
	 * @since 2.0.6
	 *
	 * @param array $user_wishlists_data User wishlist data.
	 */
	function addonify_wishlist_get_default_wishlist_items( $user_wishlists_data ) {

		$first_index = array_key_first( $user_wishlists_data );

		return isset( $user_wishlists_data[ $first_index ]['product_ids'] )
		? $user_wishlists_data[ $first_index ]['product_ids'] :
		array();
	}
}
