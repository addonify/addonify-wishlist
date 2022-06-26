<?php 

if ( ! function_exists( 'addonify_wishlist_general_setting_fields' ) ) {

    function addonify_wishlist_general_setting_fields() {

        return array(
            'enable_wishlist' => array(
                'label'			  => __( 'Enable wishlist', 'addonify-wishlist' ),
                'description'     => __( 'If disabled, addonify wishlist plugin functionality will not be functional.', 'addonify-wishlist' ),
                'type'            => 'switch',
                'className'      => '',
                'badge'          => 'Required',
                'value' => addonify_wishlist_get_option( 'enable_wishlist' )
            ),
            'wishlist_page' => array(
                'type' => 'select',
                'className'      => '',
                'label' => __( 'Wishlist page', 'addonify-wishlist' ),
                'description' => 'Select a page to display wishlist table.',
                'dependent'  => array('enable_wishlist'),
                'choices' => addonify_wishlist_get_pages(),
                'value' => addonify_wishlist_get_option( 'wishlist_page' )
            ),
            'require_login' => array(
                'type' => 'switch',
                'label' => __( 'Require login', 'addonify-wishlist' ),
                'description' => 'Allow only logged-in users to add products in wishlist.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'require_login' )
            ),
            'redirect_to_login' => array(
                'type' => 'switch',
                'className'      => '',
                'label' => __( 'Redirect to login page', 'addonify-wishlist' ),
                'description' => 'Redirect to login if non logged-in user tries to add product in wishlist.',
                'dependent'  => array('enable_wishlist','require_login'),
                'value' => addonify_wishlist_get_option( 'redirect_to_login' )
            ),
            'redirect_to_checkout_if_item_added_to_cart' => array(
                'type' => 'switch',
                'className'      => '',
                'label' => __( 'Redirect to the checkout', 'addonify-wishlist' ),
                'description' => 'Redirect to the checkout page if wishlist item is added to cart.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'redirect_to_checkout_if_item_added_to_cart' )
            ),
            'remove_from_wishlist_if_added_to_cart' => array(
                'type' => 'switch',
                'className'      => '',
                'label' => __( 'Remove product from wishlist', 'addonify-wishlist' ),
                'description' => 'Remove product from wishlist if it is added to cart.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' )
            ),
            'cookies_lifetime' => array(
                'type' => 'number',
                'className'      => '',
                'type_style' => 'toggle', // 'default', 'toggle' & slider
                'label' => __( 'Save wishlist for [ x ] days', 'addonify-wishlist' ),
                'dependent'  => array('enable_wishlist'),
                'description' => 'For how many days do you wish to save wishlist in browser cookie?',
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
                'className'      => '',
                'label' => __( 'Enable plugin styles', 'addonify-wishlist' ),
                'description' => 'If enabled, the colors selected below will be applied.',
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