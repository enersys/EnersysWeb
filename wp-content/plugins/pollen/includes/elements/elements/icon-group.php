<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Icon Group
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_pollen_icon_group extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'direction' => 'row',
			'justify_content' => 'flex-start',
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
		
		
		
		
		
		$output .= '<div '.$el_id.' class="pollen-icon-group '.$css_class.'" style="justify-content:'.$justify_content.'; flex-direction:'.$direction.'">';
		$output .= wpb_js_remove_wpautop($content);
		$output .= '</div>';
		
		return $output;
	}
}


vc_map( array(
	'name' => __( 'Icon Group', 'pollen' ),
	'base' => 'pollen_icon_group',
	'icon' => plugins_url('../images/icon-group.png', __FILE__),
	"as_parent" => array('only' => 'pollen_icon'),
	"content_element" => true,
	"show_settings_on_create" => false,
	"is_container" => true,
	'category' => __( 'Pollen', 'pollen' ),
	'description' => __( 'Add and manage multiple icons', 'pollen' ),
	'params' => array(
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Direction', 'pollen' ),
			'param_name' => 'direction',
			'value' => array(
				__( 'Row', 'pollen' ) => 'row',
				__( 'Row Reverse', 'pollen' ) => 'row-reverse',
				__( 'Column', 'pollen' ) => 'column',
				__( 'Column Reverse', 'pollen' ) => 'column-reverse',
			),
			'description' => __( 'Select the direction icons list.', 'pollen' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Justify Content', 'pollen' ),
			'param_name' => 'justify_content',
			'value' => array(
				__( 'Left', 'pollen' ) => 'flex-start',
				__( 'Right', 'pollen' ) => 'flex-end',
				__( 'Center', 'pollen' ) => 'center',
				__( 'Space Around', 'pollen' ) => 'space-around',
				__( 'Space Between', 'pollen' ) => 'space-between',
			),
			'description' => __( 'Select icons alignment.', 'pollen' ),
		),
		
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
	"js_view" => 'VcColumnView'
	) );