<?php

namespace App\Utils;

class Posts {
	public static function swco_get_post_shortname( $post_id ) {

		$shortname = get_post_meta( $post_id, 'short_name', true );
		if ( ! $shortname ) {
			$shortname = get_the_title( $post_id );
		}

		return $shortname;
	}

    public static function get_card_icon( $post_id ) {

        $result = '';
        $hot = get_field('flash_hot', $post_id);
        $icon = \App\Utils\Html::get_svg('flame');

        if ( !empty( $hot ) ) {
            $result = <<<EOT
            <span class="card__icon">$icon</span>
            EOT;
        }

        return $result;
    }
}