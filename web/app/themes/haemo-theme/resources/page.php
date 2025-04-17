<?php
/**
 * Template for page
 *
 * @category WordPress theme
 * @package haemo
 */

$paged = get_query_var('page');

$breadcrumbs = new \App\Modules\Breadcrumbs();

get_header(); ?>
<?php while (have_posts()) :
    the_post();
    ?>
	<section class="page-layout container">
		<div class="page-layout__ads">
			<?php app()->promo->display('side_left'); ?>
		</div>
		<div class="page-layout__content">
			<h1 class="section-title"><?php the_title(); ?></h1>
			<div class="content-widget content">
				<?php the_content(); ?>
			</div>
		</div>
		<div class="page-layout__ads">
			<?php app()->promo->display('side_right'); ?>
		</div>
	</section>

<?php endwhile; ?>
<?php
get_footer();