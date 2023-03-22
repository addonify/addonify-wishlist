<?php
/**
 * Define wishlist button settings fields of plugin.
 *
 * @link       https://addonify.com/
 * @since      1.1.4
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_wishlist_button_v_2_options' ) ) {
	/**
	 * Wishlist button options.
	 *
	 * @return array
	 */
	function addonify_wishlist_wishlist_button_v_2_options() {
		return array(
			'btn_position'                               => array(
				'type'        => 'select',
				'className'   => '',
				'label'       => __( 'Button Position', 'addonify-wishlist' ),
				'description' => __( 'Choose where to place the Add to Wishlist button.', 'addonify-wishlist' ),
				'choices'     => array(
					'after_add_to_cart'  => __( 'After Add to Cart Button', 'addonify-wishlist' ),
					'before_add_to_cart' => __( 'Before Add to Cart Button', 'addonify-wishlist' ),
				),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'btn_position' ),
			),
			'btn_position_on_single'                     => array(
				'type'        => 'select',
				'className'   => '',
				'label'       => __( 'Button Position on Product Single Page', 'addonify-wishlist' ),
				'description' => __( 'Choose where to place the Add to Wishlist button.', 'addonify-wishlist' ),
				'choices'     => array(
					'before_add_to_cart_form'   => __( 'Before Add to Cart Form', 'addonify-wishlist' ),
					'before_add_to_cart_button' => __( 'Before Add to Cart Button', 'addonify-wishlist' ),
					'after_add_to_cart_button'  => __( 'After Add to Cart Button', 'addonify-wishlist' ),
					'after_add_to_cart_form'    => __( 'After Add to Cart Form', 'addonify-wishlist' ),
				),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'btn_position_on_single' ),
			),
			'remove_already_added_product_from_wishlist' => array(
				'type'        => 'switch',
				'className'   => '',
				'label'       => __( 'Remove Added Product from Wishlist on Click', 'addonify-wishlist' ),
				'description' => __( 'If Add to Wishlist button is clicked when the product is already in wishlist, remove the product from wishlist.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'remove_already_added_product_from_wishlist' ),
			),
			'btn_custom_class'                           => array(
				'type'        => 'text',
				'className'   => '',
				'placeholder' => 'my_button rounded_button',
				'label'       => __( 'Custom CSS Class', 'addonify-wishlist' ),
				'badge'       => __( 'Optional', 'addonify-wishlist' ),
				'description' => __( 'Add custom CSS class(es) to Add to Wishlist button. Separate CSS classes with spaces.', 'addonify-wishlist' ),
				'dependent'   => array( 'enable_wishlist' ),
				'value'       => addonify_wishlist_get_option( 'btn_custom_class' ),
			),
			'wishlist_btn_bg_color'                      => array(
				'type'          => 'color',
				'label'         => __( 'Background Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'wishlist_btn_bg_color' ),
			),
			'wishlist_btn_bg_color_hover'                => array(
				'type'          => 'color',
				'label'         => __( 'On Hover Background Color', 'addonify-wishlist' ),
				'isAlphaPicker' => true,
				'className'     => '',
				'value'         => addonify_wishlist_get_option( 'wishlist_btn_bg_color_hover' ),
			),
			'button_labels'                              => array(
				'title'        => __( 'Button Labels', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'btn_label'                        => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Button Label', 'addonify-wishlist' ),
						'description' => __( 'Label for Add to Wishlist button.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'btn_label' ),
					),
					'btn_label_when_added_to_wishlist' => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Added to Wishlist Button Label', 'addonify-wishlist' ),
						'description' => __( 'Set the label for Add to Wishlist button, if a product is added to the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'btn_label_when_added_to_wishlist' ),
					),
					'btn_label_if_added_to_wishlist'   => array(
						'type'        => 'text',
						'className'   => '',
						'label'       => __( 'Already in Wishlist Button Label', 'addonify-wishlist' ),
						'description' => __( 'Set the label for Add to Wishlist button, if a product is already in the wishlist.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' ),
					),
					'wishlist_btn_text_color'          => array(
						'type'          => 'color',
						'label'         => __( 'Label Color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'wishlist_btn_text_color' ),
					),
					'wishlist_btn_text_color_hover'    => array(
						'type'          => 'color',
						'label'         => __( 'On Hover Label Color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'wishlist_btn_text_color_hover' ),
					),
				),
			),
			'button_icon'                                => array(
				'title'        => __( 'Button icon', 'addonify-wishlist' ),
				'type'         => 'sub_section',
				'sub_sections' => array(
					'show_icon'                     => array(
						'type'        => 'switch',
						'className'   => '',
						'label'       => __( 'Show Icon in Button', 'addonify-wishlist' ),
						'description' => __( 'Display heart icon on Add to Wishlist button label.', 'addonify-wishlist' ),
						'dependent'   => array( 'enable_wishlist' ),
						'value'       => addonify_wishlist_get_option( 'show_icon' ),
					),
					'icon_position'                 => array(
						'type'        => 'select',
						'className'   => '',
						'label'       => __( 'Button Icon Position', 'addonify-wishlist' ),
						'description' => __( 'Choose where to place the Add to Wishlist button Icon.', 'addonify-wishlist' ),
						'choices'     => array(
							'left'  => __( 'Before Button Label', 'addonify-wishlist' ),
							'right' => __( 'After Button Label', 'addonify-wishlist' ),
						),
						'dependent'   => array( 'enable_wishlist', 'show_icon' ),
						'value'       => addonify_wishlist_get_option( 'icon_position' ),
					),
					'wishlist_btn_icon_color'       => array(
						'type'          => 'color',
						'label'         => __( 'Icon Color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'wishlist_btn_icon_color' ),
					),
					'wishlist_btn_icon_color_hover' => array(
						'type'          => 'color',
						'label'         => __( 'On Hover Icon Color', 'addonify-wishlist' ),
						'isAlphaPicker' => true,
						'className'     => '',
						'value'         => addonify_wishlist_get_option( 'wishlist_btn_icon_color_hover' ),
					),
				),
			),
		);
	}
}

