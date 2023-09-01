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



if ( ! function_exists( 'addonify_wishlist_get_user_default_wishlist_from_meta' ) ) {
	/**
	 * Gets user's default wishlist from the user meta.
	 *
	 * @since 2.0.6
	 *
	 * @param int $user_id User ID.
	 * @return int|boolean Wishlist ID if found. Else false.
	 */
	function addonify_wishlist_get_user_default_wishlist_from_meta( $user_id = 0 ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		if ( ! is_multisite() ) {
			return get_user_meta( $user_id, 'addonify_wishlist_default_wishlist', true );
		} else {
			$site_url = get_site_url();

			$user_wishlist_meta = wp_unslash( get_user_meta( $user_id, 'addonify_wishlist_default_wishlist', true ) );
			$user_wishlist_meta = json_decode( $user_wishlist_meta, true );

			if ( isset( $user_wishlist_meta[ $site_url ] ) && ! empty( $user_wishlist_meta[ $site_url ] ) ) {
				return $user_wishlist_meta[ $site_url ];
			}
		}

		return false;
	}
}


if ( ! function_exists( 'addonify_wishlist_set_user_default_wishlist_in_meta' ) ) {
	/**
	 * Sets user's default wishlist in the user meta.
	 *
	 * @since 2.0.6
	 *
	 * @param int $user_id User ID.
	 * @param int $wishlist_id Wishlist ID.
	 */
	function addonify_wishlist_set_user_default_wishlist_in_meta( $user_id = 0, $wishlist_id = 0 ) {

		if ( ! $wishlist_id ) {
			return;
		}

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$site_url = get_site_url();

		if ( ! is_multisite() ) {

			$user_default_wishlist = get_user_meta( $user_id, 'addonify_wishlist_default_wishlist', true );

			if ( ! $user_default_wishlist ) {
				update_user_meta( $user_id, 'addonify_wishlist_default_wishlist', $wishlist_id );
			}
		} else {

			$user_default_wishlist = wp_unslash( get_user_meta( $user_id, 'addonify_wishlist_default_wishlist', true ) );

			if ( ! $user_default_wishlist ) {
				$default_wishlists = array(
					$site_url => $wishlist_id,
				);

				update_user_meta( $user_id, 'addonify_wishlist_default_wishlist', wp_json_encode( $default_wishlists ) );
			} else {

				$user_default_wishlist = json_decode( $user_default_wishlist, true );

				if ( ! isset( $user_default_wishlist[ $site_url ] ) ) {
					$user_default_wishlist[ $site_url ] = $wishlist_id;
				}

				update_user_meta( $user_id, 'addonify_wishlist_default_wishlist', wp_json_encode( $user_default_wishlist ) );
			}
		}
	}
}


if ( ! function_exists( 'addonify_wishlist_update_user_default_wishlist_in_meta' ) ) {
	/**
	 * Gets user's default wishlist from the user meta.
	 *
	 * @since 2.0.6
	 *
	 * @param int $user_id User ID.
	 * @param int $wishlist_id Wishlist ID.
	 * @return boolean true if updated successfully. Else false.
	 */
	function addonify_wishlist_update_user_default_wishlist_in_meta( $user_id = 0, $wishlist_id = 0 ) {

		if ( ! $wishlist_id ) {
			return false;
		}

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		if ( ! is_multisite() ) {
			return update_user_meta( $user_id, 'addonify_wishlist_default_wishlist', $wishlist_id );
		} else {
			$site_url = get_site_url();

			$user_wishlist_meta = wp_unslash( get_user_meta( $user_id, 'addonify_wishlist_default_wishlist', true ) );
			$user_wishlist_meta = json_decode( $user_wishlist_meta, true );

			$user_wishlist_meta[ $site_url ] = $wishlist_id;

			return update_user_meta( $user_id, 'addonify_wishlist_default_default', wp_json_encode( $user_wishlist_meta ) );
		}

		return false;
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
