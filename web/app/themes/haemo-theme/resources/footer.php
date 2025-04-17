<?php

/**
 * Theme footer
 *
 * @category WordPress theme
 * @package haemo
 */

use App\Utils;

$footer_logo = Utils\get_setting('cs_footer_logo');
?>

<footer class="footer container">
    <div class="footer__menu">
        <?php
        if (has_nav_menu('footer_menu')) {
            $args = [
                'theme_location'  => 'footer_menu',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'footer-nav',
                'walker'          => new \App\Modules\MenuWalker('footer-nav'),
            ];
            wp_nav_menu($args);
        }
        ?>
    </div>
    <?php echo Utils\Html::get_copyright(); ?>
</footer>

<?php get_template_part('parts/privacy-popup'); ?>

</div><!-- wrapper-->

<div class="counters">
    <?php echo Utils\get_setting('swco_counters'); ?>
</div>

<div class="images-preload">
    <?php require app()->env->source_path('svg/icons.svg'); ?>
</div>

<?php wp_footer(); ?>
</body>
</html>
