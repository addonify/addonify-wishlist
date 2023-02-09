<?php
/**
 * The class to define REST API endpoints used in settings page.
 * This is used to define REST API endpoints used in admin settings page to get and update settings values.
 *
 * @since      1.0.7
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/setting-functions
 * @author     Addonify <contact@addonify.com>
 */

/**
 * Include required files.
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/general.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/wishlist-button.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/modal-notice.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/sidebar.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/custom-css.php';


if ( ! function_exists( 'addonify_wishlist_settings_defaults' ) ) {
	/**
	 * Default Settings
	 *
	 * @param int $setting_id Setting ID.
	 */
	function addonify_wishlist_settings_defaults( $setting_id = '' ) {

		$defaults = apply_filters(
			'addonify_wishlist_setting_defaults',
			array(
				'enable_wishlist'                          => true,
				'wishlist_page'                            => '',
				'require_login'                            => false,
				'if_not_login_action'                      => 'default',
				'remove_from_wishlist_if_added_to_cart'    => true,
				'cookies_lifetime'                         => 30,
				'btn_position'                             => 'before_add_to_cart',
				'btn_position_on_single'                   => 'after_add_to_cart_form',
				'btn_label'                                => __( 'Add to wishlist', 'addonify-wishlist' ),
				'btn_label_when_added_to_wishlist'         => __( 'Added to wishlist', 'addonify-wishlist' ),
				'btn_label_if_added_to_wishlist'           => __( 'Already in wishlist', 'addonify-wishlist' ),
				'login_btn_label'                          => __( 'Login', 'addonify-wishlist' ),
				'show_icon'                                => true,
				'remove_already_added_product_from_wishlist' => false,
				'btn_custom_class'                         => '',
				'after_add_to_wishlist_action'             => 'show_popup_notice',
				'view_wishlist_btn_text'                   => __( 'View wishlist', 'addonify-wishlist' ),
				'product_added_to_wishlist_text'           => __( '{product_name} added to wishlist', 'addonify-wishlist' ),
				'product_already_in_wishlist_text'         => __( '{product_name} already in wishlist', 'addonify-wishlist' ),
				'product_removed_from_wishlist_text'       => __( '{product_name} removed from wishlist', 'addonify-wishlist' ),
				'show_wishlist_emptying_button'            => true,
				'wishlist_emptied_text'                    => __( 'Wishlist cleared.', 'addonify-wishlist' ),
				'popup_close_btn_text'                     => __( 'Close', 'addonify-wishlist' ),
				'show_sidebar'                             => false,
				'sidebar_position'                         => 'right',
				'sidebar_title'                            => __( 'My wishlist', 'addonify-wishlist' ),
				'sidebar_btn_label'                        => __( 'Wishlist', 'addonify-wishlist' ),
				'sidebar_btn_position_offset'              => -40,
				'sidebar_show_icon'                        => true,
				'sidebar_btn_icon'                         => 'heart-style-one',
				'ajaxify_remove_from_wishlist_button'      => true,
				'view_wishlist_page_button_label'          => __( 'View All Wishlist Items', 'addonify-wishlist' ),
				'load_styles_from_plugin'                  => false,
				'wishlist_btn_text_color'                  => '#333333',
				'wishlist_btn_icon_color'                  => '#333333',
				'wishlist_btn_text_color_hover'            => '#96588a',
				'wishlist_btn_icon_color_hover'            => '#96588a',
				'wishlist_btn_bg_color'                    => '',
				'wishlist_btn_bg_color_hover'              => '',
				'sidebar_modal_overlay_bg_color'           => '',
				'popup_modal_overlay_bg_color'             => '',
				'popup_modal_bg_color'                     => '',
				'sidebar_modal_general_border_color'       => '',
				'popup_modal_icon_color'                   => '',
				'popup_modal_text_color'                   => '',
				'popup_modal_btn_text_color'               => '',
				'popup_modal_btn_text_color_hover'         => '',
				'popup_modal_btn_bg_color'                 => '',
				'popup_modal_btn_bg_color_hover'           => '',
				'sidebar_modal_toggle_btn_label_color'     => '',
				'sidebar_modal_toggle_btn_label_color_hover' => '',
				'sidebar_modal_toggle_btn_bg_color'        => '',
				'sidebar_modal_toggle_btn_bg_color_hover'  => '',
				'sidebar_modal_bg_color'                   => '',
				'sidebar_modal_title_color'                => '',
				'sidebar_modal_empty_text_color'           => '',
				'sidebar_modal_close_icon_color'           => '',
				'sidebar_modal_close_icon_color_hover'     => '',
				'sidebar_modal_product_title_color'        => '',
				'sidebar_modal_product_title_color_hover'  => '',
				'sidebar_modal_product_regular_price_color' => '',
				'sidebar_modal_product_sale_price_color'   => '',
				'sidebar_modal_product_add_to_cart_label_color' => '',
				'sidebar_modal_product_add_to_cart_label_color_hover' => '',
				'sidebar_modal_product_add_to_cart_bg_color' => '',
				'sidebar_modal_product_add_to_cart_bg_color_hover' => '',
				'sidebar_modal_product_remove_from_wishlist_icon_color' => '',
				'sidebar_modal_product_remove_from_wishlist_icon_color_hover' => '',
				'sidebar_modal_view_wishlist_btn_label_color' => '',
				'sidebar_modal_view_wishlist_btn_label_color_hover' => '',
				'sidebar_modal_view_wishlist_btn_bg_color' => '',
				'sidebar_modal_view_wishlist_btn_bg_color_hover' => '',
				'sidebar_modal_notification_text_color'    => '',
				'sidebar_modal_notification_bg_color'      => '',
				'custom_css'                               => '',
			)
		);

		return ( $setting_id && isset( $defaults[ $setting_id ] ) ) ? $defaults[ $setting_id ] : $defaults;
	}
}


