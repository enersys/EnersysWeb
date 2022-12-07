<?php
/**
 * techup functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @subpackage techup
 * @since techup 1.0
 */

/**
 * techup only works in WordPress 4.7 or later.
 */

if ( ! function_exists( 'techup_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function techup_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on techup, use a find and replace
		 * to change 'techup' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'techup');
        
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in single locations.
		add_theme_support( 'nav-menus' );
		register_nav_menu('primary', esc_html__( 'Primary Menu', 'techup' ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add the custom background prperty
		add_theme_support( 'custom-background', apply_filters( 'techup_custom_background_args', array(
			'default-color' => '#000000',
			'default-image' => '',
		) ) );

		// Add supportive refresh widgets 
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Add default posts and comments RSS feed links 
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'techup_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function techup_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'techup_content_width', 640 );
}
add_action( 'after_setup_theme', 'techup_content_width', 0 );

/**
 * Set the theme version, based on theme stylesheet.
 *
 * @global string $techup_theme_version
 */
function techup_theme_version_info() {
	$techup_theme_info = wp_get_theme();
	$GLOBALS['techup_theme_version'] = $techup_theme_info->get( 'Version' );
}
add_action( 'after_setup_theme', 'techup_theme_version_info', 0 );

 

function techbit_change_excerpt( $text )
{
    $pos = strrpos( $text, '[');
    if ($pos === false)
    {
        return $text;
    }

    return rtrim (substr($text, 0, $pos) );
}
add_filter('get_the_excerpt', 'techbit_change_excerpt');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function techup_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'techup' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'techup' ),
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="title-sep2 mb-30">',
		'after_title'   => '</h4>',
	) );


	register_sidebar(array(
		'name' => esc_html__( 'Footer Widget Area', "techup"),
		'id' => 'footer-widget-area',
		'description' => esc_html__( 'The footer widget area', "techup"),
		'before_widget' => '<div class="%2$s footer-widget col-md-3 col-sm-6 col-xs-12">',
		'after_widget' => '</div>',
		'before_title' => '<div class="foot-title"><h4>',
		'after_title' => '</h4></div>',
	));

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
		array(
			'name'          => esc_html__( 'WooCommerce Sidebar', 'techup' ),
			'id'            => 'woocommerce-widgets',
			'description'   => esc_html__( 'Add widgets here.', 'techup' ),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s clearfix">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title-sep2 mb-30">',
			'after_title'   => '</h4>',
		));
	}	
}
add_action( 'widgets_init', 'techup_widgets_init' );

add_action( 'admin_init', 'techup_detect_button' );
	function techup_detect_button() {
	wp_enqueue_style( 'techup-button', get_template_directory_uri() . '/assets/css/notice-button.css' );
}
 

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * File to manage the custom body classes
 */
require get_template_directory() . '/inc/template-css-class.php';
/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Add feature in Customizer  
 */
require get_template_directory() . '/inc/customizer/cv-customizer.php';


/**
 * Custom Hooks defined 
 */
require get_template_directory() . '/inc/custom-hooks/cv-custom-hooks.php';
require get_template_directory() . '/inc/custom-hooks/footer-hooks.php';
require get_template_directory() . '/inc/custom-hooks/header-hooks.php';



/**
 * Breadcrumbs files added 
 */

	require get_template_directory() . '/inc/breadcrumbs.php';
 
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package techup
 */

/**
 * Header fearures expanded 
 */
function techup_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'techup_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/assets/images/header.jpg',
		'default-text-color'     => '000',
		'width'                  => 1920,
		'height'                 => 850,
		'flex-height'            => true,
		'wp-head-callback'       => 'techup_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'techup_custom_header_setup' );

if ( ! function_exists( 'techup_header_style' ) ) :

	function techup_header_style() {
		$header_text_color = get_header_textcolor();

		?>
		<style type="text/css">
			<?php
				//Check if user has defined any header image.
				if ( get_header_image() ) :
			?>
			.page-banner
			  {
				background-image:url('<?php header_image(); ?>');
			  }
		
			.site-title,.site-description
			 {
			color: #<?php echo esc_attr($header_text_color); ?>;
			
			  }

			<?php endif; ?>	
		</style>
		<?php
	}
endif;	

 

/**
 * Customizer additional settings.
 */
require_once( trailingslashit( get_template_directory() ) . '/inc/custom-addition/class-customize.php' );

/**
 * plugin Recommendations.
 */
require_once  get_template_directory()  . '/inc/tgm/class-tgm-plugin-activation.php';
require get_template_directory(). '/inc/tgm/hook-tgm.php';


function techup_comparepage_css($hook) {
  if ( 'appearance_page_techup-info' != $hook ) {
    return;
  }
  wp_enqueue_style( 'techup-custom-style', get_template_directory_uri() . '/assets/css/compare.css' );
}
add_action( 'admin_enqueue_scripts', 'techup_comparepage_css' );

