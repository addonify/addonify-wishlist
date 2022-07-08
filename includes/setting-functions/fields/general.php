<?php 

if ( ! function_exists( 'addonify_wishlist_general_setting_fields' ) ) {

    function addonify_wishlist_general_setting_fields() {

        return array(
            'enable_wishlist' => array(
                'label'			  => __( 'Enable wishlist', 'addonify-wishlist' ),
                'description'     => __( 'If disabled, addonify wishlist plugin functionality will not be functional.', 'addonify-wishlist' ),
                'type'            => 'switch',
                'className'       => '',
                'badge'           => 'Required',
                'value' => addonify_wishlist_get_option( 'enable_wishlist' )
            ),
            'wishlist_page' => array(
                'type' => 'select',
                'className'      => '',
                'placeholder'    => __('Select a page', 'addonify-wishlist'),
                'label'          => __( 'Wishlist Page', 'addonify-wishlist' ),
                'description'    => __( 'Select a page to display wishlist table.', 'addonify-wishlist'),
                'dependent'      => array('enable_wishlist'),
                'choices'        => addonify_wishlist_get_pages(),
                'value'          => addonify_wishlist_get_option( 'wishlist_page' )
            ),
            'require_login' => array(
                'type'          => 'switch',
                'label'         => __( 'Require Login', 'addonify-wishlist' ),
                'description'   => __('A user is required to be logged-in inorder to add products in the wishlist.', 'addonify-wishlist'),
                'dependent'     => array('enable_wishlist'),
                'value'         => addonify_wishlist_get_option( 'require_login' )
            ),
            'if_not_login_action' => array(
                'type'           => 'select',
                'className'      => '',
                'placeholder'    => __( 'Select Action', 'addonify-wishlist'),
                'label'          => __( 'If not login action', 'addonify-wishlist' ),
                'description'    => __( 'If user is required to be logged-in, choose what to do if the user tries to add product into the wishlist..', 'addonify-wishlist'),
                'dependent'      => array('enable_wishlist', 'require_login'),
                'choices'        => array(
                    'default'    => __( 'Redirect to login page', 'addonify-wishlist' ),
                    'show_popup'   => __( 'Display login popup notice', 'addonify-wishlist' ),
                ),
                'value'          => addonify_wishlist_get_option( 'if_not_login_action' )
            ),
            'cookies_lifetime' => array(
                'type'          => 'number',
                'className'     => '',
                'typeStyle'    => 'toggle', // 'default', 'toggle' & slider
                'label'         => __( 'Save Wishlist Cookie for [ x ] days', 'addonify-wishlist' ),
                'dependent'     => array('enable_wishlist'),
                'description'   => __( 'Set the number of days to save the Wishlist data in browser cookie.', 'addonify-wsihlist' ),
                'value'         => addonify_wishlist_get_option( 'cookies_lifetime' )
            ),
            'after_add_to_wishlist_action'    => array(
                'type'                        => 'select',
                'className'                   => '',
                'label'                       => __( 'After Add to Wishlist Action', 'addonify-wishlist' ),
                'description'                 => __( 'Choose what to do after a product is successfully added to the wishlist.', 'addonify-wishlist' ),
                'dependent'                   => array('enable_wishlist'),
                'value'                       => addonify_wishlist_get_option( 'after_add_to_wishlist_aciton' ),
                'choices'                     => array(
                    'none'                    => __( 'Default', 'addonify-wishlist' ),
                    'show_popup_notice'       => __( 'Show Popup Notice', 'addonify-wishlist' ),
                    'redirect_to_wishlist_page'    => __( 'Redirect to Wishlist Page', 'addonify-wishlist' ),
                ),
            ),
            'redirect_to_checkout_if_product_added_to_cart' => array(
                'type'          => 'switch',
                'className'     => '',
                'label'         => __( 'Redirect to Checkout', 'addonify-wishlist' ),
                'description'   => __( 'Redirect to the checkout page if the product in the wishlist is added into cart.', 'addonify-wishlist' ),
                'dependent'     => array('enable_wishlist'),
                'value'         => addonify_wishlist_get_option( 'redirect_to_checkout_if_product_added_to_cart' )
            ),
            'remove_from_wishlist_if_added_to_cart' => array(
                'type'          => 'switch',
                'className'     => '',
                'label'         => __( 'Remove Product From Wishlist', 'addonify-wishlist' ),
                'description'   => __( 'Remove the product from wishlist if the product is successfully added to cart.', 'addonify-wishlist' ),
                'dependent'     => array('enable_wishlist'),
                'value'         => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' )
            ),
            'ajaxify_add_to_cart' => array(
                'type'          => 'switch',
                'className'     => '',
                'label'         => __( 'Ajaxify Add to Cart Action', 'addonify-wishlist' ),
                'description'   => __( 'Add the product into the cart with ajax call.', 'addonify-wishlist' ),
                'dependent'     => array('enable_wishlist'),
                'value'         => addonify_wishlist_get_option( 'ajaxify_add_to_cart' )
            ),
            'ajaxify_remove_from_wishlist_button' => array(
                'type'              => 'switch',
                'label'             => __( 'Ajaxify Remove from Wishlist Action', 'addonify-wishlist' ),
                'description'       => __( 'Remove the product from wishlist with ajax call.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist'),
                'value'             => addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' )
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
                'type'              => 'switch',
                'className'         => '',
                'label'             => __( 'Enable Styles from Plugin', 'addonify-wishlist' ),
                'description'       => __( 'Enable to apply styles and colors from the plugin.', 'addonify-wishlist' ),
                'value'             => addonify_wishlist_get_option( 'load_styles_from_plugin' )
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