<?php

/**
 * Template for category
 *
 * @category WordPress theme
 * @package haemo-theme
 */

global $wp_query;

$paged     = get_query_var( 'paged' );
$term_slug = get_query_var( 'term' );

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination  = new \App\Modules\Paginate( $wp_query );
$content     = category_description();

$video_query = new \WP_Query(
	array(
		'post_type'      => 'haemo_video',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'tax_query'      => array(
			array(
				'taxonomy' => 'haemo_library_category',
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
	)
);
$video_nav    = new \App\Modules\Paginate( $video_query );

$article_query = new \WP_Query(
	array(
		'post_type'      => 'haemo_article',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'tax_query'      => array(
			array(
				'taxonomy' => 'haemo_library_category',
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
	)
);
$article_nav    = new \App\Modules\Paginate( $article_query );

get_header(); ?>
	<main class="main js-main">
		<h4 class="section-title"><?php echo __( 'Videos', 'haemo' ); ?></h4>
		<div class="video-grid">
			<div class="video-grid__items">
				<?php
				while ( $video_query->have_posts() ) :
					$video_query->the_post();
					?>

					<?php
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
			<div class="video-grid__nav">
				<?php $video_nav->display(); ?>
			</div>
		</div>

		<h4 class="section-title"><?php echo esc_html__( 'Articles', 'haemo' ); ?></h4>

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
				while ( $article_query->have_posts() ) :
					$article_query->the_post();
					?>
					<tr>
						<td>
							<a href="<?php the_permalink(); ?>" class="articles-table__link">
								<?php the_title(); ?>
							</a>
						</td>
						<td><?php the_date( 'd F Y' ); ?></td>
						<td class="text-muted">
							<a href="<?php the_permalink(); ?>" class="articles-table__action">
								<?php get_template_part( 'parts/icons/document-download' ); ?>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
			</table>

			<?php $article_nav->display(); ?>
		</div>
	</main>
<?php
get_footer();