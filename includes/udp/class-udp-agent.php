<?php
/**
 * UDP Agent collects non-sensitive data.
 *
 * @link       https://creamcode.org/user-data-processing/
 * @since      1.0.0
 * @author     CreamCode <contact@creamcode.org>
 * @package    Udp_Agent
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * UDP Agent class.
 */
class Udp_Agent {

	/**
	 * Name of this agents parent.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $agent_name Name of this agents parent.
	 */
	private $agent_name;

	/**
	 * Engine URL.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $engine url URL to send wp rest api connection request.
	 */
	private $engine_url;

	/**
	 * Agent's parent folder location
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $agent_root_dir Path to this agents parent folder.
	 */
	private $agent_root_dir;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $ver            Version of this agent.
	 * @param      string $agent_root_dir Path to this agents parent folder.
	 * @param      string $engine_url     URL to Engine server.
	 */
	public function __construct( $ver, $agent_root_dir, $engine_url ) {

		$this->version        = $ver;
		$this->engine_url     = $engine_url;
		$this->agent_root_dir = $agent_root_dir;

		$this->hooks();

	}


	// ----------------------------------------------
	// Hooks.
	// ----------------------------------------------

	/**
	 * All hooks will be called from this method.
	 *
	 * @since    1.0.0
	 */
	private function hooks() {
		add_action( 'init', array( $this, 'on_init' ) );
		add_action( 'admin_init', array( $this, 'on_admin_init' ) );

		// custom cron.
		add_action( 'init', array( $this, 'udp_schedule_cron' ) );
	}


	/**
	 * Action that needs to be run on "init" hook.
	 *
	 * @since    1.0.0
	 */
	public function on_init() {
		// process user tracking actions.
		if ( isset( $_GET['udp-agent-allow-access'] ) ) { //phpcs:ignore
			$this->process_user_tracking_choice();
		}

	}

	/**
	 * Actions that needs to be run on "admin init" hook.
	 *
	 * @since    1.0.0
	 */
	public function on_admin_init() {

		$this->show_user_tracking_admin_notice();

		// register and save settings data.
		register_setting(
			'general',
			'udp_agent_allow_tracking',
			array(
				'sanitize_callback' => array( $this, 'get_settings_field_val' ),
			)
		);

		// show ui in settings page.
		add_settings_field(
			'udp_agent_allow_tracking',
			__( 'Allow Anonymous Tracking', 'udp-agent' ),
			array( $this, 'show_settings_ui' ),
			'general',
			'default',
			array(
				'label_for' => 'udp_agent_allow_tracking',
			)
		);
	}


	/**
	 * Change the value of checkbox ( in settings page ) from integer to "yes" or "no"
	 * and store in database.
	 *
	 * @since    1.0.0
	 * @param    string $data Data to modify.
	 */
	public function get_settings_field_val( $data ) {
		if ( '1' === $data ) {
			return 'yes';
		} else {
			return 'no';
		}

	}


	// ----------------------------------------------
	// Settings page UI.
	// ----------------------------------------------

	/**
	 * Generate markups to show in settings page.
	 *
	 * @since    1.0.0
	 */
	public function show_settings_ui() {
		echo '<p>';
		echo "<input type='checkbox' name='udp_agent_allow_tracking' id='udp_agent_allow_tracking' value='1'";
		if ( 'yes' === get_option( 'udp_agent_allow_tracking' ) ) {
			echo ' checked';
		}
		echo '/>';
		echo wp_kses_data( 'Become a super contributor by sharing your non-sensitive WordPress data. We guarantee no sensitive data is collected. <a href="https://creamcode.org/user-data-processing/" target="_blank" >What data do we collect?</a>' ) . ' </p>';
	}


	// ----------------------------------------------
	// Show admin notice, for collecting user data.
	// ----------------------------------------------

