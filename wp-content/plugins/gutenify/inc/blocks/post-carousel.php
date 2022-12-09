<?php
/**
 * Server-side rendering of the `posts` block.
 *
 * @package WordPress
 */

/**
 * Renders the block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content.
 */
function gutenify_render_post_carousel_block( $attributes, $content, $props ) {

	global $post;
	$args = array(
		'posts_per_page'   => ! empty( $attributes['query']['numberOfItems'] ) ? $attributes['query']['numberOfItems'] : 10,
		'post_status'      => 'publish',
		'order'            => ! empty( $attributes['query']['order'] ) ? $attributes['query']['order'] : 'desc',
		'orderby'          => ! empty( $attributes['query']['orderBy'] ) ? $attributes['query']['orderBy'] : 'date',
		'suppress_filters' => false,
		'post__not_in'     => array( $post->ID ),
		'category__in'     => array(),
	);

	if ( isset( $attributes['query']['selectedCategories'] ) ) {

		$args['category__in'] = array_column( $attributes['query']['selectedCategories'], 'id' );

	}

	if ( ! empty( $attributes['query']['tax']['category'] ) ) {

		$args['category__in'] = array_merge( $attributes['query']['tax']['category'], $args['category__in'] );

	}

	if ( ! empty( $attributes['query']['tax']['tag'] ) ) {
		$args['tag__in'] = $attributes['query']['tax']['tag'];
	}

	if ( ! empty( $attributes['query']['tax']['post_tag'] ) ) {
		$args['tag__in'] = $attributes['query']['tax']['post_tag'];
	}

	if ( ! empty( $attributes['query']['authorIds'] ) ) {
		$args['author__in'] = $attributes['query']['authorIds'];
	}

	if ( ! empty( $attributes['query']['postTypes'] ) && in_array( 'attachment', $attributes['query']['postTypes'] ) ) {
		$args['post_status'] = 'inherit';

	}

	$recent_posts    = get_posts( $args );
	$formatted_posts = gutenify_get_post_info( $recent_posts );

	$block_style = null;

	if ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-horizontal' ) !== false ) {

		$block_style = 'horizontal';

	} elseif ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-stacked' ) !== false ) {

		$block_style = 'stacked';

	}

	return gutenify_posts( $formatted_posts, $attributes, $props );
}


/**
 * Renders the list and grid styles.
 *
 * @param array $posts Current posts.
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content for the list and grid styles.
 */
