<?php
/**
 * The file that defines the wishlist class for wishlist related operations.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.addonify.com
 * @since      1.0.0
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
	 * @var object $wishlist
	 */
	private $wishlist;

	/**
	 * Wishlist values in array.
	 *
	 * @var array $wishlist_items
	 */
	public $wishlist_items;

	/**
	 * Wishlist count.
	 *
	 * @var int $wishlist_items_count
	 */
	public $wishlist_items_count;

	/**
	 * Default Public wishlist.
	 *
	 * @since 1.1.0
	 * @access private
	 * @var string $default_wishlist
	 */
	private $default_wishlist = 'Default Wishlist';

	/**
	 * Stores this Object instance.
	 *
	 * @var array
	 */
	private static $instance;

	/**
	 * Class constructor.
	 */
	private function __construct() {
		global $wishlist;
		$this->wishlist = $wishlist;

		$this->wishlist_items = $this->get_wishlist();

		$this->wishlist_items_count = $this->get_wishlist_count();
	}

	public static function get_instance() {
		if ( ! ( is_array( self::$instance ) && array_key_exists( 'instance', self::$instance ) ) ) {
			self::$instance['instance'] = new Adfy_Wishlist();
		}
		return self::$instance['instance'];
	}

	/**
	 * Returns wishlist.
	 */
	public function get_wishlist() {
		if ( is_user_logged_in() ) {
			global $wishlist;
			$user_id       = get_current_user_id();
			$wishlist_data = array();
			foreach ( $wishlist->get_all_rows() as $row ) {
				if ( get_bloginfo( 'url' ) === $row->site_url && $user_id === (int) $row->user_id ) {
					if ( null !== $row->wishlist_name ) {
						$wishlist_data[ $row->id ] = array(
							'name'       => $row->wishlist_name,
							'visibility' => $row->wishlist_visibility,
						);
					} else {
						if ( array_key_exists( $row->parent_wishlist_id, $wishlist_data ) ) {
							$wishlist_data[ $row->parent_wishlist_id ]['product_ids'][] = (int) $row->product_id;
						}
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
	public function get_wishlist_count() {
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
	 * @param int $wishlist_id Wishlist ID.
	 * @param int $product_id  Product ID.
	 * @return boolean True if saved, false otherwise.
	 */
	public function add_to_wishlist( $wishlist_id = false, $product_id ) {

		if ( $wishlist_id === false ) {
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
					$this->wishlist_items[ $wishlist_id ]['product_ids'][] = $product_id;

					$return_boolean = true;
				}
			}
		}

		$this->wishlist_items_count = $this->get_wishlist_count();

		do_action( 'addonify_wishlist_after_adding_to_wishlist' );

		return $return_boolean;
	}

	/**
	 * Get default wishlist id.
	 *
	 * @return int
	 */
	private function get_default_wishlist_id() {
		foreach ( $this->wishlist_items as $index => $item ) {
			if ( $item['name'] === $this->default_wishlist ) {
				return $index;
			}
		}
		return false;
	}

	/**
	 * Remove product from the wishlist if product is already in the wishlist.
	 *
	 * @since 1.0.0
	 * @param int $product_id Product ID.
	 * @param int $parent_wishlist_id Wishlist ID.
	 * @return boolean true if removed successfully otherwise false.
	 */
	public function remove_from_wishlist( $product_id, $parent_wishlist_id = false ) {
		if ( $parent_wishlist_id ) {
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
		} else {
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

}

global $adfy_wishlist;
add_action(
	'plugins_loaded',
	function () {
		global $adfy_wishlist, $wishlist;
		if ( $wishlist->check_wishlist_table_exists() ) {
			$adfy_wishlist = Adfy_Wishlist::get_instance();
		}
	}
);
