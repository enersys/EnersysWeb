<?php
/**
 * Loads dynamic blocks for server-side rendering.
 *
 * @package Gutenify
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register meta field.
 *
 * @return void
 */
function gutenify_register_meta_fields() {
	$post_types = apply_filters( 'gutenify_active_post_types', array( 'post', 'page', 'wp_template', 'wp_template_part', 'template-kits' ) );
	if ( ! empty( $post_types ) ) {
		$meta_fields['gutenify_custom_css'] = array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			"default" => "",
			// 'auth_callback' => function () {
			// 	return current_user_can( 'edit_posts' );
			// },
			'auth_callback' => '__return_true',
		);

		$meta_fields['gutenify_custom_css_data'] = array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		);

		foreach ( $post_types as $post_type ) {
			if ( ! empty( $meta_fields ) ) {
				foreach ( $meta_fields as $meta_key => $meta_args ) {
					register_post_meta( $post_type, $meta_key, $meta_args );
				}
			}
		}
	}
}
add_action( 'init', 'gutenify_register_meta_fields' );

/**
 * Add block category
 *
 * @param array $categories Block categories.
 * @return array
 */
function gutenify_block_categories( $categories ) {
	// error_log( print_r( $categories, true ));
	return array_merge(
		array(
			array(
				'slug'  => 'gutenify',
				'title' => __( 'Gutenify Blocks', 'gutenify' ),
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'gutenify_block_categories', 100, 2 );
