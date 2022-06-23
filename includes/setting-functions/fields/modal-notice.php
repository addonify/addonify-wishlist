<?php

if ( ! function_exists( 'addonify_wishlist_modal_notice_settings_fields' ) ) {

    function addonify_wishlist_modal_notice_settings_fields() {

        return array(
            'show_popup' => array(
                'type' => 'switch',
                'className' => '',
                'label' => __( 'Successful popup notice', 'addonify-wishlist' ),
                'description' => 'Show successful popup notice after product is added to wishlist',
                'value' => addonify_wishlist_get_option( 'show_popup' )
            ),
            'redirect_to_wishlist_if_popup_disabled' => array(
                'type' => 'switch',
                'className' => '',
                'label' => __( 'Redirect to wishlist page', 'addonify-wishlist' ),
                'description' => 'Redirect to wishlist page if popup is disabled.',
                'value' => addonify_wishlist_get_option( 'redirect_to_wishlist_if_popup_disabled' )
            ),
            'view_wishlist_btn_text' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'View wishlist button label', 'addonify-wishlist' ),
                'description' => 'Label for button inside popup modal box.',
                'value' => addonify_wishlist_get_option( 'view_wishlist_btn_text' )
            ),
            'product_added_to_wishlist_text' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'Product added to wishlist text', 'addonify-wishlist' ),
                'description' => '{product_name} placeholder will be replaced with the actual product name.',
                'value' => addonify_wishlist_get_option( 'product_added_to_wishlist_text' )
            ),
            'product_already_in_wishlist_text' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'Product already in wishlist text', 'addonify-wishlist' ),
                'description' => '{product_name} placeholder will be replaced with the actual product name.',
                'value' => addonify_wishlist_get_option( 'product_already_in_wishlist_text' )
            ),
        );
    }
}


if ( ! function_exists( 'addonify_wishlist_modal_notice_add_to_settings_fields' ) ) {

    function addonify_wishlist_modal_notice_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_modal_notice_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_modal_notice_add_to_settings_fields' );
}