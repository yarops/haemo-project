<?php

/**
 * Register post type articles
 *
 * @category WordPress plugin
 * @package haemo-core
 */

namespace HaemoCore\PostTypes;

/**
 * Class for register article post type
 */
class Article
{
    public function __construct()
    {

        $this->articlePostTypeRegister();
    }

    /**
     * Register post type
     *
     * @return void
     */
    public function articlePostTypeRegister(): void
    {
        register_post_type(
            'haemo_article',
            [
                'label'              => __('Article', 'haemo-core'),
                'public'             => true,
                'show_ui'            => true,
                'show_in_nav_menus'  => true,
                'show_in_rest'       => true,
                'hierarchical'       => false,
                'has_archive'        => false,
                'rewrite'            => [
                    'slug' => 'article',
                ],
                'publicly_queryable' => true,
                'supports'           => [
                    'title',
                ],
            ]
        );
    }
}
