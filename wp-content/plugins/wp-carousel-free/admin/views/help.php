<?php
/**
 * The help page for the WP Carousel
 *
 * @package WP Carousel
 * @subpackage wp-carousel-free/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access.

/**
 * The help class for the WP Carousel
 */
class WP_Carousel_Free_Help {

	/**
	 * Wp Carousel Pro single instance of the class
	 *
	 * @var null
	 * @since 2.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main WP_Carousel_Free_Help Instance
	 *
	 * @since 2.0.0
	 * @static
	 * @see sp_wpcp_help()
	 * @return self Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Add admin menu.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function help_admin_menu() {
		add_submenu_page(
			'edit.php?post_type=sp_wp_carousel',
			__( 'WP Carousel Help', 'wp-carousel-free' ),
			__( 'Help', 'wp-carousel-free' ),
			'manage_options',
			'wpcf_help',
			array(
				$this,
				'help_page_callback',
			)
		);
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		wp_enqueue_style( 'sp-wpcp-admin-help', WPCAROUSELF_URL . 'admin/css/help-page.min.css', array(), WPCAROUSELF_VERSION );
		$add_new_carousel_link = admin_url( 'post-new.php?post_type=sp_wp_carousel' );
		?>

		<div class="sp-wp-carousel-help-page">
		<!-- Header section start -->
		<section class="sp-wpc__help header">
			<div class="header-area">
				<div class="container">
					<div class="header-logo">
						<img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/wpcp-logo.svg'; ?>" alt="">
						<span><?php echo esc_attr( WPCAROUSELF_VERSION ); ?></span>
					</div>
					<div class="header-content">
						<p>Thank you for installing WP Carousel plugin! This video will help you get started with the plugin.</p>
					</div>
				</div>
			</div>
			<div class="video-area">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUb-7uG-5jO_zo3exhqUNlZ7h0FQVJTt" frameborder="0" allowfullscreen=""></iframe>
			</div>
			<div class="content-area">
				<div class="container">
					<div class="content-button">
						<a href="<?php echo esc_url( $add_new_carousel_link ); ?>">Start Creating Carousel</a>
						<a href="https://docs.shapedplugin.com/docs/wordpress-carousel/introduction/?ref=1" target="_blank">Read Documentation</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Header section end -->

		<!-- Upgrade section start -->
		<section class="sp-wpc__help upgrade">
			<div class="upgrade-area">
				<div class="upgrade-img">
				<img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/wpcp-Icon.svg'; ?>" alt="">
				</div>
				<h2>Upgrade To Unleash the Power of WP Carousel Pro</h2>
				<p>Get the most out of WP Carousel by upgrading to unlock all of its powerful features. With WP Carousel Pro, you can unlock amazing features like:</p>
			</div>
			<div class="upgrade-info">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<ul class="upgrade-list">
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Fully responsive, SEO-friendly & optimized.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">6 Beautiful layout presets (Carousel, Tiles, Masonry, Grid, Justified, Thumbnails Slider).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Advanced Shortcode Generator.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Slide Anything (e.g. Image, Post, Product, Content, Video, Text, HTML, Shortcodes, etc.)</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Display posts from multiple Categories, Tags, Formats, or Types. (e.g. Latest, Taxonomies, Specific, etc.).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Multiple Carousels on the same page.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">100+ Visual Customization options.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Drag & Drop Carousel builder (image, content, video, etc.).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Image Carousel with internal and external links.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Image Carousel with caption and description.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Image Content Position (Bottom, Top, Right, and Overlay).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Show/hide image caption and description.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Slide background, border, and inner padding.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Lightbox functionality for images.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Modern effects for images (grayscale, zoom, fade).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Custom image resizes options.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Variable width option in the carousel.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Post Carousel with Title, image, excerpt, read more, category, date, author, tags, comments, etc.).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Post excerpt, full content, and content with the limit.</li>
							</ul>
						</div>
						<div class="col-lg-6">
							<ul class="upgrade-list">
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">WooCommerce Product Carousel.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Product content position (Bottom, Top, Right, Overlay)Filter by different product types (e.g. latest, categories, specific products, etc.).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Show/hide the standard product contents (product name, image, price, excerpt, read more, rating, add to cart, etc.).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Content Carousel (Anything).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Video Carousel with lightbox.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Supported YouTube, Vimeo, Dailymotion, mp4, WebM, and even self-hosted video.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Add Custom Video Thumbnails (for self-hosted) and video icon.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Carousel Mode (standard, center, ticker).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">25+ Carousel controls.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">8+ Different navigation positions.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Typography & Styling options (840+ Google fonts).</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Duplicate or clone carousels.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Advanced plugin settings.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Multisite, RTL, and Accessibility ready.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Fully Translation ready with WPML, Polylang, Loco Translate, and more.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Page builders & theme compatibility.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Automatic Updates notifications.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">One To One Fast & Friendly Support</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt="">Developer friendly & highly customizable.</li>
								<li><img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/checkmark.svg'; ?>" alt=""><span>Not Happy? 100% No Questions Asked <a href="https://shapedplugin.com/refund-policy/" target="_blank">Refund Policy!</a></span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="upgrade-pro">
					<div class="pro-content">
						<div class="pro-icon">
							<img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/wp-carousel-pro.svg'; ?>" alt="">
						</div>
						<div class="pro-text">
							<h2>Upgrade To WP Carousel Pro Today!</h2>
							<p>Start creating beautiful WordPress Carousels, Sliders, Galleries in minutes.</p>
						</div>
					</div>
					<div class="pro-btn">
						<a href="https://shapedplugin.com/wp-carousel/pricing/?ref=1" target="_blank">Upgrade To Pro Now</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Upgrade section end -->

		<!-- Testimonial section start -->
		<section class="sp-wpc__help testimonial">
			<div class="row">
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>I’ve tried 3 other Gallery / Carousel plugins and this one is by far the easiest, lightweight and does exactly what I want! I had a minor glitch and support was very quick to fix it. Very happy and highly recommend this! Thank you!</p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/Joyce-van-den-Berg.png'; ?>" alt="">
							</div>
							<div class="info">
								<h3>Joyce van den Berg</h3>
								<div class="star">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>A wonderful WordPress Carousel plugin. This plugin is fantastic. It’s simple to use and very effective. It’s by far the best of the options out there. Also I’ve found the support to be excellent. Highly recommended !!</p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_url( WPCAROUSELF_URL ) . 'admin/img/images/Graeme-Myburgh.jpeg'; ?>" alt="">
							</div>
							<div class="info">
								<h3>Graeme Myburgh</h3>
								<div class="star">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Testimonial section end -->

	</div>
		<?php
	}
}
