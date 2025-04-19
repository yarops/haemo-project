<?php

/**
 * Register options metabox for category
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register meta boxes for category
 */
class OptionsCategory
{
    /**
     * Add action for register meta boxes
     */
    public function __construct()
    {
        add_action('acf/include_fields', [$this, 'metaBoxesRegister']);
    }

    /**
     * Register meta boxes for category
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
                'key'                   => 'haemo_options_category',
                'title'                 => 'Category options',
                'fields'                => [

                ],
                'location'              => [
                    [
                        [
                            'param'    => 'ef_taxonomy',
                            'operator' => '==',
                            'value'    => 'category',
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
