<?php

if ( ! function_exists( 'addonify_wishlist_custom_css_settings_fields' ) ) {

    function addonify_wishlist_custom_css_settings_fields() {

        return array(
            'custom_css' => array(
                'type'              => 'textarea',
                'className'         => 'custom-css-box fullwidth',
                'inputClassName'    => 'custom-css-textarea',
                'label'             => __( 'Custom CSS', 'addonify-wishlist' ),
                'description'       => __( 'If required, add your custom CSS code here.', 'addonify-wishlist' ),
                'placeholder'       => '#app { color: blue; }',
                'value'             => addonify_wishlist_get_option( 'custom_css' )
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