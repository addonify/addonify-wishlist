<?php

if ( ! function_exists( 'addonify_wishlist_sidebar_settings_fields' ) ) {

    function addonify_wishlist_sidebar_settings_fields() {

        return array(
            'show_sidebar' => array(
                'type'              => 'switch',
                'className'         => '',
                'label'             => __( 'Show Sidebar', 'addonify-wishlist' ),
                'description'       => __( 'Sidebar off-canvas modal will be enabled to display wishlist items.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist'),
                'value'             => addonify_wishlist_get_option( 'show_sidebar' )
            ),
            'sidebar_position' => array(
                'type'              => 'select',
                'dependent'         => array('show_sidebar'),
                'className'         => '',
                'label'             => __( 'Sidebar Position', 'addonify-wishlist' ),
                'description'       => __( 'Choose position of the sidebar to be displayed.', 'addonify-wishlist' ),
                'choices' => array(
                    'left'          => __( 'Left', 'addonify-wishlist' ),
                    'right'         => __( 'Right', 'addonify-wishlist' ),
                ),
                'dependent'         => array('enable_wishlist', 'show_sidebar'),
                'value'             => addonify_wishlist_get_option( 'sidebar_position' )
            ),
            'sidebar_title' => array(
                'type'              => 'text',
                'className'         => '',
                'label'             => __( 'Sidebar Title', 'addonify-wishlist' ),
                'description'       => __( 'Set the title of the wishlist to be displayed inside the sidebar.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist', 'show_sidebar'),
                'value'             => addonify_wishlist_get_option( 'sidebar_title' )
            ),
            'sidebar_btn_label' => array(
                'type'              => 'text',
                'className'         => '',
                'label'             => __( 'Sidebar Toggle Button Label', 'addonify-wishlist' ),
                'description'       => __( 'Set sidebar toggle button label.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist', 'show_sidebar'),
                'value'             => addonify_wishlist_get_option( 'sidebar_btn_label' )
            ),
            'sidebar_btn_position_offset' => array(
                'type'              => 'number',
                'typeStyle'         => 'slider',
                'typeMinVal'        => -300, // optional
                'typeMaxVal'        => 300, // optional
                'typeStepVal'       => 1, // optional
                'typeToolTipText'   => 'px', // optional
                'className'         => 'fullwidth', // optional
                'label'             => __( 'Sidebar Toggle Button Position Offset', 'addonify-wishlist' ),
                'description'       => __( 'Set left or right position distance offset value.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist', 'show_sidebar'),
                'value'             => addonify_wishlist_get_option( 'sidebar_btn_position_offset' )
            ),
            'sidebar_show_icon' => array(
                'type'              => 'switch',
                'label'             => __( 'Show Icon in Sidebar Toggle Button', 'addonify-wishlist' ),
                'description'       => __( 'Enable to display an icon with the label in sidebar toggle button.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist', 'show_sidebar'),
                'value'             => addonify_wishlist_get_option( 'sidebar_show_icon' )
            ),
            'sidebar_btn_icon' => array(
                'type'              => 'radio',
                'typeStyle'        => "radio_icon",
                'className'         => 'fullwidth radio-input-group',
                'label'             => __( 'Select Icon', 'addonify-wishlist' ),
                'description'       => __( 'Select icon to be displayed in the sidebar toggle button.', 'addonify-wishlist' ),
                'choices'           => addonify_wishlist_get_sidebar_icons(),
                'dependent'         => array('enable_wishlist', 'show_sidebar', 'sidebar_show_icon'),
                'value'             => addonify_wishlist_get_option( 'sidebar_btn_icon' )
            ),
            'view_wishlist_page_button_label' => array(
                'type'              => 'text',
                'className'         => '',
                'label'             => __( 'View Wishlist Page Button Label', 'addonify-wishlist' ),
                'description'       => __( 'Set the button label of link to wishlist page.', 'addonify-wishlist' ),
                'dependent'         => array('enable_wishlist', 'show_sidebar'),
                'value'             => addonify_wishlist_get_option( 'view_wishlist_page_button_label' )
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



if ( ! function_exists( 'addonify_wishlist_sidebar_modal_styles_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_styles_settings_fields() {

        return array(
            'sidebar_modal_overlay_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Overlay Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_bg_color' )
            ),
            'sidebar_modal_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_bg_color' )
            ),
            'sidebar_modal_general_border_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'General Border Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_bg_color' )
            ),
            'sidebar_modal_title_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Title Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_title_color' )
            ),
            'sidebar_modal_empty_text_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Empty Wishlist Text Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_empty_text_color' )
            ),
            'sidebar_modal_close_icon_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Close Icon Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_close_icon_color' )
            ),      
            'sidebar_modal_close_icon_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'On Hover Close Icon Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_close_icon_color_hover' )
            ),
               
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_sidebar_modal_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_sidebar_modal_styles_settings_fields() );
    }
    
    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_sidebar_modal_styles_add_to_settings_fields' );
}


