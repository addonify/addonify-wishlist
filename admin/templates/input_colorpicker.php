<?php
    
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    echo '<div class="colorpicker-group">';
    
    if( isset($arg['label']) ) {
        printf(
            '<p>%s</p>',
            esc_attr( $arg['label'] )
        );
    }

    printf(
        '<input type="text" value="%2$s" name="%1$s" id="%1$s" class="color-picker" data-alpha="true" />',
        $arg['name'],
        $db_value
    );

    echo '</div>';