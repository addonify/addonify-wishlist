<?php 

if ( ! function_exists( 'addonify_wishlist_button_settings_fields' ) ) {

    function addonify_wishlist_button_settings_fields() {

        return array(
            'btn_position' => array(
                'type'                      => 'select',
                'className'                 => '',
                'label'                     => __( 'Button Position', 'addonify-wishlist' ),
                'description'               => __( 'Choose where to place the Add to Wishlist button.', 'addonify-wishlist' ),
                'choices' => array(
                    'after_add_to_cart'     => __( 'After Add to Cart Button', 'addonify-wishlist' ),
                    'before_add_to_cart'    => __( 'Before Add to Cart Button', 'addonify-wishlist' ),
                ),
                'dependent'                 => array('enable_wishlist'),
                'value'                     => addonify_wishlist_get_option( 'btn_position' )
            ),
            'btn_label' => array(
                'type'                      => 'text',
                'className'                 => '',
                'label'                     => __( 'Button Label', 'addonify-wishlist' ),
                'description'               => __( 'Label for Add to Wishlist button.', 'addonify-wishlist' ),
                'dependent'                 => array('enable_wishlist'),
                'value'                     => addonify_wishlist_get_option( 'btn_label' )
            ),
             'btn_custom_class' => array(
                'type'                      => 'text',
                'className'                 => '',
                'placeholder'               => 'my_button rounded_button',
                'label'                     => __( 'Custom CSS Class', 'addonify-wishlist' ),
                'badge'                     => __( 'Optional', 'addonify-wishlist' ),
                'description'               => __( 'Add custom CSS class(es) to Add to Wishlist button. Separate CSS classes with spaces.', 'addonify-wishlist' ),
                'dependent'                 => array('enable_wishlist'),
                'value'                     => addonify_wishlist_get_option( 'btn_custom_class' )
            ), 
            'btn_label_if_added_to_wishlist' => array(
                'type'                       => 'text',
                'className'                  => '',
                'label'                      => __( 'Already in Wishlist Button Label', 'addonify-wishlist' ),
                'description'                => __( 'Set the label for Add to Wishlist button, if a product is already in the wishlist.', 'addonify-wishlist' ),
                'dependent'                  => array('enable_wishlist'),
                'value'                      => addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' )
            ),
            'show_icon' => array(
                'type'                        => 'switch',
                'className'                   => '',
                'label'                       => __( 'Show Icon in Button', 'addonify-wishlist' ),
                'description'                 => __( 'Display heart icon before Add to Wishlist button label.', 'addonify-wishlist' ),
                'dependent'                   => array('enable_wishlist'),
                'value'                       => addonify_wishlist_get_option( 'show_icon' )
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
                'type'                        => 'color',
                'label'                       => __( 'Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'wishlist_btn_text_color' )
            ),
            'wishlist_btn_text_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'On Hover Label Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'wishlist_btn_text_color_hover' )
            ),
            'wishlist_btn_icon_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Icon Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'wishlist_btn_icon_color' )
            ),            
            'wishlist_btn_icon_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'On Hover Icon Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'wishlist_btn_icon_color_hover' )
            ), 
            'wishlist_btn_bg_color' => array(
                'type'                        => 'color',
                'label'                       => __( 'Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'wishlist_btn_bg_color' )
            ),
            'wishlist_btn_bg_color_hover' => array(
                'type'                        => 'color',
                'label'                       => __( 'On Hover Background Color', 'addonify-wishlist' ),
                'isAlphaPicker'               => true,
                'className'                   => '',
                'value'                       => addonify_wishlist_get_option( 'wishlist_btn_bg_color_hover' )
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