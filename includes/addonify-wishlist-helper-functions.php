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
	 * @return bool true if woocommerce is active, false otherwise.
	 */
	function addonify_wishlist_is_woocommerce_active() {
		if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true ) ) {
			return true;
		}
		return false;
	}
}


if ( ! function_exists( 'addonify_wishlist_get_user_default_wishlist' ) ) {
	/**
	 * Gets user's default wishlist ID.
	 *
	 * @since  2.0.6
	 */
	function addonify_wishlist_get_user_default_wishlist() {

		global $adfy_wishlist;

		return $adfy_wishlist->get_default_wishlist_id();
	}
}


if ( ! function_exists( 'addonify_wishlist_get_user_wishlists_data' ) ) {
	/**
	 * Get user's wishlists data.
	 *
	 * @since 1.0.0
	 *
	 * @param int $user_id User id.
	 * @return array Wishlists data.
	 */
	function addonify_wishlist_get_user_wishlists_data( $user_id = 0 ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		global $adfy_wishlist;

		return $adfy_wishlist->get_user_wishlists_data( $user_id );
	}
}


if ( ! function_exists( 'addonify_wishlist_get_wishlist_items' ) ) {
	/**
	 * Get the items in the wishlist.
	 *
	 * @since 1.0.0
	 *
	 * @param int $wishlist_id Wishlist ID.
	 * @return array $wishlist_items Array of wishlist items.
	 */
	function addonify_wishlist_get_wishlist_items( $wishlist_id = 0 ) {

		global $adfy_wishlist;

		return $adfy_wishlist->get_wishlist_items( $wishlist_id );
	}
}


if ( ! function_exists( 'addonify_wishlist_get_wishlist_items_count' ) ) {
	/**
	 * Get the count of items in the wishlist.
	 *
	 * @since 1.0.0
	 *
	 * @param int $wishlist_id Wishlist id.
	 * @return int Count of items.
	 */
	function addonify_wishlist_get_wishlist_items_count( $wishlist_id = 0 ) {

		$wishlist_items = addonify_wishlist_get_wishlist_items( $wishlist_id );

		return ( is_array( $wishlist_items ) ) ? count( $wishlist_items ) : 0;
	}
}


if ( ! function_exists( 'addonify_wishlist_is_product_in_wishlist' ) ) {
	/**
	 * Check if product is in wishlist.
	 *
	 * @since 1.0.0
	 *
	 * @param int $product_id Product ID.
	 * @param int $wishlist_id Wishlist ID.
	 * @return boolean True if product is in wishlist, false otherwise.
	 */
	function addonify_wishlist_is_product_in_wishlist( $product_id, $wishlist_id = 0 ) {

		$wishlist_items = addonify_wishlist_get_wishlist_items( $wishlist_id );

		return ( is_array( $wishlist_items ) && in_array( (int) $product_id, $wishlist_items, true ) ) ? true : false;
	}
}


if ( ! function_exists( 'addonify_wishlist_add_product_to_wishlist' ) ) {
	/**
	 * Adds a product into wishlist.
	 *
	 * @since 2.0.6
	 *
	 * @param int $product_id Product ID.
	 * @param int $wishlist_id Wishlist ID.
	 * @return boolean True if product is added into the wishlist, false otherwise.
	 */
	function addonify_wishlist_add_product_to_wishlist( $product_id, $wishlist_id = 0 ) {

		if ( ! $product_id || ! is_int( $product_id ) ) {
			return false;
		}

		global $adfy_wishlist;

		return $adfy_wishlist->add_to_wishlist( $product_id, $wishlist_id );
	}
}


if ( ! function_exists( 'addonify_wishlist_remove_product_from_wishlist' ) ) {
	/**
	 * Removes a product from wishlist.
	 *
	 * @since 2.0.6
	 *
	 * @param int $product_id Product ID.
	 * @param int $wishlist_id Wishlist ID.
	 * @return boolean True if product is removed from the wishlist, false otherwise.
	 */
	function addonify_wishlist_remove_product_from_wishlist( $product_id, $wishlist_id = 0 ) {

		if ( ! $product_id || ! is_int( $product_id ) ) {
			return false;
		}

		global $adfy_wishlist;

		return $adfy_wishlist->remove_from_wishlist( $product_id, $wishlist_id );
	}
}


