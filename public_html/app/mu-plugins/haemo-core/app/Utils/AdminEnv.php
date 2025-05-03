<?php

/**
 * Initialize environment
 *
 * @category WordPress theme
 * @package HaemoCore
 */

namespace HaemoCore\Utils;

class AdminEnv
{
    public $mode = 'production';
    public $key = '';
    public $proxy = '';

    function __construct()
    {
        add_action('init', [$this, 'setupEnvironment']);
        add_action('wp_footer', [$this, 'render_development_bar']);
    }

    /**
     * Setup admin env.
     *
     * @return void
     */
    public function setupEnvironment(): void
    {

        $env_file_path = HAEMOCORE_DIR . 'env.json';

        if (file_exists($env_file_path)) {
            $env_file = json_decode(file_get_contents($env_file_path), true);

            if (isset($env_file['key']) || !empty($env_file['key'])) {
                $this->key = $env_file['key'];
            }

            if (isset($env_file['mode']) || !empty($env_file['mode'])) {
                $this->mode = $env_file['mode'];
            }

            if (isset($env_file['proxy']) || !empty($env_file['proxy'])) {
                $this->proxy = $env_file['proxy'];
            }
        }
    }

    function source_path($resource)
    {
        return dirname(get_template_directory()) . '/src/' . $resource;
    }

    function assets_url($resource)
    {
        if ('development' === $this->mode) {
            return 'https://localhost:8082/src/' . $resource;
        } else {
            return get_template_directory_uri() . '/dist/' . $resource;
        }
    }

    function render_development_bar()
    {
        get_template_part('parts/development');
    }
}