function gutenify_posts( $posts, $attributes, $props ) {
	$client_id   = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$class_name  = array( 'wp-block-gutenify-post-carousel', 'gutenify-section-' . $attributes['blockClientId'], 'gutenify-post-carousel-' . $attributes['layout'], 'gutenify-post-carousel-version-2' );
	$class       = array( 'swiper-container', 'gutenify-post-carousel' );
	$styles      = array();
	$block_style = ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-stacked' ) !== false ? 'stacked' : 'horizontal';

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

	$class_name = apply_filters( 'gutenify--post-carousel--wrapper-class', $class_name, $props );
	$class_name = apply_filters( 'gutenify_block_wrapper_class', esc_attr( implode( ' ', $class_name ) ), $attributes );

	$block_content = sprintf(
		'<div class="%1$s"><div class="gutenify-post-carousel-section" id="gutenify-section-' . $client_id . '"><div class="%2$s" style="%3$s"><div class="swiper-wrapper">',
		$class_name,
		esc_attr( implode( ' ', apply_filters( 'gutenify_render_wrapper_class', $class, $attributes ) ) ),
		esc_attr( implode( ' ', apply_filters( 'gutenify_render_wrapper_styles', $styles, $attributes ) ) )
	);

	$list_items_markup = '';

	foreach ( $posts as $post ) {

		$list_class       = '';
		$align_self_class = '';

		$list_items_markup .= '<div class="gutenify-post-carousel-item gutenify-post-carousel-item-wrapper swiper-slide">';
		$list_items_markup .= '<div class="gutenify-post-carousel-item-inner-wrapper">';

		if ( ! empty( $attributes['displayFeaturedImage'] ) && null !== $post['thumbnailURL'] && $post['thumbnailURL'] ) {

			$list_items_markup .= sprintf(
				'<div class="gutenify-post-carousel-thumb">
				<a class="image-hover-zoom" href="%1$s">
				 	 <img src="%2$s" />
				 </a>
			</div>',
				esc_url( $post['postLink'] ),
				esc_url( $post['thumbnailURL'] )
			);

			if ( 'horizontal' === $block_style && ( isset( $attributes['displayPostContent'] ) && ! $attributes['displayPostContent'] ) && ( isset( $attributes['columns'] ) && 2 >= $attributes['columns'] ) ) {

				$align_self_class = 'self-center';
			}
		} else {
			$align_self_class = ' flex-start';
		}

		$list_items_markup .= sprintf(
			'<div class="gutenify-post-carousel-text-content %s">',
			esc_attr( $align_self_class )
		);

		if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] && 'stacked' === $block_style ) {

			$list_items_markup .= sprintf(
				'<time datetime="%1$s" class="wp-block-gutenify-posts__date">%2$s</time>',
				esc_url( $post['date'] ),
				esc_html( $post['dateReadable'] )
			);

		}

		$title = $post['title'];

		if ( ! $title ) {

			$title = _x( '(no title)', 'placeholder when a post has no title', 'gutenify' );

		}

		$list_items_markup .= sprintf(
			'<h3 class="gutenify-post-carousel-title"><a href="%1$s" rel="bookmark">%2$s</a></h3> ',
			$post['postLink'],
			$title
		);
		$meta_data          = '';
		if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] && 'horizontal' === $block_style ) {
			$meta_data .= sprintf(
				'<span class="posted-on"><time datetime="%1$s" class="gutenify-posts-date">%2$s</time></span>',
				esc_html( $post['date'] ),
				esc_html( $post['dateReadable'] )
			);

		}
		if ( ! empty( $attributes['displayPostAuthor'] ) ) {
			if ( ! get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) {
				$meta_data .= '<span class="byline">';
				$meta_data .= sprintf(
					'%s',
					'<a href="' . esc_url( get_author_posts_url( $post['author_id'] ) ) . '" rel="author">' . esc_html( get_the_author_meta( 'display_name', $post['author_id'] ) ) . '</a>'
				);
				$meta_data .= '</span>';
			}
		}

		if ( ! empty( $attributes['displayPostCategories'] ) ) {
			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ' ), '', $post['ID'] );
			if ( $categories_list ) {
				$meta_data .= sprintf(
					'<span class="cat-links">%s </span>',
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
				);
			}
		}

		if ( ! empty( $meta_data ) ) {
			$list_items_markup .= sprintf( '<div class="gutenify-post-carousel-meta">%1$s</div>', $meta_data );
		}

		if ( isset( $attributes['displayPostContent'] ) && $attributes['displayPostContent'] ) {

			$post_excerpt       = $post['postExcerpt'];
			$trimmed_excerpt    = esc_html( wp_trim_words( $post_excerpt, $attributes['excerptLength'], ' &hellip; ' ) );
			$list_items_markup .= '<div class="entry-summary">';
			$list_items_markup .= sprintf(
				'<p>%1$s</p>',
				esc_html( $trimmed_excerpt )
			);

			if ( isset( $attributes['displayPostLink'] ) && $attributes['displayPostLink'] ) {

				$list_items_markup .= sprintf(
					'<a href="%1$s" class="more-link"><span class="more-button">%2$s<span class="screen-reader-text">%3$s</span></span></a>',
					esc_url( $post['postLink'] ),
					esc_html( $attributes['postLink'] ),
					esc_html( $post['title'] )
				);

			}

			$list_items_markup .= '</div>';
		}

		$list_items_markup .= '</div></div></div>';

	}

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
	$space_between   = ! empty( $attributes['spaceBetween'] ) ? $attributes['spaceBetween'] : 10;
	$block_client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : 1;
	ob_start();
	wp_enqueue_script( 'gutenify-swiper' );
	$config = '{
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
			  slidesPerView: 2,
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
	}';
	$slider_var           = 'slider_' . str_replace( '-', '_', $block_client_id );
	$slider_function_name = 'reinitSlider' . $slider_var;
	wp_add_inline_script(
		'gutenify-swiper',
		'var ' . $slider_var . ' = new Swiper("#gutenify-section-' . $block_client_id . ' .swiper-container", ' . $config . ');
		console.log( ' . $config . ' );
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
				var swiperWrapper = $("' . $block_client_id . ' .swiper-wrapper");
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
 * Returns the posts for an internal posts.
 *
 * @param array $posts Current posts.
 *
 * @return array Returns posts.
 */
function gutenify_get_post_info( $posts ) {

	$formatted_posts = array();

	foreach ( $posts as $post ) {

		$formatted_post = null;

		$formatted_post['thumbnailURL'] = get_the_post_thumbnail_url( $post );
		$formatted_post['date']         = esc_attr( get_the_date( 'c', $post ) );
		$formatted_post['dateReadable'] = esc_html( get_the_date( '', $post ) );
		$formatted_post['title']        = get_the_title( $post );
		$formatted_post['postLink']     = esc_url( get_permalink( $post ) );
		$formatted_post['ID']           = absint( $post->ID );
		$formatted_post['author_id']    = absint( $post->post_author );

		$post_excerpt = $post->post_excerpt;

		if ( ! ( $post_excerpt ) ) {

			$post_excerpt = $post->post_content;

		}

		$formatted_post['postExcerpt'] = $post_excerpt;

		$formatted_posts[] = $formatted_post;

	}

	return $formatted_posts;

}

/**
 * Registers the `posts` block on server.
 */
function gutenify_register_post_carousel_block() {
	$block_name = 'post-carousel';
	$filename = 'gutenify-' . $block_name;
	$asset = include_once sprintf( '%sdist/' .$filename . '.asset.php', GUTENIFY_BASE_DIR );

	$asset['dependencies'][] = 'gutenify-editor';

	$handle = $filename;
	wp_register_script( $handle . '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.js', $asset['dependencies'], $asset['version'], false );
	wp_register_style( $handle. '-editor', GUTENIFY_BASE_URL . 'dist/' . $filename . '.css', array(), $asset['version'] );
	wp_register_style( $handle . '-frontend', GUTENIFY_BASE_URL . 'dist/' . 'style-' . $filename . '.css', array(), $asset['version'] );

	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	register_block_type( GUTENIFY_BASE_DIR . 'dist/blocks/' . $block_name, array(
		'render_callback' => 'gutenify_render_post_carousel_block'
	));
}
add_action( 'init', 'gutenify_register_post_carousel_block' );
