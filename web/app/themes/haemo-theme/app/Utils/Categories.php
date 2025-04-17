<?php

namespace App\Utils;

class Categories
{
    public static function getCategoryParents(
        $id,
        $link = false,
        $separator = '/',
        $nicename = false,
        $visited = []
    ): string {
        $chain = '';
        $parent = get_term($id, 'category');
        if (is_wp_error($parent)) {
            return $parent;
        }

        if ($nicename) {
            $name = $parent->slug;
        } else {
            $name = $parent->name;
        }

        if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
            $visited[] = $parent->parent;
            $chain .= get_category_parents($parent->parent, $link, $separator, $nicename, $visited);
        }

        if ($link) {
            $chain .= '<a href="' .
                esc_url(get_category_link($parent->term_id)) . '">' .
                $name . '</a>' .
                $separator;
        } else {
            $chain .= $name . $separator;
        }
        return $chain;
    }

    public static function getTaxtermParents(
        $taxonomy,
        $id,
        $link = false,
        $separator = '/',
        $nicename = false,
        $visited = []
    ): string {
        $chain = '';
        $parent = get_term($id, $taxonomy);
        if (is_wp_error($parent)) {
            return $parent;
        }

        if ($nicename) {
            $name = $parent->slug;
        } else {
            $name = $parent->name;
        }

        if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
            $visited[] = $parent->parent;
            $chain .= self::getTaxtermParents($parent->parent, $link, $separator, $nicename, $visited);
        }

        if ($link) {
            $chain .= '<a href="' .
                esc_url(get_term_link($parent->term_id, $taxonomy)) . '">' .
                $name . '</a>' .
                $separator;
        } else {
            $chain .= $name . $separator;
        }
        return $chain;
    }

    public static function getTermShortname($term_id)
    {

        $term = get_term($term_id);
        $shortname = get_term_meta($term_id, 'swco_shortname', true);

        if (!$shortname) {
            $shortname = $term->name;
        }

        return $shortname;
    }
}
