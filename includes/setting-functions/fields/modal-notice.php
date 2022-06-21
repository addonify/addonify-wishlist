<?php

if ( ! function_exists( 'addonify_wishlist_modal_notice_settings_fields' ) ) {

    function addonify_wishlist_modal_notice_settings_fields() {

        return array(
            'show_popup' => array(
                'type' => 'switch',
                'label' => __( 'Show successful popup notice', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'show_popup' )
            ),
            'redirect_to_wishlist_if_popup_disabled' => array(
                'type' => 'switch',
                'label' => __( 'Redirect to Wishlist page', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'redirect_to_wishlist_if_popup_disabled' )
            ),
            'view_wishlist_btn_text' => array(
                'type' => 'text',
                'label' => __( 'View Wishlist button label', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'view_wishlist_btn_text' )
            ),
            'product_added_to_wishlist_text' => array(
                'type' => 'text',
                'label' => __( 'Product added to Wishlist text', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'product_added_to_wishlist_text' )
            ),
            'product_already_in_wishlist_text' => array(
                'type' => 'text',
                'label' => __( 'Product already in Wishlist text', 'addonify-wishlist' ),
                'description' => '',
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