<?php
/**
 * Template for search results
 * @category WordPress theme
 * @package haemo
 */

global $wp_query;

$paged = get_query_var('paged');

$breadcrumbs = new \App\Modules\Breadcrumbs();
$pagination = new \App\Modules\Paginate($wp_query);

get_header(); ?>
	<section class="page-layout container">
		<div class="page-layout__ads">
			<?php app()->promo->display('side_left'); ?>
		</div>
		<div class="page-layout__content">
			<div class="content-area content-area--vertical">
				<div class="content-area__column">
					<h1 class="section-title">
						<?php echo __('Search results: ', 'haemo'); ?>
						<?php echo get_query_var('s'); ?>
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
				</div>
			</div>
		</div>
		<div class="page-layout__ads">
			<?php app()->promo->display('side_right'); ?>
		</div>
	</section>

<?php
get_footer();
