<?php
/**
 * Comments class
 *
 * @category WordPress theme
 * @package haemo
 */

namespace App;

class Comments {

	/**
	 * Initialize class
	 */
	public function __construct() {
		add_filter( 'comment_post_redirect', array( $this, 'redirect_after_comment' ) );
		add_action( 'wp_ajax_cloadmore', array( $this, 'comments_loadmore_handler' ) );
		add_action( 'wp_ajax_nopriv_cloadmore', array( $this, 'comments_loadmore_handler' ) );
		add_action( 'comments_template_query_args', array( $this, 'comments_order' ) );
	}

	/**
	 * Redirect after post comment
	 *
	 * @param string $location Location after redirect.
	 *
	 * @return [type]
	 */
	public function redirect_after_comment( $location ) {
		return $_SERVER['HTTP_REFERER'];
	}

	/**
	 * Comments ajax loading handler
	 *
	 * @return void
	 */
	public function comments_loadmore_handler() {

		// maybe it isn't the best way to declare global $post variable, but it is simple and works perfectly!

		$comments = get_comments(
			array(
				'post_id' => $_POST['post_id'],
				'status'  => 'approve',
				'type'    => 'comment',
				'order'   => 'DESC',
			)
		);

		wp_list_comments(
			array(
				'style'      => 'ul',
				'callback'   => [\App\Comments::class, 'comment_template'],
				'page'       => $_POST['cpage'],
				'per_page'   => get_option( 'comments_per_page' ),
				'short_ping' => true,
			),
			$comments
		);
		die;
	}

	/**
	 * Reverse comment order
	 *
	 * @param array $comment_args Arguments for comments list.
	 *
	 * @return [type]
	 */
	public function comments_order( $comment_args ) {
		$comment_args['order'] = 'DESC';
		return $comment_args;
	}

	/**
	 * Initialize comment template
	 *
	 * @param mixed $comment
	 * @param mixed $args
	 * @param mixed $depth
	 *
	 * @return void
	 */
	public static function comment_template( $comment, $args, $depth ) {

		// Get correct tag used for the comments
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		} ?>

		<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">

		<?php
		// Switch between different comment types
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				?>
			<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'haemo' ); ?></span> <?php comment_author_link(); ?></div>
				<?php
				break;
			default:
				if ( 'div' != $args['style'] ) {
					?>
				<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<?php } ?>
				<div class="comment-author vcard">
					<?php
					echo get_avatar( $comment, 50 );
					// Display author name
					printf(
						__( '<div class="comment-author__details"><span>%s</span><cite class="fn">%s:</cite></div>', 'haemo' ),
						get_comment_date( 'd.m.Y' ),
						get_comment_author()
					);
					?>
				</div><!-- .comment-author -->
				<div class="comment-details">
					<div class="comment-meta commentmetadata">
						<?php
						edit_comment_link( __( '(Edit)', 'haemo' ), '  ', '' );
						?>
					</div><!-- .comment-meta -->
					<div class="comment-text content"><?php comment_text(); ?></div><!-- .comment-text -->
					<?php
					// Display comment moderation text
					if ( $comment->comment_approved == '0' ) {
						?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'haemo' ); ?></em><br/>
																			<?php
					}
					?>
					<div class="reply">
					<?php
					// Display comment reply link
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => $add_below,
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'reply_text' => '
								<svg class="icon icon--left" width="34px" height="34px">
									<use xlink:href="#icon-shares"></use>
								</svg>
								Reply
								'
							)
						)
					);
					?>
					</div>
				</div><!-- .comment-details -->
				<?php
				if ( 'div' != $args['style'] ) {
					?>
				</div>
					<?php
				}
				// IMPORTANT: Note that we do NOT close the opening tag, WordPress does this for us
				break;
		endswitch; // End comment_type check.
	}
}
