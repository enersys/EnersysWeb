<?php
/**
 * The style file for the WP Carousel.
 *
 * @since    3.0.0
 * @package WP Carousel
 * @subpackage wp-carousel-free/public
 */

$section_title_dynamic_css = '';
$section_title             = isset( $shortcode_data['section_title'] ) ? $shortcode_data['section_title'] : '';
$carousel_type             = isset( $upload_data['wpcp_carousel_type'] ) ? $upload_data['wpcp_carousel_type'] : '';
$wpcp_arrows               = isset( $shortcode_data['wpcp_navigation'] ) ? $shortcode_data['wpcp_navigation'] : 'show';
$wpcp_dots                 = isset( $shortcode_data['wpcp_pagination'] ) ? $shortcode_data['wpcp_pagination'] : '';

if ( $section_title ) {
	$old_section_title_margin   = isset( $shortcode_data['section_title_margin_bottom'] ) && is_numeric( $shortcode_data['section_title_margin_bottom'] ) ? $shortcode_data['section_title_margin_bottom'] : '30';
	$section_title_margin       = isset( $shortcode_data['section_title_margin_bottom']['all'] ) && ! empty( $shortcode_data['section_title_margin_bottom']['all'] ) && ( $shortcode_data['section_title_margin_bottom']['all'] >= 0 ) ? $shortcode_data['section_title_margin_bottom']['all'] : $old_section_title_margin;
	$section_title_dynamic_css .= '
    .wpcp-wrapper-' . $post_id . ' .sp-wpcpro-section-title, .postbox .wpcp-wrapper-' . $post_id . ' .sp-wpcpro-section-title, #poststuff .wpcp-wrapper-' . $post_id . ' .sp-wpcpro-section-title {
        margin-bottom: ' . $section_title_margin . 'px;
    }';
}

$slide_border           = isset( $shortcode_data['wpcp_slide_border'] ) ? $shortcode_data['wpcp_slide_border'] : '';
$old_slide_border_width = isset( $slide_border['width'] ) && ! empty( $slide_border['width'] ) ? $slide_border['width'] : '0';
$slide_border_width     = isset( $shortcode_data['wpcp_slide_border']['all'] ) && ! empty( $shortcode_data['wpcp_slide_border']['all'] ) ? $shortcode_data['wpcp_slide_border']['all'] : $old_slide_border_width;
$slide_border_style     = isset( $slide_border['style'] ) ? $slide_border['style'] : 'none';
$slide_border_color     = isset( $slide_border['color'] ) ? $slide_border['color'] : '';

// Product Image Border.
$image_border_width = isset( $shortcode_data['wpcp_product_image_border']['all'] ) && ! empty( $shortcode_data['wpcp_product_image_border']['all'] ) ? $shortcode_data['wpcp_product_image_border']['all'] : $old_slide_border_width;
$image_border_style = isset( $shortcode_data['wpcp_product_image_border']['style'] ) ? $shortcode_data['wpcp_product_image_border']['style'] : '1';
$image_border_color = isset( $shortcode_data['wpcp_product_image_border']['color'] ) ? $shortcode_data['wpcp_product_image_border']['color'] : '#ddd';


if ( 'product-carousel' === $carousel_type ) {
	$wpcp_product_css = '#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . '.wpcp-product-carousel .wpcp-slide-image {
		border: ' . $image_border_width . 'px ' . $image_border_style . ' ' . $image_border_color . ';
	}';
} else {
	$wpcp_product_css = '#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .wpcp-single-item {
		border: ' . $slide_border_width . 'px ' . $slide_border_style . ' ' . $slide_border_color . ';
	}';
}

