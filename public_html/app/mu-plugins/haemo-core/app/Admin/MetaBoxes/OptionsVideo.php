<?php

/**
 * Register options metabox for video
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register meta boxes for video post type
 */
class OptionsVideo
{
    /**
     * Add action for register meta boxes
     */
    public function __construct()
    {
        add_action('acf/include_fields', [$this, 'metaBoxesRegister']);
    }

    /**
     * Register metaboxes for posts
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
                'key'                   => 'haemo_options_post',
                'title'                 => 'Game options',
                'fields'                => [
                    [
                        'key'               => 'haemo_video_link',
                        'label'             => 'Link to video',
                        'name'              => 'video_link',
                        'type'              => 'text',
                        'default_value'     => '',
                        'rows'              => 1,
                    ],
                    [
                        'key'               => 'haemo_video_public_link',
                        'label'             => 'Public Link to video',
                        'name'              => 'video_public_link',
                        'type'              => 'textarea',
                        'default_value'     => '',
                        'rows'              => 1,
                        // 'required'          => true,
                    ],
                    [
                        'key'               => 'haemo_video_preview',
                        'label'             => 'Preview for video',
                        'name'              => 'video_preview',
                        'type'              => 'image',
                        'save_format'       => 'object',
                        'preview_size'      => 'thumbnail',
                        'library'           => 'all',
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'haemo_video',
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
