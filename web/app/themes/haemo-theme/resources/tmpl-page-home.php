<?php

/**
 * Home page template
 *
 * @category WordPress theme
 * @package haemo
 *
 * Template Name: Home
 */

global $post;

$query_arg_paged = get_query_var('page');
$paged = ($query_arg_paged) ? $query_arg_paged : 1;

$ifr = get_post_meta($post->ID, 'flash_iframe', true);
$show = get_post_meta($post->ID, 'flash_show_iframe', true);

$args = [
    'post_type'      => 'haemo_video',
    'post_status'    => 'publish',
    'posts_per_page' => get_option('posts_per_page'),
    'paged'          => $paged,
];
$gg = new WP_Query($args);
$pagination = new \App\Modules\Paginate($gg);

get_header(); ?>
<?php while (have_posts()) :
    the_post();
    ?>
    <main class="main">

        <div class="video-grid">
            <h2 class="section-title">
                <?php echo __('Recommend For You', 'haemo'); ?>
            </h2>
            <div class="video-grid__items">
                <?php
                while ($gg->have_posts()) :
                    $gg->the_post();

                    get_template_part('parts/video-preview');
                    ?>
                <?php endwhile; ?>
            </div>
            <?php $pagination->display(); ?>
        </div>

        <div class="content-area__column">
            <div class="content-widget">
                <div class="content-widget__content content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php get_template_part('parts/tags-all'); ?>
        </div>

    </main>

<?php endwhile; ?>

<?php get_footer(); ?>