if ( ! function_exists( 'addonify_wishlist_sidebar_modal_toggle_button_styles_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_toggle_button_styles_settings_fields() {

        return array(
            'sidebar_modal_toggle_btn_label_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Button Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_label_color' )
            ),
            'sidebar_modal_toggle_btn_label_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Button On Hover Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_label_color_hover' )
            ),
            'sidebar_modal_toggle_btn_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Button Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_bg_color' )
            ),            
            'sidebar_modal_toggle_btn_bg_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Button On Hover Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_bg_color_hover' )
            ), 
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_sidebar_modal_toggle_button_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_toggle_button_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_sidebar_modal_toggle_button_styles_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_sidebar_modal_toggle_button_styles_add_to_settings_fields' );
}

if ( ! function_exists( 'addonify_wishlist_product_content_styles_settings_fields' ) ) {

    function addonify_wishlist_product_content_styles_settings_fields() {

        return array(
            'sidebar_modal_product_title_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Title Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_title_color' )
            ),
            'sidebar_modal_product_title_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Title Color on Hover', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_title_color' )
            ),
            'sidebar_modal_product_regular_price_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Regular Price Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_regular_price_color' )
            ),
            'sidebar_modal_product_sale_price_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Sale Price Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_sale_price_color' )
            ),
            'sidebar_modal_product_add_to_cart_label_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Add to Cart Button Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_label_color' )
            ),
            'sidebar_modal_product_add_to_cart_label_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Add to Cart Button On Hover Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_label_color_hover' )
            ),
            'sidebar_modal_product_add_to_cart_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Add to Cart Button Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_bg_color' )
            ),            
            'sidebar_modal_product_add_to_cart_bg_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Add to Cart Button On Hover Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_bg_color_hover' )
            ),
            'sidebar_modal_product_remove_from_wishlist_icon_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Remove Icon Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_remove_from_wishlist_icon_color' )
            ),
            'sidebar_modal_product_remove_from_wishlist_icon_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'Remove Icon Color on Hover', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_product_remove_from_wishlist_icon_color' )
            ),
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_product_content_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_product_content_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_product_content_styles_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_product_content_styles_add_to_settings_fields' );
}


if ( ! function_exists( 'addonify_wishlist_sidebar_modal_notification_styles_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_notification_styles_settings_fields() {

        return array(
            'sidebar_modal_notification_text_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Text Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_notification_text_color' )
            ),
            'sidebar_modal_notification_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_notification_bg_color' )
            ),
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_sidebar_modal_notification_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_notification_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_sidebar_modal_notification_styles_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_sidebar_modal_notification_styles_add_to_settings_fields' );
}


if ( ! function_exists( 'addonify_wishlist_sidebar_modal_view_wishlist_button_styles_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_view_wishlist_button_styles_settings_fields() {

        return array(
            'sidebar_modal_view_wishlist_btn_label_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_label_color' )
            ),
            'sidebar_modal_view_wishlist_btn_label_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'On Hover Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_label_color_hover' )
            ),
            'sidebar_modal_view_wishlist_btn_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_bg_color' )
            ),            
            'sidebar_modal_view_wishlist_btn_bg_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'On Hover Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_bg_color_hover' )
            ),
        );  
    }
}

if ( ! function_exists( 'addonify_wishlist_sidebar_modal_view_wishlist_button_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_sidebar_modal_view_wishlist_button_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_sidebar_modal_view_wishlist_button_styles_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_sidebar_modal_view_wishlist_button_styles_add_to_settings_fields' );
}
