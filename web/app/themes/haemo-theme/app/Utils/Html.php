<?php

namespace App\Utils;

class Html
{
	public static function get_svg($name = '', $width = 24, $height = 24)
	{
		$result = '';

		$result = <<<HTML
		<svg class="icon" width="{$width}px" height="{$height}px">
			<use xlink:href="#icon-{$name}"></use>
		</svg>
		HTML;

		return $result;
	}

    public static function get_copyright($name = '', $width = 24, $height = 24)
    {
        $result = '';

        $copy = get_setting('swco_copyright');
        $copy_label = '© ' . date('Y') . ' / ' . get_bloginfo('name');

        $result = <<<HTML
        <div class="copyright">{$copy_label}. {$copy}</div>
        HTML;

        return $result;
    }
}