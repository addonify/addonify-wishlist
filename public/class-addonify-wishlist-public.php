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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/public
 * @author     Adodnify <info@addonify.com>
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
	 * State of the plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $enable_plugin    The current state of the plugin
	 */
	private $enable_plugin = 1;

	/**
	  * Wishlist Button Position
	  *
	  * @since    1.0.0
	  * @access   private
	  * @var      string    $btn_position    Display Position for the Compare button
	  */
	private $btn_position;
 
	/**
	  * Wishlist Button Label
	  *
	  * @since    1.0.0
	  * @access   private
	  * @var      string    $btn_label    Label for the Wishlist button
	  */
	private $btn_label;


	/**
	  * Custom CSS class name for "add to wishlist" button
	  *
	  * @since    1.0.0
	  * @access   private
	  * @var      string    $button_custom_css_class
	  */
	private $button_custom_css_class;

	/**
	  * wishlist_page_id
	  *
	  * @since    1.0.0
	  * @access   private
	  * @var      string    $button_custom_css_class
	  */
	private $wishlist_page_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		if( ! is_admin() ){
			
			$default_wishlist_page_id 	= get_option( ADDONIFY_WISHLIST_DB_INITIALS .'page_id' );
			$this->wishlist_page_id		= get_option( ADDONIFY_WISHLIST_DB_INITIALS .'wishlist_page', $default_wishlist_page_id );


			$this->btn_position 			=  $this->get_db_values('btn_position', 'after_add_to_cart' );
			$this->btn_label 				= $this->get_db_values( 'btn_label', __( 'Add to Wishlist', 'addonify-wishlist' ) );
			$this->button_custom_css_class	= $this->get_db_values( 'btn_custom_class' );

			// $this->register_shortcode();


		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/css/addonify-wishlist-public.css', array(), time(), 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/build/js/addonify-wishlist-public.min.js', array( 'jquery' ), time(), false );

		

		// localize script
		wp_localize_script( 
			$this->plugin_name, 
			'addonify_wishlist_object', 
			array( 
				'ajax_url' 								=> admin_url( 'admin-ajax.php' ),
				'action'								=> 'add_to_wishlist',
				'nonce'									=> wp_create_nonce( $this->plugin_name ),
				'wishlist_page_url'						=> get_page_link( $this->wishlist_page_id ),
				// 'view_wishlist_btn_text'				=> $this->get_db_values( 'view_wishlist_btn_text' ),
				'product_added_to_wishlist_text' 		=> $this->get_db_values( 'product_added_to_wishlist_text', __( 'added to Wishlist', 'addonify-wishlist' ) ),
				'product_already_in_wishlist_text' 		=> $this->get_db_values( 'product_already_in_wishlist_text', __( 'added to Wishlist', 'addonify-wishlist' ) ),
			)			
		);

	}



	/**
	 * Show button after "cart to cart" button
	 *
	 * @since    1.0.0
	 */
	public function show_btn_after_add_to_cart_btn_callback(){

		if( $this->btn_position == 'after_add_to_cart'  ) {
			$this->show_btn_markups( 'after-add-to-cart' );
		}
	}

	

	
	/**
	 * Show button before "add to cart" button
	 *
	 * @since    1.0.0
	 */
	public function show_btn_before_add_to_cart_btn_callback(){
		if( $this->btn_position == 'before_add_to_cart'  ) {
			$this->show_btn_markups( 'before-add-to-cart' );
		}
	}



	/**
	 * Show button on top of image
	 *
	 * @since    1.0.0
	 */
	public function show_btn_aside_image_callback(){

		if( $this->btn_position != 'overlay_on_image' ) return;
		$this->show_btn_markups( 'addonify-overlay-btn overlay-on-image' );

	}



	/**
	 * Generate "add to wishlist" button content
	 *
	 * @since    1.0.0
	 * @param    $extra_css_class    CSS classes to be passed into templates
	 */
	private function show_btn_markups( $extra_css_class = '' ) {

		global $product;
		$product_id = $product->get_id();

		$css_class 				= array();
		$css_class[] 			= $extra_css_class;
		$css_class[] 			= $this->button_custom_css_class;

		if( $this->btn_label ) 								$css_class[] = 'show-label';
		if( $this->get_db_values('show_icon') ) 			$css_class[] = 'show-icon';
		if( $this->is_item_in_cookies( $product_id ) ) 		$css_class[] = 'added-to-wishlist';

		if( ! $this->btn_label && ! $this->get_db_values('show_icon')  ) return;

		ob_start();
		$this->get_templates( 'addonify-add-to-wishlist-button', false, array( 'product_id' => $product_id, 'label' => $this->btn_label, 'css_class' => implode(' ', $css_class ), 'name' => $product->get_title(), 'btn_position' => $this->btn_position ) );
		echo ob_get_clean();

	}



	/**
	 * Ajax callback function
	 * Adds items to wishlist cookie
	 * Returns markups for selected product to show in sticky sidebar
	 *
	 * @since    1.0.0
	 */
	public function add_to_wishlist_callback(){

		$product_id = $_POST['id'];
		$nonce 		= $_POST['nonce'];

		if( ! $product_id || ! $nonce || ! wp_verify_nonce( $nonce, $this->plugin_name ) ){
			wp_send_json_error( 'Either Product ID is missing or nonce does not match' );
		}

		$wishlist_cookies = $this->get_all_wishlist();

		if( ! array_key_exists( $product_id, $wishlist_cookies ) ){
			$wishlist_cookies[ $product_id ] = time();
			$this->save_wishlist_data( $wishlist_cookies );
		}

		wp_send_json_success( $this->get_sticky_sidebar_loop( array( $product_id => time() ) ) );
	}



	/**
	 * fetch wishlist data from database and generate cookies from it
	 * Runs on "Init" hook
	 *
	 * @since    1.0.0
	 */
	// public function generate_cookies(){

	// 	if( ! is_user_logged_in() ) return;
		
	// 	$wishlist_data = $this->get_wishlist_from_database( false ); //get_user_meta( get_current_user_id(), '_'.$this->plugin_name, true );

	// 	if( ! empty( $wishlist_data ) ) {
	// 		$this->set_cookie( $wishlist_data );
	// 	}

	// }
	


	/**
	 * Save wishlist data into database and cookies
	 *
	 * @since    1.0.0
	 * @param    $data    data to be saved in database and cookies
	 */
	private function save_wishlist_data( $data ) {

		$data = serialize( $data );

		// add data to user cookies
		$this->set_cookie( $data );

		// if user is logged in then save same data into database
		if( is_user_logged_in() ){
			$user_id = get_current_user_id();
			update_user_meta( $user_id, '_' . $this->plugin_name, $data );
		}

	}



	/**
	 * Set cookie for wishlist into global cookies variables
	 *
	 * @since    1.0.0
	 * @param    $data    data to be inserted in cookies variables
	 */
	private function set_cookie( $data ) {

		// add data to user cookies
		$cookies_lifetime = $this->get_db_values('cookies_lifetime', 30 ) * DAY_IN_SECONDS;
		setcookie( $this->plugin_name, $data, time() + $cookies_lifetime, COOKIEPATH, COOKIE_DOMAIN );

	}



	/**
	 * Check if item is in cookie variable
	 *
	 * @since    1.0.0
	 * @param    $product_id    Product ID
	 */
	private function is_item_in_cookies( $product_id ){
		$wishlist_cookies = $this->get_all_wishlist();
		if( array_key_exists( $product_id, $wishlist_cookies ) ) return true;
		return false;

	}


	/**
	 * Return wishlist product ids in array from cookie or return empty array
	 *
	 * @since    1.0.0
	 * @param    $product_id    Product ID
	 */
	public function get_all_wishlist(){

		$wishlist_from_cookies 	= $this->get_wishlist_from_cookies();
		$wishlist_from_db 		= $this->get_wishlist_from_database();
		
		return array_replace( $wishlist_from_db, $wishlist_from_cookies );
	}


	/**
	 * Return wishlist product ids in array from cookie or return empty array
	 *
	 * @since    1.0.0
	 * @param    $product_id    Product ID
	 */
	private function get_wishlist_from_cookies(){
		return isset( $_COOKIE[ $this->plugin_name ] ) ? unserialize( $_COOKIE[ $this->plugin_name ] )  : array();
	}


	/**
	 * Return wishlist product ids in array from database
	 *
	 * @since    1.0.0
	 * @param    $product_id    Product ID
	 */
	private function get_wishlist_from_database( $return_unserialized = true, $user_id = null ){

		if( empty( $user_id ) ) $user_id = get_current_user_id();

		$data = get_user_meta( $user_id, '_'.$this->plugin_name, true );

		if( $return_unserialized ){
			return ( ! empty( $data ) ) ? unserialize( $data )  : array();
		}

		return ( ! empty( $data ) ) ?  $data  : array();
	}



	/**
	 * Generate custom style tag and print it in header of the website
	 *
	 * @since    1.0.0
	 */
	public function generate_custom_styles_callback(){

		// do not continue if plugin styles are disabled by user
		if( ! $this->get_db_values( 'load_styles_from_plugin' ) ) return;

		return;


		// add table styles into body class
		add_filter( 'body_class', function( $classes ) {
			return array_merge( $classes, array( 'addonify-compare-table-style-' . $this->get_db_values('table_style') ) );
		} );


		$custom_css = $this->get_db_values('custom_css');

		$style_args = array(
			'button.addonify-cp-button' => array(
				'background' 	=> 'compare_btn_bck_color',
				'color' 		=> 'compare_btn_text_color',
				'left' 			=> 'wishlist_btn_left_offset',
				'right' 		=> 'wishlist_btn_right_offset',
				'top' 			=> 'wishlist_btn_top_offset',
				'bottom'		=> 'wishlist_btn_bottom_offset'
			),
			'#addonify-compare-modal, #addonify-compare-search-modal' => array(
				'background' 	=> 'modal_overlay_bck_color'
			),
			'.addonify-compare-model-inner, .addonify-compare-search-model-inner' => array(
				'background' 	=> 'modal_bck_color',
			),
			'#addonofy-compare-products-table th a' => array(
				'color'		 	=> 'table_title_color',
			),
			'.addonify-compare-all-close-btn svg' => array(
				'color' 		=> 'close_btn_text_color',
			),
			'.addonify-compare-all-close-btn' => array(
				'background'	=> 'close_btn_bck_color',
			),
			'.addonify-compare-all-close-btn:hover svg' => array(
				'color'		 	=> 'close_btn_text_color_hover',
			),
			'.addonify-compare-all-close-btn:hover' => array(
				'background' 	=> 'close_btn_bck_color_hover',
			),
			
		);

		$custom_styles_output = $this->generate_styles_markups( $style_args );

		// avoid empty style tags
		if( $custom_styles_output || $custom_css ){
			echo "<style id=\"addonify-wishlist-styles\"  media=\"screen\"> \n" . $custom_styles_output .  $custom_css . "\n </style>\n";
		}

	}




	/**
	 * Generate style markups
	 *
	 * @since    1.0.0
	 * @param    $style_args    Style args to be processed
	 */
	private function generate_styles_markups( $style_args ){
		$custom_styles_output = '';
		foreach($style_args as $css_sel => $property_value){

			$properties = '';

			foreach( $property_value as $property => $db_field){

				$css_unit = '';

				if( is_array($db_field) ){
					$db_value = $this->get_db_values( $db_field[0] );
					$css_unit = $db_field[1];
				}
				else{
					$db_value = $this->get_db_values( $db_field );
				}
					
				if( $db_value ){
					$properties .=  $property . ': ' . $db_value . $css_unit . '; ';
				}

			}
			
			if( $properties ){
				$custom_styles_output .= $css_sel . '{' . $properties . '}';
			}

		}

		return $custom_styles_output;
	}


	
	/**
	 * Print opening tag of image overlay container
	 *
	 * @since    1.0.0
	 */
	public function addonify_overlay_container_start_callback(){

		// do not continue if overlay is already added by another addonify plugin
		if( defined('ADDONIFY_OVERLAY_IS_ADDED') && ADDONIFY_OVERLAY_ADDED_BY != 'wishlist' ) return;
		
		if( $this->btn_position == 'overlay_on_image' ){

			if( ! defined('ADDONIFY_OVERLAY_IS_ADDED')) {
				define('ADDONIFY_OVERLAY_IS_ADDED', 1);
			}

			if( ! defined('ADDONIFY_OVERLAY_ADDED_BY')) {
				define('ADDONIFY_OVERLAY_ADDED_BY', 'wishlist' );
			}

			echo '<div class="addonify-overlay-buttons">';
		}
	}



	/**
	 * Print closing tag of the image overlay container
	 *
	 * @since    1.0.0
	 */
	public function addonify_overlay_container_end_callback(){

		// do not continue of overlay is alrady added by another addonify plugin
		if( defined('ADDONIFY_OVERLAY_IS_ADDED') && ADDONIFY_OVERLAY_ADDED_BY != 'wishlist' ) return;
		
		if( $this->btn_position == 'overlay_on_image' ){
			echo '</div>';
		}

	}



	/**
	 * Get Database values for selected fields
	 *
	 * @since    1.0.0
	 * @param    $field_name    Database Option Name
	 * @param    $default		Default Value
	 */
	private function get_db_values($field_name, $default = NULL ){
		return get_option( ADDONIFY_WISHLIST_DB_INITIALS . $field_name, $default );
	}



	/**
	 * Require proper templates for use in front end
	 *
	 * @since    1.0.0
	 * @param    $template_name		Name of the template
	 * @param    $require_once		Should use require_once or require ?
	 * @param    $data				Data to pass to template
	 */
	private function get_templates( $template_name, $require_once = true, $data = array() ){

		// first look for template in themes/addonify/templates
		$theme_path = get_template_directory() . '/addonify/' . $template_name .'.php';
		$plugin_path = dirname( __FILE__ ) .'/templates/' . $template_name .'.php';
		$template_path = file_exists( $theme_path ) ? $theme_path : $plugin_path;

		if( $require_once ){
			require_once $template_path;
		}
		else{
			require $template_path;
		}
	
	}


	/**
	 * Register shortcode to use in comparision page
	 * Runs on "Init" hook
	 *
	 * @since    1.0.0
	 */
	public function register_shortcode(){
		add_shortcode( 'addonify_wishlist', array( $this, 'get_shortcode_contents' ) );
	}



	/**
	 * Gather shortcode contents and display template
	 *
	 * @since    1.0.0
	 */
	public function get_shortcode_contents(){

		$wishlist_items = $this->get_all_wishlist();
		$output_data 	= $this->generate_contents_data( $wishlist_items);
		$wishlist_name 	= $this->get_db_values('default_wishlist_name', __( 'My Wishlist', 'addonify-wishlist' ) );

		ob_start();
		$this->get_templates( 'addonify-wishlist-contents', false, array( 'wishlist_data' => $output_data, 'wishlist_name' => $wishlist_name, 'nonce' => wp_create_nonce( $this->plugin_name ) ) );
		return ob_get_clean();

	}


	/**
	 * Output template for showing "added to wishlist" modal
	 *
	 * @since    1.0.0
	 */
	public function wishlist_modal_wrapper(){

		ob_start();
		$this->get_templates( 'addonify-wishlist-modal-wrapper', true, array( 'view_wishlist_btn_label' => $this->get_db_values( 'view_wishlist_btn_text' ) ) );
		echo ob_get_clean();
	}


	/**
	 * Output template for showing sticky sidebar
	 *
	 * @since    1.0.0
	 */
	public function wishlist_sticky_sidebar(){

		$wishlist_items 	= $this->get_all_wishlist();
		$wishlist_name 		= $this->get_db_values('default_wishlist_name', __( 'My Wishlist', 'addonify-wishlist' ) );
		$wishlist_page_url 	= get_page_link( $this->wishlist_page_id );
		$sidebar_loop 		= $this->get_sticky_sidebar_loop( $wishlist_items );

		ob_start();
		$this->get_templates( 'addonify-wishlist-sticky-sidebar', true, array( 'loop' => $sidebar_loop, 'wishlist_name' => $wishlist_name, 'wishlist_url' => $wishlist_page_url ) );
		echo ob_get_clean();
		
	}


	/**
	 * Return template for sticky sidebar loop
	 *
	 * @since    1.0.0
	 */
	public function get_sticky_sidebar_loop( $product_ids ){

		$output_data = $this->generate_contents_data( $product_ids );

		ob_start();
		$this->get_templates( 'addonify-wishlist-sticky-sidebar-loop', false, array( 'wishlist_data' => $output_data ) );
		return ob_get_clean();
	}


	
	/**
	 * Generate data to be used in wishlist shortcode template
	 *
	 * @since    1.0.0
	 * @param      string    $selected_product_ids       Product ids
	 */
	private function generate_contents_data( $selected_product_ids ) {
		
		$sel_products_data = array();

		if ( is_array( $selected_product_ids ) && ( count( $selected_product_ids ) > 0 ) ) {

			$i = 0;

			foreach ( $selected_product_ids as $product_id => $timestamp ) {

				$product = wc_get_product( $product_id );
				$parent_product = false;

				if ( ! $product )  continue;

				$sel_products_data[ $i ]['id'] 			= $product_id;
				$sel_products_data[ $i ]['image']		= apply_filters( 'addonify_wishlist_product_image', '<a href="' . $product->get_permalink() . '" >' . $product->get_image( 'woocommerce_thumbnail', array( 'draggable' => 'false' ) ) . '</a>', $product_id );
				$sel_products_data[ $i ]['title'] 		= apply_filters( 'addonify_wishlist_product_name', '<a href="' . $product->get_permalink() . '" >' . wp_strip_all_tags( $product->get_formatted_name() ) . '</a>', $product_id );
				$sel_products_data[ $i ]['price'] 		= apply_filters( 'addonify_wishlist_price_html', $product->get_price_html(), $product_id );
				$sel_products_data[ $i ]['date_added'] 	= $timestamp;

				$sel_products_data[ $i ]['stock'] 		= apply_filters( 'addonify_wishlist_stock_label', ( $product->get_stock_status() == 'instock' ) ? '<span class="stock in-stock">In stock</span>' : '<span class="stock out-of-stock">Out of stock</span>', $product_id );
				
				$sel_products_data[ $i ]['add_to_cart'] = apply_filters( 'addonify_wishlist_add_to_cart_btn', $this->add_to_cart_btn( $product ), $product_id );

				$i++;

			}

		}

		return $sel_products_data;

	}


	/**
	 * Return proper markups for "Add to cart" button to be used in wishlist shortcode
	 *
	 * @since    1.0.0
	 */
	public function add_to_cart_btn( $product ){

		if( $product->get_stock_status() != 'instock' ) return '';

		if( in_array( $product->get_type(), array( 'simple', 'variable' ) ) ) {
			return '<button type="submit" name="addonify_wishlist_add_to_cart" value="'. $product->get_id() .'">Add to cart</button>';
		}
		else{
			return do_shortcode( '[add_to_cart id="' . $product->get_id() . '" show_price="false" style="" ]' );
		}

	}


	/**
	 * capture form submitted through "wishlist" page and process necessary actions
	 *
	 * @since    1.0.0
	 */
	public function process_wishlist_form_submit(){

		// should we process this request ?
		if( ! isset( $_POST['process_addonify_wishlist_form'] ) ) return;
		
		$wishlist_page_url 						= get_page_link( $this->wishlist_page_id );
		$redirect_to_checkout_after_add_to_cart = $this->get_db_values( 'redirect_to_checkout_if_item_added_to_cart', 0 );

		// nonce
		if( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], $this->plugin_name ) ) {
			$this->set_flashdata( 'wishlist_action', array( 'Page has expired. Please try again', 'warning' ) );
			wp_redirect( $wishlist_page_url );
			exit;
		}

		
		// remove single product
		if( isset( $_POST['addonify_wishlist_remove'] )  && ! empty( $_POST['addonify_wishlist_remove'] ) ) {

			$product_id = $_POST['addonify_wishlist_remove'];

			// no need to check if item exists in wishlist
			// because, user wants to delete it anyway.

			$this->remove_item_from_wishlist( array( $_POST['addonify_wishlist_remove'] ) );
			wp_redirect( $wishlist_page_url );
			exit;

		}

		// add to cart  single product
		if( isset( $_POST['addonify_wishlist_add_to_cart'] )  && ! empty( $_POST['addonify_wishlist_add_to_cart'] ) ){
			$product_id = $_POST['addonify_wishlist_add_to_cart'];

			if( $this->add_to_cart( array( $product_id ) ) && $redirect_to_checkout_after_add_to_cart ){
				wp_redirect( wc_get_checkout_url() );
			}
			else{
				wp_redirect( $wishlist_page_url );
			}
			
			exit;

		}

		// addonify-wishlist-footer-actions
		if( isset( $_POST['addonify_wishlist_action'] )  && ! empty( $_POST['addonify_wishlist_action'] ) ) {
			
			// add all to cart
			if( $_POST['addonify_wishlist_action'] == 'add_all_to_cart' ){

				if( $this->add_to_cart( 'all' ) && $redirect_to_checkout_after_add_to_cart ){
					wp_redirect( wc_get_checkout_url() );
				}
				else{
					wp_redirect( $wishlist_page_url );
				}
				exit;
			}
			
			
			$selected_product_ids = $_POST['product_ids'];


			// is any product selected ?
			if( ! is_array( $selected_product_ids ) ){
				$this->set_flashdata( 'wishlist_action', array( 'You have not selected any products', 'warning' ) );

				wp_redirect( $wishlist_page_url );
				exit;
			}
				
			// remove selected
			if( $_POST['addonify_wishlist_action'] == 'remove' ){
				$this->remove_item_from_wishlist( $selected_product_ids );
			}
			
			// add selected to cart
			elseif( $_POST['addonify_wishlist_action'] == 'add_selected_to_cart' ){
				if( $this->add_to_cart( $selected_product_ids ) && $redirect_to_checkout_after_add_to_cart ){
					wp_redirect( wc_get_checkout_url() );
					exit;
				}
			}

			wp_redirect( $wishlist_page_url );
			exit;

		}

		

	}


	/**
	 * remove product from wishlist cookies and database
	 *
	 * @since    1.0.0
	 */
	private function remove_item_from_wishlist( $product_ids ){

		$wishlist_items = $this->get_all_wishlist();
		$msg = '';
		
		foreach( $product_ids as $product_id ){

			$product = wc_get_product( $product_id );

			unset( $wishlist_items[ $product_id ] );
			$msg .=  $product->get_name() . ' is removed from wishlist <br>';
		}

		wc_add_notice( $msg, 'success' );

		$this->save_wishlist_data( $wishlist_items );
	}


	/**
	 * Add product to cart and show proper noticications
	 *
	 * @since    1.0.0
	 */
	public function add_to_cart( $product_ids ){

		$wishlist_items = $this->get_all_wishlist();

		if( $product_ids == 'all' ){
			$product_ids = array();
			foreach( $wishlist_items as $product_id => $timestamp ){
				$product_ids[] = $product_id;
			}
		}

		$msg_success 	= '';
		$msg_error 		= '';

		//  remove from wishlist if added to cart ?
		$remove_from_cart = $this->get_db_values( 'remove_from_wishlist_if_added_to_cart', 1 );

		foreach( $product_ids as $product_id ){

			if( is_array( $product_id ) ) $product_id = $product_id[0];

			$product = wc_get_product( $product_id );

			if( WC()->cart->add_to_cart( $product_id ) ){
				$msg_success .= $product->get_name() . ' is added to cart <br>';

				
				if( $remove_from_cart ){
					$this->remove_item_from_wishlist( array( $product_id ) );
					$msg_success .= $product->get_name() . ' is removed from wishlist <br>';
				}
				
			}
			else{
				$msg_error .= $product->get_name() . ' cannot be added to cart <br>';
			}
		}

		WC()->session->set( 'wc_notices', array() ); 
		
		if( ! empty( $msg_success ) ){
			wc_add_notice( $msg_success, 'success' );
		}

		if( ! empty( $msg_error ) ){
			wc_add_notice( $msg_error, 'error' );
		}

		return ( ! empty( $msg_success ) ) ? true : false;

	}

	
	/**
	 * Save wishlist cookies into user meta options after user is logged in
	 *
	 * @since    1.0.0
	 */
	public function after_user_login( $user_login, $user ){

		$wishlist_from_cookies = $this->get_wishlist_from_cookies();

		if( ! empty( $wishlist_from_cookies ) ){
			$wishlist_from_db = $this->get_wishlist_from_database( true, $user->ID );
			$new_data = serialize( array_replace( $wishlist_from_db, $wishlist_from_cookies ) );

			// update database
			update_user_meta( $user->ID, '_' . $this->plugin_name, $new_data );
		}
		
	}



}
