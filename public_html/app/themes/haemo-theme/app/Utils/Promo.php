<?php

namespace App\Utils;

class Promo
{
	public static function get_promo($name = '')
	{
		$result = '';

		$result = <<<HTML
		<svg class="icon" width="21px" height="21px">
			<use xlink:href="#icon-{$name}"></use>
		</svg>
		HTML;

		return $result;
	}
}