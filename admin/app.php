<?php

use Kucrut\Vite;

/**
*
* Check if the current page is udp engine page.
* @since 1.0.1
*/

if ( isset( $_GET['page'] ) && 'addonify_wishlist' === $_GET['page'] ) {
	add_action( 'admin_enqueue_scripts', function (): void {
		Vite\enqueue_asset(
			dirname( __FILE__ ) . '/app/dist',
			'admin/app/src/main.js',
			[
				'handle' => 'addonify-wishlist-admin',
				'dependencies' => [ 'wp-api-fetch', 'wp-i18n', 'lodash' ], // Dependencies.
				'css-dependencies' => [], // Optional style dependencies. Defaults to empty array.
				'css-media' => 'all', // Optional.
				'css-only' => false, // Optional. Set to true to only load style assets in production mode.
				'in-footer' => true, // Optional. Defaults to false.
			]
		);
	});
}