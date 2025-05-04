<?php

/**
 * Template for single. Post type haemo video.
 *
 * @category WordPress theme
 * @package haemo-theme
 */

global $wp_query;

$paged = get_query_var( 'paged' );

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination  = new \App\Modules\Paginate( $wp_query );

get_header(); ?>
<?php
while ( have_posts() ) :
	the_post();
	$videoLink = get_field( 'video_link' );
	$diskLink  = 'https://getfile.dokpub.com/yandex/get/' . $videoLink;
	?>
	<main class="main">
		<div class="content-area">

			<div class="player">
				<div class="player__content">
					<div class="card">
						<h4 class="card__header"><?php echo __( 'Authors', 'haemo' ); ?></h4>
						<div class="card__body content">
							<?php echo apply_filters( 'the_content', get_field( 'article_authors' ) ); ?>
						</div>
						<div class="card__footer">
							<?php echo apply_filters( 'the_content', get_field( 'article_authors_info' ) ); ?>
						</div>
					</div>
				</div>
				<div class="player__description">
					<div class="card">
						<h4 class="card__header"><?php echo __( 'Description', 'haemo' ); ?></h4>
						<div class="card__body content">

						</div>
						<div class="card__footer">
							<a
								href="<?php echo $diskLink; ?>"
								class="btn btn--primary"
								target="_blank"
								title="<?php echo __( 'Download', 'haemo' ); ?>"
							>
								<?php echo __( 'Download', 'haemo' ); ?>
							</a>
							<a
								href="#"
								class="btn btn--link js-copy-link"
								target="_blank"
								title="<?php echo __( 'Copy link', 'haemo' ); ?>"
							>
								<?php echo __( 'Copy link', 'haemo' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card__body content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>

	</main>
<?php endwhile; ?>
<?php
get_footer();