	/**
	 * Show admin notice to collect user data.
	 *
	 * @since    1.0.0
	 */
	public function show_user_tracking_admin_notice() {

		$show_admin_notice = true;
		$users_choice      = get_option( 'udp_agent_allow_tracking' );

		if ( 'later' !== $users_choice && ! empty( $users_choice ) ) {

			// user has already clicked "yes" or "no" in admin notice.
			// do not show this notice.
			$show_admin_notice = false;

		} else {

			$tracking_msg_last_shown_at = intval( get_option( 'udp_agent_tracking_msg_last_shown_at' ) );

			if ( $tracking_msg_last_shown_at > ( time() - ( DAY_IN_SECONDS * 3 ) ) ) {
				// do not show,
				// if last admin notice was shown less than 1 day ago.
				$show_admin_notice = false;
			}
		}

		if ( ! $show_admin_notice ) {
			return;
		}
		$content = '<p>' . sprintf(
			/* translators: %s: agent name */
			__( '%s is asking to allow tracking your non-sensitive WordPress data?', 'udp-agent' ),
			$this->find_agent_name( $this->agent_root_dir )
		) . '</p><p>';

		$content .= sprintf(
			/* translators: %s: agent allow access link, %s: Allow */
			__( '<a href="%1$s" class="button button-primary udp-agent-access_tracking-yes" style="margin-right: 10px" >%2$s</a>', 'udp-agent' ),
			add_query_arg( 'udp-agent-allow-access', 'yes' ),
			'Allow'
		);

		$content .= sprintf(
			/* translators: %s: agent allow access link, %s: Allow */
			__( '<a href="%1$s" class="button button-secondary udp-agent-access_tracking-no" style="margin-right: 10px" >%2$s</a>', 'udp-agent' ),
			add_query_arg( 'udp-agent-allow-access', 'no' ),
			'Do not show again'
		);

		$content .= sprintf(
			/* translators: %s: agent allow access link, %s: Allow */
			__( '<a href="%1$s" class="button button-secondary udp-agent-access_tracking-yes" style="margin-right: 10px" >%2$s</a>', 'udp-agent' ),
			add_query_arg( 'udp-agent-allow-access', 'later' ),
			'Later'
		);

		$content .= '</p>';
		$this->show_admin_notice( 'warning', $content );
	}



	/**
	 * User has decided to allow or not allow user tracking.
	 * save this value in database.
	 *
	 * @since    1.0.0
	 */
	private function process_user_tracking_choice() {
		$users_choice = isset( $_GET['udp-agent-allow-access'] ) ? sanitize_text_field( wp_unslash( $_GET['udp-agent-allow-access'] ) ) : ''; //phpcs:ignore

		if ( empty( $users_choice ) ) {
			return;
		}

		// add data into database.
		update_option( 'udp_agent_allow_tracking', $users_choice );
		if ( 'yes' === $users_choice ) {
			$this->do_handshake();
		}
		update_option( 'udp_agent_tracking_msg_last_shown_at', time() );

		// redirect back.
		wp_safe_redirect( remove_query_arg( 'udp-agent-allow-access' ) );
		exit;

	}


	/**
	 * A little helper function to show admin notice.
	 *
	 * @since    1.0.0
	 * @param string $error_class Error Class/Type.
	 * @param string $msg Message.
	 */
	private function show_admin_notice( $error_class, $msg ) {
		add_action(
			'load-index.php',
			function () use ( $error_class, $msg ) {
				add_action(
					'admin_notices',
					function() use ( $error_class, $msg ) {
						$class = 'is-dismissible  notice notice-' . $error_class;
						printf( '<div class="%1$s">%2$s</div>', esc_attr( $class ), wp_kses_post( $msg ) );
					}
				);
			}
		);

	}


	// ----------------------------------------------
	// Data collection and authentication with engine.
	// ----------------------------------------------

