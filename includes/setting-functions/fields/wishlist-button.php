<?php 

if ( ! function_exists( 'addonify_wishlist_button_settings_fields' ) ) {

    function addonify_wishlist_button_settings_fields() {

        return array(
            'btn_position' => array(
                'type' => 'select',
                'className' => '',
                'label' => __( 'Button position', 'addonify-wishlist' ),
                'description' => __( 'Select button position.', 'addonify-wishlist' ),
                'choices' => array(
                    'after_add_to_cart' => __( 'After Add to Cart Button', 'addonify-wishlist' ),
                    'before_add_to_cart' => __( 'Before Add to Cart Button', 'addonify-wishlist' ),
                ),
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'btn_position' )
            ),
            'btn_label' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'Button label', 'addonify-wishlist' ),
                'description' => 'Label for add to wishlist button.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'btn_label' )
            ),
             'btn_custom_class' => array(
                'type' => 'text',
                'className' => '',
                'placeholder' => 'my_button rounded_button',
                'label' => __( 'CSS class', 'addonify-wishlist' ),
                'badge' => 'Optional',
                'description' => 'If required, add custom CSS class to add to wishlist button seperated with space.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'btn_custom_class' )
            ), 
            'btn_label_if_added_to_wishlist' => array(
                'type' => 'text',
                'className' => '',
                'label' => __( 'Label if product is in wishlist', 'addonify-wishlist' ),
                'description' => 'Add to wishlist button label if product is already in wishlist.',
                'dependent'  => array('enable_wishlist'),
                'value' => addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' )
            ),
            'show_icon' => array(
                'type' => 'switch',
                'className' => '',
                'label' => __( 'Show icon in button', 'addonify-wishlist' ),
                'description' => 'Display heart icon on add to wishlist button.',
                'dependent'  => array('enable_wishlist'),
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
                'label' => __( 'Label color', 'addonify-wishlist' ),
                'isAlphaPicker' => true,
                'className' => '',
                'value' => addonify_wishlist_get_option( 'wishlist_btn_text_color' )
            ),
            'wishlist_btn_icon_color' => array(
                'type' => 'color',
                'label' => __( 'Icon color', 'addonify-wishlist' ),
                'isAlphaPicker' => true,
                'className' => '',
                'value' => addonify_wishlist_get_option( 'wishlist_btn_icon_color' )
            ),
            'wishlist_btn_text_color_hover' => array(
                'type' => 'color',
                'label' => __( 'Label on Hover color', 'addonify-wishlist' ),
                'isAlphaPicker' => true,
                'className' => '',
                'value' => addonify_wishlist_get_option( 'wishlist_btn_text_color_hover' )
            ),
            'wishlist_btn_icon_color_hover' => array(
                'type' => 'color',
                'label' => __( 'Icon on Hover color', 'addonify-wishlist' ),
                'isAlphaPicker' => true,
                'className' => '',
                'value' => addonify_wishlist_get_option( 'wishlist_btn_icon_color_hover' )
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