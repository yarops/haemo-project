<?php

/**
 * Single categories
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

use App\Utils;

global $post;

$tags = get_the_terms($post->ID, 'post_tag');

if (!empty($tags) && !is_wp_error($tags)) :
    ?>
    <div class="tags">
        <?php foreach ($tags as $tag) :
            ?>
            <a href="<?php echo get_category_link($tag->term_id); ?>" class="tag-link">
                <div class="tag-link__title">
                    <?php echo Utils\Categories::getTermShortname($tag->term_id); ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>