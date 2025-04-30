<?php

/**
 * Register options metabox for menu
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register metaboxes for posts
 */
class OptionsMenu
{
    /**
     * Add action for register meta boxes
     */
    public function __construct()
    {
        add_action('acf/include_fields', [$this, 'metaBoxesRegister']);
    }

    /**
     * Register meta boxes for posts
     *
     * @return void
     */
    public function metaBoxesRegister(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group(
            [
                'key'                   => 'menu_options',
                'title'                 => 'Options',
                'fields'                => [
                    [
                        'key'          => 'menu_image',
                        'label'        => 'Menu Image',
                        'name'         => 'menu_image',
                        'type'         => 'image',
                        'save_format'  => 'object',
                        'preview_size' => 'thumbnail',
                        'library'      => 'all',
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'nav_menu_item',
                            'operator' => '==',
                            'value'    => 'all',
                        ],
                    ],
                ],
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => true,
                'description'           => '',
            ]
        );
    }
}
