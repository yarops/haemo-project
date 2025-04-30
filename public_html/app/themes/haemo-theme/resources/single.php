<?php
/**
 * Template for page
 *
 * @category WordPress theme
 * @package haemo
 */

global $post;

$breadcrumbs = new \App\Modules\Breadcrumbs();

get_header(); ?>
<?php
while (have_posts()) :
	the_post();
	$thumbnail = app()->images->cs_get_thumb_lazy($post->ID, 'square-thumb', 'img-fluid page-head__icon');
	$fullwidth         = get_field( 'flash_fullwidth' );
	$short_description = get_field( 'short_description' );
    $ifr = get_post_meta($post->ID, 'flash_iframe', true);
    $show = get_post_meta($post->ID, 'flash_show_iframe', true);
	?>
	<div class="game-layout container">
		<div class="game-layout__ads">
			<?php app()->promo->display( 'side_left' ); ?>
		</div>
		<div class="game-layout__top">
			<?php get_template_part(
				'parts/games/side',
				null,
				[
					'key' => 'flash_side_left',
				]
			); ?>
		</div>

		<div class="game-layout__player">

			<?php app()->promo->display( 'top' ); ?>

			<?php if (!empty($ifr)) : ?>
				<?php get_template_part( 'parts/player/player-header' ); ?>

				<?php get_template_part(
					'parts/player/player-content',
					null,
					[
						'fullwidth' => "",
						'iframe'    => $ifr,
						'show'      => $show,
					]
				); ?>

				<?php get_template_part( 'parts/player/player-footer' ); ?>
			<?php endif; ?>

			<?php app()->promo->display( 'bottom' ); ?>

		</div>
		<div class="game-layout__top">
			<?php get_template_part(
				'parts/games/side',
				null,
				[
					'key' => 'flash_side_right',
				]
			); ?>
		</div>
		<div class="game-layout__ads">
			<?php app()->promo->display( 'side_right' ); ?>
		</div>
	</div>

	<div class="content-area container">
		<div class="content-area__column">
			<main class="content-widget">
				<div class="content-widget__content content">
					<?php the_content(); ?>
				</div>
			</main>

			<?php get_template_part('parts/tags'); ?>
		</div>
		<div class="content-area__column">
			<h2 class="section-title">
				<?php echo __('Recommend For You', 'cs-poly'); ?>
			</h2>
			<?php get_template_part('parts/games/related'); ?>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
