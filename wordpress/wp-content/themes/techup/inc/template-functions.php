<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @subpackage techup
 * @since 1.0 
 */

/*-----------------------------------------------------------------------------------------------------------------------------------*/

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function techup_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'techup_pingback_header' );

/*-----------------------------------------------------------------------------------------------------------------------------------*/

if ( ! function_exists( 'techup_fonts_url' ) ) :

	/**
	 * Register Google fonts for techup.
	 *
	 * @return string Google fonts URL for the theme.
	 * @since 1.0.0
	 */

    function techup_fonts_url() {

        $fonts_url = '';
        $font_families = array();

        /*
         * Translators: If there are characters in your language that are not supported
         * by Lora translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Open+Sans: on or off', 'techup' ) ) {
            $font_families[] = 'Open+Sans:400,600,700,800';
        }

        /*
         * Translators: If there are characters in your language that are not supported
         * by Poppins, translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'techup' ) ) {
            $font_families[] = 'Roboto:300,400,500,700,900';
        }   

        if( $font_families ) {
            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }

endif;

/*-----------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles for only admin
 *
 * @since 1.0.0
 */
function techup_scripts() {

    global $techup_theme_version;
    
	//Enque Styles
     wp_enqueue_style('techup', techup_fonts_url(), array(), null );
     wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '', 'all');
     wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '', 'all');
    wp_enqueue_style('owl-carousal', get_template_directory_uri() . '/assets/css/owl.carousel.css', array(), '', 'all');
     wp_enqueue_style('owl.theme.default', get_template_directory_uri() . '/assets/css/owl.theme.default.css', array(), '', 'all');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '', 'all');
     wp_enqueue_style('techup-sites-style', get_stylesheet_uri(), array(), esc_attr( $techup_theme_version ) );
     wp_enqueue_style('techup-tpstyle', get_template_directory_uri() . '/assets/css/techup-custom-style.css', array(), '', 'all');
     wp_enqueue_style('techup-woocommerce', get_template_directory_uri() . '/assets/css/techup-woocommerce.css', array(), '', 'all');
     wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '', 'all');
     wp_enqueue_style('techup-skin', get_template_directory_uri() . '/assets/css/skin-2.css', array(), '', 'all');

    
	//Enque Scripts
	 wp_enqueue_script('popper', get_template_directory_uri() . '/assets/js/popper.js', array('jquery'), true);
	 wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), true);
     wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/assets/js/owl.carousel.js', array(), '', true);
     wp_enqueue_script('jquery-magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.js', array(), '', true);
     wp_enqueue_script('techup-custom', get_template_directory_uri() . '/assets/js/custom.js', array(), '', true);
     wp_enqueue_script( 'techup-sites-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '', true );

      
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'techup_scripts' );


/*--------------------------------------------------------------------------------------------------------------------------------*/

if( ! function_exists( 'techup_select_categories_list' ) ) :

    /**
     * function to return category lists
     *
     * @return $techup_categories_list in array
     */
    
    function techup_select_categories_list() {

        $techup_get_categories = get_categories( array( 'hide_empty' => 0 ) );
        $techup_categories_list[''] = __( 'Select Category', 'techup' );

        foreach ( $techup_get_categories as $category ) {
            $techup_categories_list[esc_attr( $category->slug )] = esc_html( $category->cat_name );
        }
        
        return $techup_categories_list;
    }

endif;

/*--------------------------------------------------------------------------------------------------------------------------------*/


if ( ! function_exists( 'techup_single_post_navigation' ) ) :
/**
 * Displays an optional single post navigation
 *
 *
 * Create your own techup_post_navigation() function to override in a child theme.
 *
 * @since Create Magazine 1.0
 */
function techup_single_post_navigation() {

   

    the_post_navigation( array(
        'prev_text' => '<i class="fa fa-angle-left"></i>'.esc_html__( ' Previous Article','techup' ),
        'next_text' => esc_html__( 'Next Article','techup' ).' <i class="fa fa-angle-right"></i>'
    ) );
}
endif;



