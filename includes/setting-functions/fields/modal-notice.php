<?php

if ( ! function_exists( 'addonify_wishlist_modal_notice_settings_fields' ) ) {

    function addonify_wishlist_modal_notice_settings_fields() {

        return array(
            'view_wishlist_btn_text' => array(
                'type'              => 'text',
                'className'         => '',
                'label'             => __( 'View Wishlist Button Link Label', 'addonify-wishlist' ),
                'description'       => __( 'Label for button to link to wishlist page inside the popup modal box.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist'),
                'value'             => addonify_wishlist_get_option( 'view_wishlist_btn_text' )
            ),
            'product_added_to_wishlist_text' => array(
                'type'              => 'text',
                'className'         => '',
                'label'             => __( 'Product Added to Wishlist Text', 'addonify-wishlist' ),
                'description'       => '{product_name}' . " "  .__( 'placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
                'dependent'         => array('enable_wishlist'),
                'value'             => addonify_wishlist_get_option( 'product_added_to_wishlist_text' )
            ),
            'product_already_in_wishlist_text' => array(
                'type'              => 'text',
                'className'         => '',
                'label'             => __( 'Product Already in Wishlist Text', 'addonify-wishlist' ),
                'description'       => '{product_name}' . " " . __( 'placeholder will be replaced with the actual product name.', 'addonify-wihlist' ),
                'dependent'         => array('enable_wishlist'),
                'value'             => addonify_wishlist_get_option( 'product_already_in_wishlist_text' )
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


if ( ! function_exists( 'addonify_wishlist_modal_notice_styles_settings_fields' ) ) {

    function addonify_wishlist_modal_notice_styles_settings_fields() {

        return array(
            'popup_modal_overlay_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Overlay Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_overlay_bg_color' )
            ),
            'popup_modal_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_bg_color' )
            ),
            'popup_modal_icon_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Icon Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_icon_color' )
            ),
            'popup_modal_text_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Text Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_text_color' )
            ),
            'popup_modal_btn_text_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Buttons Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_btn_text_color' )
            ),
            'popup_modal_btn_text_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Buttons On Hover Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_btn_text_color_hover' )
            ),
            'popup_modal_btn_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Buttons Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_btn_bg_color' )
            ),
            'popup_modal_btn_bg_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Buttons On Hover Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'popup_modal_btn_bg_color_hover' )
            ),
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_modal_notice_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_modal_notice_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_modal_notice_styles_settings_fields() );
    }
    
    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_modal_notice_styles_add_to_settings_fields' );
}