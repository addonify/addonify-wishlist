<?php 

if ( ! function_exists( 'addonify_wishlist_get_cart_products' ) ) {

	function addonify_wishlist_get_cart_products() {

		$cart_contents = WC()->cart->get_cart_contents();

		if ( 
			is_array( $cart_contents ) &&
			count( $cart_contents ) > 0 
		) {

			$cart_products = array();

			foreach ( $cart_contents as $cart_content ) {
				$cart_products[] = $cart_content['product_id'];
			}

			return $cart_products;
		}

		return false;
	}
}