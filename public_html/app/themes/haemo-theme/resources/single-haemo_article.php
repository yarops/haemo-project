<?php

/**
 * Template for single. Post type haemo video.
 *
 * @category WordPress theme
 * @package haemo-theme
 */

global $wp_query;

$paged_arg = get_query_var( 'paged' );

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination  = new \App\Modules\Paginate( $wp_query );

get_header(); ?>
<?php
while ( have_posts() ) :
	the_post();
	$article_file = get_field( 'haemo_article_file' );
	?>
	<main class="main">
		<div class="content-area">

			<div class="player">
				<div class="player__content">
					<div class="card">
						<h4 class="card__header"><?php echo esc_html__( 'Authors', 'haemo' ); ?></h4>
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
						<h4 class="card__header"><?php echo esc_html__( 'Description', 'haemo' ); ?></h4>
						<div class="card__body content">
                            <div class="article-description__thumb">
							    <?php get_template_part( 'parts/icons/pdf' ); ?>
                            </div>
						</div>
						<div class="card__footer">
							<?php if ( ! empty( $article_file['url'] ) ) : ?>
								<a
									href="<?php echo esc_url( $article_file['url'] ); ?>"
									class="btn btn--primary"
									target="_blank"
									title="<?php echo esc_html__( 'Open', 'haemo' ); ?>"
								>
									<?php echo esc_html__( 'Open', 'haemo' ); ?>
								</a>
							<?php endif; ?>
							<a
								href="#"
								class="btn btn--link js-copy-link"
								target="_blank"
								title="<?php echo esc_html__( 'Copy link', 'haemo' ); ?>"
							>
								<?php echo esc_html__( 'Copy link', 'haemo' ); ?>
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