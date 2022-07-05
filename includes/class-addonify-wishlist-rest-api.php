<?php 
/**
 * The class to define REST API endpoints used in settings page.
 *
 * This is used to define REST API endpoints used in admin settings page to get and update settings values.
 *
 * @since      1.0.7
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 * @author     Addonify <contact@addonify.com>
 */
if ( ! class_exists( 'Addonify_Wishlist_Rest_API' ) ) {

    class Addonify_Wishlist_Rest_API 
    {

        /**
         * The namespace of the Rest API.
         *
         * @since    1.0.7
         * @access   protected
         * @var      string    $rest_namespace.
         */
        protected $rest_namespace = 'addonify_wishlist_options_api';


        /**
         * Register new REST API endpoints.
         *
         * @since    1.0.7
         */
        public function __construct() {

            add_action( 'rest_api_init', array( $this, 'register_rest_endpoints' ) );
        }


        /**
         * Define the REST API endpoints to get all setting options and update all setting options.
         *
         * @since    1.0.7
         * @access   public
         */
        public function register_rest_endpoints() {

            register_rest_route(
                $this->rest_namespace,
                '/get_options',
                array(
                    'methods'   => 'GET',
                    'callback'  => array( $this, 'rest_handler_get_settings_fields' ),
                    'permission_callback' => array( $this, 'permission_callback' ),
                )
            );

            register_rest_route(
                $this->rest_namespace,
                '/update_options',
                array(
                    'methods'   => \WP_REST_Server::CREATABLE,
                    'callback'  => array( $this, 'rest_handler_update_options' ),
                    'permission_callback' => array( $this, 'permission_callback' )
                )
            );
        }


        /**
         * Callback function to get all settings options values.
         * 
         * @since    1.0.7
         */
        public function rest_handler_get_settings_fields() {

            return addonify_wishlist_get_settings_fields();
        }


        /**
         * Callback function to update all settings options values.
         * 
         * @since    1.0.7
         * @param    \WP_REST_Request    $request    The request object.
         * @return   \WP_REST_Response   $return_data   The response object.
         */
        public function rest_handler_update_options( $request ) {

            $return_data = array(
                'success' => false,
                'message' => __( 'Ooops, error saving settings!!!', 'addonify-wishlist' ),
            );

            $params = $request->get_params(); 

            if ( ! isset( $params['settings_values'] ) ) {

                $return_data['message'] = __( 'No settings values to update!!!', 'addonify-wishlist' );
                return $return_data;
            }

            if ( addonify_wishlist_update_settings( $params['settings_values'] ) === true ) {

                $return_data['success'] = true;
                $return_data['message'] = __( 'Settings saved successfully', 'addonify-wishlist' );
            } 

            return rest_ensure_response( $return_data );
        }



        /**
         * Permission callback function to check if current user can access the rest api route.
         * 
         * @since    1.0.7
         */
        public function permission_callback() {

            if ( ! current_user_can( 'manage_options' ) ) {

                return new WP_Error( 'rest_forbidden', esc_html__( 'Ooops, you are allowed to manage options.', 'addonify-wishlist' ), array( 'status' => 401 ) );
            } 
            
            return true;
        }
    }
}