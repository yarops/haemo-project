<?php

/**
 * Template for taxonomy library category with query var type
 *
 * @category WordPress theme
 * @package haemo-theme
 */

global $wp_query;

$paged_arg = get_query_var( 'paged' );
$term_slug = get_query_var( 'term' );
$type_arg  = get_query_var( 'type' );

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination  = new \App\Modules\Paginate( $wp_query );
$content     = category_description();

get_header(); ?>
	<main class="main">
		<h4 class="section-title"><?php echo esc_html__( 'Videos', 'haemo' ); ?></h4>

		<?php if ( 'video' === $type ) : ?>
			<div class="video-grid">
				<div class="video-grid__items">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part(
							'parts/video-preview',
							null,
							array(
								'lazy' => true,
							)
						);
						?>
					<?php endwhile; ?>
				</div>
			</div>
		<?php elseif ( 'article' === $type ) : ?>
			<div class="card">
				<table class="table table-striped articles-table">
					<thead>
					<tr>
						<th><?php echo esc_html__( 'Title', 'haemo' ); ?></th>
						<th><?php echo esc_html__( 'Date', 'haemo' ); ?></th>
						<th><?php echo esc_html__( 'Actions', 'haemo' ); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part(
							'parts/article-preview',
							null,
							array(
								'lazy' => true,
							)
						);
						?>
					<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</main>
<?php
get_footer();