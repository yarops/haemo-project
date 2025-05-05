<?php

/**
 * Article card
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 *
 * @var $args
 */

use App\Utils;

global $post;

// Set defaults.
$args = wp_parse_args(
	$args,
	array(
		'lazy' => true,
	)
);

$short_title = \App\Utils\Posts::swco_get_post_shortname( $post->ID );
$thumbnail   = app()->images->cs_get_thumb_lazy( $post->ID, 'post-thumbnail', 'img-fluid card__thumb' );
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
