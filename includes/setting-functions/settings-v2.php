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
 * Include required files for v2.
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields_v2/general.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields_v2/popup-modal.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields_v2/wishlist-button.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields_v2/wishlist-page.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields_v2/wishlist-sidebar.php';


if ( ! function_exists( 'addonify_wishlist_settings_defaults' ) ) {
	/**
	 * Default Settings
	 *
	 * @param int $setting_id Setting ID.
	 */
	function addonify_wishlist_settings_defaults( $setting_id = '' ) {

		$shop = get_page_by_title( 'Shop' );
		if ( null !== $shop ) {
			$page = 'Shop';
		} else {
			$page = '';
		}

		$defaults = apply_filters(
			'addonify_wishlist_setting_defaults',
			array(
				'enable_wishlist'                          => true,
				'wishlist_page'                            => '',
				'require_login'                            => false,
				'if_not_login_action'                      => 'default',
				'remove_from_wishlist_if_added_to_cart'    => true,
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
				'empty_wishlist_label'                     => __( 'Empty wishlist.', 'addonify-wishlist' ),
				'clear_wishlist_label'                     => __( 'Clear Wishlist!', 'addonify-wishlist' ),
				'sidebar_empty_wishlist_label'             => __( 'Empty wishlist.', 'addonify-wishlist' ),
				'undo_action_prelabel_text'                => __( '{product_name} has been removed.', 'addonify-wishlist' ),
				'undo_action_label'                        => __( 'Undo?', 'addonify-wishlist' ),
				'undo_notice_timeout'                      => 5,
				'icon_position'                            => 'left',
				'show_empty_wishlist_navigation_link'      => true,
				'empty_wishlist_navigation_link'           => $page,
				'empty_wishlist_navigation_link_label'     => __( 'Go to Shop', 'addonify-wishlist' ),
				'login_required_message'                   => __( 'Please login before adding item to Wishlist', 'addonify-wishlist' ),
				'could_not_add_to_wishlist_error_description' => __( 'Something went wrong. <br>{product_name} was not added to wishlist. Please refresh page and try again.', 'addonify-wishlist' ),
				'could_not_remove_from_wishlist_error_description' => __( 'Something went wrong. <br>{product_name} was not removed wishlist. Please refresh page and try again.', 'addonify-wishlist' ),

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

if ( ! function_exists( 'addonify_wishlist_v_2_get_settings_values' ) ) {
	/**
	 * Get setting values.
	 *
	 * @since 2.0.0
	 *
	 * @return array Option values.
	 */
	function addonify_wishlist_v_2_get_settings_values() {

		$settings_default = addonify_wishlist_settings_defaults();

		if ( $settings_default ) {

			$settings_values = array();

			$setting_fields = addonify_wishlist_v_2_settings_fields();

			foreach ( $settings_default as $id => $value ) {

				if ( array_key_exists( $id, $setting_fields ) ) {
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
			}

			return $settings_values;
		}
	}
}

if ( ! function_exists( 'addonify_wishlist_v_2_update_settings' ) ) {
	/**
	 * Update settings
	 *
	 * @since 2.0.0
	 *
	 * @param string $settings Setting.
	 * @return bool true on success, false otherwise.
	 */
	function addonify_wishlist_v_2_update_settings( $settings = '' ) {

		if (
			is_array( $settings ) &&
			count( $settings ) > 0
		) {
			$setting_fields = addonify_wishlist_v_2_settings_fields();

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

/**
 * Add setting fields into the global setting fields array.
 *
 * @since 2.0.0
 * @param mixed $settings_fields Setting fields.
 * @return array
 */
function addonify_wishlist_v_2_add_fields_to_settings_fields( $settings_fields ) {

	$settings_fields = array_merge( $settings_fields, apply_filters( 'addonify_wishlist_general_v_2_options', array() ) );

	$settings_fields = array_merge( $settings_fields, apply_filters( 'addonify_wishlist_popup_modal_v_2_options', array() ) );

	$settings_fields = array_merge( $settings_fields, apply_filters( 'addonify_wishlist_wishlist_button_v_2_options', array() ) );

	$settings_fields = array_merge( $settings_fields, apply_filters( 'addonify_wishlist_wishlist_page_v_2_options', array() ) );

	$settings_fields = array_merge( $settings_fields, apply_filters( 'addonify_wishlist_wishlist_sidebar_v_2_options', array() ) );

	return $settings_fields;
}
add_filter( 'addonify_wishlist_v_2_settings_fields', 'addonify_wishlist_v_2_add_fields_to_settings_fields' );


if ( ! function_exists( 'addonify_wishlist_v_2_settings_fields' ) ) {
	/**
	 * Add setting fields into the global setting fields array.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	function addonify_wishlist_v_2_settings_fields() {
		$setting_fields         = apply_filters( 'addonify_wishlist_v_2_settings_fields', array() );
		$return_settings_fields = array();
		foreach ( $setting_fields as $i => $field ) {
			if ( 'sub_section' === $field['type'] ) {
				$return_settings_fields = array_merge( $return_settings_fields, $field['sub_sections'] );
				unset( $setting_fields[ $i ] );
			}
		}
		$return_settings_fields = array_merge( $return_settings_fields, $setting_fields );
		return $return_settings_fields;
	}
}

if ( ! function_exists( 'addonify_wishlist_v_2_get_settings_fields' ) ) {
	/**
	 * Define settings sections and respective settings fields.
	 *
	 * @since 2.0.0
	 * @return array
	 */
	function addonify_wishlist_v_2_get_settings_fields() {

		return array(
			'settings_values' => addonify_wishlist_v_2_get_settings_values(),
			'tabs'            => array(
				'general'          => array(
					'title'    => __( 'General settings', 'addonify-wishlist' ),
					'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' > <path d='M12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z' /><path d='M21.294,13.9l-.444-.256a9.1,9.1,0,0,0,0-3.29l.444-.256a3,3,0,1,0-3-5.2l-.445.257A8.977,8.977,0,0,0,15,3.513V3A3,3,0,0,0,9,3v.513A8.977,8.977,0,0,0,6.152,5.159L5.705,4.9a3,3,0,0,0-3,5.2l.444.256a9.1,9.1,0,0,0,0,3.29l-.444.256a3,3,0,1,0,3,5.2l.445-.257A8.977,8.977,0,0,0,9,20.487V21a3,3,0,0,0,6,0v-.513a8.977,8.977,0,0,0,2.848-1.646l.447.258a3,3,0,0,0,3-5.2Zm-2.548-3.776a7.048,7.048,0,0,1,0,3.75,1,1,0,0,0,.464,1.133l1.084.626a1,1,0,0,1-1,1.733l-1.086-.628a1,1,0,0,0-1.215.165,6.984,6.984,0,0,1-3.243,1.875,1,1,0,0,0-.751.969V21a1,1,0,0,1-2,0V19.748a1,1,0,0,0-.751-.969A6.984,6.984,0,0,1,7.006,16.9a1,1,0,0,0-1.215-.165l-1.084.627a1,1,0,1,1-1-1.732l1.084-.626a1,1,0,0,0,.464-1.133,7.048,7.048,0,0,1,0-3.75A1,1,0,0,0,4.79,8.992L3.706,8.366a1,1,0,0,1,1-1.733l1.086.628A1,1,0,0,0,7.006,7.1a6.984,6.984,0,0,1,3.243-1.875A1,1,0,0,0,11,4.252V3a1,1,0,0,1,2,0V4.252a1,1,0,0,0,.751.969A6.984,6.984,0,0,1,16.994,7.1a1,1,0,0,0,1.215.165l1.084-.627a1,1,0,1,1,1,1.732l-1.084.626A1,1,0,0,0,18.746,10.125Z'/></svg>",
					'sections' => apply_filters( 'addonify_wishlist_general_v_2_options', array() ),
				),
				'popup_modal'      => array(
					'title'    => __( 'Popup modals', 'addonify-wishlist' ),
					'icon'     => '',
					'sections' => apply_filters( 'addonify_wishlist_popup_modal_v_2_options', array() ),
				),
				'wishlist_button'  => array(
					'title'    => __( 'Wishlist button', 'addonify-wishlist' ),
					'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20'><path d='M19,24H5c-2.76,0-5-2.24-5-5V5C0,2.24,2.24,0,5,0h14c2.76,0,5,2.24,5,5v14c0,2.76-2.24,5-5,5ZM5,2c-1.65,0-3,1.35-3,3v14c0,1.65,1.35,3,3,3h14c1.65,0,3-1.35,3-3V5c0-1.65-1.35-3-3-3H5Zm7,18c-4.41,0-8-3.59-8-8S7.59,4,12,4s8,3.59,8,8-3.59,8-8,8Zm0-14c-3.31,0-6,2.69-6,6s2.69,6,6,6,6-2.69,6-6-2.69-6-6-6Zm0,7.5c.83,0,1.5-.67,1.5-1.5s-.67-1.5-1.5-1.5-1.5,.67-1.5,1.5,.67,1.5,1.5,1.5Z'/></svg>",
					'sections' => apply_filters( 'addonify_wishlist_wishlist_button_v_2_options', array() ),
				),
				'wishlist_page'    => array(
					'title'    => __( 'Wishlist page', 'addonify-wishlist' ),
					'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20'><path d='M22.485,10.975,12,17.267,1.515,10.975A1,1,0,1,0,.486,12.69l11,6.6a1,1,0,0,0,1.03,0l11-6.6a1,1,0,1,0-1.029-1.715Z'/><path d='M22.485,15.543,12,21.834,1.515,15.543A1,1,0,1,0,.486,17.258l11,6.6a1,1,0,0,0,1.03,0l11-6.6a1,1,0,1,0-1.029-1.715Z'/><path d='M12,14.773a2.976,2.976,0,0,1-1.531-.425L.485,8.357a1,1,0,0,1,0-1.714L10.469.652a2.973,2.973,0,0,1,3.062,0l9.984,5.991a1,1,0,0,1,0,1.714l-9.984,5.991A2.976,2.976,0,0,1,12,14.773ZM2.944,7.5,11.5,12.633a.974.974,0,0,0,1,0L21.056,7.5,12.5,2.367a.974.974,0,0,0-1,0h0Z'/></svg>",
					'sections' => apply_filters( 'addonify_wishlist_wishlist_page_v_2_options', array() ),
				),
				'wishlist_sidebar' => array(
					'title'    => __( 'Wishlist sidebar', 'addonify-wishlist' ),
					'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20'><path d='M21,2H3C1.346,2,0,3.346,0,5V22H24V5c0-1.654-1.346-3-3-3ZM2,5c0-.552,.449-1,1-1H13V20H2V5Zm20,15h-7V4h6c.551,0,1,.448,1,1v15Zm-5-10h3v2h-3v-2Zm0,4h3v2h-3v-2Zm0-8h3v2h-3v-2Z'/></svg>",
					'sections' => apply_filters( 'addonify_wishlist_wishlist_sidebar_v_2_options', array() ),
				),
				'tools'            => array(
					'title'    => __( 'Tools', 'addonify-wishlist' ),
					'icon'     => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20'><path d='M23.854,22.479l-4.545-7.437c.824-.474,1.614-1.027,2.352-1.674,.415-.364,.456-.996,.092-1.411-.366-.416-.996-.455-1.412-.092-.65,.57-1.347,1.055-2.075,1.47l-3.045-4.983c.485-.662,.78-1.47,.78-2.351,0-1.858-1.279-3.411-3-3.858V1c0-.552-.447-1-1-1s-1,.448-1,1v1.142c-1.721,.447-3,2-3,3.858,0,.881,.295,1.689,.78,2.351l-3.045,4.982c-.728-.414-1.425-.899-2.075-1.47-.416-.364-1.046-.324-1.412,.092-.364,.415-.323,1.046,.092,1.412,.737,.647,1.527,1.201,2.352,1.674L.146,22.479c-.288,.472-.14,1.087,.332,1.375,.163,.1,.343,.146,.521,.146,.337,0,.666-.17,.854-.479l4.648-7.606c1.76,.71,3.627,1.077,5.498,1.077s3.738-.367,5.498-1.077l4.648,7.606c.188,.309,.518,.479,.854,.479,.178,0,.357-.047,.521-.146,.472-.288,.62-.903,.332-1.375ZM12,4c1.103,0,2,.897,2,2s-.897,2-2,2-2-.897-2-2,.897-2,2-2ZM7.555,14.191l2.787-4.561c.506,.232,1.064,.37,1.657,.37s1.151-.138,1.657-.37l2.788,4.562c-2.859,1.067-6.03,1.067-8.889,0Z'/></svg>",
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
