<?php
/**
 * The file that defines the template functions.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

if ( ! function_exists( 'addonify_wishlist_locate_template' ) ) {
	/**
	 * Locates template.
	 *
	 * @param string $template_name Template name.
	 * @param string $template_path Template path.
	 * @param string $default_path Default path.
	 */
	function addonify_wishlist_locate_template( $template_name, $template_path = '', $default_path = '' ) {

		// Set template location for theme.
		if ( empty( $template_path ) ) :
			$template_path = 'addonify/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/'; // Path to the template folder.
		endif;

		// Search template file in theme folder.
		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name,
			)
		);

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'addonify_wishlist_locate_template', $template, $template_name, $template_path, $default_path );
	}
}


if ( ! function_exists( 'addonify_wishlist_get_template' ) ) {
	/**
	 * Return template content if found.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args Arguments.
	 * @param string $tempate_path Template path.
	 * @param string $default_path Default path.
	 */
	function addonify_wishlist_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args ); //phpcs:ignore
		endif;

		$template_file = addonify_wishlist_locate_template( $template_name, $tempate_path, $default_path );

		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' ); //phpcs:ignore
			return;
		endif;

		require $template_file;
	}
}

if ( ! function_exists( 'addonify_wishlist_render_add_to_wishlist_button' ) ) {
	/**
	 * Render add to wishlist button.
	 *
	 * @param object|false $product_     Product object.
	 * @param array        $classes      Classes to be added to button.
	 * @param bool|string  $button_label Custom Button label.
	 */
	function addonify_wishlist_render_add_to_wishlist_button( $product_ = false, $classes = array(), $button_label = false ) {

		// Return if button label and icon is not set.
		if (
			! addonify_wishlist_get_option( 'btn_label' ) &&
			! (int) addonify_wishlist_get_option( 'show_icon' ) === 1
		) {
			return;
		}
		if ( ! $product_ ) {
			global $product;
		} else {
			$product = $product_;
		}

		$add_to_wishlist_button_args = array(
			'product_id'            => $product->get_id(),
			'button_label'          => $button_label ? $button_label : addonify_wishlist_get_option( 'btn_label' ),
			'preserve_button_label' => $button_label,
			'button_classes'        => array( 'button', 'adfy-wishlist-btn', 'addonify-add-to-wishlist-btn' ),
			'product_name'          => $product->get_title(),
			'display_icon'          => (bool) addonify_wishlist_get_option( 'show_icon' ),
			'icon'                  => 'heart-o-style-one',
			'redirect_to_login'     => false,
			'login_url'             => '',
			'require_login'         => false,
			'display_popup_notice'  => false,
		);

		if ( $classes ) {
			$add_to_wishlist_button_args['button_classes'] = array_merge( $add_to_wishlist_button_args['button_classes'], $classes );
		}

		if ( is_user_logged_in() ) {
			global $addonify_wishlist;

			$parent_wishlist_id = $addonify_wishlist->get_wishlist_id_from_product_id( $product->get_id() );
			if ( $parent_wishlist_id ) {
				$add_to_wishlist_button_args['parent_wishlist_id'] = $parent_wishlist_id;
			}
		}

		// Add class, 'after-add-to-cart', if button is to be displayed after add to cart button.
		if ( addonify_wishlist_get_option( 'btn_position' ) === 'after_add_to_cart' ) {

			$add_to_wishlist_button_args['button_classes'][] = 'after-add-to-cart';
		}

		// Add class, 'before-add-to-cart', if button is to be displayed before add to cart button.
		if ( addonify_wishlist_get_option( 'btn_position' ) === 'before_add_to_cart' ) {

			$add_to_wishlist_button_args['button_classes'][] = 'before-add-to-cart';
		}

		// Add class, 'show', if there is button label.
		if ( addonify_wishlist_get_option( 'btn_label' ) ) {

			$add_to_wishlist_button_args['button_classes'][] = 'show-label';
		}

		$in_wishlist = addonify_wishlist_is_product_in_wishlist( $product->get_id() );

		$add_to_wishlist_button_args['in_wishlist'] = $in_wishlist;

		// If product is already in the wishlist, add a class, set button label and set button icon.
		if ( $in_wishlist ) {

			$add_to_wishlist_button_args['button_classes'][] = 'added-to-wishlist';

			$add_to_wishlist_button_args['button_label'] = addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' );

			$add_to_wishlist_button_args['icon'] = 'heart-style-one';

			if ( (int) addonify_wishlist_get_option( 'show_icon' ) === 1 ) {

				$add_to_wishlist_button_args['button_classes'][] = 'show-icon xxxxx-heart-xxxxx';
			}
		}

		// Add custom CSS class to the button if set.
		if ( addonify_wishlist_get_option( 'btn_custom_class' ) ) {

			$add_to_wishlist_button_args['button_classes'][] = addonify_wishlist_get_option( 'btn_custom_class' );
		}

		// Set button properties check the need of user login.
		if (
			(int) addonify_wishlist_get_option( 'require_login' ) === 1 &&
			! is_user_logged_in()
		) {

			$add_to_wishlist_button_args['require_login'] = true;

			if ( addonify_wishlist_get_option( 'if_not_login_action' ) === 'show_popup' ) {

				$add_to_wishlist_button_args['button_classes'][] = 'addonify-wishlist-login-popup-enabled';
			} else {

				$add_to_wishlist_button_args['login_url'] = ( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url();
			}
		} else {
			if (
				( addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) !== 'redirect_to_wishlist_page' ) ||
				! is_user_logged_in()
			) {

				$add_to_wishlist_button_args['display_popup_notice'] = true;

				$add_to_wishlist_button_args['button_classes'][] = 'addonify-wishlist-ajax-add-to-wishlist';
			}
		}

		addonify_wishlist_get_template(
			'addonify-add-to-wishlist-button.php',
			apply_filters(
				'addonify_wishlist_add_to_wishlist_button_args',
				$add_to_wishlist_button_args
			)
		);
	}
}

