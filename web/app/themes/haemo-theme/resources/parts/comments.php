<?php
/**
 * The comments template
 *
 * @category   Themes
 * @package    WordPress
 * @subpackage haemo
 * @author     Yaroslav Popov <ed.creater@gmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://codesweet.ru
 * @since      1.0.0
 */

?>
<div class="comments">
    <div class="comments__title">
        <?php echo __('Comments', 'haemo'); ?>
        <span class="comments__meta">(<?php echo get_comments_number(); ?>)</span>
    </div>
    <div class="comments__content">
        <?php
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </div>
</div>

