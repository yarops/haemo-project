<?php
/**
 * Template part player for home
 *
 * @category WordPress theme
 * @package haemo
 *
 * @var array $args Template parsed variables.
 */

use App\Utils;

global $post;

// Set defaults.
$args = wp_parse_args(
	$args,
	array(
		'iframe' => 0,
	)
);

$short_title       = \App\Utils\Posts::swco_get_post_shortname( $post->ID );
$short_description = get_post_meta( $post->ID, 'short_description', true );

$ifr         = $args['iframe'];
$show_iframe = Utils\get_setting('swco_show_iframe');
$thumb       = get_the_post_thumbnail( $post->ID, 'post-thumbnail', array( 'class' => 'player-placeholder__thumb' ) );
$bg       = get_the_post_thumbnail_url( $post->ID, 'full' );

$iframe = html_entity_decode( $ifr );
$iframe = str_replace( '<embed', '<embed wmode="opaque"', $iframe );
?>

<div class="player-content">
	<?php
	if ( ! empty( $iframe ) && ! $show_iframe ) :
		?>

		<div
			id="flash-container"
			class="flash-container iframe"
			data-fullwidth="<?php echo $args['fullwidth']; ?>"
		>
			<div
				id="js-overlay"
				class="player-placeholder"
				style="--background: url(<?php echo $bg; ?>)"
			>
				<div class="player-placeholder__content">
					<?php echo $thumb; ?>
					<p class="player-placeholder__title"><?php the_title(); ?></p>
					<button
						id="js-player-start"
						class="player-placeholder__start"
						data-code="<?php echo htmlentities( $iframe ); ?>"
					>
						<span><?php echo __( 'Play now', 'haemo' ); ?></span>
						<?php echo \App\Utils\Html::get_svg('play'); ?>
					</button>
				</div>
			</div>
		</div>
		<?php
	elseif ( ! empty( $iframe ) && $show_iframe ) :
		$iframe = str_replace( 'src', 'external_src', $iframe );
		?>
		<div id="flash-container" class="flash-container iframe"
			data-fullwidth="<?php echo $args['fullwidth']; ?>"><?php echo $iframe; ?></div>
	<?php else : ?>
		<div id="flash-container" class="flash-container iframe" data-fullwidth="0">
			<?php echo __('<p class="flash-container__message">Not found fields!</p>', 'haemo'); ?>
		</div>
	<?php endif; ?>

</div>
