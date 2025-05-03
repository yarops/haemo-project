<?php

/**
 * Plugin Name: HaemoCore
 * Description: Setup HaemoCore.
 * Version: 1.0.0
 * License: A "Slug" license name e.g. GPL2
 */

use HaemoCore\Plugin;

if (!class_exists('HaemoCore\Plugin')) {
    define('HAEMOCORE_VENDOR_DIR', plugin_dir_path(__FILE__) . 'vendor/');
    define('HAEMOCORE_DIR', plugin_dir_path(__FILE__));
    define('HAEMOCORE_APP_DIR', plugin_dir_path(__FILE__) . 'app/');
    define('HAEMOCORE_APP_URL', plugin_dir_url(__FILE__) . 'app/');

    // Untested
//    define('CSCORE_ADMIN_DIR', CSCORE_DIR . '/Admin');
//    define('CSCORE_LIBS_DIR', CSCORE_DIR . '/Libs');
//    define('CSCORE_LIBS_DIR_URI', CSCORE_URL . '/Libs');
//    define('CSCORE_ASSETS_DIR_URI', CSCORE_URL . '/bundle');
//    define('CSCORE_WIDGETS_DIR', CSCORE_DIR . '/Widgets');
//    define('CSCORE_WIDGETS_DIR_URI', CSCORE_URL . '/Widgets');
//    define('CSCORE_SHORTCODES_DIR', CSCORE_DIR . '/Shortcodes');
//    define('CSCORE_SHORTCODES_DIR_URI', CSCORE_URL . '/Shortcodes');

    /**
     * Fix redux url bug with mu-plugins
     * need initialize before autoloader
     *
     * @param string $url Plugin url
     * @param string $path Plugin path
     * @param string $plugin Plugin name
     *
     * @return [type]
     */
    function reduxframework_fix_muplugin_url($url, $path, $plugin)
    {
        if (str_contains($path, 'haemo-core/vendor/redux-framework')) {
            $url = str_replace('/plugins', '/mu-plugins', $url);
        }

        return $url;
    }

    add_filter('plugins_url', 'reduxframework_fix_muplugin_url', 10, 3);

    require_once __DIR__ . '/vendor/autoload.php';

    // Initialize
    $pluginInstance = Plugin::instance();

    /**
     * Returns the main plugin object.
     *
     * @return Plugin
     */
    function hc()
    {
        return Plugin::instance();
    }


}
