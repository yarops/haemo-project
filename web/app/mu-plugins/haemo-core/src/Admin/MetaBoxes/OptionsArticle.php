<?php

/**
 * Register options meta box for article
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register meta boxes for video post type
 */
class OptionsArticle
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
                'key'                   => 'haemo_options_article',
                'title'                 => 'Article options',
                'fields'                => [
                    [
                        'key'               => 'haemo_article_authors',
                        'label'             => 'Authors',
                        'name'              => 'article_authors',
                        'type'              => 'textarea',
                        'default_value'     => '',
                        'rows'              => 3,
                    ],
                    [
                        'key'               => 'haemo_article_authors_info',
                        'label'             => 'Authors',
                        'name'              => 'article_authors_info',
                        'type'              => 'textarea',
                        'default_value'     => '',
                        'rows'              => 3,
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'haemo_article',
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
