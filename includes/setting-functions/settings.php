<?php


require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/general.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/wishlist-button.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/modal-notice.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/sidebar.php';

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'setting-functions/fields/custom-css.php';


if ( ! function_exists( 'addonify_wishlist_settings_defaults' ) ) {

    function addonify_wishlist_settings_defaults( $setting_id = '' ) {

        $defaults = apply_filters( 
            'addonify_wishlist/setting_defaults',  
            array(
                'enable_wishlist' => true,
                'wishlist_page' => '',
                'require_login' => true,
                'redirect_to_login' => true,
                'redirect_to_checkout_if_item_added_to_cart' => false,
                'remove_from_wishlist_if_added_to_cart' => true,
                'cookies_lifetime' => 30,
                'btn_position' => 'before_add_to_cart',
                'btn_label' => __( 'Add to wishlist', 'addonify-wishlist' ),
                'btn_label_if_added_to_wishlist' => __( 'Already in wishlist', 'addonify-wishlist' ),
                'show_icon' => true,
                'btn_custom_class' => '',
                'show_popup' => true,
                'redirect_to_wishlist_if_popup_disabled' => false,
                'view_wishlist_btn_text' => __( 'View wishlist', 'addonify-wishlist' ),
                'product_added_to_wishlist_text' => __( '{product_name} added to wishlist', 'addonify-wishlist' ),
                'product_already_in_wishlist_text' => __( '{product_name} already in wishlist', 'addonify-wishlist' ),
                'show_sidebar' => true,
                'sidebar_position' => 'right',
                'sidebar_title' => __( 'My wishlist', 'addonify-wishlist' ),
                'sidebar_btn_label' => __( 'Wishlist', 'addonify-wishlist' ),
                'sidebar_show_icon' => true,
                'sidebar_btn_icon' => 'heart-style-one',
                'load_styles_from_plugin' => false,
                'wishlist_btn_text_color' => '#333333',
                'wishlist_btn_icon_color' => '#333333',
                'wishlist_btn_text_color_hover' => '#96588a',
                'wishlist_btn_icon_color_hover' => '#96588a',
                'custom_css' => ''
            )
        );

        return ( $setting_id && isset( $defaults[ $setting_id ] ) ) ? $defaults[ $setting_id ] : $defaults;
    }
}


if ( ! function_exists( 'addonify_wishlist_get_option' ) ) {

    function addonify_wishlist_get_option( $setting_id ) {

        return get_option( ADDONIFY_WISHLIST_DB_INITIALS . $setting_id, addonify_wishlist_settings_defaults( $setting_id ) );
    }
}


if ( ! function_exists( 'addonify_wishlist_get_settings_values' ) ) {

    function addonify_wishlist_get_settings_values() {

        if ( addonify_wishlist_settings_defaults() ) {

            $settings_values = array();

            $setting_fields = addonify_wishlist_settings_fields();

            foreach ( addonify_wishlist_settings_defaults() as $id => $value ) {

                $setting_type = $setting_fields[$id];

                switch ( $setting_type ) {
                    case 'switch':
                        $settings_values[$id] = ( addonify_wishlist_get_option( $id ) == '1' ) ? true : false;
                        break;
                    case 'number':
                        $settings_values[$id] = addonify_wishlist_get_option( $id );
                        break;
                    default:
                        $settings_values[$id] = addonify_wishlist_get_option( $id );
                }
            }

            return $settings_values;
        }
    }
}


if ( ! function_exists( 'addonify_wishlist_update_settings' ) ) {

    function addonify_wishlist_update_settings( $settings = '' ) {

        if ( 
            is_array( $settings ) &&
            count( $settings ) > 0
        ) {
            $setting_fields = addonify_wishlist_settings_fields();

            foreach ( $settings as $id => $value ) {

                $sanitized_value = null;

                $setting_type = $setting_fields[$id];

                switch ( $setting_type ) {
                    case 'text':
                        $sanitized_value = sanitize_text_field( $value );
                        break;
                    case 'textarea':
                        $sanitized_value = sanitize_textarea_field( $value );
                        break;
                    case 'switch':
                        $sanitized_value = wp_validate_boolean( $value );
                        break;
                    case 'number':
                        $sanitized_value = absint( $value );
                    case 'color':
                        $sanitized_value = sanitize_text_field( $value );
                    case 'select':
                        $setting_choices = $setting_fields[$id]['choices'];
                        $sanitized_value = ( array_key_exists( $value, $setting_choices ) ) ? sanitize_text_field( $value ) : $setting_choices[0];
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

    function addonify_wishlist_settings_fields() {

        return apply_filters( 'addonify_wishlist/settings_fields', array() );
    }
}


/**
 * Define settings sections and respective settings fields.
 * 
 * @since 1.0.7
 * @return array
 */
if ( ! function_exists( 'addonify_wishlist_get_settings_fields' ) ) {

    function addonify_wishlist_get_settings_fields() {

        return array(
            'settings_values' => addonify_wishlist_get_settings_values(),
            'tabs' => array(
                'settings' => array(
                    'title' => __( 'Settings', 'addonify-wishlist' ),
                    'sections' => array(
                        'general' => array(
                            'title' => __( 'General Options', 'addonify-wishlist' ),
                            'description' => '',
                            'fields' => addonify_wishlist_general_setting_fields(),
                        ),
                        'add_to_wishlist_button' => array(
                            'title' => __('Add to Wishlist Button Options', 'addonify-wishlist' ),
                            'description' => '',
                            'fields' => addonify_wishlist_button_settings_fields(),
                        ),
                        'modal_notice' => array(
                            'title' => __('Popup Notice Options', 'addonify-wishlist' ),
                            'description' => '',
                            'fields' => addonify_wishlist_modal_notice_settings_fields(),
                        ),
                        'sidebar' => array(
                            'title' => __('Wishlist Sidebar Options', 'addonify-wishlist' ),
                            'description' => '',
                            'fields' => addonify_wishlist_sidebar_settings_fields(),
                        )
                    )
                ),
                'styles' => array(
                    'sections' => array(
                        'general' => array(
                            'title' => __( 'General', 'addonify-wishlist' ),
                            'description' => '',
                            'fields' => addonify_wishlist_general_styles_settings_fields(),
                        ),
                        'add_to_wishlist_button' => array(
                            'title' => __( 'Add to Wishlist Button Color', 'addonify-wishlist' ),
                            'description' => 'Change the look & feel of add to wishlist button.',
                            'type' => 'options-box',
                            'dependent'  => array('load_styles_from_plugin'),
                            'fields' => addonify_wishlist_add_to_wishlist_button_styles_settings_fields()
                        ),
                        'custom_css' => array(
                            'title' => __( 'Developer', 'addonify-wishlist' ),
                            'description' => '',
                            'dependent'  => array('load_styles_from_plugin'),
                            'fields' => addonify_wishlist_custom_css_settings_fields()
                        )
                    )
                ),
                'products' => array(
                    'recommended' => array(
                        // Recommend plugins here.
                        'content' => __( 'Coming soon....', 'addonify-wishlist' ),
                    )
                ),
            ),
        );
    }
}