if ( ! function_exists( 'addonify_wishlist_get_option' ) ) {
	/**
	 * Get stored option from db or return default if not.
	 *
	 * @param int $setting_id Setting ID.
	 * @return mixed Option value.
	 */
	function addonify_wishlist_get_option( $setting_id ) {

		return get_option( ADDONIFY_WISHLIST_DB_INITIALS . $setting_id, addonify_wishlist_settings_defaults( $setting_id ) );
	}
}


if ( ! function_exists( 'addonify_wishlist_get_settings_values' ) ) {
	/**
	 * Get setting values.
	 *
	 * @return array Option values.
	 */
	function addonify_wishlist_get_settings_values() {

		if ( addonify_wishlist_settings_defaults() ) {

			$settings_values = array();

			$setting_fields = addonify_wishlist_settings_fields();

			foreach ( addonify_wishlist_settings_defaults() as $id => $value ) {

				$setting_type = $setting_fields[ $id ]['type'];

				switch ( $setting_type ) {
					case 'switch':
						$settings_values[ $id ] = ( (int) addonify_wishlist_get_option( $id ) === 1 ) ? true : false;
						break;
					case 'number':
						$settings_values[ $id ] = addonify_wishlist_get_option( $id );
						break;
					default:
						$settings_values[ $id ] = addonify_wishlist_get_option( $id );
				}
			}

			return $settings_values;
		}
	}
}


