<?php
/**
 * Actions functions
 *
 * @package Gutenify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Gutenify_Actions
 */
class Gutenify_Actions {

	/**
	 * Gutenify_Actions constructor.
	 */
	public function __construct() {
		add_action( 'use_block_editor_for_post_type', array( $this, 'disable_gutenberg' ), 10, 2 );
		add_filter( 'gutenify_skip_gutenburg_post_type', array( $this, 'skip_gutenburg_post_type' ) );

		add_action(
			'save_post',
			function( $post_id, $post ) {
				// If this is just a revision, don't send the email.
				if ( wp_is_post_revision( $post_id ) ) {
					return;
				}

				$data = json_decode( file_get_contents( 'php://input' ), true );
				// error_log( print_r( $data, true ) );
				if ( ! empty( $data['meta']['gutenify_custom_css'] ) ) {
					$name = 'post-' . $post_id;
					if ( 'wp_template_parts' === $post->post_type ) {
						$name = 'part-' . $post_id;
					}
					if ( $this->create_styles_folder() ) {
						$this->create_styles_file( $name, gutenify_minimize_css_simple( $data['meta']['gutenify_custom_css'] ) );
					}
				}
			},
			10,
			2
		);
	}

	/**
	 * Disable gutenber on post type.
	 *
	 * @param boolean $is_enabled If editor is enabled.
	 * @param string  $post_type  Post type name.
	 * @return boolean
	 */
	public function disable_gutenberg( $is_enabled, $post_type ) {
		$skip_gutenburg = apply_filters( 'gutenify_skip_gutenburg_post_type', array() );
		if ( ! in_array( $post_type, $skip_gutenburg, true ) ) {
			$settings          = gutenify_settings();
			$active_post_types = ! empty( $settings['active_post_types'] ) ? $settings['active_post_types'] : array();
			if ( ! in_array( $post_type, $active_post_types, true ) ) {
				return false;
			}
		}
		return $is_enabled;
	}

	/**
	 * Post types to skip the options.
	 *
	 * @param array $post_types Post types.
	 * @return array
	 */
	public function skip_gutenburg_post_type( $post_types ) {
		$post_types = array_merge( $post_types, array( 'attachment', 'wp_template', 'wp_block', 'gutenify_template' ) );
		return $post_types;
	}

	public function create_styles_folder() {
		$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'gutenify/styles';
		if ( ! file_exists( $uploads_dir ) ) {
			wp_mkdir_p( $uploads_dir );
		}
		return true;
		// $fileLocation = $uploads_dir . '/myfile.txt';
		// $file         = fopen( $fileLocation, 'w' );
		// $content      = 'Your text here';
		// fwrite( $file, $content );
		// fclose( $file );
	}

	public function create_styles_file( $name, $content ) {
		$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'gutenify/styles';
		if ( file_exists( $uploads_dir ) ) {
			$fileLocation = $uploads_dir . '/style-' . $name . '.css';
			$file         = fopen( $fileLocation, 'w' );
			fwrite( $file, $content );
			fclose( $file );
		}
	}
}
new Gutenify_Actions();
