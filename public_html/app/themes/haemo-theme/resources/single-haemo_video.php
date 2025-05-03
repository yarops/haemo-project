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
	$disk_link  = get_field( 'haemo_video_public_link' );
	$video_link = get_field( 'haemo_video_public_link' );
	?>
	<main class="main">
		<div class="content-area">

			<div class="player">
				<div class="player__content">
					<video
						id="js-player"
						class="video-js"
						controls
						preload="auto"
						poster="<?php the_post_thumbnail_url( 'full' ); ?>"
						data-setup='{"fluid": true}'
					>
						<source src="<?php echo esc_url( $video_link ); ?>" type="video/mp4"></source>
						<!--                <source src="//vjs.zencdn.net/v/oceans.webm" type="video/webm"></source>-->
						<!--                <source src="//vjs.zencdn.net/v/oceans.ogv" type="video/ogg"></source>-->
						<p class="vjs-no-js">
							To view this video please enable JavaScript, and consider upgrading to a
							web browser that
							<a href="https://videojs.com/html5-video-support/" target="_blank">
								supports HTML5 video
							</a>
						</p>
					</video>
				</div>
				<div class="player__description">
					<div class="card">
						<h4 class="card__header">
							<?php echo esc_html__( 'Description', 'haemo' ); ?>
						</h4>
						<div class="card__body content">
							<?php the_content(); ?>
						</div>
						<div class="card__footer">
							<a
								href="<?php echo $disk_link; ?>"
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
				<h4 class="card__header">sdfsdf</h4>
				<div class="card__body content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>

	</main>
<?php endwhile; ?>
<?php
get_footer();