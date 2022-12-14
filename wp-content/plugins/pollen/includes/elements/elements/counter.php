<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Counter
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_counter extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'value' => '999',
			'value_speed' => '2000',
			'value_interval' => '1',
			'checkicon' => '',
			'icon' => '',
			'title_tag' => 'h3',
			'title_size' => '1.3rem',
			'title_line_height' => '1em',
			'title_color' => '',
			'counter_size' => '4rem',
			'counter_line_height' => '1em',
			'counter_color' => '#818b92',
			'icon_size' => '4rem',
			'icon_line_height' => '2em',
			'icon_color' => '',
			//Static
			'el_id' => '',
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
		), $atts ) );
		$output = '';
		$pollen_global_color = 'pollen-global-color'; //General Color
		$pollen_global_border_color = 'pollen-global-border-color'; //Border Color
		$pollen_global_background_color = 'pollen-global-background-color'; //Background Color
		
		
		// Start Default Extra Class, CSS and CSS animation
		
		$css = isset( $atts['css'] ) ? $atts['css'] : '';
		$el_id = isset( $atts['el_id'] ) ? 'id="' . esc_attr( $el_id ) . '"' : '';
		$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';
		
		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$css_animation_style = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}
		
		$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
		
		// End Default Extra Class, CSS and CSS animation
		
		
		
		$title_color_default = '';
		if($title_color == '') {
			$title_color_default = $pollen_global_color;
		} 
		
		$icon_color_default = '';
		if($icon_color == '') {
			$icon_color_default = $pollen_global_color;
		} 		  
		
		
		$output .= '<div '.$el_id.' class="pollen-counter text-center '.$css_class.'">';
		
		if($checkicon == 'icon') {
			$output .= '<div class="pollen-counter-icon"><i style="font-size:'.$icon_size.'; line-height:'.$icon_line_height.'; color:'.$icon_color.';" class="'.$icon.' '.$icon_color_default.'"></i></div>';
		} 
		
		$output .= '<div class="pollen-counter-paramns" style="font-size:'.$counter_size.'; line-height:'.$counter_line_height.'; color:'.$counter_color.';" value="'.$value.'" value-speed="'.$value_speed.'" value-interval="'.$value_interval.'"></div>';
		
		if($title != ''){ 
			$output .= '<'.$title_tag.' style="font-size:'.$title_size.'; line-height:'.$title_line_height.'; color:'.$title_color.';" class="pollen-counter-title '.$title_color_default.'">'.$title.'</'.$title_tag.'>'; 
		}
		$output .= '</div>';
		
		return $output;
	}
}

return array(
	'name' => __( 'Counter', 'pollen' ),
	'base' => 'pollen_counter',
	'icon' => plugins_url('../images/counter.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Your milestones and achievements', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'pollen' ),
			'param_name' => 'title',
			'description' => __( 'Enter the title here.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Counter Value', 'pollen' ),
			'param_name' => 'value',
			'description' => __( 'Enter number for counter without any special character.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Counter Value Speed', 'pollen' ),
			'param_name' => 'value_speed',
			'description' => __( 'Enter number for counter without any special character.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Counter Value Interval', 'pollen' ),
			'param_name' => 'value_interval',
			'description' => __( 'Enter number for counter without any special character.', 'pollen' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'pollen' ),
			'param_name' => 'checkicon',
			'value' => array(
				__( 'No', 'pollen' ) => '',
				__( 'Yes', 'pollen' ) => 'icon',
			),
			'description' => __( 'Enable Icon Library.', 'pollen' ),
		),
		
		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'pollen' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'pollen' ),
			'dependency' => array(
				'element' => 'checkicon',
				'value' => array( 'icon' ),
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Tag', 'pollen' ),
			'param_name' => 'title_tag',
			'group' => 'Typography',
			'value' => array(
				__( 'H1', 'pollen' ) => 'h1',
				__( 'H2', 'pollen' ) => 'h2',
				__( 'H3', 'pollen' ) => 'h3',
				__( 'H4', 'pollen' ) => 'h4',
				__( 'H5', 'pollen' ) => 'h5',
				__( 'H6', 'pollen' ) => 'h6',
				__( 'p', 'pollen' ) => 'p',
				__( 'div', 'pollen' ) => 'div',
			),
			'description' => __( 'Select title tag.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title Font Size', 'pollen' ),
			'param_name' => 'title_size',
			'description' => __( 'Enter font size.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title Line Height', 'pollen' ),
			'param_name' => 'title_line_height',
			'description' => __( 'Enter line height.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'pollen' ),
			'param_name' => 'title_color',
			'description' => __( 'Select custom color for the title.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Counter Size', 'pollen' ),
			'param_name' => 'counter_size',
			'description' => __( 'Enter font size.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Counter Line Height', 'pollen' ),
			'param_name' => 'counter_line_height',
			'description' => __( 'Enter line height.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Counter Color', 'pollen' ),
			'param_name' => 'counter_color',
			'description' => __( 'Select custom color for the number.', 'pollen' ),
			'group' => 'Typography',
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Icon Size', 'pollen' ),
			'param_name' => 'icon_size',
			'description' => __( 'Enter font size.', 'pollen' ),
			'group' => 'Typography',
			'dependency' => array(
				'element' => 'checkicon',
				'value' => array( 'icon' ),
			),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Icon Line Height', 'pollen' ),
			'param_name' => 'icon_line_height',
			'description' => __( 'Enter line height.', 'pollen' ),
			'group' => 'Typography',
			'dependency' => array(
				'element' => 'checkicon',
				'value' => array( 'icon' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Icon Color', 'pollen' ),
			'param_name' => 'icon_color',
			'description' => __( 'Select custom color for the icon.', 'pollen' ),
			'group' => 'Typography',
			'dependency' => array(
				'element' => 'checkicon',
				'value' => array( 'icon' ),
			),
		),
		
		// Animation
		vc_map_add_css_animation(),

		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'pollen' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'pollen' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'pollen' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pollen' ),
		),
		
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'pollen' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'pollen' ),
		),
	),
);
