<?php

namespace App\Modules;

class Blocks
{
	public $id;
	public $name;
	public $class_name;
	public $inline_styles;

	function __construct($block)
	{
		$this->parse_name($block);
		$this->parse_classes($block);
		$this->parse_styles($block);
	}

	function parse_name($block)
	{
		$this->id = $block['id'];
		$this->name = str_replace('garin/', '', $block['name']);
	}

	function parse_classes($block)
	{
		$classes = [
			'gr-block',
			$this->name,
			'wp-block-garin-' . $this->name
		];

		if( !empty($block['className']) ) {
			$custom_classes = explode(' ', $block['className']);
			$classes = array_merge($classes, $custom_classes);
		}

		$this->class_name = $classes;
	}

	function parse_styles($block)
	{
		if ( ! empty( $block['style'] ) ) {
			$style_engine = wp_style_engine_get_styles( $block['style'] );
			$style        = $style_engine['css'];
		} else {
			$style = '';
		}

		$this->inline_styles = $style;
	}

	function spacing() {


		$stylesMobile = $stylesDesktop = [];
		$desctop = $mobile = '';
		$paddingDesktop = get_field('custom_padding');
		$paddingMobile = get_field('custom_padding_mobile');
		$marginDesktop = get_field('custom_margin');
		$marginMobile = get_field('custom_margin_mobile');

		$block_styles_mobile = new InlineStyler();
		$block_styles_mobile->name("#$this->id");

		$block_styles_mobile->set(
			'padding-top',
			(!empty($paddingMobile['top'])) ? $paddingMobile['top'] : '',
			'px'
		);
		$block_styles_mobile->set(
			'padding-bottom',
			(!empty($paddingMobile['bottom'])) ? $paddingMobile['bottom'] : '',
			'px'
		);

		$block_styles_mobile->set(
			'margin-top',
			(!empty($marginMobile['top'])) ? $marginMobile['top'] : '',
			'px'
		);
		$block_styles_mobile->set(
			'margin-bottom',
			(!empty($marginMobile['bottom'])) ? $marginMobile['bottom'] : '',
			'px'
		);

		$block_styles_desctop = new InlineStyler();
		$block_styles_desctop->media('min-width: 768px');
		$block_styles_desctop->name("#$this->id");

		$block_styles_desctop->set(
			'padding-top',
			(!empty($paddingDesktop['top'])) ? $paddingDesktop['top'] : '',
			'px'
		);
		$block_styles_desctop->set(
			'padding-bottom',
			(!empty($paddingDesktop['bottom'])) ? $paddingDesktop['bottom'] : '',
			'px'
		);

		$block_styles_desctop->set(
			'margin-top',
			(!empty($marginDesktop['top'])) ? $marginDesktop['top'] : '',
			'px'
		);
		$block_styles_desctop->set(
			'margin-bottom',
			(!empty($marginDesktop['bottom'])) ? $marginDesktop['bottom'] : '',
			'px'
		);


		return [
			$block_styles_mobile,
			$block_styles_desctop
		];
	}
}
