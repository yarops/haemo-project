<?php

namespace App\Utils;

use HaemoCore\Utils\Functions;

/**
 * HTML Helpers
 */
class Html {



	/**
	 * Get svg function
	 *
	 * @param string $name Name icon.
	 * @param int    $width Width.
	 * @param int    $height height.
	 *
	 * @return string
	 */
	public static function get_svg(
		string $name = '',
		int $width = 24,
		int $height = 24
	): string {
		$result = '';

		return <<<HTML
		<svg class="icon" width="{$width}px" height="{$height}px">
			<use xlink:href="#icon-{$name}"></use>
		</svg>
		HTML;
	}
}
