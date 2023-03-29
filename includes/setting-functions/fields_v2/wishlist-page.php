<?php
/**
 * Define wishlist page settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      1.1.4
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_wishlist_page_v_2_options' ) ) {
	/**
	 * Wishlist page options.
	 *
	 * @return array
	 */
	function addonify_wishlist_wishlist_page_v_2_options() {
		return array(
			'wishlist_page_options' => array(
				'title'        => __( 'Wishlist Page Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'empty_wishlist_label'                 => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Empty Wishlist Text', 'addonify-wishlist' ),
						'description' => __( 'Set empty wishlist text.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'empty_wishlist_label' ),
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
						'choices'     => addonify_wishlist_get_pages(),
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
				),
			),
			'clear_wishlist_button' => array(
				'title'        => __( 'Clear Wishlist Button', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'show_wishlist_emptying_button' => array(
						'type'      => 'switch',
						'className' => '',
						'label'     => __( 'Show wishlist emptying button', 'addonify-wishlist' ),
						'dependent' => array( 'enable_wishlist' ),
						'value'     => addonify_wishlist_get_option( 'show_wishlist_emptying_button' ),
					),
					'clear_wishlist_label'          => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Clear Wishlist Button Label', 'addonify-wishlist' ),
						'description' => __( 'Set clear wishlist button label.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist', 'show_wishlist_emptying_button' ),
						'value'       => addonify_wishlist_get_option( 'clear_wishlist_label' ),
					),
				),
			),
		);
	}
}

add_filter( 'addonify_wishlist_wishlist_page_v_2_options', 'addonify_wishlist_wishlist_page_v_2_options' );
