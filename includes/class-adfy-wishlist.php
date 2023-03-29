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
	 * Class constructor.
	 */
	public function __construct() {
		global $wishlist;
		$this->wishlist = $wishlist;

		$this->wishlist_items = $this->get_wishlist();

		$this->wishlist_items_count = $this->get_wishlist_count();
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
	public function save_in_wishlist( $wishlist_id, $product_id ) {

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

}
