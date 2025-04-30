<?php
/**
 * Privacy popup part
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */
?>
<div class="privacy-popup privacy hidden">
	<div class="privacy-popup__inner">
		<svg class="privacy-popup__lock" width="228px" height="280px">
			<use xlink:href="#icon-lock"></use>
		</svg>
		<div class="privacy-popup__content">
			<?php echo \App\Utils\get_setting( 'swco_privacy_content' ); ?>
			&nbsp;<a href="<?php echo get_privacy_policy_url(); ?>">[<?php echo __( 'privacy policy', 'haemo' ); ?>]</a>
		</div>
		<div class="privacy-popup__links">
			<a href="#" class="btn btn--accent btn--small js-policy-agree"><?php echo __( 'Accept', 'haemo' ); ?></a>
			<a href="#" class="btn btn--link btn--small js-policy-agree"><?php echo __( 'Decline', 'haemo' ); ?></a>
		</div>
	</div>
</div>
