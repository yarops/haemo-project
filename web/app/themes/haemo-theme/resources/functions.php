<?php

/**
 * Functions for theme
 *
 * @category WordPress theme
 * @package haemo
 */

use App\App;

if (!file_exists($composer = __DIR__ . '/../vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'haemo'));
}

require $composer;
App::instance();

/**
 * Returns the main plugin object.
 *
 * @return App
 */
function app(): App
{
    return App::instance();
}

add_action('after_setup_theme', 'gostrike_load_textdomain');
add_filter('wpseo_metabox_prio', 'gostrike_yoast_to_bottom');
add_filter('wp_check_filetype_and_ext', 'gostrike_fix_svg_mime_type', 10, 5);

/**
 * Load theme textdomain
 *
 * @return void
 */
function gostrike_load_textdomain()
{
    load_theme_textdomain('haemo', get_template_directory() . '/languages');
}

/**
 * Move Yoast to bottom
 *
 * @return string
 */
function gostrike_yoast_to_bottom()
{
    return 'low';
}

/**
 * Fix svg mime type for upload
 *
 * @param array $data Values for the extension, mime type, and corrected filename.
 * @param string $file Full path to the file.
 * @param string $filename The name of the file (may differ from $file due to $file being in a tmp directory).
 * @param string[]|null $mimes Array of mime types keyed by their file extension regex, or null if none were provided.
 * @param string $real_mime The actual mime type or false if the type cannot be determined.
 *
 * @return [type]
 */
function gostrike_fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '')
{

    // WP 5.1+.
    if (version_compare($GLOBALS['wp_version'], '5.1.0', '>=')) {
        $dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml'], true);
    } else {
        $dosvg = ('.svg' === strtolower(substr($filename, -4)));
    }

    if ($dosvg) {
        if (current_user_can('manage_options')) {
            $data['ext'] = 'svg';
            $data['type'] = 'image/svg+xml';
        } else {
            $data['ext'] = false;
            $data['type'] = false;
        }
    }

    return $data;
}

function remove_admin_bar_bump()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}

add_action('get_header', 'remove_admin_bar_bump');


//function disable_taxonomy_query($query) {
//    if (!is_admin() && $query->is_main_query() && is_tax('haemo_video_categories')) {
//        // Отключаем выборку постов
//        $query->set('post__in', [0]); // Гарантирует, что ничего не будет найдено
//    }
//}
//add_action('pre_get_posts', 'disable_taxonomy_query');

add_filter('posts_request', 'disable_query_sql', 10, 2);
function disable_query_sql($sql, $query)
{
    if (!is_admin() && $query->is_main_query() && is_tax('haemo_video_categories')) {
        return ''; // или вернуть SQL, который ничего не делает
    }
    return $sql;
}
