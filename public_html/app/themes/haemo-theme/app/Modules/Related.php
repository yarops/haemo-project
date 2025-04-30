<?php
/**
 * Initialize related games
 *
 * @category WordPress theme
 * @package haemo
 */

namespace App\Modules;

use function App\Utils\get_setting;

class Related {
	public $related = [];
	function __construct() {
		if ( ! is_single() ) {
			return;
		}

		$this->build_related_games();
	}

	/**
	 * Initialize related games
	 */
	function build_related_games(): void {
		global $post;

		$categories_ids = wp_get_post_categories( $post->ID, array( 'field' => 'ids ' ) );

		if ( ! in_array( 0, $categories_ids ) ) {
			array_push( $categories_ids, '0' );
		}

		$count = 0;

		$excludes        = array( $post->ID );
		$related_count = ( get_setting( 'swco_similiar_count' ) ) ? get_setting( 'swco_similiar_count' ) : 18;

		foreach ( $categories_ids as $category_id ) {
			$args            = array(
				'orderby'        => 'rand',
				'posts_per_page' => $related_count,
				'post__not_in'   => $excludes,
				'tax_query'      => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $category_id,
					),
				),
			);
			$related_query = new \WP_Query( $args );

			foreach ( $related_query->posts as $related_post ) {
				++$count;

				$this->related[] = $related_post;
				$excludes[]  = $related_post->ID;

				if ( $count >= $related_count ) {
					break 2;
				}
			}
		}

		if ( $count < $related_count ) {
			$more            = $related_count - $count;
			$args            = array(
				'orderby'        => 'rand',
				'posts_per_page' => $more,
				'post__not_in'   => $excludes,
			);
			$related_query = new \WP_Query( $args );

			foreach ( $related_query->posts as $related_post ) {

				$this->related[] = $related_post;

			}
		}
	}

	/**
	 * Getter for related
	 * @return \WP_Post[]
	 */
	public function get_related() {
		return $this->related;
	}
}
