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
			
			$this->btn_position 			=  $this->get_db_values('btn_position', 'after_add_to_cart' );
			$this->btn_label 				= $this->get_db_values( 'btn_label', __( 'Add to Wishlist', 'addonify-wishlist' ) );
			$this->button_custom_css_class	= $this->get_db_values( 'btn_custom_class' );

			$this->register_shortcode();
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
				'view_wishlist_btn_text'				=> $this->get_db_values( 'view_wishlist_btn_text' ),
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
			$this->show_btn_markups();
		}
	}

	

	
	/**
	 * Show button before "add to cart" button
	 *
	 * @since    1.0.0
	 */
	public function show_btn_before_add_to_cart_btn_callback(){
		if( $this->btn_position == 'before_add_to_cart'  ) {
			$this->show_btn_markups();
		}
	}



	/**
	 * Show button on top of image
	 *
	 * @since    1.0.0
	 */
	public function show_btn_aside_image_callback(){

		if( $this->btn_position != 'overlay_on_image' ) return;

		$this->show_btn_markups( 'addonify-overlay-btn' );

	}



	/**
	 * Generating "add to wishlist" button content
	 *
	 * @since    1.0.0
	 */
	private function show_btn_markups( $extra_css_class = '' ) {

		global $product;
		$product_id = $product->get_id();

		if( $this->get_db_values('show_icon') ) {
			$extra_css_class .= ' show-icon';
		}

		$extra_css_class .= ' ' . $this->button_custom_css_class;

		// show compare btn after add to cart button
		if( $this->btn_label ) {

			ob_start();
			$this->get_templates( 'addonify-add-to-wishlist-button', false, array( 'product_id' => $product_id, 'label' => $this->btn_label, 'css_class' => $extra_css_class ) );
			echo ob_get_clean();

		}

	}
	



	/**
	 * Set cookie for wishlist
	 *
	 * @since    1.0.0
	 */
	public function set_cookie() {

		return;

		$cookies_lifetime = (int) $this->get_db_values('cookies_lifetime', 30 );
		setcookie( 'addonify_wishlist', '', $cookies_lifetime * DAY_IN_SECONDS);

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
	 * Print opening tag of overlay container
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
	 * Print closing tag of the overlay container
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
	 *
	 * @since    1.0.0
	 * @param    $template_name		Name of the template
	 * @param    $require_once		Should use require_once or require ?
	 * @param    $data				Data to pass to template
	 */
	private function register_shortcode(){
		// add_shortcode( 'addonify-wishlist', array( $this, 'get_compare_contents_callback' ) );
	}


}
