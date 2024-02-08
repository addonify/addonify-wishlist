<?php
/**
 * Wishlist table CRUD.
 *
 * @link       https://www.addonify.com
 * @since      2.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

/**
 * Database common query functions trait.
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/addonify-wishlist-database-trait.php';

/**
 * Wishlist table CRUD Class.
 *
 * @link       https://www.addonify.com
 * @since      2.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */
class Addonify_Wishlist_Database_Handler {

	use Addonify_Wishlist_Database_Trait;

	/**
	 * Create table if not exists.
	 */
	public function create_table() {

		$table_name = $this->get_table_name();

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

		$table_exists = false;

		$available_tables = $this->get_all_tables();

		foreach ( $available_tables as $_table_name ) {
			foreach ( $_table_name as $key => $value ) {
				if ( $table_name === $value ) {
					$table_exists = true;
				}
			}
		}

		return $table_exists;
	}

	/**
	 * Migrate old usermeta wishlist data to new table.
	 *
	 * @param int $user_id User ID.
	 */
	public function migrate_wishlist_data( $user_id ) {

		$wishlist_data = get_user_meta( $user_id, 'addonify-wishlist', true );

		if ( ! empty( $wishlist_data ) ) {

			$wishlist_data = json_decode( $wishlist_data, true );

			foreach ( $wishlist_data as $index => $row ) {

				$insert_data = array();

				$wishlist_name = apply_filters( 'addonify_wishist_default_wishlist_name', esc_html__( 'Default Wishlist', 'addonify-wishlist' ) );

				$insert_data['site_url']            = $index;
				$insert_data['user_id']             = $user_id;
				$insert_data['wishlist_name']       = $wishlist_name;
				$insert_data['wishlist_visibility'] = 'private';

				$wishlist_id = $this->insert_row( $insert_data );

				// Set default wishlist in the user meta.
				addonify_wishlist_set_user_default_wishlist_in_meta( $user_id, $wishlist_id );

				$wishlist_single_data = (array) $row[ array_key_first( $row ) ];
				if ( $wishlist_id && ! empty( $wishlist_single_data['products'] ) ) {
					$insert_data = array();
					foreach ( $wishlist_single_data['products'] as $i => $product_id ) {
						$insert_data[ $i ]['site_url']           = $index;
						$insert_data[ $i ]['user_id']            = $user_id;
						$insert_data[ $i ]['product_id']         = $product_id;
						$insert_data[ $i ]['parent_wishlist_id'] = $wishlist_id;
					}
					$this->insert_multiple_rows( $insert_data );
				}
			}

			delete_user_meta( $user_id, 'addonify-wishlist' );
		} else {

			$this->seed_wishlist_table( $user_id );
		}
	}

	/**
	 * Seeding wishlist table.
	 *
	 * @param int $user_id WP_User ID.
	 *
	 * @return int|false Returns wishlist row id on success, false otherwise.
	 */
	public function seed_wishlist_table( $user_id ) {

		$insert_data = array(
			'user_id'             => $user_id,
			'site_url'            => get_site_url(),
			'wishlist_name'       => apply_filters( 'addonify_wishist_default_wishlist_name', esc_html__( 'Default Wishlist', 'addonify-wishlist' ) ),
			'wishlist_visibility' => 'private',
			'share_key'           => $this->reverse_num( time() ),
		);

		$wishlist_id = $this->insert_row( $insert_data );

		// Set default wishlist in the user meta.
		addonify_wishlist_set_user_default_wishlist_in_meta( $user_id, $wishlist_id );

		return $wishlist_id;
	}

	/**
	 * Check if wishlist table is created.
	 */
	public function check_wishlist_table_exists() {

		$table_name = $this->get_table_name();

		return $this->check_table_exists( $table_name );
	}

	/**
	 * Remove all wishlist options from options table.
	 */
	public function remove_wishlist_options() {

		global $wpdb;

		$wpdb->query( "delete from $wpdb->options where option_name regexp '" . ADDONIFY_WISHLIST_DB_INITIALS . ".*'" ); // phpcs:ignore
	}

	/**
	 * Get number reversed.
	 *
	 * @since 1.0.0
	 *
	 * @param int $num Any number.
	 *
	 * @return int Number reversed.
	 */
	public function reverse_num( $num ) {

		$num    = absint( $num );
		$revnum = 0;
		while ( $num > 1 ) {
			$rem    = $num % 10;
			$revnum = ( $revnum * 10 ) + $rem;
			$num    = ( $num / 10 );
		}
		return $revnum;
	}
}
