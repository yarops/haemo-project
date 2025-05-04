<?php
/**
 * Copyright
 *
 * @category WordPress theme
 * @package haemo
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

use HaemoCore\Utils\Functions;

$copy       = Functions::getSetting( 'haemo_copyright' );
$copy_label = '© ' . gmdate( 'Y' ) . ' / ' . get_bloginfo( 'name' );
?>
<div class="copyright">
    <?php echo esc_html( $copy_label ); ?>
    <?php esc_html( $copy ); ?>
</div>
