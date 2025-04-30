<?php
/**
 * Page header
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

use App\Utils;

global $post;

// Set defaults.
$args = wp_parse_args(
    $args,
    array(
        'icon' => '',
    )
);

$classes = ['page-head'];
if (!empty($args['icon'])) {
    $classes = array_push($classes, 'page-head--iconed');
}
?>

<div class="<?php echo implode(' ', $classes); ?>">
    <?php echo $args['icon']; ?>
    <h1 class="page-head__title"><?php the_title(); ?></h1>
    <div class="page-head__meta">
        <?php if (is_single() || is_page()) : ?>
        <a
            href="#comments"
            class="page-head__comments js-comments-link"
            title="Comments link"
            data-target-id="1"
        >
            <?php echo (get_comments_number()) ? get_comments_number() : 'To'; ?>
            <?php echo __(' Comments', 'haemo'); ?>
        </a>
        <?php endif; ?>
    </div>
</div>