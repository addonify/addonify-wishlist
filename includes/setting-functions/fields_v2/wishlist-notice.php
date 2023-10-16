<?php
/**
 * Define settings fields for wishlist notices.
 *
 * @link       https://addonify.com/
 * @since      2.0.3
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_notice_options' ) ) {
	/**
	 * Wishlist notices options.
	 *
	 * @return array
	 */
	function addonify_wishlist_notice_options() {
		return array(
			'notice_options'               => array(
				'title'        => esc_html__( 'Wishlist Notice Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'undo_notice_timeout' => array(
						'type'        => 'number',
						'design'      => 'arrow', // Arrow & plus-minus.
						'min'         => 0,
						'max'         => 300,
						'step'        => 1,
						'precision'   => 0, // Eg. 1.00, 2.00, 3.00.
						'className'   => '',
						'label'       => esc_html__( 'Notice timeout (in seconds)', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'description' => esc_html__( 'Specify the duration for which the notice should be visible. Set 0 to display notice without any timeout.', 'addonify-wishlist' ),
						'value'       => addonify_wishlist_get_option( 'undo_notice_timeout' ),
					),
				),
			),
			'product_removal_undo_notice'  => array(
				'title'        => __( 'Product Removal Undo Notice Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'undo_action_prelabel_text' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Text before Undo link', 'addonify-wishlist' ),
						'description' => __( 'Set the text to be displayed before undo link. Use, placeholder {product_name} to display name of the product being removed from the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'undo_action_prelabel_text' ),
					),
					'undo_action_label'         => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Undo link label', 'addonify-wishlist' ),
						'description' => __( 'Set the label for undo link.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'undo_action_label' ),
					),
				),
			),
			'product_added_to_cart_notice' => array(
				'title'        => __( 'Product Added to Cart Notice Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'product_added_to_cart_notice_text' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => esc_html__( 'Notice text', 'addonify-wishlist' ),
						'description' => esc_html__( 'Set the text to be displayed when product is added to cart. Use, placeholder {product_name} to display name of the product being added to the cart.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'product_added_to_cart_notice_text' ),
					),
				),
			),
			'notice_color_options'         => array(
				'title'        => __( 'Notice Color Options', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'notice_background_color'            => array(
						'type'          => 'color',
						'label'         => __( 'Background color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'notice_background_color' ),
					),
					'notice_text_color'                  => array(
						'type'          => 'color',
						'label'         => __( 'Text color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'notice_text_color' ),
					),
					'undo_button_label_color'            => array(
						'type'          => 'color',
						'label'         => __( 'Undo button label color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'undo_button_label_color' ),
					),
					'undo_button_label_color_hover'      => array(
						'type'          => 'color',
						'label'         => __( 'Undo button label color on hover', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'undo_button_label_color_hover' ),
					),
					'undo_button_background_color'       => array(
						'type'          => 'color',
						'label'         => __( 'Undo button background color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'undo_button_background_color' ),
					),
					'undo_button_background_color_hover' => array(
						'type'          => 'color',
						'label'         => __( 'Undo button background color on hover', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'undo_button_background_color_hover' ),
					),
				),
			),
		);
	}
}

add_filter( 'addonify_wishlist_notice_options', 'addonify_wishlist_notice_options' );
