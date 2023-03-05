<?php
/**
 * Trait for performing CRUD operation on a table.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/db
 * @author     CreamCode <creamcodetech@gmail.com>
 */

/**
 * Trait for performing CRUD operation on a table.
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes/db
 * @author     CreamCode <creamcodetech@gmail.com>
 */
trait CommonDBFunctions {

	/**
	 * CMPriceAction database prefix.
	 *
	 * @var string
	 */
	private static $db_prefix = ADDONIFY_WISHLIST_DB_INITIALS;

	/**
	 * Get API failover table name.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public static function get_table_name() {

		global $wpdb;

		return $wpdb->prefix . self::$db_prefix . self::$table_name;
	}

	/**
	 * Retrive all rows from the table.
	 *
	 * @since 1.0.0
	 * @return array|false Array of row objects.
	 */
	public static function get_all_rows() {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->get_results( "SELECT * FROM {$table_name}" ); //phpcs:ignore
	}

	/**
	 * Retrive id of the row which contains the field and value.
	 *
	 * @since 1.0.0
	 * @param string $field Column.
	 * @param string $value Column value.
	 * @return int $id Row id.
	 */
	public static function get_row_id( $field, $value ) {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->get_var( "SELECT id FROM {$table_name} WHERE {$field} = '{$value}'" ); //phpcs:ignore
	}

	/**
	 * Retrive a row data from the table.
	 *
	 * @since 1.0.0
	 * @param string $field Field Name.
	 * @param string $value Field Value.
	 * @return object Row data.
	 */
	public static function get_row( $field, $value ) {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->get_row( "SELECT * FROM {$table_name} WHERE {$field}={$value}" ); //phpcs:ignore
	}

	/**
	 * Get Rows with provided field name and value
	 *
	 * @param mixed  $field Field Name.
	 * @param string $value Field Value.
	 * @param string $order_by Order Results.
	 * @return object
	 */
	public static function get_rows( $field, $value = '', $order_by = 'DESC' ) {

		global $wpdb;

		$table_name = self::get_table_name();
		$where      = '';
		$limit_     = '';
		$orderby    = '';
		if ( is_array( $field ) ) {
			$offset = isset( $field['offset'] ) ? $field['offset'] : 0;
			$limit  = isset( $field['limit'] ) ? $field['limit'] : 50;
			$limit_ = " limit {$offset}, {$limit} ";
		} else {
			$where = " WHERE {$field} = '{$value}' ";
		}
		if ( in_array( strtolower( $order_by ), array( 'asc', 'desc' ), true ) ) {
			$orderby = ' ORDER BY id ' . strtoupper( $order_by );
		}

		return $wpdb->get_results( "SELECT * FROM {$table_name} {$where} {$orderby} {$limit_}" ); //phpcs:ignore
	}

	/**
	 * Insert data in a new row in the table.
	 *
	 * @since 1.0.0
	 * @param array $data Row data.
	 * @return int|boolean Row ID if data inserted successfully, else false.
	 */
	public static function insert_row( $data ) {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->insert( $table_name, $data ) ? $wpdb->insert_id : false; //phpcs:ignore
	}

	/**
	 * Updates data of a row in the table.
	 *
	 * @param array $data Update data.
	 * @param array $where Update row condition.
	 * @return int|boolean Number of rows updated if data updated successfully, else false.
	 */
	public static function update_row( $data, $where ) {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->update( $table_name, $data, $where ); //phpcs:ignore
	}

	/**
	 * Deletes a row data from the table.
	 *
	 * @since 1.0.0
	 * @param int $id Row ID.
	 * @return int|boolean Number of rows updated if data updated successfully, else false.
	 */
	public static function delete_row( $id ) {

		if ( ! $id ) {
			return false;
		}

		global $wpdb;

		$table_name = self::get_table_name();

		$row_id = array( 'id' => $id );

		return $wpdb->delete( $table_name, $row_id ); //phpcs:ignore
	}

	/**
	 * Deletes all rows from the table.
	 *
	 * @since 1.0.0
	 * @return boolean true on success, else false.
	 */
	public static function clear_table() {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->query( "TRUNCATE TABLE {$table_name}" ); //phpcs:ignore
	}

	/**
	 * Count the rows in the table.
	 *
	 * @since 1.0.5
	 * @return string|null Database query result (as string), or null on failure.
	 */
	public static function total_rows_count() {

		global $wpdb;

		$table_name = self::get_table_name();

		return $wpdb->get_var( "SELECT COUNT(*) FROM {$table_name}" ); //phpcs:ignore
	}

	/**
	 * Get all tables.
	 */
	private function get_all_tables() {
		global $wpdb;

		return $wpdb->get_results( 'show tables', ARRAY_A ); //phpcs:ignore
	}
}
