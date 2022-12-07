<?php

class Gutenify_block_inline_styles {

	private static $all_styles;

	public static function init() {
		add_action( 'wp', 'Gutenify_block_inline_styles::add_styles' );
		add_action( 'wp_enqueue_scripts', 'Gutenify_block_inline_styles::add_inline_styles', 201 );
	}

	public static function add_styles() {
		add_filter(
			'render_block',
			function( $block_content, $block ) {
				if ( ! empty( $block['attrs']['gutenifyStyles'] ) ) {
					// var_dump( $block['attrs']['gutenifyStyles']);
					self::$all_styles .= $block['attrs']['gutenifyStyles'];

				}
				return $block_content;
			},
			11,
			2
		);
	}

	public static function add_inline_styles() {
		global $wp_styles;
		$handle = 'gutenify-block-inline-handle';
		$deps = array( 'gutenify-frontend' );
		wp_register_style( $handle, false, $deps );
		wp_enqueue_style( $handle );
		wp_add_inline_style( $handle, self::$all_styles );
	}
}

Gutenify_block_inline_styles::init();
