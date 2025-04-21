<?php

/**
 * Register box shortname for all entities
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register metaboxes
 */
class BoxShortname
{
    /**
     * Add action for register metaboxes
     */
    public function __construct()
    {
        add_action('acf/include_fields', [$this, 'metaboxesRegister']);
    }

    /**
     * Register metaboxes for category
     *
     * @return void
     */
    public function metaboxesRegister(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group(
            [
                'key'                   => 'haemo_box_shortname',
                'title'                 => 'Commons options',
                'fields'                => [
                    [
                        'key'         => 'swco_all_shortname',
                        'label'       => 'Shortname',
                        'name'        => 'swco_shortname',
                        'type'        => 'text',
                        'placeholder' => '',
                        'prepend'     => '',
                        'append'      => '',
                        'formatting'  => 'html',
                        'maxlength'   => '',
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'taxonomy',
                            'operator' => '==',
                            'value'    => 'category',
                            'order_no' => 0,
                            'group_no' => 0,
                        ],
                    ],
                    [
                        [
                            'param'    => 'taxonomy',
                            'operator' => '==',
                            'value'    => 'haemo_video_categories',
                        ],
                    ],
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'post',
                        ],
                    ],
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'page',
                        ],
                    ],
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'haemo_video',
                        ],
                    ],
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'haemo_article',
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