add_action( 'wp_enqueue_scripts', 'techup_theme_color' );
if( ! function_exists( 'techup_theme_color' ) ) :
  
    function techup_theme_color() { 
        $techup_theme_color = get_theme_mod( 'techup_theme_color', '#f10e00' );
        $output_css = '';

         $output_css .= ".team-slider-two.owl-theme .owl-nav [class*=owl-]:hover, .team-slider-two.owl-theme .owl-nav [class*=owl-]:focus,.post-meta li a:hover, .post-meta li a:focus,h5 a:hover, h6 a:hover, h5 a:focus, h6 a:focus, .widget_categories a:hover, .widget_archive a:hover, .widget_categories a:focus, .widget_archive a:focus,.widget_meta a:hover, .widget_meta a:focus,.foot-bottom a,.main-navigation a:hover,.widget_recent_entries a:hover, .widget_recent_entries a:focus,.widget_recent_comments .recentcomments a:hover, .widget_recent_comments .recentcomments a:focus,.widget_recent_entries .post-date,.blog-detail .post-meta li a, .logged-in-as a,.read-more:hover, .read-more:focus,.blog-detail .post-meta li i,.comment-meta a,.says,.sp-100 .pagination-blog .navigation .nav-links a,.post-tags a:hover, .post-tags a:focus , .btn-one:hover, .btn-one:focus,.widget_pages a:hover, .widget_pages a:focus,.hero-sec .caption h1,.main-menu ul ul.sub-menu a:hover,.navbar-expand-lg a:hover,.services-5 .icon-box i, .services-5 .icon-box h4 a:hover ,.widget_categories li:hover, .widget_archive li:hover, .widget_categories li a:focus, .widget_archive li a:focus, .testimonials-5 .testimonial-item i, .fibu h2, .fibu-port h5:hover.portfolio-5 .box-body:hover .box-title, .portfolio-5 .box-body:hover i, .busi-dark-banner .section-title-2,.busi-dark-feat .about-box i,.busi-dark-ser .serviceBox .service-icon, .busi-dark-co2 h2,  .educ-home .about-box i,.buco .feature-box .icon, .buco .feature-box .link-details, .section-heading .sm-title, .buco .our-team .post, .buco .our-team .post-title a:hover, .creativo-seo .readmore-btn:hover, .creativo-seo .feature-box .link-details, .creativo-service .link-box, .creativo-team .post, .creativo-blog .blog-item .entry-meta a:hover, .constech-feat .feature-box .icon-main i, .constech-service .section-heading > span, .constech-service .service-box .icon,.constech-service .service-box .link-details,.constech-port .section-heading > span.section-title, .constech-team .section-heading > span , .constech-team .post, .constech-blog .section-heading > span, .common-heading>span, .startup-team .our-team .post,.corporate-service .service-logo i, .corporate-testi .client-heading .icon, .corporate-team .our-team:hover .profile-title, .corporate-blog .post-body .post-meta-list > span,.corporate-blog .post-meta-list .meta-date-text, .post-meta-list .post-cat a,.corporate-blog .blog-btn, .corporate-service a:hover  {color:".esc_attr( $techup_theme_color )." !important;}"; 

         $output_css .= ".all-title .title-sep{ fill:".esc_attr( $techup_theme_color )."; }";
         $output_css .= ".fibu-ser .icon-box{ box-shadow: 5px 5px 0  ".esc_attr( $techup_theme_color )."99; }";  

        $output_css .= ".team-two:hover, .team-two:focus, .service-box:hover .service-content, .carousel-caption a, .blog-5 .btn-wraper .read-more-btn:hover, .corporate-service a:hover, .widget_tag_cloud .tagcloud a:hover, .widget_tag_cloud .tagcloud a:focus{ border-color:".esc_attr( $techup_theme_color )." !important; }";
        $output_css .= ".btn-two:before, .btn-two:after{ border-bottom:".esc_attr( $techup_theme_color ). " 25px solid ; !important;
border-top:".esc_attr( $techup_theme_color ). " 25px solid ; !important
          }";
        $output_css .= ".search-form input[type='submit'],.widget_tag_cloud .tagcloud a:hover, .widget_tag_cloud .tagcloud a:focus,.pagination .nav-links .page-numbers.current, .pagination .nav-links .page-numbers:hover{ border-color:".esc_attr( $techup_theme_color )."; }";
        $output_css .= ".title-line:before,.title-line:after { background: linear-gradient(to left,transparent,".esc_attr( $techup_theme_color ).") !important; }";
        $output_css .= ".fbusi .testimonial .testimonial-content:after{ border-top:10px solid ".esc_attr( $techup_theme_color )."; }"; 
		
        $output_css .= ".btn-dark,.service-box2:after,.feature-box::after,.class-box:hover h5:before, .class-box:hover h5:after, .class-box:focus h5:before, .class-box:focus h5:after,section.cta,.foot-title h4::after,.main-navigation .nav-menu>.menu-item-has-children > .sub-menu li a:before,.search-form input[type='submit'],.title-sep2::after,::-webkit-scrollbar-thumb,::-webkit-scrollbar-thumb:hover,.comment-respond .comment-reply-title::after,.comment-respond .form-submit input,.widget_tag_cloud .tagcloud a:hover, .widget_tag_cloud .tagcloud a:focus,.pagination .nav-links .page-numbers.current, .pagination .nav-links .page-numbers:hover,.reply:focus,.blog .blog-item:hover .date, .blog .blog-item:focus .date,.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span, .owl-theme .owl-dots .owl-dot:focus span, .service-box3col:after,.service-box4col:after, .service-box:hover .service-content, .project:hover .proj-content, .project:focus .proj-content,.header-three,.bg-theme, .btn-2, .cta-2, .carousel-indicators .active, .our-team .social_media_team,.service-box3 h5::after,.title-line > i,.main-menu ul ul.sub-menu a::before,.cta-4, .blog-5 .btn-wraper .read-more-btn:hover, .about .about-box:before, .tradebusi-port .box-content, .busi-dark-banner .btn-2:hover,.busi-dark-ser .serviceBox , .busi-dark-ser .service-content:before, .busi-dark-blog .btn-wraper .read-more-btn,.buco .btn-wraper .home-btn:hover,.educ-home .btn-wraper .home-btn:hover,.buco .btn-wraper .home-btn,.educ-home .btn-wraper .home-btn, .heading-divider .heading-seperator::before, .educ-home .btn, .cta-7 .buco .btn, .busi-corp, .creativo-seo .readmore-btn, .creativo-testi .client-pic i, .creativo-co, .btn-one, .constech-hero .content-sec .readmore-btn, .startup-features .feature-box .icon-main,.startup-service .service-icon, .corporate-co1 .btn:hover { background-color:".esc_attr( $techup_theme_color )." !important;}";

        $output_css .= "blockquote{ border-left:".esc_attr( $techup_theme_color )." 5px solid; }";
		$output_css .= ".corporate-service .service h4::before, .corporate-service .service h4::after{ background: linear-gradient(to right, ".esc_attr( $techup_theme_color ).", #fff);  }";
        $output_css .= ".sec-title:after, .sec-title:before,.carousel-control-prev-icon:before, .carousel-control-next-icon:before,.separator ul li, .testimonials-5 .testimonial-item, .fibu-ser .icon-box i, .fibu-ser .icon-box i:hover, .fbusi .testimonial .testimonial-content,.fbusi .our-team .team-content,.tradebusi .about-box i, .tradebusi-ser .service-icon, .tradebusi-ser .service-icon:before, .heading-divider .heading-seperator,.educ-home .service-box .icon-box, .educ-home .team-content, .educ-home .owl-nav [class*=owl-]:hover, .buco .feature-box:hover, .buco .service-box .icon-box,.buco .client-pic i, .buco .feature-box:hover .icon, .section-heading .bg-title:after, .creativo-seo .feature-box .icon, .creativo-seo .feature-box:hover .link-details, .creativo-service .service-box:hover .link-box, .creativo-blog .blog-item .post-cat a, .constech-service .service-box:after,.constech-testi .client-pic i, .constech-team .our-team:hover .pic-bottom, .constech-blog .blog-item .post-cat a, .startup-hero, .startup-port .portfolio-wrap::before, .startup-co2:before, .startup-blog .blog-item .post-cat a, .corporate-port .portfolio-wrap:hover::before{background:".esc_attr( $techup_theme_color )." !important; }";
		$output_css .= ".corporate-blog .blog-btn i{ border:".esc_attr( $techup_theme_color )." 2px solid; }";
		
		$output_css .= ".creativo-seo .readmore-btn, .creativo-seo .feature-box .link-details, .creativo-blog .blog-item .btn-details:hover{ border-color:".esc_attr( $techup_theme_color )." !important; }";
		
		$output_css .= ".heading-divider .heading-seperator::before{ box-shadow: 9px 0 0 0 ".esc_attr( $techup_theme_color ).", 18px 0 0 0 ".esc_attr( $techup_theme_color )." !important; }";	
		
       $techup_output_css = techup_css_strip_whitespace( $output_css );
        wp_add_inline_style( 'techup-sites-style', $techup_output_css );
    }
