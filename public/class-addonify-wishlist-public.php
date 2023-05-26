<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and other required stuff.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public
 * @author     Adodnify <contact@addonify.com>
 */
class Addonify_Wishlist_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Addonify Wishlist object.
	 *
	 * @var object $wishlist
	 */
	private $wishlist;

	/**
	 * Public wishlist.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var string $default_wishlist
	 */
	private $default_wishlist = 'Default Wishlist';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		global $addonify_wishlist;
		$this->wishlist = $addonify_wishlist;
	}

	/**
	 * Public init.
	 */
	public function public_init() {

		if (
			! class_exists( 'WooCommerce' ) ||
			(int) addonify_wishlist_get_option( 'enable_wishlist' ) !== 1
		) {
			return;
		}

		$this->maybe_migrate_metadata_to_table();

		$this->maybe_create_default_wishlist();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		$this->add_actions_and_filters();

		$this->register_ajax_actions();
	}

	/**
	 * Register all actions required.
	 */
	public function add_actions_and_filters() {

		if ( addonify_wishlist_get_option( 'btn_position' ) === 'after_add_to_cart' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_add_to_wishlist_button' ), 15 );
		}

		if ( addonify_wishlist_get_option( 'btn_position' ) === 'before_add_to_cart' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_add_to_wishlist_button' ), 5 );
		}

		add_action( 'woocommerce_add_to_cart', array( $this, 'remove_item_from_wishlist' ) );

		// Displaying add to wishlist button in product single before cart form.
		add_action(
			'woocommerce_before_add_to_cart_form',
			array( $this, 'render_add_to_wishlist_button_before_single_cart_form' )
		);
		// Displaying add to wishlist button in product single after cart form.
		add_action(
			'woocommerce_after_add_to_cart_form',
			array( $this, 'render_add_to_wishlist_button_after_single_cart_form' )
		);
		// Displaying add to wishlist button in product single after cart quantity field.
		add_action(
			'woocommerce_after_add_to_cart_quantity',
			array( $this, 'render_add_to_wishlist_button_after_single_add_to_cart_quantity' )
		);
		// Displaying add to wishlist button in product single before add to cart button.
		add_action(
			'woocommerce_before_add_to_cart_button',
			array( $this, 'render_add_to_wishlist_button_before_single_add_to_cart_button' )
		);
		// Displaying add to wishlist button in product single after add to cart button.
		add_action(
			'woocommerce_after_add_to_cart_button',
			array( $this, 'render_add_to_wishlist_button_after_single_add_to_cart_button' )
		);

		add_action( 'wp', array( $this, 'init_actions' ) );

		add_action( 'wp_footer', array( $this, 'wishlist_modal_wrapper' ) );
		add_action( 'wp_footer', array( $this, 'wishlist_sidebar_template' ) );

		add_action( 'addonify_wishlist_before_wishlist_form_table', array( $this, 'ajaxify_wishlist_form' ) );

		add_filter( 'woocommerce_login_redirect', array( $this, 'myaccount_login' ) );

		add_shortcode( 'addonify_wishlist', array( $this, 'get_shortcode_contents' ) );

		add_shortcode( 'addonify_wishlist_button', array( $this, 'get_wishlist_button_shortcode' ) );

		if ( addonify_wishlist_get_option( 'enable_save_for_later' ) ) {
			if ( 'after_product_name' === addonify_wishlist_get_option( 'save_for_later_btn_position' ) ) {
				add_action( 'woocommerce_after_cart_item_name', array( $this, 'render_add_to_wishlist_button_in_cart_page_items_after_name' ), 11, 2 );
			} else {
				add_filter( 'woocommerce_cart_item_subtotal', array( $this, 'render_add_to_wishlist_button_in_cart_page_items_after_subtotal' ), 11, 3 );
			}
		}

		add_filter(
			'woocommerce_add_to_cart_fragments',
			function ( $arr ) {
				$arr['addonify_wishlist_count'] = addonify_wishlist_get_wishlist_items_count();
				return $arr;
			}
		);

		add_filter(
			'woocommerce_loop_add_to_cart_args',
			array( $this, 'add_to_cart_args' ),
			15,
			2
		);
	}

	/**
	 * Register ajax call functions.
	 */
	private function register_ajax_actions() {

		add_action( 'wp_ajax_addonify_add_to_wishlist', array( $this, 'ajax_add_to_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_add_to_wishlist', array( $this, 'ajax_add_to_wishlist_handler' ) );

		add_action( 'wp_ajax_addonify_add_to_wishlist_sidebar_added_content', array( $this, 'addonify_add_to_wishlist_sidebar_added_content' ) );
		add_action( 'wp_ajax_nopriv_addonify_add_to_wishlist_sidebar_added_content', array( $this, 'addonify_add_to_wishlist_sidebar_added_content' ) );

		add_action( 'wp_ajax_addonify_add_to_cart_from_wishlist', array( $this, 'ajax_add_to_cart_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_add_to_cart_from_wishlist', array( $this, 'ajax_add_to_cart_handler' ) );

		add_action( 'wp_ajax_addonify_remove_from_wishlist', array( $this, 'ajax_remove_from_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_remove_from_wishlist', array( $this, 'ajax_remove_from_wishlist_handler' ) );

		add_action( 'wp_ajax_addonify_empty_wishlist', array( $this, 'ajax_empty_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_empty_wishlist', array( $this, 'ajax_empty_wishlist_handler' ) );

		add_action( 'wp_ajax_addonify_get_wishlist_table', array( $this, 'addonify_get_wishlist_table' ) );
		add_action( 'wp_ajax_nopriv_addonify_get_wishlist_table', array( $this, 'addonify_get_wishlist_table' ) );

		add_action( 'wp_ajax_addonify_get_wishlist_sidebar', array( $this, 'addonify_get_wishlist_sidebar' ) );
		add_action( 'wp_ajax_nopriv_addonify_get_wishlist_sidebar', array( $this, 'addonify_get_wishlist_sidebar' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			'perfect-scrollbar',
			plugin_dir_url( __FILE__ ) . 'assets/build/css/conditional/perfect-scrollbar.css',
			array(),
			$this->version,
			'all'
		);

		wp_enqueue_style(
			'addonify-wishlist-icon',
			plugin_dir_url( __FILE__ ) . 'assets/fonts/addonify-wishlist-icon.min.css',
			array(),
			$this->version,
			'all'
		);

		if ( is_rtl() ) {
			wp_enqueue_style(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'assets/build/css/addonify-wishlist-public-rtl.css',
				array(),
				$this->version,
				'all'
			);
		} else {
			wp_enqueue_style(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'assets/build/css/addonify-wishlist-public.css',
				array(),
				$this->version,
				'all'
			);
		}

		$css  = ':root {';
		$css .= '--adfy_wishlist_sidebar_btn_position_offset: ' . addonify_wishlist_get_option( 'sidebar_btn_position_offset' ) . ';';
		$css .= '}';
		wp_add_inline_style( $this->plugin_name, $css );

		$inline_css = $this->dynamic_css();

		$custom_css = addonify_wishlist_get_option( 'custom_css' );

		if ( $custom_css ) {
			$inline_css .= $custom_css;
		}

		$inline_css = $this->minify_css( $inline_css );

		wp_add_inline_style(
			$this->plugin_name,
			$inline_css
		);
	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			'perfect-scrollbar',
			plugin_dir_url( __FILE__ ) . 'assets/build/js/conditional/perfect-scrollbar.min.js',
			null,
			$this->version,
			true
		);

		wp_enqueue_script(
			$this->plugin_name . '-global',
			plugin_dir_url( __FILE__ ) . 'assets/build/js/addonify-wishlist-global-public.min.js',
			null,
			$this->version,
			true
		);

		$login_url = ( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url();

		if ( ! is_user_logged_in() ) {
			$inline_script = "
			function addonify_wishlist_get_wishlist_products() {
				let hostname = addonifyWishlistJSObject.thisSiteUrl;
				let localDeadline = localStorage.getItem('{$this->plugin_name}' + '_' + hostname + '_product_ids_deadline')
				if (null !== localDeadline) {
					const d = new Date();
					if (d.getTime() < parseInt(localDeadline)) {
						return jsonToArray(parseJson(localStorage.getItem('{$this->plugin_name}' + '_' + hostname + '_product_ids')))
					} else {
						localStorage.removeItem('{$this->plugin_name}' + '_' + hostname + '_product_ids')
						localStorage.removeItem('{$this->plugin_name}' + '_' + hostname + '_product_ids_deadline');
					}
				}
				return [];
			}
			function jsonToArray(json) {
				if (json !== null && typeof json === 'object') {
					let result = new Array;
					let keys = Object.keys(json);
					if (keys.length > 0) {
						keys.forEach(function (key) {
							result[key] = json[key];
						});
					}
					return result;
				} else {
					return false;
				}
			}
			function parseJson(json_str) {
				let json_val
				try {
					json_val = JSON.parse(json_str)
				} catch (e) {
					return false;
				}
				return json_val
			}
			";

			// For making these functions globally available on page.
			wp_add_inline_script(
				$this->plugin_name,
				$inline_script
			);

			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'assets/build/js/conditional/addonify-wishlist-public-guest.min.js',
				array( 'jquery' ),
				$this->version,
				true
			);

		} else {
			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'assets/build/js/conditional/addonify-wishlist-public.min.js',
				array( 'jquery' ),
				$this->version,
				true
			);
		}

		wp_localize_script(
			$this->plugin_name,
			'addonifyWishlistJSObject',
			array(
				'ajax_url'                              => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'                                 => wp_create_nonce( $this->plugin_name ),
				'addToWishlistAction'                   => 'addonify_add_to_wishlist',
				'emptyWishlistAction'                   => 'addonify_empty_wishlist',
				'addToWishlistActionSideBar'            => 'addonify_add_to_wishlist_sidebar_added_content',
				'removeFromWishlistAfterAddedToCart'    => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ),
				'removeAlreadyAddedProductFromWishlist' => (bool) addonify_wishlist_get_option( 'remove_already_added_product_from_wishlist' ),
				'loginMessage'                          => addonify_wishlist_get_option( 'login_required_message' ),
				'addedToWishlistText'                   => addonify_wishlist_get_option( 'btn_label_when_added_to_wishlist' ),
				'initialAddToWishlistButtonLabel'       => addonify_wishlist_get_option( 'btn_label' ),
				'popupAddedToWishlistText'              => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
				'popupAlreadyInWishlistText'            => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
				'emptyWishlistText'                     => addonify_wishlist_get_option( 'empty_wishlist_label' ),
				'sidebarEmptyWishlistText'              => addonify_wishlist_get_option( 'sidebar_empty_wishlist_label' ),
				'removedFromWishlistText'               => addonify_wishlist_get_option( 'product_removed_from_wishlist_text' ),
				'emptiedWishlistText'                   => addonify_wishlist_get_option( 'wishlist_emptied_text' ),
				'undoActionPrelabelText'                => addonify_wishlist_get_option( 'undo_action_prelabel_text' ),
				'undoActionLabel'                       => addonify_wishlist_get_option( 'undo_action_label' ),
				'undoNoticeTimeout'                     => addonify_wishlist_get_option( 'undo_notice_timeout' ),
				'addedtoCartNoticeText'                 => addonify_wishlist_get_option( 'product_added_to_cart_notice_text' ),
				'isLoggedIn'                            => is_user_logged_in(),
				'addedToWishlistButtonLabel'            => addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' ),
				'addonify_get_wishlist_table'           => 'addonify_get_wishlist_table',
				'addonify_get_wishlist_sidebar'         => 'addonify_get_wishlist_sidebar',
				'thisSiteUrl'                           => get_bloginfo( 'url' ),
				'checkoutPageURL'                       => wc_get_checkout_url(),
				'afterAddToWishlistAction'              => addonify_wishlist_get_option( 'after_add_to_wishlist_action' ),
				'wishlistPageURL'                       => addonify_wishlist_get_wishlist_page_url(),
				'requireLogin'                          => (bool) addonify_wishlist_get_option( 'require_login' ),
				'loginURL'                              => $login_url,
				/* Translators: %1$s = An 'a' tag opening tag, %2$s = closing 'a' tag. */
				'loginRequiredMessage'                  => sprintf( __( 'Login required. Please %1$s click here %2$s to login.', 'addonify-wishlist' ), '<a href="' . $login_url . '">', '</a>' ),
				'ajaxAddToCart'                         => ( 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ),
				'pageLink'                              => get_permalink( (int) addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ) ),
				'pageLinkLabel'                         => addonify_wishlist_get_option( 'empty_wishlist_navigation_link_label' ),
				'showPageLinkLabel'                     => (bool) addonify_wishlist_get_option( 'show_empty_wishlist_navigation_link' ),
				'proExists'                             => class_exists( 'Addonify_Wishlist_Pro' ),
				'removeProductAfterAddedtoCart'         => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ),
			)
		);
	}

	/**
	 * Functions to run on init.
	 *
	 * @since    1.0.0
	 */
	public function init_actions() {

		global $wp, $adfy_wishlist;

		// Remove product from the wishlist.
		// Only works if removal is done on form submit.
		if (
			isset( $_GET['addonify-remove-from-wishlist'] ) &&
			! empty( $_GET['addonify-remove-from-wishlist'] )
		) {

			$product_id = (int) sanitize_text_field( wp_unslash( $_GET['addonify-remove-from-wishlist'] ) );

			$product = wc_get_product( $product_id );

			if ( isset( $_GET['wishlist'] ) && ! empty( $_GET['wishlist'] ) ) {
				$wishlist_id = (int) sanitize_text_field( wp_unslash( $_GET['wishlist'] ) );
			} else {
				$wishlist_id = $this->get_default_wishlist_id();
			}

			// Remove product from the wishlist.
			if ( $adfy_wishlist->remove_from_wishlist( $product_id, $wishlist_id ) ) {

				wc_add_notice( __( "{$product->get_title()} is removed from the wishlist.", 'addonify-wishlist' ), 'success' ); //phpcs:ignore
			} else {

				wc_add_notice( __( "{$product->get_title()} is not in the wishlist.", 'addonify-wishlist' ), 'error' ); //phpcs:ignore
			}

			wp_safe_redirect( home_url( $wp->request ) );
			exit;
		}

		// Remove product from the wishlist and add the product into cart.
		// Only works if add to cart is done on form submit.
		if (
			isset( $_POST['addonify-add-to-cart-from-wishlist'] ) &&
			! empty( $_POST['addonify-add-to-cart-from-wishlist'] )
		) {

			// If nonce is not valid, display error message and return.
			if (
				! isset( $_POST['nonce'] ) &&
				empty( $_POST['nonce'] ) &&
				! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), $this->plugin_name )
			) {
				wc_add_notice( __( 'Invalid security token.', 'addonify-wishlist' ), 'error' );
				return;
			}

			$product_id = (int) sanitize_text_field( wp_unslash( $_POST['addonify-add-to-cart-from-wishlist'] ) );

			$product = wc_get_product( $product_id );

			// Add product into the cart.
			if ( $this->add_to_cart( $product_id ) ) {

				$notice = __( "{$product->get_title()} is added to the cart.", 'addonify-wishlist' ); //phpcs:ignore

				// Remove product from the wishlist.
				if ( (int) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) === 1 ) {

					if ( $adfy_wishlist->remove_from_wishlist( $product_id ) ) {

						$notice .= '<br>' . __( "{$product->get_title()} has been removed from the wishlist.", 'addonify-wishlist' ); //phpcs:ignore
					} else {
						$notice .= '<br>' . __( "Error removing {$product->get_title()} from the wishlist.", 'addonify-wishlist' ); //phpcs:ignore
					}
				}

				wc_add_notice( $notice, 'success' );

				wp_safe_redirect( home_url( $wp->request ) );
				exit;
			} else {

				$notice = __( "Error adding {$product->get_title()} to the cart.", 'addonify-wishlist' ); //phpcs:ignore

				wc_add_notice( $notice, 'error' );
			}
		}

		// Add product to the wishlist.
		if (
			isset( $_GET['addonify-add-to-wishlist'] ) &&
			! empty( $_GET['addonify-add-to-wishlist'] )
		) {
			$product_id = (int) sanitize_text_field( wp_unslash( $_GET['addonify-add-to-wishlist'] ) );

			if ( isset( $_GET['wishlist'] ) && ! empty( $_GET['wishlist'] ) ) {
				$wishlist_id = (int) sanitize_text_field( wp_unslash( $_GET['wishlist'] ) );
			} else {
				$wishlist_id = $this->get_default_wishlist_id();
			}

			$product = wc_get_product( $product_id );

			if ( $adfy_wishlist->add_to_wishlist( $product_id, $wishlist_id ) ) {

				if (
					addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) === 'redirect_to_wishlist_page' &&
					(int) addonify_wishlist_get_option( 'wishlist_page' )
				) {

					$wishlist_page_id = (int) addonify_wishlist_get_option( 'wishlist_page' );
					wp_safe_redirect( get_permalink( $wishlist_page_id ) );
					exit;
				} else {

					$notice = '<a href="' . esc_url( get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) ) . '" class="button wc-forward" tabindex="1">' . esc_html__( 'View Wishlist', 'addonify-wishlist' ) . '</a>';

					$notice .= __( "{$product->get_title()} is added to the wishlist.", 'addonify-wishlist' ); //phpcs:ignore

					wc_add_notice( $notice, 'success' );

					wp_safe_redirect( home_url( $wp->request ) );
					exit;
				}
			} else {

				$notice = '<a href="' . esc_url( get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) ) . '" class="button wc-forward" tabindex="1">' . esc_html__( 'View Wishlist', 'addonify-wishlist' ) . '</a>';

				$notice .= __( "{$product->get_title()} is already in the wishlist.", 'addonify-wishlist' ); //phpcs:ignore

				wc_add_notice( $notice, 'error' );

				if (
					addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) === 'redirect_to_wishlist_page' &&
					(int) addonify_wishlist_get_option( 'wishlist_page' )
				) {

					$wishlist_page_id = (int) addonify_wishlist_get_option( 'wishlist_page' );
					wp_safe_redirect( get_permalink( $wishlist_page_id ) );
					exit;
				} else {

					wp_safe_redirect( home_url( $wp->request ) );
					exit;
				}
			}
		}
	}

	/**
	 * Functions to add product name data attribute in add to cart button.
	 *
	 * @since    2.0.3
	 *
	 * @param array $args Arguments.
	 * @param array $product Product object.
	 */
	public function add_to_cart_args( $args, $product ) {

		$args['attributes']['data-product_name'] = $product->get_title();

		return $args;
	}

	/**
	 * Render add to wishlist button in products loop.
	 *
	 * @since 1.0.0
	 */
	public function render_add_to_wishlist_button() {

		do_action( 'addonify_wishlist_render_wishlist_button' );
	}

	/**
	 * Render add to wishlist button in product single before cart form.
	 *
	 * @since 2.0.2
	 */
	public function render_add_to_wishlist_button_before_single_cart_form() {

		$add_to_wishlist_button_position = addonify_wishlist_get_option( 'btn_position_on_single' );

		if ( 'before_add_to_cart_form' === $add_to_wishlist_button_position ) {
			echo '<div class="addonify-add-to-wishlist-btn-wrapper">';
			$this->render_add_to_wishlist_button();
			echo '</div>';
		}
	}

	/**
	 * Render add to wishlist button in product single after cart form.
	 *
	 * @since 2.0.2
	 */
	public function render_add_to_wishlist_button_after_single_cart_form() {

		$add_to_wishlist_button_position = addonify_wishlist_get_option( 'btn_position_on_single' );

		if ( 'after_add_to_cart_form' === $add_to_wishlist_button_position ) {
			echo '<div class="addonify-add-to-wishlist-btn-wrapper">';
			$this->render_add_to_wishlist_button();
			echo '</div>';
		}
	}

	/**
	 * Render add to wishlist button in product single before add to cart button.
	 *
	 * @since 2.0.2
	 */
	public function render_add_to_wishlist_button_before_single_add_to_cart_button() {

		global $product;

		$add_to_wishlist_button_position = addonify_wishlist_get_option( 'btn_position_on_single' );

		if (
			(
				'simple' !== $product->get_type() &&
				'variable' !== $product->get_type()
			) &&
			'before_add_to_cart_button' === $add_to_wishlist_button_position
		) {
			$this->render_add_to_wishlist_button();
		}
	}

	/**
	 * Render add to wishlist button in product single before cart quantity.
	 *
	 * @since 2.0.2
	 */
	public function render_add_to_wishlist_button_after_single_add_to_cart_quantity() {

		global $product;

		$add_to_wishlist_button_position = addonify_wishlist_get_option( 'btn_position_on_single' );

		if (
			(
				'simple' === $product->get_type() ||
				'variable' === $product->get_type()
			) &&
			'before_add_to_cart_button' === $add_to_wishlist_button_position
		) {
			$this->render_add_to_wishlist_button();
		}
	}

	/**
	 * Render add to wishlist button in product single after add to cart button.
	 *
	 * @since 2.0.2
	 */
	public function render_add_to_wishlist_button_after_single_add_to_cart_button() {

		$add_to_wishlist_button_position = addonify_wishlist_get_option( 'btn_position_on_single' );

		if ( 'after_add_to_cart_button' === $add_to_wishlist_button_position ) {
			$this->render_add_to_wishlist_button();
		}
	}

	/**
	 * Add product into the cart.
	 *
	 * @since 1.0.0
	 * @param int $product_id Product ID.
	 * @return boolean true if added successfully otherwise false.
	 */
	public function add_to_cart( $product_id ) {

		global $woocommerce;

		if ( $woocommerce->cart->add_to_cart( $product_id ) ) {

			return true;
		}

		return false;
	}

	/**
	 * Callback function to handle ajax request to add product into the cart.
	 *
	 * @since 1.0.0
	 * @return array mixed.
	 */
	public function ajax_add_to_cart_handler() {

		// Check if nonce is valid.
		if (
			! isset( $_POST['nonce'] ) ||
			empty( $_POST['nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), $this->plugin_name )
		) {
			return wp_send_json(
				array(
					'success' => false,
					'message' => __( 'Missing or invalid secutiry token.', 'addonify-wishlist' ),
				)
			);
		}

		// Check if product id is set.
		if (
			! isset( $_POST['productId'] ) ||
			empty( $_POST['productId'] )
		) {
			return wp_send_json(
				array(
					'success' => false,
					'message' => __( 'Missing product id.', 'addonify-wishlist' ),
				)
			);
		}

		$product = wc_get_product( (int) sanitize_text_field( wp_unslash( $_POST['productId'] ) ) );

		// Add product into the cart and remove product from the wishlist.
		if ( $this->add_to_cart( $product->get_id() ) ) {
			global $adfy_wishlist;

			if ( (int) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) === 1 ) {
				$adfy_wishlist->remove_from_wishlist( $product->get_id() );
			}

			return wp_send_json(
				array(
					'success'        => true,
					'message'        => __( "{$product->get_title()} is added to cart.", 'addonify-wishlist' ), //phpcs:ignore
					'wishlist_count' => $adfy_wishlist->get_wishlist_items_count(),
				)
			);
		}

		return wp_send_json(
			array(
				'success' => false,
				'message' => __( "Error adding {$product->get_title()} to the cart.", 'addonify-wishlist' ),  //phpcs:ignore
			)
		);
	}

	/**
	 * Callback function to handle ajax request to remove product from the cart.
	 *
	 * @since 1.0.0
	 * @return array mixed.
	 */
	public function ajax_remove_from_wishlist_handler() {

		// Check if nonce is valid.
		if (
			! isset( $_POST['nonce'] ) ||
			empty( $_POST['nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), $this->plugin_name )
		) {
			return wp_send_json(
				array(
					'success' => false,
					'message' => __( 'Missing or invalid secutiry token.', 'addonify-wishlist' ), //phpcs:ignore
				)
			);
		}

		// Check if product id is set.
		if (
			! isset( $_POST['productId'] ) ||
			empty( $_POST['productId'] )
		) {
			return wp_send_json(
				apply_filters(
					'ajax_remove_from_wishlist_id_not_found_return',
					array(
						'success' => false,
						'message' => __( 'Missing product id.', 'addonify-wishlist' ),
					)
				)
			);
		}

		global $adfy_wishlist;
		$product     = wc_get_product( (int) sanitize_text_field( wp_unslash( $_POST['productId'] ) ) );
		$wishlist_id = isset( $_POST['wishlistId'] ) ? sanitize_text_field( wp_unslash( $_POST['wishlistId'] ) ) : '';

		if ( 'NaN' === $wishlist_id || '' === $wishlist_id ) {
			$wishlist_id = false;
		}

		// Remove product from the wishlist.
		if ( $adfy_wishlist->remove_from_wishlist( $product->get_id(), $wishlist_id ) ) {
			return wp_send_json(
				apply_filters(
					'ajax_remove_from_wishlist_return',
					array(
						'success'        => true,
						'message'        => __( "{$product->get_title()} is removed from wishlist.", 'addonify-wishlist' ), //phpcs:ignore
						'wishlist_count' => $adfy_wishlist->get_wishlist_items_count(),
					)
				)
			);
		}

		return wp_send_json(
			apply_filters(
				'ajax_remove_from_wishlist_error_return',
				array(
					'success' => false,
					'message' => addonify_wishlist_get_option( 'could_not_remove_from_wishlist_error_description' ), //phpcs:ignore
				)
			)
		);
	}

	/**
	 * Callback function to handle ajax request to add product to the cart.
	 *
	 * @since 1.0.0
	 * @return array mixed.
	 */
	public function ajax_add_to_wishlist_handler() {

		$product_id  = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
		$wishlist_id = isset( $_POST['wishlist_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wishlist_id'] ) ) : '';
		$nonce       = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if ( 'NaN' === $wishlist_id || '' === $wishlist_id ) {
			$wishlist_id = false;
		}

		// Check if product id and nonce is set and valid.
		if (
			! $product_id ||
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json_error( 'Either Product ID is missing or nonce does not match' );
		}

		if ( ! $wishlist_id ) {
			$wishlist_id = $this->get_default_wishlist_id();
		}

		// Check if product is already in the wishlist.
		if ( addonify_wishlist_is_product_in_this_wishlist( $wishlist_id, $product_id ) ) {
			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_already_in_wishlist_return',
				array(
					'success' => true,
					'message' => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
				)
			);
			return wp_send_json( $ajax_add_to_wishlist_return );
		}

		global $adfy_wishlist;

		// Save the wishlist.
		if ( $adfy_wishlist->add_to_wishlist( $product_id, $wishlist_id ) ) {

			$sidebar_data   = addonify_wishlist_render_sidebar_product( $product_id );
			$table_row_data = $this->get_table_row( $product_id );

			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_return',
				array(
					'success'        => true,
					'sidebar_data'   => $sidebar_data,
					'table_row_data' => $table_row_data,
					'wishlist_count' => $adfy_wishlist->get_wishlist_items_count(),
					'message'        => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
				)
			);
		} else {
			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_return_error',
				array(
					'success' => false,
					'message' => addonify_wishlist_get_option( 'could_not_add_to_wishlist_error_description' ),
				)
			);
		}
		return wp_send_json( $ajax_add_to_wishlist_return );
	}

	/**
	 * Empty wishlist
	 */
	public function ajax_empty_wishlist_handler() {

		$nonce       = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		$wishlist_id = isset( $_POST['wishlistId'] ) ? sanitize_text_field( wp_unslash( $_POST['wishlistId'] ) ) : '';
		global $adfy_wishlist;
		if ( 'NaN' === $wishlist_id || '' === $wishlist_id ) {
			$wishlist_id = false;
		}

		// Check if nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json_error( 'Invalid security token.' );
		}

		if ( $adfy_wishlist->empty_wishlist( $wishlist_id ) ) {
			return wp_send_json(
				apply_filters(
					'ajax_empty_wishlist_return',
					array(
						'success'        => true,
						'message'        => addonify_wishlist_get_option( 'wishlist_emptied_text' ), //phpcs:ignore
						'wishlist_count' => 0,
					)
				)
			);
		} else {
			return wp_send_json(
				apply_filters(
					'ajax_empty_wishlist_error_return',
					array(
						'success' => false,
						'message' => __( "Error emptying wishlist.", 'addonify-wishlist' ), //phpcs:ignore
					)
				)
			);

		}
	}

	/**
	 * Get default wishlist id.
	 *
	 * @return int
	 */
	private function get_default_wishlist_id() {

		foreach ( addonify_wishlist_get_wishlist_items() as $index => $item ) {
			if ( $item['name'] === $this->default_wishlist ) {
				return $index;
			}
		}
		return false;
	}

	/**
	 * Created default wishlist if does not exists.
	 */
	private function maybe_create_default_wishlist() {

		if ( is_user_logged_in() ) {
			if ( ! $this->get_default_wishlist_id() ) {
				$this->wishlist->seed_wishlist_table( $this->default_wishlist );
			}
		}
	}

	/**
	 * Migrate to table if not migrated already.
	 */
	private function maybe_migrate_metadata_to_table() {

		$this->wishlist->migrate_wishlist_data();
	}

	/**
	 * Gather shortcode contents and display template
	 *
	 * @since    1.0.0
	 */
	public function get_shortcode_contents() {

		ob_start();
		if ( class_exists( 'Addonify_Wishlist_Pro' ) ) {
			if ( array_key_exists( 'addonify-wishlist', $_GET ) && ! empty( $_GET['addonify-wishlist'] ) ) { //phpcs:ignore
				if ( array_key_exists( 'sharekey', $_GET ) && ! empty( $_GET['sharekey'] ) ) { //phpcs:ignore
					do_action(
						'addonify_wishlist_pro_render_view_single_for_share_template',
						array(
							'wishlist_id' => $_GET['addonify-wishlist'], //phpcs:ignore
							'sharekey'    => $_GET['sharekey'], //phpcs:ignore
						)
					);
				} else {
					do_action( 'addonify_wishlist_pro_render_view_single_template', array( 'wishlist_id' => $_GET['addonify-wishlist'] ) ); //phpcs:ignore
				}
			} else {
				do_action( 'addonify_wishlist_pro_render_view_wishlists_template', array() );
			}
		} else {
			do_action( 'addonify_wishlist_render_shortcode_content' );
		}
		return ob_get_clean();
	}

	/**
	 * Add add-to-wishlist button in cart page items.
	 *
	 * @param object|array $cart_item Cart item.
	 * @param string|int   $_         Cart item key.
	 */
	public function render_add_to_wishlist_button_in_cart_page_items_after_name( $cart_item, $_ ) {

		echo $this->render_add_to_wishlist_button_in_cart_page_items( $cart_item['product_id'] ); // phpcs:ignore
	}

	/**
	 * Add add-to-wishlist button in cart page items.
	 *
	 * @param string|int   $_         Item subtotal.
	 * @param object|array $cart_item Cart item.
	 * @param string|int   $__         Cart item key.
	 */
	public function render_add_to_wishlist_button_in_cart_page_items_after_subtotal( $_, $cart_item, $__ ) {

		return $_ . $this->render_add_to_wishlist_button_in_cart_page_items( $cart_item['product_id'] );
	}

	/**
	 * Add add-to-wishlist button in cart page items.
	 *
	 * @param int $product_id Cart item.
	 */
	public function render_add_to_wishlist_button_in_cart_page_items( $product_id ) {

		if ( ! ( is_cart() || is_page( 'cart' ) ) ) {
			return;
		}

		$class = 'adfy-wishlist-btn addonify_wishlist-cart-item-add-to-wishlist';

		if ( addonify_wishlist_is_product_in_wishlist( $product_id ) ) {
			$class .= ' adfy-wishlist-hide';
		} elseif ( ! is_user_logged_in() ) {
			$class .= ' adfy-wishlist-hide';
		}

		$attrs = array(
			'id'    => $product_id,
			'class' => $class,
			'label' => addonify_wishlist_get_option( 'save_for_later_btn_label' ),
		);

		return '<div class="addonify_wishlist-save-for-later">' . $this->get_wishlist_button_shortcode( $attrs ) . '</div>';
	}

	/**
	 * Get wishlist button shortcode.
	 *
	 * @param array $atts Attributes.
	 */
	public function get_wishlist_button_shortcode( $atts ) {

		return $this->get_wishlist_button_shortcode_contents( $atts );
	}

	/**
	 * Get wishlist button shortcode contents.
	 *
	 * @param array $atts Attributes.
	 */
	public function get_wishlist_button_shortcode_contents( $atts ) {

		$atts = shortcode_atts(
			array(
				'id'    => '',
				'class' => '',
				'label' => false,
			),
			$atts,
			'addonify_wishlist_button'
		);

		if ( '' === $atts['id'] ) {
			return '<button>' . __( 'Id required', 'addonify-wishlist' ) . '</button>';
		} else {
			$product = wc_get_product( $atts['id'] );
			if ( $product ) {
				if ( 'string' === gettype( $atts['class'] ) ) {
					$atts['class'] = explode( ' ', $atts['class'] );
				}
				ob_start();
				addonify_wishlist_render_add_to_wishlist_button( $product, $atts['class'], $atts['label'] );
				return ob_get_clean();
			} else {
				return '<button>' . __( 'Product does not exists.', 'addonify-wishlist' ) . '</button>';
			}
		}
	}

	/**
	 * Render template for showing "added to wishlist" modal
	 *
	 * @since    1.0.0
	 */
	public function wishlist_modal_wrapper() {

		do_action( 'addonify_wishlist_render_modal_wrapper' );
	}

	/**
	 * Render template for showing sticky sidebar
	 *
	 * @since    1.0.0
	 */
	public function wishlist_sidebar_template() {

		if ( ! ( is_cart() || is_page( 'cart' ) || is_checkout() || is_page( 'checkout' ) ) ) {
			if (
				( addonify_wishlist_get_option( 'wishlist_page' ) !== '' && ! is_page( addonify_wishlist_get_option( 'wishlist_page' ) ) ) ||
				! addonify_wishlist_get_option( 'require_login' )
			) {
				do_action( 'addonify_wishlist_render_sidebar_toggle_button' );

				do_action( 'addonify_wishlist_render_sidebar' );
			}
		}
	}

	/**
	 * Render template for sticky sidebar loop.
	 *
	 * @since    1.0.0
	 */
	public function get_sticky_sidebar_loop() {

		if ( wp_doing_ajax() ) {
			ob_start();
			addonify_wishlist_render_sidebar_loop();
			return ob_end_clean();
		} else {
			do_action( 'addonify_wishlist_render_sidebar_loop' );
		}
	}

	/**
	 * Change redirect url after login.
	 *
	 * @since    1.0.0
	 * @param    string $redirect Redirect url.
	 */
	public function myaccount_login( $redirect ) {

		if ( isset( $_GET['addonify_wishlist_redirect'] ) && ! empty( $_GET['addonify_wishlist_redirect'] ) ) { //phpcs:ignore
			$redirect = sanitize_text_field( wp_unslash( $_GET['addonify_wishlist_redirect'] ) ); //phpcs:ignore
		}

		return $redirect;
	}

	/**
	 * Show correct buttons in modal window.
	 * Used in public/templates/addonify-wishlist-modal-wrapper.php
	 * Custom template hooks.
	 *
	 * @since    1.0.0
	 */
	public function generate_modal_action_btns() {

		// If login is not required, display link button to wishlist page.
		if (
			(int) addonify_wishlist_get_option( 'require_login' ) === 0 ||
			is_user_logged_in()
		) {

			$wishlist_page_url = addonify_wishlist_get_option( 'wishlist_page' ) ? get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) : '';

			$view_wishlist_button_label = addonify_wishlist_get_option( 'view_wishlist_btn_text' );

			echo apply_filters(  //phpcs:ignore
				'addonify_wishlist_modal_add_to_wishlist_btn',
				'<a class="adfy-wishlist-btn-link addonify-view-wishlist-btn" href="' . esc_url( $wishlist_page_url ) . '">' . $view_wishlist_button_label . '</a>'
			);
		}

		// login is required.
		// show login button.
		if (
			(int) addonify_wishlist_get_option( 'require_login' ) === 1 &&
			! is_user_logged_in()
		) {

			global $wp;

			$redirect_url = add_query_arg(
				'addonify_wishlist_redirect',
				home_url( $wp->request ),
				( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url()
			);

			echo wp_kses_post(
				apply_filters(
					'addonify_wishlist_modal_login_btn',
					'<a class="adfy-wishlist-btn-link addonify-goto-login-btn" href="' . esc_url( $redirect_url ) . '">' . __( 'Login', 'addonify-wishlist' ) . '</a>'
				)
			);
		}
	}

	/**
	 * Add nonce field in wishlist form.
	 *
	 * @since 1.0.0
	 */
	public function ajaxify_wishlist_form() {
		?>
		<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( $this->plugin_name ) ); ?>">
		<?php
	}

	/**
	 * Get guest wishlist table.
	 */
	public function addonify_get_wishlist_table() {

		if (
			isset( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), $this->plugin_name )
		) {
			ob_start();
			if ( isset( $_POST['productIds'] ) ) {
				$product_ids = json_decode( sanitize_text_field( wp_unslash( $_POST['productIds'] ) ) );
				addonify_wishlist_get_template(
					'addonify-wishlist-shortcode-contents.php',
					apply_filters(
						'addonify_wishlist_shortcode_contents_args',
						array(
							'wishlist_product_ids' => $product_ids,
							'guest'                => true,
							'nonce'                => wp_create_nonce( 'addonify-wishlist' ),
						)
					)
				);
			} else {
				addonify_wishlist_get_template(
					'addonify-wishlist-shortcode-contents.php',
					apply_filters(
						'addonify_wishlist_shortcode_contents_args',
						array(
							'wishlist_product_ids' => array(),
							'nonce'                => wp_create_nonce( 'addonify-wishlist' ),
						)
					)
				);
			}
			echo ob_get_clean(); //phpcs:ignore
			exit;
		} else {
			wp_send_json_error( 'Invalid security token.' );
		}
	}

	/**
	 * Get guest wishlist sidebar.
	 */
	public function addonify_get_wishlist_sidebar() {

		if (
			isset( $_POST['nonce'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), $this->plugin_name )
		) {
			if ( isset( $_POST['productIds'] ) ) {
				ob_start();
				addonify_wishlist_render_sidebar_toggle_button();
				$product_ids = json_decode( sanitize_text_field( wp_unslash( $_POST['productIds'] ) ) );
				addonify_wishlist_render_sidebar( $product_ids );
				echo ob_get_clean(); //phpcs:ignore
			} else {
				echo '';
			}
		} else {
			wp_send_json_error( 'Invalid security token.' );
		}
		exit;
	}

	/**
	 * Sidebar added product content.
	 */
	public function addonify_add_to_wishlist_sidebar_added_content() {

		$product_id = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
		$nonce      = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if product id and nonce is set and valid.
		if (
			! $product_id ||
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json_error( 'Either Product ID is missing or nonce does not match' );
		}

		$sidebar_data   = addonify_wishlist_render_sidebar_product( $product_id, true );
		$table_row_data = $this->get_table_row( $product_id );

		wp_send_json(
			array(
				'sidebar_data'   => $sidebar_data,
				'table_row_data' => $table_row_data,
			)
		);
	}

	/**
	 * Get table row by product ID.
	 *
	 * @param int $product_id Product ID.
	 * @return string Table row.
	 */
	public function get_table_row( $product_id ) {

		$wishlist_attr = '';

		if ( is_user_logged_in() ) {
			$parent_wishlist_id = $this->wishlist->get_wishlist_id_from_product_id( $product_id );
			if ( $parent_wishlist_id ) {
				$wishlist_attr = 'data-wishlist_id=' . $parent_wishlist_id;
			}
		}

		ob_start();
		$product = wc_get_product( $product_id );
		?>
		<tr
			class="addonify-wishlist-table-product-row"
			data-product_row="addonify-wishlist-table-product-row-<?php echo esc_attr( $product_id ); ?>"
			data-product_name="<?php echo esc_attr( $product->get_name() ); ?>"
		>
			<td class="remove">
				<?php
				$remove_class = isset( $guest ) ? ' addonify-wishlist-table-remove-from-wishlist ' : ' addonify-wishlist-ajax-remove-from-wishlist ';
				?>
				<button
					class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_html( $remove_class ); ?> addonify-wishlist-table-button" 
					name="addonify_wishlist_remove"
					data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
					value="<?php echo esc_attr( $product_id ); ?>"
					<?php echo esc_attr( $wishlist_attr ); ?>
				>
					<i class="adfy-wishlist-icon trash-2"></i>
				</button>
			</td>
			<td class="image">
				<?php
				if ( $product->get_image() ) {
					?>
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
						<?php echo wp_kses_post( $product->get_image( array( 72, 72 ) ) ); ?>
					</a>
					<?php
				}
				?>
			</td>
			<td class="name">
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo wp_kses_post( $product->get_title() ); ?>
				</a>
			</td>
			<td class="price">
				<?php echo wp_kses_post( $product->get_price_html() ); ?>
			</td>
			<td class="stock">
				<?php
				$product_avaibility = addonify_wishlist_get_product_avaibility( $product );
				if ( $product_avaibility ) {
					echo esc_html( $product_avaibility['avaibility'] );
				}
				?>
			</td>
			<td class="actions">
				<?php
				echo do_shortcode( '[add_to_cart id=' . $product->get_id() . ' show_price=false style="" class="adfy-wishlist-clear-shortcode-button-style adfy-wishlist-btn addonify-wishlist-add-to-cart addonify-wishlist-table-button"]' );
				?>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * Removes product from wishlist if exists.
	 */
	public function remove_item_from_wishlist() {

		if (
			is_user_logged_in() &&
			(bool) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' )
		) {
			global $adfy_wishlist;
			// remove if exists.
			if ( isset( $_REQUEST['product_id'] ) ) { //phpcs:ignore
				$adfy_wishlist->remove_from_wishlist( sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ) ) ); //phpcs:ignore
			}
			if ( isset( $_REQUEST['add-to-cart'] ) ) { //phpcs:ignore
				$adfy_wishlist->remove_from_wishlist( sanitize_text_field( wp_unslash( $_REQUEST['add-to-cart'] ) ) ); //phpcs:ignore
			}
		}
	}

	/**
	 * Print dynamic CSS generated from settings page.
	 */
	public function dynamic_css() {

		$css_values = array(
			'--adfy_wishlist_wishlist_btn_text_color'      => addonify_wishlist_get_option( 'wishlist_btn_text_color' ),
			'--adfy_wishlist_wishlist_btn_icon_color'      => addonify_wishlist_get_option( 'wishlist_btn_icon_color' ),
			'--adfy_wishlist_wishlist_btn_text_color_hover' => addonify_wishlist_get_option( 'wishlist_btn_text_color_hover' ),
			'--adfy_wishlist_wishlist_btn_icon_color_hover' => addonify_wishlist_get_option( 'wishlist_btn_icon_color_hover' ),
			'--adfy_wishlist_wishlist_btn_bg_color'        => addonify_wishlist_get_option( 'wishlist_btn_bg_color' ),
			'--adfy_wishlist_wishlist_btn_bg_color_hover'  => addonify_wishlist_get_option( 'wishlist_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_overlay_bg_color' => addonify_wishlist_get_option( 'sidebar_modal_overlay_bg_color' ),
			'--adfy_wishlist_popup_modal_overlay_bg_color' => addonify_wishlist_get_option( 'popup_modal_overlay_bg_color' ),
			'--adfy_wishlist_popup_modal_bg_color'         => addonify_wishlist_get_option( 'popup_modal_bg_color' ),
			'--adfy_wishlist_border_color'                 => addonify_wishlist_get_option( 'sidebar_modal_general_border_color' ),
			'--adfy_wishlist_popup_modal_close_btn_icon_color' => addonify_wishlist_get_option( 'popup_close_btn_icon_color' ),
			'--adfy_wishlist_popup_modal_close_btn_icon_color_hover' => addonify_wishlist_get_option( 'popup_close_btn_icon_color_on_hover' ),
			'--adfy_wishlist_popup_modal_icon_color'       => addonify_wishlist_get_option( 'popup_modal_icon_color' ),
			'--adfy_wishlist_popup_modal_text_color'       => addonify_wishlist_get_option( 'popup_modal_text_color' ),
			'--adfy_wishlist_popup_modal_btn_text_color'   => addonify_wishlist_get_option( 'popup_modal_btn_text_color' ),
			'--adfy_wishlist_popup_modal_btn_text_color_hover' => addonify_wishlist_get_option( 'popup_modal_btn_text_color_hover' ),
			'--adfy_wishlist_popup_modal_btn_bg_color'     => addonify_wishlist_get_option( 'popup_modal_btn_bg_color' ),
			'--adfy_wishlist_popup_modal_btn_bg_color_hover' => addonify_wishlist_get_option( 'popup_modal_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_label_color' => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_label_color' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_label_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_label_color_hover' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_bg_color' => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_bg_color' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_bg_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_toggle_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_bg_color'       => addonify_wishlist_get_option( 'sidebar_modal_bg_color' ),
			'--adfy_wishlist_sidebar_modal_title_color'    => addonify_wishlist_get_option( 'sidebar_modal_title_color' ),
			'--adfy_wishlist_sidebar_modal_empty_text_color' => addonify_wishlist_get_option( 'sidebar_modal_empty_text_color' ),
			'--adfy_wishlist_sidebar_modal_close_icon_color' => addonify_wishlist_get_option( 'sidebar_modal_close_icon_color' ),
			'--adfy_wishlist_sidebar_modal_close_icon_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_close_icon_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_title_color' => addonify_wishlist_get_option( 'sidebar_modal_product_title_color' ),
			'--adfy_wishlist_sidebar_modal_product_title_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_product_title_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_regular_price_color' => addonify_wishlist_get_option( 'sidebar_modal_product_regular_price_color' ),
			'--adfy_wishlist_sidebar_modal_product_sale_price_color' => addonify_wishlist_get_option( 'sidebar_modal_product_sale_price_color' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_label_color' => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_label_color' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_label_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_label_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_bg_color' => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_bg_color' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_bg_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_product_add_to_cart_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_remove_from_wishlist_icon_color' => addonify_wishlist_get_option( 'sidebar_modal_product_remove_from_wishlist_icon_color' ),
			'--adfy_wishlist_sidebar_modal_product_remove_from_wishlist_icon_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_product_remove_from_wishlist_icon_color_hover' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_label_color' => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_label_color' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_label_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_label_color_hover' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_bg_color' => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_bg_color' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_bg_color_hover' => addonify_wishlist_get_option( 'sidebar_modal_view_wishlist_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_in_stock_text_color' => addonify_wishlist_get_option( 'sidebar_modal_in_stock_text_color' ),
			'--adfy_wishlist_sidebar_modal_out_of_stock_text_color' => addonify_wishlist_get_option( 'sidebar_modal_out_of_stock_text_color' ),
			'--adfy_wishlist_product_removed_notice_bg_color' => addonify_wishlist_get_option( 'notice_background_color' ),
			'--adfy_wishlist_product_removed_notice_bg_color' => addonify_wishlist_get_option( 'notice_background_color' ),
			'--adfy_wishlist_product_removed_notice_text_color' => addonify_wishlist_get_option( 'notice_text_color' ),
			'--adfy_wishlist_product_removed_notice_undo_btn_text_color' => addonify_wishlist_get_option( 'undo_button_label_color' ),
			'--adfy_wishlist_product_removed_notice_undo_btn_hover_text_color' => addonify_wishlist_get_option( 'undo_button_label_color_hover' ),
			'--adfy_wishlist_product_removed_notice_undo_btn_bg_color' => addonify_wishlist_get_option( 'undo_button_background_color' ),
			'--adfy_wishlist_product_removed_notice_undo_btn_hover_bg_color' => addonify_wishlist_get_option( 'undo_button_background_color_hover' ),
		);

		$css = ':root {';

		foreach ( $css_values as $key => $value ) {
			if ( $value ) {
				$css .= $key . ': ' . $value . ';';
			}
		}

		$css .= '}';

		return $css;
	}

	/**
	 * Minify the dynamic css.
	 *
	 * @param string $css css to minify.
	 * @return string minified css.
	 */
	public function minify_css( $css ) {

		$css = preg_replace( '/\s+/', ' ', $css );
		$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
		$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		return trim( $css );
	}
}
