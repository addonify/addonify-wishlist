<?php

    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    if( $show_icon ) {
        $label = '<span class="icon"><i class="adfy-wishlist-icon heart-o-style-one"></i></span> ' . esc_html( $label );
    }

    printf(
        '<div class="addonify-add-to-wishlist-btn"><button type="button" class="button adfy-wishlist-btn %2$s" data-product_id="%3$s" data-product_name="%4$s"> %1$s</button></div>',
        $label,
        esc_attr( $css_class) ,
        esc_attr( $product_id ),
        esc_attr( $name )
    );