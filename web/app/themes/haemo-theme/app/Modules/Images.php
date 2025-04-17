<?php

namespace App\Modules;

class Images
{

	function __construct()
	{

	}

	function get_default_thumb($size = 'post-thumbnail', $class = 'img-fluid')
	{
		$size_obj = $this->get_image_size($size);
		$placeholder = 'svg/placeholder.svg';
		$placeholder_url = app()->env->assets_url($placeholder);
		$img_tag = '<img src="'.$placeholder_url.'" class="'.$class.'" width="'.$size_obj['width'].'"  height="'.$size_obj['height'].'" />';

		return $img_tag;
	}

	function cs_get_thumb_lazy($post_id, $size = '', $class = 'img-fluid')
	{
		$class=explode(' ', $class);
		$class[] = 'lazy-image';
		$class=implode(' ', $class);

		$img_tag = get_the_post_thumbnail($post_id, $size, ['class' => $class]);
		$placeholder = 'svg/placeholder.svg';
		$placeholder_attr = 'src="' . app()->env->assets_url($placeholder) . '" ';

		if (empty($img_tag)) {
			return '<img ' . $placeholder_attr . ' alt="Placeholder" class="' . $class . '" />';
		}

		$res = str_replace('src=', $placeholder_attr . 'data-src=', $img_tag);
		$res = str_replace('srcset=', 'data-srcset=', $res);

		return $res;

	}

	/**
	 * Get size information for all currently-registered image sizes.
	 *
	 * @return array $sizes Data for all currently-registered image sizes.
	 * @uses   get_intermediate_image_sizes()
	 * @global $_wp_additional_image_sizes
	 */
	function get_image_sizes()
	{
		global $_wp_additional_image_sizes;

		$sizes = [];

		foreach (get_intermediate_image_sizes() as $_size) {
			if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
				$sizes[$_size]['width'] = get_option("{$_size}_size_w");
				$sizes[$_size]['height'] = get_option("{$_size}_size_h");
				$sizes[$_size]['crop'] = (bool)get_option("{$_size}_crop");
			} elseif (isset($_wp_additional_image_sizes[$_size])) {
				$sizes[$_size] = [
					'width' => $_wp_additional_image_sizes[$_size]['width'],
					'height' => $_wp_additional_image_sizes[$_size]['height'],
					'crop' => $_wp_additional_image_sizes[$_size]['crop'],
				];
			}
		}

		return $sizes;
	}

	/**
	 * Get size information for a specific image size.
	 *
	 * @param string $size The image size for which to retrieve data.
	 *
	 * @return bool|array $size Size data about an image size or false if the size doesn't exist.
	 * @uses   get_image_sizes()
	 */
	function get_image_size($size)
	{
		$sizes = $this->get_image_sizes();

		if (isset($sizes[$size])) {
			return $sizes[$size];
		}

		return false;
	}
}
