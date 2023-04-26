<?php
/**
 * Define popup modal settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      2.0.0
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
			'added_to_wishlist_modal' => array(
				'title'        => __( 'Added to Wishlist Modal Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'view_wishlist_btn_text'           => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'View wishlist link button label', 'addonify-wishlist' ),
						'description' => __( 'Set the label to the button that links to the wishlist page within the popup modal.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'view_wishlist_btn_text' ),
					),
					'product_added_to_wishlist_text'   => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product added to wishlist text', 'addonify-wishlist' ),
						'description' => __( 'Set the text to be displayed when a product added to wishlist. Use, placeholder {product_name} to display name of the product.', 'addonify-wihlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
					),
					'product_already_in_wishlist_text' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product already in wishlist text', 'addonify-wishlist' ),
						'description' => __( 'Set the text to be displayed when a product that is already in the wishlist is attempted to be added again. Use, placeholder {product_name} to display name of the product.', 'addonify-wihlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
					),
				),
			),
			'error_modal'             => array(
				'title'        => __( 'Error Modal Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'could_not_add_to_wishlist_error_description' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product could not be added to wishlist text', 'addonify-wishlist' ),
						'description' => __( 'Set the error message to be displayed when a product could not be added into the wishlist. Use, placeholder {product_name} to display name of the product.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'could_not_add_to_wishlist_error_description' ),
					),
					'could_not_remove_from_wishlist_error_description' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Product could not be removed from wishlist text', 'addonify-wishlist' ),
						'description' => __( 'Set the error message to be displayed when a product could not be removed from the wishlist. Use, placeholder {product_name} to display name of the product.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'could_not_remove_from_wishlist_error_description' ),
					),
				),
			),
			'login_modal'             => array(
				'title'        => __( 'Login Modal Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'login_required_message' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Login required text', 'addonify-wishlist' ),
						'description' => __( 'Set the text to be displayed when user login is required.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'login_required_message' ),
					),
					'login_btn_label'        => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Login link button label', 'addonify-wishlist' ),
						'description' => __( 'Set the label for button that links to login page.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'login_btn_label' ),
					),
				),
			),
			'modal_colors'            => array(
				'title'        => __( 'Modal Color Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'popup_close_btn_icon_color'          => array(
						'type'      => 'color',
						'label'     => __( 'Close button icon color', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_close_btn_icon_color' ),
					),
					'popup_close_btn_icon_color_on_hover' => array(
						'type'      => 'color',
						'label'     => __( 'On hover close button icon color', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_close_btn_icon_color_on_hover' ),
					),
					'popup_modal_overlay_bg_color'        => array(
						'type'      => 'color',
						'label'     => __( 'Modal overlay background color', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_overlay_bg_color' ),
					),
					'popup_modal_bg_color'                => array(
						'type'      => 'color',
						'label'     => __( 'Modal background color', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_bg_color' ),
					),
					'popup_modal_icon_color'              => array(
						'type'      => 'color',
						'label'     => __( 'Modal icon color', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_icon_color' ),
					),
					'popup_modal_text_color'              => array(
						'type'      => 'color',
						'label'     => __( 'Modal text color', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_text_color' ),
					),
					'popup_modal_btn_text_color'          => array(
						'type'      => 'color',
						'label'     => __( 'Label color for buttons', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_btn_text_color' ),
					),
					'popup_modal_btn_text_color_hover'    => array(
						'type'      => 'color',
						'label'     => __( 'On hover label color for buttons', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_btn_text_color_hover' ),
					),
					'popup_modal_btn_bg_color'            => array(
						'type'      => 'color',
						'label'     => __( 'Background color for buttons', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_btn_bg_color' ),
					),
					'popup_modal_btn_bg_color_hover'      => array(
						'type'      => 'color',
						'label'     => __( 'On hover background color for buttons', 'addonify-wishlist' ),
						'className' => '',
						'value'     => addonify_wishlist_get_option( 'popup_modal_btn_bg_color_hover' ),
					),
				),
			),
		);
	}
}

add_filter( 'addonify_wishlist_popup_modal_v_2_options', 'addonify_wishlist_popup_modal_v_2_options' );
