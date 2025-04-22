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

use JetBrains\PhpStorm\NoReturn;
use WP;
use WP_Query;
use WP_Term;

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
        add_action('parse_request', [$this, 'loadType']);
        add_filter('query_vars', [$this, 'addLibraryQueryArg']);
        $this->libraryRewriteRules();
        // add_action('wp_loaded', [$this, 'libraryRewriteRules']);
        add_action('template_redirect', [$this, 'libraryTemplateInclude']);
        add_action('pre_get_posts', [$this, 'libraryTaxonomyFilter']);
    }

    /**
     * Load type
     *
     * @param WP $wp WP instance.
     *
     * @return void
     */
    #[NoReturn] public function loadType(WP $wp): void
    {
        $type = '';

        if (array_key_exists('type', $wp->query_vars)) {
            $type = $wp->query_vars['type'];

            $data = require_once app()->appPath . 'Data/TypeData.php';

            $typeObj = new TypeArg($type, $data[$type]);

            app()->queryArgs['type'] = $typeObj;
        }
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
            'index.php?haemo_library_category=$matches[1]&type=$matches[2]',
            'top'
        );

        flush_rewrite_rules();

//        flush_rewrite_rules();
    }

    /**
     * Filter library tax
     *
     * @param $q
     * @return void
     */
    public function libraryTaxonomyFilter($q): void
    {
        $type = get_query_var('type');

        if (
            !is_admin() &&
            is_tax('haemo_library_category') &&
            !empty($type)
        ) {
            $q->set('post_type', 'haemo_' . $type);
        }
    }

    /**
     * Include taxonomy template
     *
     * @return void
     */
    public function libraryTemplateInclude(): void
    {
        $type = get_query_var('type');

        if (is_tax('haemo_library_category') && !empty($type)) {
            global $wp_query;

            include get_stylesheet_directory() . '/haemo-taxonomy-library.php';
            exit;
        }
    }

    /**
     * Add query arg 'type' to library taxonomy link
     *
     * @param WP_Term $term Term.
     * @param string $type Type
     * @return string
     */
    public static function constructLibraryLink(WP_Term $term, string $type): string
    {
        if (is_wp_error($term) || is_wp_error($type) || empty($type)) {
            return '';
        }

        $term_link = get_term_link($term, 'haemo_library_category');

        if ('' !== get_option('permalink_structure')) {
            return user_trailingslashit($term_link . 'type/' . $type);
        }

        return add_query_arg('type', $type, $term_link);
    }
}
