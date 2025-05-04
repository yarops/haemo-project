<?php

/**
 * Theme footer
 *
 * @category WordPress theme
 * @package haemo
 */

use App\Utils;

?>

<footer class="footer container">
	<div class="footer__menu">
		<?php
		if ( has_nav_menu( 'footer_menu' ) ) {
			$args = array(
				'theme_location'  => 'footer_menu',
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'menu_class'      => 'footer-nav',
				'walker'          => new \App\Modules\MenuWalker( 'footer-nav' ),
			);
			wp_nav_menu( $args );
		}
		?>
	</div>
	<?php get_template_part( 'parts/commons/copyright' ); ?>
</footer>

<?php get_template_part( 'parts/privacy-popup' ); ?>

</div><!-- wrapper-->

<div class="modals">
	<div id="searchModal" class="modal fade js-modal">
		<div class="modal__inner">
			<?php get_search_form(); ?>
		</div>
	</div>
	<div class="modals__backdrop fade js-modal-backdrop"></div>
</div>

<div class="images-preload">
	<?php require app()->env->source_path( 'svg/icons.svg' ); ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
