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

		$this->public_init();
	}

	/**
	 * Public init.
	 */
	public function public_init() {

		if ( (int) addonify_wishlist_get_option( 'enable_wishlist' ) !== 1 ) {
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

		add_action( 'woocommerce_add_to_cart', array( $this, 'remove_item_from_wishlist' ), 10, 2 );

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

		add_action( 'wp_footer', array( $this, 'wishlist_modal_wrapper' ) );
		add_action( 'wp_footer', array( $this, 'wishlist_sidebar_template' ) );

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

		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );

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

		add_action( 'wp_ajax_addonify_guest_add_to_wishlist_action', array( $this, 'guest_add_to_wishlist_action_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_guest_add_to_wishlist_action', array( $this, 'guest_add_to_wishlist_action_handler' ) );

		add_action( 'wp_ajax_addonify_guest_remove_from_wishlist_action', array( $this, 'guest_remove_from_wishlist_action_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_guest_remove_from_wishlist_action', array( $this, 'guest_remove_from_wishlist_action_handler' ) );

		add_action( 'wp_ajax_addonify_remove_from_wishlist', array( $this, 'ajax_remove_from_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_remove_from_wishlist', array( $this, 'ajax_remove_from_wishlist_handler' ) );

		add_action( 'wp_ajax_addonify_empty_wishlist', array( $this, 'ajax_empty_wishlist_handler' ) );
		add_action( 'wp_ajax_nopriv_addonify_empty_wishlist', array( $this, 'ajax_empty_wishlist_handler' ) );

		add_action( 'wp_ajax_addonify_get_initial_wishlist_content', array( $this, 'guest_initial_wishlist_content' ) );
		add_action( 'wp_ajax_nopriv_addonify_get_initial_wishlist_content', array( $this, 'guest_initial_wishlist_content' ) );

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

		$script_object = apply_filters(
			'addonify_wishlist_js_object',
			array(
				'ajax_url'                              => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'                                 => wp_create_nonce( $this->plugin_name ),
				'removeAlreadyAddedProductFromWishlist' => (bool) addonify_wishlist_get_option( 'remove_already_added_product_from_wishlist' ),
				'removeFromWishlistAfterAddedToCart'    => addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ),
				'afterAddToWishlistAction'              => addonify_wishlist_get_option( 'after_add_to_wishlist_action' ),
				'wishlistPageURL'                       => addonify_wishlist_get_wishlist_page_url(),
				'undoNoticeTimeout'                     => addonify_wishlist_get_option( 'undo_notice_timeout' ),
				'addedToWishlistText'                   => addonify_wishlist_get_option( 'btn_label_when_added_to_wishlist' ),
				'initialAddToWishlistButtonLabel'       => addonify_wishlist_get_option( 'btn_label' ),
				'loader'                                => $this->get_loader(),
				'alreadyInWishlistModal'                => $this->already_in_wishlist_modal(),
			)
		);

		if ( addonify_wishlist_get_option( 'enable_save_for_later' ) === '1' ) {
			$script_object['saveForLaterButtonLabel']  = addonify_wishlist_get_option( 'save_for_later_btn_label' );
			$script_object['savedForLaterButtonLabel'] = addonify_wishlist_get_option( 'save_for_later_btn_label_after_added_to_wishlist' );
		}

		if ( ! is_user_logged_in() ) {

			$login_url = ( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : wp_login_url();

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

			$script_object['guestAddToWishlistAction']        = 'addonify_guest_add_to_wishlist_action';
			$script_object['guestRemoveFromWishlistAction']   = 'addonify_guest_remove_from_wishlist_action';
			$script_object['requireLogin']                    = (bool) addonify_wishlist_get_option( 'require_login' );
			$script_object['addedToWishlistButtonLabel']      = addonify_wishlist_get_option( 'btn_label_if_added_to_wishlist' );
			$script_object['initialWishlistContentGetAction'] = 'addonify_get_initial_wishlist_content';
			$script_object['thisSiteUrl']                     = get_site_url();
			$script_object['isLoginRequired']                 = addonify_wishlist_get_option( 'require_login' );
			$script_object['loginRequiredModal']              = $this->login_required_modal();
			$script_object['ifNotLoginAction']                = addonify_wishlist_get_option( 'if_not_login_action' );
			$script_object['loginURL']                        = $login_url;
			$script_object['addedToWishlistModal']            = $this->added_to_wishlist_modal();
			$script_object['alreadyInWishlistModal']          = $this->already_in_wishlist_modal();
			$script_object['errorAddingToWishlistModal']      = $this->error_adding_to_wishlist_modal();
			$script_object['errorRemovingFromWishlistModal']  = $this->error_removing_from_wishlist_modal();
			$script_object['removedFromWishlistModal']        = $this->removed_from_wishlist_modal();
		} else {
			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'assets/build/js/conditional/addonify-wishlist-public.min.js',
				array( 'jquery' ),
				$this->version,
				true
			);

			$script_object['addToWishlistAction']      = 'addonify_add_to_wishlist';
			$script_object['removeFromWishlistAction'] = 'addonify_remove_from_wishlist';
			$script_object['emptyWishlistAction']      = 'addonify_empty_wishlist';
		}

		wp_localize_script(
			$this->plugin_name,
			'addonifyWishlistJSObject',
			$script_object
		);
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
	 * Add wishlist table and sidebar content in cart fragments.
	 *
	 * @since 2.0.6
	 *
	 * @param array $fragments Cart fragments.
	 */
	public function add_to_cart_fragments( $fragments ) {

		if ( is_user_logged_in() ) {

			$fragments['tableContent'] = $this->get_wishlist_page_loop_content();
			$fragments['itemsCount']   = addonify_wishlist_get_wishlist_items_count();

			if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
				$fragments['sidebarContent'] = $this->get_wishlist_sidebar_loop_content();
			}
		}

		return $fragments;
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
	 * Callback function to handle ajax request to remove product from the cart.
	 *
	 * @since 1.0.0
	 */
	public function ajax_remove_from_wishlist_handler() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-nonce' ) );
		}

		$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

		if ( ! $product_id ) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-product-id' ) );
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-product' ) );
		}

		$button_source = isset( $_POST['source'] ) ? sanitize_text_field( wp_unslash( $_POST['source'] ) ) : '';

		if ( ! addonify_wishlist_is_product_in_wishlist( $product_id ) ) {

			$response_data = array(
				'success'     => false,
				'productName' => $product->get_name(),
			);

			if ( 'add-to-wishlist' === $button_source ) {
				$response_data['modalContent'] = addonify_wishlist_get_ajax_modal_content(
					array(
						'message' => sprintf(
							/* translators: %1$s Product name */
							esc_html__( '%1$s does not exist in the wishlist.', 'addonify-wishlist' ),
							$product->get_name()
						),
					)
				);
			} else {
				$response_data['message'] = sprintf(
					/* translators: %1$s Product name */
					esc_html__( '%1$s does not exist in the wishlist.', 'addonify-wishlist' ),
					$product->get_name()
				);
			}

			wp_send_json(
				apply_filters(
					'addonify_wishlist_ajax_remove_from_wishlist_error_response',
					$response_data
				)
			);
		}

		// Remove product from the wishlist.
		if ( addonify_wishlist_remove_product_from_wishlist( $product->get_id() ) ) {

			$response_data = array(
				'success'     => true,
				'itemsCount'  => addonify_wishlist_get_wishlist_items_count(),
				'undoContent' => $this->get_product_removal_undo_notice( $product ),
				'productName' => $product->get_name(),
			);

			if ( 'add-to-wishlist' === $button_source ) {
				$response_data['modalContent'] = addonify_wishlist_get_ajax_modal_content(
					array(
						'icon'    => apply_filters(
							'addonify_wishlist_success_modal_icon',
							'<i class="adfy-wishlist-icon adfy-status-success heart-o-style-three"></i>'
						),
						'message' => sprintf(
							/* translators: %1$s Product name */
							esc_html__( '%1$s has been removed from wishlist.', 'addonify-wishlist' ),
							$product->get_name()
						),
					)
				);
			}

			if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
				$response_data['sidebarContent'] = $this->get_wishlist_sidebar_loop_content();
			}

			$response_data['tableContent'] = $this->get_wishlist_page_loop_content();

			wp_send_json(
				apply_filters(
					'addonify_wishlist_ajax_remove_from_wishlist_success_response',
					$response_data
				)
			);
		} else {

			$could_not_be_removed_from_wishlist_text = addonify_wishlist_get_option( 'could_not_remove_from_wishlist_error_description' );

			if ( str_contains( $could_not_be_removed_from_wishlist_text, '{product_name}' ) ) {
				$could_not_be_removed_from_wishlist_text = str_replace( '{product_name}', $product->get_name(), $could_not_be_removed_from_wishlist_text );
			}

			$response_data = array(
				'success'     => false,
				'productName' => $product->get_name(),
			);

			if ( 'add-to-wishlist' === $button_source ) {
				$response_data['modalContent'] = addonify_wishlist_get_ajax_modal_content(
					array(
						'message' => $could_not_be_removed_from_wishlist_text,
					)
				);
			} else {
				$response_data['message'] = $could_not_be_removed_from_wishlist_text;
			}

			wp_send_json(
				apply_filters(
					'addonify_wishlist_ajax_remove_from_wishlist_error_response',
					$response_data
				)
			);
		}
	}


	/**
	 * Callback function to handle ajax request to add product to the cart.
	 *
	 * @since 1.0.0
	 */
	public function ajax_add_to_wishlist_handler() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-nonce' ) );
		}

		$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

		if ( ! $product_id ) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-product-id' ) );
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-product' ) );
		}

		// Check if product is already in the wishlist.
		if ( addonify_wishlist_is_product_in_wishlist( $product_id ) ) {

			$already_in_wishlist_text = addonify_wishlist_get_option( 'product_already_in_wishlist_text' );

			if ( str_contains( $already_in_wishlist_text, '{product_name}' ) ) {
				$already_in_wishlist_text = str_replace( '{product_name}', $product->get_name(), $already_in_wishlist_text );
			}

			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_success_response',
				array(
					'success'      => false,
					'message'      => esc_html( $already_in_wishlist_text ),
					'productName'  => $product->get_name(),
					'modalContent' => addonify_wishlist_get_ajax_modal_content(
						array(
							'icon'           => apply_filters(
								'addonify_wishlist_already_in_wishlist_modal_icon',
								'<i class="adfy-wishlist-icon adfy-status-success heart-style-one"></i>'
							),
							'message'        => $already_in_wishlist_text,
							'button_content' => addonify_wishlist_get_modal_button_content( 'wishlist-link' ),
						)
					),
				)
			);

			wp_send_json( $ajax_add_to_wishlist_return );
		}

		// Save the wishlist.
		if ( addonify_wishlist_add_product_to_wishlist( $product_id ) ) {

			$added_to_wishlist_text = addonify_wishlist_get_option( 'product_added_to_wishlist_text' );

			if ( str_contains( $added_to_wishlist_text, '{product_name}' ) ) {
				$added_to_wishlist_text = str_replace( '{product_name}', $product->get_name(), $added_to_wishlist_text );
			}

			$response_data = array(
				'success'      => true,
				'productName'  => $product->get_name(),
				'itemsCount'   => addonify_wishlist_get_wishlist_items_count(),
				'message'      => esc_html( $added_to_wishlist_text ),
				'modalContent' => addonify_wishlist_get_ajax_modal_content(
					array(
						'icon'           => apply_filters(
							'addonify_wishlist_added_to_wishlist_modal_icon',
							'<i class="adfy-wishlist-icon adfy-status-success heart-style-one"></i>'
						),
						'message'        => $added_to_wishlist_text,
						'button_content' => addonify_wishlist_get_modal_button_content( 'wishlist-link' ),
					)
				),
			);

			if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
				$response_data['sidebarContent'] = $this->get_wishlist_sidebar_loop_content();
			}

			$response_data['tableContent'] = $this->get_wishlist_page_loop_content();

			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_success_response',
				$response_data
			);

			wp_send_json( $ajax_add_to_wishlist_return );
		} else {

			$error_adding_to_wishlist_text = addonify_wishlist_get_option( 'could_not_add_to_wishlist_error_description' );

			if ( str_contains( $error_adding_to_wishlist_text, '{product_name}' ) ) {
				$error_adding_to_wishlist_text = str_replace( '{product_name}', $product->get_name(), $error_adding_to_wishlist_text );
			}
			$ajax_add_to_wishlist_return = apply_filters(
				'addonify_wishlist_ajax_add_to_wishlist_error_response',
				array(
					'success'      => false,
					'message'      => esc_html( $error_adding_to_wishlist_text ),
					'productName'  => $product->get_name(),
					'modalContent' => addonify_wishlist_get_ajax_modal_content(
						array(
							'message' => $error_adding_to_wishlist_text,
						)
					),
				)
			);

			wp_send_json( $ajax_add_to_wishlist_return );
		}
	}


	/**
	 * Empty wishlist
	 */
	public function ajax_empty_wishlist_handler() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json( addonify_wishlist_get_error_ajax_response( 'invalid-nonce' ) );
		}

		if ( addonify_wishlist_empty_wishlist() ) {
			wp_send_json(
				apply_filters(
					'addonify_wishlist_ajax_empty_wishlist_success_response',
					array(
						'success'      => true,
						'tableContent' => $this->get_wishlist_page_loop_content(),
						'modalContent' => addonify_wishlist_get_ajax_modal_content(
							array(
								'icon'    => apply_filters(
									'addonify_wishlist_success_modal_icon',
									'<i class="adfy-wishlist-icon adfy-status-success check"></i>'
								),
								'message' => addonify_wishlist_get_option( 'wishlist_emptied_text' ),
							)
						),
					)
				)
			);
		} else {
			wp_send_json(
				apply_filters(
					'addonify_wishlist_ajax_empty_wishlist_error_response',
					array(
						'success'      => false,
						'modalContent' => addonify_wishlist_get_ajax_modal_content(
							array(
								'message' => esc_html__( 'Error emptying the wishlist!', 'addonify-wishlist' ),
							)
						),
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

		return addonify_wishlist_get_user_default_wishlist();
	}


	/**
	 * Created default wishlist if does not exists.
	 */
	private function maybe_create_default_wishlist() {

		if ( is_user_logged_in() ) {

			if ( ! addonify_wishlist_get_user_default_wishlist() ) {
				global $addonify_wishlist;
				$addonify_wishlist->seed_wishlist_table( $this->default_wishlist );
			}

			$user_default_wishlist_meta = addonify_wishlist_get_user_default_wishlist_from_meta( get_current_user_id() );

			if ( ! $user_default_wishlist_meta ) {
				$user_default_wishlist = addonify_wishlist_get_user_default_wishlist();
				addonify_wishlist_set_user_default_wishlist_in_meta( get_current_user_id(), $user_default_wishlist );
			}
		}
	}


	/**
	 * Migrate to table if not migrated already.
	 */
	private function maybe_migrate_metadata_to_table() {

		global $addonify_wishlist;

		$addonify_wishlist->migrate_wishlist_data();
	}


	/**
	 * Gather shortcode contents and display template
	 *
	 * @since    1.0.0
	 */
	public function get_shortcode_contents() {

		ob_start();
		do_action( 'addonify_wishlist_render_shortcode_content' );
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

		$class = 'adfy-wishlist-btn addonify_wishlist-cart-item-add-to-wishlist addonify-wishlist-save-for-later';

		$attrs = array(
			'id'    => $product_id,
			'class' => $class,
			'label' => addonify_wishlist_get_option( 'save_for_later_btn_label' ),
		);

		if ( addonify_wishlist_is_product_in_wishlist( $product_id ) ) {
			$attrs['label'] = addonify_wishlist_get_option( 'save_for_later_btn_label_after_added_to_wishlist' );
		}

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
	 * AJAX request handler that returns wishlist sidebar and table content when pages are loaded.
	 *
	 * @since 2.0.6
	 */
	public function guest_initial_wishlist_content() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Invalid security token.', 'addonify-wishlist' ),
				)
			);
		}

		$wishlist_items = isset( $_POST['product_ids'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['product_ids'] ) ), true ) : array();

		$response_data = array(
			'success' => true,
		);

		ob_start();
		do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_items );
		$response_data['tableContent'] = ob_get_clean();

		if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
			ob_start();
			do_action( 'addonify_wishlist_render_sidebar_loop', $wishlist_items );
			$response_data['sidebarContent'] = ob_get_clean();
		}

		wp_send_json( $response_data );
	}

	/**
	 * AJAX request handler that returns wishlist sidebar and table content when a product is added into the
	 * wishlist.
	 *
	 * @since 2.0.6
	 */
	public function guest_add_to_wishlist_action_handler() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Invalid security token.', 'addonify-wishlist' ),
				)
			);
		}

		$wishlist_items = isset( $_POST['product_ids'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['product_ids'] ) ), true ) : array();

		$response_data = array(
			'success' => true,
		);

		if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
			ob_start();
			do_action( 'addonify_wishlist_render_sidebar_loop', $wishlist_items );
			$response_data['sidebarContent'] = ob_get_clean();
		}

		ob_start();
		do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_items );
		$response_data['tableContent'] = ob_get_clean();

		wp_send_json( $response_data );
	}

	/**
	 * AJAX request handler that returns wishlist sidebar and table content when a product is remved from the
	 * wishlist.
	 *
	 * @since 2.0.6
	 */
	public function guest_remove_from_wishlist_action_handler() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Invalid security token.', 'addonify-wishlist' ),
				)
			);
		}

		$wishlist_items = isset( $_POST['product_ids'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['product_ids'] ) ), true ) : array();

		$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;

		if ( ! $product_id ) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Invalid product id.', 'addonify-wishlist' ),
				)
			);
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Invalid product.', 'addonify-wishlist' ),
				)
			);
		}

		$response_data = array(
			'success' => true,
		);

		if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
			ob_start();
			do_action( 'addonify_wishlist_render_sidebar_loop', $wishlist_items );
			$response_data['sidebarContent'] = ob_get_clean();
		}

		ob_start();
		do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_items );
		$response_data['tableContent'] = ob_get_clean();

		$response_data['undoContent'] = $this->get_product_removal_undo_notice( $product );

		wp_send_json( $response_data );
	}


	/**
	 * Returns HTML content of items in wishlist sidebar.
	 *
	 * @since 1.0.0
	 */
	public function addonify_wishlist_get_wishlist_sidebar_loop_content() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

		// Check if nonce is set and valid.
		if (
			! $nonce ||
			! wp_verify_nonce( $nonce, $this->plugin_name )
		) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Invalid security token.', 'addonify-wishlist' ),
				)
			);
		}

		$wishlist_items = isset( $_POST['product_ids'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['product_ids'] ) ), true ) : '';

		if ( ! $wishlist_items ) {
			wp_send_json(
				array(
					'success' => false,
					'error'   => 'e1',
					'message' => esc_html__( 'Missing product ids.', 'addonify-wishlist' ),
				)
			);
		}

		$response_data = array(
			'success' => true,
		);

		if ( addonify_wishlist_get_option( 'show_sidebar' ) === '1' ) {
			ob_start();
			do_action( 'addonify_wishlist_render_sidebar_loop', $wishlist_items );
			$response_data['sidebarContent'] = ob_get_clean();
		}

		ob_start();
		do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_items );
		$response_data['tableContent'] = ob_get_clean();

		wp_send_json( $response_data );
	}


	/**
	 * Removes product from wishlist when product is added into the cart.
	 *
	 * @since 1.0.0
	 *
	 * @param string $cart_item_key Cart item key.
	 * @param int    $product_id Product id.
	 */
	public function remove_item_from_wishlist( $cart_item_key, $product_id ) {

		if (
			is_user_logged_in() &&
			addonify_wishlist_get_option( 'remove_from_wishlist_if_added_to_cart' ) === '1'
		) {
			addonify_wishlist_remove_product_from_wishlist( $product_id );
		}
	}


	/**
	 * Returns the HTML of a product added to wishlist modal.
	 *
	 * @since 2.0.6
	 */
	public function added_to_wishlist_modal() {
		ob_start();
		do_action( 'addonify_wishlist_render_added_to_wishlist_modal' );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML of product already in the wishlist modal.
	 *
	 * @since 2.0.6
	 */
	public function already_in_wishlist_modal() {
		ob_start();
		do_action( 'addonify_wishlist_render_already_in_wishlist_modal' );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML of login required modal.
	 *
	 * @since 2.0.6
	 */
	public function login_required_modal() {
		ob_start();
		do_action( 'addonify_wishlist_render_login_required_modal' );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML of error modal when adding a product to wishlist.
	 *
	 * @since 2.0.6
	 */
	public function error_adding_to_wishlist_modal() {
		ob_start();
		do_action( 'addonify_wishlist_render_error_adding_to_wishlist_modal' );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML of error modal when removing a product from wishlist.
	 *
	 * @since 2.0.6
	 */
	public function error_removing_from_wishlist_modal() {
		ob_start();
		do_action( 'addonify_wishlist_render_error_removing_from_wishlist_modal' );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML of modal when a product is removed from wishlist.
	 *
	 * @since 2.0.6
	 */
	public function removed_from_wishlist_modal() {
		ob_start();
		do_action( 'addonify_wishlist_render_removed_from_wishlist_modal' );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML content of wishlist items in the wishlist sidebar.
	 *
	 * @since 2.0.6
	 */
	public function get_wishlist_sidebar_loop_content() {

		$wishlist_product_ids = addonify_wishlist_get_default_wishlist_items_for_loop();

		ob_start();
		do_action( 'addonify_wishlist_render_sidebar_loop', $wishlist_product_ids );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML content of wishlist items in the wishlist page.
	 *
	 * @since 2.0.6
	 */
	public function get_wishlist_page_loop_content() {

		$wishlist_product_ids = addonify_wishlist_get_default_wishlist_items_for_loop();

		ob_start();
		do_action( 'addonify_wishlist_render_wishlist_page_loop', $wishlist_product_ids );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML for product removal undo notice.
	 *
	 * @since 2.0.6
	 *
	 * @param object $product WC_Product.
	 */
	public function get_product_removal_undo_notice( $product ) {

		ob_start();
		do_action( 'addonify_wishlist_render_product_removal_undo_notice', $product );
		return ob_get_clean();
	}


	/**
	 * Returns the HTML for loader.
	 *
	 * @since 2.0.6
	 */
	public function get_loader() {
		ob_start();
		do_action( 'addonify_wishlist_render_loader' );
		return ob_get_clean();
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
