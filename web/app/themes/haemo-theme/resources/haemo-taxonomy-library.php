<?php

/**
 * Template for taxonomy library category with query var type
 * @category WordPress theme
 * @package haemo-theme
 */

global $wp_query;

$paged = get_query_var('paged');
$term_slug = get_query_var('term');

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination = new \App\Modules\Paginate($wp_query);
$content = category_description();

get_header(); ?>
    <main class="main">
        <h4 class="section-title"><?php echo __('Videos', 'haemo'); ?></h4>
        <div class="video-grid">
            <div class="video-grid__items">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>

                    <?php
                    get_template_part(
                        'parts/video-preview',
                        null,
                        [
                            'lazy' => true,
                        ]
                    );
                    ?>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
<?php
get_footer();