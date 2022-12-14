<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_progress_bar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'percentage' => '',
			'height' => '16px',
			'corner' => 'progress-bar-rounded',
			'colors' => '',
			'title_color' => '',
			'icon_color' => '',
			'percentage_color' => '',
			'bar_color' => '',
			'track_color' => '',
			'checkicon' => '',
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
		
		$icon_color = $icon_color ? 'style=color:'.$icon_color.'' : 'style=color:'.$pollen_global_color_value.'';
		
		$bar_color = $bar_color ? $bar_color : $pollen_global_color_value;

		$track_color = $track_color ? $track_color : '#f9f9f9';
		
		$thickness = $thickness ? 'style="stroke-width:'.$thickness.';"' : '';
		
		// End Custom Colors
		
		$height = $height ? 'style="height:'.$height.';"' : '';
		
		if ($checkicon=="custom_icon") { $icon = '<i class="pollen-progress-bar-icon '.$icon.'" '.$icon_color.'></i>'; } else { $icon = ""; }
		
		// Start Output
		
		$output .= '<div '.$el_id.' class="pollen-progress-bar '.$css_class.'">';
		$output .= $icon;
		$output .= '<div class="pollen-progress-bar-inner">';
		$output .= '<span '.$title_color.' class="progress-bar-title">'.$title.'</span>';
		$output .= '<div class="pollen-progress-bar-params '.$corner.'" '.$height.' percentage="'.$percentage.'" bar_color="'.$bar_color.'" track_color="'.$track_color.'" percentage_color="'.$percentage_color.'"></div>';
		$output .= '</div></div>';
		
		return $output;
		
		// End Output
	}
}

return array(
	'name' => __( 'Progress Bar', 'pollen' ),
	'base' => 'pollen_progress_bar',
	'icon' => plugins_url('../images/progress-bar.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Animated progress bar', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'pollen' ),
			'param_name' => 'title',
			'description' => __( 'Enter the Progress Bar Field title here.', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Progress in %', 'pollen' ),
			'param_name' => 'percentage',
			'description' => __( 'Enter a number between 0 and 100', 'pollen' ),
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Height', 'pollen' ),
			'param_name' => 'height',
			'description' => __( 'Enter a value for height. Ex: 16px.', 'pollen' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Corner Style', 'pollen' ),
			'description' => __( 'Select style.', 'pollen' ),
			'param_name' => 'corner',
			'value' => array(
				__( 'Rounded', 'pollen' ) => 'progress-bar-rounded',
				__( 'Square', 'pollen' ) => 'progress-bar-square',
				__( 'Round', 'pollen' ) => 'progress-bar-round',
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
			'heading' => __( 'Icon Color', 'pollen' ),
			'param_name' => 'icon_color',
			'description' => __( 'Select custom color for icon.', 'pollen' ),
			'dependency' => array(
				'element' => 'colors',
				'value' => array( 'custom' ),
			),
		),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Percentage Color', 'pollen' ),
			'param_name' => 'percentage_color',
			'description' => __( 'Select custom color for the percentage.', 'pollen' ),
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
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'pollen' ),
			'param_name' => 'checkicon',
			'value' => array(
				__( 'No', 'pollen' ) => 'no_icon',
				__( 'Yes', 'pollen' ) => 'custom_icon',
			),
			'description' => __( 'Should an icon be displayed at the left side of the progress bar.', 'pollen' ),
		),
		
		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'pollen' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'pollen' ),
			'dependency' => array(
				'element' => 'checkicon',
				'value' => 'custom_icon'
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
