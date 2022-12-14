<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Semi Circular Progress Bar
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_semi_circular_progress_bar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'percentage' => '',
			'bar_thickness' => '16',
			'track_thickness' => '16',
			'corner' => 'butt',
			'colors' => '',
			'title_color' => '',
			'ip_color' => '',
			'bar_color' => '',
			'track_color' => '',
			'style' => 'percentage',
			'icon' => '',
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
		
		// Start Get Colors for Pollen Settings
		$options = get_option('pollen');
		if ( $options['pollen_color_switch'] == '1' ) {
			$pollen_global_color_value = $options['pollen_global_color'];
		} else {
			$pollen_global_color_value = $options['pollen_background_color'];
		}
		// End Get Colors for Pollen Settings

		// Start Custom Colors		
		$title_color = $title_color ? 'style=color:'.$title_color.'' : 'style=color:'.$pollen_global_color_value.'';
		
		$percentage_color = $ip_color;
		$ip_color = $ip_color ? 'style=color:'.$ip_color.'' : 'style=color:'.$pollen_global_color_value.'';
		
		$bar_color = $bar_color ? $bar_color : $pollen_global_color_value;

		$track_color = $track_color ? $track_color : '#f9f9f9';
		
		if ($style=="icon") { $icon = '<i '.$ip_color.' class="pollen-semi-circular-progress-bar-icon '.$icon.'""></i>'; } else { $icon = ""; }
		// End Custom Colors
		
		// Start Output
		
		$output .= '<div '.$el_id.' class="pollen-semi-circular-progress-bar '.$css_class.'">';
		$output .= '<div class="pollen-semi-circular-progress-bar-inner">';
		$output .= '<div class="pollen-semi-circular-progress-bar-params '.$corner.' '.$style.'" '.$height.' percentage="'.$percentage.'" bar_color="'.$bar_color.'" track_color="'.$track_color.'" percentage_color="'.$percentage_color.'" bar_thickness="'.$bar_thickness.'" track_thickness="'.$track_thickness.'"></div>';
		$output .= $icon;
		$output .= '<span '.$title_color.' class="pollen-semi-circular-progress-bar-title">'.$title.'</span>';
		$output .= '</div></div>';
		
		return $output;
		
		// End Output
	}
}

return array(
	'name' => __( 'Semi Circular Progress Bar', 'pollen' ),
	'base' => 'pollen_semi_circular_progress_bar',
	'icon' => plugins_url('../images/semi-circular-progress-bar.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Animated progress bar', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'pollen' ),
			'param_name' => 'title',
			'description' => __( 'Enter the Progress Bar title here.', 'pollen' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'pollen' ),
			'param_name' => 'style',
			'value' => array(
				__( 'Percentage', 'pollen' ) => 'percentage',
				__( 'Icon', 'pollen' ) => 'icon',
			),
			'description' => __( 'Choose a style.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Progress in %', 'pollen' ),
			'param_name' => 'percentage',
			'description' => __( 'Enter a number between 0 and 100', 'pollen' ),
		),
		
		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'pollen' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'pollen' ),
			'dependency' => array(
				'element' => 'style',
				'value' => 'icon'
			),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Bar Thickness', 'pollen' ),
			'param_name' => 'bar_thickness',
			'description' => __( 'Enter a value for height. Ex: 16px.', 'pollen' ),
		),

		array(
			'type' => 'textfield',
			'heading' => __( 'Track Thickness', 'pollen' ),
			'param_name' => 'track_thickness',
			'description' => __( 'Enter a value for height. Ex: 16px.', 'pollen' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Corner Style', 'pollen' ),
			'description' => __( 'Select style.', 'pollen' ),
			'param_name' => 'corner',
			'value' => array(
				__( 'Square', 'pollen' ) => 'butt',
				__( 'Round', 'pollen' ) => 'round',
			),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Colors', 'pollen' ),
			'param_name' => 'colors',
			'value' => array(
				__( 'Preset Color', 'pollen' ) => '',
				__( 'Custom Color', 'pollen' ) => 'custom',
			),
			'description' => __( 'Choose a color for your progress bar here.', 'pollen' ),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'pollen' ),
			'param_name' => 'title_color',
			'description' => __( 'Select custom color for the title.', 'pollen' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Percentage and Icon Color', 'pollen' ),
			'param_name' => 'ip_color',
			'description' => __( 'Select custom color for the percentage or icon.', 'pollen' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Bar Color', 'pollen' ),
			'param_name' => 'bar_color',
			'description' => __( 'Select custom color for the bar.', 'pollen' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),
		
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Track Color', 'pollen' ),
			'param_name' => 'track_color',
			'description' => __( 'Select custom color for the track.', 'pollen' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
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
