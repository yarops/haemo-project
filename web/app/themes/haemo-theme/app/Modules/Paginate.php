<?php

/**
 * Paginate class
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package haemo
 */

namespace App\Modules;

use WP_Query;

/**
 * Paginate class
 */
class Paginate {

	private $current = 1;
	private $max     = null;
	private $markup  = '';

	/**
	 * Construct class with parameters
	 *
	 * @param ?WP_Query $query WP_Query instance.
	 */
	public function __construct(
		?WP_Query $query,
	) {
		global $wp_query;

		if ( ! empty( $query ) ) {
			$this->max     = $query->max_num_pages;
			$this->current = $query->get( 'paged' );
		} else {
			$this->max     = $wp_query->max_num_pages;
			$this->current = $wp_query->get( 'paged' );
		}

		$this->build_markup();
	}

	/**
	 * Construct and display pagination
	 *
	 * @return void
	 */
	public function build_markup() {
		$pages = '';

		$args = array(
			'base'      => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
			'total'     => $this->max,
			'type'      => 'list',
			'current'   => $this->current,
			'prev_next' => true,
			'prev_text' => '<svg class="icon" width="16px" height="16px"><use xlink:href="#icon-arrow-left"></use></svg>',
			'next_text' => '<svg class="icon" width="16px" height="16px"><use xlink:href="#icon-arrow-right"></use></svg>',
			'end_size'  => 1,
			'mid_size'  => 3,
		);

		if ( $this->max > 1 ) {
			$this->markup .= '<div class="pagination">';

			$this->markup .= $pages . paginate_links( $args );
			// echo '<div class="pagination__bottom">';
			// echo '<a href='.get_pagenum_link(1).'>'.__('первая', 'cs').' </a>';
			// echo '<span>/</span>';
			// echo '<a href='.get_pagenum_link($max).'> '.__('последняя', 'cs').'</a>';
			// echo '</div>';

			$this->markup .= '</div>';
		}
	}

	public function display() {
		echo $this->markup;
	}
}
