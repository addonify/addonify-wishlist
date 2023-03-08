<?php
/**
 * Wishlist table CRUD.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/db
 * @author     CreamCode <creamcodetech@gmail.com>
 */

namespace Addonify;

/**
 * Database common query functions trait.
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'db/db-common/commondbfunctions.php';

/**
 * Wishlist table CRUD Class.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/db
 * @author     CreamCode <creamcodetech@gmail.com>
 */
class Wishlist {

	use \CommonDBFunctions;

	/**
	 * Table name.
	 *
	 * @var string $table_name
	 */
	private static $table_name = 'table';

	/**
	 * Create table if not exists.
	 */
	public function create_table() {
		$table_name = $this->get_table_name();

		if ( $this->check_table_exists( $table_name ) ) {
			return;
		}

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name}(
			id BIGINT NOT NULL AUTO_INCREMENT,
			user_id BIGINT NOT NULL,
			site_url VARCHAR(250) NOT NULL,
			wishlist_name VARCHAR(100) NULL,
			wishlist_visibility ENUM('public','shared','private') NULL,
			created_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP),
			parent_wishlist_id BIGINT NULL,
			product_id BIGINT NULL,
			product_added_at TIMESTAMP NULL,
			share_key BIGINT NULL,
			PRIMARY KEY (id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Check if table exists.
	 *
	 * @param string $table_name Table name.
	 * @return bool
	 */
	private function check_table_exists( $table_name ) {
		$available_tables = $this->get_all_tables();

		foreach ( $available_tables as $_table_name ) {
			foreach ( $_table_name as $key => $value ) {
				if ( $table_name === $value ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Seeding wishlist table.
	 *
	 * @param int $wishlist_name Wishlist name.
	 * @param int $wishlist_visibility Wishlist visibility.
	 */
	public function seed_wishlist_table( $wishlist_name = false, $wishlist_visibility = false ) {
		$insert_data = array(
			'user_id'             => get_current_user_id(),
			'site_url'            => get_bloginfo( 'url' ),
			'wishlist_name'       => $wishlist_name ? $wishlist_name : 'Default Wishlist',
			'wishlist_visibility' => $wishlist_visibility ? $wishlist_visibility : 'public',
		);

		return $this->insert_row( $insert_data );
	}

}
