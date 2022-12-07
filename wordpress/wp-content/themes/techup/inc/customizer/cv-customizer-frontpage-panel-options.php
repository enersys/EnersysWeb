<?php
/**
 * techup manage the Customizer options of frontpage panel.
 *
 * @subpackage techup
 * @since 1.0 
 */

// Toggle field for Enable/Disable banner content
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_banner_section',
		'label'    => __( 'Enable Home Page Banner', 'techup' ),
		'section'  => 'techup_section_banner_content',
		'default'  => '1',
		'priority' => 5,
	)
);
Kirki::add_field(
	'techup_config', array(
		'type'        => 'image',
		'settings'    => 'techup_banner_image',
		'label'       => esc_attr__( 'Home Banner Image', 'techup' ),
		'section'     => 'techup_section_banner_content',
		'default'     => esc_url(  get_template_directory_uri() . '/assets/images/banner.jpg' ),
		'priority' 	  => 10,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_banner_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for banner title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_banner_title',
		'label'    => __( 'Banner Title', 'techup' ),
		'section'  => 'techup_section_banner_content',
        'default'  => '',
		'priority' => 15,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_banner_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Textarea field for banner content
Kirki::add_field(
	'techup_config', array(
		'type'     => 'textarea',
		'settings' => 'techup_banner_content',
		'label'    => __( 'Banner Text', 'techup' ),
		'section'  => 'techup_section_banner_content',
        'default'  => '',
		'priority' => 20,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_banner_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for banner content button label
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_banner_button_label1',
		'label'    => __( 'Banner Button Text', 'techup' ),
		'section'  => 'techup_section_banner_content',
		'default'  => '',
		'priority' => 25,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_banner_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Link field for banner content button link
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_banner_button_link1',
		'label'    => __( 'Banner Button URL', 'techup' ),
		'section'  => 'techup_section_banner_content',
		'default'  => '',
		'priority' => 30,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_banner_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);
 
// Toggle field for Enable/Disable Service Section
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_service_section',
		'label'    => __( 'Enable Home Service Area', 'techup' ),
		'section'  => 'techup_section_services',
		'default'  => '0',
		'priority' => 5,
	)
);

// Text field for Service section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_service_title',
		'label'    => __( 'Service Title', 'techup' ),
		'section'  => 'techup_section_services',
		'default'  => '',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_service_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for Service section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_service_subtitle',
		'label'    => __( 'Service Sub Title', 'techup' ),
		'section'  => 'techup_section_services',
		'default'  => '',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_service_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

for($i=1;$i<=6;$i++){
	Kirki::add_field(
	'techup_config', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'techup_service_page '.$i,
		'label'       => 'Select Service Page '.$i,
		'section'     => 'techup_section_services',
		'default'     => 0,
		'priority'    => '7',
		
	)
);

	Kirki::add_field(
	'techup_config', array(
		'type'        => 'text',
		'settings'    => 'techup_service_icon '.$i,
		'label'       => 'Select Service Icon '.$i,
		'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">Click Here</a> for select icon','techup'),
		'section'     => 'techup_section_services',
		'default'     => 'fa fa-user',
		'priority'    => '7',
		
	)
);
}

// Toggle field for Enable/Disable Features Section
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_features_section',
		'label'    => __( 'Enable Home Features Area', 'techup' ),
		'section'  => 'techup_section_features',
		'default'  => '0',
		'priority' => 5,
	)
);

for($i=1;$i<=3;$i++){
	Kirki::add_field(
	'techup_config', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'techup_features_page '.$i,
		'label'       => 'Select Features Page '.$i,
		'section'     => 'techup_section_features',
		'default'     => 0,
		'priority'    => '7',
		
	)
);

	Kirki::add_field(
	'techup_config', array(
		'type'        => 'text',
		'settings'    => 'techup_features_icon '.$i,
		'label'       => 'Select Features Icon '.$i,
		'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">Click Here</a> for select icon','techup'),
		'section'     => 'techup_section_features',
		'default'     => 'fa fa-user',
		'priority'    => '7',
		
	)
);
}

// Toggle field for Enable/Disable Portfolio Section
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_portfolio_section',
		'label'    => __( 'Enable Home Portfolio Area', 'techup' ),
		'section'  => 'techup_section_portfolio',
		'default'  => '0',
		'priority' => 5,
	)
);

// Text field for Service section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_portfolio_title',
		'label'    => __( 'Portfolio Title', 'techup' ),
		'section'  => 'techup_section_portfolio',
		'default'  =>'',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_portfolio_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for Service section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_portfolio_subtitle',
		'label'    => __( 'Portfolio Sub Title', 'techup' ),
		'section'  => 'techup_section_portfolio',
		'default'  => '',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_portfolio_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

for($k=1;$k<=6;$k++){
	Kirki::add_field(
	'techup_config', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'techup_portfolio_page'.$k,
		'label'       =>  'Select Portfolio Page'.$k,
		'section'     => 'techup_section_portfolio',
		'default'     => 0,
		'priority'    => 11,
		
	)
);
}

// Toggle field for Enable/Disable Team Section
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_team_section',
		'label'    => __( 'Enable Home Team Area', 'techup' ),
		'section'  => 'techup_section_team',
		'default'  => '0',
		'priority' => 5,
	)
);


// Text field for Team section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_team_title',
		'label'    => __( 'Team Title', 'techup' ),
		'section'  => 'techup_section_team',
		'default'  => '',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_team_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for Team section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_team_subtitle',
		'label'    => __( 'Team Sub Title', 'techup' ),
		'section'  => 'techup_section_team',
		'default'  => '',	
		'priority' => 6,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_team_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