// Nav Style.
$nav_dynamic_style = '';
if ( 'hide' !== $wpcp_arrows ) {
	$wpcp_nav_color       = isset( $shortcode_data['wpcp_nav_colors']['color1'] ) ? $shortcode_data['wpcp_nav_colors']['color1'] : '#aaa';
	$wpcp_nav_hover_color = isset( $shortcode_data['wpcp_nav_colors']['color2'] ) ? $shortcode_data['wpcp_nav_colors']['color2'] : '#fff';
	$nav_dynamic_style   .= '
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-prev,
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-next,
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-prev:hover,
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-next:hover {
		background: none;
		border: none;
		font-size: 30px;
	}
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-prev i,
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-next i {
		color: ' . $wpcp_nav_color . ';
	}
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-prev i:hover,
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .swiper-button-next i:hover {
		color: ' . $wpcp_nav_hover_color . ';
	}';
}

$pagination_dynamic_style = '';
if ( 'hide' !== $wpcp_dots ) {
	$wpcp_dot_color           = isset( $shortcode_data['wpcp_pagination_color']['color1'] ) ? $shortcode_data['wpcp_pagination_color']['color1'] : '#ccc';
	$wpcp_dot_active_color    = isset( $shortcode_data['wpcp_pagination_color']['color2'] ) ? $shortcode_data['wpcp_pagination_color']['color2'] : '#52b3d9';
	$pagination_dynamic_style = '
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .wpcp-swiper-dots .swiper-pagination-bullet {
		background-color: ' . $wpcp_dot_color . ';
	}
	#sp-wp-carousel-free-id-' . $post_id . '.sp-wpcp-' . $post_id . ' .wpcp-swiper-dots .swiper-pagination-bullet.swiper-pagination-bullet-active {
		background-color: ' . $wpcp_dot_active_color . ';
	}
	';
}
if ( 'hide_mobile' === $wpcp_dots ) {
	$the_wpcf_dynamic_css .= '
	@media screen and (max-width: 479px) {
		#sp-wp-carousel-free-id-' . $post_id . '.nav-vertical-center .wpcp-next-button,#sp-wp-carousel-free-id-' . $post_id . ' .wpcp-swiper-dots {
			display: none;
		}
	}';
}

/**
 * The Dynamic Style CSS.
 */

$the_wpcf_dynamic_css .= $wpcp_product_css;
$the_wpcf_dynamic_css .= $section_title_dynamic_css;
$the_wpcf_dynamic_css .= $nav_dynamic_style;
$the_wpcf_dynamic_css .= $pagination_dynamic_style;
if ( 'post-carousel' === $carousel_type ) {
	$the_wpcf_dynamic_css .= '
	.wpcp-carousel-wrapper #sp-wp-carousel-free-id-' . $post_id . '.wpcp-post-carousel .wpcp-single-item {
		background: ' . ( isset( $shortcode_data['wpcp_slide_background'] ) ? $shortcode_data['wpcp_slide_background'] : '#f9f9f9' ) . ';
	}';
}
if ( 'hide' === $wpcp_arrows ) {
	$the_wpcf_dynamic_css .= '
		#sp-wp-carousel-free-id-' . $post_id . '.nav-vertical-center {
			padding: 0;
			margin:0;
	}';
}
if ( 'hide_mobile' === $wpcp_arrows ) {
	$the_wpcf_dynamic_css .= '
	@media screen and (max-width: 479px) {
		#sp-wp-carousel-free-id-' . $post_id . '.nav-vertical-center {
			padding: 0;
			margin:0;
		}
		#sp-wp-carousel-free-id-' . $post_id . '.nav-vertical-center .wpcp-next-button,#sp-wp-carousel-free-id-' . $post_id . '.nav-vertical-center .wpcp-prev-button {
			display: none;
		}
	}';
}
$item_gap              = isset( $shortcode_data['wpcp_slide_margin'] ) ? $shortcode_data['wpcp_slide_margin'] : array(
	'top'   => '20',
	'right' => '20',
);
$the_wpcf_dynamic_css .= '#sp-wp-carousel-free-id-' . $post_id . ' .wpcpro-row>[class*="wpcpro-col-"] {
    padding: 0 ' . (int) $item_gap['top'] / 2 . 'px;
    padding-bottom: ' . $item_gap['right'] . 'px;
}';

