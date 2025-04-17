<?php

namespace App\Modules;

class Likes
{

	function __construct()
	{

		add_action('wp_ajax_set_like_post', array($this, 'set_like_post'));
		add_action('wp_ajax_nopriv_set_like_post', array($this, 'set_like_post'));
		add_action('wp_ajax_set_dislike_post', array($this, 'set_dislike_post'));
		add_action('wp_ajax_nopriv_set_dislike_post', array($this, 'set_dislike_post'));

		add_action('add_meta_boxes', array($this, 'add_cs_likes_box'));
		add_action('save_post', array($this, 'save_cs_likes_box'));

	}

	/**
	 * Add metabox to admin interface
	 *
	 * @param $post_type
	 * @return void
	 */
	function add_cs_likes_box($post_type)
	{
		add_meta_box(
			'cs_likes_box',
			__('CS Likes/Dislikes', 'cslikes'),
			array($this, 'show_cs_likes_box'),
			array('post', 'page'),
			'side',
			'high'
		);
	}


	/**
	 * Callback for add_post_meta_box()
	 * Display metabox content
	 *
	 * @param int|object $post
	 */
	function show_cs_likes_box($post)
	{

		wp_nonce_field(plugin_basename(__FILE__), 'cs_likes_box_content_nonce');
		$likes = get_post_meta($post->ID, 'cs_post_likes', true);
		$dislikes = get_post_meta($post->ID, 'cs_post_dislikes', true);

		echo '<p><label for="post_likes" style="display: inline-block; width: 30%;">' . __('Likes', 'cslikes') . '</label>';
		echo '<input type="text" id="post_likes" name="post_likes" value="' . $likes . '" style="width: 65%;" /></p>';

		echo '<p><label for="post_dislikes" style="display: inline-block; width: 30%;">' . __('Dislikes', 'cslikes') . '</label>';
		echo '<input type="text" id="post_dislikes" name="post_dislikes" value="' . $dislikes . '" style="width: 65%;" /></p>';

	}


