<?php
/**
 * techup manage the Customizer panels.
 *
 * @subpackage techup
 * @since 1.0 
 */

/**
 * General Settings Panel
 */
Kirki::add_panel( 'techup_general_panel', array(
	'priority' => 10,
	'title'    => __( 'General Settings', 'techup' ),
) );

/**
 * Header Settings Panel
 */
Kirki::add_panel( 'techup_header_panel', array(
	'priority' => 15,
	'title'    => __( 'Header Options', 'techup' ),
) );

/**
 * Frontpage Settings Panel
 */
Kirki::add_panel( 'techup_frontpage_panel', array(
	'priority' => 20,
	'title'    => __( 'Techup Front Page', 'techup' ),
) );

/**
 * Design Settings Panel
 */
Kirki::add_panel( 'techup_design_panel', array(
	'priority' => 25,
	'title'    => esc_html__( 'Design Settings', 'techup' ),
) );