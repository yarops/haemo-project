<?php

namespace App\Utils;

/**
 * Functions for theme
 *
 * @category WordPress theme
 * @package haemo
 */
function get_setting( $option, $default = '' ) {

	global $sweetcore;
	if ( isset( $sweetcore[ $option ] ) && ! empty( $sweetcore[ $option ] ) ) {
		return $sweetcore[ $option ];
	}

	return '';
}
