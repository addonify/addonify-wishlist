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
 * Defines the plugin name, version, and other required variables.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/admin
 * @author     Adodnify <info@addonify.com>
 */
class Addonify_Wishlist_Admin extends Addonify_Wishlist_Helpers {

	/**
	 * Settings page slug
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings_page_slug    Default settings page slug for this plugin
	 */
	private $settings_page_slug = 'addonify_wishlist';


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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of this plugin.
	 * @param    string $version     The version of this plugin.
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

		// load styles in this plugin page only.
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->settings_page_slug ) {

			// toggle switch.
			wp_enqueue_style( 'lc_switch', plugin_dir_url( __FILE__ ) . 'css/lc_switch.css', array(), $this->version, 'all' );

			// built in wp color picker.
			// requires atleast wordpress 3.5.
			wp_enqueue_style( 'wp-color-picker' );

			// admin css.
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/addonify-wishlist-admin.min.css', array(), $this->version, 'all' );
		}

		// admin menu icon fix.
		wp_enqueue_style( 'addonify-icon-fix', plugin_dir_url( __FILE__ ) . 'css/addonify-icon-fix.css', array(), $this->version, 'all' );

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// load scripts in plugin page only.
		if ( isset( $_GET['page'] ) && $_GET['page'] == $this->settings_page_slug ) {

			if ( isset( $_GET['tabs'] ) && 'styles' === $_GET['tabs'] ) {

				// requires atleast wordpress 4.9.0.
				wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
				wp_enqueue_script( 'wp-color-picker' );
			}

			// toggle switch.
			wp_enqueue_script( 'lc_switch', plugin_dir_url( __FILE__ ) . 'js/lc_switch.min.js', array( 'jquery' ), $this->version, false );

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/addonify-wishlist-admin.min.js', array( 'jquery' ), time(), false );

		}

	}


	/**
	 * Generate admin menu for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function add_menu_callback() {

		// do not show menu if woocommerce is not active.
		if ( ! $this->is_woocommerce_active() ) {
			return;
		}

		global $menu;
		$parent_menu_slug = null;

		foreach ( $menu as $item ) {
			if ( 'addonify' === strtolower( $item[0] ) ) {

				$parent_menu_slug = $item[2];
				break;
			}
		}

		if ( ! $parent_menu_slug ) {
			add_menu_page( 'Addonify Settings', 'Addonify', 'manage_options', $this->settings_page_slug, array( $this, 'get_settings_screen_contents' ), plugin_dir_url( __FILE__ ) . '/images/addonify-logo.svg', 76 );
			add_submenu_page( $this->settings_page_slug, 'Addonify Wishlist Settings', 'Wishlist', 'manage_options', $this->settings_page_slug, array( $this, 'get_settings_screen_contents' ), 1 );

		} else {

			// sub menu.
			// redirects to main plugin link.
			add_submenu_page( $parent_menu_slug, 'Addonify Wishlist Settings', 'Wishlist', 'manage_options', $this->settings_page_slug, array( $this, 'get_settings_screen_contents' ), 1 );

		}
	}



	/**
	 * Print "settings" link in plugins.php admin page
	 *
	 * @since    1.0.0
	 * @param string $links links.
	 * @param string $file File.
	 */
	public function custom_plugin_link_callback( $links, $file ) {

		if ( plugin_basename( ADDONIFY_WISHLIST_PLUGIN_PATH . '/addonify-wishlist.php' ) === $file ) {
			// add "Settings" link.
			$links[] = '<a href="admin.php?page=' . esc_attr( $this->settings_page_slug ) . '">' . __( 'Settings', 'addonify-wishlist' ) . '</a>';
		}

		return $links;
	}



	/**
	 * Get contents from settings page templates and print it
	 * Called from "add_menu_callback".
	 *
	 * @since    1.0.0
	 */
	public function get_settings_screen_contents() {
		$current_tab = ( isset( $_GET['tabs'] ) ) ? sanitize_text_field( wp_unslash( $_GET['tabs'] ) ) : 'settings';
		$tab_url = "admin.php?page=$this->settings_page_slug&tabs=";

		require_once ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/settings-screen.php';
	}



	/**
	 * Generate form elements for settings page from array
	 *
	 * @since    1.0.0
	 */
	public function settings_page_ui() {

		// ---------------------------------------------
		// General Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_settings',
			'section_id' => 'general_options',
			'section_label' => __( 'General Options', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-general_options',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'default_wishlist_name',
					'field_label' => __( 'Wishlist name', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'default_wishlist_name',
							'default' => __( 'My Wishlist', 'addonify-wishlist' ),
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page',
					'field_label' => __( 'Wishlist Page', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'select_page' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page',
							'default' => get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'page_id' ),
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'require_login',
					'field_label' => __( 'Require Login', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'require_login',
							'checked' => 1,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'redirect_to_login',
					'field_label' => __( 'Redirect to Login Page', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'redirect_to_login',
							'checked' => 1,
							'end_label' => esc_html( '"Require Login" option should be "On"' ),
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'redirect_to_checkout_if_item_added_to_cart',
					'field_label' => __( 'Redirect to the checkout page from Wishlist if added to cart', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'redirect_to_checkout_if_item_added_to_cart',
							'checked' => 0,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'remove_from_wishlist_if_added_to_cart',
					'field_label' => __( 'Remove Product from Wishlist if added to cart', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'remove_from_wishlist_if_added_to_cart',
							'checked' => 1,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'cookies_lifetime',
					'field_label' => __( 'Save Wishlist for', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'cookies_lifetime',
							'default' => 30,
							'css_class' => 'number',
							'type' => 'number',
							'end_label' => 'days',
							'other_attr' => 'min="1"',
							'sanitize_callback' => 'validate_cookies_lifetime',
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// ---------------------------------------------
		// Button Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_settings',
			'section_id' => 'button_options',
			'section_label' => __( 'Add to Wishlist Button Options', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-button_settings',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_position',
					'field_label' => __( 'Button position', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'select' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_position',
							'options' => array(
								'after_add_to_cart' => __( 'After Add To Cart Button', 'addonify-wishlist-products' ),
								'before_add_to_cart' => __( 'Before Add To Cart Button', 'addonify-wishlist-products' ),
								'overlay_on_image' => __( 'Overlay On The Product Image', 'addonify-wishlist-products' ),
							),
							'default' => 'before_add_to_cart',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_label',
					'field_label' => __( 'Button label', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_label',
							'default' => __( 'Add to Wishlist', 'addonify-wishlist' ),
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_label_if_added_to_wishlist',
					'field_label' => __( 'Button label if product is already in Wishlist', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_label_if_added_to_wishlist',
							'default' => __( 'Already in Wishlist', 'addonify-wishlist' ),
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'show_icon',
					'field_label' => __( 'Show icon in button', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'show_icon',
							'checked' => 1,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_custom_class',
					'field_label' => __( 'Custom CSS class', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'btn_custom_class',
							'default' => '',
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// ---------------------------------------------
		// Popup Notice Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_settings',
			'section_id' => 'popup_options',
			'section_label' => __( 'Popup Notice Options', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-popup_options',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'show_popup',
					'field_label' => __( 'Show successful popup notice', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'show_popup',
							'default' => 1,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'view_wishlist_btn_text',
					'field_label' => __( '"View Wishlist" button label', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'view_wishlist_btn_text',
							'default' => __( 'View Wishlist', 'addonify-wishlist' ),
							'sanitize_callback' => 'validate_view_wishlist_btn_text',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'product_added_to_wishlist_text',
					'field_label' => __( '"Product added to Wishlist" text', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'product_added_to_wishlist_text',
							'default' => __( '{product_name} added to Wishlist', 'addonify-wishlist' ),
							'sanitize_callback' => 'validate_product_added_to_wishlist_text',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'product_already_in_wishlist_text',
					'field_label' => __( '"Product already in Wishlist" text', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'product_already_in_wishlist_text',
							'default' => __( '{product_name} already in Wishlist', 'addonify-wishlist' ),
							'sanitize_callback' => 'validate_product_already_in_wishlist_text',
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// ---------------------------------------------
		// Wishlist Sidebar Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_settings',
			'section_id' => 'sidebar',
			'section_label' => __( 'Wishlist Sidebar Options', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-sidebar_options',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'show_sidebar',
					'field_label' => __( 'Show Sidebar', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'show_sidebar',
							'checked' => 1,
							'default' => 1,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_position',
					'field_label' => __( 'Sidebar position', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'select' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_position',
							'options' => array(
								'left' => 'Left',
								'right' => 'Right',
							),
							'default' => 'right',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_title',
					'field_label' => __( 'Sidebar title', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_title',
							'default' => __( 'My Wishlist', 'addonify-wishlist' ),
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// ---------------------------------------------
		// Sidebar Show/Hide Button Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_settings',
			'section_id' => 'sidebar_btn',
			'section_label' => __( 'Sidebar Show/Hide Button Options', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-sidebar_btn_options',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_label',
					'field_label' => __( 'Button label', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_box' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_label',
							'default' => __( 'Wishlist', 'addonify-wishlist' ),
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_show_icon',
					'field_label' => __( 'Show icon in button', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_show_icon',
							'checked' => 1,
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
					'field_label' => __( 'Select Icon', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'radio_group' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'heart-style-one',
							'checked' => 1,
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon heart-style-one"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'heart-o-style-one',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon heart-o-style-one"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'heart-o-style-three',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon heart-o-style-three"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'flash',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon flash"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'tools',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon tools"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'circle-with-plus',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon circle-with-plus"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'eye',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon eye"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'loader',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon loader"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'settings',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon settings"></span>',
						),
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_btn_icon',
							'value' => 'shopping-bag',
							'label' => '<span style="font-size: 20px;" class="adfy-wishlist-icon shopping-bag"></span>',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_animate_btn',
					'field_label' => __( 'Animate button', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'sidebar_animate_btn',
							'checked' => 1,
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// ---------------------------------------------
		// Styles Options
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_styles',
			'section_id' => 'style_options',
			'section_label' => __( 'STYLE OPTIONS', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-styles',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'load_styles_from_plugin',
					'field_label' => __( 'Load Styles From Plugin', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'toggle_switch' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'load_styles_from_plugin',
							'checked' => 0,
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// ---------------------------------------------
		// Content Colors
		// ---------------------------------------------

		$settings_args = array(
			'settings_group_name' => 'wishlist_styles',
			'section_id' => 'content_colors',
			'section_label' => __( 'CONTENT COLORS', 'addonify-wishlist' ),
			'section_callback' => '',
			'screen' => $this->settings_page_slug . '-content-colors',
			'fields' => array(
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_colors',
					'field_label' => __( 'Add to Wishlist button', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'color_picker_group' ),
					'field_callback_args' => array(
						array(
							'label' => __( 'Text Color', 'addonify-wishlist' ),
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_text_color',
							'default' => '#333333',
						),
						array(
							'label' => __( 'Icon Color', 'addonify-wishlist' ),
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_icon_color',
							'default' => '#333333',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_colors_hover',
					'field_label' => '',
					'field_callback' => array( $this, 'color_picker_group' ),
					'field_callback_args' => array(
						array(
							'label' => __( 'Text Color on Hover', 'addonify-wishlist' ),
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_text_color_hover',
							'default' => '#96588a',
						),
						array(
							'label' => __( 'Icon Color on Hover', 'addonify-wishlist' ),
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_btn_icon_color_hover',
							'default' => '#96588a',
						),
					),
				),
				array(
					'field_id' => ADDONIFY_WISHLIST_DB_INITIALS . 'custom_css',
					'field_label' => __( 'Custom CSS', 'addonify-wishlist' ),
					'field_callback' => array( $this, 'text_area' ),
					'field_callback_args' => array(
						array(
							'name' => ADDONIFY_WISHLIST_DB_INITIALS . 'custom_css',
							'attr' => 'rows="5" class="large-text code"',
						),
					),
				),
			),
		);

		// create settings fields.
		$this->create_settings( $settings_args );

		// store default values.
		update_option( ADDONIFY_WISHLIST_DB_INITIALS . 'default_values', $this->default_input_values );

	}



	/**
	 * Show notification after form submission.
	 *
	 * @since    1.0.0
	 */
	public function show_form_submission_notification() {
		if ( isset( $_GET['page'] ) && $this->settings_page_slug === $_GET['page'] ) {
			settings_errors();
		}
	}




	/**
	 * Show admin error message if woocommerce is not active
	 *
	 * @since    1.0.0
	 */
	public function show_woocommerce_not_active_notice_callback() {

		if ( ! $this->is_woocommerce_active() ) {
			add_action(
				'admin_notices',
				function() {
					require ADDONIFY_WISHLIST_PLUGIN_PATH . '/admin/templates/woocommerce-not-active-notice.php';
				}
			);
		}

	}


	/**
	 * Show custom "post status" label after page title in "Pages" admin menu.
	 * shows "Addonify Wishlist Page" label after the page title.
	 *
	 * @since    1.0.0
	 * @param array  $states Post Status.
	 * @param object $post  Post object.
	 */
	public function display_custom_post_states_after_page_title( $states, $post ) {

		$wishlist_page_id = get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'wishlist_page', get_option( ADDONIFY_WISHLIST_DB_INITIALS . 'page_id' ) );

		if ( get_post_type( $post->ID ) == 'page' && $post->ID == $wishlist_page_id ) {
			$states[] = __( 'Addonify Wishlist Page', 'addonify-wishlist' );
		}

		return $states;
	}

}
