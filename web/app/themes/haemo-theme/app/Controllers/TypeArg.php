<?php

/**
 * Type arg entitiy for Library
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package haemo
 */

namespace App\Controllers;

use WP_Query;

use function App\Utils\get_setting;

/**
 * Paginate class
 */
class TypeArg
{
    public string $slug;

    public array $labels;

    /**
     * Fill data
     */
    public function __construct(string $slug, array $labels)
    {
        $this->slug = $slug;
        $this->labels = $labels;
    }
}
