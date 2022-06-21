<?php 

if ( ! function_exists( 'addonify_wishlist_general_setting_fields' ) ) {

    function addonify_wishlist_general_setting_fields() {

        return array(
            'enable_wishlist' => array(
                'label'			=> __( 'Enable Wishlist', 'addonify-wishlist' ),
                'description'     => __( 'Once enabled, it will be visible in product catalog.', 'addonify-wishlist' ),
                'type'            => 'switch',
                'value' => addonify_wishlist_get_option( 'enable_wishlist' )
            ),
            'wishlist_page' => array(
                'type' => 'select',
                'label' => __( 'Wishlist Page', 'addonify-wishlist' ),
                'description' => '',
                'choices' => addonify_wishlist_get_pages(),
                'value' => addonify_wishlist_get_option( 'wishlist_page' )
            ),
            'login_heading' => array(
                'type' => 'heading',
                'label' => __( 'Login Action', 'addonify-wishlist' ),
                'description' => '',
            ),
            'require_login' => array(
                'type' => 'switch',
                'label' => __( 'Require Login', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'require_login' )
            ),
            'redirect_to_login' => array(
                'type' => 'switch',
                'label' => __( 'Redirect to Login Page', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'redirect_to_login' )
            ),
            'wishlist_add_to_cart_heading' => array(
                'type' => 'heading',
                'label' => __( 'Wishlist Add to Cart Action', 'addonify-wishlist' ),
                'description' => '',
            ),
            'redirect_to_checkout_if_item_added_to_cart' => array(
                'type' => 'switch',
                'label' => __( 'Redirect to the checkout page from Wishlist if added to cart', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'redirect_to_checkout_if_item_added_to_cart' )
            ),
            'remove_from_wishlist_if_added_to_cart' => array(
                'type' => 'switch',
                'label' => __( 'Remove Product from Wishlist if added to cart', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' )
            ),
            'wishlist_cookie_heading' => array(
                'type' => 'heading',
                'label' => __( 'Wishlist Cookie', 'addonify-wishlist' ),
                'description' => '',
            ),
            'cookies_lifetime' => array(
                'type' => 'number',
                'label' => __( 'Save Wishlist for', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'cookies_lifetime' )
            ),
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_general_add_to_settings_fields' ) ) {

    function addonify_wishlist_general_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_general_setting_fields() );
    }
    
    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_general_add_to_settings_fields' );
}


if ( ! function_exists( 'addonify_wishlist_general_styles_settings_fields' ) ) {

    function addonify_wishlist_general_styles_settings_fields() {

        return array(
            'load_styles_from_plugin' => array(
                'type' => 'switch',
                'label' => __( 'Load CSS Styles From Plugin', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'load_styles_from_plugin' )
            )
        );
    }
}


if ( ! function_exists( 'addonify_wishlist_general_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_general_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_general_styles_settings_fields() );
    }
    
    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_general_styles_add_to_settings_fields' );
}