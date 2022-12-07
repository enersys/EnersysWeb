<?php
/**
 * techup manage the Customizer options of general panel.
 *
 * @subpackage techup
 * @since 1.0 
 */
Kirki::add_field(
	'techup_config', array(
		'type'        => 'checkbox',
		'settings'    => 'techup_home_posts',
		'label'       => esc_attr__( 'Checked to hide latest posts in homepage.', 'techup' ),
		'section'     => 'static_front_page',
		'default'     => true,
	)
);

// Color Picker field for Primary Color
Kirki::add_field( 
	'techup_config', array(
		'type'        => 'color',
		'settings'    => 'techup_theme_color',
		'label'       => esc_html__( 'Primary Color', 'techup' ),
		'section'     => 'colors',
		'default'     => '#f10e00',
	)
);