<?php

/**
 * Register options metabox for page
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register metaboxes for page
 */
class OptionsPage
{
    /**
     * Add action for register metaboxes
     */
    public function __construct()
    {
        add_action('acf/include_fields', [$this, 'metaBoxesRegister']);
    }

    /**
     * Register metaboxes for page
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
                'key'                   => 'haemo_options_page',
                'title'                 => 'Page options',
                'fields'                => [

                ],
                'location'              => [
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'page',
                            'order_no' => 0,
                            'group_no' => 0,
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
                'show_in_rest'          => 0,
            ]
        );
    }
}
