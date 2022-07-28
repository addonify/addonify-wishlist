<?php 
/**
 * Get the list of pages.
 * 
 * @since 1.0.0
 * @return array $page_list
 */
if ( ! function_exists( 'addonify_wishlist_get_pages' ) ) {

	function addonify_wishlist_get_pages() {

		$pages  =  get_pages();

		$page_list = array();

		if( ! empty( $pages ) ) {

			foreach( $pages as $page ) {

				$page_list[ $page->ID ] = $page->post_title;
			}
		}

		return $page_list;
	}
} 



/**
 * Get the icons for the sidebar wishlist toggle button.
 * 
 * @since 1.0.0
 * @return array Array of icons.
 */
if ( ! function_exists( 'addonify_wishlist_get_sidebar_icons' ) ) {

	function addonify_wishlist_get_sidebar_icons() {

		return apply_filters( 
			'addonify_wishlist/sidebar_icons', 
			array(
				'heart-style-one' => '<i class="adfy-wishlist-icon heart-style-one"></i>',
				'heart-o-style-one' => '<i class="adfy-wishlist-icon heart-o-style-one"></i>',
				'heart-o-style-three' => '<i class="adfy-wishlist-icon heart-o-style-three"></i>',
				'flash' => '<i class="adfy-wishlist-icon flash"></i>',
				'eye' => '<i class="adfy-wishlist-icon eye"></i>',
				'loader' => '<i class="adfy-wishlist-icon loader"></i>',
				'settings' => '<i class="adfy-wishlist-icon settings"></i>'
			) 
		);
	}
}