	/**
	 * Gather data to send to engine.
	 *
	 * @since    1.0.0
	 */
	private function get_data() {

		if ( ! class_exists( 'WP_Debug_Data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-debug-data.php';
			require_once ABSPATH . 'wp-includes/load.php';
			require_once ABSPATH . 'wp-admin/includes/update.php';
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			require_once ABSPATH . 'wp-admin/includes/misc.php';
		}

		if ( ! class_exists( 'WP_Site_Health' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-site-health.php';
		}

		$data = array();

		$site        = wp_parse_url( get_site_url() );
		$site_scheme = array_key_exists( 'scheme', $site ) ? $site['scheme'] . '://' : '';
		$site_host   = array_key_exists( 'host', $site ) ? $site['host'] : '';
		$site_port   = array_key_exists( 'port', $site ) ? ':' . $site['port'] : '';

		$data['data']            = WP_Debug_Data::debug_data();
		$data['site_url']        = $site_scheme . $site_host . $site_port;
		$data['site_user_email'] = get_bloginfo( 'admin_email' );
		$plugin_directory        = untrailingslashit( dirname( __FILE__, 3 ) );
		$dir_names               = explode( '/', $plugin_directory );
		if ( strpos( $dir_names[ count( $dir_names ) - 1 ], '\\' ) ) {
			$dir_names = explode( '\\', $dir_names[ count( $dir_names ) - 1 ] );
		}
		$plugin_name           = array_pop( $dir_names );
		$this_plugin_data      = get_plugin_data( $plugin_directory . '/' . $plugin_name . '.php' );
		$data['sender_client'] = $this_plugin_data['Name'];

		return $data;

	}



	/**
	 * Authotrize this agent to send data to engine.
	 * get secret key from engine
	 * run on agent activation.
	 *
	 * @since    1.0.0
	 */
	public function do_handshake() {

		$track_user = get_option( 'udp_agent_allow_tracking' );

		if ( 'yes' !== $track_user ) {
			// do not send data.
			return;
		}

		// secret key will be same for all agents.
		$secret_key = get_option( 'udp_agent_secret_key' );
		if ( ! empty( $secret_key ) ) {

			// secret_key already exists.
			// do nothing.
			return true;
		}

		// authenticate with engine.

		$data['agent_data'] = serialize( $this->get_data() ); //phpcs:ignore
		$data['site_url']   = get_bloginfo( 'url' );
		$url                = untrailingslashit( $this->engine_url ) . '/wp-json/udp-engine/v1/handshake';

		// get secret key from engine.
		$secret_key = json_decode( $this->do_curl( $url, $data ) );

		if ( empty( $secret_key ) ) {
			error_log( __FUNCTION__ . ' : Cannot get secret key from engine.' ); //phpcs:ignore
			return false;
		}

		if ( isset( $secret_key->secret_key ) ) {
			// save secret_key into db.
			update_option( 'udp_agent_secret_key', $secret_key->secret_key );
		} else {
			error_log( __FUNCTION__ . $secret_key->message ); //phpcs:ignore
			return false;
		}

		return true;

	}


	/**
	 * Find agent's parent's name. It can be theme or plugin.
	 *
	 * @since    1.0.0
	 * @param    string $root_dir Path to root folder of the agents parent.
	 */
	private function find_agent_name( $root_dir ) {

		if ( ! empty( $this->agent_name ) ) {
			return $this->agent_name;
		}

		$agent_name = '';

		if ( file_exists( $root_dir . '/functions.php' ) ) {
			// it is a theme
			// return get_style.

			$my_theme = wp_get_theme( basename( $root_dir ) );
			if ( $my_theme->exists() ) {
				$agent_name = $my_theme->get( 'Name' );
			}
		} else {
			// it is a plugin.
			$plugin_file = $this->agent_root_dir . DIRECTORY_SEPARATOR . basename( $this->agent_root_dir ) . '.php';
			$plugin_data = get_file_data(
				$plugin_file,
				array(
					'name' => 'Plugin Name',
				)
			);

			$agent_name = $plugin_data['name'];
		}
		$this->agent_name = $agent_name;
		return $agent_name;
	}


	// ------------------------------------------------
	// Cron
	// ------------------------------------------------

	/**
	 * Custom cron job, runs daily
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function udp_schedule_cron() {

		$cron_hook_name = 'udp_agent_cron';
		add_action( $cron_hook_name, array( $this, 'send_data_to_engine' ) );

		if ( ! wp_next_scheduled( $cron_hook_name ) ) {
			wp_schedule_event( time(), 'daily', $cron_hook_name );
		}

	}

	/**
	 * Custom cron job callback function.
	 * Send data collected from agent to engine.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function send_data_to_engine() {

		$track_user = get_option( 'udp_agent_allow_tracking' );

		if ( 'yes' !== $track_user ) {
			// do not send data.
			return;
		}

		$data_to_send['agent_data'] = serialize( $this->get_data() ); //phpcs:ignore
		$data_to_send['secret_key'] = get_option( 'udp_agent_secret_key' );
		$url                        = untrailingslashit( $this->engine_url ) . '/wp-json/udp-engine/v1/process-data';
		$this->write_log( __FUNCTION__ . $this->do_curl( $url, $data_to_send ) );
		exit;

	}

	/**
	 * Function used for debugging.
	 * Writes in the log file.
	 *
	 * @param string $log Message to be logged.
	 */
	private function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) ); //phpcs:ignore
			} else {
				error_log( $log ); //phpcs:ignore
			}
		}
	}

	/**
	 * A little helper function to do curl request.
	 *
	 * @since    1.0.0
	 * @param string $url URL.
	 * @param array  $data_to_send Data to send.
	 * @return mixed $response Response from curl request.
	 */
	private function do_curl( $url, $data_to_send ) {
		if ( empty( $url ) ) {
			return;
		}

		$args = array(
			'body' => $data_to_send,
		);

		$return_data = wp_remote_post( $url, $args );

		return wp_remote_retrieve_body( $return_data );
	}

}
