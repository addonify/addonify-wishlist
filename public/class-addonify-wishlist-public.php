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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


	public function public_init() {

		if (
			! class_exists( 'WooCommerce' ) ||
			(int) addonify_wishlist_get_option( 'enable_wishlist' ) != 1
		) {
			return;
		}

		$this->wishlist_items = $this->get_wishlist();

		$this->wishlist_items_count = is_array( $this->wishlist_items ) ? count( $this->wishlist_items ) : 0;

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );


		if ( addonify_wishlist_get_option( 'btn_position' ) ==  'after_add_to_cart' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_add_to_wishlist_button' ), 15 );
		}

		if ( addonify_wishlist_get_option( 'btn_position' ) ==  'before_add_to_cart' ) {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'render_add_to_wishlist_button' ), 5 );
		}

		add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'render_add_to_wishlist_button_single' ) );
		
		add_action( 'wp', array( $this, 'init_actions' ) );

		add_action( 'wp_footer', array( $this, 'wishlist_modal_wrapper' ) );
		add_action( 'wp_footer', array( $this, 'wishlist_sidebar_template' ) );

		add_action( 'wp_ajax_addonify_add_to_wishlist', array( $this, 'ajax_add_to_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_add_to_wishlist', array( $this, 'ajax_add_to_wishlist_handler' ) );

		add_action( 'wp_ajax_addonify_add_to_cart_from_wishlist', array( $this, 'ajax_add_to_cart_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_add_to_cart_from_wishlist', array( $this, 'ajax_add_to_cart_handler' ) );

		add_action( 'wp_ajax_addonify_remove_from_wishlist', array( $this, 'ajax_remove_from_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_remove_from_wishlist', array( $this, 'ajax_remove_from_wishlist_handler' ) );

		// For future update.
		//add_action( 'wp_login', array( $this, 'after_user_login' ), 10, 2 );
		
		add_filter( 'woocommerce_login_redirect', array( $this, 'myaccount_login' ) );

		add_action( 'addonify_wishlist/before_wishlist_form_table', array( $this, 'ajaxify_wishlist_form' ) );

		// add_action( 'wp', array( $this, 'init_actions' ) );

		add_shortcode( 'addonify_wishlist', array( $this, 'get_shortcode_contents' ) );
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'perfect-scrollbar', plugin_dir_url( __FILE__ ) . 'assets/build/css/conditional/perfect-scrollbar.css', array(), $this->version );

		if ( is_rtl() ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/css/addonify-wishlist-public-rtl.css', array(), $this->version );
		} else {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/css/addonify-wishlist-public.css', array(), $this->version );
		}

		wp_enqueue_style( 'addonify-wishlist-icon', plugin_dir_url( __FILE__ ) . 'assets/fonts/addonify-wishlist-icon.min.css', array(), $this->version );

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

		global $wp;

		wp_enqueue_script( 'perfect-scrollbar', plugin_dir_url( __FILE__ ) . 'assets/build/js/conditional/perfect-scrollbar.min.js', null, $this->version, true );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/js/addonify-wishlist-public.min.js', array( 'jquery' ), $this->version, true );

		wp_localize_script(
			$this->plugin_name,
			'addonifyWishlistJSObject',
			array(
				'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce' => wp_create_nonce( $this->plugin_name ),
				'addToWishlistAction' => 'addonify_add_to_wishlist',
				'removeFromWishlistAfterAddedToCart' => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ),
				'loginMessage' => __( 'Please login before adding item to Wishlist', 'addonify-wishlist' ),
				'addedToWishlistText' => __( "Added to Wishlist", 'addonify-wishlist' ),
				'initialAddToWishlistButtonLabel' => addonify_wishlist_get_option( 'btn_label' ),
				'alreadyInWishlistText' => __( "Already in Wishlist", 'addonify-wishlist' ),
				'popupAddedToWishlistText' => addonify_wishlist_get_option( 'product_added_to_wishlist_text' ),
				'popupAlreadyInWishlistText' => addonify_wishlist_get_option( 'product_already_in_wishlist_text' ),
				'emptyWishlistText' => __( 'Your Wishlist is empty', 'addonify-wishlist' ),
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

		// var_dump( strtok( $_SERVER['REQUEST_URI'], '?' ) );

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
				! wp_verify_nonce( $_POST['nonce'], $this->plugin_name )
			) {
				wc_add_notice( __( "Invalid security token.", 'addonify-wishlist' ), 'error' );
				return;
			}

			$product_id = (int) wp_unslash( $_POST['addonify-remove-from-wishlist'] );

			$product = wc_get_product( $product_id );

			// Remove product from the wishlist.
			if ( $this->remove_from_wishlist( $product_id ) ) {

				wc_add_notice( __( "{$product->get_title()} is removed from the wishlist.", "addonify-wishlist" ), 'success' );
			} else {

				wc_add_notice( __( "{$product->get_title()} is not in the wishlist.", "addonify-wishlist" ), 'error' );
			}

			wp_redirect( home_url( $wp->request ) );
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
				! wp_verify_nonce( $_POST['nonce'], $this->plugin_name )
			) {
				wc_add_notice( __( "Invalid security token.", 'addonify-wishlist' ), 'error' );
				return;
			}

			$product_id = (int) wp_unslash( $_POST['addonify-add-to-cart-from-wishlist'] );

			$product = wc_get_product( $product_id );

			// Add product into the cart.
			if ( $this->add_to_cart( $product_id ) ) {

				$notice = __( "{$product->get_title()} is added to the cart.", 'addonify-wishlist' );

				// Remove product from the wishlist.
				if ( (int) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) == 1 ) {

					if ( $this->remove_from_wishlist( $product_id ) ) {

						$notice .= '<br>' . __( "{$product->get_title()} has been removed from the wishlist.", 'addonify-wishlist' );
					} else {
						$notice .= '<br>' . __( "Error removing {$product->get_title()} from the wishlist.", 'addonify-wishlist' );
					}
				}

				wc_add_notice( $notice, 'success' );

				// If redirect to checkout is enabled, redirect to checkout page.
				if (
					(int) addonify_wishlist_get_option( 'redirect_to_checkout_if_product_added_to_cart' ) == 1 &&
					get_option( 'woocommerce_checkout_page_id' )
				) {

					wp_safe_redirect( wc_get_checkout_url() );
					exit;
				}

				wp_redirect( home_url( $wp->request ) );
				exit;
			} else {

				$notice = __( "Error adding {$product->get_title()} to the cart.", 'addonify-wishlist' );

				wc_add_notice( $notice, 'error' );
			}
		}

		// Add product to the wishlist.
		if (
			isset( $_GET['addonify-add-to-wishlist'] ) &&
			! empty( $_GET['addonify-add-to-wishlist'] )
		) {
			$product_id = (int) wp_unslash( $_GET['addonify-add-to-wishlist'] );

			$product = wc_get_product( $product_id );

			if ( $this->add_to_wishlist( $product_id ) ) {

				if (
					addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) == 'redirect_to_wishlist_page' &&
					(int) addonify_wishlist_get_option( 'wishlist_page' )
				) {

					$wishlist_page_id = (int) addonify_wishlist_get_option( 'wishlist_page' );
					wp_redirect( get_permalink( $wishlist_page_id ) );
					exit;
				} else {

					$notice = '<a href="' . esc_url( get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) ) . '" class="button wc-forward" tabindex="1">' . esc_html__( 'View Wishlist', 'addonify-wishlist' ) . '</a>';

					$notice .= __( "{$product->get_title()} is added to the wishlist.", "addonify-wishlist" );

					wc_add_notice( $notice, 'success' );

					wp_redirect( home_url( $wp->request ) );
					exit;
				}
			} else {

				$notice = '<a href="' . esc_url( get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) ) . '" class="button wc-forward" tabindex="1">' . esc_html__( 'View Wishlist', 'addonify-wishlist' ) . '</a>';

				$notice .= __( "{$product->get_title()} is already in the wishlist.", "addonify-wishlist" );

				wc_add_notice( $notice, 'error' );

				if (
					addonify_wishlist_get_option( 'after_add_to_wishlist_action' ) == 'redirect_to_wishlist_page' &&
					(int) addonify_wishlist_get_option( 'wishlist_page' )
				) {

					$wishlist_page_id = (int) addonify_wishlist_get_option( 'wishlist_page' );
					wp_redirect( get_permalink( $wishlist_page_id ) );
					exit;
				} else {

					wp_redirect( home_url( $wp->request ) );
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

		do_action( 'addonify_wishlist/render_wishlist_button' );
	}

	/**
	 * Render add to wishlist button in product single.
	 *
	 * @since 1.0.0
	 */
	public function render_add_to_wishlist_button_single() {

		echo '<div class="addonify-add-to-wishlist-btn-wrapper">';
		$this->render_add_to_wishlist_button();
		echo '</div>';
	}


	/**
	 * Add product into the wishlist if product is not in the wishlist.
	 *
	 * @since 1.0.0
	 * @param int $product_id
	 * @return boolean true if added successfully otherwise false.
	 */
	public function add_to_wishlist( $product_id ) {

		if ( ! array_key_exists( $product_id, $this->wishlist_items ) ) {

			$this->wishlist_items[ $product_id ] = time();

			return $this->save_wishlist_items( $this->wishlist_items );
		}

		return false;
	}


	/**
	 * Remove product from the wishlist if product is already in the wishlist.
	 *
	 * @since 1.0.0
	 * @param int $product_id
	 * @return boolean true if removed successfully otherwise false.
	 */
	public function remove_from_wishlist( $product_id ) {

		if ( array_key_exists( $product_id, $this->wishlist_items ) ) {

			unset( $this->wishlist_items[ $product_id ] );

			return $this->save_wishlist_items( $this->wishlist_items );
		}

		return false;
	}


	/**
	 * Add product into the cart.
	 *
	 * @since 1.0.0
	 * @param int $product_id
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
			! wp_verify_nonce( $_POST['nonce'], $this->plugin_name )
		 ) {
			return wp_send_json( array(
				'success' => false,
				'message' => __( 'Missing or invalid secutiry token.', 'addonify-wishlist' )
			) );
		}

		// Check if product id is set.
		if (
			! isset( $_POST['productId'] ) ||
			empty( $_POST['productId'] )
		) {
			return wp_send_json( array(
				'success' => false,
				'message' => __( 'Missing product id.', 'addonify-wishlist' )
			) );
		}

		$product = wc_get_product( (int) wp_unslash( $_POST['productId'] ) );

		// Add product into the cart and remove product from the wishlist.
		if ( $this->add_to_cart( $product->get_id() ) ) {

			if ( (int) addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) == 1 ) {

				$this->remove_from_wishlist( $product->get_id() );
			}

			return wp_send_json( array(
				'success' => true,
				'message' => __( "{$product->get_title()} is added to cart.", "addonify-wishlist" ),
				'wishlist_count' => $this->wishlist_items_count
			) );
		}

		return wp_send_json( array(
			'success' => false,
			'message' => __( "Error adding {$product->get_title()} to the cart.", "addonify-wishlist" )
		) );
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
			! wp_verify_nonce( $_POST['nonce'], $this->plugin_name )
		 ) {
			return wp_send_json( array(
				'success' => false,
				'message' => __( 'Missing or invalid secutiry token.', 'addonify-wishlist' )
			) );
		}

		// Check if product id is set.
		if (
			! isset( $_POST['productId'] ) ||
			empty( $_POST['productId'] )
		) {
			return wp_send_json( array(
				'success' => false,
				'message' => __( 'Missing product id.', 'addonify-wishlist' )
			) );
		}

		$product = wc_get_product( (int) wp_unslash( $_POST['productId'] ) );

		// Remove product from the wishlist.
		if ( $this->remove_from_wishlist( $product->get_id() ) ) {

			return wp_send_json( array(
				'success' => true,
				'message' => __( "{$product->get_title()} is removed from wishlist.", "addonify-wishlist" ),
				'wishlist_count' => $this->wishlist_items_count
			) );
		}

		return wp_send_json( array(
			'success' => false,
			'message' => __( "Error removing {$product->get_title()} from the wishlist.", "addonify-wishlist" )
		) );
	}

	/**
	 * Callback function to handle ajax request to add product to the cart.
	 *
	 * @since 1.0.0
	 * @return array mixed.
	 */
	public function ajax_add_to_wishlist_handler() {

		$product_id = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if product id and nonce is set and valid.
		if (
			! $product_id ||
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json_error( 'Either Product ID is missing or nonce does not match' );
		}

		// Check if product is already in the wishlist.
		if ( addonify_wishlist_is_product_in_wishlist( $product_id ) ) {

			return wp_send_json(
				array(
					'success' => true,
					'message' => addonify_wishlist_get_option( 'product_already_in_wishlist_text' )
				)
			);
		}

		// Add product into the wishlist.
		$this->wishlist_items[ $product_id ] = time();

		// Save the wishlist.
		if ( $this->save_wishlist_items( $this->wishlist_items ) ) {

			$sidebar_data = addonify_wishlist_render_sidebar_product( $product_id );

			return wp_send_json(
				array(
					'success'			=> true,
					'sidebar_data' 		=> $sidebar_data,
					'wishlist_count' 	=> $this->wishlist_items_count,
					'message' 			=> addonify_wishlist_get_option( 'product_added_to_wishlist_text' )
				)
			);
		} else {
			return wp_send_json(
				array(
					'success' => false,
					'message' => __( 'Something went wrong. <br>{product_name} was not added to wishlist. Please refresh page and try again.', 'addonify-wishlist' )
				)
			);
		}
	}



	/**
	 * Save wishlist data into the user meta and cookie.
	 *
	 * @since    1.0.0
	 * @param    array $data Data to be saved as wishlist.
	 * @return 	 boolean true if saved successfully, false otherwise.
	 */
	private function save_wishlist_items( $data ) {

		$return_boolean = false;

		do_action( 'addonify_wishlist_before_adding_to_wishlist' );

		// For future update.
		/* if ( is_user_logged_in() ) {

			$return_boolean = ( $this->set_cookie( $data ) && update_user_meta( get_current_user_id(), '_' . $this->plugin_name, serialize( $data ) ) ) ? true : false;
		} else {

			$return_boolean = $this->set_cookie( $data );
		} */

		$set_wishlist_cookie_data = array(
			'last_updated' => time(),
			'wishlist_items' => $data
		);

		$return_boolean = $this->set_cookie( $set_wishlist_cookie_data );

		$this->wishlist_items_count = count( $this->wishlist_items );

		do_action( 'addonify_wishlist_after_adding_to_wishlist' );

		return $return_boolean;
	}



	/**
	 * Set cookie for wishlist into global cookie variable.
	 *
	 * @since    1.0.0
	 * @param    array $data serialized data.
	 * @return 	 boolean true if cookie is set, false otherwise.
	 */
	private function set_cookie( $wishlist_cookie_data ) {

		if (
			is_array( $wishlist_cookie_data ) &&
			isset( $wishlist_cookie_data['wishlist_items'] ) &&
			count( $wishlist_cookie_data['wishlist_items'] ) > 0
		) {
			// Set browser cookie if there are products in the wishlist.
			$cookies_lifetime = (int) addonify_wishlist_get_option( 'cookies_lifetime' ) * DAY_IN_SECONDS;

			return setcookie( $this->plugin_name, json_encode( $wishlist_cookie_data ), time() + $cookies_lifetime, COOKIEPATH, COOKIE_DOMAIN );
		} else {

			// Remove browser cookie if are no products in the wishlist.
			if ( isset( $_COOKIE[ $this->plugin_name ] ) ) {

				return setcookie( $this->plugin_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN );
			}
		}
	}


	/**
	 * Return wishlist.
	 * If cookie wishlist and user meta wishlist do not match, user meta wishlist is updated with cookie wishlist.
	 *
	 * @since    1.0.0
	 * @return  array $wishlist_items.
	 */
	public function get_wishlist() {

		$wishlist_cookie = $this->get_wishlist_from_cookies();

		$wishlist_items = isset( $wishlist_cookie['wishlist_items'] ) ? $wishlist_cookie['wishlist_items'] : array();

		/* For future update
		if ( is_user_logged_in() ) {

			$user_meta_wishlist = $this->get_wishlist_from_database();
			if ( $cookie_wishlist !== $user_meta_wishlist ) {

				$this->save_wishlist_items( $cookie_wishlist );
			}
		} */

		return $wishlist_items;
	}


	/**
	 * Return wishlist from cookies.
	 *
	 * @since    1.0.0
	 * @return 	array $wishlist_items.
	 */
	private function get_wishlist_from_cookies() {

		return isset( $_COOKIE[ $this->plugin_name ] ) ? json_decode( sanitize_text_field( wp_unslash( $_COOKIE[ $this->plugin_name ] ) ), true ) : array();
	}


	/**
	 * Return wishlist product ids in array from database
	 *
	 * @since    for future update.
	 * @return 	array $wishlist_items.
	 */
	/* private function get_wishlist_from_database() {

		$current_user_id = get_current_user_id();

		if ( $current_user_id !== 0 ) {
			$wishlist_data = get_user_meta( $current_user_id, '_' . $this->plugin_name, true );

			return $wishlist_data ? unserialize( $wishlist_data ) : array();
		}

		return array();
	} */


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
			do_action( 'addonify_wishlist/render_shortcode_content' );
		} 

			
	}


	/**
	 * Render template for showing "added to wishlist" modal
	 *
	 * @since    1.0.0
	 */
	public function wishlist_modal_wrapper() {

		do_action( 'addonify_wishlist/render_modal_wrapper' );
	}


	/**
	 * Render template for showing sticky sidebar
	 *
	 * @since    1.0.0
	 */
	public function wishlist_sidebar_template() {

		do_action( 'addonify_wishlist/render_sidebar_toggle_button' );

		do_action( 'addonify_wishlist/render_sidebar' );
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
			do_action( 'addonify_wishlist/render_sidebar_loop' );
		}		
	}


	/**
	 * Check if user meta wishlist and cookie wishlist are same.
	 * If not, then update user meta wishlist with cookie wishlist.
	 *
	 * @since    1.0.0
	 * @param    string $user_login User Login.
	 * @param    object $user User object.
	 */
	/* public function after_user_login( $user_login, $user ) {

		$wishlist_cookies = $this->get_wishlist_from_cookies();

		$user_wishlist_data = $this->get_wishlist_from_database();

		if ( $wishlist_cookies !== $user_wishlist_data ) {

			$wishlist_data = serialize( $wishlist_cookies );

			update_user_meta( $user->ID, '_' . $this->plugin_name, $wishlist_data );
		}
	} */



	/**
	 * Change redirect url after login.
	 *
	 * @since    1.0.0
	 * @param    string $redirect Redirect url.
	 */
	public function myaccount_login( $redirect ) {

		if ( isset( $_GET['addonify_wishlist_redirect'] ) && ! empty( $_GET['addonify_wishlist_redirect'] ) ) {
			$redirect = sanitize_text_field( wp_unslash( $_GET['addonify_wishlist_redirect'] ) );
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
			(int) addonify_wishlist_get_option( 'require_login' ) == 0 ||
			is_user_logged_in()
		) {
			
			$wishlist_page_url = addonify_wishlist_get_option( 'wishlist_page' ) ? get_permalink( (int) addonify_wishlist_get_option( 'wishlist_page' ) ) : '';

			$view_wishlist_button_label = addonify_wishlist_get_option( 'view_wishlist_btn_text' );

			echo apply_filters(
				'addonify_wishlist_modal_add_to_wishlist_btn',
				'<a class="adfy-wishlist-btn-link addonify-view-wishlist-btn" href="' . esc_url( $wishlist_page_url ) . '">' . $view_wishlist_button_label . '</a>'
			);
		}

		// login is required.
		// show login button.
		if (
			(int) addonify_wishlist_get_option( 'require_login' ) == 1 &&
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

		// show close button in any case.
		echo wp_kses_post(
			apply_filters(
				'addonify_wishlist_modal_close_btn',
				'<button type="button" class="adfy-wishlist-btn addonify-wishlist-close-btn" id="addonify-wishlist-close-modal-btn">' . __( 'Close', 'addonify-wishlist' ) . '</button>'
			)
		);
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
	 * Print dynamic CSS generated from settings page.
	 */
	public function dynamic_css() {

		$css_values = array(
			'--adfy_wishlist_wishlist_btn_text_color' => addonify_wishlist_get_option('wishlist_btn_text_color' ),
			'--adfy_wishlist_wishlist_btn_icon_color' => addonify_wishlist_get_option('wishlist_btn_icon_color' ),
			'--adfy_wishlist_wishlist_btn_text_color_hover' => addonify_wishlist_get_option('wishlist_btn_text_color_hover' ),
			'--adfy_wishlist_wishlist_btn_icon_color_hover' => addonify_wishlist_get_option('wishlist_btn_icon_color_hover' ),
			'--adfy_wishlist_wishlist_btn_bg_color' => addonify_wishlist_get_option('wishlist_btn_bg_color' ),
			'--adfy_wishlist_wishlist_btn_bg_color_hover' => addonify_wishlist_get_option('wishlist_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_overlay_bg_color' => addonify_wishlist_get_option('sidebar_modal_overlay_bg_color' ),
			'--adfy_wishlist_popup_modal_overlay_bg_color' => addonify_wishlist_get_option('popup_modal_overlay_bg_color' ),
			'--adfy_wishlist_popup_modal_bg_color' => addonify_wishlist_get_option('popup_modal_bg_color' ),
			'--adfy_wishlist_border_color' => addonify_wishlist_get_option('sidebar_modal_general_border_color' ),
			'--adfy_wishlist_popup_modal_icon_color' => addonify_wishlist_get_option('popup_modal_icon_color' ),
			'--adfy_wishlist_popup_modal_text_color' => addonify_wishlist_get_option('popup_modal_text_color' ),
			'--adfy_wishlist_popup_modal_btn_text_color' => addonify_wishlist_get_option('popup_modal_btn_text_color' ),
			'--adfy_wishlist_popup_modal_btn_text_color_hover' => addonify_wishlist_get_option('popup_modal_btn_text_color_hover' ),
			'--adfy_wishlist_popup_modal_btn_bg_color' => addonify_wishlist_get_option('popup_modal_btn_bg_color' ),
			'--adfy_wishlist_popup_modal_btn_bg_color_hover' => addonify_wishlist_get_option('popup_modal_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_btn_position_offset' => addonify_wishlist_get_option('sidebar_btn_position_offset' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_label_color' => addonify_wishlist_get_option('sidebar_modal_toggle_btn_label_color' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_label_color_hover' => addonify_wishlist_get_option('sidebar_modal_toggle_btn_label_color_hover' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_bg_color' => addonify_wishlist_get_option('sidebar_modal_toggle_btn_bg_color' ),
			'--adfy_wishlist_sidebar_modal_toggle_btn_bg_color_hover' => addonify_wishlist_get_option('sidebar_modal_toggle_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_bg_color' => addonify_wishlist_get_option('sidebar_modal_bg_color' ),
			'--adfy_wishlist_sidebar_modal_title_color' => addonify_wishlist_get_option('sidebar_modal_title_color' ),
			'--adfy_wishlist_sidebar_modal_empty_text_color' => addonify_wishlist_get_option('sidebar_modal_empty_text_color' ),
			'--adfy_wishlist_sidebar_modal_close_icon_color' => addonify_wishlist_get_option('sidebar_modal_close_icon_color' ),
			'--adfy_wishlist_sidebar_modal_close_icon_color_hover' => addonify_wishlist_get_option('sidebar_modal_close_icon_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_title_color' => addonify_wishlist_get_option('sidebar_modal_product_title_color' ),
			'--adfy_wishlist_sidebar_modal_product_title_color_hover' => addonify_wishlist_get_option('sidebar_modal_product_title_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_regular_price_color' => addonify_wishlist_get_option('sidebar_modal_product_regular_price_color' ),
			'--adfy_wishlist_sidebar_modal_product_sale_price_color' => addonify_wishlist_get_option('sidebar_modal_product_sale_price_color' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_label_color' => addonify_wishlist_get_option('sidebar_modal_product_add_to_cart_label_color' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_label_color_hover' => addonify_wishlist_get_option('sidebar_modal_product_add_to_cart_label_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_bg_color' => addonify_wishlist_get_option('sidebar_modal_product_add_to_cart_bg_color' ),
			'--adfy_wishlist_sidebar_modal_product_add_to_cart_bg_color_hover' => addonify_wishlist_get_option('sidebar_modal_product_add_to_cart_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_product_remove_from_wishlist_icon_color' => addonify_wishlist_get_option('sidebar_modal_product_remove_from_wishlist_icon_color' ),
			'--adfy_wishlist_sidebar_modal_product_remove_from_wishlist_icon_color_hover' => addonify_wishlist_get_option('sidebar_modal_product_remove_from_wishlist_icon_color_hover' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_label_color' => addonify_wishlist_get_option('sidebar_modal_view_wishlist_btn_label_color' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_label_color_hover' => addonify_wishlist_get_option('sidebar_modal_view_wishlist_btn_label_color_hover' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_bg_color' => addonify_wishlist_get_option('sidebar_modal_view_wishlist_btn_bg_color' ),
			'--adfy_wishlist_sidebar_modal_view_wishlist_btn_bg_color_hover' => addonify_wishlist_get_option('sidebar_modal_view_wishlist_btn_bg_color_hover' ),
			'--adfy_wishlist_sidebar_modal_notification_text_color' => addonify_wishlist_get_option('sidebar_modal_notification_text_color' ),
			'--adfy_wishlist_sidebar_modal_notification_bg_color' => addonify_wishlist_get_option('sidebar_modal_notification_bg_color' ),
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


	public function register_shortcodes() {

		
	}


	/**
	 * Require proper templates for use in front end
	 *
	 * @since    1.0.0
	 * @param    string  $template_name Name of the template.
	 * @param    boolean $require_once  Should use require_once or require ?.
	 * @param    array   $data          Data to pass to template.
	 */
	private function get_templates( $template_name, $require_once = true, $data = array() ) {

		// first look for template in themes/addonify/templates.
		$theme_path = get_template_directory() . '/addonify/addonify-wishlist/' . $template_name . '.php';
		$plugin_path = dirname( __FILE__ ) . '/templates/' . $template_name . '.php';
		$template_path = file_exists( $theme_path ) ? $theme_path : $plugin_path;

		// Extract keys from array to separate local variables.
		foreach ( $data as $data_key => $data_val ) {
			$$data_key = $data_val;
		}

		if ( $require_once ) {
			require_once $template_path;
		} else {
			require $template_path;
		}
	}
}
