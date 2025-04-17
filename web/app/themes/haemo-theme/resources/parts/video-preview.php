<?php

/**
 * Video card
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 *
 * @var $args
 */

use App\Utils;

global $post;

// Set defaults.
$args = wp_parse_args(
    $args,
    [
        'lazy' => true,
    ]
);

$short_title = \App\Utils\Posts::swco_get_post_shortname($post->ID);
$thumbnail = app()->images->cs_get_thumb_lazy($post->ID, 'post-thumbnail', 'img-fluid card__thumb');

?>
<div class="card">
    <?php echo $thumbnail; ?>
    <div class="card__body">
        <h5 class="card__title">
            <a
                href="<?php the_permalink(); ?>"
                title="<?php the_title(); ?>"
            >
                <?php echo $short_title; ?>
            </a>
        </h5>
    </div>
</div>
