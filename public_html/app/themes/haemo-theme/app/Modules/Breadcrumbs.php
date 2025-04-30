<?php

/**
 * Breadcrumbs class file
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package haemo
 */

namespace App\Modules;

use App\Utils\Categories;

/**
 * Breadcrumbs class
 */
class Breadcrumbs
{
    public function displayBreadcrumbs($postid = null)
    {

        /* === ОПЦИИ === */
        $basics = get_option('cs_basics');

        $text['home'] = __('Home', 'cs'); // текст ссылки "Главная"
        $text['category'] = '%s'; // текст для страницы рубрики
        $text['search'] = __('Search results "%s"', 'cs'); // текст для страницы с результатами поиска
        $text['tag'] = __('Posts with tag "%s"', 'cs'); // текст для страницы тега
        $text['author'] = 'Author posts %s'; // текст для страницы автора
        $text['404'] = __('Error 404', 'cs'); // текст для страницы 404
        $text['page'] = __('Страница %s', 'cs'); // текст 'Страница N'
        $text['cpage'] = __('Comments page %s', 'cs'); // текст 'Страница комментариев N'

        $delimiter = '—'; // разделитель между "крошками"
        $delim_before = '<span class="breadcrumbs__item breadcrumbs__delimiter">'; // тег перед разделителем
        $delim_after = '</span>'; // тег после разделителя
        $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
        $show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
        $show_title = 1; // 1 - показывать подсказку (title) для ссылок, 0 - не показывать
        $show_current = 1; // 1 - показывать название текущей страницы, 0 - не показывать
        $before = '<span class="breadcrumbs__item breadcrumbs__current">'; // тег перед текущей "крошкой"
        $after = '</span>'; // тег после текущей "крошки"
        /* === КОНЕЦ ОПЦИЙ === */

        global $post;
        $home_link = home_url('/');
        $link_before = '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumbs__item">';
        $link_after = '</span>';
        $link_attr = ' itemprop="url"';
        $link_in_before = '<span itemprop="title">';
        $link_in_after = '</span>';
        $link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
        $frontpage_id = get_option('page_on_front');

        $blogpageFlag = false;
        $parent_id = '';

        if ($postid) {
            $post = get_post($postid);
        }
        if (is_home() && !is_front_page() && get_option('page_for_posts', true)) {
            $postid = get_option('page_for_posts', true);
            $post = get_post($postid);
            $blogpageFlag = true;
        }
        if ($post) {
            $parent_id = $post->post_parent;
        }
        $delimiter = ' ' . $delim_before . $delimiter . $delim_after . ' ';

        if ((is_home() || is_front_page()) && !$blogpageFlag) {
            if ($show_on_home == 1) {
                echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
            }
        } elseif ($blogpageFlag) {
            echo '<div class="breadcrumbs">';

            if ($show_home_link == 1) {
                printf($link, $home_link, $text['home']);
            }

            if ($show_current == 1) {
                echo $delimiter . $before . get_the_title($post) . $after;
            }

            echo '</div><!-- .breadcrumbs -->';
        } else {
            echo '<div class="breadcrumbs">';
            if ($show_home_link == 1) {
                printf($link, $home_link, $text['home']);
            }

            if (is_category()) {
                $cat = get_category(get_query_var('cat'), false);
                if ($cat->parent != 0) {
                    $cats = Categories::getCategoryParents($cat->parent, true, $delimiter);
                    $cats = preg_replace("#^(.+)$delimiter$#", '$1', $cats);
                    $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
                    if ($show_title == 0) {
                        $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                    }
                    if ($show_home_link == 1) {
                        echo $delimiter;
                    }
                    echo $cats;
                }
                if (get_query_var('paged')) {
                    $cat = $cat->cat_ID;
                    $small_title = get_field('small_title', 'category_' . $cat);
                    if ($small_title) {
                        $title = $small_title;
                    } else {
                        $title = get_cat_name($cat);
                    }
                    echo $delimiter . sprintf($link, get_category_link($cat), $title) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                } else {
                    $title = single_cat_title('', false);

                    if ($show_current == 1) {
                        echo $delimiter . $before . sprintf($text['category'], $title) . $after;
                    }
                }
            } elseif (is_search()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                echo $before . sprintf($text['search'], get_search_query()) . $after;
            } elseif (is_day()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                echo $before . get_the_time('d') . $after;
            } elseif (is_month()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo $before . get_the_time('F') . $after;
            } elseif (is_year()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                echo $before . get_the_time('Y') . $after;
            } elseif (is_single() && !is_attachment()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                if ((get_post_type() == 'post')) {
                    $title = get_the_title();

                    $cat = get_the_category();
                    if ($cat) {
                        $cat = $cat[0];
                        $cats = Categories::getCategoryParents($cat, true, $delimiter);
                        if ($show_current == 0 || get_query_var('cpage')) {
                            $cats = preg_replace("#^(.+)$delimiter$#", '$1', $cats);
                        }
                        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
                        if ($show_title == 0) {
                            $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                        }
                        echo $cats;
                    }

                    if (get_query_var('cpage')) {
                        echo $delimiter . sprintf($link, get_permalink(), $title) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
                    } elseif ($show_current == 1) {
                        echo $before . $title . $after;
                    }
                } elseif (get_post_type() == 'cs_services') {
                    $title = get_the_title();

                    $cat = get_the_terms($post->ID, 'cs_services_cats');
                    $cat = $cat[0];
                    $cats = Categories::getCategoryParents($cat, true, $delimiter);
                    if ($show_current == 0 || get_query_var('cpage')) {
                        $cats = preg_replace("#^(.+)$delimiter$#", '$1', $cats);
                    }
                    $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
                    if ($show_title == 0) {
                        $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                    }
                    echo $cats;

                    if (get_query_var('cpage')) {
                        echo $delimiter . sprintf($link, get_permalink(), $title) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
                    } elseif ($show_current == 1) {
                        echo $before . $title . $after;
                    }
                } else {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                    if ($show_current == 1) {
                        echo $delimiter . $before . get_the_title() . $after;
                    }
                }

                // custom post type
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_tax()) {
                $post_type = get_post_type_object(get_post_type());
                if (get_query_var('paged')) {
                    echo $delimiter . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                } elseif ($show_current == 1) {
                    echo $delimiter . $before . $post_type->label . $after;
                }
                // custom tax
            } elseif (is_tax()) {
                $term_slug = get_query_var('term');
                $tax_name = get_query_var('taxonomy');
                $term = get_term_by('slug', $term_slug, $tax_name);
                if ($term->parent != 0) {
                    $terms = Categories::getTaxtermParents($tax_name, $term->parent, true, $delimiter);
                    $terms = preg_replace("#^(.+)$delimiter$#", '$1', $terms);
                    $terms = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $terms);
                    if ($show_title == 0) {
                        $cats = preg_replace('/ title="(.*?)"/', '', $terms);
                    }
                    if ($show_home_link == 1) {
                        echo $delimiter;
                    }
                    echo $terms;
                }
                if (get_query_var('paged')) {
                    $title = $term->name;
                    echo $delimiter . sprintf($link, get_category_link($term), $title) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                } else {
                    $title = single_term_title('', false);
                    if ($show_current == 1) {
                        echo $delimiter . $before . sprintf($text['category'], $title) . $after;
                    }
                }
            } elseif (is_attachment()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                $parent = get_post($parent_id);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                if ($cat) {
                    $cats = Categories::getCategoryParents($cat, true, $delimiter);
                    $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
                    if ($show_title == 0) {
                        $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                    }
                    echo $cats;
                }
                printf($link, get_permalink($parent), $parent->post_title);
                if ($show_current == 1) {
                    echo $delimiter . $before . get_the_title() . $after;
                }
            } elseif (is_page() && !$parent_id) {
                if ($show_current == 1) {
                    echo $delimiter . $before . get_the_title() . $after;
                }
            } elseif (is_page() && $parent_id) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                if ($parent_id != $frontpage_id) {
                    $breadcrumbs = [];
                    while ($parent_id) {
                        $page = get_page($parent_id);
                        if ($parent_id != $frontpage_id) {
                            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                        }
                        $parent_id = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse($breadcrumbs);
                    for ($i = 0; $i < count($breadcrumbs); $i++) {
                        echo $breadcrumbs[$i];
                        if ($i != count($breadcrumbs) - 1) {
                            echo $delimiter;
                        }
                    }
                }
                if ($show_current == 1) {
                    echo $delimiter . $before . get_the_title() . $after;
                }
            } elseif (is_tag()) {
                if ($show_current == 1) {
                    echo $delimiter . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
                }
            } elseif (is_author()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                global $author;
                $author = get_userdata($author);
                echo $before . sprintf($text['author'], $author->display_name) . $after;
            } elseif (is_404()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                echo $before . $text['404'] . $after;
            } elseif (has_post_format() && !is_singular()) {
                if ($show_home_link == 1) {
                    echo $delimiter;
                }
                echo get_post_format_string(get_post_format());
            }

            echo '</div><!-- .breadcrumbs -->';
        }
    }
}
