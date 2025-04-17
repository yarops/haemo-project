<?php
/**
 * Player header
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

use App\Utils;
use chillerlan\QRCode\QRCode;

global $post;

$link = get_permalink($post->ID);
$qr = new QrCode();
$controls = get_field('controls', get_the_ID());
?>

<div class="player-header">
	<div class="player-header__item player-header__item--first">
		<div class="single-head__rating">
			<?php app()->rating->rating($post->ID, true); ?>
		</div>
	</div>
	<div class="player-header__item player-header__actions">
<!--		--><?php //if (!is_front_page()) : ?>
<!--			<a-->
<!--				href="#"-->
<!--				class="player-header__btn js-favorites-add"-->
<!--				data-id="--><?php //echo $post->ID; ?><!--"-->
<!--				title="Add to my games"-->
<!--			>-->
<!--				--><?php //echo \App\Utils\Html::get_svg('favorites-add'); ?>
<!--			</a>-->
<!--		--><?php //endif; ?>
		<?php if (!empty($controls)) : ?>
		<a href="#" class="player-header__btn js-modal-toggler" data-modal="modal-controls">
			<?php echo \App\Utils\Html::get_svg('controls'); ?>
		</a>
		<?php endif; ?>

		<a href="#" class="player-header__btn js-modal-toggler" data-modal="modal-qr">
			<?php echo \App\Utils\Html::get_svg('qr'); ?>
		</a>
		<a href="#" class="player-header__btn js-fullscreen-start">
			<?php echo \App\Utils\Html::get_svg('fullscreen'); ?>
		</a>
	</div>

</div>

<div id="modal-qr" class="modal js-modal">
	<div class="modal__inner">
		<div class="game-qr">
			<p class="modal__title"><?php echo __( 'Go to mobile:', 'haemo' ); ?></p>
			<img src="<?php echo $qr->render($link) ?>" alt="QR code">
			<p>Scan and play on you phone or tablet</p>
		</div>
		<a href="#" class="modal__close js-modal-close">
			<?php echo \App\Utils\Html::get_svg('close'); ?>
		</a>
	</div>
</div>

<?php if (!empty($controls)) : ?>
<div id="modal-controls" class="modal js-modal">
	<div class="modal__inner">
		<p class="modal__title"><?php echo __( 'Controls:', 'haemo' ); ?></p>
		<div class="player-controls">
			<?php echo apply_filters('the_content', ($controls) ? $controls : 'No controls'); ?>
		</div>
		<a href="#" class="modal__close js-modal-close">
			<?php echo \App\Utils\Html::get_svg('close'); ?>
		</a>
	</div>
</div>
<?php endif; ?>