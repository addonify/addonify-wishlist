<?php
/**
 * Define popup modal settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      1.1.4
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_popup_modal_v_2_options' ) ) {
	/**
	 * Popup modal options.
	 *
	 * @return array
	 */
	function addonify_wishlist_popup_modal_v_2_options() {
		return array(
			'popup_button_options'    => array(
				'title'        => __( 'Popup Button Option', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'popup_close_btn_text' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Close Button Label', 'addonify-wishlist' ),
						'description' => __( 'Label for button to close the popup modal box.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'popup_close_btn_text' ),
					),
				),
			),
			'added_to_wishlist_modal' => array(
				'title'        => __( 'Added to Wishlist Modal', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'view_wishlist_btn_text'           => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'View Wishlist Button Link Label', 'addonify-wishlist' ),
						'description' => __( 'Label for button to link to wishlist page inside the popup modal box.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'view_wishlist_btn_text' ),
					),
					'product_added_to_wishlist_text'   => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product Added to Wishlist Text', 'addonify-wishlist' ),
						'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
					),
					'product_already_in_wishlist_text' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product Already in Wishlist Text', 'addonify-wishlist' ),
						'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
					),
				),
			),
			'error_modal'             => array(
				'title'        => __( 'Error Modal', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'could_not_add_to_wishlist_error_description' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product Could not be Added to Wishlist Text', 'addonify-wishlist' ),
						'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'could_not_add_to_wishlist_error_description' ),
					),
					'could_not_remove_from_wishlist_error_description' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product Could not be Removed from Wishlist Text', 'addonify-wishlist' ),
						'description' => __( '{product_name} placeholder will be replaced with the actual product name.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'could_not_remove_from_wishlist_error_description' ),
					),
				),
			),
			'login_modal'             => array(
				'title'        => __( 'Login Modal', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'login_required_message' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Login Required Description', 'addonify-wishlist' ),
						'description' => __( 'Message displayed in modal when login is required.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'login_required_message' ),
					),
					'login_btn_label'        => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Login Button Label', 'addonify-wishlist' ),
						'description' => __( 'Label for button to redirect to login page.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'login_btn_label' ),
					),
				),
			),
			'modal_colors'            => array(
				'title'        => __( 'Modal Colors', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'popup_modal_overlay_bg_color'     => array(
						'type'          => 'color',
						'label'         => __( 'Overlay Background Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_overlay_bg_color' ),
					),
					'popup_modal_bg_color'             => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_bg_color' ),
					),
					'popup_modal_icon_color'           => array(
						'type'          => 'color',
						'label'         => __( 'Icon Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_icon_color' ),
					),
					'popup_modal_text_color'           => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_text_color' ),
					),
					'popup_modal_btn_text_color'       => array(
						'type'          => 'color',
						'label'         => __( 'Buttons Label Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_btn_text_color' ),
					),
					'popup_modal_btn_text_color_hover' => array(
						'type'          => 'color',
						'label'         => __( 'Buttons On Hover Label Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_btn_text_color_hover' ),
					),
					'popup_modal_btn_bg_color'         => array(
						'type'          => 'color',
						'label'         => __( 'Buttons Background Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_btn_bg_color' ),
					),
					'popup_modal_btn_bg_color_hover'   => array(
						'type'          => 'color',
						'label'         => __( 'Buttons On Hover Background Color', 'addonify-wishlist' ),
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'popup_modal_btn_bg_color_hover' ),
					),
				),
			),
		);
	}
}

add_filter( 'addonify_wishlist_popup_modal_v_2_options', 'addonify_wishlist_popup_modal_v_2_options' );
