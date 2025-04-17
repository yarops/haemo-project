<?php
/**
 * Template for 404
 * @category WordPress theme
 * @package haemo
 */

use \App\Utils;

$breadcrumbs = new \App\Modules\Breadcrumbs();

get_header(); ?>

	<section class="page-layout container">
		<div class="page-layout__ads">
			<?php app()->promo->display( 'side_left' ); ?>
		</div>
		<div class="page-layout__content">
			<div class="content-404">
				<h1 class="section-title content-404__title">
					<?php
					echo (Utils\get_setting('swco_404_title'))
						? Utils\get_setting('swco_404_title')
						: __('Error 404', 'haemo');
					?>
				</h1>
				<img
					src="<?php echo app()->env->assets_url('img/404.webp'); ?>"
					alt="Page not found"
					width="595"
					height="221"
				/>

				<div class="content-404__content">
					<?php
					echo (Utils\get_setting('swco_404_content'))
						? apply_filters('the_content', Utils\get_setting('swco_404_content'))
						: __('<p>Sorry, page not found</p>', 'haemo');
					?>
				</div>

				<a href="<?php home_url(); ?>" class="btn btn--primary">
					<?php echo __('Go to homepage', 'haemo'); ?>
				</a>
			</div>
		</div>
		<div class="page-layout__ads">
			<?php app()->promo->display( 'side_right' ); ?>
		</div>
	</section>

<?php
get_footer();
