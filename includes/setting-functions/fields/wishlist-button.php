<?php 

if ( ! function_exists( 'addonify_wishlist_button_settings_fields' ) ) {

    function addonify_wishlist_button_settings_fields() {

        return array(
            'btn_position' => array(
                'type' => 'select',
                'label' => __( 'Wishlist Page', 'addonify-wishlist' ),
                'description' => __( 'Button position', 'addonify-wishlist' ),
                'choices' => array(
                    'after_add_to_cart' => __( 'After Add to Cart Button', 'addonify-wishlist' ),
                    'before_add_to_cart' => __( 'Before Add to Cart Button', 'addonify-wishlist' ),
                ),
                'value' => addonify_wishlist_get_option( 'btn_position' )
            ),
            'btn_label' => array(
                'type' => 'text',
                'label' => __( 'Button label', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'btn_label' )
            ),
            'btn_label_if_added_to_wishlist' => array(
                'type' => 'text',
                'label' => __( 'Button label if product is already in Wishlist', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' )
            ),
            'show_icon' => array(
                'type' => 'switch',
                'label' => __( 'Show icon in button', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'show_icon' )
            )
        );
    }
}


if ( ! function_exists( 'addonify_wishlist_button_add_to_settings_fields' ) ) {

    function addonify_wishlist_button_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_button_settings_fields() );
    }

    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_button_add_to_settings_fields' );
}






if ( ! function_exists( 'addonify_wishlist_add_to_wishlist_button_styles_settings_fields' ) ) {

    function addonify_wishlist_add_to_wishlist_button_styles_settings_fields() {

        return array(
            'wishlist_btn_text_color' => array(
                'type' => 'color',
                'label' => __( 'Label Color', 'addonify-wishlist' ),
                'value' => addonify_wishlist_get_option( 'wishlist_btn_text_color' )
            ),
            'wishlist_btn_icon_color' => array(
                'type' => 'color',
                'label' => __( 'Icon Color', 'addonify-wishlist' ),
                'value' => addonify_wishlist_get_option( 'wishlist_btn_icon_color' )
            ),
            'wishlist_btn_text_color_hover' => array(
                'type' => 'color',
                'label' => __( 'Label on Hover Color', 'addonify-wishlist' ),
                'value' => addonify_wishlist_get_option( 'wishlist_btn_text_color_hover' )
            ),
            'wishlist_btn_icon_color_hover' => array(
                'type' => 'color',
                'label' => __( 'Icon on Hover Color', 'addonify-wishlist' ),
                'value' => addonify_wishlist_get_option( 'wishlist_btn_icon_color_hover' )
            ), 
            'btn_custom_class' => array(
                'type' => 'text',
                'label' => __( 'Custom CSS class', 'addonify-wishlist' ),
                'description' => '',
                'value' => addonify_wishlist_get_option( 'btn_custom_class' )
            ),    
        );
    }
}

if ( ! function_exists( 'addonify_wishlist_add_to_wishlist_button_styles_add_to_settings_fields' ) ) {

    function addonify_wishlist_add_to_wishlist_button_styles_add_to_settings_fields( $settings_fields ) {

        return array_merge( $settings_fields, addonify_wishlist_add_to_wishlist_button_styles_settings_fields() );
    }
    
    add_filter( 'addonify_wishlist/settings_fields', 'addonify_wishlist_add_to_wishlist_button_styles_add_to_settings_fields' );
}