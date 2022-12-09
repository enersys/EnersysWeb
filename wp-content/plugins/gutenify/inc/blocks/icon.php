<?php
function gutenify_register_block_icon() {
	$block_name  = 'icon';
	$filename = 'gutenify-' . $block_name;
	$asset = include_once sprintf( '%sdist/' . $filename . '.asset.php', GUTENIFY_BASE_DIR );

	$handle = $filename;
	wp_register_script( $handle . '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.js', $asset['dependencies'], $asset['version'], false );

	$deps[] = 'gutenify-fontawesome-style';
	if ( wp_style_is( 'gutenify-line-awesome', 'registered' ) ) {
		$deps[] = 'gutenify-line-awesome';
	}

	wp_register_style( $handle. '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.css', $deps, $asset['version'] );
	wp_register_style( $handle . '-frontend', GUTENIFY_BASE_URL . 'dist/' . 'style-' . $filename . '.css', $deps, $asset['version'] );

	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type( GUTENIFY_BASE_DIR . 'dist/blocks/' . $block_name );
}
add_action( 'init', 'gutenify_register_block_icon' );
