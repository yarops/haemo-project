<?php
/**
 * Template for tag
 * @category WordPress theme
 * @package haemo
 */

global $wp_query;

$paged = get_query_var('paged');
$category = get_queried_object();

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination = new \App\Modules\Paginate($wp_query);

$content = category_description();

get_header(); ?>
	<div class="page-layout container">
		<div class="page-layout__ads">
			<?php app()->promo->display( 'side_left' ); ?>
		</div>
		<div class="page-layout__content">
			<section class="content-area content-area--vertical">
				<div class="content-area__column">
					<h1 class="section-title">
						<?php echo single_cat_title(); ?>
					</h1>
					<div class="games-grid">
						<?php
						while (have_posts()) :
							the_post();
							?>

							<?php
							get_template_part(
								'parts/games/game-card',
								null,
								[
									'lazy' => true,
								]
							);
							?>
						<?php endwhile; ?>
					</div>
					<?php $pagination->display(); ?>
				</div>
				<div class="content-area__column">
					<main class="content-widget">
						<div class="content-widget__content content">
							<?php echo apply_filters('the_content', $content); ?>
						</div>
					</main>

					<p class="section-title"><?php echo __('All tags', 'haemo'); ?></p>
					<?php get_template_part('parts/tags-all'); ?>
				</div>
			</section>
		</div>
		<div class="page-layout__ads">
			<?php app()->promo->display( 'side_right' ); ?>
		</div>
	</div>
<?php
get_footer();
