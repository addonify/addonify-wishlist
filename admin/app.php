<?php
/**
 *
 * Check if the current page is udp engine page.
 *
 * @package Addonify_Wishlist
 * @since 1.0.1
 */

use Kucrut\Vite;


if ( isset( $_GET['page'] ) && 'addonify_wishlist' === $_GET['page'] ) { //phpcs:ignore
	$handle = 'addonify-wishlist-admin';
	add_action(
		'admin_enqueue_scripts',
		function () use ( $handle ): void {
			Vite\enqueue_asset(
				dirname( __FILE__ ) . '/app/dist',
				'admin/app/src/main.js',
				array(
					'handle'           => $handle,
					'dependencies'     => array( 'wp-api-fetch', 'wp-i18n', 'lodash' ), // Dependencies.
					'css-dependencies' => array(), // Optional style dependencies. Defaults to empty array.
					'css-media'        => 'all', // Optional.
					'css-only'         => false, // Optional. Set to true to only load style assets in production mode.
					'in-footer'        => true, // Optional. Defaults to false.
				)
			);

			wp_localize_script(
				$handle,
				'ADDONIFY_WISHLIST_LOCOLIZER',
				array(
					'admin_url'      => admin_url( '/' ),
					'ajax_url'       => admin_url( 'admin-ajax.php' ),
					'site_url'       => site_url( '/' ),
					'rest_namespace' => 'addonify_wishlist_options_api',
					'version_number' => ADDONIFY_WISHLIST_VERSION,
				)
			);
		}
	);
}