endif;




if( ! function_exists( 'techup_css_strip_whitespace' ) ) :
    
    /**
     * Get minified css and removed space
     *
     * @since 1.0.0
     */

    function techup_css_strip_whitespace( $css ){
        $replace = array(
            "#/\*.*?\*/#s" => "",  // Strip C style comments.
            "#\s\s+#"      => " ", // Strip excess whitespace.
        );
        $search = array_keys( $replace );
        $css = preg_replace( $search, $replace, $css );

        $replace = array(
            ": "  => ":",
            "; "  => ";",
            " {"  => "{",
            " }"  => "}",
            ", "  => ",",
            "{ "  => "{",
            ";}"  => "}", // Strip optional semicolons.
            ",\n" => ",", // Don't wrap multiple selectors.
            "\n}" => "}", // Don't wrap closing braces.
            "} "  => "}\n", // Put each rule on it's own line.
        );
        $search = array_keys( $replace );
        $css = str_replace( $search, $replace, $css );

        return trim( $css );
    }

endif;


if( ! function_exists( 'techup_select_page_list' ) ) :

    /**
     * function to return page lists
     *
     * @return $techup_page_list in array
     */
    
    function techup_select_page_list() {

        $techup_get_pages = get_pages();
        $techup_page_list[''] = __( 'Select Page', 'techup' );

        foreach ( $techup_get_pages as $page ) {
            $techup_page_list[esc_attr( $page->post_name )] = esc_html( $page->post_title );
        }
        
        return $techup_page_list;
    }

endif;