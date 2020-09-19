<?php
    
    // direct access is disabled
    defined( 'ABSPATH' ) || exit;

    printf(
        '<input type="%4$s" class="regular-text %3$s" name="%1$s" id="%1$s" value="%2$s" %6$s /><span class="label-after-input">%5$s</span>',
        $args['name'],
        $db_value,
        $args['css_class'],
        $args['type'],
        $args['end_label'],
        $args['other_attr']
    );