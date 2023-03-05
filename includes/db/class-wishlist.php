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

		$available_tables = $this->get_all_tables();

		foreach ( $available_tables as $_table_name ) {
			foreach ( $_table_name as $key => $value ) {
				if ( $table_name === $value ) {
					return;
				}
			}
		}

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name}(
			id BIGINT NOT NULL AUTO_INCREMENT,
			user_id BIGINT NOT NULL,
			site_url VARCHAR(250) NOT NULL,
			wishlist_name VARCHAR(100) NULL,
			wishlist_visibility ENUM('public','shared','private') NULL,
			created_at BIGINT DEFAULT (CURRENT_TIMESTAMP),
			parent_wishlist_id BIGINT NULL,
			product_id BIGINT NULL,
			product_added_at TIMESTAMP NULL,
			share_key BIGINT NULL,
			PRIMARY KEY (id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

}
