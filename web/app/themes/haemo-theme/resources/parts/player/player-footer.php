<?php
/**
 * Player footer part
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

global $post;
?>
<div class="player-footer">
	<h1 class="player-footer__title"><?php the_title(); ?></h1>
	<?php get_template_part('parts/shares'); ?>
</div>