<?php

/**
 * Theme header
 *
 * @category WordPress theme
 * @package haemo
 */

use App\Utils;

global $env;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <title><?php wp_title(); ?></title>

    <?php get_template_part('parts/favicons'); ?>

    <?php echo Utils\get_setting('swco_head_code'); ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="wrapper">
    <?php get_template_part('parts/sidenav-menu'); ?>

    <header class="header">
        <div class="navbar">

            <div class="navbar-panel js-navbar-panel">
                <?php if (has_nav_menu('main_menu')) : ?>
                    <?php
                    $args = [
                        'theme_location'  => 'main_menu',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'navbar-nav',
                        'walker'          => new \App\Modules\MenuWalker('navbar-nav'),
                    ];
                    wp_nav_menu($args);
                    ?>
                <?php endif; ?>

                <div class="navbar__search">
                    <?php get_search_form(); ?>
                </div>
            </div>

            <button
                class="navbar__toggler navbar-toggler js-navbar-panel-toggler"
                aria-label="Menu"
            >
                <?php echo Utils\Html::get_svg('menu'); ?>

            </button>

        </div>

    </header>
