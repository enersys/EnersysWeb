<?php
function gutenify_after_content_import_setup() {
	// Set static homepage.
	$homepage = get_page_by_title( apply_filters( 'gutenify_content_home_page_title', 'Home' ) );

	if ( $homepage ) {
		update_option( 'page_on_front', $homepage->ID );
		update_option( 'show_on_front', 'page' );
	}

	// Set static blog page.
	$blogpage = get_page_by_title( apply_filters( 'gutenify_content_blog_page_title', 'Blog' ) );

	if ( $blogpage ) {
		update_option( 'page_for_posts', $blogpage->ID );
		update_option( 'show_on_front', 'page' );
	}
}
add_action( 'import_end', 'gutenify_after_content_import_setup' );