if ( ! function_exists( 'addonify_wishlist_empty_wishlist' ) ) {
	/**
	 * Removes a product from wishlist.
	 *
	 * @since 2.0.6
	 *
	 * @param int $wishlist_id Wishlist ID.
	 * @return boolean True if wishlist is emptied, false otherwise.
	 */
	function addonify_wishlist_empty_wishlist( $wishlist_id = 0 ) {

		global $adfy_wishlist;

		return $adfy_wishlist->empty_wishlist( $wishlist_id );
	}
}


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



if ( ! function_exists( 'addonify_wishlist_prepare_wishlist_loop_products_data' ) ) {
	/**
	 * Prepare and return array of products data in the wishlist.
	 *
	 * @since 2.0.6
	 *
	 * @param array $wishlist_product_ids Array of product ids.
	 * @return array $products_data Array of products data.
	 */
	function addonify_wishlist_prepare_wishlist_loop_products_data( $wishlist_product_ids ) {

		$products_data = array();

		if ( is_array( $wishlist_product_ids ) ) {
			foreach ( $wishlist_product_ids as $product_id ) {
				$product = wc_get_product( $product_id );

				if ( $product ) {
					$product_data = array(
						'name'       => $product->get_name(),
						'permalink'  => $product->get_permalink(),
						'image'      => $product->get_image( 'woocommerce_thumbnail' ),
						'price'      => $product->get_price_html(),
						'data_attrs' => array(
							'product_id'   => $product->get_id(),
							'product_name' => $product->get_name(),
						),
					);

					$product_avaibility = addonify_wishlist_get_product_avaibility( $product );
					if ( $product_avaibility ) {
						$product_data['stock_status'] = $product_avaibility;
					}

					$products_data[ $product->get_id() ] = $product_data;
				}
			}
		}

		return $products_data;
	}
}



if ( ! function_exists( 'addonify_wishlist_get_error_ajax_response' ) ) {

	function addonify_wishlist_get_error_ajax_response( $error ) {

		$response = array(
			'success' => false,
		);

		switch ( $error ) {
			case 'invalid-nonce':
				$response['message']      = esc_html__( 'Invalid security token.', 'addonify-wishlist' );
				$response['modalContent'] = addonify_wishlist_get_ajax_modal_content(
					array(
						'message' => esc_html__( 'Invalid security token.', 'addonify-wishlist' ),
					)
				);
				break;
			case 'invalid-product-id':
				$response['message']      = esc_html__( 'Invalid product id.', 'addonify-wishlist' );
				$response['modalContent'] = addonify_wishlist_get_ajax_modal_content(
					array(
						'message' => esc_html__( 'Invalid product id.', 'addonify-wishlist' ),
					)
				);
				break;
			case 'invalid-product':
				$response['message']      = esc_html__( 'Invalid product.', 'addonify-wishlist' );
				$response['modalContent'] = addonify_wishlist_get_ajax_modal_content(
					array(
						'message' => esc_html__( 'Invalid product.', 'addonify-wishlist' ),
					)
				);
				break;
			default:
		}

		return apply_filters( 'addonify_wishlist_error_ajax_response', $response, $error );
	}
}


if ( ! function_exists( 'addonify_wishlist_get_default_wishlist_items_for_loop' ) ) {

	function addonify_wishlist_get_default_wishlist_items_for_loop() {

		$wishlist_items = array();

		if ( is_user_logged_in() ) {

			global $addonify_wishlist;
			if ( $addonify_wishlist->check_wishlist_table_exists() ) {
				$wishlist_items = addonify_wishlist_get_wishlist_items();
				if ( is_array( $wishlist_items ) && count( $wishlist_items ) > 0 ) {
					$wishlist_product_ids = addonify_wishlist_get_wishlist_items();
				}
			} else {
				$wishlist_items = addonify_wishlist_get_wishlist_items();
				if ( is_array( $wishlist_items ) && count( $wishlist_items ) > 0 ) {
					$wishlist_product_ids = addonify_wishlist_get_wishlist_items();
				}
			}
		}

		return apply_filters( 'addonify_wishlist_default_wishlist_items_for_loop', $wishlist_items );
	}
}
