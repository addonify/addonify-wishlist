<?php
/**
 * Define wishlist page settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      2.0.0
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
						'label'       => __( 'Text when the wishlist is empty', 'addonify-wishlist' ),
						'description' => __( 'Set the text when there are no products in the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'empty_wishlist_label' ),
					),
					'show_empty_wishlist_navigation_link'  => array(
						'type'        => 'switch',
						'className'   => '',
						'label'       => __( 'Display a link', 'addonify-wishlist' ),
						'description' => __( 'Enable this option to display a link to the selected page when the wishlist is empty.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'show_empty_wishlist_navigation_link' ),
					),
					'empty_wishlist_navigation_link'       => array(
						'type'        => 'select',
						'className'   => '',
						'label'       => __( 'Page to be linked', 'addonify-wishlist' ),
						'description' => __( 'Choose the page to be linked in the text when the wishlist is empty.', 'addonify-wishlist' ),
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
				'title'        => __( 'Button to Empty Wishlist Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'show_wishlist_emptying_button' => array(
						'type'      => 'switch',
						'className' => '',
						'label'     => __( 'Display button to empty wishlist', 'addonify-wishlist' ),
						'dependent' => array( 'enable_wishlist' ),
						'value'     => addonify_wishlist_get_option( 'show_wishlist_emptying_button' ),
					),
					'clear_wishlist_label'          => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Button label', 'addonify-wishlist' ),
						'description' => __( 'Set the label of the button to empty the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist', 'show_wishlist_emptying_button' ),
						'value'       => addonify_wishlist_get_option( 'clear_wishlist_label' ),
					),
				),
			),
		);
	}
}

add_filter( 'addonify_wishlist_wishlist_page_v_2_options', 'addonify_wishlist_wishlist_page_v_2_options' );
