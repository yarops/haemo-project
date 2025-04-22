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
class LibraryCategories
{
    public function __construct()
    {
        $this->libraryCategoryRegister();
    }

    /**
     * Register taxonomy
     *
     * @return void
     */
    protected function libraryCategoryRegister(): void
    {

        $labels = [
            'name'                       => _x('Library category', 'haemo-core'),
            'singular_name'              => _x('Price category', 'haemo-core'),
            'search_items'               => __('Search price categories', 'haemo-core'),
            'popular_items'              => __('Popular price categories'),
            'all_items'                  => __('All price categories'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __('Edit price category'),
            'update_item'                => __('Update price category'),
            'add_new_item'               => __('Add New price category'),
            'new_item_name'              => __('New price category'),
            'separate_items_with_commas' => __('Separate price categories with commas'),
            'add_or_remove_items'        => __('Add or remove price categories'),
            'choose_from_most_used'      => __('Choose from the most used price categories'),
            'menu_name'                  => __('Library categories'),
        ];
        $args = [
            'labels'       => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'hierarchical' => true,
            'publicly_queryable' => true,
            'rewrite'      => [
                'slug' => 'lib-category',
            ],
        ];
        register_taxonomy('haemo_video_categories', ['haemo_video', 'haemo_article'], $args);
    }
}
