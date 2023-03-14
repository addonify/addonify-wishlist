<?php
/**
 * Define general settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_general_setting_fields' ) ) {
	/**
	 * General setting fields of plugin.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function addonify_wishlist_general_setting_fields() {

		return array(
			'enable_wishlist'                       => array(
				'label'       => __( 'Enable wishlist', 'addonify-wishlist' ),
				'description' => __( 'If disabled, addonify wishlist plugin functionality will not be functional.', 'addonify-wishlist' ),
				'type'        => 'switch',
				'className'   => '',
				'badge'       => 'Required',
				'value'       => addonify_wishlist_get_option( 'enable_wishlist' ),
			),
			'wishlist_page'                         => array(
				'type'        => 'select',
				'className'   => '',
				'placeholder' => __( 'Select a page', 'addonify-wishlist' ),
				'label'       => __( 'Wishlist Page', 'addonify-wishlist' ),
				'description' => __( 'Select a page to display wishlist table.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'choices'     => addonify_wishlist_get_pages(),
				'value'       => addonify_wishlist_get_option( 'wishlist_page' ),
			),
			'require_login'                         => array(
				'type'        => 'switch',
				'label'       => __( 'Require Login', 'addonify-wishlist' ),
				'description' => __( 'A user is required to be logged-in inorder to add products in the wishlist.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'require_login' ),
			),
			'if_not_login_action'                   => array(
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
			'after_add_to_wishlist_action'          => array(
				'type'        => 'select',
				'className'   => '',
				'label'       => __( 'After Add to Wishlist Action', 'addonify-wishlist' ),
				'description' => __( 'Choose what to do after a product is successfully added to the wishlist.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'after_add_to_wishlist_aciton' ),
				'choices'     => array(
					'show_popup_notice'         => __( 'Show Popup Notice', 'addonify-wishlist' ),
					'redirect_to_wishlist_page' => __( 'Redirect to Wishlist Page', 'addonify-wishlist' ),
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
			'ajaxify_remove_from_wishlist_button'   => array(
				'type'        => 'switch',
				'label'       => __( 'Ajaxify Remove from Wishlist Action', 'addonify-wishlist' ),
				'description' => __( 'Remove the product from wishlist with ajax call.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist', 'require_login' ),
				'value'       => addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ),
			),
			'undo_action_prelabel_text'             => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Text Before Undo Action Label', 'addonify-wishlist' ),
				'description' => __( 'Text displayed before undo action label. The placeholder, \'{product_name}\', when used,  is replaced by Product Name.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'undo_action_prelabel_text' ),
			),
			'undo_action_label'                     => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Undo Action Label', 'addonify-wishlist' ),
				'description' => __( 'Set undo action label.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'undo_action_label' ),
			),
			'undo_notice_timeout'                   => array(
				'type'        => 'number',
				'className'   => '',
				'typeStyle'   => 'toggle', // Values for typeStyle are default, toggle & slider.
				'label'       => __( 'Undo Notice Timeout (in seconds)', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'description' => __( 'Set the time till when the undo notice is to displayed.', 'addonify-wsihlist' ),
				'value'       => addonify_wishlist_get_option( 'undo_notice_timeout' ),
			),
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_general_styles_settings_fields' ) ) {
	/**
	 * Style setting fields of plugin.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function addonify_wishlist_general_styles_settings_fields() {

		return array(
			'load_styles_from_plugin' => array(
				'type'        => 'switch',
				'className'   => '',
				'label'       => __( 'Enable Styles from Plugin', 'addonify-wishlist' ),
				'description' => __( 'Enable to apply styles and colors from the plugin.', 'addonify-wishlist' ),
				'value'       => addonify_wishlist_get_option( 'load_styles_from_plugin' ),
			),
		);
	}
}
