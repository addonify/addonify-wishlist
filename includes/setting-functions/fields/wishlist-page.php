<?php
/**
 * Define settings fields for wishlist page.
 *
 * @link       https://addonify.com/
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_page_settings_fields' ) ) {
	/**
	 * General setting fields for wishlist page.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function addonify_wishlist_page_settings_fields() {

		$pages = get_pages();
		foreach ( $pages as $page ) {
			$page_array[ $page->ID ] = $page->post_title;
		}

		return array(
			'empty_wishlist_label'                 => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Empty Wishlist Text', 'addonify-wishlist' ),
				'description' => __( 'Set empty wishlist text.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'empty_wishlist_label' ),
			),
			'clear_wishlist_label'                 => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Clear Wishlist Button Label', 'addonify-wishlist' ),
				'description' => __( 'Set clear wishlist button label.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'clear_wishlist_label' ),
			),
			'show_empty_wishlist_navigation_link'  => array(
				'type'        => 'switch',
				'className'   => '',
				'label'       => __( 'Display Link', 'addonify-wishlist' ),
				'description' => __( 'Display a link when wishlist is empty.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'show_empty_wishlist_navigation_link' ),
			),
			'empty_wishlist_navigation_link'       => array(
				'type'        => 'select',
				'className'   => '',
				'label'       => __( 'Link to Page', 'addonify-wishlist' ),
				'description' => __( 'Page to be linked in the link when wishlist is empty.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist', 'show_empty_wishlist_navigation_link' ),
				'choices'     => $page_array,
				'value'       => addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ),
			),
			'empty_wishlist_navigation_link_label' => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Link label', 'addonify-wishlist' ),
				'description' => __( 'Set label for the link.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist', 'show_empty_wishlist_navigation_link' ),
				'value'       => addonify_wishlist_get_option( 'empty_wishlist_navigation_link_label' ),
			),
		);
	}
}