if ( ! function_exists( 'addonify_wishlist_render_wishlist_content' ) ) {
	/**
	 * Render wishlist content.
	 */
	function addonify_wishlist_render_wishlist_content() {

		$wishlist_product_ids = array();

		global $addonify_wishlist;
		if ( $addonify_wishlist->check_wishlist_table_exists() ) {
			if ( addonify_wishlist_get_wishlist_items_count() > 0 ) {
				$wishlists = addonify_wishlist_get_wishlist_items();
				foreach ( $wishlists as $data ) {
					if ( array_key_exists( 'product_ids', $data ) ) {
						$wishlist_product_ids = array_merge( $wishlist_product_ids, $data['product_ids'] );
					}
				}
			}
		} else {
			if ( addonify_wishlist_get_wishlist_items_count() > 0 ) {
				$wishlist_product_ids = addonify_wishlist_get_wishlist_items();
			}
		}

		addonify_wishlist_get_template(
			'addonify-wishlist-shortcode-contents.php',
			apply_filters(
				'addonify_wishlist_shortcode_contents_args',
				array(
					'wishlist_product_ids' => $wishlist_product_ids,
					'nonce'                => wp_create_nonce( 'addonify-wishlist' ),
				)
			)
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_render_modal_wrapper' ) ) {
	/**
	 * Render modal wrapper.
	 */
	function addonify_wishlist_render_modal_wrapper() {

		$css_class = ( (int) addonify_wishlist_get_option( 'require_login' ) && ! is_user_logged_in() ) ? 'require-login' : '';

		addonify_wishlist_get_template(
			'addonify-wishlist-modal-wrapper.php',
			apply_filters(
				'addonify_wishlist_modal_wrapper_args',
				array(
					'css_classes' => $css_class,
				)
			)
		);
	}
}


if ( ! function_exists( 'addonify_wishlist_render_sidebar_toggle_button' ) ) {
	/**
	 * Render sidebar toggle button.
	 *
	 * @param array $product_ids Product ids.
	 */
	function addonify_wishlist_render_sidebar_toggle_button( $product_ids = array() ) {

		if ( (int) addonify_wishlist_get_option( 'show_sidebar' ) !== 1 ) {
			return;
		}

		if ( get_the_ID() === (int) addonify_wishlist_get_option( 'wishlist_page' ) ) {
			// do not show sidebar in wishlist page.
			return;
		}

		$alignment = 'addonify-align-' . addonify_wishlist_get_option( 'sidebar_position' );

		$css_classes = array( $alignment );

		$total_items = addonify_wishlist_get_wishlist_items_count();

		$css_classes[] = ( $total_items < 1 && empty( $product_ids ) ) ? 'hidden' : '';

		addonify_wishlist_get_template(
			'addonify-wishlist-sidebar-toggle-button.php',
			apply_filters(
				'addonify_wishlist_sidebar_toggle_button_args',
				array(
					'css_classes' => implode( ' ', $css_classes ),
					'label'       => addonify_wishlist_get_option( 'sidebar_btn_label' ),
					'show_icon'   => (int) addonify_wishlist_get_option( 'sidebar_show_icon' ),
					'icon'        => addonify_wishlist_get_option( 'sidebar_btn_icon' ),
				)
			)
		);
	}
}

if ( ! function_exists( 'addonify_wishlist_render_sidebar' ) ) {
	/**
	 * Render sidebar.
	 *
	 * @param array $product_ids Product ids.
	 */
	function addonify_wishlist_render_sidebar( $product_ids = array() ) {

		if ( get_the_ID() === (int) addonify_wishlist_get_option( 'wishlist_page' ) ) {
			// do not show sidebar in wishlist page.
			return;
		}

		if ( (int) addonify_wishlist_get_option( 'show_sidebar' ) !== 1 ) {
			return;
		}

		$total_items = addonify_wishlist_get_wishlist_items_count();

		addonify_wishlist_get_template(
			'addonify-wishlist-sidebar.php',
			apply_filters(
				'addonify_wishlist_sidebar_args',
				array(
					'total_items'                     => $total_items,
					'css_class'                       => 'addonify-align-' . addonify_wishlist_get_option( 'sidebar_position' ),
					'title'                           => addonify_wishlist_get_option( 'sidebar_title' ),
					'wishlist_url'                    => ( addonify_wishlist_get_option( 'wishlist_page' ) ) ? get_permalink( addonify_wishlist_get_option( 'wishlist_page' ) ) : '',
					'alignment'                       => 'addonify-align-' . addonify_wishlist_get_option( 'sidebar_position' ),
					'view_wishlist_page_button_label' => addonify_wishlist_get_option( 'view_wishlist_page_button_label' ),
					'product_ids'                     => $product_ids,
				)
			)
		);
	}
}

if ( ! function_exists( 'addonify_wishlist_render_sidebar_loop' ) ) {
	/**
	 * Render sidebar loop.
	 *
	 * @param array $wishlist_product_ids Product ids.
	 */
	function addonify_wishlist_render_sidebar_loop( $wishlist_product_ids = array() ) {
		$guest = false;
		if ( is_user_logged_in() ) {
			$wishlist_product_ids = array();

			global $addonify_wishlist;
			if ( $addonify_wishlist->check_wishlist_table_exists() ) {
				if ( addonify_wishlist_get_wishlist_items_count() > 0 ) {
					$wishlists = addonify_wishlist_get_wishlist_items();
					foreach ( $wishlists as $data ) {
						if ( array_key_exists( 'product_ids', $data ) ) {
							$wishlist_product_ids = array_merge( $wishlist_product_ids, $data['product_ids'] );
						}
					}
				}
			} else {
				if ( addonify_wishlist_get_wishlist_items_count() > 0 ) {
					$wishlist_product_ids = addonify_wishlist_get_wishlist_items();
				}
			}
		} else {
			$guest = true;
		}

		addonify_wishlist_get_template(
			'addonify-wishlist-sidebar-loop.php',
			apply_filters(
				'addonify_wishlist_sidebar_loop_args',
				array(
					'wishlist_product_ids' => $wishlist_product_ids,
					'guest'                => $guest,
				)
			)
		);
	}
}

if ( ! function_exists( 'addonify_wishlist_render_single_wishlist_button' ) ) {
	/**
	 * Render single wishlist button.
	 */
	function addonify_wishlist_render_single_wishlist_button() {

		addonify_wishlist_get_template(
			'addonify-wishlist-sidebar-loop.php',
			apply_filters(
				'addonify_wishlist_sidebar_loop_args',
				array(
					'wishlist_product_ids' => isset( $wishlist_product_ids ) ? $wishlist_product_ids : array(),
				)
			)
		);
	}
}

if ( ! function_exists( 'addonify_wishlist_render_sidebar_product' ) ) {
	/**
	 * Render single wishlist button.
	 *
	 * @param string $product_id Product id.
	 * @param bool   $guest False if user is logged in, true otherwise.
	 */
	function addonify_wishlist_render_sidebar_product( $product_id, $guest = false ) {

		$product            = wc_get_product( $product_id );
		$product_avaibility = addonify_wishlist_get_product_avaibility( $product );
		$wishlist_attr      = '';

		if ( is_user_logged_in() ) {
			global $addonify_wishlist;

			$parent_wishlist_id = $addonify_wishlist->get_wishlist_id_from_product_id( $product_id );
			if ( $parent_wishlist_id ) {
				$wishlist_attr = 'data-wishlist_id=' . $parent_wishlist_id;
			}
		}

		ob_start();
		?>
		<li
			class="addonify-wishlist-sidebar-item"
			data-product_row="addonify-wishlist-sidebar-product-row-<?php echo esc_attr( $product_id ); ?>"
			data-product_name="<?php echo esc_attr( $product->get_name() ); ?>"
		>
			<div class="adfy-wishlist-row">
				<div class="adfy-wishlist-col image-column">
					<div class="adfy-wishlist-woo-image">
						<?php
						$product_post_thumbnail_id = $product->get_image_id();
						if ( $product->get_image() ) {
							?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo wp_kses_post( $product->get_image( array( 72, 72 ) ) ); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="adfy-wishlist-col title-price-column">
					<div class="adfy-wishlist-woo-title">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
							<?php echo wp_kses_post( $product->get_title() ); ?>
						</a>
					</div>
					<div class="adfy-wishlist-woo-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
					<?php
					if ( $product_avaibility ) {
						?>
						<div class="adfy-wishlist-woo-stock">
							<span class="stock-label <?php echo esc_attr( $product_avaibility['class'] ); ?>">
								<?php echo esc_html( $product_avaibility['avaibility'] ); ?>
							</span>
						</div>
						<?php
					}
					?>
				</div>
			</div>

			<div class="adfy-wishlist-woo-action">
				<div class="adfy-wishlist-row">
					<div class="adfy-wishlist-col cart-column">
						<?php
						echo do_shortcode( '[add_to_cart id=' . $product->get_id() . ' show_price=false style="" class="adfy-wishlist-clear-shortcode-button-style adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-sidebar-button"]' );
						?>
					</div>
					<div class="adfy-wishlist-col remove-item-column">
						<?php
						$remove_from_wishlist_class = $guest ? ' addonify-wishlist-remove-from-wishlist ' : ' adfy-wishlist-remove-btn addonify-wishlist-ajax-remove-from-wishlist ';
						?>
						<button
							class="adfy-wishlist-btn adfy-wishlist-remove-btn addonify-wishlist-icon <?php echo esc_attr( $remove_from_wishlist_class ); ?> addonify-wishlist-sidebar-button"
							name="addonify_wishlist_remove"
							data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
							value="<?php echo esc_attr( $product->get_id() ); ?>"
							<?php echo esc_attr( $wishlist_attr ); ?>
						>
							<i class="adfy-wishlist-icon trash-2"></i>
						</button>
					</div>
				</div>
			</div>
		</li>
		<?php
		return ob_get_clean();
	}
}


if ( ! function_exists( 'addonify_wishlist_render_popup_wishlist_link_button' ) ) {
	/**
	 * Render popup wishlist link button.
	 */
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
				'addonify_wishlist_popup_wishlist_link_button_args',
				array(
					'wishlist_page_url'          => $wishlist_page_url,
					'view_wishlist_button_label' => $view_wishlist_button_label,
				)
			)
		);
	}
}

if ( ! function_exists( 'addonify_wishlist_render_popup_login_link_button' ) ) {
	/**
	 * Render popup link button.
	 */
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
			'addonify-popup-login-link-button.php',
			apply_filters(
				'addonify_wishlist_popup_wishlist_link_button_args',
				array(
					'redirect_url'       => $redirect_url,
					'login_button_label' => apply_filters( 'addonify_wishlist_popup_login_button_label', addonify_wishlist_get_option( 'login_btn_label' ) ),
				)
			)
		);
	}
}

