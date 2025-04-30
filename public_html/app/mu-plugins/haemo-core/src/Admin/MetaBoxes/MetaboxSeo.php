<?php

/**
 * Register seo metabox
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes;

/**
 * Class for register metaboxes for category
 */
class MetaboxSeo
{
    /**
     * Add action for register meta boxes
     */
    public function __construct()
    {
        add_action('acf/include_fields', array( $this, 'metaboxesRegister' ));
    }

    /**
     * Register meta boxes for category
     *
     * @return void
     */
    public function metaboxesRegister(): void
    {
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group(
            array(
                'key'                   => 'haemo_metabox_seo',
                'title'                 => 'Seo options',
                'fields'                => array(
                    array(
                        'key'           => 'haemo_keywords',
                        'label'         => 'Keywords',
                        'name'          => 'haemo_keywords',
                        'type'          => 'textarea',
                        'default_value' => '',
                    ),
                ),
                'location'              => array(
                    array(
                        array(
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'post',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                    array(
                        array(
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'page',
                        ),
                    ),
                    array(
                        array(
                            'param'    => 'taxonomy',
                            'operator' => '==',
                            'value'    => 'category',
                        ),
                    ),
                ),
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => true,
                'description'           => '',
                'show_in_rest'          => 0,
            )
        );
    }
}
