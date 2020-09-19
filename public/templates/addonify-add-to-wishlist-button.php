<?php

    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    printf(
        '<div class="addonify-add-to-wishlist-btn"><button type="button" class="%2$s" data-product_id="%3$s" data-product_name="%4$s" >%1$s</button></div>',
        esc_attr( $data['label'] ),
        esc_attr( $data['css_class']) ,
        esc_attr( $data['product_id'] ),
        esc_attr( $data['name'] )
    );