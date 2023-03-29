<?php
/**
 * Define general settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      1.1.4
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_general_v_2_options' ) ) {
	/**
	 * General options.
	 *
	 * @return array
	 */
	function addonify_wishlist_general_v_2_options() {
		return array(
			'general_options'             => array(
				'title'        => __( 'General Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'enable_wishlist'                     => array(
						'label'       => __( 'Enable wishlist', 'addonify-wishlist' ),
						'description' => __( 'If disabled, addonify wishlist plugin functionality will not be functional.', 'addonify-wishlist' ),
						'type'        => 'switch',
						'className'   => '',
						'badge'       => 'Required',
						'value'       => addonify_wishlist_get_option( 'enable_wishlist' ),
					),
					'wishlist_page'                       => array(
						'type'        => 'select',
						'className'   => '',
						'placeholder' => __( 'Select a page', 'addonify-wishlist' ),
						'label'       => __( 'Wishlist Page', 'addonify-wishlist' ),
						'description' => __( 'Select a page to display wishlist table.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'choices'     => addonify_wishlist_get_pages(),
						'value'       => addonify_wishlist_get_option( 'wishlist_page' ),
					),
					'require_login'                       => array(
						'type'        => 'switch',
						'label'       => __( 'Require Login', 'addonify-wishlist' ),
						'description' => __( 'A user is required to be logged-in inorder to add products in the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'require_login' ),
					),
					'if_not_login_action'                 => array(
						'type'        => 'select',
						'className'   => '',
						'placeholder' => __( 'Select Action', 'addonify-wishlist' ),
						'label'       => __( 'If not login action', 'addonify-wishlist' ),
						'description' => __( 'If user is required to be logged-in, choose what to do if the user tries to add product into the wishlist..', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist', 'require_login' ),
						'choices'     => array(
							'default'    => __( 'Redirect to login page', 'addonify-wishlist' ),
							'show_popup' => __( 'Display login popup notice', 'addonify-wishlist' ),
						),
						'value'       => addonify_wishlist_get_option( 'if_not_login_action' ),
					),
					'after_add_to_wishlist_action'        => array(
						'type'        => 'select',
						'className'   => '',
						'label'       => __( 'After Add to Wishlist Action', 'addonify-wishlist' ),
						'description' => __( 'Choose what to do after a product is successfully added to the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'after_add_to_wishlist_action' ),
						'choices'     => array(
							'show_popup_notice'         => __( 'Show Popup Notice', 'addonify-wishlist' ),
							'redirect_to_wishlist_page' => __( 'Redirect to Wishlist Page', 'addonify-wishlist' ),
							'none'                      => __( 'None', 'addonify-wishlist' ),
						),
					),
					'remove_from_wishlist_if_added_to_cart' => array(
						'type'        => 'switch',
						'className'   => '',
						'label'       => __( 'Remove Product From Wishlist', 'addonify-wishlist' ),
						'description' => __( 'Remove the product from wishlist if the product is successfully added to cart.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ),
					),
					'ajaxify_remove_from_wishlist_button' => array(
						'type'        => 'switch',
						'label'       => __( 'Ajaxify Remove from Wishlist Action', 'addonify-wishlist' ),
						'description' => __( 'Remove the product from wishlist with ajax call.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist', 'require_login' ),
						'value'       => addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ),
					),
					'custom_css'                          => array(
						'type'           => 'textarea',
						'className'      => 'custom-css-box fullwidth',
						'inputClassName' => 'custom-css-textarea',
						'label'          => __( 'Custom CSS', 'addonify-wishlist' ),
						'description'    => __( 'If required, add your custom CSS code here.', 'addonify-wishlist' ),
						'placeholder'    => '#app { color: blue; }',
						'value'          => addonify_wishlist_get_option( 'custom_css' ),
					),
				),
			),
			'product_removal_undo_notice' => array(
				'title'        => __( 'Product Removal Undo Notice', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'undo_action_prelabel_text' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Text Before Undo Action Label', 'addonify-wishlist' ),
						'description' => __( 'Text displayed before undo action label. The placeholder, \'{product_name}\', when used,  is replaced by Product Name.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'undo_action_prelabel_text' ),
					),
					'undo_action_label'         => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Undo Action Label', 'addonify-wishlist' ),
						'description' => __( 'Set undo action label.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'undo_action_label' ),
					),
					'undo_notice_timeout'       => array(
						'type'        => 'number',
						'className'   => '',
						'typeStyle'   => 'toggle', // Values for typeStyle are default, toggle & slider.
						'label'       => __( 'Undo Notice Timeout (in seconds)', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'description' => __( 'Set the time till when the undo notice is to displayed.', 'addonify-wsihlist' ),
						'value'       => addonify_wishlist_get_option( 'undo_notice_timeout' ),
					),
				),
			),
		);
	}
}
add_filter( 'addonify_wishlist_general_v_2_options', 'addonify_wishlist_general_v_2_options' );