/**
 * Compare page content
 */

add_action('admin_menu', 'techup_themepage');
function techup_themepage(){
  $theme_info = add_theme_page( __('Techup Details','techup'), __('Techup Details','techup'), 'manage_options', 'techup-info.php', 'techup_info_page' );
}

function techup_info_page() {
  $user = wp_get_current_user();
  ?>
  <div class="wrap about-wrap one-pageily-add-css">
    <div>
      <h1>
        <?php echo __('Welcome to Techup!','techup'); ?>
      </h1>

      <div class="feature-section three-col">
		<div class="col">
          <div class="widgets-holder-wrap">
            <h3><?php echo __("Documentation", "techup" ); ?></h3>
            <p><?php echo __("Getting started with a new theme can be difficult, But its installation and customization is so easy", "techup" ); ?></p>
            <p><a target="blank" href="<?php echo esc_url('http://testerwp.com/docs/techup-theme-doc/', 'techup'); ?>" class="button button-primary">
              <?php echo __("Read Documentation", "techup" ); ?>
            </a></p>
          </div>
        </div>
        <div class="col">
          <div class="widgets-holder-wrap">
            <h3><?php echo __("Recommended Plugins", "techup" ); ?></h3>
            <p><?php echo __("Please install recommended plugins for better use of theme. It will help you to make website more useful", "techup" ); ?></p>
            <p><a target="blank" href="<?php echo esc_url(admin_url('/themes.php?page=tgmpa-install-plugins&plugin_status=activate'), 'techup'); ?>" class="button button-primary">
              <?php echo __("Install Plugins", "techup" ); ?>
            </a></p>
          </div>
        </div>
        <div class="col">
          <div class="widgets-holder-wrap">
            <h3><?php echo __("Free Theme Demo", "techup" ); ?></h3>
            <p><?php echo __("You can check free theme demo before setup your website if you like demo then install theme", "techup" ); ?></p>
            <p><a target="blank" href="<?php echo esc_url('http://testerwp.com/demo/techup/', 'techup'); ?>" class="button button-primary">
              <?php echo __("Free Theme Demo", "techup" ); ?>
            </a></p>
          </div>
        </div>
         
      </div>
	  
	  <h2><?php echo __("Free Vs Premium","techup" ); ?></h2>
    <div class="one-pageily-button-container">
      <a target="blank" href="<?php echo esc_url('https://testerwp.com/lp/logitech-preview/', 'techup'); ?>" class="button button-primary">
        <?php echo __("Premium Theme Demo", "techup" ); ?>
      </a>
      <a target="blank" href="<?php echo esc_url('https://testerwp.com/product/logitech/', 'techup'); ?>" class="button button-primary">
        <?php echo __("Buy Now", "techup" ); ?>
      </a>
    </div>


    <table class="wp-list-table widefat">
      <thead>
        <tr>
          <th><strong><?php echo __("Theme Feature", "techup" ); ?></strong></th>
          <th><strong><?php echo __("Basic Version", "techup" ); ?></strong></th>
          <th><strong><?php echo __("Premium Version", "techup" ); ?></strong></th>
        </tr>
      </thead>

      <tbody>
		  <tr>
          <td><?php echo __("Import Demo Content", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          </tr>	
		  <tr>
          <td><?php echo __("Responsive Design", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
			</tr>
			<tr>
          <td><?php echo __("Unlimited Color Option", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
			</tr>
			<tr>
          <td><?php echo __("Header Customization", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          </tr>
		  <tr>
          <td><?php echo __("Footer Customization", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          </tr>
		  <tr>
          <td><?php echo __("Unlimited post/Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          </tr>
			<tr>
          <td><?php echo __("Mulitple Header Layout", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Multiple Home Page", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Page Builder", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Coming Soon Page", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Multiple Blog Layout", "techup" ); ?></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>


        <tr>
          <td><?php echo __("Premium Support", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Portfolio Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Multiple Google Fonts", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Team Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("404 Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Service Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Premium Widgets", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Multiple Footer", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Shortcodes", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Multiple Sidebar", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Multiple Page Layout", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("SEO Friendly", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Slider", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Footer Featured Cusomization", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Contact Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Customize Footer Colors", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Mega Menu", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr> 
        <tr>
          <td><?php echo __("Pricing Page", "techup" ); ?></td>
          <td><span class="cross"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "techup" ); ?>" /></span></td>
          <td><span class="checkmark"><img src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "techup" ); ?>" /></span></td>
        </tr>
        

      </tbody>
    </table>
    <div class="one-pageily-button-container">
      <a target="blank" href="<?php echo esc_url('https://testerwp.com/lp/logitech-preview/', 'techup'); ?>" class="button button-primary">
        <?php echo __("GO PREMIUM", "techup" ); ?>
      </a>
    </div>
	  
    </div>
    <hr>
 
  </div>
  <?php
}