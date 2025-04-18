<?php

/**
 * Library controller
 * Класс реализует дополнительный параметр для фильтрации
 * типов постов внутри библиотечной категории
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
class LibraryController
{
    /**
     * Fill items
     */
    public function __construct()
    {
        add_filter('query_vars', [$this, 'addLibraryQueryArg']);
        $this->libraryRewriteRules();
        // add_action('wp_loaded', [$this, 'libraryRewriteRules']);
    }

    /**
     * Add library query arg
     *
     * @param array $vars Query vars.
     *
     * @return array
     */
    public function addLibraryQueryArg(array $vars): array
    {
        $vars[] = 'type';
        return $vars;
    }

    /**
     * Add library rewrite rules
     *
     * @return void
     */
    public function libraryRewriteRules(): void
    {
        add_rewrite_tag("%type%", "([a-z0-9\-_]+)");

        add_rewrite_rule(
            '^lib-category\/([^/]+)\/type\/([^/]+)\/?$',
            'index.php?haemo_video_categories=$matches[1]&type=$matches[2]',
            'top'
        );

        flush_rewrite_rules();

//        flush_rewrite_rules();
    }

    /**
     * Add query arg 'type' to library taxonomy link
     *
     * @param \WP_Term $term Term.
     * @param string $type Type
     * @return string
     */
    public static function constructLibraryLink(\WP_Term $term, string $type): string
    {
        if (is_wp_error($term) || is_wp_error($type) || empty($type)) {
            return '';
        }

        $term_link = get_term_link($term, 'haemo_video_categories');

        if ('' !== get_option('permalink_structure')) {
            return user_trailingslashit($term_link . 'type/' . $type);
        }

        return add_query_arg('type', $type, $term_link);
    }
}
