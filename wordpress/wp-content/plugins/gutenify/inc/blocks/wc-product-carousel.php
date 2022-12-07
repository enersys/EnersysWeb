<?php
/**
 * Server-side rendering of the `posts` block.
 *
 * @package WordPress
 */

function gutenify_render_wc_product_carousel_block( $attributes, $content, $props ) {
	if ( ! class_exists( 'woocommerce' ) ) {
		return '';
	}
	$query = $attributes['query'];
	$args  = array(
		'post_status' => 'publish',
		'post_type'   => 'product',
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
	$has_navigation = ! empty( $attributes['hasNavigation'] ) && true === $attributes['hasNavigation'];
	$has_pagination = ! empty( $attributes['hasPagination'] ) && true === $attributes['hasPagination'];

	ob_start();
	if ( $posts->have_posts() ) {
		$wrapper_class = array(
			'gutenify-section-' . $attributes['blockClientId'],
			'wp-block-gutenify-wc-product-carousel',
			'gutenify--wc-product-carousel-' . $attributes['layout'],
			'gutenify--wc-product-carousel-col-' . $attributes['columns'],
			'gutenify-wc-product-carousel-version-2',
			'swiper-container'
		);
		if ( isset( $attributes['className'] ) ) {
			array_push( $wrapper_class, $attributes['className'] );
		}
		$wrapper_class = apply_filters( 'gutenify--slider--wrapper-class', $wrapper_class, $props );
		echo sprintf( '<div class="%s">', implode( ' ', $wrapper_class ) );
		// echo '<div class="swiper-container">';
		echo '<div class="swiper-wrapper">';
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$product   = wc_get_product( get_the_ID() );
			$permalink = get_the_permalink( $product->get_id() );
			echo '<div class="gutenify--wc-product--item swiper-slide">';
			echo '<div class="gutenify--wc-product--item-wrapper">';

			echo '<div class="gutenify--wc-product--thumb">';
			echo '<a class="image-hover-zoom" href="' . $permalink . '" tabindex="-1">';
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
			echo '</div>'; // .gutenify--wc-product--item-content

			echo '</div>'; // Product individual wrapper
			echo '</div>'; // Product individual wrapper
		}

		echo '</div>'; // .swiper-wrapper
		if ( $has_navigation ) {
			echo '<div class="swiper-button-next"></div>';
			echo '<div class="swiper-button-prev"></div>';
		}
		if ( $has_pagination ) {
			echo '<div class="swiper-pagination"></div>';
		}
		// echo '</div>'; // .swiper-container
		echo '</div>'; // Product carousels wrapper
		wp_reset_postdata();
	}
	wp_enqueue_script( 'gutenify-swiper' );

	$columns       = ! empty( $attributes['columns'] ) ? $attributes['columns'] : 1;
	$space_between = ! empty( $attributes['spaceBetween'] ) ? $attributes['spaceBetween'] : 0;
	// $swiper_config = array(
	// 	'loop'          => true,
	// 	'slidesPerView' => $columns,
	// 	'spaceBetween'  => $space_between,
	// 	'breakpoints'   => array(
	// 		'320'  => array(
	// 			'slidesPerView' => 1,
	// 			'spaceBetween'  => 20,
	// 		),
	// 		// when window width is >= 640px
	// 		'640'  => array(
	// 			'slidesPerView' => 2,
	// 			'spaceBetween'  => 15,
	// 		),
	// 	),
	// 	'scrollbar'     => array( 'draggable' => true ),
	// );

	// if ( $has_navigation ) {
	// 	$swiper_config['navigation'] = array(
	// 		'nextEl' => '.swiper-button-next',
	// 		'prevEl' => '.swiper-button-prev',
	// 	);
	// }

	// if ( $has_pagination ) {
	// 	$swiper_config['pagination'] = array(
	// 		'el'        => '.swiper-pagination',
	// 		'clickable' => true,
	// 	);
	// }

	$block_client_id      = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : 1;
	$slider_var           = 'slider_' . str_replace( '-', '_', $block_client_id );
	$slider_function_name = 'reinitSlider_' . $slider_var;
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
	?>
	<script>
		jQuery(function($){
			var sliderConfig =  <?php echo $config; ?>;
			function <?php echo $slider_function_name; ?>() {
				var swiperWrapper = $(".gutenify-section-<?php echo $block_client_id; ?>.swiper-container");
				var newSlides = swiperWrapper.children(".swiper-slide").clone(true);
				' . $slider_var . '.destroy();
				swiperWrapper.empty().append(newSlides);
				swiperWrapper.attr("style", "");
				mySwiper = new Swiper(".gutenify-section-<?php echo $block_client_id; ?>.swiper-container", sliderConfig);
			}

			var <?php echo $slider_var; ?> = new Swiper(".gutenify-section-<?php echo $block_client_id; ?>.swiper-container", sliderConfig);
			$(window).on("resize", function(){
				<?php echo $slider_function_name; ?>();
			});
			$(document).on("containerStretched", function(){
				<?php echo $slider_function_name; ?>();
			});
		});
	</script>
	<?php
	$result = ob_get_clean();
	return $result;
}

/**
 * Registers the `posts` block on server.
 */
function gutenify_register_wc_product_carousel_block() {
	$block_name  = 'wc-product-carousel';
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
			'render_callback' => 'gutenify_render_wc_product_carousel_block',
		)
	);
}
add_action( 'init', 'gutenify_register_wc_product_carousel_block' );
