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
class Addonify_Wishlist_Public_Deprecated {

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
	 * Total items in wishlist
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      int    $wishlist_items_count
	 */
	public $wishlist_items_count;


	/**
	 * Wishlist items.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $wishlist_items
	 */
	private $wishlist_items = array();

	/**
	 * Public wishlist.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var string $default_wishlist
	 */
	private $default_wishlist = 'default_wishlist';

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

		$this->wishlist_items = $this->get_wishlist();

		$this->maybe_create_default_wishlist();

		if (
			array_key_exists( get_bloginfo( 'url' ), $this->wishlist_items ) &&
			isset( $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ] ) &&
			isset( $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'] )
			) {
			$this->wishlist_items_count = count( $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'] );
		} else {
			$this->wishlist_items_count = 0;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		if ( addonify_wishlist_get_option( 'btn_position' ) === 'after_add_to_cart' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_add_to_wishlist_button' ), 15 );
		}

		if ( addonify_wishlist_get_option( 'btn_position' ) === 'before_add_to_cart' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_add_to_wishlist_button' ), 5 );
		}

		add_action( 'wp', array( $this, 'position_add_to_wishlist_button_single_page' ) );

		add_action( 'woocommerce_add_to_cart', array( $this, 'remove_item_from_wishlist' ) );

		add_action( 'wp', array( $this, 'init_actions' ) );

		add_action( 'wp_footer', array( $this, 'wishlist_modal_wrapper' ) );
		add_action( 'wp_footer', array( $this, 'wishlist_sidebar_template' ) );

		add_filter( 'woocommerce_login_redirect', array( $this, 'myaccount_login' ) );

		add_action( 'addonify_wishlist_before_wishlist_form_table', array( $this, 'ajaxify_wishlist_form' ) );

		add_shortcode( 'addonify_wishlist', array( $this, 'get_shortcode_contents' ) );

		add_shortcode( 'addonify_wishlist_button', array( $this, 'get_wishlist_button_shortcode' ) );

		$this->register_ajax_actions();
	}

	/**
	 * Position add to wishlist button on single page.
	 */
	public function position_add_to_wishlist_button_single_page() {

		switch ( addonify_wishlist_get_option( 'btn_position_on_single' ) ) {
			case 'before_add_to_cart_form':
				add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'render_add_to_wishlist_button_single' ) );
				break;
			case 'before_add_to_cart_button':
				if (
					'simple' === wc_get_product()->get_type() ||
					'variable' === wc_get_product()->get_type()
				) {
					add_action( 'woocommerce_after_add_to_cart_quantity', array( $this, 'render_add_to_wishlist_button_single' ) );
				} else {
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'render_add_to_wishlist_button_single' ) );
				}
				break;
			case 'after_add_to_cart_button':
				add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'render_add_to_wishlist_button_single' ) );
				break;
			default:
				add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'render_add_to_wishlist_button_single' ) );
		}
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

		wp_enqueue_style(
			'addonify-wishlist-icon',
			plugin_dir_url( __FILE__ ) . 'assets/fonts/addonify-wishlist-icon.min.css',
			array(),
			$this->version,
			'all'
		);

		$css  = ':root {';
		$css .= '--adfy_wishlist_sidebar_btn_position_offset: ' . addonify_wishlist_get_option( 'sidebar_btn_position_offset' ) . ';';
		$css .= '}';

		wp_add_inline_style( $this->plugin_name, $css );

		if ( (int) addonify_wishlist_get_option( 'load_styles_from_plugin' ) === 1 ) {

			$inline_css = $this->dynamic_css();

			$custom_css = addonify_wishlist_get_option( 'custom_css' );

			if ( $custom_css ) {
				$inline_css .= $custom_css;
			}

			$inline_css = $this->minify_css( $inline_css );

			wp_add_inline_style( $this->plugin_name, $inline_css );
		}
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
				'loginMessage'                          => __( 'Please login before adding item to Wishlist', 'addonify-wishlist' ),
				'addedToWishlistText'                   => addonify_wishlist_get_option( 'btn_label_when_added_to_wishlist' ),
				'initialAddToWishlistButtonLabel'       => addonify_wishlist_get_option( 'btn_label' ),
				'alreadyInWishlistText'                 => __( 'Already in Wishlist', 'addonify-wishlist' ),
				'popupAddedToWishlistText'              => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
				'popupAlreadyInWishlistText'            => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
				'emptyWishlistText'                     => addonify_wishlist_get_option( 'empty_wishlist_label' ),
				'sidebarEmptyWishlistText'              => addonify_wishlist_get_option( 'sidebar_empty_wishlist_label' ),
				'removedFromWishlistText'               => addonify_wishlist_get_option( 'product_removed_from_wishlist_text' ),
				'emptiedWishlistText'                   => addonify_wishlist_get_option( 'wishlist_emptied_text' ),
				'undoActionPrelabelText'                => addonify_wishlist_get_option( 'undo_action_prelabel_text' ),
				'undoActionLabel'                       => addonify_wishlist_get_option( 'undo_action_label' ),
				'undoNoticeTimeout'                     => addonify_wishlist_get_option( 'undo_notice_timeout' ),
				'isLoggedIn'                            => is_user_logged_in(),
				'addedToWishlistButtonLabel'            => addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' ),
				'addonify_get_wishlist_table'           => 'addonify_get_wishlist_table',
				'addonify_get_wishlist_sidebar'         => 'addonify_get_wishlist_sidebar',
				'thisSiteUrl'                           => get_bloginfo( 'url' ),
				'checkoutPageURL'                       => wc_get_checkout_url(),
				'afterAddToWishlistAction'              => addonify_wishlist_get_option( 'after_add_to_wishlist_action' ),
				'wishlistPageURL'                       => esc_url( get_permalink( addonify_wishlist_get_page_by_title( 'Wishlist' ) ) ),
				'requireLogin'                          => (bool) addonify_wishlist_get_option( 'require_login' ),
				'loginURL'                              => $login_url,
				/* Translators: %1$s = An 'a' tag opening tag, %2$s = closing 'a' tag. */
				'loginRequiredMessage'                  => sprintf( __( 'Login required. Please %1$s click here %2$s to login.', 'addonify-wishlist' ), '<a href="' . $login_url . '">', '</a>' ),
				'ajaxAddToCart'                         => ( 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ),
				'pageLink'                              => get_permalink( (int) addonify_wishlist_get_option( 'empty_wishlist_navigation_link' ) ),
				'pageLinkLabel'                         => addonify_wishlist_get_option( 'empty_wishlist_navigation_link_label' ),
				'showPageLinkLabel'                     => (bool) addonify_wishlist_get_option( 'show_empty_wishlist_navigation_link' ),
			)
		);

	}

	/**
	 * Functions to run on init.
	 *
	 * @since    1.0.0
	 */
	public function init_actions() {

		global $wp;

		// Remove product from the wishlist.
		// Only works if removal is done on form submit.
		if (
			isset( $_POST['addonify-remove-from-wishlist'] ) &&
			! empty( $_POST['addonify-remove-from-wishlist'] )
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

			$product_id = (int) sanitize_text_field( wp_unslash( $_POST['addonify-remove-from-wishlist'] ) );

			$product = wc_get_product( $product_id );

			// Remove product from the wishlist.
			if ( $this->remove_from_wishlist( $product_id ) ) {

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

					if ( $this->remove_from_wishlist( $product_id ) ) {

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

			$product = wc_get_product( $product_id );

			if ( $this->add_to_wishlist( $product_id ) ) {

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
	 * Render add to wishlist button in products loop.
	 *
	 * @since 1.0.0
	 */
	public function render_add_to_wishlist_button() {

		do_action( 'addonify_wishlist_render_wishlist_button' );
	}

	/**
	 * Render add to wishlist button in product single.
	 *
	 * @since 1.0.0
	 */
	public function render_add_to_wishlist_button_single() {

		if ( is_archive() || is_shop() ) {
			return;
		}
		echo '<div class="addonify-add-to-wishlist-btn-wrapper">';
		$this->render_add_to_wishlist_button();
		echo '</div>';
	}

	/**
	 * Add product into the wishlist if product is not in the wishlist.
	 *
	 * @since 1.0.0
	 * @param int $product_id Product ID.
	 * @return boolean true if added successfully otherwise false.
	 */
	public function add_to_wishlist( $product_id ) {

		if (
			is_array( $this->wishlist_items )
		) {
			$this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'][] = (int) $product_id;
			$this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['updated_at'] = time();
			return $this->save_wishlist_items( $this->wishlist_items );
		}
		return false;
	}

	/**
	 * Remove product from the wishlist if product is already in the wishlist.
	 *
	 * @since 1.0.0
	 * @param int $product_id Product ID.
	 * @return boolean true if removed successfully otherwise false.
	 */
	public function remove_from_wishlist( $product_id ) {

		if (
			array_key_exists( get_bloginfo( 'url' ), $this->wishlist_items )
		) {
			$key = array_search( (int) $product_id, $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'], true );
			if ( false !== $key ) {
				unset( $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'][ $key ] );
			}
			return $this->save_wishlist_items( $this->wishlist_items );
		}
		return false;
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

			if ( (int) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) === 1 ) {

				$this->remove_from_wishlist( $product->get_id() );
			}

			return wp_send_json(
				array(
					'success'        => true,
					'message'        => __( "{$product->get_title()} is added to cart.", 'addonify-wishlist' ), //phpcs:ignore
					'wishlist_count' => $this->wishlist_items_count,
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

		$product = wc_get_product( (int) sanitize_text_field( wp_unslash( $_POST['productId'] ) ) );

		// Remove product from the wishlist.
		if ( $this->remove_from_wishlist( $product->get_id() ) ) {

			return wp_send_json(
				apply_filters(
					'ajax_remove_from_wishlist_return',
					array(
						'success'        => true,
						'message'        => __( "{$product->get_title()} is removed from wishlist.", 'addonify-wishlist' ), //phpcs:ignore
						'wishlist_count' => $this->wishlist_items_count,
					)
				)
			);
		}

		return wp_send_json(
			apply_filters(
				'ajax_remove_from_wishlist_error_return',
				array(
					'success' => false,
					'message' => __( "Error removing {$product->get_title()} from the wishlist.", 'addonify-wishlist' ), //phpcs:ignore
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

		$in_wishlist = addonify_wishlist_is_product_in_wishlist( $product_id );

		// Check if product is already in the wishlist.
		if ( $in_wishlist ) {
			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_already_in_wishlist_return',
				array(
					'success' => true,
					'message' => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
				)
			);
			return wp_send_json( $ajax_add_to_wishlist_return );
		}

		// Add product into the wishlist.
		$this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'][] = (int) $product_id;
		$this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['updated_at'] = time();

		// Save the wishlist.
		if ( $this->save_wishlist_items( $this->wishlist_items ) ) {

			$sidebar_data   = addonify_wishlist_render_sidebar_product( $product_id );
			$table_row_data = $this->get_table_row( $product_id );

			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_return',
				array(
					'success'        => true,
					'sidebar_data'   => $sidebar_data,
					'table_row_data' => $table_row_data,
					'wishlist_count' => $this->wishlist_items_count,
					'message'        => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
				)
			);
		} else {
			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_return_error',
				array(
					'success' => false,
					'message' => __( 'Something went wrong. <br>{product_name} was not added to wishlist. Please refresh page and try again.', 'addonify-wishlist' ),
				)
			);
		}
		return wp_send_json( $ajax_add_to_wishlist_return );
	}

	/**
	 * Empty wishlist
	 */
	public function ajax_empty_wishlist_handler() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if product id and nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json_error( 'Invalid security token.' );
		}

		if ( array_key_exists( get_bloginfo( 'url' ), $this->wishlist_items ) ) {
			$this->wishlist_items[ get_bloginfo( 'url' ) ] = array();
		}

		if ( $this->save_wishlist_items( $this->wishlist_items ) ) {

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
	 * Save wishlist data into the user meta and cookie.
	 *
	 * @since   1.0.0
	 * @param   array $data Data to be saved as wishlist.
	 * @return  boolean true if saved successfully, false otherwise.
	 */
	private function save_wishlist_items( $data ) {

		$return_boolean = false;

		do_action( 'addonify_wishlist_before_adding_to_wishlist' );

		if ( is_user_logged_in() ) {
			if ( wp_unslash( wp_json_encode( $data ) ) === get_user_meta( get_current_user_id(), $this->plugin_name, true ) ) {
				$return_boolean = true;
			} else {
				$return_boolean = ( update_user_meta( get_current_user_id(), $this->plugin_name, wp_json_encode( $data ) ) ) ? true : false;
			}
		}
		if (
			array_key_exists( get_bloginfo( 'url' ), $this->wishlist_items ) &&
			isset( $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'] )
		) {
			$this->wishlist_items_count = count( $this->wishlist_items[ get_bloginfo( 'url' ) ][ $this->default_wishlist ]['products'] );
		} else {
			$this->wishlist_items_count = 0;
		}

		do_action( 'addonify_wishlist_after_adding_to_wishlist' );

		return $return_boolean;
	}

	/**
	 * Return wishlist.
	 * If cookie wishlist and user meta wishlist do not match, user meta wishlist is updated with cookie wishlist.
	 *
	 * @since    1.0.0
	 * @return  array $wishlist_items.
	 */
	public function get_wishlist() {

		if ( is_user_logged_in() ) {
			$user_meta_wishlist = $this->get_wishlist_from_database();
			if ( is_array( $user_meta_wishlist ) ) {
				return $user_meta_wishlist;
			}
		}
		return array();
	}

	/**
	 * Return wishlist product ids in array from database
	 *
	 * @since    for future update.
	 * @return  array $wishlist_items.
	 */
	private function get_wishlist_from_database() {

		$current_user_id = get_current_user_id();

		if ( 0 !== $current_user_id ) {
			$wishlist_data = get_user_meta( $current_user_id, $this->plugin_name, true );
			if ( ! empty( $wishlist_data ) ) {
				return $wishlist_data ? json_decode( $wishlist_data, true ) : array();
			}
		}

		return array();
	}

	/**
	 * Created default wishlist if does not exists.
	 */
	private function maybe_create_default_wishlist() {

		if (
			! is_array( $this->wishlist_items ) ||
			! array_key_exists( get_bloginfo( 'url' ), $this->wishlist_items ) ||
			! array_key_exists( $this->default_wishlist, $this->wishlist_items[ get_bloginfo( 'url' ) ] )
			) {
			$this->wishlist_items[ get_bloginfo( 'url' ) ] = array(
				$this->default_wishlist => array(
					'products'   => array(),
					'created_at' => time(),
				),
			);
			$this->save_wishlist_items( $this->wishlist_items );
		}
	}

	/**
	 * Gather shortcode contents and display template
	 *
	 * @since    1.0.0
	 */
	public function get_shortcode_contents() {

		if ( wp_doing_ajax() ) {
			ob_start();
			addonify_wishlist_render_wishlist_content();
			return ob_end_clean();
		} else {
			do_action( 'addonify_wishlist_render_shortcode_content' );
		}
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
			),
			$atts,
			'addonify_wishlist_button'
		);

		if ( '' === $atts['id'] ) {
			return 'id required';
		} else {
			$product = wc_get_product( $atts['id'] );
			ob_start();
			addonify_wishlist_render_add_to_wishlist_button( $product, $atts['class'] );
			return ob_get_clean();
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

		if (
			(
				addonify_wishlist_get_option( 'wishlist_page' ) !== '' &&
				! is_page( addonify_wishlist_get_option( 'wishlist_page' ) )
			) ||
			! addonify_wishlist_get_option( 'require_login' )
		) {
			do_action( 'addonify_wishlist_render_sidebar_toggle_button' );

			do_action( 'addonify_wishlist_render_sidebar' );
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

		ob_start();
		$product = wc_get_product( $product_id );
		?>
		<tr class="addonify-wishlist-table-product-row" data-product_row="addonify-wishlist-table-product-row-<?php echo esc_attr( $product_id ); ?>" data-product_name="<?php echo esc_attr( $product->get_name() ); ?>">
			<td class="remove">
				<?php
				$remove_class = isset( $guest ) ? ' addonify-wishlist-table-remove-from-wishlist ' : ' addonify-wishlist-ajax-remove-from-wishlist ';
				?>
				<button 
					class="adfy-wishlist-btn addonify-wishlist-icon <?php echo esc_html( $remove_class ); ?> addonify-wishlist-table-button" 
					name="addonify_wishlist_remove"
					data-product_name="<?php echo wp_kses_post( $product->get_title() ); ?>"
					value="<?php echo esc_attr( $product_id ); ?>"
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

		if ( is_user_logged_in() && (bool) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) ) {
			// remove if exists.
			if ( isset( $_REQUEST['product_id'] ) ) { //phpcs:ignore
				$this->remove_from_wishlist( sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ) ) ); //phpcs:ignore
			}
			if ( isset( $_REQUEST['add-to-cart'] ) ) { //phpcs:ignore
				$this->remove_from_wishlist( sanitize_text_field( wp_unslash( $_REQUEST['add-to-cart'] ) ) ); //phpcs:ignore
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
			'--adfy_wishlist_popup_model_close_btn_icon_color' => addonify_wishlist_get_option( 'popup_close_btn_icon_color' ),
			'--adfy_wishlist_popup_model_close_btn_icon_color_hover' => addonify_wishlist_get_option( 'popup_close_btn_icon_color_on_hover' ),
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
			'--adfy_wishlist_sidebar_modal_notification_text_color' => addonify_wishlist_get_option( 'sidebar_modal_notification_text_color' ),
			'--adfy_wishlist_sidebar_modal_notification_bg_color' => addonify_wishlist_get_option( 'sidebar_modal_notification_bg_color' ),
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
