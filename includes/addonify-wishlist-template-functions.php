<?php 

if ( ! function_exists( 'addonify_wishlist_locate_template' ) ) {

    function addonify_wishlist_locate_template( $template_name, $template_path = '', $default_path = '' ) {

        // Set template location for theme 
        if ( empty( $template_path )) :
            $template_path = 'addonify/';
        endif;

        // Set default plugin templates path.
        if ( ! $default_path ) :
            $default_path = plugin_dir_path( dirname(__FILE__ ) ) . 'public/templates/'; // Path to the template folder
        endif;

        // Search template file in theme folder.
        $template = locate_template( array(
            $template_path . $template_name,
            $template_name
        ) );

        // Get plugins template file.
        if ( ! $template ) :
            $template = $default_path . $template_name;
        endif;

        return apply_filters( 'addonify_wishlist/locate_template', $template, $template_name, $template_path, $default_path );
    }
}


if ( ! function_exists( 'addonify_wishlist_get_template' ) ) {

    function addonify_wishlist_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

        if ( is_array( $args ) && isset( $args ) ) :
            extract( $args );
        endif;

        $template_file = addonify_wishlist_locate_template( $template_name, $tempate_path, $default_path );

        if ( ! file_exists( $template_file ) ) :
            _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
            return;
        endif;

        include $template_file;
    }
}



if ( ! function_exists( 'addonify_wishlist_render_add_to_wishlist_button' ) ) {

    function addonify_wishlist_render_add_to_wishlist_button() {

        // Return if button label and icon is not set.
		if ( 
			! addonify_wishlist_get_option( 'btn_label' ) &&
			! (int) addonify_wishlist_get_option( 'show_icon' ) == 1
		) {
			return;
		}

		global $product;

		$add_to_wishlist_button_args = array(
			'product_id' => $product->get_id(),
			'button_label' => addonify_wishlist_get_option( 'btn_label' ),
			'button_classes' => array( 'button', 'adfy-wishlist-btn', 'addonify-add-to-wishlist-btn' ),
			'product_name' => $product->get_title(),
			'display_icon' => addonify_wishlist_get_option( 'show_icon' ),
			'icon' => 'heart-o-style-one',
			'redirect_to_login' => false,
			'login_url' => '',
			'require_login' => false,
			'display_popup_notice' => false
		);

		// Add class, 'after-add-to-cart', if button is to be displayed after add to cart button.
		if ( addonify_wishlist_get_option( 'btn_position' ) == 'after_add_to_cart' ) {

			$add_to_wishlist_button_args['button_classes'][] = 'after-add-to-cart';
		}

		// Add class, 'before-add-to-cart', if button is to be displayed before add to cart button.
		if ( addonify_wishlist_get_option( 'btn_position' ) == 'before_add_to_cart' ) {

			$add_to_wishlist_button_args['button_classes'][] = 'before-add-to-cart';
		}

		// Add class, 'show', if there is button label.
		if ( addonify_wishlist_get_option( 'btn_label' ) ) {

			$add_to_wishlist_button_args['button_classes'][] = 'show-label';
		}

		// If product is already in the wishlist, add a class, set button label and set button icon.
		if ( addonify_wishlist_is_product_in_wishlist( $product->get_id() ) ) {

			$add_to_wishlist_button_args['button_classes'][] = 'added-to-wishlist';

			$add_to_wishlist_button_args['button_label'] = addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' );

			$add_to_wishlist_button_args['icon'] = 'heart-style-one';

			if ( (int) addonify_wishlist_get_option( 'show_icon' ) == 1 ) {

				$add_to_wishlist_button_args['button_classes'][] = 'show-icon xxxxx-heart-xxxxx';
			}
		}

		// Add custom CSS class to the button if set.
		if ( addonify_wishlist_get_option( 'btn_custom_class' ) ) {

			$add_to_wishlist_button_args['button_classes'][] = addonify_wishlist_get_option( 'btn_custom_class' );
		}

		// Set button properties check the need of user login.
		if ( 
			(int) addonify_wishlist_get_option( 'require_login' ) == 1 &&
			! is_user_logged_in()
		) {

			$add_to_wishlist_button_args['require_login'] = true;

			if ( addonify_wishlist_get_option( 'if_not_login_action' ) == 'show_popup' ) {

				$add_to_wishlist_button_args['button_classes'][] = 'addonify-wishlist-login-popup-enabled';
			} else {

				$add_to_wishlist_button_args['login_url'] = ( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url();
			}
		} else {
			if ( addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) == 'show_popup_notice' ) {

				$add_to_wishlist_button_args['display_popup_notice'] = true;

				$add_to_wishlist_button_args['button_classes'][] = 'addonify-wishlist-ajax-add-to-wishlist';
			}
		}

        addonify_wishlist_get_template( 
            'addonify-add-to-wishlist-button.php', 
            apply_filters( 'addonify_wishlist/add_to_wishlist_button_args', $add_to_wishlist_button_args ) 
        );
    }
}
