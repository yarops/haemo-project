<?php

/**
 * Template for single. Post type haemo video.
 *
 * @category WordPress theme
 * @package haemo-theme
 */

global $wp_query;

$paged = get_query_var('paged');

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination = new \App\Modules\Paginate($wp_query);

get_header(); ?>
    <main class="main">
        <h4 class="section-title"><?php echo __('Videos', 'haemo'); ?></h4>

        <div class="content-area">
            asd
        </div>

    </main>
<?php
get_footer();