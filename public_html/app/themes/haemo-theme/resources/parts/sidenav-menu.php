<?php

/**
 * Single categories
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

use App\Utils;
use App\Controllers\LibraryController;

$tags = get_terms( array( 'taxonomy' => 'haemo_library_category' ) );
?>
<div class="sidenav-menu js-sidenav">
	<button class="sidenav-menu__toggler js-sidenav-toggler">
		<svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25"></path>
		</svg>
	</button>
	<div class="sidenav-menu__logo">
		<a href="/" class="logo">
			<img
				src="<?php echo esc_url( app()->env->assets_url( 'svg/logo.svg' ) ); ?>"
				alt=""
				width="50"
				height="50"
			/>
			<span class="logo__text">
				<?php echo esc_attr__( 'HAEMO', 'haemo' ); ?>
				<span class="accent"><?php echo esc_attr__( 'LIB', 'haemo' ); ?></span>
			</span>
		</a>
	</div>
	<ul class="side-nav">
		<?php
		foreach ( $tags as $tag ) :
			?>
			<li class="side-nav__item">
				<a
					class="side-nav__link"
					href="<?php echo esc_url( get_term_link( $tag ) ); ?>"
				>
					<?php echo Utils\Categories::getTermShortname( $tag->term_id ); ?>
				</a>
				<ul class="side-nav__sub">
					<li class="side-nav__item">
						<a
							class="side-nav__link side-nav__link--sub"
							href="<?php echo LibraryController::constructLibraryLink( $tag, 'video' ); ?>"
						>
							<?php get_template_part( 'parts/icons/play' ); ?>
							<?php echo __( 'Videos', 'haemo' ); ?>
						</a>
					</li>
					<li class="side-nav__item">
						<a
							class="side-nav__link side-nav__link--sub"
							href="<?php echo LibraryController::constructLibraryLink( $tag, 'article' ); ?>"
						>
							<?php get_template_part( 'parts/icons/document' ); ?>
							<?php echo __( 'Articles', 'haemo' ); ?>
						</a>
					</li>
				</ul>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
