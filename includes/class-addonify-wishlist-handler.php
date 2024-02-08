<?php
/**
 * The file that defines the wishlist class for wishlist related operations.
 *
 * @link       https://www.addonify.com
 * @since      2.0.0
 *
 * @package    Addonify_Wishlist
 * @subpackage Addonify_Wishlist/includes
 */

/**
 * Class for wishlist fetch and manipulation.
 */
class Addonify_Wishlist_Handler {

	/**
	 * Wishlist database handler class object.
	 *
	 * @access protected
	 *
	 * @var object $database_handler
	 */
	protected $database_handler;

	/**
	 * Stores this Object instance.
	 *
	 * @access protected
	 *
	 * @var array $instance
	 */
	protected static $instance;

	/**
	 * Stores current user id.
	 *
	 * @access protected
	 *
	 * @var int $current_user_id
	 */
	protected $current_user_id;

	/**
	 * Stores current site url.
	 *
	 * @access protected
	 *
	 * @var string $current_site_url
	 */
	protected $current_site_url;

	/**
	 * Stores user's default wishlist ID.
	 *
	 * @access protected
	 *
	 * @var string $default_wishlist_id
	 */
	protected $default_wishlist_id;

	/**
	 * Class constructor.
	 */
	public function __construct() {

		$this->database_handler = new Addonify_Wishlist_Database_Handler();

		$this->maybe_generate_share_key();

		$this->current_user_id     = get_current_user_id();
		$this->current_site_url    = get_site_url();
		$this->default_wishlist_id = $this->get_default_wishlist_id( $this->current_user_id );
	}

	/**
	 * Get an object instance of this class.
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( ! ( is_array( self::$instance ) && array_key_exists( 'instance', self::$instance ) ) ) {
			self::$instance['instance'] = new Addonify_Wishlist_Handler();
		}

		return self::$instance['instance'];
	}

	/**
	 * Get all wishlists data associated to a user.
	 *
	 * @since 1.0.0
	 */
	public function get_user_wishlists_data() {

		$query_results = $this->database_handler->get_rows(
			array(
				'user_id'  => $this->current_user_id,
				'site_url' => $this->current_site_url,
			)
		);

		$user_wishlists_data = array();

		if ( is_array( $query_results ) && ! empty( $query_results ) ) {
			foreach ( $query_results as $row ) {
				if ( ! empty( $row->wishlist_name ) ) {
					$user_wishlists_data[ $row->id ]['name']       = $row->wishlist_name;
					$user_wishlists_data[ $row->id ]['visibility'] = $row->wishlist_visibility;
					$user_wishlists_data[ $row->id ]['share_key']  = $row->share_key;
					$user_wishlists_data[ $row->id ]['created_at'] = $row->created_at;
				} else {
					$user_wishlists_data[ $row->parent_wishlist_id ]['product_ids'][] = (int) $row->product_id;
				}
			}
		}

		return $user_wishlists_data;
	}

	/**
	 * Save product in wishlist.
	 *
	 * @param int $product_id  Product ID.
	 * @param int $wishlist_id Wishlist ID (Optional) (If not provided, default wishlist id is used. Useful when multi wishlist option is disabled).
	 * @return boolean True if saved, false otherwise.
	 */
	public function add_to_wishlist( $product_id = 0, $wishlist_id = 0 ) {

		if ( ! $product_id ) {
			return false;
		}

		if ( 0 === $wishlist_id ) {
			$wishlist_id = $this->default_wishlist_id;
		}

		// If there is no default wishlist set for a user.
		if ( 0 === $wishlist_id ) {
			return false;
		}

		$return_boolean = false;

		$insert_id = $this->database_handler->insert_row(
			array(
				'user_id'            => $this->current_user_id,
				'site_url'           => $this->current_site_url,
				'parent_wishlist_id' => $wishlist_id,
				'product_id'         => (int) $product_id,
			)
		);

		if ( $insert_id ) {
			$return_boolean = true;
		}

		return $return_boolean;
	}

