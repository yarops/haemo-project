<?php

namespace App\Modules;

class Rating
{

	function __construct()
	{

		add_action('wp_ajax_set_rating_post', array($this, 'cs_set_rating_ajax'));
		add_action('wp_ajax_nopriv_set_rating_post', array($this, 'cs_set_rating_ajax'));

		add_action('save_post', array($this, 'cs_set_rating_first'));

		add_filter('manage_edit-post_columns', array( $this, 'add_post_rating_column' ));
		add_filter('manage_post_posts_custom_column', array( $this, 'fill_post_rating_column' ), 5, 2);
	}

	public function cs_set_rating_ajax()
	{

		if (!check_ajax_referer('app-nonce', 'nonce', false)) {
			echo 'Not verified!';
			die;
		}

		if (!isset($_POST['data'])) {
			echo 'Incorrect data';
			die;
		}

		$data = json_decode(stripcslashes( $_POST['data']), true);

		if ((isset($data['postId']))) {
			$postId = (int)$data['postId'];
			$currentVote = (int)$data['currentVote'];

			if (empty($_COOKIE['vote-post-' . $postId])) {
				$rate = $this->wp__get_data($postId);

				$this->wp__set_data(
					$postId,
					[
						'rating' => $rate['rating'] + $currentVote,
						'total' => $rate['total'] + 1,
					]
				);

				$abs = round($rate['rating'] / $rate['total'], 0);
				echo $abs;
			} else {
				echo 'limit';
			}

			die();
		}

		die();
	}

	public function rating($postid, $show_info = false, $can_vote = true): void
	{
		if ($can_vote) {
			$disable_class = (isset($_COOKIE['vote-post-' . $postid])) ? ' disabled' : '';
		} else {
			$disable_class = ' disabled';
		}

		$rate = $this->wp__get_data($postid);

		$total_text = $this->sklonen($rate['total'], 'голос', 'голоса', 'голосов', true);

		$pr = ($rate['rating'] / ($rate['total'] * 5)) * 100;
		$abs = round($rate['rating'] / $rate['total'], 0);

		$stars = '';
		for ($i = 5; $i > 0; $i--) {
			$current_class = ($i === (int)$abs) ? 'current' : '';
			$stars .= '<li class="' . $current_class . '" data-vote="' . $i . '"><svg class="icon" width="10px" height="10px"><use xlink:href="#icon-star"></use></svg></li>';
		}

		$info = '';
        if ($show_info) {
            $average = round($rate['rating'] / $rate['total'], 1);
            $info = <<<HTML
            <span class="rating-info__average">{$average}</span>
            <span class="rating-info__del">/</span>
            <span class="rating-info__max">5</span>
            HTML;
        }

		$ratingHTML =
			<<<HTML
			<ol class="rating show-current">{$stars}</ol>
			<div class="vote-block__info rating-info" id="rating-info">{$info}</div>
			HTML;

		$richSnp =
			<<<HTML
			<div typeof="v:Rating">
				<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
					<meta itemprop="bestRating" content="5">
					<meta itemprop="worstRating" content="0">
					<meta property="v:rating" content="{$abs}" />
					<meta itemprop="ratingValue" content="{$abs}">
					<meta itemprop="ratingCount" property="v:votes" content="{$rate['total']}">
				</div>
			</div>
			HTML;

		echo '<div class="vote-block' . $disable_class . '" data-id="' . $postid . '" data-total="' . $rate['total'] . '" data-rating="' . $rate['rating'] . '" rel="v:rating">' . $richSnp . '' . $ratingHTML . '</div>';
	}

