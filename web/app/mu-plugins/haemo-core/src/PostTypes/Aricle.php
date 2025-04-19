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
class Aricle
{

	function __construct()
	{

		$this->article_posttype_register();
	}

	/**
	 * Register post type
	 *
	 * @return void
	 */
	function article_posttype_register(): void
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
				'rewrite'            => false,
				'publicly_queryable' => false,
				'supports'           => [
					'title',
				],
			]
		);
	}
}
