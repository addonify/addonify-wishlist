<?php
/**
 * Helper functions to use with plugin.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

/**
 * A set of helper functin to use in this plugin.
 *
 * @since      1.0.0
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 * @author     Adodnify <info@addonify.com>
 */
class Addonify_Wishlist_Helpers {

	/**
	 * Check if woocommerce is active.
	 *
	 * @since    1.0.0
	 */
	protected function is_woocommerce_active() {
		return ( class_exists( 'woocommerce' ) ) ? true : false;
	}


	/**
	 * This will create settings section, fields and register that settings in a database from the provided array data
	 *
	 * @since    1.0.0
	 * @param array $args Required parameters to genereate settings.
	 */
	protected function create_settings( $args ) {

		// define section.
		add_settings_section( $args['section_id'], $args['section_label'], $args['section_callback'], $args['screen'] );

		foreach ( $args['fields'] as $field ) {

			// create label.
			add_settings_field( $field['field_id'], $field['field_label'], $field['field_callback'], $args['screen'], $args['section_id'], $field['field_callback_args'] );

			foreach ( $field['field_callback_args'] as $sub_field ) {

				$this->default_input_values[ $sub_field['name'] ] = ( isset( $sub_field['default'] ) ) ? $sub_field['default'] : '';

				register_setting(
					$args['settings_group_name'],
					$sub_field['name'],
					array(
						'sanitize_callback' => ( isset( $sub_field['sanitize_callback'] ) ) ? array( $this, $sub_field['sanitize_callback'] ) : 'sanitize_text_field',
					)
				);
			}
		}
	}



	/**
	 * Form Validation for "View Wishlist Button text" field.
	 *
	 * @since    1.0.0
	 * @param string $post_data Post data from form submission.
	 */
	public function validate_view_wishlist_btn_text( $post_data ) {
		return $this->validate_text_field( $post_data, __FUNCTION__, __( '"View Wishlist button" text cannot be empty.', 'addonify-wishlist' ) );
	}


	/**
	 * Form Validation for "Product added to wishlist" text field.
	 *
	 * @since    1.0.0
	 * @param string $post_data Post data from form submission.
	 */
	public function validate_product_added_to_wishlist_text( $post_data ) {
		return $this->validate_text_field( $post_data, __FUNCTION__, __( '"Product added to Wishlist" text cannot be empty.', 'addonify-wishlist' ) );
	}


	/**
	 * Form Validation for "Product already in wishlist" text field.
	 *
	 * @since    1.0.0
	 * @param string $post_data Post data from form submission.
	 */
	public function validate_product_already_in_wishlist_text( $post_data ) {
		return $this->validate_text_field( $post_data, __FUNCTION__, __( '"Product already in Wishlist" text cannot be empty', 'addonify-wishlist' ) );
	}


	/**
	 * Form Validation for "Cookies Lifetime" text field.
	 *
	 * @since    1.0.0
	 * @param string $post_data Post data from form submission.
	 */
	public function validate_cookies_lifetime( $post_data ) {
		return $this->validate_numeric( $post_data, __FUNCTION__, __( '"Delete Wishlist Cookies after" value should be numeric', 'addonify-wishlist' ) );
	}



	/**
	 * Form Validation for Numeric input fields.
	 *
	 * @since    1.0.0
	 * @param string $post_data Post data from form submission.
	 * @param string $name Name of the input field.
	 * @param string $msg Default response message.
	 */
	protected function validate_numeric( $post_data, $name, $msg = null ) {

		if ( is_numeric( $post_data ) ) {
			return sanitize_text_field( $post_data );
		}

		return $this->validation_response( $name, $msg );
	}



	/**
	 * Form Validation for text field.
	 *
	 * @since    1.0.0
	 * @param string $post_data Post data from form submission.
	 * @param string $name Name of the input field.
	 * @param string $msg Default reponse message.
	 */
	protected function validate_text_field( $post_data, $name, $msg = null ) {

		if ( ! empty( $post_data ) ) {
			return sanitize_text_field( $post_data );
		}

		return $this->validation_response( $name, $msg );
	}


	/**
	 * Display admin notice if validation fails.
	 *
	 * @since    1.0.0
	 * @param string $name Name of the text field.
	 * @param string $msg Message to display.
	 */
	protected function validation_response( $name, $msg = null ) {

		$default_value = $this->default_input_values[ ADDONIFY_WISHLIST_DB_INITIALS . str_replace( 'validate_', '', $name ) ];

		if ( ! $msg ) {
			$msg = __( 'Input field should not be empty.', 'addonify-wishlist' );
		}

		$msg .= __( ' Default value is used.', 'addonify-wishlist' );

		add_settings_error(
			$this->plugin_name,
			esc_attr( 'settings_updated' ),
			$msg
		);

		return $default_value;
	}



