<?php
/**
 * Collection of functions to handle AJAX request for logged in user.
 *
 * @since 2.0.6
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

if ( ! function_exists( 'addonify_wishlist_add_to_wishlist_ajax_handler' ) ) {
	/**
	 * Callback function to handle AJAX request to add product into the wishlist.
	 *
	 * @since 1.0.0
	 */
	function addonify_wishlist_add_to_wishlist_ajax_handler() {

		if ( ! wp_doing_ajax() ) {
			return;
		}

		$response_data = array(
			'success' => false,
			'message' => '',
		);

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, 'addonify-wishlist' )
		) {
			$response_data['message'] = esc_html__( 'Invalid security token.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

		if ( ! $product_id ) {
			$response_data['message'] = esc_html__( 'Invalid product id.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			$response_data['message'] = esc_html__( 'Invalid product.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		if ( addonify_wishlist_is_product_in_wishlist( $product_id ) ) {
			$response_data['message'] = esc_html( addonify_wishlist_get_option( 'product_already_in_wishlist_text' ) );
			wp_send_json( $response_data );
		}

		if ( addonify_wishlist_add_product_to_wishlist( $product_id ) ) {
			$response_data['success']    = true;
			$response_data['itemsCount'] = addonify_wishlist_get_wishlist_items_count();

			$has_wishlist_sidebar = isset( $_POST['has_wishlist_sidebar'] ) ? true : false; // phpcs:ignore

			$has_wishlist_table = isset( $_POST['has_wishlist_table'] ) ? true : false; // phpcs:ignore

			$response_data['success'] = true;

			if ( $has_wishlist_sidebar ) {
				ob_start();
				do_action( 'addonify_wishlist_render_sidebar_product_row', $product );
				$response_data['sidebarProductRowContent'] = ob_get_clean();
			}

			if ( $has_wishlist_table ) {
				ob_start();
				do_action( 'addonify_wishlist_render_table_product_row', $product );
				$response_data['tableProductRowContent'] = ob_get_clean();
			}

			wp_send_json( $response_data );
		} else {
			$response_data['message'] = esc_html( addonify_wishlist_get_option( 'could_not_add_to_wishlist_error_description' ) );
			wp_send_json( $response_data );
		}
	}
}


if ( ! function_exists( 'addonify_wishlist_remove_from_wishlist_ajax_handler' ) ) {
	/**
	 * Callback function to handle AJAX request to remove product from the wishlist.
	 *
	 * @since 1.0.0
	 */
	function addonify_wishlist_remove_from_wishlist_ajax_handler() {

		if ( ! wp_doing_ajax() ) {
			return;
		}

		$response_data = array(
			'success' => false,
			'message' => '',
		);

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, 'addonify-wishlist' )
		) {
			$response_data['message'] = esc_html__( 'Invalid security token.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

		if ( ! $product_id ) {
			$response_data['message'] = esc_html__( 'Invalid product id.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			$response_data['message'] = esc_html__( 'Invalid product.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		if ( ! addonify_wishlist_is_product_in_wishlist( $product_id ) ) {
			$response_data['message'] = esc_html__( '{product_name} does not exist in the wishlist.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		if ( addonify_wishlist_remove_product_from_wishlist( $product_id ) ) {
			$response_data['success']    = true;
			$response_data['itemsCount'] = addonify_wishlist_get_wishlist_items_count();
			$response_data['message']    = esc_html__( '{product_name} has been removed from wishlist.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		} else {
			$response_data['message'] = esc_html( addonify_wishlist_get_option( 'could_not_remove_from_wishlist_error_description' ) );
			wp_send_json( $response_data );
		}
	}
}


if ( ! function_exists( 'addonify_wishlist_empty_wishlist_ajax_handler' ) ) {
	/**
	 * Callback function to handle AJAX request to empty the wishlist.
	 *
	 * @since 1.0.0
	 */
	function addonify_wishlist_empty_wishlist_ajax_handler() {

		if ( ! wp_doing_ajax() ) {
			return;
		}

		$response_data = array(
			'success' => false,
			'message' => '',
		);

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, 'addonify-wishlist' )
		) {
			$response_data['message'] = esc_html__( 'Invalid security token.', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}

		if ( addonify_wishlist_empty_wishlist() ) {
			$response_data['success'] = true;
			$response_data['message'] = esc_html( addonify_wishlist_get_option( 'wishlist_emptied_text' ) );
			wp_send_json( $response_data );
		} else {
			$response_data['message'] = esc_html__( 'Error emptying the wishlist!', 'addonify-wishlist' );
			wp_send_json( $response_data );
		}
	}
}
