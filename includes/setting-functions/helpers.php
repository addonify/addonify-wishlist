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

if ( ! function_exists( 'addonify_wishlist_get_shop_page_id' ) ) {
	/**
	 * Get the shop page id if exists.
	 *
	 * @since 2.0.0
	 * @return string|int
	 */
	function addonify_wishlist_get_shop_page_id() {

		$page = addonify_wishlist_get_page_by_title( 'Shop' );
		if ( $page && '' !== $page ) {
			return $page->ID;
		}
		return '';
	}
}

if ( ! function_exists( 'addonify_wishlist_get_wishlist_page_id' ) ) {
	/**
	 * Get the wishlist page id if exists.
	 *
	 * @since 2.0.0
	 * @return string|int
	 */
	function addonify_wishlist_get_wishlist_page_id() {

		$page = addonify_wishlist_get_page_by_title( 'Wishlist' );
		if ( $page && '' !== $page ) {
			return $page->ID;
		}
		return '';
	}
}

if ( ! function_exists( 'addonify_wishlist_get_page_by_title' ) ) {
	/**
	 * Get page by title.
	 *
	 * @since 2.0.0
	 *
	 * @param string $title Title.
	 * @return object|false Page object if found, false otherwise.
	 */
	function addonify_wishlist_get_page_by_title( $title ) {

		$pages = get_pages();

		if ( ! empty( $pages ) ) {

			foreach ( $pages as $page ) {

				if ( $page->post_title === $title ) {
					return $page;
				}
			}
		}

		return false;
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
