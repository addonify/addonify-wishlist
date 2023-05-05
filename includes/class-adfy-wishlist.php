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
class Adfy_Wishlist {

	/**
	 * Wishlist database class.
	 *
	 * @access protected
	 * @var object $wishlist
	 */
	protected $wishlist;

	/**
	 * Wishlist values in array.
	 *
	 * @access protected
	 * @var array $wishlist_items
	 */
	protected $wishlist_items;

	/**
	 * Wishlist count.
	 *
	 * @access protected
	 * @var int $wishlist_items_count
	 */
	protected $wishlist_items_count;

	/**
	 * Default Public wishlist.
	 *
	 * @access protected
	 * @var string $default_wishlist
	 */
	protected $default_wishlist = 'Default Wishlist';

	/**
	 * Stores this Object instance.
	 *
	 * @access protected
	 * @var array
	 */
	protected static $instance;

	/**
	 * Class constructor.
	 */
	protected function __construct() {
		global $addonify_wishlist;

		$this->maybe_generate_share_key();

		$this->wishlist = $addonify_wishlist;

		$this->wishlist_items = $this->get_wishlist();

		$this->wishlist_items_count = $this->get_wishlist_count();
	}

	/**
	 * Get an object instance of this class.
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( ! ( is_array( self::$instance ) && array_key_exists( 'instance', self::$instance ) ) ) {
			self::$instance['instance'] = new Adfy_Wishlist();
		}
		return self::$instance['instance'];
	}

	/**
	 * Returns wishlist.
	 *
	 * @return array
	 */
	protected function get_wishlist() {
		if ( is_user_logged_in() ) {
			global $addonify_wishlist;
			$user_id       = get_current_user_id();
			$wishlist_data = array();
			foreach ( $addonify_wishlist->get_all_rows() as $row ) {
				if ( get_bloginfo( 'url' ) === $row->site_url && $user_id === (int) $row->user_id ) {
					if ( null !== $row->wishlist_name ) {
						$wishlist_data[ $row->id ]['name']       = $row->wishlist_name;
						$wishlist_data[ $row->id ]['visibility'] = $row->wishlist_visibility;
						$wishlist_data[ $row->id ]['share_key']  = $row->share_key;
						$wishlist_data[ $row->id ]['created_at'] = $row->created_at;
					} else {
						$wishlist_data[ $row->parent_wishlist_id ]['product_ids'][] = (int) $row->product_id;
					}
				}
			}
			return $wishlist_data;
		}
		return array();
	}

	/**
	 * Get wishlist count.
	 *
	 * @return int
	 */
	protected function get_wishlist_count() {
		$count = 0;
		foreach ( $this->wishlist_items as $item ) {
			if ( array_key_exists( 'product_ids', $item ) && is_array( $item['product_ids'] ) ) {
				$count += count( $item['product_ids'] );
			}
		}
		return $count;
	}

	/**
	 * Save product in wishlist.
	 *
	 * @param int $product_id  Product ID.
	 * @param int $wishlist_id Wishlist ID (Optional) (If not provided, default wishlist id is used. Useful when multi wishlist option is disabled).
	 * @return boolean True if saved, false otherwise.
	 */
	public function add_to_wishlist( $product_id, $wishlist_id = false ) {

		if ( false === $wishlist_id ) {
			$wishlist_id = $this->get_default_wishlist_id();
		}

		$return_boolean = false;

		do_action( 'addonify_wishlist_before_adding_to_wishlist' );

		if ( is_user_logged_in() ) {
			if ( array_key_exists( (int) $wishlist_id, $this->wishlist_items ) ) {
				$save['user_id']            = get_current_user_id();
				$save['site_url']           = get_bloginfo( 'url' );
				$save['parent_wishlist_id'] = $wishlist_id;
				$save['product_id']         = (int) $product_id;

				$insert_id = $this->wishlist->insert_row( $save );
				if ( $insert_id ) {
					$this->wishlist_items[ $wishlist_id ]['product_ids'][] = (int) $product_id;

					$return_boolean = true;
				}
			}
		}

		$this->wishlist_items_count = $this->get_wishlist_count();

		do_action( 'addonify_wishlist_after_adding_to_wishlist' );

		return $return_boolean;
	}