	/**
	 * Save metabox content
	 *
	 * @param int $post_id
	 * @return void
	 */
	function save_cs_likes_box($post_id)
	{

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (!isset($_POST['cs_likes_box_content_nonce'])) {
			return;
		}
		if (!wp_verify_nonce($_POST['cs_likes_box_content_nonce'], plugin_basename(__FILE__))) {
			return;
		}

		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return;
			}
		} else {
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
		}

		$post_dislikes = $_POST['post_dislikes'];
		update_post_meta($post_id, 'cs_post_dislikes', $post_dislikes);

		$post_likes = $_POST['post_likes'];
		update_post_meta($post_id, 'cs_post_likes', $post_likes);

	}


	/**
	 * Set Likes Post
	 */
	function set_like_post()
	{
		global $wpdb;

		$error = '';

		check_ajax_referer('app-nonce', 'nonce');

		if (!$_POST || !isset($_POST['postID']) || empty($_POST['postID'])) {
			return;
		}
		$post_id = $_POST['postID'];

		// check IP
		$client_ip = $_SERVER['REMOTE_ADDR'];
		$voted_ip = get_post_meta($post_id, 'cs_vote_ip', true);

		if (isset($voted_ip[$client_ip]) && $voted_ip[$client_ip]) {
			$voted_time = $voted_ip[$client_ip];
			$different_time = time() - $voted_time;
			if ($different_time < 10 * 60) {
				$error .= __('With your IP has already voted , please try later', 'cslikes');
			}
		}

		if (empty($error)) {
			if ($_POST['vote'] === 'like') {

				// set IP dislike
				$voted_ip = get_post_meta($post_id, 'cs_vote_ip', true);

				if (is_array($voted_ip)) {
					$voted_ip[$client_ip] = time();
				} else {
					$voted_ip = array(
						$client_ip => time(),
					);
				}

				update_post_meta($post_id, 'cs_vote_ip', $voted_ip);

				// set dislike
				$post_likes = get_post_meta($post_id, 'cs_post_likes', true);
				update_post_meta($post_id, 'cs_post_likes', (int)$post_likes + 1);

			} else {
				return;
			}

			$post_likes = get_post_meta($post_id, 'cs_post_likes', true);

			$response = array(
				'success' => true,
				'html' => $post_likes,
				'post_id' => $post_id,
				'success_message' => __('Like counted!', 'cslikes'),
			);
			wp_send_json_success($response);
		}

		$response = array(
			'success' => false,
			'comment_id' => $post_id,
			'error_message' => $error,
		);
		wp_send_json_error($response);

	}


	/**
	 * Set Dislikes Post
	 */
	function set_dislike_post()
	{
		global $wpdb;

		$error = '';

		check_ajax_referer('app-nonce', 'nonce');

		if (!$_POST || !isset($_POST['postID']) || empty($_POST['postID'])) {
			return;
		}
		$post_id = $_POST['postID'];

		// check IP
		$client_ip = $_SERVER['REMOTE_ADDR'];

		$voted_ip = get_post_meta($post_id, 'cs_vote_ip', true);

		if (isset($voted_ip[$client_ip]) && $voted_ip[$client_ip]) {
			$voted_time = $voted_ip[$client_ip];
			$different_time = time() - $voted_time;
			if ($different_time < 10 * 60) {
				$error .= __('With your IP has already voted , please try later', 'cslikes');
			}
		}

		// Set dislikes
		if (empty($error)) {
			if ($_POST['vote'] === 'dislike') {

				// set IP dislike
				$voted_ip = get_post_meta($post_id, 'cs_vote_ip', true);

				if (is_array($voted_ip)) {
					$voted_ip[$client_ip] = time();
				} else {
					$voted_ip = array(
						$client_ip => time(),
					);
				}

				update_post_meta($post_id, 'cs_vote_ip', $voted_ip);

				// set dislike
				$post_dislikes = get_post_meta($post_id, 'cs_post_dislikes', true);
				update_post_meta($post_id, 'cs_post_dislikes', (int)$post_dislikes + 1);

			} else {
				return;
			}

			$post_dislikes = get_post_meta($post_id, 'cs_post_dislikes', true);

			$response = array(
				'success' => true,
				'html' => $post_dislikes,
				'post_id' => $post_id,
				'success_message' => __('Dislike counted!', 'cslikes'),
			);
			wp_send_json_success($response);
		}

		$response = array(
			'success' => false,
			'comment_id' => $post_id,
			'error_message' => $error,
		);
		wp_send_json_error($response);

	}


	/**
	 * Display Buttons Like and Dislike
	 *
	 * @param integer $post_id if call function outside loop
	 * @param boolean $show if call function outside loop
	 *
	 * @return string $form html form
	 */
	public function show_buttons_like($post_id = null, $show = false)
	{
		global $post, $current_user;

		if (!$post_id) {
			$post_id = $post->ID;
		}
		$post_likes = get_post_meta($post_id, 'cs_post_likes', true);
		if (empty($post_likes)) {
			$post_likes = 0;
		}
		$post_dislikes = get_post_meta($post_id, 'cs_post_dislikes', true);
		if (empty($post_dislikes)) {
			$post_dislikes = 0;
		}

		$form = '<div id="cs-likes-dislikes-' . $post_id . '" class="cs-likes-dislikes">';
		$form .= '<form action="" method="post" class="cs-likes-dislikes-form">';

		$form .= '<a href="#" class="cs-like-post" data-post="' . $post_id . '">';
		$form .= '<svg class="icon" width="24px" height="24px"><use xlink:href="#icon-like"></use></svg>';
		$form .= '<span class="like-count">' . $post_likes . '</span></a>';
		$form .= '<a href="#" class="cs-dislike-post" data-post="' . $post_id . '">';
		$form .= '<svg class="icon" width="24px" height="24px"><use xlink:href="#icon-like"></use></svg>';
		$form .= '<span class="dislike-count">' . $post_dislikes . '</span></a>';

		$form .= '</form>';
		$form .= '</div>';

		if ($show) {
			echo $form;
		}
		return $form;
	}


	/**
	 * Get Post Likes
	 *
	 * @param $post_id
	 * @return mixed
	 */
	public static function get_post_likes($post_id)
	{
		$post_likes = get_post_meta($post_id, 'cs_post_likes', true);
		return $post_likes;
	}

	/**
	 * Get Post Dislikes
	 *
	 * @param $post_id
	 * @return mixed
	 */
	public static function get_post_dislikes($post_id)
	{
		$post_dislikes = get_post_meta($post_id, 'cs_post_dislikes', true);
		return $post_dislikes;
	}

	/**
	 * Add comment karma column to the admin view.
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function add_comment_columns($columns)
	{

		return array_merge(
			$columns,
			array(
				'comment_karma' => __('Karma', 'esuf'),
			)
		);

	}

}