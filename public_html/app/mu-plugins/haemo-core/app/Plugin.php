<?php

/**
 * Plugin base file
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore;

use HaemoCore\Admin\AdminAssets;
use HaemoCore\Admin\MetaBoxesSetup;
use HaemoCore\Admin\ThemeOptions;
use HaemoCore\Utils\AdminEnv;

class Plugin
{
    /**
     * Environment object
     *
     * @var object
     */
    public object $adminEnv;

    public array $modules = [];

    /**
     * @var ?Plugin
     */
    private static ?Plugin $instance = null;

    /**
     * Initialize Plugin
     */
    public function __construct()
    {
        $this->adminEnv = new AdminEnv();
        new AdminAssets();

        add_action('init', [$this, 'initLanguages']);
        add_action('plugins_loaded', [$this, 'initOptions']);

        $this->adminInitialize();
        $this->initHooks();
    }

    public function initLanguages(): void
    {
        load_plugin_textdomain('haemo-core', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Access method for the plugin.
     *
     * @return ?Plugin
     */
    public static function instance(): ?Plugin
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance ?? null;
    }

    /**
     * Register theme hooks.
     *
     * @return void
     */
    private function initHooks(): void
    {
        add_action('init', [$this, 'registerSidebars']);
        add_action('init', [$this, 'registerMenus']);
        add_action('init', [$this, 'registerPostTypes']);
        add_action('init', [$this, 'addImageSizes']);
        add_action('after_setup_theme', [$this, 'addThemeSupports']);
    }

    public function adminInitialize(): void
    {
        new MetaBoxesSetup();
    }

    public function initOptions(): void
    {
        new ThemeOptions();
    }

    public function addThemeSupports(): void
    {
        if (!current_theme_supports('post-thumbnail')) {
            add_theme_support('post-thumbnails');
        }

        add_theme_support('post-formats', ['video', 'audio', 'gallery']);

        add_filter('the_content', 'wp_filter_content_tags');
        add_filter('the_content', 'wp_replace_insecure_home_url');
    }

    public function addImageSizes(): void
    {

        set_post_thumbnail_size('320', '240', true);
        add_image_size('small-thumb', '180', '90', true);
        add_image_size('icon-thumb', '150', '150', true);
    }

    public function registerSidebars(): void
    {
        add_filter('widget_text', 'do_shortcode');

        register_sidebar(
            [

                'id'            => 'sidebar-left',
                'name'          => __('Sidebar Left', 'haemo-core'),
                'description'   => __('Sidebar left', 'haemo-core'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget__title">',
                'after_title'   => "</h3>\n",
            ]
        );
    }

    public function registerMenus(): void
    {
        // Menu Support
        add_theme_support('Menus');

        register_nav_menus(
            [
                'navmenu' => 'Navbar menu',
                'mobile'  => 'Mobile menu',
                'footer'  => 'Footer menu',
            ]
        );
    }

    public function registerPostTypes(): void
    {
        new PostTypes\LibraryCategories();
        new PostTypes\Video();
        new PostTypes\Article();
    }
}
