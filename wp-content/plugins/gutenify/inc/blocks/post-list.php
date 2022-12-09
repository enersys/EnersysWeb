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
function gutenify_render_post_list_block( $attributes ) {
	global $post;
	$args = array(
		'posts_per_page'   => ! empty( $attributes['query']['numberOfItems'] ) ? $attributes['query']['numberOfItems'] : 10,
		'post_status'      => 'publish',
		'order'            => ! empty( $attributes['query']['order'] ) ? $attributes['query']['order'] : 'desc',
		'orderby'          => ! empty( $attributes['query']['orderBy'] ) ? $attributes['query']['orderBy'] : 'date',
		'suppress_filters' => false,
		'post__not_in'     => array( $post->ID ),
		'post_type'        => ! empty( $attributes['query']['postTypes'] ) ? (array) $attributes['query']['postTypes'] : 'post',
		'category__in'     => array(),
	);
	if ( ! empty( $attributes['query']['selectedCategories'] ) ) {

		$args['category__in'] = array_column( $attributes['query']['selectedCategories'], 'id' );

	}

	if ( ! empty( $attributes['query']['tax']['category'] ) ) {

		$args['category__in'] = array_merge( $attributes['query']['tax']['category'], $args['category__in'] );

	}

	if ( ! empty( $attributes['query']['tax']['tag'] ) ) {
		$args['tag__in'] = $attributes['query']['tax']['tag'];
	}

	if ( ! empty( $attributes['query']['authorIds'] ) ) {
		$args['author__in'] = $attributes['query']['authorIds'];
	}

	if ( ! empty( $attributes['query']['postTypes'] ) && in_array( 'attachment', $attributes['query']['postTypes'] ) ) {
		$args['post_status'] = 'inherit';

	}
	$recent_posts = get_posts( $args );

	$formatted_posts = gutenify_get_post_info( $recent_posts );

	$block_style = null;

	if ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-horizontal' ) !== false ) {

		$block_style = 'horizontal';

	} elseif ( isset( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-stacked' ) !== false ) {

		$block_style = 'stacked';

	}

	return gutenify_post_list( $formatted_posts, $attributes );
}


/**
 * Renders the list and grid styles.
 *
 * @param array $posts Current posts.
 * @param array $attributes The block attributes.
 *
 * @return string Returns the block content for the list and grid styles.
 */
function gutenify_post_list( $posts, $attributes ) {
	$client_id   = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$list_layout = ! empty( $attributes['blockAdvanceOptions']['postListLayout'] ) ? $attributes['blockAdvanceOptions']['postListLayout'] : 'layout-1';
	$class_name  = array( 'wp-block-gutenify-post-list', 'gutenify-section-' . $attributes['blockClientId'], 'gutenify-post-list-' . $attributes['layout'], 'gutenify--post-list--post-list-' . $list_layout, 'gutenify-post-list-version-2' );
	$class       = array( 'gutenify-post-list' );
	$styles      = array();
	$block_style = ! empty( $attributes['className'] ) && strpos( $attributes['className'], 'is-style-stacked' ) !== false ? 'stacked' : 'horizontal';
	$columns     = ! empty( $attributes['columns'] ) ? $attributes['columns'] : 1;

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

	if ( isset( $columns ) ) {
		array_push( $class_name, 'gutenify-post-list-col-' . $columns );
	}

	$class_name = apply_filters( 'gutenify_block_wrapper_class', esc_attr( implode( ' ', $class_name ) ), $attributes );

	$block_content = sprintf(
		'<div class="%1$s">',
		$class_name,
	);

	$list_items_markup = '';

	foreach ( $posts as $post ) {

		$list_class       = '';
		$align_self_class = '';

		$list_items_markup .= '<div class="gutenify-post-list-item gutenify-post-list-item-wrapper inner-block-shadow">';
		$list_items_markup .= '<div class="gutenify-post-list-item-inner-wrapper">';

		if ( ! empty( $attributes['displayFeaturedImage'] ) && null !== $post['thumbnailURL'] && $post['thumbnailURL'] ) {

			$list_items_markup .= sprintf(
				'<div class="gutenify-post-list-thumb">
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
			'<div class="gutenify-post-list-text-content %s">',
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
			'<h3 class="gutenify-post-list-title"><a href="%1$s" rel="bookmark">%2$s</a></h3> ',
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
			$list_items_markup .= sprintf( '<div class="gutenify-post-list-meta">%1$s</div>', $meta_data );
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
	// $block_content .= '</div>';
	$block_content .= '</div>';
	ob_start();
	echo $block_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	$output = ob_get_contents();
	ob_end_clean();
	return $output;

}

/**
 * Registers the `posts` block on server.
 */
function gutenify_register_post_list_block() {
	$block_name  = 'post-list';
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
			'render_callback' => 'gutenify_render_post_list_block',
		)
	);
}
add_action( 'init', 'gutenify_register_post_list_block' );