	// -------------------------------------------------
	// form helpers for admin setting screen
	// -------------------------------------------------


	/**
	 * Text input field
	 *
	 * @since    1.0.0
	 * @param string $arguments Arguments required to generate this field.
	 */
	public function text_box( $arguments ) {
		foreach ( $arguments as $args ) {

			$default = isset( $args['default'] ) ? $args['default'] : '';
			$db_value = get_option( $args['name'], $default );

			if ( ! isset( $args['css_class'] ) ) {
				$args['css_class'] = '';
			}

			if ( ! isset( $args['type'] ) ) {
				$args['type'] = 'text';
			}

			if ( ! isset( $args['end_label'] ) ) {
				$args['end_label'] = '';
			}

			if ( ! isset( $args['other_attr'] ) ) {
				$args['other_attr'] = '';
			}

			require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-textbox.php';
		}
	}


	/**
	 * Toggle Switch
	 *
	 * @since    1.0.0
	 * @param string $arguments Arguments required to generate this field.
	 */
	public function toggle_switch( $arguments ) {
		foreach ( $arguments as $args ) {
			$args['attr'] = ' class="lc_switch"';
			$this->checkbox( $args );
		}
	}


	/**
	 * Color Picker
	 *
	 * @since    1.0.0
	 * @param string $args Arguments required to generate this field.
	 */
	public function color_picker_group( $args ) {
		foreach ( $args as $arg ) {

			$default = isset( $arg['default'] ) ? $arg['default'] : '';
			$db_value = ( get_option( $arg['name'] ) ) ? get_option( $arg['name'] ) : $default;

			require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-colorpicker.php';
		}
	}


	/**
	 * Radio input field
	 *
	 * @since    1.0.0
	 * @param string $arguments Arguments required to generate this field.
	 */
	public function radio_group( $arguments ) {

		foreach ( $arguments as $args ) {

			$name = ( array_key_exists( 'name', $args ) ) ? $args['name'] : '';
			$value = ( array_key_exists( 'value', $args ) ) ? $args['value'] : '';
			$label = ( array_key_exists( 'label', $args ) ) ? $args['label'] : '';
			$checked = ( array_key_exists( 'checked', $args ) ) ? $args['checked'] : '';

			$db_value = get_option( $args['name'] );

			$attr = ( array_key_exists( 'attr', $args ) ) ? $args['attr'] : '';

			if ( $value === $db_value || 1 === $checked ) {
				$attr .= ' checked ';
			}

			require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-radio-group.php';
		}
	}


	/**
	 * Checkbox input field.
	 *
	 * @since    1.0.0
	 * @param string $args Arguments required to generate this field.
	 */
	public function checkbox( $args ) {

		$default_state = ( array_key_exists( 'checked', $args ) ) ? $args['checked'] : 1;
		$db_value = get_option( $args['name'] );
		$is_checked = ( $db_value ) ? 'checked' : '';
		$attr = ( array_key_exists( 'attr', $args ) ) ? $args['attr'] : '';
		$end_label = ( array_key_exists( 'end_label', $args ) ) ? $args['end_label'] : '';

		require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-checkbox.php';
	}


	/**
	 * Select form field
	 *
	 * @since    1.0.0
	 * @param string $arguments Arguments required to generate this field.
	 */
	public function select( $arguments ) {

		foreach ( $arguments as $args ) {

			$options = ( array_key_exists( 'options', $args ) ) ? $args['options'] : array();
			$default = ( array_key_exists( 'default', $args ) ) ? $args['default'] : '';
			$db_value = get_option( $args['name'], $default );

			require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-select.php';
		}
	}



	/**
	 * Select Page field
	 *
	 * @since    1.0.0
	 * @param string $arguments Arguments required to generate this field.
	 */
	public function select_page( $arguments ) {

		$options = array();

		foreach ( get_pages() as $page ) {
			$options[ $page->ID ] = $page->post_title;
		}

		$args = $arguments[0];
		$db_value = get_option( $args['name'] );

		$default_wishlist_page_id = get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'page_id' );

		if ( ! $db_value ) {
			$db_value = $default_wishlist_page_id;
		}

		if ( $db_value != $default_wishlist_page_id ) {
			$args['end_label'] = 'Please insert "[addonify_wishlist]" shortcode into the content area of the page';
		}

		require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-select.php';
	}



	/**
	 * Textarea input field
	 *
	 * @since    1.0.0
	 * @param string $arguments Arguments required to generate this field.
	 */
	public function text_area( $arguments ) {
		foreach ( $arguments as $args ) {
			$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
			$db_value = get_option( $args['name'], $placeholder );
			$attr = isset( $args['attr'] ) ? $args['attr'] : '';

			require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/input-textarea.php';
		}
	}

}
