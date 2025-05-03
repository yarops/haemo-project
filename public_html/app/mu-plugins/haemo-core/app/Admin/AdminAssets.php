<?php

/**
 * Include assets
 *
 * @category WordPress plugin
 * @package haemo-core
 */

namespace HaemoCore\Admin;

//use function App\Utils\get_setting;

class AdminAssets
{
    /**
     * Initialise assets hooks.
     */
    public function __construct()
    {
        add_filter('script_loader_tag', [$this, 'addModuleAttr'], 10, 3);

        add_action('admin_enqueue_scripts', [$this, 'provideStylesAdmin']);
        add_action('admin_enqueue_scripts', [$this, 'provideScriptsAdmin']);
    }

    /**
     * Setup styles/scripts in footer
     *
     * @return void
     */
    public function provideStylesAdmin(): void
    {
        /** App Style */
        wp_register_style(
            'core',
            HAEMOCORE_APP_URL . 'dist/styles/core.css',
            [],
            hc()->adminEnv->key,
            'all'
        );

        // Development
        if (hc()->adminEnv->mode === 'development') {
            wp_deregister_style('core');
        }

        wp_enqueue_style('core');
    }

    /**
     * Setup scripts
     *
     * @return void
     */
    public function provideScriptsAdmin(): void
    {

        global $post;

        // wp_deregister_script('jquery');

        wp_register_script(
            'core',
            HAEMOCORE_APP_URL . 'dist/scripts/core.js',
            null,
            hc()->adminEnv->key,
            true
        );

        // Development scripts
        if (hc()->adminEnv->mode === 'development') {
            wp_deregister_script('core');

            wp_enqueue_script(
                'vite',
                'https://localhost:8082/@vite/client',
                [],
                null
            );

            wp_register_script(
                'core',
                'https://localhost:8082/src/ts/core.ts',
                null,
                time(),
                true
            );
        }

        wp_enqueue_script('core');
        wp_localize_script(
            'core',
            'core',
            [
                'url'   => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('core-nonce'),
                'postID' => $post->ID
            ]
        );
    }

    public function addModuleAttr(string $tag, string $handle, string $src): string
    {
        if (in_array($handle, ['vite', 'core'])) {
            return '<script type="module" src="' . esc_url($src) . '" defer></script>';
        }
        return $tag;
    }
}
