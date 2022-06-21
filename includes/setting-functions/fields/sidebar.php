<?php

if ( ! function_exists( 'addonify_wishlist_sidebar_settings_fields' ) ) {

    function addonify_wishlist_sidebar_settings_fields() {

        return array(
            'show_sidebar' => array(
                'type' => 'switch',
                'label' => __( 'Show Sidebar', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'show_sidebar' )
            ),
            'sidebar_position' => array(
                'type' => 'select',
                'label' => __( 'Sidebar Position', 'addonify-wishlist' ),
                'description' => '',
                'choices' => array(
                    'left' => __( 'Left', 'addonify-wishlist' ),
                    'right' => __( 'Right', 'addonify-wishlist' ),
                ),
                'value' => addonify_wishlist_get_option( 'sidebar_position' )
            ),
            'sidebar_title' => array(
                'type' => 'text',
                'label' => __( 'Sidebar title', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'sidebar_title' )
            ),
            'sidebar_toggle_btn_heading' => array(
                'type' => 'heading',
                'label' => __( 'Sidebar Toggle Button', 'addonify-wishlist' ),
                'description' => '',
            ),
            'sidebar_btn_label' => array(
                'type' => 'text',
                'label' => __( 'Button label', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'sidebar_btn_label' )
            ),
            'sidebar_show_icon' => array(
                'type' => 'switch',
                'label' => __( 'Show icon in button', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'sidebar_show_icon' )
            ),
            'sidebar_btn_icon' => array(
                'type' => 'select',
                'label' => __( 'Select Icon', 'addonify-wishlist' ),
                'description' => '',
                'choices' => addonify_wishlist_get_sidebar_icons(),
                'value' => addonify_wishlist_get_option( 'sidebar_btn_icon' )
            ),
        );
    }
}


if ( ! function_exists( 'addonify_wishlist_sidebar_add_to_settings_fields' ) ) {

    function addonify_wishlist_sidebar_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_sidebar_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_sidebar_add_to_settings_fields' );
}