if ( ! function_exists( 'addonify_wishlist_update_settings' ) ) {
	/**
	 * Update settings
	 *
	 * @param string $settings Setting.
	 * @return bool true on success, false otherwise.
	 */
	function addonify_wishlist_update_settings( $settings = '' ) {

		if (
			is_array( $settings ) &&
			count( $settings ) > 0
		) {
			$setting_fields = addonify_wishlist_settings_fields();

			foreach ( $settings as $id => $value ) {

				$sanitized_value = null;

				$setting_type = $setting_fields[ $id ]['type'];

				switch ( $setting_type ) {
					case 'text':
						$sanitized_value = sanitize_text_field( $value );
						break;
					case 'textarea':
						$sanitized_value = sanitize_textarea_field( $value );
						break;
					case 'switch':
						$sanitized_value = ( true === $value ) ? '1' : '0';
						break;
					case 'number':
						$sanitized_value = (int) $value;
						break;
					case 'color':
						$sanitized_value = sanitize_text_field( $value );
						break;
					case 'select':
						$setting_choices = $setting_fields[ $id ]['choices'];
						$sanitized_value = ( array_key_exists( $value, $setting_choices ) ) ? sanitize_text_field( $value ) : $setting_choices[0];
						break;
					default:
						$sanitized_value = sanitize_text_field( $value );
				}

				if ( ! update_option( ADDONIFY_WISHLIST_DB_INITIALS . $id, $sanitized_value ) ) {
					return false;
				}
			}

			return true;
		}
	}
}


if ( ! function_exists( 'addonify_wishlist_settings_fields' ) ) {
	/**
	 * Return settings fields.
	 *
	 * @return array Fields.
	 */
	function addonify_wishlist_settings_fields() {

		return apply_filters( 'addonify_wishlist_settings_fields', array() );
	}
}


/**
 * Add setting fields into the global setting fields array.
 *
 * @since 1.0.0
 * @param mixed $settings_fields Setting fields.
 * @return array
 */
function addonify_wishlist_add_fields_to_settings_fields( $settings_fields ) {

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_general_setting_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_general_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_modal_notice_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_modal_notice_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_sidebar_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_sidebar_modal_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_sidebar_modal_toggle_button_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_product_content_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_sidebar_modal_notification_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_button_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_add_to_wishlist_button_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_sidebar_modal_view_wishlist_button_styles_settings_fields() );

	$settings_fields = array_merge( $settings_fields, addonify_wishlist_custom_css_settings_fields() );

	return $settings_fields;
}
add_filter( 'addonify_wishlist_settings_fields', 'addonify_wishlist_add_fields_to_settings_fields' );


