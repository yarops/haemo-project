<?php

/**
 * Register post type Price
 *
 * @category WordPress plugin
 * @package haemo-core
 */

namespace HaemoCore\PostTypes;

/**
 * Class for register video post type
 */
class Video
{
    public function __construct()
    {
        $this->videoPostTypeRegister();
    }

    /**
     * Register post type
     *
     * @return void
     */
    public function videoPostTypeRegister(): void
    {
        register_post_type('haemo_video', [
            'label'              => __('Video', 'haemo-core'),
            'public'             => true,
            'show_ui'            => true,
            'show_in_nav_menus'  => true,
            'show_in_rest'       => true,
            'hierarchical'       => false,
            'has_archive'        => false,
            'rewrite'            => [
                'slug' => 'video',
            ],
            'publicly_queryable' => true,
            'supports'           => [
                'title',
                'thumbnail',
                'editor',
            ],
        ]);
    }
}