	/**
	 * Remove product from the wishlist if product is already in the wishlist.
	 *
	 * @param int $product_id Product ID.
	 * @param int $parent_wishlist_id Wishlist ID (Optional) (If not provided, default wishlist id is used. Useful when multi wishlist option is disabled).
	 * @return boolean true if removed successfully otherwise false.
	 */
	public function remove_from_wishlist( $product_id, $parent_wishlist_id = 0 ) {

		if ( ! $product_id ) {
			return false;
		}

		if ( 0 === $parent_wishlist_id ) {
			$parent_wishlist_id = $this->default_wishlist_id;
		}

		$wishlist_items = $this->get_wishlist_items( $parent_wishlist_id );

		if ( in_array( (int) $product_id, $wishlist_items, true ) ) {

			return $this->database_handler->delete_where(
				array(
					'parent_wishlist_id' => $parent_wishlist_id,
					'product_id'         => $product_id,
					'user_id'            => $this->current_user_id,
					'site_url'           => $this->current_site_url,
				)
			);
		}

		return false;
	}

	/**
	 * Get default wishlist id.
	 *
	 * @param int $user_id WP User ID.
	 *
	 * @return int|boolean If found, wishlist ID. Else, false.
	 */
	public function get_default_wishlist_id( $user_id ) {

		$user_wishlists = $this->get_wishlists( $user_id );

		if (
			! empty( $user_wishlists ) &&
			isset( $user_wishlists[0] )
		) {
			return (int) $user_wishlists[0];
		}

		return 0;
	}


	/**
	 * Get all wishlists associated to a user in ascending order.
	 *
	 * @since 2.0.6
	 *
	 * @param int $user_id WP User ID.
	 *
	 * @return array|boolean Lists of wishlists if found. Else false.
	 */
	public function get_wishlists( $user_id ) {

		$user_wishlists = $this->database_handler->get_rows(
			array(
				'user_id'            => $user_id,
				'site_url'           => get_site_url(),
				'parent_wishlist_id' => NULL, // phpcs:ignore
			)
		);

		$wishlist_ids = array();

		if (
			is_array( $user_wishlists ) &&
			! empty( $user_wishlists )
		) {
			foreach ( $user_wishlists as $user_wishlist ) {
				$wishlist_ids[] = (int) $user_wishlist->id;
			}
		}

		sort( $wishlist_ids );

		return ( empty( $wishlist_ids ) || count( $wishlist_ids ) === 0 ) ? false : $wishlist_ids;
	}

	/**
	 * Get wishlist items.
	 *
	 * @param int $wishlist_id Wishlist ID.
	 * @return array Wishlist items.
	 */
	public function get_wishlist_items( $wishlist_id = 0 ) {

		if ( 0 === $wishlist_id ) {
			$wishlist_id = $this->default_wishlist_id;
		}

		$wishlist_items = $this->database_handler->get_rows(
			array(
				'user_id'            => $this->current_user_id,
				'site_url'           => $this->current_site_url,
				'parent_wishlist_id' => $wishlist_id,
			)
		);

		$items = array();

		if (
			is_array( $wishlist_items ) &&
			! empty( $wishlist_items )
		) {
			foreach ( $wishlist_items as $wishlist_item ) {
				$items[] = (int) $wishlist_item->product_id;
			}
		}

		return $items;
	}

	/**
	 * Vacate wishlist.
	 *
	 * @param int $wishlist_id Wishlist ID (optional).
	 * @return bool True on success, false otherwise.
	 */
	public function empty_wishlist( $wishlist_id = 0 ) {

		if ( 0 === $wishlist_id ) {
			$wishlist_id = $this->default_wishlist_id;
		}

		$delete_where = array(
			'parent_wishlist_id' => $wishlist_id,
			'user_id'            => $this->current_user_id,
			'site_url'           => $this->current_site_url,
		);

		return $this->database_handler->delete_where( $delete_where );
	}

	/**
	 * Generate share key if null.
	 */
	public function maybe_generate_share_key() {

		global $wpdb;

		$table_name = $this->database_handler->get_table_name();

		$wishlist_ids_with_no_share_keys = $wpdb->get_row( //phpcs:ignore
			"SELECT GROUP_CONCAT(`id`) as ids FROM {$table_name} WHERE `wishlist_name` IS NOT NULL AND `share_key` IS NULL",//phpcs:ignore
			ARRAY_A
		);

		if (
			! empty( $wishlist_ids_with_no_share_keys ) &&
			array_key_exists( 'ids', $wishlist_ids_with_no_share_keys ) &&
			! empty( $wishlist_ids_with_no_share_keys['ids'] )
		) {
			$time = time();
			$ids  = $wishlist_ids_with_no_share_keys['ids'];
			$wpdb->query( "UPDATE {$table_name} SET `share_key` = REVERSE(CAST( ({$time} + `id`) AS CHAR )) WHERE `id` IN ({$ids}) " ); //phpcs:ignore
		}
	}
}