	/**
	 * Remove product from the wishlist if product is already in the wishlist.
	 *
	 * @param int $product_id Product ID.
	 * @param int $parent_wishlist_id Wishlist ID (Optional) (If not provided, default wishlist id is used. Useful when multi wishlist option is disabled).
	 * @return boolean true if removed successfully otherwise false.
	 */
	public function remove_from_wishlist( $product_id, $parent_wishlist_id = false ) {
		// if parent wishlist is provided.
		if ( false !== $parent_wishlist_id ) {
			if ( array_key_exists( $parent_wishlist_id, $this->wishlist_items ) ) {
				if ( array_key_exists( 'product_ids', $this->wishlist_items[ $parent_wishlist_id ] ) && in_array( (int) $product_id, $this->wishlist_items[ $parent_wishlist_id ]['product_ids'], true ) ) {
					$where = array(
						'parent_wishlist_id' => $parent_wishlist_id,
						'product_id'         => $product_id,
						'user_id'            => get_current_user_id(),
						'site_url'           => get_bloginfo( 'url' ),
					);
					$this->wishlist->delete_where( $where );
					unset( $this->wishlist_items[ $parent_wishlist_id ]['product_ids'][ array_search( (int) $product_id, $this->wishlist_items[ $parent_wishlist_id ]['product_ids'], true ) ] );
					$this->wishlist_items_count = $this->get_wishlist_count();
					return true;
				}
			}
		} else { // if parent wishlist is not provided, search through all wishlists for the item.
			foreach ( $this->wishlist_items as $index => $item ) {
				if ( array_key_exists( 'product_ids', $item ) && in_array( (int) $product_id, $item['product_ids'], true ) ) {
					$where = array(
						'parent_wishlist_id' => $index,
						'product_id'         => $product_id,
						'user_id'            => get_current_user_id(),
						'site_url'           => get_bloginfo( 'url' ),
					);
					$this->wishlist->delete_where( $where );
					unset( $this->wishlist_items[ $index ]['product_ids'][ array_search( (int) $product_id, $this->wishlist_items[ $index ]['product_ids'], true ) ] );
					$this->wishlist_items_count = $this->get_wishlist_count();
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Check if product is in wishlist.
	 *
	 * @param int $product_id Product ID.
	 * @return boolean True if product is in wishlist, false otherwise.
	 */
	public function is_product_in_wishlist( $product_id ) {

		if (
			is_array( $this->wishlist_items ) &&
			count( $this->wishlist_items ) > 0
		) {
			foreach ( $this->wishlist_items as $item ) {
				if ( array_key_exists( 'product_ids', $item ) && is_array( $item['product_ids'] ) ) {
					if ( in_array( (int) $product_id, $item['product_ids'], true ) ) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Check if product is in mentioned wishlist.
	 *
	 * @param int $wishlist_id wishlist ID.
	 * @param int $product_id Product ID.
	 * @return boolean True if product is in wishlist, false otherwise.
	 */
	public function is_product_in_this_wishlist( $wishlist_id, $product_id ) {

		if (
			is_array( $this->wishlist_items ) &&
			count( $this->wishlist_items ) > 0
		) {
			if (
				array_key_exists( (int) $wishlist_id, $this->wishlist_items ) &&
				array_key_exists( 'product_ids', $this->wishlist_items[ $wishlist_id ] )
			) {
				return in_array( (int) $product_id, $this->wishlist_items[ $wishlist_id ]['product_ids'], true );
			}
		}

		return false;
	}

	/**
	 * Get default wishlist id.
	 *
	 * @return int
	 */
	protected function get_default_wishlist_id() {
		foreach ( $this->wishlist_items as $index => $item ) {
			if ( $item['name'] === $this->default_wishlist ) {
				return $index;
			}
		}
		return false;
	}

	/**
	 * Get wishlist items.
	 *
	 * @return array
	 */
	public function get_wishlist_items() {
		return $this->wishlist_items;
	}

	/**
	 * Get wishlist items count.
	 *
	 * @return int
	 */
	public function get_wishlist_items_count() {
		return $this->wishlist_items_count;
	}

	/**
	 * Vacate wishlist.
	 *
	 * @param int $wishlist_id Wishlist ID (optional).
	 * @return bool True on success, false otherwise.
	 */
	public function empty_wishlist( $wishlist_id = false ) {
		global $addonify_wishlist;
		if ( false === $wishlist_id || '' === $wishlist_id ) {
			$wishlist_id = $this->get_default_wishlist_id();
		}

		$delete_where = array(
			'parent_wishlist_id' => $wishlist_id,
			'user_id'            => get_current_user_id(),
			'site_url'           => get_bloginfo( 'url' ),
		);

		return $addonify_wishlist->delete_where( $delete_where );
	}

	/**
	 * Generate share key if null.
	 */
	public function maybe_generate_share_key() {
		global $wpdb, $addonify_wishlist;
		$table_name = $addonify_wishlist->get_table_name();

		$wishlist_ids_with_no_share_keys = $wpdb->get_row( //phpcs:ignore
			"SELECT GROUP_CONCAT(`id`) as ids FROM {$table_name} WHERE `wishlist_name` IS NOT NULL AND `share_key` IS NULL",//phpcs:ignore
			ARRAY_A
		);

		if ( ! empty( $wishlist_ids_with_no_share_keys ) && array_key_exists( 'ids', $wishlist_ids_with_no_share_keys ) && ! empty( $wishlist_ids_with_no_share_keys['ids'] ) ) {
			$time = time();
			$ids  = $wishlist_ids_with_no_share_keys['ids'];
			$wpdb->query( "UPDATE {$table_name} SET `share_key` = REVERSE(CAST( ({$time} + `id`) AS CHAR )) WHERE `id` IN ({$ids}) " ); //phpcs:ignore
		}
	}

}

global $adfy_wishlist;
add_action(
	'plugins_loaded',
	function () {
		global $adfy_wishlist, $addonify_wishlist;
		if ( $addonify_wishlist->check_wishlist_table_exists() ) {
			$adfy_wishlist = Adfy_Wishlist::get_instance();
		}
	}
);
