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

if ( post_password_required() ) {
    return;
}

?>
<div id="comments" class="comments-area scrollbar-inner">
    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) :
        ?>
		<div class="comments-list__wrapper">
			<ol id="comments-list" class="comments-list">
                <?php
                wp_list_comments(
                    array(
                        'style'    => 'ul',
                        'callback' => array( \App\Comments::class, 'comment_template' ),
                    )
                );
                ?>
			</ol><!-- .comment-list -->
		</div>
        <?php
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
            $cpage = get_query_var( 'cpage' ) ? get_query_var( 'cpage' ) : 1;
            echo '<a href="#" class="comments-list__more js-load-comments" data-current="' . $cpage . '" data-post="' . get_the_ID() . '">Load oldest</a>';

        } // Check for comment navigation.
        ?>

    <?php
    endif; // Check for have_comments().

    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'blogus' ); ?></p>
    <?php
    endif;

    $req       = get_option( 'require_name_email' );
    $html_req  = ( $req ? " required='required'" : '' );
    $aria_req  = ( $req ? " aria-required='true'" : '' );
    $commenter = wp_get_current_commenter();
    $consent   = empty( $commenter['comment_author_email'] ) ? '' : 'checked';

    $comment_form_args = array(
        'fields'               => array(
            'title'   => '<p class="comment-form__title">Leave comment</p>',
            'author'  => '<p class="comment-form__row comment-form__row--author comment-form-author">
                <label for="author" class="comment-form__label">' . __( 'Name' ) . ' <span class="required">*</span></label>
                <input
					id="author"
					class="input"
					name="author"
					type="text"
					value="' . esc_attr( $commenter['comment_author'] ) . '"
					size="30"' . $aria_req . $html_req . '
					placeholder="' . __( 'Name' ) . '"
				/>
            </p>',
            'email'   => '<p class="comment-form__row comment-form__row--email comment-form-email">
                <label for="email" class="comment-form__label">' . __( 'Email' ) . ' <span class="required">*</span></label>
                <input
					id="email"
					class="input"
					name="email"
					type="email"
					value="' . esc_attr( $commenter['comment_author_email'] ) . '"
					size="30"
					aria-describedby="email-notes"' . $aria_req . $html_req . '
					placeholder="' . __( 'Email', 'haemo' ) . '"
				/>
            </p>',
            'url'     => false,
            'cookies' => '',
        ),
        'comment_field'        => '<p class="comment-form__row comment-form__row--comment recaptcha-input">
            <label for="comment" class="comment-form__label">' . _x( 'Comment', 'haemo' ) . '</label>
            <textarea
				id="comment"
				class="textarea"
				name="comment"
				cols="45"
				rows="3"
				aria-required="true"
				required="required"
				placeholder="' . _x( 'Comment', 'haemo' ) . '"
			></textarea>
        </p>',
        'submit_field'         => '
			<p class="comment-form__row comment-form__row--submit">
			<label for="wp-comment-cookies-consent" class="comment-form__accept">' .
            sprintf( '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />', $consent ) .
            __( 'I`d read and agree to the terms and conditions.' ) .
            '</label>
			%1$s %2$s' . app()->recaptcha->recaptcha_response_field() . '
			
			</p>
		',
        'submit_button'        => '<button name="%1$s" id="%2$s" class="btn btn--primary btn--xl comment-form__submit" type="submit">Comment</button>',
        'title_reply_before'   => '',
        'title_reply_after'    => '',
        'title_reply'          => '',
        'title_reply_to'       => '',
        'comment_notes_before' => '',
    );

    comment_form( $comment_form_args );
    ?>
</div><!-- #comments -->
