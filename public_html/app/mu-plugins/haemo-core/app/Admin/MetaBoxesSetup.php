<?php

/**
 * Setup metaboxes
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 */

namespace HaemoCore\Admin;

use HaemoCore\Admin\MetaBoxes\BoxShortname;
use HaemoCore\Admin\MetaBoxes\Extra\VideoLinkPublic;
use HaemoCore\Admin\MetaBoxes\MetaboxSeo;
use HaemoCore\Admin\MetaBoxes\OptionsArticle;
use HaemoCore\Admin\MetaBoxes\OptionsCategory;
use HaemoCore\Admin\MetaBoxes\OptionsMenu;
use HaemoCore\Admin\MetaBoxes\OptionsPage;
use HaemoCore\Admin\MetaBoxes\OptionsVideo;

/**
 * Initialize metaboxes classes
 */
class MetaBoxesSetup
{
    /**
     * Register metaboxes classes
     */
    public function __construct()
    {
        // add_filter('acf/settings/show_admin', '__return_false');
        // add_action('acf/input/admin_head', array( $this, 'sc_acf_admin_head' ));

        new BoxShortname();
        new OptionsVideo();
        new OptionsArticle();
        new OptionsPage();
        new OptionsCategory();
        new OptionsMenu();
        new MetaboxSeo();
        new VideoLinkPublic();
    }

    /**
     * Rigister script for collapse metabox on page
     *
     * @return void
     */
    public function sc_acf_admin_head()
    {
        ?>
        <script type="text/javascript">
            (function ($) {

                $(document).ready(function () {
                    $('.layout').addClass('-collapsed');
                    $('.acf-postbox').addClass('closed');
                });

            })(jQuery);
        </script>
        <?php
    }
}
