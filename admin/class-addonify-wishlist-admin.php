<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin
 * @author     Adodnify <info@addonify.com>
 */
class Addonify_Wishlist_Admin {

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
	 * Settings page slug
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings_page_slug    Default settings page slug for this plugin
	 */
	private $settings_page_slug = 'addonify_wishlist';


	/**
	 * Default values for input fields in admin screen
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $default_input_values
	 */
	private $default_input_values;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		global $wp_styles;

		// load styles in this plugin page only
		if( isset($_GET['page']) && $_GET['page'] == $this->settings_page_slug ){


			// toggle switch
			wp_enqueue_style( 'lc_switch', plugin_dir_url( __FILE__ ) . 'css/lc_switch.css' );

			// built in wp color picker
			// requires atleast wordpress 3.5
			wp_enqueue_style( 'wp-color-picker' ); 

			// admin css
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/addonify-wishlist-admin.min.css', array(), $this->version, 'all' );
		}

		// admin menu icon fix
		wp_enqueue_style( 'addonify-icon-fix', plugin_dir_url( __FILE__ ) . 'css/addonify-icon-fix.css', array(), $this->version, 'all' );

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// load scripts in plugin page only
		if( isset($_GET['page']) && $_GET['page'] == $this->settings_page_slug  ){

			if( isset( $_GET['tabs'] ) && $_GET['tabs'] == 'styles' ){

				// requires atleast wordpress 4.9.0
				// wp_enqueue_code_editor( array( 'type' => 'text/css' ) );

				wp_enqueue_script( 'wp-color-picker' );
				
			}
			
			// toggle switch
			wp_enqueue_script( 'lc_switch', plugin_dir_url( __FILE__ ) . 'js/lc_switch.min.js', array( 'jquery' ), '', false );
			

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/addonify-wishlist-admin.min.js', array( 'jquery' ), $this->version, false );

		}

	}



	/**
	 * Check if woocommerce is active
	 *
	 * @since    1.0.0
	 */
	private function is_woocommerce_active() {
		return ( class_exists( 'woocommerce' ) ) ? true : false;
	}



	/**
	 * Generate admin menu for this plugin
	 *
	 * @since    1.0.0
	 */
	public function add_menu_callback(){

		// do not show menu if woocommerce is not active
		if ( ! $this->is_woocommerce_active() )  return; 

		global $menu;
		$parent_menu_slug = null;

		foreach($menu as $item) {
			if(strtolower($item[0]) == 'addonify' ) {

				$parent_menu_slug = $item[2];
				break;
			}
		}


		if( ! $parent_menu_slug ){
			add_menu_page( 'Addonify Settings', 'Addonify', 'manage_options', $this->settings_page_slug, array($this, 'get_settings_screen_contents'), plugin_dir_url( __FILE__ ) .'/templates/addonify-logo.svg', 76 );

			add_submenu_page(  $this->settings_page_slug, 'Addonify Wishlist Settings', 'Wishlist', 'manage_options', $this->settings_page_slug, array($this, 'get_settings_screen_contents'), 1 );

		}
		else{

			// sub menu
			// redirects to main plugin link
			add_submenu_page(  $parent_menu_slug, 'Addonify Wishlist Settings', 'Wishlist', 'manage_options', $this->settings_page_slug, array($this, 'get_settings_screen_contents'), 1 );
			
		}
	}



	/**
	 * Print "settings" link in plugins.php admin page
	 *
	 * @since    1.0.0
	 */
	 public function custom_plugin_link_callback( $links, $file ){
		
		if ( $file == plugin_basename(dirname(__FILE__, 2) . '/addonify-wishlist.php') ) {
			// add "Settings" link
			$links[] = '<a href="admin.php?page='. $this->settings_page_slug .'">' . __('Settings','addonify-wishlist') . '</a>';
		}
		
		return $links;
	}



	/**
	 * Get contents from settings page templates and print it
	 *
	 * @since    1.0.0
	 */
	public function get_settings_screen_contents(){
		$current_tab = ( isset($_GET['tabs']) ) ? $_GET['tabs'] : 'settings';
		$tab_url = "admin.php?page=$this->settings_page_slug&tabs=";

		ob_start();
		require_once dirname( __FILE__ ) .'/templates/settings-screen.php';
		echo ob_get_clean();

	}



	/**
	 * Generate form elements for settings page from array
	 *
	 * @since    1.0.0
	 */
	public function settings_page_ui() {


		// ---------------------------------------------
		// Button Settings
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name'	=> 'wishlist_settings',
			'section_id' 			=> 'table_options',
			'section_label'			=> __('Add to Wishlist button options', 'addonify-wishlist'),
			'section_callback'		=> '',
			'screen'				=> $this->settings_page_slug.'-button_settings',
			'fields'				=> array(
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'btn_position',
					'field_label'			=> __('Button position', 'addonify-wishlist'),
					'field_callback'		=> array($this, "select"),
					'field_callback_args'	=> array( 
						array(
							'name' 				=> ADDONIFY_WISHLIST_DB_INITIALS . 'btn_position', 
							'options' 			=> array(
								'after_add_to_cart'		=> __('After Add To Cart Button', 'addonify-wishlist-products'),
								'before_add_to_cart' 	=> __('Before Add To Cart Button', 'addonify-wishlist-products'),
								'overlay_on_image'		=> __('Overlay On The Product Image', 'addonify-wishlist-products')
							),
						),
					) 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'btn_label',
					'field_label'			=> __('Button label', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'btn_label', 
							'default'		 	=> __('Add to Wishlist', 'addonify-wishlist'),
						)
					), 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'show_icon',
					'field_label'			=> __('Show icon in button', 'addonify-wishlist'),
					'field_callback'		=> array($this, "toggle_switch"),
					'field_callback_args'	=> array( 
						array(
							'name' 				=> ADDONIFY_WISHLIST_DB_INITIALS . 'show_icon', 
							'checked' 			=> 1,
						),
					) 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'btn_custom_class',
					'field_label'			=> __('Button custom CSS class', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'btn_custom_class', 
							'default'		 	=> __('', 'addonify-wishlist'),
						)
					), 
				),
				
			),
		);

		// create settings fields
		$this->create_settings( $settings_args );



		// ---------------------------------------------
		// After Product is added to wishlist
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name'	=> 'wishlist_settings',
			'section_id' 			=> 'general_options',
			'section_label'			=> __('After Product is added to Wishlist', 'addonify-wishlist'),
			'section_callback'		=> '',
			'screen'				=> $this->settings_page_slug.'-after_product_added_to_wishlist',
			'fields'				=> array(
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'view_wishlist_btn_text',
					'field_label'			=> __('"View Wishlist" button text', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'view_wishlist_btn_text', 
							'default'		 	=> __('View Wishlist', 'addonify-wishlist'),
							'sanitize_callback'	=> 'validate_view_wishlist_btn_text',
						)
					), 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'product_added_to_wishlist_text',
					'field_label'			=> __('"Product added to Wishlist" text', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'product_added_to_wishlist_text', 
							'default'		 	=> __('{product_name} added to Wishlist', 'addonify-wishlist'),
							'sanitize_callback'	=> 'validate_product_added_to_wishlist_text',
						)
					), 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'product_already_in_wishlist_text',
					'field_label'			=> __('"Product already in Wishlist" text', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'product_already_in_wishlist_text', 
							'default'		 	=> __('{product_name} already in Wishlist', 'addonify-wishlist'),
							'sanitize_callback'	=> 'validate_product_already_in_wishlist_text',
						)
					), 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'cookies_lifetime',
					'field_label'			=> __('Delete Wishlist Cookies after', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name' 				=> ADDONIFY_WISHLIST_DB_INITIALS . 'cookies_lifetime', 
							'default' 			=> 30,
							'css_class'			=> 'number',
							'type'				=> 'number',
							'end_label'			=> 'days',
							'other_attr'		=> 'min="1"',
							'sanitize_callback'	=> 'validate_cookies_lifetime',
						)
					) 
				),
				
			)
		);

		// create settings fields
		$this->create_settings( $settings_args );


		// ---------------------------------------------
		// Wishlist details page
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name'	=> 'wishlist_settings',
			'section_id' 			=> 'general_options',
			'section_label'			=> __('Wishlist details page', 'addonify-wishlist'),
			'section_callback'		=> '',
			'screen'				=> $this->settings_page_slug.'-wishlist_details_page',
			'fields'				=> array(
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page',
					'field_label'			=> __('Wishlist Page', 'addonify-wishlist'),
					'field_callback'		=> array($this, "select_page"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page', 
						)
					), 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'default_wishlist_name',
					'field_label'			=> __('Default Wishlist name', 'addonify-wishlist'),
					'field_callback'		=> array($this, "text_box"),
					'field_callback_args'	=> array( 
						array(
							'name'			 	=> ADDONIFY_WISHLIST_DB_INITIALS . 'default_wishlist_name', 
							'default'		 	=> __('My Wishlist', 'addonify-wishlist'),
							'sanitize_callback'	=> 'validate_default_wishlist_name',
						)
					), 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'remove_from_wishlist_if_added_to_cart',
					'field_label'			=> __('Remove Product from Wishlist if added to cart', 'addonify-wishlist'),
					'field_callback'		=> array($this, "toggle_switch"),
					'field_callback_args'	=> array( 
						array(
							'name' 				=> ADDONIFY_WISHLIST_DB_INITIALS . 'remove_from_wishlist_if_added_to_cart', 
							'checked' 			=> 1,
						)
					) 
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'redirect_to_checkout_if_item_added_to_cart',
					'field_label'			=> __('Redirect to the checkout page from Wishlist if added to cart', 'addonify-wishlist'),
					'field_callback'		=> array($this, "toggle_switch"),
					'field_callback_args'	=> array( 
						array(
							'name' 				=> ADDONIFY_WISHLIST_DB_INITIALS . 'redirect_to_checkout_if_item_added_to_cart', 
							'checked' 			=> 0,
						)
					) 
				),		
				

				
				
			)
		);

		// create settings fields
		$this->create_settings( $settings_args );



		// ---------------------------------------------
		// Styles Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name'	=> 'wishlist_styles',
			'section_id' 			=> 'style_options',
			'section_label'			=> __('STYLE OPTIONS', 'addonify-wishlist'),
			'section_callback'		=> '',
			'screen'				=> $this->settings_page_slug.'-styles',
			'fields'				=> array(
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'load_styles_from_plugin',
					'field_label'			=> __('Load Styles From Plugin', 'addonify-wishlist'),
					'field_callback'		=> array($this, "toggle_switch"),
					'field_callback_args'	=> array( 
						array(
							'name' 				=> ADDONIFY_WISHLIST_DB_INITIALS . 'load_styles_from_plugin', 
							'checked' 			=> 0,
						)
					) 
				),
			)
		);

		// create settings fields
		$this->create_settings( $settings_args );


		// ---------------------------------------------
		// Content Colors
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name'	=> 'wishlist_styles',
			'section_id' 			=> 'content_colors',
			'section_label'			=> __('CONTENT COLORS', 'addonify-wishlist'),
			'section_callback'		=> '',
			'screen'				=> $this->settings_page_slug.'-content-colors',
			'fields'				=> array(
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_colors',
					'field_label'			=> __('Add to Wishlist button', 'addonify-wishlist'),
					'field_callback'		=> array($this, "color_picker_group"),
					'field_callback_args'	=> array( 
						array(
							'label'				=> __('Text Color', 'addonify-wishlist'),
							'name'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_text_color',
							'default'			=> '#96588a',
						),
						array(
							'label'				=> __('Icon Color', 'addonify-wishlist'),
							'name'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_icon_color',
							'default'			=> '#96588a',
						),
					),
				),
				array(
					'field_id'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_colors_hover',
					'field_label'			=> '',
					'field_callback'		=> array($this, "color_picker_group"),
					'field_callback_args'	=> array( 
						array(
							'label'				=> __('Text Color on Hover', 'addonify-wishlist'),
							'name'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_text_color_hover',
							'default'			=> '#000000',
						),
						array(
							'label'				=> __('Icon Color on Hover', 'addonify-wishlist'),
							'name'				=> ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_icon_color_hover',
							'default'			=> '#000000',
						),
					),
				),
			)
		);

		// create settings fields
		$this->create_settings( $settings_args );
		
	}



	/**
	 * This will create settings section, fields and register that settings in a database from the provided array data
	 *
	 * @since    1.0.0
	 */
	private function create_settings($args){

		// define section ---------------------------
		add_settings_section($args['section_id'], $args['section_label'], $args['section_callback'], $args['screen'] );

		foreach($args['fields'] as $field){
			
			// create label
			add_settings_field( $field['field_id'], $field['field_label'], $field['field_callback'], $args['screen'], $args['section_id'], $field['field_callback_args'] );
			
			foreach( $field['field_callback_args'] as $sub_field){

				$this->default_input_values[ $sub_field['name'] ] = ( isset( $sub_field['default'] ) ) ? $sub_field['default'] : '';
				register_setting( $args['settings_group_name'],  $sub_field['name'], array(
        			'sanitize_callback' => ( isset( $sub_field['sanitize_callback'] )) ? array( $this, $sub_field['sanitize_callback'] ) : 'sanitize_text_field'
				));
			}

		}

	}

	
	/**
	 * Form Validation for Offset From Top
	 *
	 * @since    1.0.0
	 */

	public function validate_view_wishlist_btn_text( $post_data ){
		return $this->validate_text_field( $post_data, __FUNCTION__ , __( '"View Wishlist button" text cannot be empty.', 'addonify-wishlist' ) );
	}
	 
	public function validate_product_added_to_wishlist_text( $post_data ){
		return $this->validate_text_field( $post_data, __FUNCTION__, __( '"Product added to Wishlist" text cannot be empty.', 'addonify-wishlist' ) );
	}
	
	public function validate_product_already_in_wishlist_text( $post_data ){
		return $this->validate_text_field( $post_data, __FUNCTION__, __( '"Product already in Wishlist" text cannot be empty', 'addonify-wishlist' ) );
	}

	public function validate_cookies_lifetime( $post_data ){
		return $this->validate_numeric( $post_data, __FUNCTION__, __( '"Delete Wishlist Cookies after" value should be numeric', 'addonify-wishlist' ) );
	}

	public function validate_default_wishlist_name( $post_data ){
		return $this->validate_text_field( $post_data, __FUNCTION__, __( '"Default Wishlist name" should not be empty', 'addonify-wishlist' ) );
	}

	

	private function validate_numeric( $post_data, $name, $msg = null  ){

		if( is_numeric( $post_data ) ){
			return sanitize_text_field( $post_data );
		}
		
		return $this->validation_response( $name, $msg );
	}

	private function validate_text_field( $post_data, $name, $msg = null  ){

		if( ! empty( $post_data ) ){
			return sanitize_text_field( $post_data );
		}

		return $this->validation_response( $name, $msg );
	}

	private function validation_response( $name, $msg = NULL ){

		$default_value = $this->default_input_values[ ADDONIFY_WISHLIST_DB_INITIALS . str_replace('validate_', '', $name ) ];

		if( ! $msg ) $msg = __( 'Input field should not be empty.', 'addonify-wishlist' );
		$msg .= __( ' Default value is used.', 'addonify-wishlist' );
		
		add_settings_error(
			$this->plugin_name,
			esc_attr( 'settings_updated' ),
			$msg
		);

		return $default_value;
	
	}

	


	/**
	 * Show notification after form submission
	 *
	 * @since    1.0.0
	 */
	public function form_submission_notification_callback(){
		if( isset($_GET['page']) && $_GET['page'] == $this->settings_page_slug ){
			settings_errors();			
		}
	}




	/**
	 * Show admin error message if woocommerce is not active
	 *
	 * @since    1.0.0
	 */
	 public function show_woocommerce_not_active_notice_callback(){
		 

		if( ! $this->is_woocommerce_active() ){
			add_action('admin_notices', function() {
				ob_start();
				require dirname( __FILE__ ) .'/templates/woocommerce_not_active_notice.php';
				echo ob_get_clean();
			});
		}


		

	}


	/**
	 * Show custom "post status" label after page title
	 * shows "Addonify Wishlist Page" label after the page title
	 *
	 * @since    1.0.0
	 */
	function custom_display_post_states_callback( $states, $post ) {

		$wishlist_page_id = get_option( ADDONIFY_WISHLIST_DB_INITIALS .'wishlist_page', get_option( ADDONIFY_WISHLIST_DB_INITIALS .'page_id' ) );

		if( get_post_type( $post->ID ) == 'page' && $post->ID == $wishlist_page_id ){
			$states[] = __('Addonify Wishlist Page', 'addonify-wishlist'); 
		}
	 
		return $states;
	}



	// -------------------------------------------------
	// form helpers for admin setting screen
	// -------------------------------------------------

	public function text_box($arguments){
		ob_start();
		foreach($arguments as $args){
			$default = isset( $args['default'] ) ? $args['default'] : '';
			$db_value = get_option($args['name'], $default);

			if( ! isset( $args['css_class'] ) ) 	$args['css_class'] 	= '';
			if( ! isset( $args['type'] ) ) 			$args['type']		= 'text';
			if( ! isset( $args['end_label'] ) ) 	$args['end_label']	= '';
			if( ! isset( $args['other_attr'] ) ) 	$args['other_attr']	= '';

			require dirname( __FILE__ ) .'/templates/input_textbox.php';
		}
		echo ob_get_clean();
	}

	public function toggle_switch($arguments){
		foreach($arguments as $args){
			$args['attr'] = ' class="lc_switch"';
			$this->checkbox($args);
		}
	}

	public function color_picker_group($args){
		ob_start();
		foreach($args as $arg){
			$default =  isset( $arg['default'] )  ? $arg['default'] : '';
			$db_value = ( get_option( $arg['name'] )) ? get_option( $arg['name'] ) : $default;

			require dirname( __FILE__ ) .'/templates/input_colorpicker.php';
		}
		echo ob_get_clean();
	}

	public function checkbox($args){
		$default_state = ( array_key_exists('checked', $args) ) ? $args['checked'] : 1;
		$db_value = get_option($args['name'], $default_state);
		$is_checked = ( $db_value ) ? 'checked' : '';
		$attr = ( array_key_exists('attr', $args) ) ? $args['attr'] : '';

		ob_start();
		require dirname( __FILE__ ) .'/templates/input_checkbox.php';
		echo ob_get_clean();
	}

	public function select($arguments){
		ob_start();
		foreach($arguments as $args){

			$db_value = get_option($args['name']);
			$options = ( array_key_exists('options', $args) ) ? $args['options'] : array();
			
			require dirname( __FILE__ ) .'/templates/input_select.php';
		}
		echo ob_get_clean();
	}

	public function select_page( $arguments ){

		ob_start();
		$options = array();

		foreach( get_pages() as $page ){
			$options[$page->ID] = $page->post_title;
		}

		$args = $arguments[0];
		$db_value = get_option( $args['name'] );

		$default_wishlist_page_id = get_option( ADDONIFY_WISHLIST_DB_INITIALS .'page_id' );

		if ( ! $db_value ) $db_value = $default_wishlist_page_id;

		if( $db_value != $default_wishlist_page_id ) {
			$args['end_label'] = 'Please insert "[addonify_wishlist]" shortcode into the content area of the page';
		}

		
		require dirname( __FILE__ ) .'/templates/input_select.php';
		echo ob_get_clean();
	}


}
