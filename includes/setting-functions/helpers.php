<?php
/**
 * Helper functions for settings.
 *
 * @since      1.0.7
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions
 * @author     Addonify <contact@addonify.com>
 */

if ( ! function_exists( 'addonify_wishlist_get_pages' ) ) {
	/**
	 * Get the list of pages.
	 *
	 * @since 1.0.0
	 * @return array $page_list
	 */
	function addonify_wishlist_get_pages() {

		$pages = get_pages();

		$page_list = array();

		if ( ! empty( $pages ) ) {

			foreach ( $pages as $page ) {

				$page_list[ $page->ID ] = $page->post_title;
			}
		}

		return $page_list;
	}
}


if ( ! function_exists( 'addonify_wishlist_get_sidebar_icons' ) ) {
	/**
	 * Get the icons for the sidebar wishlist toggle button.
	 *
	 * @since 1.0.0
	 * @return array Array of icons.
	 */
	function addonify_wishlist_get_sidebar_icons() {

		return apply_filters(
			'addonify_wishlist_sidebar_icons',
			array(
				'heart-style-one'     => '<i class="adfy-wishlist-icon heart-style-one"></i>',
				'heart-o-style-one'   => '<i class="adfy-wishlist-icon heart-o-style-one"></i>',
				'heart-o-style-three' => '<i class="adfy-wishlist-icon heart-o-style-three"></i>',
				'flash'               => '<i class="adfy-wishlist-icon flash"></i>',
				'eye'                 => '<i class="adfy-wishlist-icon eye"></i>',
				'loader'              => '<i class="adfy-wishlist-icon loader"></i>',
				'settings'            => '<i class="adfy-wishlist-icon settings"></i>',
			)
		);
	}
}
