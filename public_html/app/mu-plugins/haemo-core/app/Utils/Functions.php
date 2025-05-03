<?php

/**
 * Functions class
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Utils;

class Functions
{
    /**
     * Get options
     *
     * @param string $option_name Option name.
     *
     * @return string
     */
    public static function getSetting(string $option_name): string
    {
        global $haemocore;

        if (!empty($haemocore[$option_name])) {
            return $haemocore[$option_name];
        }

        return '';
    }
}
