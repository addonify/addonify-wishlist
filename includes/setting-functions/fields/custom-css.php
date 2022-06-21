<?php

if ( ! function_exists( 'addonify_wishlist_custom_css_settings_fields' ) ) {

    function addonify_wishlist_custom_css_settings_fields() {

        return array(
            'custom_css' => array(
                'type' => 'textarea',
                'label' => __( 'Custom CSS', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'custom_css' )
            )
        );
    }
}


if ( ! function_exists( 'addonify_wishlist_custom_css_add_to_settings_fields' ) ) {

    function addonify_wishlist_custom_css_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_custom_css_settings_fields() );
    }
    
    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_custom_css_add_to_settings_fields' );
}