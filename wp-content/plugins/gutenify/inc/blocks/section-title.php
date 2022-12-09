<?php
/**
 *
 * @package WordPress
 */

/**
 *
 * @param array $attributes Block attributes.
 *
 * @return string Returns the filtered post title for the current post wrapped inside "h1" tags.
 */
function gutenify_render_block_section_title( $attributes ) {
	$align_class_name = empty( $attributes['textAlignment'] ) ? '' : "has-text-align-{$attributes['textAlignment']}";

	$prefix_level = ! empty( $attributes['prefixTag'] ) ? $attributes['prefixTag'] : 'h4';

	$prefix_css_classes = ! empty( $attributes['blockAdvanceOptions']['prefixTitleClasses'] ) ? $attributes['blockAdvanceOptions']['prefixTitleClasses'] : '';
	$prefix_css_classes = $prefix_css_classes . ' gutenify-section-title-prefix';
	$wrapper_attributes = '';
	if ( ! empty( $attributes['prefixColor'] ) ) {
		$wrapper_attributes = 'style="color:' . $attributes['prefixColor'] . '"';
	}
	$wrapper_attributes .= 'class="' . $prefix_css_classes . '"';
	$prefix_content      = ! empty( $attributes['prefixContent'] ) ? $attributes['prefixContent'] : '';

	$prefix = sprintf(
		'<%1$s %2$s>%3$s</%1$s>',
		$prefix_level,
		$wrapper_attributes,
		$prefix_content
	);

	// Heading.
	$title_level      = ! empty( $attributes['titleTag'] ) ? $attributes['titleTag'] : 'h2';
	$main_css_classes = ! empty( $attributes['blockAdvanceOptions']['mainTitleClasses'] ) ? $attributes['blockAdvanceOptions']['mainTitleClasses'] : '';
	$main_css_classes = $main_css_classes . ' gutenify-section-title-main';

	$wrapper_attributes = '';
	if ( ! empty( $attributes['titleColor'] ) ) {
		$wrapper_attributes = 'style="color:' . $attributes['titleColor'] . '"';
	}
	$wrapper_attributes .= 'class="' . $main_css_classes . '"';
	$title_content       = ! empty( $attributes['titleContent'] ) ? $attributes['titleContent'] : '';

	$title = sprintf(
		'<%1$s %2$s>%3$s</%1$s>',
		$title_level,
		$wrapper_attributes,
		$title_content
	);

	// Suffix.
	$suffix_level       = ! empty( $attributes['suffixTag'] ) ? $attributes['suffixTag'] : 'p';
	$suffix_css_classes = ! empty( $attributes['blockAdvanceOptions']['suffixTitleClasses'] ) ? $attributes['blockAdvanceOptions']['suffixTitleClasses'] : '';
	$suffix_css_classes = $suffix_css_classes . ' gutenify-section-title-suffix';

	$wrapper_attributes = '';
	if ( ! empty( $attributes['suffixColor'] ) ) {
		$wrapper_attributes = 'style="color:' . $attributes['suffixColor'] . '"';
	}
	$wrapper_attributes .= 'class="' . $suffix_css_classes . '"';
	$suffix_content      = ! empty( $attributes['suffixContent'] ) ? $attributes['suffixContent'] : '';

	$suffix          = sprintf(
		'<%1$s %2$s>%3$s</%1$s>',
		$suffix_level,
		$wrapper_attributes,
		$suffix_content
	);
	$block_client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : 1;

	$class_name = array( 'wp-block-gutenify-section-title', 'gutenify-section-' . $block_client_id, 'gutenify-section-title-version-2' );
	if ( isset( $attributes['className'] ) ) {
		array_push( $class_name, $attributes['className'] );
	}
	if ( $align_class_name ) {
		array_push( $class_name, $align_class_name );
	}

	$class_name = apply_filters( 'gutenify_block_wrapper_class', esc_attr( implode( ' ', $class_name ) ), $attributes );

	$output  = '<div class="' . $class_name . '">';
	$output .= '<div id="gutenify-section-' . $block_client_id . '" class="gutenify-section-title-section ">';
	if ( ! empty( $attributes['displayPrefix'] ) ) {
		$output .= $prefix;
	}
	$output .= $title;
	if ( ! empty( $attributes['displaySuffix'] ) ) {
		$output .= $suffix;
	}
	$output .= '</div>';
	$output .= '</div>';
	return $output;
}

/**
 * Registers the block on the server.
 */
function gutenify_register_block_section_title() {
	$block_name  = 'section-title';
	$filename = 'gutenify-' . $block_name;
	$asset = include_once sprintf( '%sdist/' . $filename . '.asset.php', GUTENIFY_BASE_DIR );

	$handle = $filename;
	wp_register_script( $handle . '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.js', $asset['dependencies'], $asset['version'], false );
	wp_register_style( $handle . '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.css', array(), $asset['version'] );
	wp_register_style( $handle . '-frontend', GUTENIFY_BASE_URL . 'dist/' . 'style-' . $filename . '.css', array(), $asset['version'] );

	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type(
		GUTENIFY_BASE_DIR . 'dist/blocks/' . $block_name,
		array(
			'render_callback' => 'gutenify_render_block_section_title',
		)
	);
}
add_action( 'init', 'gutenify_register_block_section_title' );