	public function rating_info($postid, $show_info = false)
	{

		$rate = $this->wp__get_data($postid);

		$total_text = $this->sklonen($rate['total'], 'голос', 'голоса', 'голосов', true);

		$pr = ($rate['rating'] / ($rate['total'] * 5)) * 100;
		$abs = round($rate['rating'] / $rate['total'], 1);

		$info = '';
        if ($show_info) {
            $average = round($rate['rating'] / $rate['total'], 1);
            $info = <<<HTML
            <span class="rating-info__average">{$average}</span>
            <span class="rating-info__del">/</span>
            <span class="rating-info__max">5</span>
            HTML;
        }

		$ratingHTML = '<ol class="rating show-current"><li>5</li><li>4</li><li>3</li><li>2</li><li>1</li><li class="current"><span style="width:' . $pr . '%"></span></li></ol> ' . $info . ' <div class="rating-info" id="rating-info"></div>';

		$richSnp = '<div typeof="v:Rating"><div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><meta itemprop="bestRating" content="5"><meta itemprop="worstRating" content="0"><meta property="v:rating" content="' . ($abs) . '" /><meta itemprop="ratingValue" content="' . ($abs) . '"><meta itemprop="ratingCount" property="v:votes" content="' . $rate['total'] . '"></div></div>';

		echo '<div class="vote-block-info disabled" data-id="' . $postid . '" data-total="' . $rate['total'] . '" data-rating="' . $rate['rating'] . '" rel="v:rating">' . $richSnp . '' . $ratingHTML . '</div>';
	}

	public function rating_number($postID): float
	{

		$rate = $this->wp__get_data($postID);

		return round($rate['rating'] / $rate['total'], 1);
	}

	public function sklonen($n, $s1, $s2, $s3, $b = false)
	{
		$m = $n % 10;
		$j = $n % 100;
		if ($m == 0 || $m >= 5 || ($j >= 10 && $j <= 20)) {
			return $n . ' ' . $s3;
		}
		if ($m >= 2 && $m <= 4) {
			return $n . ' ' . $s2;
		}
		return $n . ' ' . $s1;
	}


	public function wp__set_data($postID, $rate): void
	{
		$total = get_post_meta($postID, 'vote-total', true);
		$rating = get_post_meta($postID, 'vote-rating', true);

		if (empty($total) || empty($rating)) {
			update_post_meta($postID, 'vote-total', 1);
			update_post_meta($postID, 'vote-rating', 5);
		} else {
			update_post_meta($postID, 'vote-total', $rate['total']);
			update_post_meta($postID, 'vote-rating', $rate['rating']);
		}
	}

	public function wp__get_data($postID): array
	{
		$total = get_post_meta($postID, 'vote-total', true);
		$rating = get_post_meta($postID, 'vote-rating', true);

		if (empty($total) || empty($rating)) {
			$this->wp__set_data(
				$postID,
				[
					'total' => 1,
					'rating' => 5,
				]
			);

			return [
				'total' => 1,
				'rating' => 5,
			];
		}

		return [
			'total' => $total,
			'rating' => $rating,
		];
	}

	function cs_set_rating_first($post_id): void
	{

		global $post_type;

		$post_type_object = get_post_type_object($post_type);

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			|| (!isset($_POST['post_ID']) || $post_id != $_POST['post_ID'])
			|| (!in_array($post_type, array('post')))
			|| (!current_user_can($post_type_object->cap->edit_post, $post_id))) {
			return;
		}

		$vote_total = get_post_meta($post_id, 'vote-total', true);

		if ($vote_total === '') {

			delete_post_meta($post_id, 'vote-total');
			delete_post_meta($post_id, 'vote-rating');

			add_post_meta($post_id, 'vote-total', '1');
			add_post_meta($post_id, 'vote-rating', '5');

		}
	}

	function fill_post_rating_column($colname, $post_id): void
	{
		if ($colname === 'post_rating') {
			$rating = $this->rating_number($post_id);

			if (! empty($rating)) {
				echo '<span style="color:green;">'.$rating.'</span>';
			}
		}
	}

	function add_post_rating_column($columns)
	{
		$num = 2;

		$column_flash = array(
			'post_rating' => __('Rate'),
		);

		return array_slice($columns, 0, $num) + $column_flash + array_slice($columns, $num);
	}
}