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

        require $template_file;
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
            apply_filters( 
				'addonify_wishlist/add_to_wishlist_button_args', 
				$add_to_wishlist_button_args 
			) 
        );
    }
}


if ( ! function_exists( 'addonify_wishlist_render_wishlist_content' ) ) {

	function addonify_wishlist_render_wishlist_content() {

		$wishlist_product_ids = array();

		if ( addonify_wishlist_get_wishlist_items_count() > 0 ) {

			$wishlist_product_ids = array_keys( addonify_wishlist_get_wishlist_items() );
		}

		if ( wp_doing_ajax() ) {
			ob_start();
			addonify_wishlist_get_template( 
				'addonify-wishlist-shortcode-contents.php', 
				apply_filters( 
					'addonify_wishlist/shortcode_contents_args', 
					array(
						'wishlist_product_ids' => $wishlist_product_ids,
						'nonce' => wp_create_nonce( 'addonify-wishlist' ),
					) 
				) 
			);
			return ob_get_clean();
		} else {
			addonify_wishlist_get_template( 
				'addonify-wishlist-shortcode-contents.php', 
				apply_filters( 
					'addonify_wishlist/shortcode_contents_args', 
					array(
						'wishlist_product_ids' => $wishlist_product_ids,
						'nonce' => wp_create_nonce( 'addonify-wishlist' ),
					) 
				) 
			);
		}		
	}
}


