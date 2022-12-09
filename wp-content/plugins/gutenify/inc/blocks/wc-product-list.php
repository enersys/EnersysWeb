<?php

/**
 * Server-side rendering of the `posts` block.
 *
 * @package WordPress
 */

function gutenify_wc_get_add_to_cart( $product ) {
	$attributes = array(
		'aria-label'       => $product->add_to_cart_description(),
		'data-quantity'    => '1',
		'data-product_id'  => $product->get_id(),
		'data-product_sku' => $product->get_sku(),
		'rel'              => 'nofollow',
		'class'            => 'wp-block-button__link add_to_cart_button',
	);

	if (
		$product->supports( 'ajax_add_to_cart' ) &&
		$product->is_purchasable() &&
		( $product->is_in_stock() || $product->backorders_allowed() )
	) {
		$attributes['class'] .= ' ajax_add_to_cart';
	}

	return sprintf(
		'<a href="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		wc_implode_html_attributes( $attributes ),
		esc_html( $product->add_to_cart_text() )
	);
}

function gutenify_render_wc_product_list_block( $attributes ) {
	if ( ! class_exists( 'woocommerce' ) ) {
		return '';
	}
	$query = $attributes['query'];
	$args  = array(
		'post_status' => 'publish',
		'post_type' => 'product',
	);

	if ( ! empty( $query['numberOfItems'] ) ) {
		$args['posts_per_page'] = $query['numberOfItems'];
	}
	if ( ! empty( $query['orderBy'] ) ) {
		$args['orderby'] = $query['orderBy'];
	}
	if ( ! empty( $query['order'] ) ) {
		$args['order'] = strtoupper( $query['order'] );
	}


	if ( ! empty( $query['tax']['product_cat'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $query['tax']['product_cat'],
		);
	}
	if ( ! empty( $query['tax']['product_tag'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_tag',
			'field'    => 'id',
			'terms'    => $query['tax']['product_tag'],
		);
	}
	$posts = new WP_Query( $args );

	ob_start();
	if ( $posts->have_posts() ) {
		$wrapper_class = array(
			'gutenify-section-' . $attributes['blockClientId'],
			'wp-block-gutenify-wc-product-list',
			'gutenify--wc-product-list-' . $attributes['layout'],
			'gutenify--wc-product-list-col-' . $attributes['columns'],
			'gutenify-wc-product-list-version-2',
		);
		if ( isset( $attributes['className'] ) ) {
			array_push( $wrapper_class, $attributes['className'] );
		}
		echo sprintf( '<div class="%s">', implode( ' ', $wrapper_class ) );
		while( $posts->have_posts() ) {
			$posts->the_post();
			$product = wc_get_product( get_the_ID() );
			$permalink = get_the_permalink( $product->get_id() );
			echo '<div class="gutenify--wc-product--item has-no-hover-shadow-dark">';
			echo '<div class="gutenify--wc-product--item-wrapper">';


			echo '<div class="gutenify--wc-product--thumb">';
			echo '<a class="image-zoom-hover" href="' . $permalink . '" tabindex="-1">';
			echo woocommerce_get_product_thumbnail();
			echo '</a>'; // Product thumb link
			echo $product->is_on_sale() ? '<div class="gutenify--wc-product--onsale"><span aria-hidden="true">Sale</span><span class="screen-reader-text">Product on sale</span></div>' : '';

			echo '</div>'; // Product thumb
			echo '<div class="gutenify--wc-product--item-content">';

			echo '<h3 class="gutenify--wc-product--title">';
			echo '<a rel="bookmark" href="' . $permalink . '" tabindex="-1">';
			echo $product->get_name();
			echo '</a>'; // Product title link
			echo '</h3>'; // Product title

			echo '<div class="gutenify--wc-product--price">';
			echo $product->get_price_html();
			echo '</div>'; // Product price

			echo '<div class="wp-block-button wc-block-grid__product-add-to-cart">';
			echo gutenify_wc_get_add_to_cart( $product );
			// var_dump( $product );
			echo '</div>'; // Product add to cart wrapper
			echo '</div>'; // Product individual wrapper
			echo '</div>'; // Product individual wrapper
			echo '</div>'; // Product individual wrapper
		}
		echo '</div>'; // Product lists wrapper
		wp_reset_postdata();
	}
	// $products = wc_get_products( $args );
	// var_dump( $query );
	// var_dump( $args );
	// var_dump( $products );



	$result = ob_get_clean();
	return $result;
}

/**
 * Registers the `posts` block on server.
 */
function gutenify_register_wc_product_list_block() {
	$block_name  = 'wc-product-list';
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
			'render_callback' => 'gutenify_render_wc_product_list_block',
		)
	);
}
add_action( 'init', 'gutenify_register_wc_product_list_block' );
