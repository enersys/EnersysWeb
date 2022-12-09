<?php
/**
 * Server-side rendering of the `posts` block.
 *
 * @package WordPress
 */

/**
 * Renders the block on server.
 *
 * @param array  $attributes The block attributes.
 * @param string $content    Block Content.
 *
 * @return string Returns the block content.
 */
function gutenify_render_slider_block( $attributes, $content, $props ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
	return gutenify_slider( $attributes, $content, $props );
}


/**
 * Renders the list and grid styles.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content for the list and grid styles.
 */
function gutenify_slider( $attributes, $content, $props ) {
	$client_id   = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$class_name  = array();
	$class       = array( 'swiper-container', 'gutenify-slider' );
	$styles      = array();
	$block_style = ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-stacked' ) !== false ? 'stacked' : 'horizontal';

	$layout = ! empty( $attributes['blockAdvanceOptions']['layout'] ) ? $attributes['blockAdvanceOptions']['layout'] : 'layout-1';
	array_push( $class_name, 'wp-block-gutenify-slider', 'gutenify-section-' . $attributes['blockClientId'], 'gutenify-section-' . $layout );

	if ( isset( $attributes['className'] ) ) {
		array_push( $class_name, $attributes['className'] );
	}

	if ( isset( $attributes['align'] ) ) {
		array_push( $class_name, 'align' . $attributes['align'] );
	}

	if ( isset( $attributes['columns'] ) ) {
		array_push( $class, 'has-columns has-' . $attributes['columns'] . '-columns has-responsive-columns' );
	}

	if ( isset( $attributes['listPosition'] ) && 'right' === $attributes['listPosition'] && 'horizontal' === $block_style ) {
		array_push( $class, 'has-image-right' );
	}

	if ( isset( $attributes['imageSize'] ) && 'horizontal' === $block_style ) {
		array_push( $class, 'has-' . $attributes['imageSize'] . '-image' );
	}

	if ( isset( $attributes['imageStyle'] ) ) {
		array_push( $class, 'has-' . $attributes['imageStyle'] . '-image' );
	}

	$class_name = apply_filters( 'gutenify--slider--wrapper-class', $class_name, $props );
	$block_content = sprintf(
		'<div class="%1$s"><div id="gutenify-section-' . $client_id . '" class="gutenify-slider-section"><div class="%2$s" style="%3$s"><div class="swiper-wrapper">',
		esc_attr( implode( ' ', $class_name ) ),
		esc_attr( implode( ' ', apply_filters( 'gutenify_render_wrapper_class', $class, $attributes ) ) ),
		esc_attr( implode( ' ', apply_filters( 'gutenify_render_wrapper_styles', $styles, $attributes ) ) )
	);

	$list_items_markup = '';

	$list_items_markup = $content;

	$block_content .= $list_items_markup;
	$block_content .= '</div>';
	$has_navigation = ! empty( $attributes['hasNavigation'] ) && true === $attributes['hasNavigation'];
	$has_pagination = ! empty( $attributes['hasPagination'] ) && true === $attributes['hasPagination'];
	if ( $has_navigation ) {
		$block_content .= '<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>';
	}
	if ( $has_pagination ) {
		$block_content .= '<div class="swiper-pagination"></div>';
	}
	$block_content .= '</div>';
	$block_content .= '</div>';
	$block_content .= '</div>';

	$columns         = ! empty( $attributes['columns'] ) ? $attributes['columns'] : 1;
	$space_between   = ! empty( $attributes['spaceBetween'] ) ? $attributes['spaceBetween'] : 0;
	$block_client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : 1;
	ob_start();
	wp_enqueue_script( 'gutenify-swiper' );
	$config  = '{
		loop: true,
		slidesPerView: ' . $columns . ',
		breakpoints: {
			// when window width is >= 320px
			320: {
			  slidesPerView: 1,
			  spaceBetween: 20
			},
			// when window width is >= 640px
			640: {
			  slidesPerView: 1,
			  spaceBetween: 15
			},
			1024: {
				slidesPerView: ' . $columns . ',
				spaceBetween: ' . $space_between . '
			  }
		  },';
	$config .= ' spaceBetween:' . $space_between . ',';
	if ( $has_navigation ) {
		$config .= ' navigation:{
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	      },';
	}
	$config              .= '
		pagination:{
			el: ".swiper-pagination",
			clickable: true,
		      },
	';
	$config              .= '
		scrollbar:{ draggable: true },
		on: {
			init: function () {
				jQuery(document).trigger("gutenifySlideinit" );
			},
		      },
	}';
	$slider_var           = 'slider_' . str_replace( '-', '_', $block_client_id );
	$slider_function_name = 'reinitSlider' . $slider_var;
	wp_add_inline_script(
		'gutenify-swiper',
		'var ' . $slider_var . ' = new Swiper("#gutenify-section-' . $block_client_id . ' .swiper-container", ' . $config . ');
		jQuery(function($){
			$(document).on("containerStretched", function(){
				var swiperWrapper = $("' . $block_client_id . ' .swiper-wrapper");
				var newSlides = swiperWrapper.children(".swiper-slide").clone(true);
				' . $slider_var . '.destroy();
				swiperWrapper.empty().append(newSlides);
				swiperWrapper.attr("style", "");
				mySwiper = new Swiper("#gutenify-section-' . $block_client_id . ' .swiper-container", ' . $config . ');
			});
		});'
	);
	$block_content .= '<script>
	jQuery(function($){
			function ' . $slider_function_name . '() {
				var swiperWrapper = $("#gutenify-section-' . $block_client_id . ' .swiper-wrapper");
				var newSlides = swiperWrapper.children(".swiper-slide").clone(true);
				' . $slider_var . '.destroy();
				swiperWrapper.empty().append(newSlides);
				swiperWrapper.attr("style", "");
				mySwiper = new Swiper("#gutenify-section-' . $block_client_id . ' .swiper-container", ' . $config . ');
			}

			var ' . $slider_var . ' = new Swiper("#gutenify-section-' . $block_client_id . ' .swiper-container", ' . $config . ');
			$(window).on("resize", function(){
				' . $slider_function_name . '();
			});
			' . $slider_var . '.on("slideChangeTransitionEnd", function (a,b) {
				jQuery(document).trigger("gutenifySlideChangeTransitionEnd" );
			      });
			' . $slider_var . '.on("slideChangeTransitionStart", function (a,b) {
			jQuery(document).trigger("gutenifySlideChangeTransitionStart" );
			});
			$(document).on("containerStretched", function(){
				' . $slider_function_name . '();
			});
		});</script>';
	echo $block_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	$output = ob_get_contents();
	ob_end_clean();
	return $output;

}

/**
 * Registers the `gallery` block on server.
 */
function gutenify_register_slider_block() {
	$block_name  = 'slider';
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
			'render_callback' => 'gutenify_render_slider_block',
		)
	);
}
add_action( 'init', 'gutenify_register_slider_block' );
