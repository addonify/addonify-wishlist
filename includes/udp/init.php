<?php
/**
 * The file that defines the initial plugin functions
 *
 * A hooks definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://addonify.com/
 * @since      1.0.0
 *
 * @package    Udp_agent
 */

// Declared global so they can be used in multiple plugins.
// For addressing issues caused by having function declared with same name in multiple plugins.
global $this_agent_ver, $engine_url, $root_dir, $udp_admin_notice_displayed;

// -------------------------------------------
// Config
// -------------------------------------------

$engine_url     = 'https://udp.creamcode.org/';
$this_agent_ver = '1.0.0';

// -------------------------------------------
// Which agent to load ?
// -------------------------------------------
$root_dir             = dirname( dirname( __DIR__ ) );
$all_installed_agents = get_option( 'udp_installed_agents', array() );
$this_agent_is_latest = true;

// make sure this agent is the latest.
foreach ( $all_installed_agents as $agent_ver ) {
	if ( version_compare( $agent_ver, $this_agent_ver ) > 0 ) {
		$this_agent_is_latest = false;
		break;
	}
}

if ( ! isset( $all_installed_agents[ basename( $root_dir ) ] ) ) {
	$installed_agents                          = get_option( 'udp_installed_agents', array() );
	$installed_agents[ basename( $root_dir ) ] = $this_agent_ver;

	// register this agent locally.
	update_option( 'udp_installed_agents', $installed_agents );
}

// load this agent, only if it is the latest version and this agent is installed.
if ( $this_agent_is_latest && isset( $all_installed_agents[ basename( $root_dir ) ] ) ) {
	if ( ! class_exists( 'Udp_Agent' ) ) {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . '/udp/class-udp-agent.php';
	}
	new Udp_Agent( $this_agent_ver, $root_dir, $engine_url, $udp_admin_notice_displayed );
	if ( ! isset( $udp_admin_notice_displayed ) || ! $udp_admin_notice_displayed ) {
		$udp_admin_notice_displayed = true;
		add_action(
			'admin_init',
			function () {
				$root_dir = dirname( dirname( __DIR__ ) );

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
				$plugin_file = $root_dir . DIRECTORY_SEPARATOR . basename( $root_dir ) . '.php';
				$plugin_data = get_file_data(
					$plugin_file,
					array(
						'name' => 'Plugin Name',
					)
				);

				$agent_name = $plugin_data['name'];

				$content = '<p>' . sprintf(
					/* translators: %s: agent name */
					__( '%s is asking to allow tracking your non-sensitive WordPress data?', 'udp-agent' ),
					$agent_name
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
				add_action(
					'load-index.php',
					function () use ( $content ) {
						add_action(
							'admin_notices',
							function() use ( $content ) {
								$class = 'is-dismissible  notice notice-warning';
								printf( '<div class="%1$s">%2$s</div>', esc_attr( $class ), wp_kses_post( $content ) );
							}
						);
					}
				);
			}
		);
	}
}

// -------------------------------------------
// Agent Activation
// -------------------------------------------

// for plugin.
register_activation_hook(
	$root_dir . DIRECTORY_SEPARATOR . basename( $root_dir ) . '.php',
	function () use ( $this_agent_ver, $engine_url ) {
		$root_dir = dirname( dirname( __DIR__ ) );

		// authorize this agent with engine.
		if ( ! class_exists( 'Udp_Agent' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '/udp/class-udp-agent.php';
		}
		$agent = new Udp_Agent( $this_agent_ver, $root_dir, $engine_url );
		$agent->do_handshake();

		// show admin notice if user selected "no" but new agent is installed.
		$show_admin_notice = get_option( 'udp_agent_allow_tracking' );
		if ( 'no' === $show_admin_notice ) {
			$active_agent = get_option( 'udp_active_agent_basename' );
			if ( basename( $root_dir ) !== $active_agent ) {
				update_option( 'udp_active_agent_basename', basename( $root_dir ) );
				delete_option( 'udp_agent_allow_tracking' );
			}
		}
	}
);

if ( ! function_exists( 'cc_udp_agent_send_data_on_action' ) ) {
	/**
	 * Send data on theme/plugin activation and plugin deactivation.
	 *
	 * @param string $root_dir Root Directory Path.
	 */
	function cc_udp_agent_send_data_on_action( $root_dir ) {
		global $this_agent_ver, $engine_url;

		// authorize this agent with engine.
		if ( ! class_exists( 'Udp_Agent' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '/udp/class-udp-agent.php';
		}
		$agent = new Udp_Agent( $this_agent_ver, $root_dir, $engine_url );
		$agent->send_data_to_engine();
	}
}

add_action( 'cc_udp_agent_send_data', 'cc_udp_agent_send_data_on_action' );

/**
 * Schedule data send on theme switch & update agent basename
 */
add_action(
	'after_switch_theme',
	function() use ( $root_dir ) {
		global $this_agent_ver;

		wp_schedule_single_event( time() + 10, 'cc_udp_agent_send_data', array( $root_dir ) );

		$installed_agents                          = get_option( 'udp_installed_agents', array() );
		$installed_agents[ basename( $root_dir ) ] = $this_agent_ver;

		// register this agent locally.
		update_option( 'udp_installed_agents', $installed_agents );

		// show admin notice if user selected "no" but new agent is installed.
		$show_admin_notice = get_option( 'udp_agent_allow_tracking' );
		if ( 'no' === $show_admin_notice ) {
			$active_agent = get_option( 'udp_active_agent_basename' );
			if ( basename( $root_dir ) !== $active_agent ) {
				update_option( 'udp_active_agent_basename', basename( $root_dir ) );
				delete_option( 'udp_agent_allow_tracking' );
			}
		}
	}
);


/**
 * Schedule data send on plugin activation
 */
add_action(
	'activate_plugin',
	function() use ( $root_dir ) {
		wp_schedule_single_event( time() + 10, 'cc_udp_agent_send_data', array( $root_dir ) );
	}
);

/**
 * Schedule data send on plugin deactivation
 */
add_action(
	'deactivate_plugin',
	function() use ( $root_dir ) {
		wp_schedule_single_event( time() + 10, 'cc_udp_agent_send_data', array( $root_dir ) );
	}
);

// -------------------------------------------
// Agent De-activation
// -------------------------------------------

// for plugin.
register_deactivation_hook(
	$root_dir . DIRECTORY_SEPARATOR . basename( $root_dir ) . '.php',
	function () use ( $root_dir ) {

		$installed_agents = get_option( 'udp_installed_agents', array() );
		if ( isset( $installed_agents[ basename( $root_dir ) ] ) ) {
			unset( $installed_agents[ basename( $root_dir ) ] );
		}

		// remove this agent from the list of active agents.
		update_option( 'udp_installed_agents', $installed_agents );
		$timestamp = wp_next_scheduled( 'udp_agent_cron' );
		wp_unschedule_event( $timestamp, 'udp_agent_cron' );
	}
);

// for theme.
add_action(
	'switch_theme',
	function () use ( $root_dir ) {

		$installed_agents = get_option( 'udp_installed_agents', array() );
		if ( isset( $installed_agents[ basename( $root_dir ) ] ) ) {
			unset( $installed_agents[ basename( $root_dir ) ] );
		}

		// remove this agent from the list of active agents.
		update_option( 'udp_installed_agents', $installed_agents );
	}
);
