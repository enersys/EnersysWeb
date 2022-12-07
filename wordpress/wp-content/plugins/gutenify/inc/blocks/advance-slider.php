<?php
/**
 * Registers the `gallery` block on server.
 */

function gutenify_render_advance_slider( $attributes, $content, $props ) {
	$has_navigation = ! empty( $attributes['blockAdvanceOptions']['hasNavigation'] ) && true === $attributes['blockAdvanceOptions']['hasNavigation'];
	$has_pagination = ! empty( $attributes['blockAdvanceOptions']['hasPagination'] ) && true === $attributes['blockAdvanceOptions']['hasPagination'];
	$has_autoplay = ! empty( $attributes['blockAdvanceOptions']['autoplay'] ) && true === $attributes['blockAdvanceOptions']['autoplay'] ? 1 : 0;

	$client_id   = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$class_name  = array();

	$layout = ! empty( $attributes['blockAdvanceOptions']['layout'] ) ? $attributes['blockAdvanceOptions']['layout'] : 'layout-1';
	array_push( $class_name, 'wp-block-gutenify-advance-slider', 'gutenify-advance-slider', 'gutenify-section-' . $attributes['blockClientId'], 'gutenify-section-' . $layout, 'gutenify-advance-slider-version-2', );

	if ( isset( $attributes['className'] ) ) {
		array_push( $class_name, $attributes['className'] );
	}

	if ( isset( $attributes['align'] ) ) {
		array_push( $class_name, 'align' . $attributes['align'] );
	}

	$class_name = apply_filters( 'gutenify--slider--wrapper-class', $class_name, $props );
	$block_content = sprintf(
		'<div class="%1$s">',
		esc_attr( implode( ' ', $class_name ) ),
	);

	$block_content .= '<div class="swiper-wrapper">';

	$block_content .= $content;
	$block_content .= '</div>';
	if ( $has_navigation ) {
		$block_content .= '<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>';
	}
	if ( $has_pagination ) {
		$block_content .= '<div class="swiper-pagination"></div>';
	}
	$block_content .= '</div>';

	$columns         = ! empty( $attributes['blockAdvanceOptions']['columns'] ) ? $attributes['blockAdvanceOptions']['columns'] : 1;
	$space_between   = ! empty( $attributes['blockAdvanceOptions']['spaceBetween'] ) ? $attributes['blockAdvanceOptions']['spaceBetween'] : 0;
	$block_client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : 1;
	ob_start();
	wp_enqueue_script( 'gutenify-swiper' );
	$config  = '{
		loop: true,
		speed: 800,
		slidesPerView: ' . $columns . ',
		autoplay: ' . ( $has_autoplay ? '{
			// delay: 5000,
			disableOnInteraction: false,
		  }' : 0 ) . ',
		  effect: "creative",

		  creativeEffect: {
			prev: {
			  // will set `translateZ(-400px)` on previous slides
			  translate: [0, 0, -500],
			},
			next: {
			  // will set `translateX(100%)` on next slides
			  translate: ["100%", 0, 0],
			},
		  },
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
	$block_content .= '<script>
	jQuery(function($){
			function ' . $slider_function_name . '() {
				var swiperWrapper = $(".gutenify-section-' . $block_client_id . ' .swiper-wrapper");
				var newSlides = swiperWrapper.children(".swiper-slide").clone(true);
				' . $slider_var . '.destroy();
				swiperWrapper.empty().append(newSlides);
				swiperWrapper.attr("style", "");
				mySwiper = new Swiper(".gutenify-section-' . $block_client_id . '", ' . $config . ');
			}

			var ' . $slider_var . ' = new Swiper(".gutenify-section-' . $block_client_id . '", ' . $config . ');
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
function gutenify_register_block_advance_slider() {
	$block_name  = 'advance-slider';
	$filename = 'gutenify-' . $block_name;
	$asset = include_once sprintf( '%sdist/' . $filename . '.asset.php', GUTENIFY_BASE_DIR );

	$handle = 'gutenify-' . $block_name;

	$asset['dependencies'][] = 'gutenify-components';
	$asset['dependencies'][] = 'gutenify-swiper';
	wp_register_script( $handle . '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.js', $asset['dependencies'], $asset['version'], false );

	$deps[] = 'gutenify-swiper-style';
	wp_register_style( $handle . '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.css', $deps, $asset['version'] );
	wp_register_style( $handle . '-frontend', GUTENIFY_BASE_URL . 'dist/' . 'style-' . $filename . '.css', array(), $asset['version'] );

	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type( GUTENIFY_BASE_DIR . 'dist/blocks/' . $block_name, array(
		'render_callback' => 'gutenify_render_advance_slider'
	));
}
add_action( 'init', 'gutenify_register_block_advance_slider' );
