<?php
    
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    printf(
        '<input type="text" class="regular-text" name="%1$s" id="%1$s" value="%2$s" />',
        esc_attr( $args['name'] ),
        esc_attr( $db_value )
    );