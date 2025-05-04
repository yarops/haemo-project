<?php
/**
 * Template for page
 *
 * @category WordPress theme
 * @package haemo
 */

$breadcrumbs = new \App\Modules\Breadcrumbs();

get_header(); ?>
<?php
while ( have_posts() ) :
	the_post();
	?>
	<main class="main">
		<div class="content-area">
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