if ( ! function_exists( 'addonify_wishlist_get_settings_fields' ) ) {
	/**
	 * Define settings sections and respective settings fields.
	 *
	 * @since 1.0.7
	 * @return array
	 */
	function addonify_wishlist_get_settings_fields() {

		return array(
			'settings_values' => addonify_wishlist_get_settings_values(),
			'tabs'            => array(
				'settings' => array(
					'title'    => __( 'Settings', 'addonify-wishlist' ),
					'sections' => array(
						'general'                => array(
							'title'       => __( 'General Options', 'addonify-wishlist' ),
							'description' => '',
							'fields'      => addonify_wishlist_general_setting_fields(),
						),
						'add_to_wishlist_button' => array(
							'title'       => __( 'Add to Wishlist Button Options', 'addonify-wishlist' ),
							'description' => '',
							'fields'      => addonify_wishlist_button_settings_fields(),
						),
						'modal_notice'           => array(
							'title'       => __( 'Popup Notice Options', 'addonify-wishlist' ),
							'description' => '',
							'fields'      => addonify_wishlist_modal_notice_settings_fields(),
						),
						'sidebar'                => array(
							'title'       => __( 'Wishlist Sidebar Options', 'addonify-wishlist' ),
							'description' => '',
							'fields'      => addonify_wishlist_sidebar_settings_fields(),
						),
					),
				),
				'styles'   => array(
					'sections' => array(
						'general'                       => array(
							'title'       => __( 'General', 'addonify-wishlist' ),
							'description' => '',
							'fields'      => addonify_wishlist_general_styles_settings_fields(),
						),
						'add_to_wishlist_button'        => array(
							'title'       => __( 'Add to Wishlist Button Colors', 'addonify-wishlist' ),
							'description' => __( 'Set Add to Wishlist button label and background colors.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_add_to_wishlist_button_styles_settings_fields(),
						),
						'popup_modal'                   => array(
							'title'       => __( 'Popup Modal Colors', 'addonify-wishlist' ),
							'description' => __( 'Set popup modal icon, message, and button colors.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_modal_notice_styles_settings_fields(),
						),
						'sidebar_wishlist_modal_toggle_button' => array(
							'title'       => __( 'Sidebar Wishlist Modal Toggle Button Colors', 'addonify-wishlist' ),
							'description' => __( 'Set sidebar wishlist off-canvas modal toggle button label and background colors.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_sidebar_modal_toggle_button_styles_settings_fields(),
						),
						'sidebar_wishlist_modal'        => array(
							'title'       => __( 'Sidebar Wishlist Modal Colors', 'addonify-wishlist' ),
							'description' => __( 'Set colors of sidebar wishlist off-canvas modal general elements.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_sidebar_modal_styles_settings_fields(),
						),
						'sidebar_wishlist_product'      => array(
							'title'       => __( 'Sidebar Wishlist Product Colors', 'addonify-wishlist' ),
							'description' => __( 'Set colors of product content of sidebar wishlist off-canvas modal.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_product_content_styles_settings_fields(),
						),
						'sidebar_wishlist_notification' => array(
							'title'       => __( 'Sidebar Wishlist Notification Colors', 'addonify-wishlist' ),
							'description' => __( 'Set text and background color of notification.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_sidebar_modal_notification_styles_settings_fields(),
						),
						'sidebar_wishlist_view_wishlist_button' => array(
							'title'       => __( 'Sidebar Wishlist View Wishlist Button Colors', 'addonify-wishlist' ),
							'description' => __( 'Set view wishlist button label and background colors.', 'addonify-wishlist' ),
							'type'        => 'options-box',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_sidebar_modal_view_wishlist_button_styles_settings_fields(),
						),
						'custom_css'                    => array(
							'title'       => __( 'Developer', 'addonify-wishlist' ),
							'description' => '',
							'dependent'   => array( 'load_styles_from_plugin' ),
							'fields'      => addonify_wishlist_custom_css_settings_fields(),
						),
					),
				),
				'products' => array(
					'recommended' => array(
						// Recommend plugins here.
						'content' => __( 'Coming soon....', 'addonify-wishlist' ),
					),
				),
				'tools'    => array(
					'sections' => array(
						'reset-options'  => array(
							'type'   => 'options-box',
							'fields' => array(
								'reset-options' => array(
									'label'          => esc_html__( 'Reset Options', 'addonify-wishlist' ),
									'confirmText'    => esc_html__( 'Are you sure you want to reset all settings?', 'addonify-wishlist' ),
									'confirmYesText' => esc_html__( 'Yes', 'addonify-wishlist' ),
									'confirmNoText'  => esc_html__( 'No', 'addonify-wishlist' ),
									'type'           => 'reset-option',
									'description'    => esc_html__( 'All the settings will be set to default.', 'addonify-wishlist' ),
								),
							),
						),
						'export-options' => array(
							'type'   => 'options-box',
							'fields' => array(
								'export-options' => array(
									'label'       => esc_html__( 'Export Options', 'addonify-wishlist' ),
									'description' => esc_html__( 'Backup all settings that can be imported in future.', 'addonify-wishlist' ),
									'type'        => 'export-option',
								),
							),
						),
						'import-options' => array(
							'type'   => 'options-box',
							'title'  => esc_html__( 'Import Options', 'addonify-wishlist' ),
							'fields' => array(
								'import-options' => array(
									'label'       => esc_html__( 'Import Options', 'addonify-wishlist' ),
									'caption'     => esc_html__( 'Drop a file here or click here to upload.', 'addonify-wishlist' ),
									'note'        => esc_html__( 'Only .json file is permitted.', 'addonify-wishlist' ),
									'description' => esc_html__( 'Drag or upload the .json file that you had exported.', 'addonify-wishlist' ),
									'type'        => 'import-option',
									'className'   => 'fullwidth',
								),
							),
						),
					),
				),
			),
		);
	}
}
