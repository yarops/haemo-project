<?php

/**
 * Register theme options
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin;

class ThemeOptions
{
    public $args = [];
    public $sections = [];
    public $theme;
    public $ReduxFramework;

    public function __construct()
    {
        if (!class_exists('Redux')) {
            echo 'not';
            die;
        }

        if (!class_exists('ReduxFramework')) {
            return;
        }

        $this->initSettings();
    }

    public function initSettings()
    {

        $this->setArguments();
        $this->setHelpTabs();
        $this->setSections();

        if (!isset($this->args['opt_name'])) {
            return;
        }

        $this->ReduxFramework = new \ReduxFramework($this->sections, $this->args);
    }

    public function setSections()
    {
        require_once __DIR__ . '/Options/Sections.php';
    }

    public function setHelpTabs()
    {

        // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
        $this->args['help_tabs'][] = [
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__('Theme Information 1', 'haemo-core'),
            'content' => esc_html__('This is the tab content, HTML is allowed.', 'haemo-core'),
        ];

        $this->args['help_tabs'][] = [
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__('Theme Information 2', 'haemo-core'),
            'content' => esc_html__('This is the tab content, HTML is allowed.', 'haemo-core'),
        ];

        // Set the help sidebar
        $this->args['help_sidebar'] = esc_html__('This is the sidebar content, HTML is allowed.', 'haemo-core');
    }

    /**
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */
    public function setArguments()
    {

        $theme = wp_get_theme(); // For use with some settings. Not necessary.

        $this->args = [
            'opt_name'           => 'haemocore',
            'display_name'       => esc_html__('Theme Options', 'haemo-core'),
            'display_version'    => 'V' . $theme->get('Version'),
            'menu_type'          => 'menu',
            'allow_sub_menu'     => true,
            'menu_title'         => esc_html__('Theme Options', 'haemo-core'),
            'page_title'         => esc_html__('Theme Options', 'haemo-core'),
            'google_api_key'     => '',
            'async_typography'   => false,
            'admin_bar'          => true,
            'global_variable'    => '',
            'dev_mode'           => false,
            'customizer'         => true,
            'page_priority'      => null,
            'page_parent'        => 'themes.php',
            'page_permissions'   => 'manage_options',
            'menu_icon'          => 'dashicons-art',
            'last_tab'           => '',
            'page_icon'          => 'icon-themes',
            'page_slug'          => '_options',
            'save_defaults'      => true,
            'default_show'       => false,
            'default_mark'       => '',
            'show_import_export' => true,
            'transient_time'     => 60 * MINUTE_IN_SECONDS,
            'output'             => true,
            'output_tag'         => true,
            'database'           => '',
            'system_info'        => false,
            'hints'              => [
                'icon'          => 'icon-question-sign',
                'icon_position' => 'right',
                'icon_color'    => 'lightgray',
                'icon_size'     => 'normal',
                'tip_style'     => [
                    'color'   => 'light',
                    'shadow'  => true,
                    'rounded' => false,
                    'style'   => '',
                ],
                'tip_position'  => [
                    'my' => 'top left',
                    'at' => 'bottom right',
                ],
                'tip_effect'    => [
                    'show' => [
                        'effect'   => 'slide',
                        'duration' => '500',
                        'event'    => 'mouseover',
                    ],
                    'hide' => [
                        'effect'   => 'slide',
                        'duration' => '500',
                        'event'    => 'click mouseleave',
                    ],
                ],
            ],
        ];

        // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
        $this->args['share_icons'][] = [
            'url'   => '#',
            'title' => 'Visit us on GitHub',
            'icon'  => 'el el-icon-github',
        ];
        $this->args['share_icons'][] = [
            'url'   => '#',
            'title' => 'Like us on Facebook',
            'icon'  => 'el el-icon-facebook',
        ];
        $this->args['share_icons'][] = [
            'url'   => '#',
            'title' => 'Follow us on Twitter',
            'icon'  => 'el el-icon-twitter',
        ];

        if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
            if (!empty($this->args['global_variable'])) {
                $v = $this->args['global_variable'];
            } else {
                $v = str_replace('-', '_', $this->args['opt_name']);
            }
            $this->args['intro_text'] = '';
        } else {
            $this->args['intro_text'] = '';
        }

        $this->args['footer_text'] = '';
    }
}
