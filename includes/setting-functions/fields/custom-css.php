<?php
/**
 * Define settings fields for custom css.
 *
 * @link       https://addonify.com/
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions/fields
 */

if ( ! function_exists( 'addonify_wishlist_custom_css_settings_fields' ) ) {
	/**
	 * Custom CSS.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	function addonify_wishlist_custom_css_settings_fields() {

		return array(
			'custom_css' => array(
				'type'           => 'textarea',
				'className'      => 'custom-css-box fullwidth',
				'inputClassName' => 'custom-css-textarea',
				'label'          => __( 'Custom CSS', 'addonify-wishlist' ),
				'description'    => __( 'If required, add your custom CSS code here.', 'addonify-wishlist' ),
				'placeholder'    => '#app { color: blue; }',
				'value'          => addonify_wishlist_get_option( 'custom_css' ),
			),
		);
	}
}
