<?php

/**
 * Promo banners class
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package haemo
 */

namespace App\Modules;

use WP_Query;
use function App\Utils\get_setting;

/**
 * Paginate class
 */
class Promo {

	private $items = [];

	/**
	 * Fill items
	 */
	public function __construct() {
		$this->items = [
			'side_left' => get_setting('swco_promo_side_left'),
			'side_right' => get_setting('swco_promo_side_right'),
			'top' => get_setting('swco_promo_top'),
			'bottom' => get_setting('swco_promo_bottom'),
			'side' => get_setting('swco_promo_side'),
		];
	}

	/**
	 * Display selected location
	 *
	 * @param string $location Banner location.
	 *
	 * @return void
	 */
	public function display(string $location): void
	{
		$promo = <<<HTML
			<div class="promo promo--{$location}">
				{$this->items[$location]}
			</div>
		HTML;

		echo $promo;
	}
}
