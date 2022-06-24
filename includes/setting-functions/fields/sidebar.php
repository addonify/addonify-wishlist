<?php

if ( ! function_exists( 'addonify_wishlist_sidebar_settings_fields' ) ) {

    function addonify_wishlist_sidebar_settings_fields() {

        return array(
            'show_sidebar' => array(
                'type' => 'switch',
                'className' => '',
                'label' => __( 'Show sidebar', 'addonify-wishlist' ),
                'description' => 'If enabled, sticky wishlist canvas sidebar functionality will be added.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'show_sidebar' )
            ),
            'sidebar_position' => array(
                'type' => 'select',
                'dependent' => array('show_sidebar'),
                'className' => '',
                'label' => __( 'Sidebar position', 'addonify-wishlist' ),
                'description' => 'Choose where the sidebar will be displayed.',
                'choices' => array(
                    'left' => __( 'Left', 'addonify-wishlist' ),
                    'right' => __( 'Right', 'addonify-wishlist' ),
                ),
                'dependent'  => array('enable_wishlist', 'show_sidebar'),
                'value' => addonify_wishlist_get_option( 'sidebar_position' )
            ),
            'sidebar_title' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'Sidebar title', 'addonify-wishlist' ),
                'description' => 'Title will be displayed inside the canvas sidebar.',
                'dependent'  => array('enable_wishlist', 'show_sidebar'),
                'value' => addonify_wishlist_get_option( 'sidebar_title' )
            ),
            'sidebar_btn_label' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'Button label', 'addonify-wishlist' ),
                'description' => 'Label for the sidebar toggle button.',
                'dependent'  => array('enable_wishlist', 'show_sidebar'),
                'value' => addonify_wishlist_get_option( 'sidebar_btn_label' )
            ),
            'sidebar_show_icon' => array(
                'type' => 'switch',
                'label' => __( 'Show icon in button', 'addonify-wishlist' ),
                'description' => 'If enabled, an icon will be displayed along with the label in toggle button.',
                'dependent'  => array('enable_wishlist', 'show_sidebar'),
                'value' => addonify_wishlist_get_option( 'sidebar_show_icon' )
            ),
            'sidebar_btn_icon' => array(
                'type' => 'radio',
                'type_style' => "radio_icon",
                'className' => 'fullwidth radio-input-group',
                'label' => __( 'Select Icon', 'addonify-wishlist' ),
                'description' => 'Selected icon will be displayed in the toggle button.',
                'choices' => addonify_wishlist_get_sidebar_icons(),
                'dependent'  => array('enable_wishlist', 'show_sidebar'),
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