<?php

    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    printf(
        '<div class="addonify-add-to-wishlist-btn"><a role="button" aria-label="%1$s" class="%2$s" data-product_id="%3$s" ><span class="addonify-add-to-wishlist-text">%1$s</span></a></div>',
        esc_attr($data['label']),
        esc_attr($data['css_class']),
        esc_attr( $data['product_id'] ),
    );