if ( ! function_exists( 'addonify_wishlist_render_modal_wrapper' ) ) {

	function addonify_wishlist_render_modal_wrapper() {

		$css_class = ( (int) addonify_wishlist_get_option( 'require_login' ) && ! is_user_logged_in() ) ? 'require-login' : '';

		addonify_wishlist_get_template( 
			'addonify-wishlist-modal-wrapper.php', 
			apply_filters( 
				'addonify_wishlist/modal_wrapper_args', 
				array(
					'css_classes' => $css_class,
				) 
			) 
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_render_sidebar_toggle_button' ) ) {

	function addonify_wishlist_render_sidebar_toggle_button() {

		if ( (int) addonify_wishlist_get_option( 'show_sidebar' ) !== 1 ) {
			return;
		}

		$alignment = 'addonify-align-' . addonify_wishlist_get_option( 'sidebar_position' );

		$css_classes = array( $alignment );

		$css_classes[] = ( addonify_wishlist_get_wishlist_items_count() < 1 ) ? 'hidden' : '';

		addonify_wishlist_get_template( 
            'addonify-wishlist-sidebar-toggle-button.php', 
            apply_filters( 
				'addonify_wishlist/sidebar_toggle_button_args', 
				array(
					'css_classes' => implode( ' ', $css_classes ),
					'label' => addonify_wishlist_get_option( 'sidebar_btn_label' ),
					'show_icon' => (int) addonify_wishlist_get_option( 'sidebar_show_icon' ),
					'icon' => addonify_wishlist_get_option( 'sidebar_btn_icon' ),
				) 
			) 
        );
	}
}


if ( ! function_exists( 'addonify_wishlist_render_sidebar' ) ) {

	function addonify_wishlist_render_sidebar() {

		if ( get_the_ID() === (int) addonify_wishlist_get_option( 'wishlist_page' ) ) {
			// do not show sidebar in wishlist page.
			return;
		}

		if ( (int) addonify_wishlist_get_option( 'show_sidebar' ) != 1 ) {
			
			return;
		}

		addonify_wishlist_get_template( 
            'addonify-wishlist-sidebar.php', 
            apply_filters( 
				'addonify_wishlist/sidebar_args', 
				array(
					'total_items' => addonify_wishlist_get_wishlist_items_count(),
					'css_class' => 'addonify-align-' . addonify_wishlist_get_option( 'sidebar_position' ),
					'title' => addonify_wishlist_get_option( 'sidebar_title' ),
					'wishlist_url' => ( addonify_wishlist_get_option( 'wishlist_page' ) ) ? get_permalink( addonify_wishlist_get_option( 'wishlist_page' ) ) : '',
					'alignment' => 'addonify-align-' . addonify_wishlist_get_option( 'sidebar_position' ),
					'view_wishlist_page_button_label' => addonify_wishlist_get_option( 'view_wishlist_page_button_label' )
				) 
			) 
        );
	}
}



if ( ! function_exists( 'addonify_wishlist_render_sidebar_loop' ) ) {

	function addonify_wishlist_render_sidebar_loop() {

		$wishlist_product_ids = array();

		if ( addonify_wishlist_get_wishlist_items_count() > 0 ) {

			$wishlist_product_ids = array_keys( addonify_wishlist_get_wishlist_items() );
		}

		addonify_wishlist_get_template( 
			'addonify-wishlist-sidebar-loop.php', 
			apply_filters( 
				'addonify_wishlist/sidebar_loop_args', 
				array(
					'wishlist_product_ids' => $wishlist_product_ids
				) 
			) 
		);
	}
}



if ( ! function_exists( 'addonify_wishlist_render_single_wishlist_button' ) ) {

	function addonify_wishlist_render_single_wishlist_button() {

		addonify_wishlist_get_template( 
			'addonify-wishlist-sidebar-loop.php', 
			apply_filters( 
				'addonify_wishlist/sidebar_loop_args', 
				array(
					'wishlist_product_ids' => $wishlist_product_ids
				) 
			) 
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_render_sidebar_product' ) ) {

	function addonify_wishlist_render_sidebar_product( $product_id ) {

		$product = wc_get_product( $product_id );

		ob_start();
		?>
		<li class="addonify-wishlist-sidebar-item" data-product_row="addonify-wishlist-sidebar-product-row-<?php echo esc_attr( $product_id ); ?>">
			<div class="adfy-wishlist-row">
				<div class="adfy-wishlist-col image-column">
					<div class="adfy-wishlist-woo-image">
						<?php
						$product_post_thumbnail_id = $product->get_image_id();
						if ( $product->get_image() ) {
							?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo wp_kses_post( $product->get_image( array(72, 72) ) ); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="adfy-wishlist-col title-price-column">
					<div class="adfy-wishlist-woo-title">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo $product->get_title(); ?>
						</a>
					</div>
					<div class="adfy-wishlist-woo-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				</div>
			</div>

			<div class="adfy-wishlist-woo-action">
				<div class="adfy-wishlist-row">
					<div class="adfy-wishlist-col cart-column">
						<?php
						if ( in_array( $product->get_type(), array( 'simple', 'external' ) ) ) {

							if ( $product->is_in_stock() ) {

								if ( (int) addonify_wishlist_get_option( 'ajaxify_add_to_cart' ) == 1 ) {
									?>
									<button 
										class="button adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-ajax-add-to-cart addonify-wishlist-sidebar-button" 
										name="addonify_wishlist_add_to_cart" 
										value="<?php echo esc_attr( $product_id ); ?>">
											<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</button>
									<?php
								} else {
									?>
									<button 
										type="submit" 
										class="button adfy-wishlist-btn addonify-wishlist-add-to-cart"
										name="addonify-add-to-cart-from-wishlist"
										value="<?php echo esc_attr( $product->get_id() ); ?>"
									>
										<?php echo esc_html( $product->add_to_cart_text() ); ?>
									</button>
									<?php
								}
							} else {
								$add_to_cart_button_classes = array(
									'button',
									'adfy-wishlist-btn addonify-wishlist-add-to-cart',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : ''
									
								);

								$add_to_cart_button_attributes = array(
									'data-product_id'  => $product->get_id(),
									'data-product_sku' => $product->get_sku(),
									'aria-label'       => $product->add_to_cart_description(),
									'rel'              => 'nofollow',
								);
								?>
								<a 
									href="<?php echo esc_url( $product->get_permalink() ) ?>" 
									class="<?php echo esc_attr( implode( ' ', $add_to_cart_button_classes ) ); ?>" 
									<?php echo wc_implode_html_attributes( $add_to_cart_button_attributes ); ?>
								>
									<?php echo esc_html( $product->add_to_cart_text() ); ?>
								</a>
								<?php
							}
						} else {
							$add_to_cart_button_classes = array(
								'button',
								'adfy-wishlist-btn addonify-wishlist-add-to-cart',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : ''
								
							);

							$add_to_cart_button_attributes = array(
								'data-product_id'  => $product->get_id(),
								'data-product_sku' => $product->get_sku(),
								'aria-label'       => $product->add_to_cart_description(),
								'rel'              => 'nofollow',
							);
							?>
							<a 
								href="<?php echo esc_url( $product->add_to_cart_url() ) ?>" 
								class="<?php echo esc_attr( implode( ' ', $add_to_cart_button_classes ) ); ?>" 
								<?php echo wc_implode_html_attributes( $add_to_cart_button_attributes ); ?>
							>
								<?php echo esc_html( $product->add_to_cart_text() ); ?>
							</a>
							<?php
						}	
						?>
					</div>
					<div class="adfy-wishlist-col remove-item-column">
						<?php 
						if ( (int) addonify_wishlist_get_option( 'ajaxify_remove_from_wishlist_button' ) == 1 ) {
							?>
							<button
								class="adfy-wishlist-btn adfy-wishlist-remove-btn addonify-wishlist-icon addonify-wishlist-ajax-remove-from-wishlist addonify-wishlist-sidebar-button"
								name="addonify_wishlist_remove" 
								value="<?php echo esc_attr( $product->get_id() ); ?>"
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
							<?php
						} else {
							?>
							<button 
								type="submit"
								class="adfy-wishlist-btn adfy-wishlist-remove-btn addonify-wishlist-icon"
								name="addonify-remove-from-wishlist"
								value="<?php echo esc_attr( $product->get_id() ); ?>"
							>
								<i class="adfy-wishlist-icon trash-2"></i>
							</button>
							<?php
						}
						?>						
					</div>
				</div>
			</div>
		</li>
		<?php
		return ob_get_clean();
	}
}


if ( ! function_exists( 'addonify_wishlist_render_popup_wishlist_link_button' ) ) {

	function addonify_wishlist_render_popup_wishlist_link_button() {
		// If login is not required, display link button to wishlist page.
		if (
			(int) addonify_wishlist_get_option( 'require_login' ) === 1 &&
			! is_user_logged_in()
		) {

			return;			
		}

		$wishlist_page_url = addonify_wishlist_get_option( 'wishlist_page' ) ? get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) : '';

		$view_wishlist_button_label = addonify_wishlist_get_option( 'view_wishlist_btn_text' );

		addonify_wishlist_get_template( 
			'addonify-popup-wishlist-link-button.php', 
			apply_filters( 
				'addonify_wishlist/popup_wishlist_link_button_args', 
				array(
					'wishlist_page_url' => $wishlist_page_url,
					'view_wishlist_button_label' => $view_wishlist_button_label,
				) 
			) 
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_render_popup_login_link_button' ) ) {

	function addonify_wishlist_render_popup_login_link_button() {
		// If login is not required, display link button to wishlist page.
		if (
			(int) addonify_wishlist_get_option( 'require_login' ) === 0 ||
			is_user_logged_in()
		) {

			return;			
		}

		global $wp;

		$redirect_url = add_query_arg(
			'addonify_wishlist_redirect',
			home_url( $wp->request ),
			( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url()
		);

		addonify_wishlist_get_template( 
			'addonify-popup-wishlist-link-button.php', 
			apply_filters( 
				'addonify_wishlist/popup_wishlist_link_button_args', 
				array(
					'redirect_url' => $redirect_url,
					'login_button_label' => apply_filters( 'addonify_wishlist/popup_login_button_label', __( 'Login', 'addonify-wishlist' ) ),
				) 
			) 
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_render_popup_close_button' ) ) {

	function addonify_wishlist_render_popup_close_button() {

		addonify_wishlist_get_template( 
			'addonify-popup-close-button.php', 
			apply_filters( 
				'addonify_wishlist/popup_close_button_args', 
				array(
					'close_button_label' => apply_filters( 'addonify_wishlist/popup_close_button_label', __( 'Close', 'addonify-wishlist' ) ),
				) 
			) 
		);
	}
}