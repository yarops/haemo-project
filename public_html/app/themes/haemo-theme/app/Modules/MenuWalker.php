<?php

/**
 * Menu walker class
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package haemo
 */

namespace App\Modules;

use App\Utils\Html;

/**
 * Menu walker class
 */
class MenuWalker extends \Walker_Nav_Menu
{

	/**
	 * What the class handles.
	 *
	 * @since 3.0.0
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */

	public $menu_class = 'menu';

	public $tree_type = array('post_type', 'taxonomy', 'custom');

	/**
	 * Database fields to use.
	 *
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 *
	 * @see Walker::$db_fields
	 */
	public $db_fields = array(
		'parent' => 'menu_item_parent',
		'id' => 'db_id',
	);

	function __construct($menu_class = 'menu')
	{

		$this->menu_class = $menu_class;

	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 */
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat($t, $depth);

		// Default class.
		$classes = array('sub-menu');

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args An object of `wp_nav_menu()` arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @since 4.8.0
		 *
		 */
		$class_names = implode(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 */
	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat($t, $depth);
		$output .= "$indent</ul>{$n}";
	}

	/**
	 * Starts the element output.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param WP_Post $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @param int $id Current item ID.
	 * @see Walker::start_el()
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$classes = empty($item->classes) ? array() : (array)$item->classes;
		$classes[] = $this->menu_class . '__item';
		$classes[] = $this->menu_class . '__item--' . $item->ID;

		/**
		 * Filters the arguments for a page nav menu item.
		 *
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param WP_Post $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @since 4.4.0
		 *
		 */
		$args = apply_filters('nav_menu_item_args', $args, $item, $depth);

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 */

		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 */
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts = array();
		$atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target) ? $item->target : '';
		if ('_blank' === $item->target && empty($item->xfn)) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href'] = !empty($item->url) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 * @type string $title Title attribute.
		 * @type string $target Target attribute.
		 * @type string $rel The rel attribute.
		 * @type string $href The href attribute.
		 * @type string $aria_current The aria-current attribute.
		 * }
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 */
		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (is_scalar($value) && '' !== $value && false !== $value) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$attributes .= ' ' . 'class="' . $this->menu_class . '__link ' . $this->menu_class . '__link--' . $item->ID . '"';

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters('the_title', $item->title, $item->ID);

		/**
		 * Filters a menu item's title.
		 *
		 * @param string $title The menu item's title.
		 * @param WP_Post $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @since 4.4.0
		 *
		 */
		$title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
		$icon = get_post_meta($item->ID, 'icon', true);

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';

		if ($this->menu_class == 'sidemenu') {
			$item_output .= <<<HTML
				<svg class="corner-top" width="8px" height="8px">
					<use xlink:href="#sidemenu-corner-top"></use>
				</svg>
			HTML;
		}

		if ($icon) {
			$icon_el = Html::get_svg($icon);

			$item_output .= <<<HTML
				$icon_el 
			HTML;
		}

		$title_class = $this->menu_class . '__title';
		$item_output .= <<<HTML
			<span class="$title_class">$title</span>
		HTML;

		// $item_output .= '<span class="name">' . $title . '</span>';

		if (in_array('menu-item-has-children', $classes)) {
			$item_output .= '<svg class="icon" width="14px" height="14px"><use xlink:href="#icon-angle-down"></use></svg>';
		}

		if ($this->menu_class == 'sidemenu') {
			$item_output .= <<<HTML
				<svg class="corner-bottom" width="8px" height="8px">
					<use xlink:href="#sidemenu-corner-bottom"></use>
				</svg>
			HTML;
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param WP_Post $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @since 3.0.0
		 *
		 */
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param WP_Post $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 */
	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}
}
