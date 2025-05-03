<?php

/**
 * Privacy popup part
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

use HaemoCore\Utils\Functions;

?>
<div class="privacy-popup privacy hidden">
	<div class="privacy-popup__inner">
		<div class="privacy-popup__content">
			<?php echo esc_html( Functions::getSetting( 'haemo_privacy_content' ) ); ?>
			<br>
			<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">
				<?php echo esc_html( __( 'privacy policy', 'haemo' ) ); ?>
			</a>
		</div>
		<div class="privacy-popup__links">
			<a href="#" class="btn btn--accent btn--small js-policy-agree">
				<?php echo esc_html( __( 'Accept', 'haemo' ) ); ?>
			</a>
			<a href="#" class="btn btn--link btn--small js-policy-agree">
				<?php echo esc_html( __( 'Decline', 'haemo' ) ); ?>
			</a>
		</div>
	</div>
</div>
