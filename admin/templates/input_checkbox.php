<?php
    
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    printf(
        '<input type="checkbox"  name="%1$s" id="%1$s" value="1" %2$s %3$s />',
        esc_attr( $args['name'] ),
        $is_checked,
        $attr
    );