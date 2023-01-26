<?php
/**
 * Define settings fields of popup modal box.
 *
 * @link       https://addonify.com/
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_modal_notice_settings_fields' ) ) {
	/**
	 * General setting fields for popup modal box.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function addonify_wishlist_modal_notice_settings_fields() {

		return array(
			'view_wishlist_btn_text'             => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'View Wishlist Button Link Label', 'addonify-wishlist' ),
				'description' => __( 'Label for button to link to wishlist page inside the popup modal box.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'view_wishlist_btn_text' ),
			),
			'product_added_to_wishlist_text'     => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Product Added to Wishlist Text', 'addonify-wishlist' ),
				'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
			),
			'product_already_in_wishlist_text'   => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Product Already in Wishlist Text', 'addonify-wishlist' ),
				'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
			),
			'product_removed_from_wishlist_text' => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Product Removed from Wishlist Text', 'addonify-wishlist' ),
				'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'product_removed_from_wishlist_text' ),
			),
			'show_wishlist_emptying_button'      => array(
				'type'      => 'switch',
				'className' => '',
				'label'     => __( 'Show wishlist emptying button', 'addonify-wishlist' ),
				'dependent' => array( 'enable_wishlist' ),
				'value'     => addonify_wishlist_get_option( 'show_wishlist_emptying_button' ),
			),
			'wishlist_emptied_text'              => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Wishlist Emptied Text', 'addonify-wishlist' ),
				'description' => __( 'Text to display in notice when wishlist is emptied.', 'addonify-wihlist' ),
				'dependent'   => array( 'enable_wishlist', 'show_wishlist_emptying_button' ),
				'value'       => addonify_wishlist_get_option( 'wishlist_emptied_text' ),
			),
			'login_btn_label'                    => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Login Button Label', 'addonify-wishlist' ),
				'description' => __( 'Label for button to redirect to login page.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'login_btn_label' ),
			),
			'popup_close_btn_text'               => array(
				'type'        => 'text',
				'className'   => '',
				'label'       => __( 'Close Button Label', 'addonify-wishlist' ),
				'description' => __( 'Label for button to close the popup modal box.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'popup_close_btn_text' ),
			),
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_modal_notice_styles_settings_fields' ) ) {
	/**
	 * Styles setting fields for popup modal box.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function addonify_wishlist_modal_notice_styles_settings_fields() {

		return array(
			'popup_modal_overlay_bg_color'     => array(
				'type'          => 'color',
				'label'         => __( 'Overlay Background Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_overlay_bg_color' ),
			),
			'popup_modal_bg_color'             => array(
				'type'          => 'color',
				'label'         => __( 'Background Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_bg_color' ),
			),
			'popup_modal_icon_color'           => array(
				'type'          => 'color',
				'label'         => __( 'Icon Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_icon_color' ),
			),
			'popup_modal_text_color'           => array(
				'type'          => 'color',
				'label'         => __( 'Text Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_text_color' ),
			),
			'popup_modal_btn_text_color'       => array(
				'type'          => 'color',
				'label'         => __( 'Buttons Label Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_btn_text_color' ),
			),
			'popup_modal_btn_text_color_hover' => array(
				'type'          => 'color',
				'label'         => __( 'Buttons On Hover Label Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_btn_text_color_hover' ),
			),
			'popup_modal_btn_bg_color'         => array(
				'type'          => 'color',
				'label'         => __( 'Buttons Background Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_btn_bg_color' ),
			),
			'popup_modal_btn_bg_color_hover'   => array(
				'type'          => 'color',
				'label'         => __( 'Buttons On Hover Background Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'popup_modal_btn_bg_color_hover' ),
			),
		);
	}
}