for($k=1;$k<=6;$k++){
	Kirki::add_field(
	'techup_config', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'techup_team_page'.$k,
		'label'       => 'Select Team Page'.$k,
		'section'     => 'techup_section_team',
		'default'     => 0,
		'priority'    => 11,
		
	)
);
}

Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_blog_section',
		'label'    => __( 'Enable Home Blog Area', 'techup' ),
		'section'  => 'techup_section_blog',
		'default'  => '1',
		'priority' => 5,
	)
);


Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_blog_section',
		'label'    => __( 'Enable Home Blog Area', 'techup' ),
		'section'  => 'techup_section_blog',
		'default'  => '1',
		'priority' => 5,
	)
);

// Text field for blog section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_blog_title',
		'label'    => __( 'Top Title', 'techup' ),
		'section'  => 'techup_section_blog',
		'default'  => '',	
		'priority' => 10,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_blog_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_blog_subtitle',
		'label'    => __( 'Sub Title', 'techup' ),
		'section'  => 'techup_section_blog',
		'default'  => '',	
		'priority' => 10,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_blog_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Select field for blog section categories.
Kirki::add_field(
	'techup_config', array(
		'type'        => 'select',
		'settings'    => 'techup_blog_cat',
		'label'       => esc_attr__( 'Select Category', 'techup' ),
		'section'     => 'techup_section_blog',
		'default'     => 'Uncategorized',
		'priority'    => 15,
		'choices'     => techup_select_categories_list(),
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_blog_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for Blog button label
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_rm_button_label',
		'label'    => __( 'Read More Text', 'techup' ),
		'default'  => '',
		'section'  => 'techup_section_blog',
		'priority' => 25,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_blog_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Toggle field for Enable/Disable callout content second
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_callout_section',
		'label'    => __( 'Enable Home Page Callout 2', 'techup' ),
		'section'  => 'techup_section_callout_content',
		'default'  => '0',
		'priority' => 5,
	)
);

Kirki::add_field(
	'techup_config', array(
		'type'        => 'image',
		'settings'    => 'techup_co2_image',
		'label'       => esc_attr__( 'Callout Background Image', 'techup' ),
		'section'     => 'techup_section_callout_content',
		'default'     => esc_url(  get_template_directory_uri() . '/assets/images/banner.jpg' ),
		'priority' 	  => 10,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for callout title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_callout_title',
		'label'    => __( 'Callout Title', 'techup' ),
		'section'  => 'techup_section_callout_content',
        'default'  => '',
		'priority' => 15,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Textarea field for callout content
Kirki::add_field(
	'techup_config', array(
		'type'     => 'textarea',
		'settings' => 'techup_callout_content',
		'label'    => __( 'Callout Text', 'techup' ),
		'section'  => 'techup_section_callout_content',
        'default'  => '',
		'priority' => 20,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for callout content button label
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_callout_button_label1',
		'label'    => __( 'Callout Button Text', 'techup' ),
		'default'  => '',
		'section'  => 'techup_section_callout_content',
		'priority' => 25,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Link field for callout content button link
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_callout_button_link1',
		'label'    => __( 'Callout Button URL', 'techup' ),
		'default'  => '',
		'section'  => 'techup_section_callout_content',
		'priority' => 30,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Toggle field for Enable/Disable Testimonial  Section
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_testimonial_section',
		'label'    => __( 'Enable Home Testimonial ', 'techup' ),
		'section'  => 'techup_section_testimonial',
		'default'  => '0',
		'priority' => 5,
	)
);

// Text field for Testimonial  section title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_testimonial_title',
		'label'    => __( 'Testimonial  Title', 'techup' ),
		'section'  => 'techup_section_testimonial',
		'default'  =>'',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_testimonial_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Text field for Tesimonial section Subtitle
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_testimonial_subtitle',
		'label'    => __( 'Testimonial Sub Title', 'techup' ),
		'section'  => 'techup_section_testimonial',
		'default'  => '',	
		'priority' => 5,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_testimonial_section',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

for($k=1;$k<=6;$k++){
	Kirki::add_field(
	'techup_config', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'techup_testimonial_page'.$k,
		'label'       =>  'Select Testimonial Page'.$k,
		'section'     => 'techup_section_testimonial',
		'default'     => 0,
		'priority'    => 11,
		
	)
);
}

// Toggle field for Enable/Disable callout content First
Kirki::add_field(
	'techup_config', array(
		'type'     => 'toggle',
		'settings' => 'techup_enable_callout_section1',
		'label'    => __( 'Enable Home Page Callout 1', 'techup' ),
		'section'  => 'techup_section_callout_content1',
		'default'  => '0',
		'priority' => 5,
	)
);
// Text field for callout title
Kirki::add_field(
	'techup_config', array(
		'type'     => 'text',
		'settings' => 'techup_callout_title1',
		'label'    => __( 'Callout Title', 'techup' ),
		'section'  => 'techup_section_callout_content1',
        'default'  => '',
		'priority' => 15,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section1',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

// Textarea field for callout content
Kirki::add_field(
	'techup_config', array(
		'type'     => 'textarea',
		'settings' => 'techup_callout_content1',
		'label'    => __( 'Callout Text', 'techup' ),
		'section'  => 'techup_section_callout_content1',
        'default'  => '',
		'priority' => 20,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section1',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);

Kirki::add_field(
	'techup_config', array(
		'type'        => 'image',
		'settings'    => 'techup_co1_image',
		'label'       => esc_attr__( 'Callout Background Image', 'techup' ),
		'section'     => 'techup_section_callout_content1',
		'default'     => esc_url(  get_template_directory_uri() . '/assets/images/banner.jpg' ),
		'priority' 	  => 10,
		'active_callback' => array(
			array(
				'setting'  => 'techup_enable_callout_section1',
				'value'    => true,
				'operator' => 'in',
			),
		)
	)
);