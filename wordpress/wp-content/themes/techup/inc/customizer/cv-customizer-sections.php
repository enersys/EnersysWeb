<?php
/**
 * techup manage the Customizer sections.
 *
 * @subpackage techup
 * @since 1.0 
 */

/**
 * Site Settings
 */
Kirki::add_section( 'techup_section_site', array(
	'title'    => __( 'Site Settings', 'techup' ),
	'panel'    => 'techup_general_panel',
	'priority' => 40,
) );

/**
 * Hero Section
 */
Kirki::add_section( 'techup_section_banner_content', array(
	'title'    => __( 'Home Banner Settings', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 5,
) );
 
/**
 * Services Section
 */
Kirki::add_section( 'techup_section_services', array(
	'title'    => __( 'Home Service Settings', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 9,
) );

/**
 * Features Section
 */
Kirki::add_section( 'techup_section_features', array(
	'title'    => __( 'Home Features Settings', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 7,
) );

/**
 * Portfolio Section
 */
Kirki::add_section( 'techup_section_portfolio', array(
	'title'    => __( 'Home Portfolio Settings', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 13,
) );


/**
 * Team Section
 */
Kirki::add_section( 'techup_section_team', array(
	'title'    => __( 'Home Team Section', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 19,
) );

 
/**
 * Blog Section
 */
Kirki::add_section( 'techup_section_blog', array(
	'title'    => __( 'Home Blog Setting', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 45,
) );

/**
 * Callout 1 Section
 */
Kirki::add_section( 'techup_section_callout_content1', array(
	'title'    => __( 'Home Callout 1 Setting', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 11,
) );


/**
 * Callout 2 Section
 */
Kirki::add_section( 'techup_section_callout_content', array(
	'title'    => __( 'Home Callout 2 Setting', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 15,
) );

/**
 * Testimonial Section
 */
Kirki::add_section( 'techup_section_testimonial', array(
	'title'    => __( 'Home Testimonial Setting', 'techup' ),
	'panel'    => 'techup_frontpage_panel',
	'priority' => 17,
) );
/**
 * Footer Settings
 */
Kirki::add_section( 'techup_footer_setting', array(
	'title'    => __( 'Footer Settings', 'techup' ),
	'priority' => 40,
) );