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
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			parent_wishlist_id BIGINT NULL,
			product_id BIGINT NULL,
			share_key BIGINT NULL,
			PRIMARY KEY (id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Delete wishlist table.
	 */
	public function delete_table() {
		global $wpdb;
		$table_name = $this->get_table_name();
		$sql        = "DROP TABLE IF EXISTS `$table_name`;";
		$wpdb->query( $sql ); //phpcs:ignore
	}

	/**
	 * Check if table exists.
	 *
	 * @param string $table_name Table name.
	 * @return bool
	 */
	public function check_table_exists( $table_name ) {
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
	 * Migrate old usermeta wishlist data to new table.
	 */
	public function migrate_wishlist_data() {
		if ( ! $this->check_wishlist_table_exists() ) {
			return;
		}
		$wishlist_data = get_user_meta( get_current_user_id(), 'addonify-wishlist', true );
		if ( ! empty( $wishlist_data ) ) {
			$wishlist_data = json_decode( $wishlist_data, true );

			foreach ( $wishlist_data as $index => $row ) {
				$insert_data = array();

				$wishlist_name = 'Default Wishlist';

				$insert_data['site_url']            = $index;
				$insert_data['user_id']             = get_current_user_id();
				$insert_data['wishlist_name']       = $wishlist_name;
				$insert_data['wishlist_visibility'] = 'public';

				$wishlist_id = $this->insert_row( $insert_data );

				$wishlist_single_data = (array) $row[ array_key_first( $row ) ];
				if ( $wishlist_id && ! empty( $wishlist_single_data['products'] ) ) {
					$insert_data = array();
					foreach ( $wishlist_single_data['products'] as $i => $product_id ) {
						$insert_data[ $i ]['site_url']           = $index;
						$insert_data[ $i ]['user_id']            = get_current_user_id();
						$insert_data[ $i ]['product_id']         = $product_id;
						$insert_data[ $i ]['parent_wishlist_id'] = $wishlist_id;
					}
					$this->insert_multiple_rows( $insert_data );
				}
			}
			delete_user_meta( get_current_user_id(), 'addonify-wishlist' );
		}
	}

	/**
	 * Seeding wishlist table.
	 *
	 * @param int $wishlist_name Wishlist name.
	 * @param int $wishlist_visibility Wishlist visibility.
	 *
	 * @return int|false Returns wishlist row id on success, false otherwise.
	 */
	public function seed_wishlist_table( $wishlist_name = false, $wishlist_visibility = false ) {
		$insert_data = array(
			'user_id'             => get_current_user_id(),
			'site_url'            => get_bloginfo( 'url' ),
			'wishlist_name'       => $wishlist_name ? $wishlist_name : 'Default Wishlist',
			'wishlist_visibility' => $wishlist_visibility ? $wishlist_visibility : 'public',
			'share_key'           => addonify_wishlist_reverse_num( time() ),
		);

		return $this->insert_row( $insert_data );
	}

	/**
	 * Check if wishlist table is created.
	 */
	public function check_wishlist_table_exists() {
		$wishlist   = new Wishlist();
		$table_name = $wishlist->get_table_name();

		return $this->check_table_exists( $table_name );
	}

	/**
	 * Get wishlist ID from product ID.
	 *
	 * @param int $product_id Product ID.
	 */
	public function get_wishlist_id_from_product_id( $product_id ) {
		if ( $this->check_wishlist_table_exists() ) {
			$where = array(
				'site_url'   => get_bloginfo( 'url' ),
				'product_id' => $product_id,
				'user_id'    => get_current_user_id(),
			);

			$wishlist = $this->get_row( $where );
			if ( ! empty( $wishlist ) ) {
				return $wishlist->parent_wishlist_id;
			}
		}
		return false;
	}

	/**
	 * Remove all wishlist options from options table.
	 */
	public function remove_wishlist_options() {
		global $wpdb;
		$wpdb->query( "delete from $wpdb->options where option_name regexp '" . ADDONIFY_WISHLIST_DB_INITIALS . ".*'" ); // phpcs:ignore
	}
}

global $addonify_wishlist;
$addonify_wishlist = new Wishlist();
