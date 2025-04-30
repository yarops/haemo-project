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

<div class="wrapper js-wrapper">
    <?php get_template_part('parts/sidenav-menu'); ?>

    <header class="header">
        <div class="navbar">
            <?php get_template_part('parts/page-header'); ?>

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

                </div>
            </div>

            <button
                class="search-form-toggler js-modal-toggler"
                aria-label="Search toggle"
                data-target="#searchModal"
            >
                <span>Search something..</span>
                <?php get_template_part('parts/icons/magnifying-glass'); ?>
            </button>
        </div>
    </header>
